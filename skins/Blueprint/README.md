# Blueprint

MediaWiki skin for the the living styleguide.

## Installation

Clone the skin in `mediawiki/skins/` and install dependencies:
```
$ git clone https://gerrit.wikimedia.org/r/mediawiki/skins/Blueprint Blueprint
$ cd Blueprint
$ composer install
```

Enable and set the skin as default, add this to `LocalSettings.php`:
```php
require_once "$IP/skins/Blueprint/Blueprint.php";
$wgDefaultSkin = "blueprint";
```
