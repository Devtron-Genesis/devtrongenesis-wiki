<?php

class BlueprintSkinTemplate extends QuickTemplate {
	public function execute() {
		$this->data['wiki_homepage_url'] = $this->getWikiHomepageURL();
		$this->data['getdebughtml'] = MWDebug::getDebugHTML( $this->getSkin()->getContext() );
		$this->data['left_nav_sections'] = $this->getLinks( 'left-nav' );
		$this->data['footer_links'] = $this->getLinks( 'footer' );
		// Get username for the user menu button
		$personal_urls = $this->data['personal_urls'];
		if ( isset( $personal_urls['userpage'] ) ) {
			$this->data['username'] = $personal_urls['userpage']['text'];
		} elseif ( isset( $personal_urls['anonuserpage'] ) ) {
			$this->data['username'] = $personal_urls['anonuserpage']['text'];
		} else {
			$this->data['username'] = wfMessage( 'blueprint-anon-username' )->text();
		}
		// Make HTML for page status indicators, copied from BaseTemplate::getIndicators().
		$tmp = "<div class=\"mw-indicators\">\n";
		foreach ( $this->data['indicators'] as $id => $content ) {
			$tmp .= Html::rawElement(
				'div',
				array(
					'id' => Sanitizer::escapeId( "mw-indicator-$id" ),
					'class' => 'mw-indicator',
				),
				$content
			) . "\n";
		}
		$this->data['html_indicators'] = $tmp . "</div>\n";

		// Search Form related functions
		$this->data['search_title'] = Html::hidden( 'title', $this->get( 'searchtitle' ) );
		$this->data['search_label'] = $this->data['search_placeholder'] = wfMessage( 'search' )->plain();

		// Get various i18n strings
		$this->data['blueprint-skip-to-content'] = wfMessage( 'blueprint-skip-to-content' )->text();
		$this->data['blueprint-skip-to-nav'] = wfMessage( 'blueprint-skip-to-nav' )->text();

		$templateParser = new TemplateParser( __DIR__ . '/../templates' );
		try {
			echo $templateParser->processTemplate(
				'Skin',
				$this->data
			);
		} catch ( Exception $e ) {
			echo 'Error: ' . htmlspecialchars( $e->getMessage() );
		}
	}

	// This returns an array of the pages in the leftnav that are specified
	// on-wiki in MediaWiki:blueprint-left-nav. It caches this structure
	// before it makes some dynamic changes.
	protected function getLinks( $list ) {
		global $wgMemc;

		$cacheKey = wfMemcKey( 'blueprint', $list );

		$cacheVal = $wgMemc->get( $cacheKey );

		if ( $cacheVal ) {
			$links = $cacheVal;
		} else {
			$text = wfMessage( 'blueprint-' . $list )->plain();
			$links = array();
			$page_regex = '([^\[\]\|]+)';
			$line_regex = '/^[#*]\s*\[\['.$page_regex.'(?:\|'.$page_regex.')?\]\]$/';

			foreach ( explode( "\n", $text ) as $line ) {
				$matches = null;
				if ( preg_match( $line_regex, $line, $matches ) ) {
					$title = Title::newFromText( $matches[1] );
					$text = isset( $matches[2] ) ? $matches[2] : $matches[1];

					$links[] = array(
						'text' => $text,
						'title' => $title,
						'url' => $title->getFullUrl(),
					);
				}
			}

			$wgMemc->set( $cacheKey, $links, 300 ); // Cache for 300 seconds (5 minutes)
		}

		// Update sidebar structure with the current page after caching.
		$currTitle = Title::newFromText( $this->data['thispage'] );
		// The iteration modifies leftNav items, therefore it accesses by reference.
		foreach ( $links as &$navItem ) {
			// Someone may have used `{{DISPLAYTITLE:}}` to monkey with
			// the current page's title, e.g. to hide or color it; then
			// `data['title']` has the <div> contents in it (T103454).
			// Could use `Sanitizer::stripAllTags( $this->data['title'] )`,
			// but instead use thispage.
			$navItem['current'] = $navItem['title']->equals( $currTitle );
		}

		return $links;
	}

	private function getWikiHomepageURL() {
		return htmlspecialchars( $this->data['nav_urls']['mainpage']['href'] );
	}

	public function getTemplate() {
		$templating = new SimpleLightNCandy( __DIR__ . '/../templates' );

		$templating->addHelper( 'msg',
			function( array $args /*, array $named */ ) {
				$str = array_shift( $args );

				return wfMessage( $str )->params( $args )->text();
			}
		);
		// Helper for CSS class values @see T113566.
		$templating->addHelper( 'stringOrArray',
			function( array $args /*, array $named */ ) {
				if ( is_array( $args[0] ) ) {
					return implode( ' ', $args[0] );
				}
				return $args[0];
			}
		);

		return $templating->getTemplate( 'Skin' );
	}
}
