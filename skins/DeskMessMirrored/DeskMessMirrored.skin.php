<?php
/**
 * Desk Mess Mirrored skin -- marble desktop covered with a mix of old and new
 * items, such as some vintage papers, a stainless steel pen, and, a hot cup of
 * coffee!
 *
 * @file
 * @author Edward Caissie <edward.caissie@gmail.com> -- original WordPress theme
 * @author Jack Phoenix <jack@countervandalism.net> -- MediaWiki port
 * @see http://wordpress.org/themes/desk-mess-mirrored
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License version 2
 */

/**
 * Inherit main code from SkinTemplate, set the CSS and template filter.
 *
 * @ingroup Skins
 */
class SkinDeskMessMirrored extends SkinTemplate {
	public $skinname = 'deskmessmirrored', $stylename = 'deskmessmirrored',
		$template = 'DeskMessMirroredTemplate', $useHeadElement = true;

	/**
	 * Initializes Desk Mess Mirrored
	 * @param OutputPage $out
	 */
	public function initPage( OutputPage $out ) {
		parent::initPage( $out );

		global $wgHooks;
		// Add some required classes to the <body> element
		$wgHooks['OutputPageBodyAttributes'][] = function( $out, $sk, &$bodyAttrs ) {
			$bodyAttrs['class'] .= ' home blog custom-background';
			return true;
		};
	}

	function setupSkinUserCss( OutputPage $out ) {
		global $wgStylePath;

		parent::setupSkinUserCss( $out );

		// Add CSS via ResourceLoader
		$out->addModuleStyles( array(
			'mediawiki.skinning.interface',
			'mediawiki.skinning.content.externallinks',
			'skins.deskmessmirrored'
		) );

		// Internet Explorer fixes (required for IE11 at least)
		$out->addStyle( "{$wgStylePath}/DeskMessMirrored/css/ie.css", 'screen', 'IE' );
	}
}

/**
 * Main Desk Mess Mirrored skin class.
 * @ingroup Skins
 */
