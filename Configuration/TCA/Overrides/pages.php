<?php

$columns = array(
    't3themes_conf' => array (
        'exclude' => 0,
        'label' => 'LLL:EXT:t3cms/Resources/Private/Language/locallang_db.xlf:pages.t3themes_conf',
        'config' => array(
                'type' => 'text',
                'readOnly' => 1,
                'cols' => 40,
                'rows' => 6
        ),
    ),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('pages', $columns, 1);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
    'pages',
    'layout',
    '--linebreak--, t3themes_conf',
    'after: backend_layout_next_level'
);

unset($columns);

