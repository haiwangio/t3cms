<?php

$columns = [
    't3themes_conf' => [
        'exclude' => 0,
        'label' => 'LLL:EXT:t3cms/Resources/Private/Language/locallang_db.xlf:pages.t3themes_conf',
        'config' => [
                'type' => 'text',
                'readOnly' => 1,
                'cols' => 40,
                'rows' => 6
        ],
    ],
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('pages', $columns, 1);

unset($columns);

