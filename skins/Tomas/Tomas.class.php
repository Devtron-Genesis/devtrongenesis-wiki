<?php

class SkinTomas extends Skin {
	var $out;

	function getMainCss() {
		return "{$this->path}/main.css";
	}

	function getMainJs() {
		return "{$this->path}/main.js";
	}

	function outputPage( OutputPage $out = null ) {
		global $wgContLang, $wgTomasSkinPath, $wgExtensionAssetsPath;

		if ( !$out ) {
			// MW 1.19
			$out = $this->getOutput();
		}

		$lang = $wgContLang->getCode();
		$this->path = $wgTomasSkinPath ? $wgTomasSkinPath : "{$wgExtensionAssetsPath}/skins/Tomas";
		$this->out = $out;
		$bodyText = $out->getHTML();
		$bodyText = preg_replace( '!(<img[^>]*src=")schstock/!', "$1{$this->path}/images/", $bodyText );
		$bodyText = preg_replace( '!(<[^>]*style="[^"]*url\()schstock/!', "$1{$this->path}/images/", $bodyText );
		$bodyText = preg_replace( '!(<input[^>]*src=")schstock/!', "$1{$this->path}/images/", $bodyText );
		$query = 'usemsgcache=yes&action=raw&ctype=text/css&smaxage=2678400';
		$siteCss = Title::newFromText( 'MediaWiki:Tomas.css' )->getLocalUrl( $query );
		$siteJs = Title::newFromText( 'MediaWiki:Tomas.js' )->getLocalUrl( $query );

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Language" content="<?php echo htmlspecialchars( $lang ) ?>">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title><?php echo htmlspecialchars( $out->getPageTitle() )?> </title>
		<link rel="stylesheet" href="<?php echo htmlspecialchars( $this->getMainCss() ); ?>" type="text/css"/>
		<script type="text/javascript" src="<?php echo htmlspecialchars( $this->getMainJs() ); ?>"></script>
		<link rel="stylesheet" href="<?php echo htmlspecialchars( $siteCss ); ?>" type="text/css"/>
		<script type="text/javascript" src="<?php echo htmlspecialchars( $siteJs ); ?>"></script>

	</head>

	<body>
		<div align="center">

			<?php echo $bodyText ?>
		</div>
	</body>
</html>

<?php
	}

	/**
	 * Add skin specific stylesheets
	 * Calling this method with an $out of anything but the same OutputPage
	 * inside ->getOutput() is deprecated. The $out arg is kept
	 * for compatibility purposes with skins.
	 * @param $out OutputPage
	 * @delete
	 */
	function setupSkinUserCss(OutputPage $out) {
		// TODO: Implement setupSkinUserCss() method.
	}
}

