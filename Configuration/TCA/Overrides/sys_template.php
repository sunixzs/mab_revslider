<?php
// Add an entry in the static template list found in sys_templates for static TS
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile ( 'mab_revslider', 'Configuration/TypoScript', 'Default' );

// A simple palette for file-references
//$GLOBALS[ 'TCA' ][ 'sys_file_reference' ][ 'palettes' ][ 'tx_mabcontentelements_simpleImageoverlayPalette' ] = array (
//	'showitem' => 'title,alternative,--linebreak--,crop'
//);

// A simple palette for file-references
//$GLOBALS[ 'TCA' ][ 'sys_file_reference' ][ 'palettes' ][ 'tx_mabcontentelements_ImageoverlayPalette' ] = array (
//	'showitem' => 'title,alternative,--linebreak--,description,--linebreak--,crop'
//);