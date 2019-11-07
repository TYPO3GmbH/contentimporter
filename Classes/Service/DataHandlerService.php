<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/contentimporter.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\Contentimporter\Service;

use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class DataHandlerService
{
    public function createContentElements(array $contentElements)
    {
        $tce = GeneralUtility::makeInstance(DataHandler::class);
        krsort($contentElements);
        $data = [
            'tt_content' => $contentElements,
        ];
        $tce->start($data, []);
        $tce->process_datamap();
    }
}
