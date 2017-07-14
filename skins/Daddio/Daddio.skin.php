<?php
/**
 * Daddio skin. Skin for getting work done.
 * Based on Modern, modified by Rufus Post, Aaron Schulz
 *
 * @file
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( -1 );
}

/**
 * Inherit main code from SkinTemplate, set the CSS and template filter.
 *
 * @ingroup Skins
 */
class SkinDaddio extends SkinTemplate {
	public $skinname = 'daddio', $stylename = 'daddio',
		$template = 'DaddioTemplate', $useHeadElement = true;

	function setupSkinUserCss( OutputPage $out ) {
		$out->addModuleStyles( array( 'mediawiki.legacy.shared', 'skins.daddio' ) );
	}
}

/**
 * @todo document
 * @ingroup Skins
 */
class DaddioTemplate extends ModernTemplate {
	public $skin;

	/**
	 * Template filter callback for Daddio skin.
	 * Takes an associative array of data set from a SkinTemplate-based
	 * class, and a wrapper for MediaWiki's localization database, and
	 * outputs a formatted page.
	 */
	public function execute() {
		$this->skin = $this->data['skin'];

		$this->data['pageLanguage'] = $this->skin->getTitle()->getPageViewLanguage()->getHtmlCode();

		$this->html( 'headelement' );
?>
	<!-- heading -->

	<div id="mw_main">
	<div id="mw_contentwrapper">
	<!-- navigation portlet -->
	<div class="portlet" id="p-cactions">
		<h5><?php $this->msg( 'views' ) ?></h5>
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

	<!-- content -->
	<div id="mw_content">
	<!-- contentholder does nothing by default, but it allows users to style the text inside
	     the content area without affecting the meaning of 'em' in #mw_content, which is used
	     for the margins -->
	<div id="mw_contentholder">
		<div class="mw-topboxes">
			<div id="mw-js-message" style="display:none;"></div>
			<div class="mw-topbox" id="siteSub"><?php $this->msg( 'tagline' ) ?></div>
			<?php if ( $this->data['newtalk'] ) {
				?><div class="usermessage mw-topbox"><?php $this->html( 'newtalk' ) ?></div>
			<?php } ?>
			<?php if ( $this->data['sitenotice'] ) {
				?><div class="mw-topbox" id="siteNotice"><?php $this->html( 'sitenotice' ) ?></div>
			<?php } ?>
		</div>
		<div id="mw_header"><h1 id="firstHeading" class="firstHeading" lang="<?php $this->text( 'pageLanguage' ); ?>"><?php $this->html( 'title' ) ?></h1></div>
		<div id="contentSub"><?php $this->html( 'subtitle' ) ?></div>

		<?php if ( $this->data['undelete'] ) { ?><div id="contentSub2"><?php $this->html( 'undelete' ) ?></div><?php } ?>
		<div id="jump-to-nav" class="mw-jump"><?php $this->msg( 'jumpto' ) ?> <a href="#column-one"><?php $this->msg( 'jumptonavigation' ) ?></a>, <a href="#searchInput"><?php $this->msg( 'jumptosearch' ) ?></a></div>

		<?php $this->html( 'bodytext' ) ?>
		<div class="mw_clear"></div>
		<?php if ( $this->data['catlinks'] ) { $this->html( 'catlinks' ); } ?>
		<?php $this->html( 'dataAfterContent' ) ?>
	</div><!-- mw_contentholder -->
	</div><!-- mw_content -->
	</div><!-- mw_contentwrapper -->

	<div id="mw_portlets">

	<?php
		$sidebar = $this->data['sidebar'];
		if ( !isset( $sidebar['SEARCH'] ) ) {
			$sidebar['SEARCH'] = true;
		}
		if ( !isset( $sidebar['TOOLBOX'] ) ) {
			$sidebar['TOOLBOX'] = true;
		}
		if ( !isset( $sidebar['LANGUAGES'] ) ) {
			$sidebar['LANGUAGES'] = true;
		}

		foreach ( $sidebar as $boxName => $cont ) {
			if ( $boxName == 'SEARCH' ) {
				$this->searchBox();
			} elseif ( $boxName == 'TOOLBOX' ) {
				$this->toolbox();
			} elseif ( $boxName == 'LANGUAGES' ) {
				$this->languageBox();
			} else {
				$this->customBox( $boxName, $cont );
			}
		}
	?>

	</div><!-- mw_portlets -->


	</div><!-- main -->

	<div class="mw_clear"></div>

	<!-- personal portlet -->
	<div class="portlet_top" id="p-personal">
		<h5><?php $this->msg( 'personaltools' ) ?></h5>
		<div class="pBody">
			<ul<?php $this->html( 'userlangattributes' ) ?>>
			<?php
				foreach ( $this->getPersonalTools() as $key => $item ) {
					echo $this->makeListItem( $key, $item );
				}
			?>
			</ul>
		</div>
	</div>

	<!-- bottom of page -->
	<div id="mw_bottom">

	<?php
	// Mostly stol--I mean nationalized from MonoBook
	$validFooterIcons = $this->getFooterIcons( 'icononly' );
	$validFooterLinks = $this->getFooterLinks( 'flat' ); // Additional footer links

	if ( count( $validFooterIcons ) + count( $validFooterLinks ) > 0 ) { ?>
<!-- footer -->
<div id="footer" role="contentinfo"<?php $this->html( 'userlangattributes' ) ?>>
<?php
		$footerEnd = '</div>';
	} else {
		$footerEnd = '';
	}
	// @todo FIXME/CHECKME: do these belong here or not?
	// I don't think the original version had these, so if they break stuff, feel
	// free to remove 'em
	foreach ( $validFooterIcons as $blockName => $footerIcons ) { ?>
	<div id="f-<?php echo htmlspecialchars( $blockName ); ?>ico">
<?php
		foreach ( $footerIcons as $icon ) {
			echo $this->skin->makeFooterIcon( $icon );
		}
?>
	</div>
<?php }

		if ( count( $validFooterLinks ) > 0 ) {
?>	<ul id="f-list">
<?php
			foreach ( $validFooterLinks as $aLink ) { ?>
		<li id="<?php echo $aLink ?>"><?php $this->html( $aLink ) ?></li>
<?php
			}
?>
	</ul>
<?php	}
echo $footerEnd;

	// Call ResourceLoader to output bottom scripts (mostly JS) and whatnot
	$this->printTrail();
?>
</div> <!-- bottom of page -->
</body></html>
<?php
	} // end of execute() method
} // end of class

