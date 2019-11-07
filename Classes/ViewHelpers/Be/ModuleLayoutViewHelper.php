<?php

/*
 * This file is part of the package t3g/contentimporter.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\Contentimporter\ViewHelpers\Be;

use TYPO3\CMS\Backend\Template\ModuleTemplate;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

class ModuleLayoutViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    /**
     * @var bool
     */
    protected $escapeOutput = false;

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return string
     * @throws \Exception
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext): string
    {
        if ($renderingContext->getViewHelperVariableContainer()->exists(self::class, ModuleTemplate::class)) {
            throw new \Exception('this vh cannot be used more than once per template', 1483292643);
        }
        $moduleTemplate = GeneralUtility::makeInstance(ModuleTemplate::class);
        $moduleTemplate->setFlashMessageQueue($renderingContext->getControllerContext()->getFlashMessageQueue());

        $renderingContext->getViewHelperVariableContainer()->add(self::class, ModuleTemplate::class, $moduleTemplate);
        $moduleTemplate->setContent($renderChildrenClosure());

        return $moduleTemplate->renderContent();
    }
}
