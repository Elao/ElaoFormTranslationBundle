<?php

namespace Elao\Bundle\FormTranslationBundle\Tests\Builders;

use Elao\Bundle\FormTranslationBundle\Test\FormTranslationTestCase;
use Elao\Bundle\FormTranslationBundle\Builders\FormTreeBuilder;

class FormTreeBuilderTest extends FormTranslationTestCase
{
    /**
     * Test that the trees are properly built
     */
    public function testSimpleTreeBuilder()
    {
        $treeBuilder = new FormTreeBuilder();
        $form        = $this->factory->createNamed('foo', 'form');

        $form->add('bar', 'text');

        $formView = $form->createView();
        $fooTree  = $treeBuilder->getTree($formView);
        $barTree  = $treeBuilder->getTree($formView['bar']);

        $this->assertEquals(1, count($fooTree));
        $this->assertEquals('foo', $fooTree[0]->getName());
        $this->assertEquals(true, $fooTree[0]->hasChildren());

        $this->assertEquals(2, count($barTree));
        $this->assertEquals('foo', $barTree[0]->getName());
        $this->assertEquals('bar', $barTree[1]->getName());
        $this->assertEquals(true, $barTree[0]->hasChildren());
        $this->assertEquals(false, $barTree[1]->hasChildren());
    }

    /**
     * Test that the collection trees are properly built
     */
    public function testCollectionTreeBuilder()
    {
        $treeBuilder = new FormTreeBuilder();
        $form        = $this->factory->createNamed('foo', 'form');

        $form->add(
            'bar',
            'collection',
            array(
                'type'         => 'text',
                'allow_add'    => true,
                'allow_delete' => true,
            )
        );

        $formView = $form->createView();
        $tree     = $treeBuilder->getTree($formView['bar']->vars['prototype']);

        $this->assertEquals(true, $tree[1]->hasChildren());
        $this->assertEquals(true, $tree[1]->isCollection());
        $this->assertEquals(false, $tree[1]->isPrototype());

        $this->assertEquals(3, count($tree));
        $this->assertEquals(false, $tree[2]->hasChildren());
        $this->assertEquals(false, $tree[2]->isCollection());
        $this->assertEquals(true, $tree[2]->isPrototype());
    }
}