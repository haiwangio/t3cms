<?php
namespace SalvatoreEckel\T3cms\DataProcessing;

/*
 * This file is part of the package salvatore-eckel/t3cms.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;

/**
 * Minimal TypoScript configuration
 * Process field pi_flexform and overrides the values stored in data
 *
 * 10 = SalvatoreEckel\T3cms\DataProcessing\T3themesConfProcessor
 *
 *
 * Advanced TypoScript configuration
 * Process field assigned in fieldName and stores processed data to new key
 *
 * 10 = SalvatoreEckel\T3cms\DataProcessing\T3themesConfProcessor
 * 10 {
 *   fieldName = t3themes_conf
 *   as = t3themesConf
 *   rootpageId = TEXT
 *   rootpageId {
 *       insertData = 1
 *       data = leveluid : 0
 *   }
 * }
 */
class T3themesConfProcessor implements DataProcessorInterface
{
    /**
     * @param ContentObjectRenderer $cObj The data of the content element or page
     * @param array $contentObjectConfiguration The configuration of Content Object
     * @param array $processorConfiguration The configuration of this processor
     * @param array $processedData Key/value store of processed data (e.g. to be passed to a Fluid View)
     * @return array the processed data as key/value store
     */
    public function process(ContentObjectRenderer $cObj, array $contentObjectConfiguration, array $processorConfiguration, array $processedData)
    {
        # PageRepository
        $sysPage = GeneralUtility::makeInstance(\TYPO3\CMS\Frontend\Page\PageRepository::class);
        $pageId = (GeneralUtility::_GP('id') > 0) ? GeneralUtility::_GP('id') : $cObj->stdWrapValue('rootpageId', $processorConfiguration);
        $rootline = $sysPage->getRootLine($pageId, '', true);

        $targetDbFieldName = $cObj->stdWrapValue('fieldName', $processorConfiguration);
        $targetVariableName = $cObj->stdWrapValue('as', $processorConfiguration);

        # Build and merge configuration upin rootpage
        if (!empty($rootline)) {
            $items = json_decode($rootline[0][$targetDbFieldName],1);
            foreach (array_reverse($rootline) as $key => $page) {
                $pageConf = json_decode($page[$targetDbFieldName],1);
                if (count($pageConf)) {
                    foreach ($pageConf as $name => $value) {
                        if (!empty($value)) {
                            $items[$name] = $value;
                        }
                    }
                }
            }
        }

        $processedData[$targetVariableName] = $items;

        return $processedData;
    }
}
