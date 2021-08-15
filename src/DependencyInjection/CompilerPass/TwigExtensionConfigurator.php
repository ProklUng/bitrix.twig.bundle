<?php

namespace Prokl\BitrixTwigBundle\DependencyInjection\CompilerPass;

use RuntimeException;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class TwigExtensionConfigurator
 * @package Prokl\TwigExtensionsPackBundle\DependencyInjection\CompilerPass
 *
 * @since 08.08.2021
 */
class TwigExtensionConfigurator implements CompilerPassInterface
{
    /**
     * @inheritdoc
     */
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasDefinition('twig.cache.runtime')) {
            return;
        }

        // Кэшер для runtime директивы cacher.
        $cacherTwigDefinition = $container->getDefinition('twig.cache.runtime');

        $serviceCacherId = null;
        if ($container->hasParameter('twig.cacher')) {
            $serviceCacherId = $container->getParameter('twig.cacher');
        }

        // null => значит фича отключена.
        if ($serviceCacherId === null) {
            $container->removeDefinition('twig.cache.runtime');
            return;
        }

        if (!$container->hasDefinition($serviceCacherId)) {
            throw new RuntimeException('Invalid service in cache config key:  ' . $serviceCacherId);
        }

        $newCacherDef = $container->getDefinition($serviceCacherId);
        $cacherTwigDefinition->replaceArgument(0, $newCacherDef);
    }
}
