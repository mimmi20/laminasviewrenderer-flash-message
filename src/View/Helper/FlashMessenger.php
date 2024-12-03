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

use Laminas\Mvc\Plugin\FlashMessenger\FlashMessenger as LaminasFlashMessenger;
use Laminas\View\Exception\RuntimeException;
use Laminas\View\Helper\AbstractHelper;
use Laminas\View\Model\ViewModel;

use function array_merge;
use function array_unique;

/**
 * Outputs all messages from FlashMessenger in Bootstrap style
 */
final class FlashMessenger extends AbstractHelper
{
    /** @throws void */
    public function __construct(private readonly LaminasFlashMessenger $flashMessenger)
    {
        // nothing to do
    }

    /**
     * Outputs message depending on flag
     *
     * @throws void
     */
    public function __invoke(): self
    {
        return $this;
    }

    /**
     * Outputs message depending on flag
     *
     * @throws RuntimeException
     *
     * @api
     */
    public function render(): string
    {
        $view = $this->getView();

        if ($view === null) {
            throw new RuntimeException('A view Renderer is required');
        }

        $allMessages = [
            'danger' => array_unique(
                array_merge(
                    $this->flashMessenger->getErrorMessages(),
                    $this->flashMessenger->getCurrentErrorMessages(),
                ),
            ),
            'warning' => array_unique(
                array_merge(
                    $this->flashMessenger->getWarningMessages(),
                    $this->flashMessenger->getCurrentWarningMessages(),
                ),
            ),
            'info' => array_unique(
                array_merge(
                    $this->flashMessenger->getInfoMessages(),
                    $this->flashMessenger->getCurrentInfoMessages(),
                ),
            ),
            'success' => array_unique(
                array_merge(
                    $this->flashMessenger->getSuccessMessages(),
                    $this->flashMessenger->getCurrentSuccessMessages(),
                ),
            ),
            'primary' => array_unique(
                array_merge(
                    $this->flashMessenger->getMessages(),
                    $this->flashMessenger->getCurrentMessages(),
                ),
            ),
        ];

        $this->flashMessenger->clearMessagesFromContainer();
        $this->flashMessenger->clearCurrentMessagesFromContainer();

        $output = '';

        foreach ($allMessages as $alertLevel => $groupMessages) {
            foreach ($groupMessages as $message) {
                $viewModel = new ViewModel();
                $viewModel->setVariable('alertLevel', $alertLevel);
                $viewModel->setVariable('alertMessage', $message);
                $viewModel->setTemplate('widget/bootstrap-alert');

                $output .= $view->render($viewModel);
            }
        }

        return $output;
    }
}
