<?php

# Extension Manager/Repository config file for ext: "t3cms"

$EM_CONF[$_EXTKEY] = array(
	'title' => 'TYPO3 Content Management System',
	'description' => 'Hardly inspired by high quality wordpress themes. EXT:t3cms combines -easy to use- with powerfull tools.',
	'category' => 'module',
	'author' => 'Salvatore Eckel',
	'author_email' => 'salvaracer@gmx.de',
	'author_company' => '',
	'state' => 'beta',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'clearCacheOnLoad' => 0,
	'version' => '1.0.0',
	'constraints' => array(
		'depends' => array(
			'typo3' => '7.6.0-8.99.99',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
);
