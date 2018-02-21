<?php

# Extension Manager/Repository config file for ext: "t3cms"

$EM_CONF[$_EXTKEY] = [
	'title' => 'TYPO3 Content Management System - Set up your homepages easier with it!',
	'description' => 'Works with all famous dists and sitepackages. Hardly inspired by high quality wordpress themes. EXT:t3cms combines -easy to use- with powerfull tools.',
	'category' => 'module',
	'author' => 'Salvatore Eckel',
	'author_email' => 'salvaracer@gmx.de',
	'author_company' => '',
	'state' => 'beta',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'clearCacheOnLoad' => 1,
	'version' => '2.0.0',
	'constraints' => [
		'depends' => [
			'typo3' => '8.7.4-9.99.99',
		],
		'conflicts' => [
		],
		'suggests' => [
		],
	],
];
