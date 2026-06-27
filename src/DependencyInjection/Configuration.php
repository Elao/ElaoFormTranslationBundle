<?php

/*
 * This file is part of the ElaoFormTranslation bundle.
 *
 * Copyright (C) Elao
 *
 * @author Elao <contact@elao.com>
 */

namespace Elao\Bundle\FormTranslationBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * ElaoFormTranslation bundle configuration
 *
 * @author Thomas Jarrand <thomas.jarrand@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('elao_form_translation');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->info('<info>Activate the Form Tree component (used to generate label translation keys)</info>')
            ->canBeDisabled()
            ->children()
                ->booleanNode('auto_generate')
                    ->info('<info>Generate translation keys for all missing keys</info>')
                    ->defaultFalse()
                ->end()
                ->arrayNode('keys')
                    ->info('<info>Customize available keys</info>')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->append(
                            $this->addKeysConfig(
                                'form',
                                [
                                    '[label]' => 'label',
                                    '[help]' => 'help',
                                    '[attr][placeholder]' => 'placeholder',
                                ]
                            )
                        )
                        ->append(
                            $this->addKeysConfig(
                                'collection',
                                [
                                    '[label_add]' => 'label_add',
                                    '[label_delete]' => 'label_delete',
                                ]
                            )
                        )
                        ->append(
                            $this->addKeysConfig(
                                'choice',
                                [
                                    '[placeholder]' => 'placeholder',
                                    '[empty_value]' => 'empty_value',
                                ]
                            )
                        )
                    ->end()
                ->end()
                ->arrayNode('blocks')
                    ->info('<info>Customize the ways keys are built</info>')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('children')
                            ->defaultValue('children')
                            ->treatNullLike(false)
                            ->info('Prefix for children nodes (string|false)')
                        ->end()
                        ->scalarNode('prototype')
                            ->defaultValue('prototype')
                            ->treatNullLike(false)
                            ->info('Prefix for prototype nodes (string|false)')
                        ->end()
                        ->scalarNode('root')
                            ->defaultValue('form')
                            ->treatNullLike(false)
                            ->info('Prefix at the root of the key (string|false)')
                        ->end()
                        ->scalarNode('separator')
                            ->defaultValue('.')
                            ->treatNullLike(false)
                            ->info('Separator te be used between nodes (string|false)')
                        ->end()
                    ->end()
                ->end()
                ->scalarNode('default_translation_domain')
                    ->info('<info>Default translation domain for all forms</info>')
                    ->defaultNull()
                ->end()
            ->end();

        return $treeBuilder;
    }

    /**
     * Add Keys Config
     *
     * @param array<string,string> $default
     *
     * @return ArrayNodeDefinition|NodeDefinition
     */
    public function addKeysConfig(string $key, array $default = [])
    {
        $treeBuilder = new TreeBuilder($key);
        $node = $treeBuilder->getRootNode();

        $node
            ->prototype('scalar')
                ->isRequired()
            ->end()
            ->defaultValue($default);

        return $node;
    }
}
