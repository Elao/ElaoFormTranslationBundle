<?php

/**
 * This file is part of the ElaoFormTranslation bundle.
 *
 * Copyright (C) 2014 Elao
 *
 * @author Elao <contact@elao.com>
 */

namespace Elao\Bundle\FormTranslationBundle\Form\Extension;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Collection Type Extension
 */
class CollectionTypeExtension extends TreeAwareExtension
{
    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return 'collection';
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        if ($this->autoGenerate) {
            $options = array('label_add', 'label_delete');

            foreach ($options as $option) {
                if ($resolver->isKnown($option)) {
                    $resolver->replaceDefaults(array($option => true));
                }
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        if ($this->treeBuilder && $this->keyBuilder && $options['allow_add'] && $options['prototype']) {

            if ($view->vars['prototype']->vars['label'] == $options['prototype_name'].'label__') {
                if (!isset($options['options']['label'])) {
                    $options['options']['label'] = $options['label'];
                }
                $view->vars['prototype']->vars['label'] = $options['options']['label'];
            }

            foreach ($this->keys as $key => $value) {
                if (isset($options['options'][$key]) && $options['options'][$key] === true) {
                    $this->generateKey($view->vars['prototype'], $key, $value);
                }
            }
        }

        parent::finishView($view, $form, $options);
    }
}
