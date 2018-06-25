<?php
if (! defined('TYPO3_MODE')) {
    die('Access denied.');
}

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Imaging\IconRegistry;
//use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;
use TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider;

if (TYPO3_MODE == "BE") {
    // add type icons ...
    $iconRegistry = GeneralUtility::makeInstance(IconRegistry::class);
    $iconRegistry->registerIcon(
        'mabrevslider-revolutionslider',
        BitmapIconProvider::class,
        [
            'source' => 'EXT:mab_revslier/Resources/Public/Icons/ContentElements/revolutionslider.png'
        ]
    );
}
