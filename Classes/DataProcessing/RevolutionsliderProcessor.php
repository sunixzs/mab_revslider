<?php

namespace MAB\MabRevslider\DataProcessing;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class for data processing for the content element "Buttonbox"
 */
class RevolutionsliderProcessor implements DataProcessorInterface
{


    /**
     * Process data for the content element "My new content element"
     *
     * @param ContentObjectRenderer $cObj The data of the content element or page
     * @param array $contentObjectConfiguration The configuration of Content Object
     * @param array $processorConfiguration The configuration of this processor
     * @param array $processedData Key/value store of processed data (e.g. to be passed to a Fluid View)
     * @return array the processed data as key/value store
     */
    public function process(ContentObjectRenderer $cObj, array $contentObjectConfiguration, array $processorConfiguration, array $processedData)
    {
        // check for revslider path
        if (isset($processorConfiguration[ 'path' ]) == false || trim($processorConfiguration[ 'path' ]) == "") {
            $processedData[ 'content' ] = "ERROR: tt_content.mabrevslider_revolutionslider.dataProcessing.1.path is not defined!";
            return $processedData;
        }

        if (is_dir(PATH_site . $processorConfiguration[ 'path' ]) === false) {
            $processedData[ 'content' ] = "ERROR: Could not find directory '" . htmlentities($processorConfiguration[ 'path' ]) . "' which is defined in tt_content.mabrevslider_revolutionslider.dataProcessing.1.path!";
            return $processedData;
        }

        if (is_file(PATH_site . $processorConfiguration[ 'path' ] . "embed.php") === false) {
            $processedData[ 'content' ] = "ERROR: Could not find file  '" . htmlentities($processorConfiguration[ 'path' ]) . "embed.php'!";
            return $processedData;
        }

        // Header
        $processedData[ 'header' ] = str_replace("|", "&shy;", htmlspecialchars($processedData[ "data" ][ "header" ]));

        // alias / bodytext
        $alias = trim($processedData[ "data" ][ "bodytext" ]);
        if ($alias == "") {
            $processedData[ 'content' ] = "ERROR: You have to define the Alias from the slider to be shown. You find it in the visual builder plugin!";
            return $processedData;
        }
        // include revolutionslider contents...
        $hostPath = $cObj->getTypoLink_URL($processorConfiguration[ 'path' ]);
        include PATH_site . $processorConfiguration[ 'path' ] . 'embed.php';
        

        if (isset($processorConfiguration[ 'useIframe' ]) && ( bool )$processorConfiguration[ 'useIframe' ] === true) {
            // build iframe html
            ob_start();
            \RevSliderEmbedder::headIncludes();
            $head_include = ob_get_clean();
            ob_start();
            \RevSliderEmbedder::putRevSlider($alias);
            $body_include = ob_get_clean();
            $iframe_html = <<<EOT
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
{$head_include}
<script>
if ( self === top ) {
	location.href = "/";
}

// some other domain loading my page?
try {
	var prop = top.location.href;
} catch(e) {
	//alert( e.message );
	self.location = 'about:blank';
}

var sendHeight = function(){
	height = jQuery('body').outerHeight(true);
	window.parent.postMessage({height: height}, "*");
}

jQuery(document).on('ready', sendHeight);
jQuery(window).on('resize', sendHeight);
</script>
</head>
<body style="margin: 0;">
{$body_include}
</body>
</html>
EOT;
        
            ob_start();
            echo $iframe_html;
            $revsliderHtml = ob_get_clean();
            
            // build temporary file
            $hash = sha1($revsliderHtml);
            $iframe_filename = "mab_revolutionslider" . $hash . ".html";
            $iframe_path = PATH_site . "typo3temp" . DIRECTORY_SEPARATOR . "mab_revslider" . DIRECTORY_SEPARATOR;
            $iframe_filepath = $iframe_path . $iframe_filename;
            $iframe_src = $cObj->getTypoLink_URL("typo3temp/mab_revslider/" . $iframe_filename);
            
            if (!is_dir($iframe_path)) {
                mkdir(iframe_path);
            }

            // create file with html iframe content, if not exists
            if (!is_file($iframe_filepath)) {
                file_put_contents($iframe_filepath, $revsliderHtml);
            }
            
            // build output html
            $html = <<<EOT
<iframe src="{$iframe_src}" width="100%" height="600" frameborder="0" scrolling="no" id="revolutionslider_{$hash}" style="overflow: hidden;"></iframe>
<script>
window.addEventListener('message', function(event) {
	if(height = event.data['height']) {
		document.getElementById("revolutionslider_{$hash}").style.height = height + "px";
	}
})
</script>
EOT;
        
            $processedData[ 'content' ] = $html;
        } elseif (isset($processorConfiguration[ 'includeDefaultRevolutionsliderHeader' ]) && ( bool )$processorConfiguration[ 'includeDefaultRevolutionsliderHeader' ] === true) {
            ob_start();
            \RevSliderEmbedder::headIncludes();
            \RevSliderEmbedder::putRevSlider($alias);
            $processedData[ 'content' ] = ob_get_clean();
        } else {
            ob_start();
            \RevSliderEmbedder::headIncludes(false);
            \RevSliderEmbedder::putRevSlider($alias);
            $processedData[ 'content' ] = ob_get_clean();
        }

        return $processedData;
    }
}
