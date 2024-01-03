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

use ArrayAccess;
use Laminas\Mvc\Plugin\FlashMessenger\FlashMessenger as LaminasFlashMessenger;
use Laminas\View\Exception\RuntimeException;
use Laminas\View\Model\ModelInterface;
use Laminas\View\Model\ViewModel;
use Laminas\View\Renderer\RendererInterface;
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
     *
     * @phpcs:disable Generic.Metrics.CyclomaticComplexity.TooHigh
     * @phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength
     */
    public function testRender(): void
    {
        $flashMessenger = $this->createMock(LaminasFlashMessenger::class);
        $flashMessenger->expects(self::once())
            ->method('getErrorMessages')
            ->willReturn(['error-message']);
        $flashMessenger->expects(self::once())
            ->method('getCurrentErrorMessages')
            ->willReturn(['error-message', 'current-error-message']);
        $flashMessenger->expects(self::once())
            ->method('getSuccessMessages')
            ->willReturn(['success-message']);
        $flashMessenger->expects(self::once())
            ->method('getCurrentSuccessMessages')
            ->willReturn(['success-message', 'current-success-message']);
        $flashMessenger->expects(self::once())
            ->method('getWarningMessages')
            ->willReturn(['warning-message']);
        $flashMessenger->expects(self::once())
            ->method('getCurrentWarningMessages')
            ->willReturn(['warning-message', 'current-warning-message']);
        $flashMessenger->expects(self::once())
            ->method('getInfoMessages')
            ->willReturn(['info-message']);
        $flashMessenger->expects(self::once())
            ->method('getCurrentInfoMessages')
            ->willReturn(['info-message', 'current-info-message']);
        $flashMessenger->expects(self::once())
            ->method('getMessages')
            ->willReturn(['default-message']);
        $flashMessenger->expects(self::once())
            ->method('getCurrentMessages')
            ->willReturn(['default-message', 'current-default-message']);
        $flashMessenger->expects(self::once())
            ->method('clearMessagesFromContainer')
            ->willReturn(true);
        $flashMessenger->expects(self::once())
            ->method('clearCurrentMessagesFromContainer')
            ->willReturn(true);

        $object = new FlashMessenger($flashMessenger);

        $view    = $this->createMock(RendererInterface::class);
        $matcher = self::exactly(10);
        $view->expects($matcher)
            ->method('render')
            ->willReturnCallback(
                static function (ModelInterface | string $nameOrModel, array | ArrayAccess | null $values = null) use ($matcher): string {
                    self::assertInstanceOf(ViewModel::class, $nameOrModel);

                    match ($matcher->numberOfInvocations()) {
                        1, 2 => self::assertSame('danger', $nameOrModel->getVariable('alertLevel')),
                        3, 4 => self::assertSame('warning', $nameOrModel->getVariable('alertLevel')),
                        5, 6 => self::assertSame('info', $nameOrModel->getVariable('alertLevel')),
                        7, 8 => self::assertSame('success', $nameOrModel->getVariable('alertLevel')),
                        9, 10 => self::assertSame('primary', $nameOrModel->getVariable('alertLevel')),
                        default => self::assertSame('', $nameOrModel->getVariable('alertLevel')),
                    };

                    match ($matcher->numberOfInvocations()) {
                        1 => self::assertSame(
                            'error-message',
                            $nameOrModel->getVariable('alertMessage'),
                        ),
                        2 => self::assertSame(
                            'current-error-message',
                            $nameOrModel->getVariable('alertMessage'),
                        ),
                        3 => self::assertSame(
                            'warning-message',
                            $nameOrModel->getVariable('alertMessage'),
                        ),
                        4 => self::assertSame(
                            'current-warning-message',
                            $nameOrModel->getVariable('alertMessage'),
                        ),
                        5 => self::assertSame(
                            'info-message',
                            $nameOrModel->getVariable('alertMessage'),
                        ),
                        6 => self::assertSame(
                            'current-info-message',
                            $nameOrModel->getVariable('alertMessage'),
                        ),
                        7 => self::assertSame(
                            'success-message',
                            $nameOrModel->getVariable('alertMessage'),
                        ),
                        8 => self::assertSame(
                            'current-success-message',
                            $nameOrModel->getVariable('alertMessage'),
                        ),
                        9 => self::assertSame(
                            'default-message',
                            $nameOrModel->getVariable('alertMessage'),
                        ),
                        10 => self::assertSame(
                            'current-default-message',
                            $nameOrModel->getVariable('alertMessage'),
                        ),
                        default => self::assertSame('', $nameOrModel->getVariable('alertMessage')),
                    };

                    self::assertSame('widget/bootstrap-alert', $nameOrModel->getTemplate());
                    self::assertNull($values);

                    return 'test-render';
                },
            );

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
