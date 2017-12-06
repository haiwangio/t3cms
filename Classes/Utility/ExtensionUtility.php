<?php

namespace SalvatoreEckel\T3cms\Utility;

/**
 * This file is part of the "T3cms" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

/**
 * Utility to provide some tasks belonging to extensions
 */
class ExtensionUtility
{

    /**
     * Find loaded extensions by key or prefix
     * Find extensions by extension keys and return an array only of loaded extensions
     * Find extensions that begin with a prefix like "t3themes_" and return an array only of loaded extensions
     *
     * @param array $data
     * @param bool $searchByPrefix
     * @return array
     */
    public static function getLoadedExtensions(array $data, $searchByPrefix = '')
    {
        $loadedExtensions = [];
        $extDir = scandir(PATH_typo3conf . 'ext/');
        if ($searchByPrefix) {
            foreach ($data as $prefix) {
                foreach ($extDir as $key => $localExtKey) {
                    if ((preg_match('/'.$prefix.'/i', $localExtKey)) || $localExtKey == $prefix) {
                        if (ExtensionManagementUtility::isLoaded($localExtKey)) {
                            $loadedExtensions[$localExtKey] = $localExtKey;
                        }
                    }
                }

                if ($unsetPrefix) {
                    unset($loadedExtensions[$prefix]);
                }
            }
        } else {
            $extKeys = $data;
            foreach (scandir(PATH_typo3conf . 'ext/') as $extKey => $localExtKey) {
                if (in_array($localExtKey, $extKeys)) {
                    if (ExtensionManagementUtility::isLoaded($localExtKey)) {
                        $loadedExtensions[$localExtKey] = $localExtKey;
                    }
                }
            }
        }
        return $loadedExtensions;
    }

}
