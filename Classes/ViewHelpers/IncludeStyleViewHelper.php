<?php

namespace SalvatoreEckel\T3cms\ViewHelpers;

/**
 * This file is part of the "T3cms" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3\CMS\Fluid\Core\ViewHelper\Facets\CompilableInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/**
 * ViewHelper to include a css style code
 *
 * # Example: Basic example
 * <code>
 * <se:includeStyle value="{settings.cssFile}" />
 * </code>
 * <output>
 * This will include the css style code provided by {settings} in the header
 * </output>
 *
 */
class IncludeStyleViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper implements CompilableInterface
{
    use CompileWithRenderStatic;

    /**
     */
    public function initializeArguments()
    {
        $this->registerArgument('name', 'string', 'Unique identifier', true);
        $this->registerArgument('css', 'string', 'CSS Code which should be included', false);
        $this->registerArgument('compress', 'bool', 'Define if file should be compressed', false, false);
        $this->registerArgument('forceOnTop', 'bool', 'Define if css code should be forced to top position', false, false);
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext) {
        $name = $arguments['name'];
        $cssStyleCode = $arguments['css'];
        $compress = (bool)$arguments['compress'];
        $forceOnTop = false;

        if (!empty($cssStyleCode)) {
            $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
            $pageRenderer->addCssInlineBlock($name,$cssStyleCode,$compress,$forceOnTop);
        }
    }
}
