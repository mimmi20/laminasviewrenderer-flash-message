<?php

/**
 * This file is part of the mimmi20/laminasviewrenderer-flash-message package.
 *
 * Copyright (c) 2023-2025, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Mimmi20\LaminasView\FlashMessage;

use Mimmi20\LaminasView\FlashMessage\View\Helper\FlashMessenger;
use Mimmi20\LaminasView\FlashMessage\View\Helper\FlashMessengerFactory;

final class ConfigProvider
{
    /**
     * Returns configuration from file
     *
     * @return array<array<array<string>>>
     * @phpstan-return array{view_helpers: array{aliases: non-empty-array<string, class-string>, factories: non-empty-array<class-string, class-string>}}
     *
     * @throws void
     */
    public function __invoke(): array
    {
        return [
            'view_helpers' => $this->getViewHelperConfig(),
        ];
    }

    /**
     * Get view helper configuration
     *
     * @return array<array<string>>
     * @phpstan-return array{aliases: non-empty-array<string, class-string>, factories: non-empty-array<class-string, class-string>}
     *
     * @throws void
     */
    public function getViewHelperConfig(): array
    {
        return [
            'aliases' => [
                'bootstrapFlashMessenger' => FlashMessenger::class,
            ],
            'factories' => [
                FlashMessenger::class => FlashMessengerFactory::class,
            ],
        ];
    }
}
