<?php
/**
 * This file is part of PHPWord - A pure PHP library for reading and writing
 * word processing documents.
 *
 * PHPWord is free software distributed under the terms of the GNU Lesser
 * General Public License version 3 as published by the Free Software Foundation.
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code. For the full list of
 * contributors, visit https://github.com/PHPOffice/PHPWord/contributors.
 *
 * @link        https://github.com/PHPOffice/PHPWord
 * @copyright   2010-2016 PHPWord contributors
 * @license     http://www.gnu.org/licenses/lgpl.txt LGPL version 3
 */

namespace T3G\ContentImporter\Writer\Element;

use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\Writer\HTML\Element\AbstractElement;

/**
 * ListItem element HTML writer
 *
 * @since 0.10.0
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
