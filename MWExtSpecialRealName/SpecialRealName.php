<?php
/***
    This file is part of mediawiki-special-realname.

    mediawiki-special-realname
    Copyright (C) 2015  Xiaodu @ Du9L.com

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
***/

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
