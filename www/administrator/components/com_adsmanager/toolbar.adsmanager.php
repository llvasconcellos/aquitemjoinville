<?php
//
// Copyright (C) 2006 Thomas Papin
// http://www.gnu.org/copyleft/gpl.html GNU/GPL

// This file is part of the AdsManager Component,
// a Joomla! Classifieds Component by Thomas Papin
// Email: thomas.papin@free.fr
//
// no direct access
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
require_once( $mainframe->getPath( 'toolbar_html' ) ); 

switch ($task) {	
	case "new" :
	case "edit" :
		menuAdsManager::editMenu();
		break;
		
	case "save" :
	case "delete" :
	default:
		if ($act == "item")
			menuAdsManager::listItemMenu();
		else if ($act == "configuration")
			menuAdsManager::editMenu();
		else if ($act == "tools")
			break;
		else if ($act == "positions")
			break;
		else
			menuAdsManager::listMenu();
		break;
}

?>
