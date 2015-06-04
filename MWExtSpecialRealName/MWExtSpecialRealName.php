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

if ( !defined( 'MEDIAWIKI' ) ) {
	echo <<<EOF
To install this extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/MWExtSpecialRealName/MWExtSpecialRealName.php" );
EOF;
	exit(1);
}

$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'MWExtSpecialRealName',
	'author' => 'Xiaodu @ Du9L.com',
	'url' => 'https://github.com/Du9L/mediawiki-special-realname',
	'description' => 'redirect to the user page of a given real name',
	'version' => '0.1',
	'license-name' => 'GPLv3, https://github.com/Du9L/mediawiki-special-realname/blob/master/LICENSE',
);

$wgAutoloadClasses['SpecialRealName'] = __DIR__ . '/SpecialRealName.php';
$wgMessagesDirs['MWExtSpecialRealName'] = __DIR__ . "/i18n";
$wgExtensionMessagesFiles['MWExtSpecialRealNameAlias'] = __DIR__ . '/MWExtSpecialRealName.alias.php';
$wgSpecialPages['RealName'] = 'SpecialRealName';

