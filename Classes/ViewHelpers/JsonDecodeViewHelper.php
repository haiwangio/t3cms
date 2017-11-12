<?php
namespace SalvatoreEckel\T3cms\ViewHelpers;

/*
 *  The MIT License (MIT)
 *
 *  Copyright (c) 2017-2018 Salvatore Eckel <salvaracer@gmx.de>
 *
 *  Permission is hereby granted, free of charge, to any person obtaining a copy
 *  of this software and associated documentation files (the "Software"), to deal
 *  in the Software without restriction, including without limitation the rights
 *  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 *  copies of the Software, and to permit persons to whom the Software is
 *  furnished to do so, subject to the following conditions:
 *
 *  The above copyright notice and this permission notice shall be included in
 *  all copies or substantial portions of the Software.
 *
 *  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 *  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 *  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 *  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 *  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 *  THE SOFTWARE.
 */

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Fluid\Core\ViewHelper\Facets\CompilableInterface;

/**
 * @author Salvatore Eckel <salvaracer@gmx.de>
 */
class JsonDecodeViewHelper extends AbstractViewHelper implements CompilableInterface
{
    /**
     * @var bool
     */
    protected $escapeOutput = false;

    /**
     * Render
     *
     * @param string $data
     * @param string $as
     * @return string
     */
    public function render($data, $as = 'items')
    {
        return self::renderStatic(
            [
                'data' => $data,
                'as' => $as,
            ],
            $this->buildRenderChildrenClosure(),
            $this->renderingContext
        );
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return string
     */
    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ) {
        $content = '';

        # PageRepository
        $sysPage = GeneralUtility::makeInstance(\TYPO3\CMS\Frontend\Page\PageRepository::class);
        $rootline = $sysPage->getRootLine(GeneralUtility::_GP('id'), '', true);

        # Build and merge configuration upin rootpage
        if (!empty($rootline)) {
            $items = json_decode($rootline[0]['t3themes_conf'],1);
            foreach (array_reverse($rootline) as $key => $page) {
                $pageConf = json_decode($page['t3themes_conf'],1);
                if (count($pageConf)) {
                    foreach ($pageConf as $name => $value) {
                        if (!empty($value)) {
                            $items[$name] = $value;
                        }
                    }
                }
            }
        }

        # Merge at least with given json data if given
        if (isset($arguments['data'])) {
            $givenPageConf = json_decode($arguments['data'],1);
            if (count($givenPageConf)) {
                foreach ($givenPageConf as $name => $value) {
                    if (!empty($value)) {
                        $items[$name] = $value;
                    }
                }
            }
        }

        $templateVariableContainer = $renderingContext->getTemplateVariableContainer();
        $templateVariableContainer->add($arguments['as'], $items);
        $content = $renderChildrenClosure();
        $templateVariableContainer->remove($arguments['as']);

        return $content;
    }
}
