<?php

namespace Elao\Bundle\FormTranslationBundle\Tests;

use Elao\Bundle\FormTranslationBundle\Test\FormTranslationTestCase;
use Elao\Bundle\FormTranslationBundle\Builders\FormTreeBuilder;

class FormTreeBuilderTest extends FormTranslationTestCase
{
    /**
     * [testAdd description]
     *
     * @return [type]
     */
    public function testTreeBuilt()
    {
        $treeBuilder = new FormTreeBuilder();
        $formView    = $this->getSampleFormView();
        $tree        = $treeBuilder->getTree($formView);

        $this->assertEquals(42, $result);
    }

    /**
     * Get sample form view
     *
     * @return Symfony\Component\Form\FormView
     */
    protected function getSampleFormView()
    {
        $form = $this->factory->create('form');

        $form->add('test', 'text');

        return $form->createView();
    }
}