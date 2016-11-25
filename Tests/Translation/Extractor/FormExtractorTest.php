<?php

namespace Elao\Bundle\FormTranslationBundle\Tests\Translation\Extractor;

use Elao\Bundle\FormTranslationBundle\Builders\FormKeyBuilder;
use Elao\Bundle\FormTranslationBundle\Builders\FormTreeBuilder;
use Elao\Bundle\FormTranslationBundle\DependencyInjection\Configuration;
use Elao\Bundle\FormTranslationBundle\Form\Extension;
use Elao\Bundle\FormTranslationBundle\Test\FormTranslationTestCase;
use Elao\Bundle\FormTranslationBundle\Tests\Fixtures\Form\Type\AdvancedType;
use Elao\Bundle\FormTranslationBundle\Tests\Fixtures\Form\Type\SimpleType;
use Elao\Bundle\FormTranslationBundle\Translation\Extractor\FormExtractor;
use JMS\TranslationBundle\Model\MessageCatalogue;
use PhpParser\Lexer\Emulative;
use PhpParser\Parser;
use Psr\Log\NullLogger;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\Container;

class FormExtractorTest extends FormTranslationTestCase
{
    /**
     * Get Form Type Extensions
     *
     * @return array
     */
    protected function getTypeExtensions()
    {
        $processor = new Processor();
        $configuration = new Configuration();
        $config = $processor->processConfiguration($configuration, []);

        $ext = [];

        /** @var Extension\TreeAwareExtension $type */
        foreach (parent::getTypeExtensions() as $type) {
            $type->setAutoGenerate(true);
            $type->setKeybuilder(new FormKeyBuilder());
            $type->setTreebuilder(new FormTreeBuilder());
            $type->setKeys($config['keys']['form']);

            $ext[] = $type;
        }

        return $ext;
    }

    public function testSimpleFormExtract()
    {
        $extractor = new FormExtractor($this->factory, new NullLogger());

        $file = new \SplFileInfo((new \ReflectionClass(SimpleType::class))->getFileName());
        $catalogue = new MessageCatalogue();
        $parser = $parser = new Parser(new Emulative);

        $extractor->visitPhpFile(
            $file,
            $catalogue,
            $parser->parse(file_get_contents($file->getPathname()))
        );

        $this->assertEquals('form.simple.children.name.label', $catalogue->get('form.simple.children.name.label'));
        $this->assertEquals('form.simple.children.phone.label', $catalogue->get('form.simple.children.phone.label'));
    }

    public function testAdvancedFormExtract()
    {
        $extractor = new FormExtractor($this->factory, new NullLogger());
        $extractor->setContainer(new Container());

        $file = new \SplFileInfo((new \ReflectionClass(AdvancedType::class))->getFileName());
        $catalogue = new MessageCatalogue();
        $parser = $parser = new Parser(new Emulative);

        $extractor->visitPhpFile(
            $file,
            $catalogue,
            $parser->parse(file_get_contents($file->getPathname()))
        );

        $this->assertEquals('form.advanced.children.name.label', $catalogue->get('form.advanced.children.name.label'));
        $this->assertEquals('form.advanced.children.phone.label', $catalogue->get('form.advanced.children.phone.label'));
    }
}
