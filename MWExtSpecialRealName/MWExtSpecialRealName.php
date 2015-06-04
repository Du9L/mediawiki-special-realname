<?php
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
	'url' => 'http://du9l.com/',
	'descriptionmsg' => 'redirect to the user page of a given real name',
	'version' => '0.1',
);

$wgAutoloadClasses['SpecialRealName'] = __DIR__ . '/SpecialRealName.php';
$wgMessagesDirs['MWExtSpecialRealName'] = __DIR__ . "/i18n";
$wgExtensionMessagesFiles['MWExtSpecialRealNameAlias'] = __DIR__ . '/MWExtSpecialRealName.alias.php';
$wgSpecialPages['RealName'] = 'SpecialRealName';

