<?php

if ( function_exists( 'wfLoadSkin' ) ) {
	wfLoadSkin( 'Blueprint' );
	// Keep i18n globals so mergeMessageFileList.php doesn't break
	$wgMessagesDirs['Blueprint'] = __DIR__ . '/i18n';
	/* wfWarn(
		'Deprecated PHP entry point used for Blueprint skin. Please use wfLoadSkin instead, ' .
		'see https://www.mediawiki.org/wiki/Extension_registration for more details.'
	); */
	return;
} else {
	die( 'This version of the Blueprint skin requires MediaWiki 1.25+' );
}
