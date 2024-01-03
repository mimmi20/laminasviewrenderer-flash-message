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

namespace Mimmi20\LaminasView\FlashMessage;

use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use Laminas\ModuleManager\Feature\DependencyIndicatorInterface;

final class Module implements ConfigProviderInterface, DependencyIndicatorInterface
{
    /**
     * Returns configuration to merge with application configuration
     *
     * @return array<array<array<string>>>
     * @phpstan-return array{view_helpers: array{aliases: non-empty-array<string, class-string>, factories: non-empty-array<class-string, class-string>}}
     *
     * @throws void
     */
    public function getConfig(): array
    {
        $provider = new ConfigProvider();

        return [
            'view_helpers' => $provider->getViewHelperConfig(),
        ];
    }

    /**
     * Expected to return an array of modules on which the current one depends on
     *
     * @return array<string>
     * @phpstan-return non-empty-array<int, string>
     *
     * @throws void
     */
    public function getModuleDependencies(): array
    {
        return ['Laminas\Mvc\Plugin\FlashMessenger'];
    }
}
