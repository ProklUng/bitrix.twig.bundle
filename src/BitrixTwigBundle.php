<?php

namespace Prokl\BitrixTwigBundle;

use Prokl\BitrixTwigBundle\DependencyInjection\BitrixTwigExtension;
use Prokl\BitrixTwigBundle\DependencyInjection\CompilerPass\MakeExtensionsPublic;
use Prokl\BitrixTwigBundle\DependencyInjection\CompilerPass\TwigExtensionConfigurator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class BitrixTwigBundle
 * @package Prokl\BitrixTwigBundle
 *
 * @since 15.08.2021
 */
class BitrixTwigBundle extends Bundle
{
   /**
   * @inheritDoc
   */
    public function getContainerExtension()
    {
        if ($this->extension === null) {
            $this->extension = new BitrixTwigExtension();
        }

        return $this->extension;
    }

    /**
     * @inheritDoc
     */
    public function build(ContainerBuilder $container) : void
    {
        parent::build($container);

        $container->addCompilerPass(new TwigExtensionConfigurator());
        $container->addCompilerPass(new MakeExtensionsPublic());
    }
}
