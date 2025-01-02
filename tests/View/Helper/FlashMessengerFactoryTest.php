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

namespace Mimmi20\LaminasView\FlashMessage\View\Helper;

use Laminas\Mvc\Controller\PluginManager;
use Laminas\Mvc\Plugin\FlashMessenger\FlashMessenger as LaminasFlashMessenger;
use Override;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

final class FlashMessengerFactoryTest extends TestCase
{
    private FlashMessengerFactory $object;

    /** @throws void */
    #[Override]
    protected function setUp(): void
    {
        $this->object = new FlashMessengerFactory();
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function testInvoke(): void
    {
        $flashMessenger = $this->createMock(LaminasFlashMessenger::class);

        $controllerPluginManager = $this->getMockBuilder(PluginManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $controllerPluginManager->expects(self::once())
            ->method('get')
            ->with('flashMessenger')
            ->willReturn($flashMessenger);
        $controllerPluginManager->expects(self::never())
            ->method('has');

        $container = $this->getMockBuilder(ContainerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $container->expects(self::once())
            ->method('get')
            ->with('ControllerPluginManager')
            ->willReturn($controllerPluginManager);
        $container->expects(self::never())
            ->method('has');

        $result = ($this->object)($container, '');

        self::assertInstanceOf(FlashMessenger::class, $result);
    }
}
