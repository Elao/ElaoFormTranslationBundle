<?php

/**
 * This file is part of the ElaoFormTranslation bundle.
 *
 * Copyright (C) 2014 Elao
 *
 * @author Elao <contact@elao.com>
 */

namespace Elao\Bundle\FormTranslationBundle;

use Elao\Bundle\FormTranslationBundle\DependencyInjection\Compiler\JMSTranslationPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Elao From Translation Bundle
 */
class ElaoFormTranslationBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new JMSTranslationPass());
    }
}
