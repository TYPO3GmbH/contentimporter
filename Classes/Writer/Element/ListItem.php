<?php
declare(strict_types=1);

/*
 * This file is part of the package t3g/contentimporter.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\ContentImporter\Writer\Element;

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
