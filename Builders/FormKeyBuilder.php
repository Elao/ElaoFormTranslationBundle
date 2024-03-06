<?php

/*
 * This file is part of the ElaoFormTranslation bundle.
 *
 * Copyright (C) Elao
 *
 * @author Elao <contact@elao.com>
 */

namespace Elao\Bundle\FormTranslationBundle\Builders;

use Elao\Bundle\FormTranslationBundle\Model\FormTree;

/**
 * Responsible form building tree for forms.
 *
 * @author Thomas Jarrand <thomas.jarrand@gmail.com>
 */
class FormKeyBuilder
{
    /**
     * Separator te be used between nodes
     */
    protected string $separator;

    /**
     * Prefix at the root of the key
     */
    protected string $root;

    /**
     * Prefix for children nodes
     */
    protected string $children;

    /**
     * Prefix for prototype nodes
     */
    protected string $prototype;

    /**
     * Constructor
     *
     * @param string $separator Separator te be used between nodes
     * @param string $root      Prefix at the root of the key
     * @param string $children  Prefix for children nodes
     * @param string $prototype Prefix for prototype nodes
     */
    public function __construct(
        string $separator = '.',
        string $root = 'form',
        string $children = 'children',
        string $prototype = 'prototype'
    ) {
        $this->separator = $separator;
        $this->root = $root;
        $this->children = $children;
        $this->prototype = $prototype;
    }

    /**
     * Build the key corresponding to a given tree
     *
     * @param FormTree $tree   The tree
     * @param string   $parent Suffix for nodes that have children
     *
     * @return string The key
     */
    public function buildKeyFromTree(FormTree $tree, $parent): string
    {
        $key = [];

        if ($this->root) {
            $key[] = $this->root;
        }

        $last = \count($tree) - 1;

        foreach ($tree as $index => $node) {
            if (!$node->isPrototype()) {
                $key[] = $node->getName();
            }

            $children = false;

            if ($node->hasChildren()) {
                $children = $node->isCollection() ? $this->prototype : $this->children;
            }

            $value = $last === $index ? $parent : $children;

            if ($value) {
                $key[] = $value;
            }
        }

        return implode($this->separator, $key);
    }
}
