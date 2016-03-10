<?php

namespace Elao\Bundle\FormTranslationBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class JMSTranslationPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasExtension('jms_translation')) {
            $container->removeDefinition('elao.form_translation.extractor.form_extractor');
        }
    }
}
