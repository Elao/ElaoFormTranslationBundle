<?php

/**
 * This file is part of the ElaoFormTranslation bundle.
 *
 * Copyright (C) 2014 Elao
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
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('elao_form_translation');

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
                                array(
                                    'label' => "label",
                                    'help'  => "help",
                                )
                            )
                        )
                        ->append(
                            $this->addKeysConfig(
                                'collection',
                                array(
                                    'label_add'    => "label_add",
                                    'label_delete' => "label_delete",
                                )
                            )
                        )
                        ->append(
                            $this->addKeysConfig(
                                'choice',
                                array(
                                    'empty_value' => "empty_value",
                                )
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
                            ->info('Prefix for children nodes (string|false)')
                        ->end()
                        ->scalarNode('prototype')
                            ->defaultValue('prototype')
                            ->info('Prefix for prototype nodes (string|false)')
                        ->end()
                        ->scalarNode('root')
                            ->defaultValue('form')
                            ->info('Prefix at the root of the key (string|false)')
                        ->end()
                        ->scalarNode('separator')
                            ->defaultValue('.')
                            ->info('Separator te be used between nodes (string|false)')
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }

    /**
     * Add Keys Config
     *
     * @param string $key
     * @param array $default
     *
     * @return ArrayNodeDefinition|NodeDefinition
     */
    public function addKeysConfig($key, $default = array())
    {
        $builder = new TreeBuilder();
        $node    = $builder->root($key);

        $node
            ->prototype('scalar')
                ->isRequired()
            ->end()
	    ->normalizeKeys(false)
            ->defaultValue($default);

        return $node;
    }
}
