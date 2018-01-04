<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

$GLOBALS['TYPO3_CONF_VARS']['FE']['addRootLineFields'] .= ",t3themes_conf";

# Fix issue: https://forge.typo3.org/issues/80541#note-8
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ElementBrowsers']['file_reference'] = "TYPO3\CMS\Recordlist\Browser\FileBrowser";

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('
TCAdefaults.tt_content.sectionIndex = 0
TCEFORM.tt_content {
	layout {
		addItems {
			40 = Wrap with Container
			41 = Wrap with Fluid Container
		}
		altLabels {
			40 = Wrap with Container
			41 = Wrap with Fluid Container
		}
		#types.plugin.removeItems = 5
	}
}
');

# Enable frontend-context plugin
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'SalvatoreEckel.' . $_EXTKEY,
	'T3cms',
	array('Worker' => 'tsnavigations, tssidebars'),
	array('Worker' => 'tsnavigations, tssidebars')
);

# Enable flux
if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('flux')) {
	\FluidTYPO3\Flux\Core::registerProviderExtensionKey('SalvatoreEckel.T3cms', 'Content');
}
