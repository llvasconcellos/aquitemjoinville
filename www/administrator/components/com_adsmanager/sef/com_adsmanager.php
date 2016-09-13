<?php

// Security check to ensure this file is being included by a parent file.
if (!defined('_VALID_MOS')) die('Direct Access to this location is not allowed.');


if (file_exists($GLOBALS['mosConfig_absolute_path'] .'/components/com_adsmanager/lang/lang_' . $GLOBALS['mosConfig_lang'] . '.php')){
	include_once($GLOBALS['mosConfig_absolute_path'] .'/components/com_adsmanager/lang/lang_' . $GLOBALS['mosConfig_lang'] . '.php');
}
else
	include_once( $GLOBALS['mosConfig_absolute_path'] .'/components/com_adsmanager/lang/lang_english.php' );
	
//Limitstart, limit nog toevoegen
$title[] = ADSMANAGER_SEF_ADS;

extract($vars);

switch ($vars['page']) {

  case 'show_profile': {
	$title[] = ADSMANAGER_SEF_PROFILE.$vars['userid']."/".ADSMANAGER_SEF_EDIT.$sefconfig->suffix;
    break;
  }
  
  case 'save_profile': {
	$title[] = ADSMANAGER_SEF_PROFILE.$vars['userid']."/".ADSMANAGER_SEF_SAVE.$sefconfig->suffix;
    break;
  }
  
  case 'show_user': {
	if (isset($vars['userid'])){
		$title[] = ADSMANAGER_SEF_USER."-".$vars['userid'].$sefconfig->suffix;
	}
	else
	{
		$title[] = ADSMANAGER_SEF_MY_ADS.$sefconfig->suffix;
	}
		
    break;
  }
  
  case 'show_category': {
	// get category-name: #__adsmanager_category
	$catid= $vars['catid'];
	
	if ($catid != 0)
	{
		$database->setQuery( "SELECT c.* FROM #__adsmanager_categories as c ".
								 "WHERE c.published = 1 ORDER BY c.parent,c.ordering");
								 
		$rows = $database->loadObjectList();
		if ($database -> getErrorNum()) {
			echo $database -> stderr();
			return false;
		}
							 
		// establish the hierarchy of the menu
		$orderlist = array();
		$current_list = array();
		// first pass - collect children
		foreach ($rows as $v ) {
			$orderlist[$v->id] = $v;
		}
	
		$current = $catid;
		while($orderlist[$current]->id != 0)
		{
			$current_list[] = $orderlist[$current]->name;
			$current = $orderlist[$current]->parent;
		}
	}
	
	$size = count($current_list);
	for($i = $size -1;$i>0;$i--)
	{
		$title[] = $current_list[$i];
	}
	$title[]=$current_list[0];
    break;
  }

  case 'show_rules': {
	$title[] = ADSMANAGER_RULES.$sefconfig->suffix;
    break;
  }

  case 'show_ad': {
	$adid = $vars['adid'];
	$database->setQuery("SELECT category, ad_headline FROM #__adsmanager_ads WHERE id=$adid");						
	$rows = $database->loadObjectList();
	$text = $rows[0]->ad_headline;
	$catid = $rows[0]->category;
	
	$database->setQuery( "SELECT c.* FROM #__adsmanager_categories as c ".
							 "WHERE c.published = 1 ORDER BY c.parent,c.ordering");
							 
	$rows = $database->loadObjectList();
	if ($database -> getErrorNum()) {
		echo $database -> stderr();
		return false;
	}
						 
	// establish the hierarchy of the menu
	$orderlist = array();
	// first pass - collect children
	foreach ($rows as $v ) {
		$orderlist[$v->id] = $v;
	}
	
	$current = $catid;
	if (count($orderlist) > 0)
	{
		while($orderlist[$current]->id != 0)
		{
			$current_list[] = $orderlist[$current]->name;
			$current = $orderlist[$current]->parent;
		}
	}

	$size = count($current_list);
	for($i = $size -1;$i>0;$i--)
	{
		$title[] = $current_list[$i];
	}
	if (count($current_list) > 0)
		$title[]= $current_list[0];
		
	$text = substr($text,0,40);
	
	$title[] = $text."-".$adid.$sefconfig->suffix;
    break;
  }

  case 'write_ad': {
	if (!isset($vars['adid'])) {
			$title[] = "ecrire-une-annonce".$sefconfig->suffix;
	}
	else
	{
		$adid = $vars['adid'];
		$database->setQuery("SELECT category, ad_headline FROM #__adsmanager_ads WHERE id=$adid");						
		$rows = $database->loadObjectList();
		$text = $rows[0]->ad_headline;
		$catid = $rows[0]->category;
		
		$database->setQuery("SELECT name, parent FROM #__adsmanager_categories WHERE published='1' AND id=$catid");
		
		$rows_categories = $database->loadObjectList();
		$cat_name = $rows_categories[0]->name;
		$parentid = $rows_categories[0]->parent;
	
		if ($parentid != 0)
		{
			$parent = $rows_categories[0]->parent;
			$database->setQuery("SELECT name FROM #__adsmanager_categories WHERE published='1' AND id=$parent");
			
			$rows_categories = $database->loadObjectList();
			$parent_name = $rows_categories[0]->name;
			$title[] = $parent_name;
		}
		
		$title[] = $cat_name;	
		
		$text = substr($text,0,40);
		
		$title[] = ADSMANAGER_SEF_UPDATE."-".$text."-".$adid.$sefconfig->suffix;
	}
    break;
  }
   
  case 'save_ad': {
	if (!isset($vars['adid'])) {
			$title[] = ADSMANAGER_SEF_SAVE_AD.$sefconfig->suffix;
	}
	else
	{
		$adid = $vars['adid'];
		$database->setQuery("SELECT category, ad_headline FROM #__adsmanager_ads WHERE id=$adid");						
		$rows = $database->loadObjectList();
		$text = $rows[0]->ad_headline;
		$catid = $rows[0]->category;
		
		$database->setQuery("SELECT name, parent FROM #__adsmanager_categories WHERE published='1' AND id=$catid");
		
		$rows_categories = $database->loadObjectList();
		$cat_name = $rows_categories[0]->name;
		$parentid = $rows_categories[0]->parent;
	
		if ($parentid != 0)
		{
			$parent = $rows_categories[0]->parent;
			$database->setQuery("SELECT name FROM #__adsmanager_categories WHERE published='1' AND id=$parent");
			
			$rows_categories = $database->loadObjectList();
			$parent_name = $rows_categories[0]->name;
			$title[] = $parent_name;
		}
		
		$title[] = $cat_name;	
		
		$text = substr($text,0,40);
		
		$title[] = ADSMANAGER_SEF_SAVE."-".$text."-".$adid.$sefconfig->suffix;
	}
    break;
  }

  case 'delete_ad': {
    if (!isset($vars['adid'])) {
			$title[] = ADSMANAGER_SEF_DELETE_AD.$sefconfig->suffix;
	}
	else
	{
		$adid = $vars['adid'];
		$database->setQuery("SELECT category, ad_headline FROM #__adsmanager_ads WHERE id=$adid");						
		$rows = $database->loadObjectList();
		$text = $rows[0]->ad_headline;
		$catid = $rows[0]->category;
		
		$database->setQuery("SELECT name, parent FROM #__adsmanager_categories WHERE published='1' AND id=$catid");
		
		$rows_categories = $database->loadObjectList();
		$cat_name = $rows_categories[0]->name;
		$parentid = $rows_categories[0]->parent;
	
		if ($parentid != 0)
		{
			$parent = $rows_categories[0]->parent;
			$database->setQuery("SELECT name FROM #__adsmanager_categories WHERE published='1' AND id=$parent");
			
			$rows_categories = $database->loadObjectList();
			$parent_name = $rows_categories[0]->name;
			$title[] = $parent_name;
		}
		
		$title[] = $cat_name;	
		$text = substr($text,0,40);
		
		$title[] = ADSMANAGER_SEF_DELETE."-".$text."-".$adid.$sefconfig->suffix;
	}
    break;
  }
  
  case 'show_all': {
	$title[] = ADSMANAGER_SEF_ALL_ADS.$sefconfig->suffix;
	break;
  }
  
  case 'show_search': {
	$title[] = ADSMANAGER_SEF_SHOW_SEARCH.$sefconfig->suffix;
	break;
  }
  
  case 'show_result': {
	$title[] = ADSMANAGER_SEF_SHOW_RESULT.$sefconfig->suffix;
	break;
  }

  default: {
     $title[] = "index".$sefconfig->suffix;
    break;
  }
}
//echo sef_404::sefGetLocation($string, $title);
$string = sef_404::sefGetLocation($string, $title);
?>