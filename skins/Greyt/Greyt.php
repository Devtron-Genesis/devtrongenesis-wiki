<?php
/*
 * Keep in mind that this skin is still in beta stage and it may come to problems!
 * Denke daran, dass dieser sich dieser Skin im Beta-Stadium befindet und es zu Problemen kommen kann!
 */

if (!function_exists('wfLoadSkin')) {
	die('Der Greyt-Skin benötigt zur einwandfreien Verwendung MediaWiki in der Version 1.25 oder höher.');
}

$wgExtensionCredits['skin'][] = array(
	'path' => __FILE__,
	'name' => 'Greyt',
	'namemsg' => 'skinname-greyt',
	'version' => '0.9',
	'url' => 'https://www.mediawiki.org/wiki/Skin:Greyt',
	'author' => '[http://www.pokewiki.de/Benutzer:Xavier Xavier]',
	'descriptionmsg' => 'greyt-description',
	'license' => 'GPLv3+',
);

$wgValidSkinNames['greyt'] = 'Greyt';

$wgAutoloadClasses['SkinGreyt'] = __DIR__ . '/Greyt-HTML.php';
$wgMessagesDirs['Greyt'] = __DIR__ . '/i18n';

$wgResourceModules['skins.greyt'] = array(
	'position' => 'top',
	'styles' => array(
		'Greyt/Ressourcen/stylesheet.css' => array('media' => 'screen'),
	),
	'remoteBasePath' => &$GLOBALS['wgStylePath'],
	'localBasePath' => &$GLOBALS['wgStyleDirectory'],
);
?>
