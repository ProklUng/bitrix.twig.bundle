<?php

namespace Prokl\BitrixTwigBundle\DependencyInjection;

use Exception;
use LogicException;
use Maximaster\Tools\Twig\TemplateEngine;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Class BitrixTwigExtension
 * @package Prokl\BitrixTwig\DependencyInjection
 *
 * @since 15.08.2021
 */
class BitrixTwigExtension extends Extension
{
    private const DIR_CONFIG = '/../Resources/config';

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function load(array $configs, ContainerBuilder $container) : void
    {
        if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
            throw new \RuntimeException('Бандл BitrixTwigExtension работает только под Битриксом.');
        }

        if (!class_exists('Prokl\CustomFrameworkExtensionsBundle\DependencyInjection\CustomFrameworkExtensionsExtension')) {
            throw new LogicException(
                'Чтобы использовать Твиг нужно установить и активировать core.framework.extension.bundle. 
              Попробуйте composer require proklung/core-framework-extension-bundle.'
            );
        }

        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . self::DIR_CONFIG)
        );

        $loader->load('services.yaml');
    }

    /**
     * @inheritDoc
     */
    public function getAlias() : string
    {
        return 'bitrix-twig';
    }
}
