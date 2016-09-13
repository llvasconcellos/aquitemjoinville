<?php
/**
* @package rssFactory
* @version 1.0
* @copyright www.thefactory.ro
*/ 
function com_uninstall() {
	global $mosConfig_absolute_path, $database;

	$destination_file = $mosConfig_absolute_path."/modules/mod_rssfactory.php";
	unlink($destination_file);
	$destination_file = $mosConfig_absolute_path."/modules/mod_rssfactory.xml";
	unlink($destination_file);
	$destination_file = $mosConfig_absolute_path."/mambots/search/rssfactory.searchbot.php";
	unlink($destination_file);
	$destination_file = $mosConfig_absolute_path."/mambots/search/rssfactory.searchbot.xml";
	unlink($destination_file);

	$database->setQuery("
		DELETE FROM `#__modules` where `module`= 'mod_rssfactory'
		");
	$database->query();
	$database->setQuery("
		DELETE FROM `#__mambots` where `element`= 'rssfactory.searchbot'
		");
	$database->query();
}
?>
