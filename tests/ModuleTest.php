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
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;

final class ModuleTest extends TestCase
{
    /** @throws Exception */
    public function testGetConfig(): void
    {
        $object = new Module();
        $config = $object->getConfig();

        self::assertIsArray($config);
        self::assertArrayHasKey('view_helpers', $config);

        $viewHelperConfig = $config['view_helpers'];

        self::assertIsArray($viewHelperConfig);

        self::assertArrayHasKey('factories', $viewHelperConfig);
        $factories = $viewHelperConfig['factories'];
        self::assertIsArray($factories);
        self::assertArrayHasKey(FlashMessenger::class, $factories);

        self::assertArrayHasKey('aliases', $viewHelperConfig);
        $aliases = $viewHelperConfig['aliases'];
        self::assertIsArray($aliases);
        self::assertArrayHasKey('bootstrapFlashMessenger', $aliases);
    }

    /** @throws Exception */
    public function testGetModuleDependencies(): void
    {
        $object = new Module();
        $config = $object->getModuleDependencies();

        self::assertIsArray($config);
        self::assertContains('Laminas\Mvc\Plugin\FlashMessenger', $config);
    }
}
