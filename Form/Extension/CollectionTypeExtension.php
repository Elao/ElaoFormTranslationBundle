<?php

/**
 * This file is part of the ElaoFormTranslation bundle.
 *
 * Copyright (C) 2014 Elao
 *
 * @author Elao <contact@elao.com>
 */

namespace Elao\Bundle\FormTranslationBundle\Form\Extension;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
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
        return CollectionType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        if ($this->autoGenerate) {
            $resolver->setDefault('label_add', true);
            $resolver->setDefault('label_delete', true);
        }
    }

    /**
     * for Sf < 2.7
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $this->configureOptions($resolver);
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
