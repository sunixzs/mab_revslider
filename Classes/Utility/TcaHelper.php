<?php

namespace LBR\MabRevslider\Utility;

use \TYPO3\CMS\Extbase\Utility\ArrayUtility;

/**
 * @package mab_revslider
 */
class TcaHelper {
	/**
	 * @var array $showitems
	 */
	protected $showitems = [ ];
	
	/**
	 * @param string $showitemsString
	 */
	public function setShowitems($showitemsString) {
		$this->showitems = [ ];
		$showitemsArr = ArrayUtility::trimExplode ( ",", $showitemsString, true );
		$divs = 0;
		$linebreaks = 0;
		foreach ( $showitemsArr as $showitem ) {
			if (substr ( $showitem, 0, 11 ) === "--palette--") {
				$parts = ArrayUtility::trimExplode ( ";", $showitem, true );
				$this->showitems[ end ( $parts ) ] = $showitem;
			} else if (substr ( $showitem, 0, 7 ) === "--div--") {
				$divs ++;
				$this->showitems[ "--div--" . $divs ] = $showitem;
			} else if (substr ( $showitem, 0, 13 ) === "--linebreak--") {
				$linebreaks ++;
				$this->showitems[ "--linebreak--" . $linebreaks ] = $showitem;
			} else {
				$parts = ArrayUtility::trimExplode ( ";", $showitem, true );
				$this->showitems[ $parts[ 0 ] ] = $showitem;
			}
		}
	}
	
	/**
	 * @return array
	 */
	public function getShowitems() {
		return $this->showitems;
	}
	
	/**
	 * @return array
	 */
	public function getShowitemsString() {
		return implode ( ",", $this->showitems );
	}
	
	/**
	 * @param array $keysToBeRemoved
	 * @return void
	 */
	public function removeShowitems($keysToBeRemoved) {
		foreach ( $keysToBeRemoved as $key ) {
			if (isset ( $this->showitems[ $key ] )) {
				unset ( $this->showitems[ $key ] );
			}
		}
	}
	
	/**
	 * @param string $showitemToAdd
	 * @param string $keyOfPreviousShowitem
	 * @return void
	 */
	public function addShowitemAfter($showitemToAdd, $keyOfPreviousShowitem) {
		$tmpShowitems = [ ];
		$addedShowItems = 0;
		foreach ( $this->showitems as $key => $showitem ) {
			$tmpShowitems[ $key ] = $showitem;
			if ($key == $keyOfPreviousShowitem) {
				$addedShowItems ++;
				$tmpShowitems[ "addedShowItem" . $addedShowItems ] = $showitemToAdd;
			}
		}
		$this->showitems = $tmpShowitems;
	}
	
	/**
	 * @param array $showitemsToAdd
	 * @param string $keyOfPreviousShowitem
	 * @return void
	 */
	public function addShowitemsAfter($showitemsToAdd, $keyOfPreviousShowitem) {
		$tmpShowitems = [ ];
		$addedShowItems = 0;
		foreach ( $this->showitems as $key => $showitem ) {
			$tmpShowitems[ $key ] = $showitem;
			if ($key == $keyOfPreviousShowitem) {
				foreach ( $showitemsToAdd as $showitemToAdd ) {
					$addedShowItems ++;
					$tmpShowitems[ "addedShowItem" . $addedShowItems ] = $showitemToAdd;
				}
			}
		}
		$this->showitems = $tmpShowitems;
	}
	
	/**
	 * @param string $showitemToBeReplaced
	 * @param string $showitemToReplace
	 * @return void
	 */
	public function replaceShowitem($showitemToBeReplaced, $showitemToReplace) {
		$tmpShowitems = [ ];
		$replacedShowItems = 0;
		foreach ( $this->showitems as $key => $showitem ) {
			if ($key == $showitemToBeReplaced) {
				$replacedShowItems ++;
				$tmpShowitems[ "replacedShowItem" . $replacedShowItems ] = $showitemToReplace;
			} else {
				$tmpShowitems[ $key ] = $showitem;
			}
		}
		$this->showitems = $tmpShowitems;
	}
}
?>