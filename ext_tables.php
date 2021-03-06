<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function($extKey)
    {

        if (TYPO3_MODE === 'BE' && !(TYPO3_REQUESTTYPE & TYPO3_REQUESTTYPE_INSTALL)) {
            $extConfiguration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['t3cms']);

            // Hijack: Typo3 default module listing order
            $GLOBALS['TBE_MODULES'] = array_merge(array('SalvatoreEckel' => ''), $GLOBALS['TBE_MODULES']);
            $GLOBALS['TBE_MODULES']['_configuration']['SalvatoreEckel'] = array(
                'labels' => array(
                    'll_ref' => 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_db.xlf',
                    'tabs_images' => array(
                        'tab' => 'EXT:' . $extKey . '/Resources/Public/Icons/user_mod_dashboard.svg',
                    )
                ),
                'name' => 'SalvatoreEckel', // New main module key as 'pw'
            );


            if ($extConfiguration['enableT3cmsModule'] == 1) {
                \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
                    'SalvatoreEckel.T3cms',
                    'SalvatoreEckel', // Make module a submodule of 'SalvatoreEckel'
                    'dashboard', // Submodule key
                    '', // Position
                    [
                        'Worker' => 'dashboard,config,ajax,feUserProfile'
                    ],
                    [
                        'access' => 'user,group',
                        'icon'   => 'EXT:' . $extKey . '/Resources/Public/Icons/user_mod_dashboard.png',
                        'labels' => 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_dashboard.xlf',
                    ]
                );
            }

            \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
                'SalvatoreEckel.T3cms',
                'web', // Make module a submodule of 'SalvatoreEckel'
                'options', // Submodule key
                '', // Position
                [
                    'Worker' => 'config,updateConfig,dashboard,ajax,feUserProfile'
                ],
                [
                    'access' => 'user,group',
                    'icon'   => 'EXT:' . $extKey . '/Resources/Public/Icons/user_mod_options.png',
                    'labels' => 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_options.xlf',
                ]
            );

        }

        # DEPRECATED
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'SalvatoreEckel.' . $extKey,
            'T3cms',
            'T3cms'
        );

    },
    $_EXTKEY
);
