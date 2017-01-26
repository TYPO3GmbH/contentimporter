<?php
declare(strict_types = 1);


namespace T3G\Contentimporter\Controller;


use PhpOffice\PhpWord\Element\Title;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\DataHandling\DataHandler;
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
        $phpWordTest = \PhpOffice\PhpWord\IOFactory::load($uploadedFile);

        $sections = $phpWordTest->getSections();
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

        $tce = GeneralUtility::makeInstance(DataHandler::class);
        krsort($contentElements);
        $data = [
            'tt_content' => $contentElements,
        ];
        $tce->start($data, []);
        $tce->process_datamap();

        $this->redirectToUri(BackendUtility::getModuleUrl('web_layout', ['id' => $pid]));
    }

    protected function parse($element, $withoutP = false)
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
