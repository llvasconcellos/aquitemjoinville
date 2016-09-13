<?php
/**
* @version 1.0.4
* @package RSform! 1.0.4
* @copyright (C) 2007 www.rsjoomla.com
* @license Commercial License, http://www.rsjoomla.com/license/forme.html
*/
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
require_once( $mainframe->getPath( 'toolbar_html' ) );

switch ( $task ) {

		case "new":
		case "edit":
		case "editA":
		case "copy":
		menuforme::EDIT_MENU();
		break;

		case "update":
		menuforme::UPDATE();
		break;

		case "forms":
		menuforme::LISTFORMS_MENU();
		break;

		case "newform":
		case "editform":
		menuforme::EDITFORM_MENU();
		break;

		case "newfield":
		case "editfield":
		menuforme::EDITFIELD_MENU();
		break;

		case "settings":
    	menuforme::SETTINGS_MENU();
    	break;

    	case "listdata":
    	menuforme::LISTDATA_MENU();
    	break;

    	case "fields.copy.screen":
    		menuforme::FIELDS_COPY_SCREEN();
    	break;

		default:
		menuforme::_DEFAULT();
		break;

	}

?>