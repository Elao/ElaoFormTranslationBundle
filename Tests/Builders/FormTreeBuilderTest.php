<?php

/*
 * This file is part of the ElaoFormTranslation bundle.
 *
 * Copyright (C) Elao
 *
 * @author Elao <contact@elao.com>
 */

namespace Elao\Bundle\FormTranslationBundle\Tests\Builders;

use Elao\Bundle\FormTranslationBundle\Builders\FormTreeBuilder;
use Elao\Bundle\FormTranslationBundle\Tests\FormTranslationTestCase;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class FormTreeBuilderTest extends FormTranslationTestCase
{
    /**
     * Test that the trees are properly built
     */
    public function testSimpleTreeBuilder(): void
    {
        $treeBuilder = new FormTreeBuilder();
        $form = $this->factory->createNamed('foo', FormType::class);

        $form->add('bar', TextType::class);

        $formView = $form->createView();
        $fooTree = $treeBuilder->getTree($formView);
        $barTree = $treeBuilder->getTree($formView['bar']);

        $this->assertEquals(1, \count($fooTree));
        $this->assertNotNull($fooTree[0]);
        $this->assertEquals('foo', $fooTree[0]->getName());
        $this->assertEquals(true, $fooTree[0]->hasChildren());

        $this->assertEquals(2, \count($barTree));
        $this->assertNotNull($barTree[0]);
        $this->assertEquals('foo', $barTree[0]->getName());
        $this->assertEquals(true, $barTree[0]->hasChildren());
        $this->assertNotNull($barTree[1]);
        $this->assertEquals('bar', $barTree[1]->getName());
        $this->assertEquals(false, $barTree[1]->hasChildren());
    }

    /**
     * Test that the collection trees are properly built
     */
    public function testCollectionTreeBuilder(): void
    {
        $treeBuilder = new FormTreeBuilder();
        $form = $this->factory->createNamed('foo', FormType::class);

        $form->add(
            'bar',
            CollectionType::class,
            [
                'entry_type' => TextType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ]
        );

        $formView = $form->createView();
        $tree = $treeBuilder->getTree($formView['bar']->vars['prototype']);

        $this->assertNotNull($tree[1]);
        $this->assertEquals(true, $tree[1]->hasChildren());
        $this->assertEquals(true, $tree[1]->isCollection());
        $this->assertEquals(false, $tree[1]->isPrototype());

        $this->assertEquals(3, \count($tree));
        $this->assertNotNull($tree[2]);
        $this->assertEquals(false, $tree[2]->hasChildren());
        $this->assertEquals(false, $tree[2]->isCollection());
        $this->assertEquals(true, $tree[2]->isPrototype());
    }
}
