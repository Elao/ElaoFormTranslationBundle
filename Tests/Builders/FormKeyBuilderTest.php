<?php

namespace Elao\Bundle\FormTranslationBundle\Tests\Builders;

use Elao\Bundle\FormTranslationBundle\Test\FormTranslationTestCase;
use Elao\Bundle\FormTranslationBundle\Builders\FormTreeBuilder;
use Elao\Bundle\FormTranslationBundle\Builders\FormKeyBuilder;

class FormKeyBuilderTest extends FormTranslationTestCase
{
    /**
     * Test that the trees are properly built
     */
    public function testSimpleTreeBuilder()
    {
        $treeBuilder = new FormTreeBuilder();
        $keyBuilder  = new FormKeyBuilder();

        $form = $this->factory->createNamed('foo', 'form');

        $form->add('bar', 'text');

        $view  = $form->createView();
        $tree  = $treeBuilder->getTree($view['bar']);
        $label = $keyBuilder->buildKeyFromTree($tree , 'label');

        $this->assertEquals('form.foo.children.bar.label', $label);
    }

    /**
     * Test that the collection trees are properly built
     */
    public function testCollectionTreeBuilder()
    {
        $treeBuilder = new FormTreeBuilder();
        $keyBuilder  = new FormKeyBuilder();

        $form = $this->factory->createNamed('foo', 'form');

        $form->add(
            'bar',
            'collection',
            array(
                'type'         => 'text',
                'allow_add'    => true,
                'allow_delete' => true,
            )
        );

        $view           = $form->createView();
        $barTree        = $treeBuilder->getTree($view['bar']);
        $prototypeTree  = $treeBuilder->getTree($view['bar']->vars['prototype']);
        $barLabel       = $keyBuilder->buildKeyFromTree($barTree, 'label');
        $prototypeLabel = $keyBuilder->buildKeyFromTree($prototypeTree, 'label');

        $this->assertEquals('form.foo.children.bar.label', $barLabel);
        $this->assertEquals('form.foo.children.bar.prototype.label', $prototypeLabel);
    }
}