class DeskMessMirroredTemplate extends BaseTemplate {
	/**
	 * Template filter callback for the Desk Mess Mirrored skin.
	 * Takes an associative array of data set from a SkinTemplate-based
	 * class, and a wrapper for MediaWiki's localization database, and
	 * outputs a formatted page.
	 */
	public function execute() {
		global $wgContLang, $wgSitename;

		$this->html( 'headelement' );
?><div id="mainwrap">
	<div id="header-container">
		<div id="header"><!-- header -->
			<div id="headerleft"></div>
			<div id="logo">
				<h2 id="site-title">
					<a href="<?php echo $this->data['nav_urls']['mainpage']['href'] ?>" title="<?php echo Linker::titleAttrib( 'p-logo', 'withaccess' ) ?>" accesskey="<?php echo Linker::accesskey( 'p-logo' ) ?>"><?php echo $wgSitename ?></a>
				</h2>
				<p id="site-description"><?php $this->msg( 'tagline' ) ?></p>
			</div><!-- #logo -->
			<div id="cup"></div>
			<div id="top-navigation-menu" class="noprint">
				<ul class="nav-menu">
				<?php
					// Yet another copy of NavigationService until NestedMenuParser makes it into core MW...
					$service = new DeskMessMirroredSkinNavigationService();
					$menuNodes = $service->parseMessage(
						'deskmessmirrored-navigation',
						array( 10, 10, 10, 10, 10, 10 ),
						60 * 60 * 3 // 3 hours
					);

					if ( is_array( $menuNodes ) && isset( $menuNodes[0] ) ) {
						$counter = 0;
						foreach ( $menuNodes[0]['children'] as $level0 ) {
							$hasChildren = isset( $menuNodes[$level0]['children'] );
					?>
					<li class="page_item<?php echo ( $hasChildren ? ' page_item_has_children' : '' ) ?>">
						<a class="nav<?php echo $counter ?>_link" href="<?php echo htmlspecialchars( $menuNodes[$level0]['href'], ENT_QUOTES ) ?>"><?php echo htmlspecialchars( $menuNodes[$level0]['text'], ENT_QUOTES ) ?></a>
						<?php if ( $hasChildren ) { ?>
						<ul class="children">
<?php
							foreach ( $menuNodes[$level0]['children'] as $level1 ) {
?>
							<li class="page_item">
								<a href="<?php echo htmlspecialchars( $menuNodes[$level1]['href'], ENT_QUOTES ) ?>"><?php echo htmlspecialchars( $menuNodes[$level1]['text'], ENT_QUOTES ) ?></a>
<?php
								if ( isset( $menuNodes[$level1]['children'] ) ) {
									echo '<ul class="children">';
									foreach ( $menuNodes[$level1]['children'] as $level2 ) {
?>
									<li class="page_item">
										<a href="<?php echo htmlspecialchars( $menuNodes[$level2]['href'], ENT_QUOTES ) ?>"><?php echo htmlspecialchars( $menuNodes[$level2]['text'], ENT_QUOTES ) ?></a>
									</li>
<?php
									}
									echo '</ul>';
									$counter++;
								}
?>
							</li>
<?php
							}
							echo '</ul>';
							$counter++;
						} // hasChildren
						echo '</li>';
						} // top-level foreach
					} // is_array( $menuNodes )
?>
				</ul>
			</div>
		</div><!-- #header -->
	</div><!-- #header-container -->
	<div id="maintop"></div>
	<div id="wrapper">
		<div id="content">
			<div id="main-blog" class="mw-body">
				<div class="post hentry mw-body-primary">
					<?php $this->cactions(); ?>
					<?php if ( $this->data['sitenotice'] ) { ?><div id="siteNotice"><?php $this->html( 'sitenotice' ) ?></div><?php } ?>
					<h1 id="firstHeading" class="firstHeading"><?php $this->html( 'title' ) ?></h1>
					<!-- @todo FIXME: postdata class on the next two elements is just a test, need to see how it looks like... -->
					<div class="postdata" id="contentSub"<?php $this->html( 'userlangattributes' ) ?>><?php $this->html( 'subtitle' ) ?></div>
					<?php if ( $this->data['undelete'] ) { ?><div class="postdata" id="contentSub2"><?php $this->html( 'undelete' ) ?></div><?php } ?>
					<?php if ( $this->data['newtalk'] ) { ?><div class="usermessage"><?php $this->html( 'newtalk' ) ?></div><?php } ?>
					<div id="jump-to-nav" class="mw-jump"><?php $this->msg( 'jumpto' ) ?> <a href="#column-one"><?php $this->msg( 'jumptonavigation' ) ?></a><?php $this->msg( 'comma-separator' ) ?><a href="#searchInput"><?php $this->msg( 'jumptosearch' ) ?></a></div>
					<!-- start content -->
					<?php
					$this->html( 'bodytext' );
					if ( $this->data['catlinks'] ) {
						$this->html( 'catlinks' );
					}
					?>
					<!-- end content -->
					<div class="clear"><!-- For inserted media at the end of the post --></div>
					<?php if ( $this->data['dataAfterContent'] ) { $this->html( 'dataAfterContent' ); } ?>
				</div><!-- .post #post-ID -->

				<div id="nav-global" class="navigation">
					<div class="left"></div>
					<div class="right"></div>
				</div>
			</div><!-- end #main-blog -->

			<div id="sidebar" class="noprint">
				<div id="sidebar-top"></div>
				<div id="sidebar-content">
					<div id="subcolumn">
						<ul>
							<?php $this->renderPortals( $this->data['sidebar'] ); ?>
							<li class="widget" id="p-personal">
								<h2 class="widgettitle"><?php $this->msg( 'personaltools' ) ?></h2>
								<ul>
								<?php
									foreach ( $this->getPersonalTools() as $key => $item ) {
										echo $this->makeListItem( $key, $item );
									}
								?>
								</ul>
							</li>
						</ul>
					</div><!-- #subcolumn -->
				</div><!-- #sidebar-content -->
				<div id="sidebar-bottom"></div>
			</div><!-- #sidebar -->

			<div class="clear"></div>
		</div><!-- end content -->
	</div><!-- end wrapper -->

	<div id="bottom"></div>
	<div id="bottom-extended">
		<div id="bottom-container">
			<p>
				<?php
				if ( isset( $this->data['copyright'] ) && $this->data['copyright'] ) :
				?>
				<span id="dmm-dynamic-copyright"><?php echo $this->data['copyright'] ?></span><!-- #bns-dynamic-copyright --><br /><?php endif; ?><span id="dmm-theme-version" class="noprint"><?php
				foreach ( $this->getFooterIcons( 'nocopyright' ) as $blockName => $footerIcons ) {
					foreach ( $footerIcons as $icon ) {
						echo $this->getSkin()->makeFooterIcon( $icon, 'withoutImage' );
					}
				}
				?></span>
			</p>
		</div><!-- #bottom-container -->
	</div><!-- #bottom-extended -->
</div><!-- #mainwrap -->
<?php
		$this->printTrail();
		echo Html::closeElement( 'body' );
		echo Html::closeElement( 'html' );
	} // end of execute() method

	/*************************************************************************************************/

