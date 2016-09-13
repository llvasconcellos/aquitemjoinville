<?php
/**
* @package rssFactory
* @version 1.0
* @copyright www.thefactory.ro
*/ 
/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( $mainframe->getPath( 'toolbar_html' ) );

switch ($task) {
	case "new":
		TOOLBAR_RSSReader::_EDIT();
		break;
	case "edit":
		TOOLBAR_RSSReader::_EDIT();
		break;
	case "newads":
		TOOLBAR_RSSReader::_EDITADS();
		break;
	case "editads":
		TOOLBAR_RSSReader::_EDITADS();
		break;
	case "showads":
		TOOLBAR_RSSReader::_ADLIST();
		break;
	case "showconfig":
		TOOLBAR_RSSReader::_EDITCONFIG();
		break;
	case "importcsv":
		TOOLBAR_RSSReader::_IMPORTCSV();
		break;
	case "backup":
		TOOLBAR_RSSReader::_BACKUP();
		break;
	case "restore":
		TOOLBAR_RSSReader::_RESTOREBACKUP();
		break;
	case "catman":
		TOOLBAR_RSSReader::_CATMAN();
		break;
	default:
		TOOLBAR_RSSReader::_DEFAULT();
		break;
}
?>
