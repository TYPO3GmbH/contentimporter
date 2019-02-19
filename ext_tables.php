<?php

defined('TYPO3_MODE') or die();

call_user_func(function ($extKey) {
    if (TYPO3_MODE === 'BE') {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
            'T3G.Contentimporter',
            'web', // Make module a submodule of 'web'
            'contentimport', // Submodule key
            '', // Position
            [
                'Import' => 'chooseFile,file',
            ],
            [
                'access' => 'user,group',
                'icon' => 'EXT:' . $extKey . '/ext_icon.svg',
                'labels' => 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_contentimport.xlf',
            ]
        );

    }
}, 'contentimporter');
