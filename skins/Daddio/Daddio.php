<?php
/**
 * Daddio skin.
 *
 * @file
 * @ingroup Skins
 * @author Rufus Post
 * @author Aaron Schulz
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 *
 * To install place the Daddio folder (the folder containing this file!) into
 * skins/ and add this line to your wiki's LocalSettings.php:
 * wfLoadSkin( 'Daddio' );
 */

if ( function_exists( 'wfLoadSkin' ) ) {
	wfLoadSkin( 'Daddio' );
	// Keep i18n globals so mergeMessageFileList.php doesn't break
	$wgMessagesDirs['Daddio'] = __DIR__ . '/i18n';
	wfWarn(
		'Deprecated PHP entry point used for Daddio skin. Please use wfLoadSkin instead, ' .
		'see https://www.mediawiki.org/wiki/Extension_registration for more details.'
	);
	return;
} else {
	die( 'This version of the Daddio skin requires MediaWiki 1.25+' );
}
