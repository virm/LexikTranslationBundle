<?php

namespace Lexik\Bundle\TranslationBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class TranslationStoragePass
 * @package Lexik\Bundle\TranslationBundle\DependencyInjection\Compiler
 */
class TranslationStoragePass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $storage = $container->getParameter('lexik_translation.storage.type');

        $storageDefinition = $container->getDefinition('lexik_translation.translation_storage');
        $storageDefinition->setClass(
            $container->getParameter(sprintf('lexik_translation.%s.translation_storage.class', $storage))
        );

        $storageDefinition->setArguments(array(
            new Reference(
                $container->getParameter('lexik_translation.storage.object_manager')
            ),
            array(
                'trans_unit'  => $container->getParameter(sprintf('lexik_translation.%s.trans_unit.class', $storage)),
                'translation' => $container->getParameter(sprintf('lexik_translation.%s.translation.class', $storage)),
                'file'        => $container->getParameter(sprintf('lexik_translation.%s.file.class', $storage)),
            ),
        ));
    }
}