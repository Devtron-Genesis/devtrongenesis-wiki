<?php

/**
 * Splash skin stuff.
 *
 * @file
 * @ingroup Skins
 * @author Calimonius the Estrange
 * @author Jack Phoenix
 * @authors Whoever wrote monobook
 * @date 2013
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( -1 );
}

/**
 * Inherit main code from SkinTemplate, set the CSS and template filter.
 * @ingroup Skins
 */
class SkinSplash extends SkinTemplate {
	public $skinname = 'splash', $stylename = 'splash',
		$template = 'SplashTemplate', $useHeadElement = true;

	/**
	 * @param $out OutputPage
	 */
	function setupSkinUserCss( OutputPage $out ) {
		global $wgFontCSSLocation;
		parent::setupSkinUserCss( $out );

		# Add css/js
		$out->addModuleStyles( array (
			'mediawiki.skinning.content.externallinks',
			'skins.splash'
		) );
		$out->addModuleScripts( 'skins.splash' );
	}
}

/**
 * Main skin class
 * @ingroup Skins
 */
class SplashTemplate extends BaseTemplate {

	/**
	 * Template filter callback for Splash skin.
	 * Takes an associative array of data set from a SkinTemplate-based
	 * class, and a wrapper for MediaWiki's localization database, and
	 * outputs a formatted page.
	 *
	 * @access private
	 */
	function execute() {
		$user = $this->getSkin()->getUser();

		# Suppress warnings to prevent notices about missing indexes in $this->data
		wfSuppressWarnings();

		$this->html( 'headelement' );
		?>
		<div id="globalWrapper">
		<div id="container-top">
		<div id="container-top-l1">
		<div id="container-top-l2">
		<div id="container-bottom">
		<div id="container-content">
		<div id="header" class="noprint"<?php $this->html( 'userlangattributes' ); ?>>
			<div id="global-links" class="portlet" role="navigation">
				<?php
				# Menu for global navigation (between wiki and other things)
				if ( wfMessage( 'global-links-menu' )->escaped() ) {
					$this->renderNavigation( 'global-links-menu', 'main-links' );
				}
				?>
			</div>
			<div id="site-links">
				<div class="portlet" id="p-personal" role="navigation">
					<?php
					# Display status, and make a dropdown if logged in
					if ( $user->isLoggedIn() ) {
						?>
						<div id="p-loggedin">
							<?php echo $user->getName(); ?>
						</div>
						<div class="pBody dropdown">
						<?php
					} else {
						?>
						<div class="pBody no-dropdown">
						<?php
					}
					?>
					<ul<?php $this->html( 'userlangattributes' ) ?>>
					<?php
						foreach ( $this->getPersonalTools() as $key => $item ) {
							echo $this->makeListItem( $key, $item );
						}
					?>
					</ul>
					</div>
				</div>
				<div id="site-navigation">
					<?php $this->renderPortals( $this->data['sidebar'] ); ?>
				</div>
				<?php $this->searchBox(); ?>

			</div>
			<div id="main-logo" role="banner">
			<a href="/"><div id="mainlogo-text"><h1><?php echo wfMessage( 'site-banner' )->parse(); ?></h1></div></a>
		</div>
		</div>
		<div id="page-content">
		<div id="content-container">
		<div id="content" class="mw-body-primary" role="main">
			<a id="top"></a>
			<?php
			if ( $this->data['sitenotice'] ) {
			?>
				<div id="siteNotice">
				<?php
					$this->html( 'sitenotice' )
				?>
				</div>
				<?php
			}

			if ( $this->data['newtalk'] ) {
				if ( $this->data['newtalk'] ) {
					?>
					<div class="usermessage"><?php $this->html( 'newtalk' ) ?></div>
					<?php
				}
			}
			?>
			<h1 id="firstHeading" class="firstHeading" lang="<?php
				$this->data['pageLanguage'] = $this->getSkin()->getTitle()->getPageViewLanguage()->getHtmlCode();
				$this->text( 'pageLanguage' );
				?>">
				<?php $this->cactions(); ?>
				<?php $this->html( 'title' ) ?>
			</h1>
			<?php
			if ( $this->data['subtitle'] || $this->data['undelete'] ) {
			?>
				<div id="contentSub"<?php $this->html( 'userlangattributes' ) ?>>
					<?php $this->html( 'subtitle' ) ?>
				</div>
				<?php
				if ( $this->data['undelete'] ) {
					?>
					<div id="contentSub2"><?php $this->html( 'undelete' ) ?></div>
					<?php
				}
			}
			?>
			<div id="bodyContent" class="mw-body">
				<div id="siteSub"><?php $this->msg( 'tagline' ) ?></div>

				<!-- start content -->
				<?php $this->html( 'bodytext' ) ?>
				<!-- end content -->

				<div class="visualClear"></div>
				<?php if( $this->data['catlinks'] ) { $this->html( 'catlinks' ); } ?>
				<?php if( $this->data['dataAfterContent'] ) { $this->html( 'dataAfterContent' ); } ?>
			</div>
			<div id="content-footer">
				<?php echo wfMessage( 'content-footer' )->parse(); ?>
			</div>
		</div>
		</div>
		</div>
		<?php
			$validFooterIcons = $this->getFooterIcons( "icononly" );
			$validFooterLinks = $this->getFooterLinks( "flat" ); // Additional footer links
			?>
			<div id="footer" role="contentinfo"<?php $this->html('userlangattributes') ?>>
			<?php
			foreach ( $validFooterIcons as $blockName => $footerIcons ) {
				?>
				<div id="f-<?php echo htmlspecialchars( $blockName ); ?>ico" class="footer-icons">
				<?php
				foreach ( $footerIcons as $icon ) {
					?>
					<?php echo $this->getSkin()->makeFooterIcon( $icon );
				}
				?>
				</div>
				<?php
			}
			if ( count( $validFooterLinks ) > 0 ) {
				?>
				<div>
					<ul id="f-list">
					<?php
					foreach( $validFooterLinks as $aLink ) { ?>
						<li id="<?php echo $aLink ?>"><?php $this->html($aLink) ?></li>
					<?php } ?>
					</ul>
				</div>
			<?php } ?>
		</div>
		</div>
		</div>
		</div>
		</div>
		<?php
		$this->printTrail();
		echo Html::closeElement( 'body' );
		echo Html::closeElement( 'html' );
		wfRestoreWarnings();
	} // end of execute() method