	/**
	 * @param $sidebar array
	 */
	protected function renderPortals( $sidebar ) {
		if ( !isset( $sidebar['SEARCH'] ) ) {
			$sidebar['SEARCH'] = true;
		}
		if ( !isset( $sidebar['TOOLBOX'] ) ) {
			$sidebar['TOOLBOX'] = true;
		}
		if ( !isset( $sidebar['LANGUAGES'] ) ) {
			$sidebar['LANGUAGES'] = true;
		}

		foreach ( $sidebar as $boxName => $content ) {
			if ( $content === false ) {
				continue;
			}

			if ( $boxName == 'SEARCH' ) {
				$this->searchBox();
			} elseif ( $boxName == 'TOOLBOX' ) {
				$this->toolbox();
			} elseif ( $boxName == 'LANGUAGES' ) {
				$this->languageBox();
			} else {
				$this->customBox( $boxName, $content );
			}
		}
	}

	/**
	 * Outputs the search box.
	 */
	function searchBox() {
?>
							<li id="search-3" class="widget widget_search"><h2 class="widgettitle"></h2>
							<form role="search" method="get" id="searchform" class="searchform" action="<?php $this->text( 'wgScript' ) ?>">
								<div>
									<input type="hidden" name="title" value="<?php $this->text( 'searchtitle' ) ?>"/>
									<label class="screen-reader-text" for="searchInput"><?php $this->msg( 'search' ) ?></label>
									<?php
										echo $this->makeSearchInput( array( 'id' => 'searchInput' ) );
										#$fullText = $this->makeSearchButton( 'fulltext', array( 'id' => 'mw-searchButton', 'class' => 'searchButton' ) );
										$goButton = $this->makeSearchButton( 'go', array( 'id' => 'searchGoButton', 'class' => 'searchButton' ) );
										// Fulltext search button removed, it looks bad together w/ the
										// "Go" button since they both just don't fit in there
										#echo $fullText . "\n";
										echo $goButton . "\n";
									?>&#160;
								</div>
							</form>
							</li>
<?php
	}

	/**
	 * Outputs the content actions bar.
	 */
	function cactions() {
?>
								<div id="p-cactions" class="noprint">
<?php
		foreach ( $this->data['content_actions'] as $key => $tab ) {
			echo $this->makeListItem( $key, $tab );
		}
		echo '</div>';
	}

	/**
	 * Outputs the toolbox.
	 */
	function toolbox() {
?>
							<li id="p-toolbox" class="widget">
								<h2 class="widgettitle"><?php $this->msg( 'toolbox' ) ?></h2>
								<ul>
<?php
		foreach ( $this->getToolbox() as $key => $tbitem ) {
			echo $this->makeListItem( $key, $tbitem );
		}

		Hooks::run( 'SkinTemplateToolboxEnd', array( &$this, true ) );
		echo '</ul>';
	} // toolbox()

	function languageBox() {
		if ( $this->data['language_urls'] ) {
?>
							<li class="widget" id="p-languages">
								<h2 class="widget-title"<?php $this->html( 'userlangattributes' ) ?>><?php $this->msg( 'otherlanguages' ) ?></h2>
								<ul>
<?php
			foreach ( $this->data['language_urls'] as $key => $langLink ) {
				echo $this->makeListItem( $key, $langLink );
			} // foreach
			echo '</ul>';
		} // if
	} // languageBox()

	/**
	 * @param $bar string
	 * @param $cont array|string
	 */
	function customBox( $bar, $cont ) {
		$portletAttribs = array(
			'class' => 'generated-sidebar widget',
			'id' => Sanitizer::escapeId( "p-$bar" ),
			'role' => 'navigation'
		);
		$msg = wfMessage( $bar );
		echo '	' . Html::openElement( 'li', $portletAttribs );
?>
		<h2 class="widget-title"><?php echo htmlspecialchars( $msg->exists() ? $msg->text() : $bar ); ?></h2>
<?php	if ( is_array( $cont ) ) {
			echo '<ul>';
			foreach ( $cont as $key => $val ) {
				echo $this->makeListItem( $key, $val );
			}
			echo '</ul>';
		} else {
			// allow raw HTML block to be defined by extensions (such as NewsBox)
			echo $cont;
		}
		echo '</li>';
	} // customBox()

} // end of the DeskMessMirroredTemplate class

/**
 * A fork of Oasis' NavigationService with some changes.
 * Namely the name was changed and "magic word" handling was removed from
 * parseMessage() and some (related) unused functions were also removed.
 */
class DeskMessMirroredSkinNavigationService {

	const version = '0.01';

