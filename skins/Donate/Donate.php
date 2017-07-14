<?php
if ( function_exists( 'wfLoadSkin' ) ) {
	wfLoadExtension( 'Donate' );
	/*wfWarn(
		'Deprecated PHP entry point used for Donate skin. Please use wfLoadSkin instead, ' .
		'see https://www.mediawiki.org/wiki/Extension_registration for more details.'
	);*/
	return;
} else {
	die( 'This version of the Donate skin requires MediaWiki 1.25+' );
}
