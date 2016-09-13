<?php
//
// Copyright (C) 2006 Thomas Papin
// http://www.gnu.org/copyleft/gpl.html GNU/GPL

// This file is part of the AdsManager Component,
// a Joomla! Classifieds Component by Thomas Papin
// Email: thomas.papin@free.fr
//
// Dont allow direct linking
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );


class adsManagerConf extends mosDBTable {
	var $id = null;
	var $version = null;
	var $ads_per_page = null;
	var $max_image_size = null;
	var $max_width = null; 
	var $max_height = null;
	var $max_width_t = null;
	var $max_height_t = null; 
	var $send_email_on_new = null;
	var $send_email_on_update = null;
	var $auto_publish = null;
	var $tag = null;
	var $fronttext = null;
	var $nb_images = null;
	var $show_contact = null;
	var $root_allowed = null;
	var $comprofiler = null;
	var $email_display = null;
	var $rules_text = null;
	var $display_last = null;
	var $display_expand = null;
	var $display_fullname = null;
	var $expiration = null;
	var $ad_duration = null;
	var $recall = null;
	var $recall_time = null;
	var $recall_text = null;
	var $image_display = null;
	var $cat_max_width = null;
	var $cat_max_height = null;
	var $cat_max_width_t = null;
	var $cat_max_height_t = null;
	var $submission_type = null;
	var $nb_ads_by_user = null;
	var $allow_attachement= null;
	var $allow_contact_by_pms = null;
	var $show_rss = null;
		
	function adsManagerConf(&$db){
		$this->mosDBTable('#__adsmanager_config', 'id', $db);
	}
}


class adsManagerCategory extends mosDBTable {
	var $id = null;
	var $parent = null;
	var $name = null;
	var $description = null;
	var $ordering = null;
	var $published = 1;
		
	function adsManagerCategory(&$db){
		$this->mosDBTable('#__adsmanager_categories', 'id', $db);
	}
}

class adsManagerAd extends mosDBTable {
	var $id= null;
	var $category= null;
	var $userid= null; 
	var $date_created = null;
	var $date_expiration = null;
	var $recall_mail_sent = null;
	var $published = null;
	
	function adsManagerAd(&$db){
		$this->mosDBTable('#__adsmanager_ads', 'id', $db);
	}
}

class adsManagerField extends mosDBTable {

   var $fieldid=null;
   var $name=null;
   var $description=null;
   var $title=null;
   var $display_title=null;
   var $type=null;
   var $maxlength=null;
   var $size=null;
   var $required=null;
   var $ordering=null;
   var $cols=null;
   var $rows=null;
   var $columnid    =null;
   var $columnorder =null;
   var $pos      = null;
   var $posorder = null;
   var $profile = null;
   var $cb_field = null;
   var $editable = null;
   var $searchable = null;
   var $sort = null;
   var $sort_direction = null;
   var $catsid = null;
   var $published = 1;

    /**
    * Constructor
    * @param database A database connector object
    */
	function adsManagerField( &$db ) {
	
		$this->mosDBTable( '#__adsmanager_fields', 'fieldid', $db );
	
	} //end func
} //end class

class adsManagerColumn extends mosDBTable {

   var $id=null;
   var $name=null;
   var $ordering=null;
   var $catsid=null;
   var $published = 1;

    /**
    * Constructor
    * @param database A database connector object
    */
	function adsManagerColumn( &$db ) {
	
		$this->mosDBTable( '#__adsmanager_columns', 'id', $db );
	
	} //end func
} //end class

class adsManagerPosition extends mosDBTable {

   var $id=null;
   var $name=null;
   var $title=null;

    /**
    * Constructor
    * @param database A database connector object
    */
	function adsManagerPosition( &$db ) {
	
		$this->mosDBTable( '#__adsmanager_positions', 'id', $db );
	
	} //end func
} //end class

?>