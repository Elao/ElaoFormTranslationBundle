<?php

namespace Elao\Bundle\FormTranslationBundle\Tests\Fixtures\Form\Type;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdvancedType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('phone')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setRequired('dt')
            ->setAllowedTypes('dt', \DateTime::class)
        ;
    }

    /**
     * @param ContainerInterface $container
     *
     * @return array
     */
    public static function extractorOptions(ContainerInterface $container)
    {
        return [
            'dt' => new \DateTime(),
        ];
    }
}
