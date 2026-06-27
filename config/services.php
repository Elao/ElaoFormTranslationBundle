<?php

/*
 * This file is part of the ElaoFormTranslation bundle.
 *
 * Copyright (C) Elao
 *
 * @author Elao <contact@elao.com>
 */

use Elao\Bundle\FormTranslationBundle\Builders\FormKeyBuilder;
use Elao\Bundle\FormTranslationBundle\Builders\FormTreeBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services->set('elao.form_translation.tree_builder', FormTreeBuilder::class);

    $services->set('elao.form_translation.key_builder', FormKeyBuilder::class);
};
