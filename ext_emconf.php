<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "lbr_lesscss".
 *
 * Auto generated 06-11-2014 20:35
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/
$EM_CONF[ $_EXTKEY ] = array(
    'title' => 'MAB Revslider',
    'description' => 'Adds a content element for revolutionslider plugin.',
    'category' => 'distribution',
    'version' => '1.0.0',
    'state' => 'beta',
	'uploadfolder' => false,
	'createDirs' => 'typo3temp/mab_revslider',
    'modify_tables' => 'tt_content',
    'clearcacheonload' => true,
    'author' => 'Marcel Briefs',
    'author_email' => 't3@lbrmedia.net',
    'author_company' => 'LBRmedia',
    'constraints' => array(
        'depends' => array(
            'typo3' => '7.6.0-8.99.99'
        ),
        'conflicts' => array(),
        'suggests' => array()
    )
);
