<?php
declare(strict_types = 1);

namespace T3G\Contentimporter\Controller;

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

use T3G\Contentimporter\Service\ContentConverterService;
use T3G\Contentimporter\Service\DataHandlerService;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class ImportController extends ActionController
{

    public function chooseFileAction()
    {

    }

    public function fileAction()
    {
        $pid = (int)$_GET['id'];
        $uploadedFile = $_FILES['tx_contentimporter_web_contentimportercontentimport']['tmp_name']['fileName'];

        $contentConverter = GeneralUtility::makeInstance(ContentConverterService::class);
        $contentElements = $contentConverter->convert($uploadedFile, $pid);

        $dataHandlerService = GeneralUtility::makeInstance(DataHandlerService::class);
        $dataHandlerService->createContentElements($contentElements);

        $this->redirectToUri(BackendUtility::getModuleUrl('web_layout', ['id' => $pid]));

    }

}
