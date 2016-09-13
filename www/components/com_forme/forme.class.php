<?php
/**
* @version 1.0.4
* @package RSform! 1.0.4
* @copyright (C) 2007 www.rsjoomla.com
* @license Commercial License, http://www.rsjoomla.com/license/forme.html
*/

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

class forme_config extends mosDBTable{
	var $id = null;
	var $setting_name = null;
	var $setting_value = null;

	function forme_config(&$db){
		$this->mosDBTable('#__forme_config', 'id', $db);
	}

}

class forme_forms extends mosDBTable{
	var $id = null;
	var $name = null;
	var $title = null;
	var $formstyle = null;
	var $fieldstyle = null;
	var $thankyou = null;
	var $email = null;
	var $emailto = null;
	var $emailfrom = null;
	var $emailfromname = null;
	var $emailsubject = null;
	var $emailmode = null;
	var $return_url = null;
	var $published = null;
	var $checked_out = null;
	var $checked_out_time = null;
	var $lang = null;
	var $script_process = null;
	var $script_display = null;

	function forme_forms(&$db){
		$this->mosDBTable('#__forme_forms', 'id', $db);
	}

}

class forme_fields extends mosDBTable{
	var $id = null;
	var $form_id = null;
	var $name = null;
	var $title = null;
	var $fieldstyle = null;
	var $description = null;
	var $inputtype = null;
	var $default_value = null;
	var $params = null;
	var $validation_rule = null;
	var $validation_message = null;
	var $ordering = null;
	var $published = null;
	var $checked_out = null;
	var $checked_out_time = null;

	function forme_fields(&$db){
		$this->mosDBTable('#__forme_fields', 'id', $db);
	}

}

class forme_data extends mosDBTable{
	var $id = null;
	var $form_id = null;
	var $date_added = null;
	var $uip = null;
	var $uid = null;
	var $params = null;

	function forme_data(&$db){
		$this->mosDBTable('#__forme_data', 'id', $db);
	}

}
?>