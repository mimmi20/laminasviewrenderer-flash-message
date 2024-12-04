<?php

/**
 * This file is part of the mimmi20/laminasviewrenderer-flash-message package.
 *
 * Copyright (c) 2023-2024, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Mimmi20\LaminasView\FlashMessage\View\Helper;

use Laminas\Mvc\Controller\PluginManager;
use Laminas\Mvc\Plugin\FlashMessenger\FlashMessenger as LaminasFlashMessenger;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Override;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;

use function assert;

/**
 * Generates the BootstrapFlashMessenger view helper object
 */
final class FlashMessengerFactory implements FactoryInterface
{
    /**
     * Create Service Factory
     *
     * @param string            $requestedName
     * @param array<mixed>|null $options
     * @phpstan-param array<mixed>|null $options
     *
     * @throws ContainerExceptionInterface
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
     */
    #[Override]
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array | null $options = null,
    ): FlashMessenger {
        $controllerPluginManager = $container->get('ControllerPluginManager');
        assert($controllerPluginManager instanceof PluginManager);

        $plugin = $controllerPluginManager->get('flashMessenger');
        assert($plugin instanceof LaminasFlashMessenger);

        return new FlashMessenger($plugin);
    }
}
