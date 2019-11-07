<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/contentimporter.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\Contentimporter\Service;

use PhpOffice\PhpWord\Element\AbstractElement;
use PhpOffice\PhpWord\Element\Title;
use PhpOffice\PhpWord\IOFactory;

class ContentConverterService
{

    /**
     * Convert .docx file located at $file to contentElements on page $pid
     *
     * @param string $filePath
     * @param int $pid
     * @return array
     */
    public function convert(string $filePath, int $pid): array
    {
        $phpWord = IOFactory::load($filePath);

        $sections = $phpWord->getSections();
        $contentElements = [];
        foreach ($sections as $section) {
            $elements = $section->getElements();
            $contentElement = [];
            $ceIdent = uniqid('NEW');
            $openList = false;
            foreach ($elements as $element) {
                if ($element instanceof Title) {
                    $contentElements[$ceIdent] = $contentElement;
                    $ceIdent = uniqid('NEW');
                    $contentElement = [
                        'pid' => $pid,
                        'header' => $element->getText(),
                    ];
                } else {
                    $containerClass = substr(get_class($element), strrpos(get_class($element), '\\') + 1);
                    $withoutP = in_array($containerClass, ['TextRun', 'Footnote', 'Endnote']) ? true : false;
                    if ($containerClass === 'ListItem' && $openList === false) {
                        $openList = true;
                        $contentElement['bodytext'] .= '<ul>';
                    }
                    if ($openList === true && $containerClass !== 'ListItem') {
                        $contentElement['bodytext'] .= '</ul>';
                    }
                    $contentElement['bodytext'] .= $this->parse($element, $withoutP);
                }
            }
            $contentElements[$ceIdent] = $contentElement;
            $contentElement[$ceIdent]['pid'] = $pid;
        }
        return $contentElements;
    }

    /**
     * @param AbstractElement $element
     * @param bool $withoutP
     * @return string
     */
    protected function parse(AbstractElement $element, bool $withoutP = false): string
    {
        $text = '';
        $elementClass = get_class($element);
        $customWriterClass = str_replace('PhpOffice\\PhpWord\\Element', 'T3G\\Contentimporter\\Writer\\Element', $elementClass);
        $writerClass = str_replace('PhpOffice\\PhpWord\\Element', 'PhpOffice\\PhpWord\\Writer\\HTML\\Element', $elementClass);
        if (class_exists($customWriterClass)) {
            $writerClass = $customWriterClass;
        }
        if (class_exists($writerClass)) {
            /** @var \PhpOffice\PhpWord\Writer\HTML\Element\AbstractElement $writer Type hint */
            $writer = new $writerClass(new \PhpOffice\PhpWord\Writer\HTML(), $element, $withoutP);
            $text .= $writer->write();
        }
        return $text;
    }
}
