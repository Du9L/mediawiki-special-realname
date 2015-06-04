<?php
class SpecialRealName extends UnlistedSpecialPage {
	function __construct() {
		parent::__construct( 'RealName' );
	}

	protected function _getUserPage( $userRow, $userPagePath ) {
		$title = Title::makeTitle(NS_USER, $userRow['user_name']);
		if ($userPagePath)
			$title = $title->getSubpage($userPagePath);
		return $title;
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
			$output->showErrorPage('error', 'badarticleerror');
		} else {
			// Look up in database
			$dbr = wfGetDB( DB_SLAVE );
			$res = $dbr->select( 'user',
					array('user_id', 'user_name', 'user_real_name'),
					array('user_real_name' => $realName),
					__METHOD__,
					array('ORDER BY' => 'user_id ASC') );
			$resCount = $res->numRows();
			if ($resCount == 0) {
				$output->showErrorPage('error', 'listusers-noresult');
			} elseif ($resCount == 1) {
				// Found one user
				$row = $res->fetchRow();
				$title = $this->_getUserPage($row, $userPagePath);
				$url = $title->getFullURL();
				$output->redirect($url);
			} else {
				// Found multiple users
				$output->setPageTitle($this->getLocalName());
				for ($i = 0; $i != $resCount; $i ++) {
					$row = $res->fetchRow();
					$title = $this->_getUserPage($row, $userPagePath);
					$output->addWikiText("* [[" . $title->getFullText() . "]]\n");
				}
			}
		}
	}
}
