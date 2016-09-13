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

function com_install()
{
	global $mosConfig_absolute_path,$database;
	if(!file_exists($mosConfig_absolute_path . "/images/com_adsmanager/")){
		@mkdir($mosConfig_absolute_path . "/images/com_adsmanager/");
	};
	
	if(!file_exists($mosConfig_absolute_path . "/images/com_adsmanager/categories/")){
		@mkdir($mosConfig_absolute_path . "/images/com_adsmanager/categories/");
	};
	
	if(!file_exists($mosConfig_absolute_path . "/images/com_adsmanager/ads/")){
		@mkdir($mosConfig_absolute_path . "/images/com_adsmanager/ads/");
	};
	
	if(!file_exists($mosConfig_absolute_path . "/images/com_adsmanager/email/")){
		@mkdir($mosConfig_absolute_path . "/images/com_adsmanager/email/");
	};
	
	if(!file_exists($mosConfig_absolute_path . "/images/com_adsmanager/files/")){
		@mkdir($mosConfig_absolute_path . "/images/com_adsmanager/files/");
	};
	
	//Update to 1.0.1
    $database->setQuery("SELECT send_email_on_new FROM #__adsmanager_config WHERE 1");
    $database->loadObjectList();
	if ($database->getErrorNum()) {
		$database->setQuery("ALTER TABLE #__adsmanager_config ADD `send_email_on_new` TINYINT DEFAULT '1' NOT NULL AFTER `max_height_t` ,"
						    ." ADD `send_email_on_update` TINYINT DEFAULT '1' NOT NULL AFTER `send_email_on_new`");
		$result = $database->query();
    }
    
    //Update to 1.1.0
    $database->setQuery("SELECT root_allowed FROM #__adsmanager_config WHERE 1");
    $database->loadObjectList();
	if ($database->getErrorNum()) {
		$database->setQuery("ALTER TABLE #__adsmanager_config ADD `root_allowed` TINYINT DEFAULT '1' NOT NULL AFTER `max_height_t` ,"
						    ." ADD `nb_images` INT DEFAULT '2' NOT NULL AFTER `root_allowed` ,"
						    ." ADD `show_contact` TINYINT DEFAULT '1' NOT NULL AFTER `nb_images`");
		$result = $database->query();
    }
    
    //Update to 1.2.0
    $database->setQuery("SELECT comprofiler FROM #__adsmanager_config WHERE 1");
    $database->loadObjectList();
	if ($database->getErrorNum()) {
		$database->setQuery("ALTER TABLE #__adsmanager_config ADD `comprofiler` TINYINT DEFAULT '0' NOT NULL AFTER `fronttext`");
		$result = $database->query();
    }
    
    //Update to 1.2.1
    $database->setQuery("SELECT email_display FROM #__adsmanager_config WHERE 1");
    $database->loadObjectList();
	if ($database->getErrorNum()) {
		$database->setQuery("ALTER TABLE #__adsmanager_config ADD `email_display` TINYINT DEFAULT '0' NOT NULL AFTER `comprofiler`");
		$result = $database->query();
    }
       
    $database->setQuery("SELECT count(*) FROM `#__adsmanager_columns` WHERE 1");
    $total = $database->loadResult();
    if ($total == 0)
    {
		//Update to 2.0.0
		$database->setQuery("INSERT IGNORE INTO `#__adsmanager_columns` VALUES (2, 'ADSMANAGER_PRICE', 1, 1);");
		$result = $database->query();
	
		$database->setQuery("INSERT IGNORE INTO `#__adsmanager_columns` VALUES (3, 'ADSMANAGER_CITY', 2, 1);");
		
		$result = $database->query();
	
		$database->setQuery("INSERT IGNORE INTO `#__adsmanager_columns` VALUES (5, 'ADSMANAGER_STATE', 1, 0);");
		$result = $database->query();
	
		$database->setQuery("INSERT IGNORE INTO `#__adsmanager_field_values` VALUES (228, 8, 'ADSMANAGER_KINDOF2', 1, 1, 0);");
		$result = $database->query();
	
		$database->setQuery("INSERT IGNORE INTO `#__adsmanager_field_values` VALUES (229, 8, 'ADSMANAGER_KINDOF1', 2, 2, 0);");
		$result = $database->query();
	
		$database->setQuery("INSERT IGNORE INTO `#__adsmanager_field_values` VALUES (225, 9, 'ADSMANAGER_STATE_0', 4, 4, 0);");
		$result = $database->query();
	
		$database->setQuery("INSERT IGNORE INTO `#__adsmanager_field_values` VALUES (227, 8, 'ADSMANAGER_KINDOFALL', 0, 0, 0);");
		$result = $database->query();
	
		$database->setQuery("INSERT IGNORE INTO `#__adsmanager_field_values` VALUES (224, 9, 'ADSMANAGER_STATE_1', 3, 3, 0);");
		$result = $database->query();
	
		$database->setQuery("INSERT IGNORE INTO `#__adsmanager_field_values` VALUES (222, 9, 'ADSMANAGER_STATE_3', 1, 1, 0);");
		$result = $database->query();
	
		$database->setQuery("INSERT IGNORE INTO `#__adsmanager_field_values` VALUES (223, 9, 'ADSMANAGER_STATE_2', 2, 2, 0);");
		$result = $database->query();
	
		$database->setQuery("INSERT IGNORE INTO `#__adsmanager_field_values` VALUES (289, 7, '', 0, 0, 0);");
		$result = $database->query();
	
		$database->setQuery("INSERT IGNORE INTO `#__adsmanager_field_values` VALUES (285, 2, '', 0, 0, 0);");
		$result = $database->query();
	
		$database->setQuery("INSERT IGNORE INTO `#__adsmanager_field_values` VALUES (284, 1, '', 0, 0, 0);");
		$result = $database->query();
	
		$database->setQuery("INSERT IGNORE INTO `#__adsmanager_field_values` VALUES (221, 9, 'ADSMANAGER_STATE_4', 0, 0, 0);");	
		$result = $database->query();
	
		$database->setQuery("INSERT IGNORE INTO `#__adsmanager_field_values` VALUES (288, 4, '', 0, 0, 0);");
		$result = $database->query();
		
		$database->setQuery("INSERT IGNORE INTO `#__adsmanager_fields` (`fieldid`, `name`, `title`, `description`, `type`, `maxlength`, `size`, `required`, `ordering`, `cols`, `rows`, `columnid`, `columnorder`, `pos`, `posorder`, `profile`, `cb_field`, `sort`, `sort_direction`, `published`) VALUES (1, 'name', 'ADSMANAGER_FORM_NAME', '', 'text', 50, 35, 1, 0, 0, 0, -1, 5, 5, 1, 1, 41, 0, 'DESC', 1);");
		$result = $database->query();
	
		$database->setQuery("INSERT IGNORE INTO `#__adsmanager_fields` (`fieldid`, `name`, `title`, `description`, `type`, `maxlength`, `size`, `required`, `ordering`, `cols`, `rows`, `columnid`, `columnorder`, `pos`, `posorder`, `profile`, `cb_field`, `sort`, `sort_direction`, `published`) VALUES (2, 'email', 'ADSMANAGER_FORM_EMAIL', '', 'emailaddress', 50, 35, 1, 1, 0, 0, -1, 10, 5, 4, 1, 50, 0, 'DESC', 1);");
		$result = $database->query();
	
		$database->setQuery("INSERT IGNORE INTO `#__adsmanager_fields` (`fieldid`, `name`, `title`, `description`, `type`, `maxlength`, `size`, `required`, `ordering`, `cols`, `rows`, `columnid`, `columnorder`, `pos`, `posorder`, `profile`, `cb_field`, `sort`, `sort_direction`, `published`) VALUES (3, 'ad_city', 'ADSMANAGER_FORM_CITY', '', 'text', 50, 35, 0, 4, 0, 0, 3, 1, 5, 3, 1, 59, 1, 'ASC', 1);");	
		$result = $database->query();
	
		$database->setQuery("INSERT IGNORE INTO `#__adsmanager_fields` (`fieldid`, `name`, `title`, `description`, `type`, `maxlength`, `size`, `required`, `ordering`, `cols`, `rows`, `columnid`, `columnorder`, `pos`, `posorder`, `profile`, `cb_field`, `sort`, `sort_direction`, `published`) VALUES (4, 'ad_zip', 'ADSMANAGER_FORM_ZIP', '', 'text', 6, 7, 0, 3, 0, 0, -1, 0, 5, 2, 1, -1, 0, 'ASC', 1);");	
		$result = $database->query();
	
		$database->setQuery("INSERT IGNORE INTO `#__adsmanager_fields` (`fieldid`, `name`, `title`, `description`, `type`, `maxlength`, `size`, `required`, `ordering`, `cols`, `rows`, `columnid`, `columnorder`, `pos`, `posorder`, `profile`, `cb_field`, `sort`, `sort_direction`, `published`) VALUES (5, 'ad_headline', 'ADSMANAGER_FORM_AD_HEADLINE', '', 'text', 60, 35, 1, 5, 0, 0, -1, 0, 1, 1, 0, -1, 0, 'DESC', 1);");	
		$result = $database->query();
	
		$database->setQuery("INSERT IGNORE INTO `#__adsmanager_fields` (`fieldid`, `name`, `title`, `description`, `type`, `maxlength`, `size`, `required`, `ordering`, `cols`, `rows`, `columnid`, `columnorder`, `pos`, `posorder`, `profile`, `cb_field`, `sort`, `sort_direction`, `published`) VALUES (6, 'ad_text', 'ADSMANAGER_FORM_AD_TEXT', '', 'textarea', 500, 0, 1, 6, 40, 20, -1, 0, 3, 1, 0, -1, 0, 'DESC', 1);");
		$result = $database->query();
	
		$database->setQuery("INSERT IGNORE INTO `#__adsmanager_fields` (`fieldid`, `name`, `title`, `description`, `type`, `maxlength`, `size`, `required`, `ordering`, `cols`, `rows`, `columnid`, `columnorder`, `pos`, `posorder`, `profile`, `cb_field`, `sort`, `sort_direction`, `published`) VALUES (7, 'ad_phone', 'ADSMANAGER_FORM_PHONE1', '', 'number', 50, 35, 0, 2, 0, 0, -1, 0, 5, 1, 1, -1, 0, 'DESC', 1);");
		$result = $database->query();
	
		$database->setQuery("INSERT IGNORE INTO `#__adsmanager_fields` (`fieldid`, `name`, `title`, `description`, `type`, `maxlength`, `size`, `required`, `ordering`, `cols`, `rows`, `columnid`, `columnorder`, `pos`, `posorder`, `profile`, `cb_field`, `sort`, `sort_direction`, `published`) VALUES (8, 'ad_kindof', 'ADSMANAGER_FORM_KINDOF', '', 'select', 0, 0, 1, 7, 0, 0, 5, 0, 2, 1, 0, -1, 0, 'DESC', 1);");
		$result = $database->query();
	
		$database->setQuery("INSERT IGNORE INTO `#__adsmanager_fields` (`fieldid`, `name`, `title`, `description`, `type`, `maxlength`, `size`, `required`, `ordering`, `cols`, `rows`, `columnid`, `columnorder`, `pos`, `posorder`, `profile`, `cb_field`, `sort`, `sort_direction`, `published`) VALUES (9, 'ad_state', 'ADSMANAGER_FORM_STATE', '', 'select', 0, 0, 1, 8, 0, 0, 5, 0, 2, 1, 0, -1, 0, 'DESC', 1);");	
		$result = $database->query();
	
		$database->setQuery("INSERT IGNORE INTO `#__adsmanager_fields` (`fieldid`, `name`, `title`, `description`, `type`, `maxlength`, `size`, `required`, `ordering`, `cols`, `rows`, `columnid`, `columnorder`, `pos`, `posorder`, `profile`, `cb_field`, `sort`, `sort_direction`, `published`) VALUES (10, 'ad_price', 'ADSMANAGER_FORM_AD_PRICE', '', 'price', 10, 7, 1, 9, 0, 0, 2, 0, 4, 1, 0, -1, 1, 'DESC', 1);");	
		$result = $database->query();
	
		$database->setQuery("INSERT IGNORE INTO `#__adsmanager_positions` VALUES (1, 'top', 'ADSMANAGER_POSITION_TOP');");	
		$result = $database->query();
	
		$database->setQuery("INSERT IGNORE INTO `#__adsmanager_positions` VALUES (2, 'subtitle', 'ADSMANAGER_POSITION_SUBTITLE');");
		$result = $database->query();
	
		$database->setQuery("INSERT IGNORE INTO `#__adsmanager_positions` VALUES (3, 'description', 'ADSMANAGER_POSITION_DESCRIPTION');");
		$result = $database->query();
	
		$database->setQuery("INSERT IGNORE INTO `#__adsmanager_positions` VALUES (4, 'description2', 'ADSMANAGER_POSITION_DESCRIPTION2');");
		$result = $database->query();
	
		$database->setQuery("INSERT IGNORE INTO `#__adsmanager_positions` VALUES (5, 'contact', 'ADSMANAGER_POSITION_CONTACT');");
		$result = $database->query();
		
		$database->setQuery(" ALTER IGNORE TABLE `#__adsmanager_ads` ADD `name` TEXT DEFAULT NULL;");
		$result = $database->query();
		
		$database->setQuery(" ALTER IGNORE TABLE `#__adsmanager_ads` ADD `ad_zip` TEXT DEFAULT NULL;");
		$result = $database->query();
		
		$database->setQuery(" ALTER IGNORE TABLE `#__adsmanager_ads` ADD `ad_city` TEXT DEFAULT NULL;");
		$result = $database->query();
		
		$database->setQuery(" ALTER IGNORE TABLE `#__adsmanager_ads` ADD `ad_phone` TEXT DEFAULT NULL;");
		$result = $database->query();
		
		$database->setQuery(" ALTER IGNORE TABLE `#__adsmanager_ads` ADD `email` TEXT DEFAULT NULL;");	
		$result = $database->query();
		
		$database->setQuery(" ALTER IGNORE TABLE `#__adsmanager_ads` ADD `ad_kindof` TEXT DEFAULT NULL;");	
		$result = $database->query();
		
		$database->setQuery(" ALTER IGNORE TABLE `#__adsmanager_ads` ADD `ad_headline` TEXT DEFAULT NULL;");	
		$result = $database->query();
		
		$database->setQuery(" ALTER IGNORE TABLE `#__adsmanager_ads` ADD `ad_text` TEXT DEFAULT NULL;");	
		$result = $database->query();
		
		$database->setQuery(" ALTER IGNORE TABLE `#__adsmanager_ads` CHANGE `ad_state` `ad_state` TEXT DEFAULT NULL;");	
		$result = $database->query();
		
		$database->setQuery(" ALTER IGNORE TABLE `#__adsmanager_ads` ADD `ad_price` TEXT DEFAULT NULL;");	
		$result = $database->query(); 
		   
		$database->setQuery("ALTER IGNORE TABLE `#__adsmanager_profile` ADD `name` TEXT DEFAULT NULL;");   
		$result = $database->query();
		
		$database->setQuery("ALTER IGNORE TABLE  `#__adsmanager_profile` ADD `ad_zip` TEXT DEFAULT NULL;");	
		$result = $database->query();
		
		$database->setQuery("ALTER IGNORE TABLE `#__adsmanager_profile` ADD `ad_city` TEXT DEFAULT NULL;");	
		$result = $database->query();
		
		$database->setQuery("ALTER TABLE `#__adsmanager_profile` ADD `ad_phone` TEXT NOT NULL;");	
		$result = $database->query();
	}
	
	$database->setQuery(" ALTER IGNORE TABLE `#__adsmanager_ads` CHANGE `name` `name` TEXT DEFAULT NULL;");
	$result = $database->query();
	
	$database->setQuery(" ALTER IGNORE TABLE `#__adsmanager_ads` CHANGE `zip` `ad_zip` TEXT DEFAULT NULL;");
	$result = $database->query();
	
	$database->setQuery(" ALTER IGNORE TABLE `#__adsmanager_ads` CHANGE `city` `ad_city` TEXT DEFAULT NULL;");
	$result = $database->query();
	
	$database->setQuery(" ALTER IGNORE TABLE `#__adsmanager_ads` CHANGE `phone1` `ad_phone` TEXT DEFAULT NULL;");
	$result = $database->query();
	
	$database->setQuery(" ALTER IGNORE TABLE `#__adsmanager_ads` CHANGE `email` `email` TEXT DEFAULT NULL;");	
	$result = $database->query();
	
	$database->setQuery(" ALTER IGNORE TABLE `#__adsmanager_ads` CHANGE `ad_kindof` `ad_kindof` TEXT DEFAULT NULL;");	
	$result = $database->query();
	
	$database->setQuery(" ALTER IGNORE TABLE `#__adsmanager_ads` CHANGE `ad_headline` `ad_headline` TEXT DEFAULT NULL;");	
	$result = $database->query();
	
	$database->setQuery(" ALTER IGNORE TABLE `#__adsmanager_ads` CHANGE `ad_text` `ad_text` TEXT DEFAULT NULL;");	
	$result = $database->query();
	
	$database->setQuery(" ALTER IGNORE TABLE `#__adsmanager_ads` CHANGE `ad_state` `ad_state` TEXT DEFAULT NULL;");	
	$result = $database->query();
	
	$database->setQuery(" ALTER IGNORE TABLE `#__adsmanager_ads` CHANGE `ad_price` `ad_price` TEXT DEFAULT NULL;");	
	$result = $database->query(); 
	   
	$database->setQuery("ALTER IGNORE TABLE `#__adsmanager_profile` CHANGE `name` `name` TEXT DEFAULT NULL;");   
	$result = $database->query();
	
	$database->setQuery("ALTER IGNORE TABLE `#__adsmanager_profile` CHANGE `zip` `ad_zip` TEXT DEFAULT NULL;");	
	$result = $database->query();
	
	$database->setQuery("ALTER IGNORE TABLE `#__adsmanager_profile` CHANGE `city` `ad_city` TEXT DEFAULT NULL;");	
	$result = $database->query();
    
    //Update to 2.0.2
    $database->setQuery("SELECT rules_text FROM #__adsmanager_config WHERE 1");
    $database->loadObjectList();
	if ($database->getErrorNum()) {
		$database->setQuery("ALTER TABLE #__adsmanager_config ADD `rules_text` TEXT NOT NULL");
		$result = $database->query();
    }
    
    //Update to 2.0.3
    $database->setQuery("SELECT display_expand FROM #__adsmanager_config WHERE 1");
    $database->loadObjectList();
	if ($database->getErrorNum()) {
		$database->setQuery("ALTER TABLE #__adsmanager_config ADD `display_expand` TEXT NOT NULL");
		$result = $database->query();
    }
    
    $database->setQuery("SELECT display_last FROM #__adsmanager_config WHERE 1");
    $database->loadObjectList();
	if ($database->getErrorNum()) {
		$database->setQuery("ALTER TABLE #__adsmanager_config ADD `display_last` TEXT NOT NULL");
		$result = $database->query();
    }
    
    //Update to 2.1.0
    $database->setQuery("SELECT ad_duration FROM #__adsmanager_config WHERE 1");
    $database->loadObjectList();
	if ($database->getErrorNum()) {
		$database->setQuery("ALTER TABLE #__adsmanager_config ADD `expiration` TINYINT DEFAULT '1' NOT NULL AFTER `display_last`");
		$result = $database->query();
		$database->setQuery("ALTER TABLE #__adsmanager_config ADD `ad_duration` INT DEFAULT '30' NOT NULL AFTER `expiration`");
		$result = $database->query();
		$database->setQuery("ALTER TABLE #__adsmanager_config ADD `recall` TINYINT DEFAULT '1' NOT NULL AFTER `ad_duration`");
		$result = $database->query();
		$database->setQuery("ALTER TABLE #__adsmanager_config ADD `recall_time` INT DEFAULT '7' NOT NULL AFTER `recall`");
		$result = $database->query();
		$database->setQuery("ALTER TABLE #__adsmanager_config ADD `recall_text` TEXT NOT NULL AFTER `recall_time`");
		$result = $database->query();
		
		$database->setQuery("ALTER TABLE #__adsmanager_ads ADD `date_recall` DATE NULL AFTER `date_created`");
		$result = $database->query();
		$database->setQuery("ALTER TABLE #__adsmanager_ads ADD `recall_mail_sent` TINYINT DEFAULT '0' NOT NULL AFTER `date_recall`");
		$result = $database->query();
		
		$database->setQuery("ALTER TABLE #__adsmanager_ads ADD `views` INT DEFAULT '0' NOT NULL AFTER `recall_mail_sent`");
		$result = $database->query();
		
		$database->setQuery("ALTER TABLE #__adsmanager_fields ADD `editable` TINYINT DEFAULT '1' NOT NULL AFTER `cb_field`");
		$result = $database->query();
		
		$database->setQuery("ALTER TABLE #__adsmanager_fields ADD `searchable` TINYINT DEFAULT '1' NOT NULL AFTER `editable`");
		$result = $database->query();
    }
    
    //Update to 2.1.2
    $database->setQuery("SELECT catsid FROM #__adsmanager_fields WHERE 1");
    $database->loadObjectList();
    if ($database->getErrorNum()) {
		$database->setQuery("ALTER TABLE #__adsmanager_fields ADD `catsid` VARCHAR(255) DEFAULT ',-1,' NOT NULL AFTER `sort_direction`");
		$result = $database->query();
    }
    
    //Update to 2.1.4 
    $database->setQuery("SELECT display_title FROM #__adsmanager_fields WHERE 1");
    $database->loadObjectList();
    if ($database->getErrorNum()) {
		$database->setQuery("ALTER TABLE #__adsmanager_fields ADD `display_title` TINYINT DEFAULT '0' NOT NULL AFTER `title`");
		$result = $database->query();
    }
    
    //Update to 2.1.5
    $database->setQuery("SELECT catsid FROM #__adsmanager_columns WHERE 1");
    $database->loadObjectList();
    if ($database->getErrorNum()) {
		$database->setQuery("ALTER TABLE #__adsmanager_columns ADD `catsid` VARCHAR( 255 ) DEFAULT ',-1,' NOT NULL AFTER `ordering`");
		$result = $database->query();
		
    }
       
    $database->setQuery("SELECT image_display FROM #__adsmanager_config WHERE 1");
    $database->loadObjectList();
	if ($database->getErrorNum()) {
		$database->setQuery("ALTER TABLE #__adsmanager_config ADD `image_display` VARCHAR( 50 ) NOT NULL DEFAULT 'default'");
		$result = $database->query();
    }
    
    $database->setQuery("SELECT cat_max_width FROM #__adsmanager_config WHERE 1");
    $database->loadObjectList();
    if ($database->getErrorNum()) {
		$database->setQuery("ALTER TABLE #__adsmanager_config ADD `cat_max_width` int(4) NOT NULL default '150'");
		$result = $database->query();
		$database->setQuery("ALTER TABLE #__adsmanager_config ADD `cat_max_height` int(4) NOT NULL default '150'");
		$result = $database->query();
		$database->setQuery("ALTER TABLE #__adsmanager_config ADD `cat_max_width_t` int(4) NOT NULL default '30'");
		$result = $database->query();
		$database->setQuery("ALTER TABLE #__adsmanager_config ADD `cat_max_height_t` int(4) NOT NULL default '30'");
		$result = $database->query();
    }
    
    $database->setQuery("SELECT submission_type FROM #__adsmanager_config WHERE 1");
    $database->loadObjectList();
	if ($database->getErrorNum()) {
		$database->setQuery("ALTER TABLE #__adsmanager_config ADD `submission_type` int(4) NOT NULL DEFAULT '0'");
		$result = $database->query();
    }
    
    $database->setQuery("SELECT nb_ads_by_user FROM #__adsmanager_config WHERE 1");
    $database->loadObjectList();
	if ($database->getErrorNum()) {
		$database->setQuery("ALTER TABLE #__adsmanager_config ADD `nb_ads_by_user` int(4) NOT NULL DEFAULT '-1'");
		$result = $database->query();
    }
    
    $database->setQuery("SELECT allow_attachement FROM #__adsmanager_config WHERE 1");
    $database->loadObjectList();
	if ($database->getErrorNum()) {
		$database->setQuery("ALTER TABLE #__adsmanager_config ADD `allow_attachement` tinyint(1) NOT NULL DEFAULT '0'");
		$result = $database->query();
    }
    
    $database->setQuery("SELECT allow_contact_by_pms FROM #__adsmanager_config WHERE 1");
    $database->loadObjectList();
	if ($database->getErrorNum()) {
		$database->setQuery("ALTER TABLE #__adsmanager_config ADD `allow_contact_by_pms` tinyint(1) NOT NULL DEFAULT '0'");
		$result = $database->query();
    }
    
    $database->setQuery("SELECT display_fullname FROM #__adsmanager_config WHERE 1");
    $database->loadObjectList();
	if ($database->getErrorNum()) {
		$database->setQuery("ALTER TABLE #__adsmanager_config ADD `display_fullname` tinyint(1) NOT NULL DEFAULT '0'");
		$result = $database->query();
    }
    
    $database->setQuery("SELECT show_rss FROM #__adsmanager_config WHERE 1");
    $database->loadObjectList();
	if ($database->getErrorNum()) {
		$database->setQuery("ALTER TABLE #__adsmanager_config ADD `show_rss` tinyint(1) NOT NULL DEFAULT '0'");
		$result = $database->query();
    }
    
    $database->setQuery("INSERT IGNORE INTO `#__adsmanager_positions` VALUES (6, 'description3', 'ADSMANAGER_POSITION_DESCRIPTION3');");
	$result = $database->query();

    /*$database->setQuery("SELECT device FROM #__adsmanager_config WHERE 1");
    $database->loadObjectList();
	if ($database->getErrorNum()) {
		$database->setQuery("ALTER TABLE #__adsmanager_config ADD `device` TEXT NOT NULL");
		$result = $database->query();
    }*/
    
    $database->setQuery("INSERT IGNORE INTO `#__adsmanager_config` VALUES (1, '1.0.1', 20, 2048000, 400, 300, 150, 100, 1,2,1,1,1,1, 'joomprod.com', '<p align=\"center\"><strong>Welcome to Ads Section.</strong></p><p align=\"left\">The better place to sell or buy</p>',0,0,'Inform the users about the rules here...',2,1,0,1,30,1,7,'Add This Text to recall message<br />','default',150,150,30,30,0,-1,0,0,0)");
    $result = $database->query();
?>

<center>
<table width="100%" border="0">
   <tr>
      <td>
      Thank you for using AdsManager (joomprod.com)<br/>
	 <p>
		<em>webmaster@joomprod.com</em>
	 </p>
      </td>
      <td>
         <p>
            <br>
            <br>
            <br>
         </p>
      </td>
   </tr>
</table>
</center>


<?php
}
?>