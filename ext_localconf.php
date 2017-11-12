<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

$GLOBALS['TYPO3_CONF_VARS']['FE']['addRootLineFields'] .= ",t3themes_conf";

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'SalvatoreEckel.' . $_EXTKEY,
	'T3cms',
	array('Worker' => 'tsnavigations, tssidebars'),
	array('Worker' => 'tsnavigations, tssidebars')
);

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