	/*************************************************************************************************/

	/**
	 * Print arbitrary block of navigation
	 * @param $linksMessage
	 * @param $blockId
	 * Message parsing is limited to first 10 lines only for this skin.
	 */
	private function renderNavigation( $linksMessage, $blockId ) {
		$message = trim(  wfMessage( $linksMessage )->text() );
		$lines = array_slice( explode( "\n", $message ), 0, 10 );
		$links = array();
		foreach ( $lines as $line ) {
			# ignore empty lines
			if ( strlen( $line ) == 0 ) {
				continue;
			}
			$links[] = $this->parseItem( $line );
		}

		$this->customBox( $blockId, $links );
	}

	/**
	 * Extract the link text and destination (href) from a MediaWiki message
	 * and return them as an array.
	 */
	private function parseItem( $line ) {
		$item = array();

		$line_temp = explode( '|', trim( $line, '* ' ), 3 );
		if ( count( $line_temp ) > 1 ) {
			$line = $line_temp[1];
			$link = wfMessage( $line_temp[0] )->inContentLanguage()->text();

			# Pull out third item as a class
			if ( count( $line_temp ) == 3 ) {
				$item['class'] =  Sanitizer::escapeClass( $line_temp[2] );
			}
		} else {
			$line = $line_temp[0];
			$link = $line_temp[0];
		}
		$item['id'] = Sanitizer::escapeId( $line );

		# Determine what to show as the human-readable link description
		if ( $line == 'zaori-link' ) {
			# Daji time
			$item['text'] = '';
		} else if ( wfMessage( $line )->isDisabled() ) {
			# It's *not* the name of a MediaWiki message, so display it as-is
			$item['text'] = $line;
		} else {
			# Guess what -- it /is/ a MediaWiki message!
			$item['text'] = wfMessage( $line )->text();
		}

		if ( $link != null ) {
			if ( wfMessage( $line_temp[0] )->isDisabled() ) {
				$link = $line_temp[0];
			}
			if ( Skin::makeInternalOrExternalUrl( $link ) ) {
				$href = $link;
			} else {
				$title = Title::newFromText( $link );
				if ( $title ) {
					$title = $title->fixSpecialName();
					$href = $title->getLocalURL();
				} else {
					$href = '#';
				}
			}
		}
		$item['href'] = $href;

		return $item;
	}

