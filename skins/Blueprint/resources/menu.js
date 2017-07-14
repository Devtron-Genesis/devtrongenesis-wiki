$( function () {
	var openSidebar, closeSidebar,
		$sideMenu = $( '#sidebar' ),
		$tocToggle = $( '#toc-toggle' ),
		$extraSpace = $( '#extra-space' ),
		$content = $( '#content' );

	openSidebar = function () {
		var
			sidebarWidth = $sideMenu.width() + 10,
			marginDifference = sidebarWidth - $content.offset().left,
			navBrandWidth = $( '.navbar-head' ).width(),
			contentWidth = $content.width();

		$extraSpace.css( 'width', sidebarWidth - navBrandWidth - 10 );

		$sideMenu.show();

		$tocToggle.addClass( 'close' );

		$content.css( {
			marginLeft: sidebarWidth,
			width: contentWidth - marginDifference
		} );
	};

	closeSidebar = function () {
		$sideMenu.hide();
		$extraSpace.css( 'width', 0 );
		$tocToggle.removeClass( 'close' );
		$content.css( {
			marginLeft: '',
			width: ''
		} );
	};

	$tocToggle.click( function ( e ) {
		e.preventDefault();
		if ( $tocToggle.hasClass( 'close' ) ) {
			closeSidebar();
		} else {
			openSidebar();
		}
	} );
} );
