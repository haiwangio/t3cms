<?php

/*
 * This file is part of the package salvatore-eckel/t3cms.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace SalvatoreEckel\T3cms\DataProcessing;

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
        // The field name to process
        $fieldName = $cObj->stdWrapValue('fieldName', $processorConfiguration);
        if (empty($fieldName) && !$processedData['data']['t3themes_conf']) {
            return $processedData;
        } else {
            $fieldName = 't3themes_conf';
        }

        // Process json data
        $originalValue = $processedData['data'][$fieldName];

        // Set the target variable
        $targetVariableName = $cObj->stdWrapValue('as', $processorConfiguration);
        if (!empty($targetVariableName)) {
            $processedData[$targetVariableName] = $originalValue;
        } else {
            $processedData['data'][$fieldName] = $originalValue;
        }

        return $processedData;
    }
}
