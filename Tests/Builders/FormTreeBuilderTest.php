<?php

namespace Elao\Bundle\FormTranslationBundle\Tests\Builders;

use Elao\Bundle\FormTranslationBundle\Builders\FormTreeBuilder;
use Elao\Bundle\FormTranslationBundle\Test\FormTranslationTestCase;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class FormTreeBuilderTest extends FormTranslationTestCase
{
    /**
     * Test that the trees are properly built
     */
    public function testSimpleTreeBuilder()
    {
        $treeBuilder = new FormTreeBuilder();
        $form        = $this->factory->createNamed('foo', FormType::class);

        $form->add('bar', TextType::class);

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
        $form        = $this->factory->createNamed('foo', FormType::class);

        $form->add(
            'bar',
            CollectionType::class,
            array(
                'entry_type'   => TextType::class,
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