	/**
	 * Parses a system message by exploding along newlines.
	 *
	 * @param $messageName String: name of the MediaWiki message to parse
	 * @param $maxChildrenAtLevel Array:
	 * @param $duration Integer: cache duration for memcached calls
	 * @param $forContent Boolean: is the message we're supposed to parse in
	 *								the wiki's content language (true) or not?
	 * @return Array
	 */
	public function parseMessage( $messageName, $maxChildrenAtLevel = array(), $duration, $forContent = false ) {
		global $wgLang, $wgContLang, $wgMemc;

		$this->forContent = $forContent;

		$useCache = $wgLang->getCode() == $wgContLang->getCode();

		if ( $useCache || $this->forContent ) {
			$cacheKey = wfMemcKey( $messageName, self::version );
			$nodes = $wgMemc->get( $cacheKey );
		}

		if ( empty( $nodes ) ) {
			if ( $this->forContent ) {
				$lines = explode( "\n", wfMessage( $messageName )->inContentLanguage()->text() );
			} else {
				$lines = explode( "\n", wfMessage( $messageName )->text() );
			}
			$nodes = $this->parseLines( $lines, $maxChildrenAtLevel );

			if ( $useCache || $this->forContent ) {
				$wgMemc->set( $cacheKey, $nodes, $duration );
			}
		}

		return $nodes;
	}

	/**
	 * Function used by parseMessage() above.
	 *
	 * @param $lines String: newline-separated lines from the supplied MW: msg
	 * @param $maxChildrenAtLevel Array:
	 * @return Array
	 */
	private function parseLines( $lines, $maxChildrenAtLevel = array() ) {
		$nodes = array();

		if ( is_array( $lines ) && count( $lines ) > 0 ) {
			$lastDepth = 0;
			$i = 0;
			$lastSkip = null;

			foreach ( $lines as $line ) {
				// we are interested only in lines that are not empty and start with asterisk
				if ( trim( $line ) != '' && $line{0} == '*' ) {
					$depth = strrpos( $line, '*' ) + 1;

					if ( $lastSkip !== null && $depth >= $lastSkip ) {
						continue;
					} else {
						$lastSkip = null;
					}

					if ( $depth == $lastDepth + 1 ) {
						$parentIndex = $i;
					} elseif ( $depth == $lastDepth ) {
						$parentIndex = $nodes[$i]['parentIndex'];
					} else {
						for ( $x = $i; $x >= 0; $x-- ) {
							if ( $x == 0 ) {
								$parentIndex = 0;
								break;
							}
							if ( $nodes[$x]['depth'] <= $depth - 1 ) {
								$parentIndex = $x;
								break;
							}
						}
					}

					if ( isset( $maxChildrenAtLevel[$depth - 1] ) ) {
						if ( isset( $nodes[$parentIndex]['children'] ) ) {
							if ( count( $nodes[$parentIndex]['children'] ) >= $maxChildrenAtLevel[$depth - 1] ) {
								$lastSkip = $depth;
								continue;
							}
						}
					}

					$node = $this->parseOneLine( $line );
					$node['parentIndex'] = $parentIndex;
					$node['depth'] = $depth;

					$nodes[$node['parentIndex']]['children'][] = $i + 1;
					$nodes[$i + 1] = $node;
					$lastDepth = $node['depth'];
					$i++;
				}
			}
		}

		return $nodes;
	}

	/**
	 * @param $line String: line to parse
	 * @return Array
	 */
	private function parseOneLine( $line ) {
		// trim spaces and asterisks from line and then split it to maximum two chunks
		$lineArr = explode( '|', trim( $line, '* ' ), 2 );

		// trim [ and ] from line to have just http://en.wikipedia.org instead of [http://en.wikipedia.org] for external links
		$lineArr[0] = trim( $lineArr[0], '[]' );

		if ( count( $lineArr ) == 2 && $lineArr[1] != '' ) {
			$link = trim( wfMessage( $lineArr[0] )->inContentLanguage()->text() );
			$desc = trim( $lineArr[1] );
		} else {
			$link = $desc = trim( $lineArr[0] );
		}

		$text = $this->forContent ? wfMessage( $desc )->inContentLanguage() : wfMessage( $desc );
		if ( $text->isDisabled() ) {
			$text = $desc;
		}

		if ( wfMessage( $lineArr[0] )->isDisabled() ) {
			$link = $lineArr[0];
		}

		if ( preg_match( '/^(?:' . wfUrlProtocols() . ')/', $link ) ) {
			$href = $link;
		} else {
			if ( empty( $link ) ) {
				$href = '#';
			} elseif ( $link{0} == '#' ) {
				$href = '#';
			} else {
				$title = Title::newFromText( $link );
				if ( is_object( $title ) ) {
					$href = $title->fixSpecialName()->getLocalURL();
				} else {
					$href = '#';
				}
			}
		}

		return array(
			'original' => $lineArr[0],
			'text' => $text,
			'href' => $href
		);
	}

} // end of the DeskMessMirroredSkinNavigationService class
