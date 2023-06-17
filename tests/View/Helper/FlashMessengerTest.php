<?php
/**
 * This file is part of the mimmi20/laminasviewrenderer-flash-message package.
 *
 * Copyright (c) 2023, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Mimmi20\LaminasView\FlashMessage\View\Helper;

use Laminas\Mvc\Plugin\FlashMessenger\FlashMessenger as LaminasFlashMessenger;
use Laminas\View\Exception\RuntimeException;
use Laminas\View\Model\ViewModel;
use Laminas\View\Renderer\RendererInterface;
use PHPUnit\Framework\Constraint\IsInstanceOf;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;

use function str_repeat;

final class FlashMessengerTest extends TestCase
{
    /** @throws Exception */
    public function testInvoke(): void
    {
        $flashMessenger = $this->createMock(LaminasFlashMessenger::class);
        $flashMessenger->expects(self::never())
            ->method('getErrorMessages');
        $flashMessenger->expects(self::never())
            ->method('getCurrentErrorMessages');
        $flashMessenger->expects(self::never())
            ->method('getSuccessMessages');
        $flashMessenger->expects(self::never())
            ->method('getCurrentSuccessMessages');
        $flashMessenger->expects(self::never())
            ->method('getWarningMessages');
        $flashMessenger->expects(self::never())
            ->method('getCurrentWarningMessages');
        $flashMessenger->expects(self::never())
            ->method('getInfoMessages');
        $flashMessenger->expects(self::never())
            ->method('getCurrentInfoMessages');
        $flashMessenger->expects(self::never())
            ->method('getMessages');
        $flashMessenger->expects(self::never())
            ->method('getCurrentMessages');
        $flashMessenger->expects(self::never())
            ->method('clearMessagesFromContainer');
        $flashMessenger->expects(self::never())
            ->method('clearCurrentMessagesFromContainer');

        $object = new FlashMessenger($flashMessenger);

        self::assertSame($object, $object());
    }

    /**
     * @throws Exception
     * @throws RuntimeException
     */
    public function testRenderWithoutMessages(): void
    {
        $flashMessenger = $this->createMock(LaminasFlashMessenger::class);
        $flashMessenger->expects(self::once())
            ->method('getErrorMessages')
            ->willReturn([]);
        $flashMessenger->expects(self::once())
            ->method('getCurrentErrorMessages')
            ->willReturn([]);
        $flashMessenger->expects(self::once())
            ->method('getSuccessMessages')
            ->willReturn([]);
        $flashMessenger->expects(self::once())
            ->method('getCurrentSuccessMessages')
            ->willReturn([]);
        $flashMessenger->expects(self::once())
            ->method('getWarningMessages')
            ->willReturn([]);
        $flashMessenger->expects(self::once())
            ->method('getCurrentWarningMessages')
            ->willReturn([]);
        $flashMessenger->expects(self::once())
            ->method('getInfoMessages')
            ->willReturn([]);
        $flashMessenger->expects(self::once())
            ->method('getCurrentInfoMessages')
            ->willReturn([]);
        $flashMessenger->expects(self::once())
            ->method('getMessages')
            ->willReturn([]);
        $flashMessenger->expects(self::once())
            ->method('getCurrentMessages')
            ->willReturn([]);
        $flashMessenger->expects(self::once())
            ->method('clearMessagesFromContainer')
            ->willReturn(true);
        $flashMessenger->expects(self::once())
            ->method('clearCurrentMessagesFromContainer')
            ->willReturn(true);

        $object = new FlashMessenger($flashMessenger);

        $view = $this->createMock(RendererInterface::class);
        $view->expects(self::never())
            ->method('render');

        $object->setView($view);

        self::assertSame('', $object->render());
    }

    /**
     * @throws Exception
     * @throws RuntimeException
     */
    public function testRender(): void
    {
        $flashMessenger = $this->createMock(LaminasFlashMessenger::class);
        $flashMessenger->expects(self::once())
            ->method('getErrorMessages')
            ->willReturn(['error-message']);
        $flashMessenger->expects(self::once())
            ->method('getCurrentErrorMessages')
            ->willReturn(['current-error-message']);
        $flashMessenger->expects(self::once())
            ->method('getSuccessMessages')
            ->willReturn(['success-message']);
        $flashMessenger->expects(self::once())
            ->method('getCurrentSuccessMessages')
            ->willReturn(['current-success-message']);
        $flashMessenger->expects(self::once())
            ->method('getWarningMessages')
            ->willReturn(['warning-message']);
        $flashMessenger->expects(self::once())
            ->method('getCurrentWarningMessages')
            ->willReturn(['current-warning-message']);
        $flashMessenger->expects(self::once())
            ->method('getInfoMessages')
            ->willReturn(['info-message']);
        $flashMessenger->expects(self::once())
            ->method('getCurrentInfoMessages')
            ->willReturn(['current-info-message']);
        $flashMessenger->expects(self::once())
            ->method('getMessages')
            ->willReturn(['default-message']);
        $flashMessenger->expects(self::once())
            ->method('getCurrentMessages')
            ->willReturn(['current-default-message']);
        $flashMessenger->expects(self::once())
            ->method('clearMessagesFromContainer')
            ->willReturn(true);
        $flashMessenger->expects(self::once())
            ->method('clearCurrentMessagesFromContainer')
            ->willReturn(true);

        $object = new FlashMessenger($flashMessenger);

        $view = $this->createMock(RendererInterface::class);
        $view->expects(self::exactly(10))
            ->method('render')
            ->with(new IsInstanceOf(ViewModel::class), null)
            ->willReturn('test-render');

        $object->setView($view);

        self::assertSame(str_repeat('test-render', 10), $object->render());
    }

    /**
     * @throws Exception
     * @throws RuntimeException
     */
    public function testRenderWithException(): void
    {
        $flashMessenger = $this->createMock(LaminasFlashMessenger::class);
        $flashMessenger->expects(self::never())
            ->method('getErrorMessages');
        $flashMessenger->expects(self::never())
            ->method('getCurrentErrorMessages');
        $flashMessenger->expects(self::never())
            ->method('getSuccessMessages');
        $flashMessenger->expects(self::never())
            ->method('getCurrentSuccessMessages');
        $flashMessenger->expects(self::never())
            ->method('getWarningMessages');
        $flashMessenger->expects(self::never())
            ->method('getCurrentWarningMessages');
        $flashMessenger->expects(self::never())
            ->method('getInfoMessages');
        $flashMessenger->expects(self::never())
            ->method('getCurrentInfoMessages');
        $flashMessenger->expects(self::never())
            ->method('getMessages');
        $flashMessenger->expects(self::never())
            ->method('getCurrentMessages');
        $flashMessenger->expects(self::never())
            ->method('clearMessagesFromContainer');
        $flashMessenger->expects(self::never())
            ->method('clearCurrentMessagesFromContainer');

        $object = new FlashMessenger($flashMessenger);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('A view Renderer is required');

        $object->render();
    }
}
