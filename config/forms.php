<?php

/*
 * This file is part of the ElaoFormTranslation bundle.
 *
 * Copyright (C) Elao
 *
 * @author Elao <contact@elao.com>
 */

use Elao\Bundle\FormTranslationBundle\Form\Extension\ButtonTypeExtension;
use Elao\Bundle\FormTranslationBundle\Form\Extension\ChoiceTypeExtension;
use Elao\Bundle\FormTranslationBundle\Form\Extension\CollectionTypeExtension;
use Elao\Bundle\FormTranslationBundle\Form\Extension\FormTypeExtension;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FormType;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services->set('elao.form_translation.extension.tree_aware_extension')
        ->abstract();

    $services->set('elao.form_translation.extension.form_type_extension', FormTypeExtension::class)
        ->parent('elao.form_translation.extension.tree_aware_extension')
        ->tag('form.type_extension', ['extended-type' => FormType::class]);

    $services->set('elao.form_translation.extension.collection_type_extension', CollectionTypeExtension::class)
        ->parent('elao.form_translation.extension.tree_aware_extension')
        ->tag('form.type_extension', ['extended-type' => CollectionType::class]);

    $services->set('elao.form_translation.extension.button_type_extension', ButtonTypeExtension::class)
        ->parent('elao.form_translation.extension.tree_aware_extension')
        ->tag('form.type_extension', ['extended-type' => ButtonType::class]);

    $services->set('elao.form_translation.extension.choice_type_extension', ChoiceTypeExtension::class)
        ->parent('elao.form_translation.extension.tree_aware_extension')
        ->tag('form.type_extension', ['extended-type' => ChoiceType::class]);
};
