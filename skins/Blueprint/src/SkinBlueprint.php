<?php

class SkinBlueprint extends SkinTemplate {
	public $skinname = 'blueprint';
	public $stylename = 'Blueprint';
	public $template = 'BlueprintSkinTemplate';

	public function initPage( OutputPage $out ) {
		parent::initPage( $out );

		// Append JS shiv for supporting HTML5 elements in IE<9 @media screen
		$min = $this->getRequest()->getFuzzyBool( 'debug' ) ? '' : '.min';
		$out->addHeadItem( 'html5shiv',
			'<!--[if lt IE 9]><script src="' .
			htmlspecialchars(
				$this->getConfig()->get( 'LocalStylePath' ) .
				"/{$this->stylename}/resources/vendor/html5shiv{$min}.js"
			) .
			'"></script><![endif]-->'
		);
		$out->addModules( array( 'skin.blueprint.js' ) );
	}

	public function setupSkinUserCss( OutputPage $out ) {
		parent::setupSkinUserCss( $out );
		$out->addModuleStyles( array( 'skin.blueprint.styles' ) );
	}
}
