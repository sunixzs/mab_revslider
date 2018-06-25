<?php
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

/** @var \LBR\MabRevslider\Utility\TcaHelper $tcaHelper */
$tcaHelper = GeneralUtility::makeInstance(\LBR\MabRevslider\Utility\TcaHelper::class);

/**
 * Content Element: Revolutionslider
 */

// Adds the content element to the "Type" dropdown
ExtensionManagementUtility::addPlugin(
    [
        "LLL:EXT:mab_revslider/Resources/Private/Language/locallang_db.xlf:plugin.Revolutionslider",
        "mabrevslider_revolutionslider",
        "EXT:mab_revslider/Resources/Public/Icons/ContentElements/revolutionslider.png"
    ],
    "CType",
    "mab_revslider"
);

// Configure the default backend fields for the content element
$tcaHelper->setShowitems($GLOBALS[ "TCA" ][ "tt_content" ][ "types" ][ "text" ][ "showitem" ]);
$tcaHelper->replaceShowitem("bodytext", "bodytext;Revolutionslider Visual Builder Alias");
$GLOBALS[ "TCA" ][ "tt_content" ][ "types" ][ "mabcontentelements_revolutionslider" ][ "showitem" ] = $tcaHelper->getShowitemsString();
$GLOBALS[ "TCA" ][ "tt_content" ][ "types" ][ "mabcontentelements_revolutionslider" ][ "columnsOverrides" ][ "bodytext" ][ "config" ] = [
	'type' => 'input',
	'size' => 50,
	'max' => 255,
	'eval' => "required",
	'enableRichtext' => false
];
$GLOBALS[ "TCA" ][ "tt_content" ][ "ctrl" ][ "typeicon_classes" ][ "mabrevslider_revolutionslider" ] = "mabrevslider-revolutionslider";