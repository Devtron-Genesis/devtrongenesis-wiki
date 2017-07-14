$( function () {
	var $appendTo = $( '#sidebar .sidebar-toc-active' );

	if ( !$appendTo.length ) {
		$appendTo = $( '#sidebar' );
	}

	$( '#toc' )
		.detach()
		.addClass( 'sidebar-toc' )
		.appendTo( $appendTo );
} );
