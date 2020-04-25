<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/contentimporter.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\Contentimporter\Controller;

use T3G\Contentimporter\Service\ContentConverterService;
use T3G\Contentimporter\Service\DataHandlerService;
use TYPO3\CMS\Backend\Routing\UriBuilder;
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

        $contentElements = GeneralUtility::makeInstance(ContentConverterService::class)->convert($uploadedFile, $pid);

        $dataHandlerService = GeneralUtility::makeInstance(DataHandlerService::class);
        $dataHandlerService->createContentElements($contentElements);

        $uriBuilder = GeneralUtility::makeInstance(UriBuilder::class);
        $this->redirectToUri($uriBuilder->buildUriFromRoute('web_layout', ['id' => $pid]));
    }
}
