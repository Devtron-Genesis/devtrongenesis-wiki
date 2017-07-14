<?php
/*
 * Keep in mind that this skin is still in beta stage and it may come to problems!
 * Denke daran, dass dieser sich dieser Skin im Beta-Stadium befindet und es zu Problemen kommen kann!
 */

class SkinGreyt extends SkinTemplate {
	var $skinname = 'greyt', $stylename = 'Greyt',
		$template = 'GreytTemplate', $useHeadElement = true;

	function setupSkinUserCss(OutputPage $out) {
		parent::setupSkinUserCss($out);
		$out->addModuleStyles(array(
			'mediawiki.skinning.interface', 'skins.greyt'
		) );
	}
}

class GreytTemplate extends BaseTemplate {

	public function execute() {
		$this->html('headelement') ?>

<header>
<div id="mw-head">
		<a
		class="logo"
		href="<?php echo htmlspecialchars($this->data['nav_urls']['mainpage']['href']);?>"
		<?php echo Xml::expandAttributes(Linker::tooltipAndAccesskeyAttribs('p-logo')) ?>
		><?php $this->text('sitename'); ?></a>

<form action="<?php $this->text('wgScript'); ?>">
	<input type="hidden" name="title" value="<?php $this->text('searchtitle') ?>" />
	<?php
		echo $this->makeSearchInput(array('type' => 'text'));
		echo $this->makeSearchButton('image', array('src' => $this->getSkin()->getSkinStylePath('Ressourcen/Lupe.svg')));
	?>
</form>
			
	<ul class="mw-head">
		<?php
		foreach ($this->getPersonalTools() as $key => $item) {
			echo $this->makeListItem($key, $item);
		}
		?>
	</ul>
</div>
</header>

<div id="mw-wrapper">
<!--Beta-Stuff (will be removed very soon) -->
<div class="beta">
★ Beta ★
</div>

<?php if ( $this->data['newtalk'] ) { ?>
<div class="usermessage">
<?php $this->html('newtalk');?>
</div>
<?php } ?>
	
<?php if ( $this->data['sitenotice'] ) { ?>
<div id="siteNotice">
<?php $this->html('sitenotice'); ?>
</div>
<?php } ?>
	
	<section>
	<div id="content">
		<div id="p-actions">
			<?php foreach ($this->data['content_navigation'] as $category => $tabs) { ?>
			<ul class="list-actions">
			<?php
				foreach ($tabs as $key => $tab) {
					echo $this->makeListItem($key, $tab);
				}
			?>
			</ul>
			<?php } ?>
		</div>
		
		<?php echo $this->getIndicators(); ?>

		<?php $this->html('subtitle'); ?>
		<?php $this->html('undelete'); ?>
		<h1 class="firstHeading"><?php $this->html('title'); ?></h1>
		
		<?php $this->html('bodytext'); ?>
		
		<?php $this->html('catlinks'); ?>
		
		<?php $this->html('dataAfterContent'); ?>
	</div>
	</section>

<div style="clear: both;"></div>

<footer>
<div id="footer">
<?php
foreach ( $this->getFooterLinks() as $category => $links ) { ?>
<ul>
<?php
	foreach ( $links as $key ) { ?>
	<li><?php $this->html( $key ) ?></li>

<?php
	} ?>
</ul>
<?php
} ?>

	<ul class="footer-icons">
	<?php
	foreach ($this->getFooterIcons('icononly') as $blockName => $footerIcons) { ?>
		<li>
		<?php
		foreach ($footerIcons as $icon) {
			echo $this->getSkin()->makeFooterIcon($icon);
		}
		?>
		</li>
		<?php
	} ?>
	</ul>
</footer>

</div>
</body>
</html><?php
	}
}
?>
