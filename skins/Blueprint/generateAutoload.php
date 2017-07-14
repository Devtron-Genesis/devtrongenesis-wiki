<?php

require_once __DIR__ . '/../../includes/utils/AutoloadGenerator.php';

function wfMain() {
	$base = __DIR__;
	$generator = new AutoloadGenerator( $base );
	$generator->readDir( "$base/src" );

	$generator->generateAutoload( $base );

	echo "Done.\n\n";
}

wfMain();
