<?php
declare(strict_types=1);

namespace T3G\ContentImporter\Writer\Element;

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
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\Writer\HTML\Element\AbstractElement;

/**
 * ListItem element HTML writer - taken from phpword and changed to generate <li> tags
 */
class ListItem extends AbstractElement
{
    /**
     * Write list item
     *
     * @return string
     */
    public function write()
    {
        if (!$this->element instanceof \PhpOffice\PhpWord\Element\ListItem) {
            return '';
        }

        if (Settings::isOutputEscapingEnabled()) {
            $content = '<li>' . $this->escaper->escapeHtml($this->element->getTextObject()->getText()) . '</li>' . PHP_EOL;
        } else {
            $content = '<li>' . $this->element->getTextObject()->getText() . '</li>' . PHP_EOL;
        }

        return $content;
    }
}
