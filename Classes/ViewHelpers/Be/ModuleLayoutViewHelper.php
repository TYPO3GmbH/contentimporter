<?php

namespace T3G\Contentimporter\ViewHelpers\Be;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Backend\Template\ModuleTemplate;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

class ModuleLayoutViewHelper extends AbstractViewHelper
{
    /**
     * @var bool
     */
    protected $escapeOutput = false;

    /**
     *
     */
    public function render()
    {
        if ($this->viewHelperVariableContainer->exists(self::class, ModuleTemplate::class)) {
            throw new \Exception('this vh cannot be used more than once per template', 1483292643);
        }
        $moduleTemplate = GeneralUtility::makeInstance(ModuleTemplate::class);
        $moduleTemplate->setFlashMessageQueue($this->controllerContext->getFlashMessageQueue());

        $this->viewHelperVariableContainer->add(self::class, ModuleTemplate::class, $moduleTemplate);
        $moduleTemplate->setContent($this->renderChildren());

        return $moduleTemplate->renderContent();
    }
}
