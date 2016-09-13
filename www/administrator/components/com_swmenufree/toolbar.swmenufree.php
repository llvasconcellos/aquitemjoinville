<?php
/**
* SWmenuFree v4.0
* http://swonline.biz
* DHTML Menu Component for Mambo Open Source
**/

// ensure this file is being included by a parent file
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( $mainframe->getPath( 'toolbar_html' ) );

switch ( $task ) {


			case "cancel":
			// menucontact::CANCEL_MENU();
			 break;

			case "save":
			// menucontact::SAVE_MENU();
			 break;
        
        default:
            //    menucontact::DHTML_MENU();
                break;
}
?>
