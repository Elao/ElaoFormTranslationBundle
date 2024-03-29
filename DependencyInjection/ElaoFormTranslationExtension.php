<?php

/*
 * This file is part of the ElaoFormTranslation bundle.
 *
 * Copyright (C) Elao
 *
 * @author Elao <contact@elao.com>
 */

namespace Elao\Bundle\FormTranslationBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * ElaoFormTranslation extension
 *
 * @author Thomas Jarrand <thomas.jarrand@gmail.com>
 */
class ElaoFormTranslationExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        if ($config['enabled']) {
            $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

            $loader->load('services.xml');
            $loader->load('forms.xml');

            $this->loadTreeConfig($container, $loader, $config);
        }
    }

    /**
     * Load Tree configuration
     *
     * @param ContainerBuilder    $container The container builder
     * @param LoaderInterface     $loader    The loader
     * @param array<string,mixed> $config    An array of config keys
     */
    private function loadTreeConfig(ContainerBuilder $container, LoaderInterface $loader, array $config): void
    {
        // Set up the Key Builder
        $container
            ->getDefinition('elao.form_translation.key_builder')
            ->addArgument($config['blocks']['separator'])
            ->addArgument($config['blocks']['root'])
            ->addArgument($config['blocks']['children'])
            ->addArgument($config['blocks']['prototype']);

        // Set up the Tree Aware extension
        $container
            ->getDefinition('elao.form_translation.extension.tree_aware_extension')
            ->addMethodCall('setAutoGenerate', [$config['auto_generate']])
            ->addMethodCall('setDefaultTranslationDomain', [$config['default_translation_domain']])
            ->addMethodCall('setTreebuilder', [new Reference('elao.form_translation.tree_builder')])
            ->addMethodCall('setKeybuilder', [new Reference('elao.form_translation.key_builder')]);

        // Set up the Form extensions
        $container
            ->getDefinition('elao.form_translation.extension.form_type_extension')
            ->addMethodCall('setKeys', [$config['keys']['form']]);

        $container
            ->getDefinition('elao.form_translation.extension.button_type_extension')
            ->addMethodCall('setKeys', [$config['keys']['form']]);

        $container
            ->getDefinition('elao.form_translation.extension.collection_type_extension')
            ->addMethodCall('setKeys', [array_merge($config['keys']['form'], $config['keys']['collection'])]);

        $container
            ->getDefinition('elao.form_translation.extension.choice_type_extension')
            ->addMethodCall('setKeys', [array_merge($config['keys']['form'], $config['keys']['choice'])]);
    }
}
