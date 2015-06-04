<?php
class SpecialRealName extends UnlistedSpecialPage {
	function __construct() {
		parent::__construct( 'RealName' );
	}

	function execute( $subPage ) {
		$request = $this->getRequest();
		$output  = $this->getOutput();
		$this->setHeaders();

		// Multi-byte fallback functions include: mb_substr, mb_strlen & mb_str[r]pos
		$realNameLen = mb_strpos($subPage, '/');
		if ($realNameLen === FALSE) {
			$realName     = $subPage;
			$userPagePath = NULL;
		} else {
			$realName     = mb_substr($subPage, 0, $realNameLen);
			$userPagePath = mb_substr($subPage, $realNameLen+1); 
		}

		if ($realName === '') {
			// No real name provided, error
		} else {
			// Look up in database
		}

		// Test:
		$testWikiText = '* RealName: ' . $realName . '\n* UserPagePath: ' . $userPagePath;
		$output->addWikiText($testWikiText);
	}
}
