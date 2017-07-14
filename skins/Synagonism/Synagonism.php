<?php
if ( function_exists( 'wfLoadSkin' ) ) {
	wfLoadSkin( 'Synagonism' );
	/*wfWarn(
		'Deprecated PHP entry point used for Synagonism skin. Please use wfLoadSkin instead, ' .
		'see https://www.mediawiki.org/wiki/Extension_registration for more details.'
	);*/
	return;
} else {
	die( 'This version of the Synagonism skin requires MediaWiki 1.25+' );
}
