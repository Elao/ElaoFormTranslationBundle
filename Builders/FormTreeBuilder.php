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
use Elao\Bundle\FormTranslationBundle\Model\FormTreeNode;
use Symfony\Component\Form\FormView;

/**
 * Responsible form building tree for forms.
 *
 * @author Thomas Jarrand <thomas.jarrand@gmail.com>
 */
class FormTreeBuilder
{
    /**
     * Form type with no children labels
     *
     * @var array<string>
     */
    private array $noChildren = ['date', 'time', 'datetime', 'choice'];

    /**
     * Get the full tree for a given view
     *
     * @param FormView $view The FormView
     */
    public function getTree(FormView $view): FormTree
    {
        if ($view->parent !== null) {
            $tree = $this->getTree($view->parent);
        } else {
            $tree = new FormTree();
        }

        $tree->addChild($this->createNodeFromView($view));

        return $tree;
    }

    /**
     * Set form type that should not be treated as having children
     *
     * @param array<string> $types An array of types
     */
    public function setNoChildren(array $types): void
    {
        $this->noChildren = $types;
    }

    /**
     * Create a FormTreeNode for the given view
     */
    private function createNodeFromView(FormView $view): FormTreeNode
    {
        $haschildren = $this->hasChildrenWithLabel($view);
        $isCollection = $haschildren ? $this->isCollection($view) : false;
        $isPrototype = $this->isPrototype($view);

        return new FormTreeNode($view->vars['name'], $haschildren, $isCollection, $isPrototype);
    }

    /**
     * Test if the given form view has children with labels
     *
     * @param FormView $view The FormView
     */
    private function hasChildrenWithLabel(FormView $view): bool
    {
        if (!isset($view->vars['compound']) || !$view->vars['compound']) {
            return false;
        }

        foreach ($view->vars['block_prefixes'] as $prefix) {
            if (\in_array($prefix, $this->noChildren)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Test if the given form view is a collection
     *
     * @param FormView $view The FormView
     */
    private function isCollection(FormView $view): bool
    {
        if ($view->parent === null || !$view->vars['compound']) {
            return false;
        }

        return \in_array('collection', $view->vars['block_prefixes']);
    }

    /**
     * Test if the given form view is a prototype in a collection
     *
     * @param FormView $view The FormView
     */
    private function isPrototype(FormView $view): bool
    {
        return $view->parent && $this->isCollection($view->parent);
    }
}