	/**
	 * @param $sidebar array
	 */
	protected function renderPortals( $sidebar ) {
		if ( !isset( $sidebar['TOOLBOX'] ) ) $sidebar['TOOLBOX'] = true;
		if ( !isset( $sidebar['LANGUAGES'] ) ) $sidebar['LANGUAGES'] = true;

		foreach( $sidebar as $boxName => $content ) {
			if ( $content === false )
				continue;

			if ( $boxName == 'SEARCH' ) {
				continue;
			} elseif ( $boxName == 'TOOLBOX' ) {
				$this->toolbox();
			} elseif ( $boxName == 'LANGUAGES' ) {
				$this->languageBox();
			} else {
				$this->customBox( $boxName, $content );
			}
		}
	}

	function searchBox() {
	?>
		<div id="p-search" class="portlet" role="search">
			<form action="<?php $this->text( 'wgScript' ) ?>" id="searchform">
			<div id="simpleSearch">
				<?php echo $this->makeSearchInput( array( 'id' => 'searchInput', 'type' => 'text' ) ); ?>
				<?php echo $this->makeSearchButton( 'go', array( 'id' => 'searchGoButton', 'class' => 'searchButton' ) ); ?>
				<?php # echo $this->makeSearchButton( 'fulltext', array( 'id' => 'mw-searchButton', 'class' => 'searchButton' ) ); ?>
				<input type='hidden' name="title" value="<?php $this->text( 'searchtitle' ) ?>"/>
			</div>
		</form>
		</div>
	<?php
	}

	/**
	 * Prints the cactions bar.
	 */
	function cactions() {
	?>
		<div id="p-cactions" class="portlet" role="navigation">
			<div class="pBody">
				<ul>
				<?php
				foreach ( $this->data['content_actions'] as $key => $tab ) {
					echo $this->makeListItem( $key, $tab );
				}
				?>
				</ul>
			</div>
		</div>
	<?php
	}

	/*************************************************************************************************/
	function toolbox() {
	?>
		<div class="portlet" id="p-tb" role="navigation">
			<h3><?php $this->msg( 'toolbox' ) ?></h3>
			<div class="pBody">
				<ul>
				<?php
					foreach ( $this->getToolbox() as $key => $tbitem ) {
						echo $this->makeListItem( $key, $tbitem );
					}
					$title = $this->getSkin()->getTitle();
					# history
					if ( $this->getSkin()->getOutput()->isArticleRelated() ) {
						$link = Linker::link( $title, wfMessage( 'greystuff-history' )->text(), array(), array( 'action' => 'history' ) ); ?>
						<li id="t-history"><?php echo $link; ?></li>
						<?php
					}
					# purge
					$link = Linker::link( $title, wfMessage( 'greystuff-purge' )->text(), array(), array( 'action' => 'purge' ) ); ?>
					<li id="t-purge"><?php echo $link; ?></li>

					<?php
					Hooks::run( 'MonoBookTemplateToolboxEnd', array( &$this ) );
					Hooks::run( 'SkinTemplateToolboxEnd', array( &$this, true ) );
				?>
				</ul>
			</div>
		</div>
	<?php
	}

	/*************************************************************************************************/
	function languageBox() {
		if ( $this->data['language_urls'] ) {
		?>
			<div id="p-lang" class="portlet" role="navigation">
				<h3<?php $this->html( 'userlangattributes' ) ?>><?php $this->msg( 'otherlanguages' ) ?></h3>
				<div class="pBody">
					<ul>
					<?php
					foreach ( $this->data['language_urls'] as $key => $langlink ) {
						?>
						<?php echo $this->makeListItem( $key, $langlink );
					}
					?>
					</ul>
				</div>
			</div>
		<?php
		}
	}

	/*************************************************************************************************/
	/**
	 * @param $bar string
	 * @param $cont array|string
	 */
	function customBox( $bar, $cont ) {
		$portletAttribs = array( 'class' => 'generated-sidebar portlet', 'id' => Sanitizer::escapeId( "p-$bar" ), 'role' => 'navigation' );
		$tooltip = Linker::titleAttrib( "p-$bar" );
		if ( $tooltip !== false ) {
			$portletAttribs['title'] = $tooltip;
		}
		echo Html::openElement( 'div', $portletAttribs );
		$msgObj = wfMessage( $bar );
		?>

		<h3><?php echo htmlspecialchars( $msgObj->exists() ? $msgObj->text() : $bar ); ?></h3>
		<div class='pBody'>
			<?php   if ( is_array( $cont ) ) { ?>
			<ul>
			<?php
				foreach ( $cont as $key => $val ) {
					echo $this->makeListItem( $key, $val );
				}
			?>
			</ul>
			<?php
		} else {
			# allow raw HTML block to be defined by extensions
			print $cont;
		}
		?>
		</div>
	</div>
	<?php
	}
} // end of class
