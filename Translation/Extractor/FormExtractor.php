<?php

namespace Elao\Bundle\FormTranslationBundle\Translation\Extractor;

use JMS\TranslationBundle\Model\FileSource;
use JMS\TranslationBundle\Model\Message;
use JMS\TranslationBundle\Model\MessageCatalogue;
use JMS\TranslationBundle\Model\SourceInterface;
use JMS\TranslationBundle\Translation\Extractor\FileVisitorInterface;
use PhpParser\Node;
use PhpParser\NodeTraverser;
use PhpParser\NodeTraverserInterface;
use PhpParser\NodeVisitor;
use PhpParser\NodeVisitor\NameResolver;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\Exception\ExceptionInterface;

class FormExtractor implements FileVisitorInterface, NodeVisitor, ContainerAwareInterface
{
    /**
     * @var \SplFileInfo
     */
    protected $file;

    /**
     * @var MessageCatalogue
     */
    protected $catalogue;

    /**
     * @var NodeTraverserInterface
     */
    protected $traverser;

    /**
     * @var FormFactoryInterface
     */
    protected $formFactory;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @param FormFactoryInterface $formFactory
     * @param LoggerInterface      $logger
     */
    public function __construct(FormFactoryInterface $formFactory, LoggerInterface $logger)
    {
        $this->traverser = new NodeTraverser();
        $this->traverser->addVisitor(new NameResolver());
        $this->traverser->addVisitor($this);

        $this->formFactory = $formFactory;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    function visitPhpFile(\SplFileInfo $file, MessageCatalogue $catalogue, array $ast)
    {
        $this->file = $file;
        $this->catalogue = $catalogue;
        $this->traverser->traverse($ast);
    }

    /**
     * {@inheritdoc}
     */
    public function enterNode(Node $node)
    {
        if ($node instanceof Node\Stmt\Class_) {
            $fqcn = (string) $node->namespacedName;

            require_once $this->file->getPathname();

            $refl = new \ReflectionClass($fqcn);

            if ($refl->implementsInterface(FormTypeInterface::class)) {
                // Drilling down with the node visitor is not the way to go here, extends, traits etc.

                if ($refl->hasMethod('extractorOptions')) {
                    $method = $refl->getMethod('extractorOptions');

                    if (!$method->isStatic()) {
                        throw new \LogicException(
                            sprintf(
                                'The "extractorOptions" method must be static in class "%s"',
                                $refl->getName()
                            )
                        );
                    }

                    $options = call_user_func([$refl->getName(), $method->getName()], $this->container);
                } else {
                    $options = [];
                }

                try {
                    $form = $this->formFactory->create($refl->getName(), null, $options);
                } catch (ExceptionInterface $e) {
                    $this->logError($refl, $e);
                    $this->logger->warning(
                        'You should add a static "extractorOptions" method to this type, and return the options.'
                    );

                    return;
                } catch (\Exception $e) {
                    $this->logError($refl, $e);

                    return;
                }

                $labels = $this->extractView($form->createView());
                $source = new FileSource((string) $this->file);

                foreach ($labels as $label) {
                    $this->addToCatalogue($label, $source);
                }
            }
        }
    }

    /**
     * @param \ReflectionClass $refl
     * @param \Exception       $e
     */
    protected function logError(\ReflectionClass $refl, \Exception $e)
    {
        $this->logger->warning(
            sprintf(
                'Could not extract messages from type "%s". Exception: "%s", message: "%s"',
                $refl->getName(),
                get_class($e),
                $e->getMessage()
            )
        );
    }

    /**
     * @param FormView $view
     *
     * @return array
     */
    protected function extractView(FormView $view)
    {
        $labels = [];

        foreach ($view as $field) {
            if (count($field)
                && (
                    !isset($field->vars['choice_translation_domain'])
                    || $field->vars['choice_translation_domain'] !== false
                )
            ) {
                $labels = array_merge($labels, $this->extractView($field));
            }

            $labels[] = $field->vars['label'];
        }

        return $labels;
    }

    /**
     * @param string          $id
     * @param SourceInterface $source
     * @param string          $domain
     */
    protected function addToCatalogue($id, SourceInterface $source, $domain = null)
    {
        if (null === $domain) {
            $message = new Message($id);
        } else {
            $message = new Message($id, $domain);
        }

        $message->addSource($source);

        $this->catalogue->add($message);
    }

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    function visitFile(\SplFileInfo $file, MessageCatalogue $catalogue)
    {
    }

    /**
     * {@inheritdoc}
     */
    function visitTwigFile(\SplFileInfo $file, MessageCatalogue $catalogue, \Twig_Node $ast)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function leaveNode(Node $node)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function beforeTraverse(array $nodes)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function afterTraverse(array $nodes)
    {
    }
}
