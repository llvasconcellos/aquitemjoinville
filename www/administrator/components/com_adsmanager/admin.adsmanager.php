<?php
//
// Copyright (C) 2006 Thomas Papin
// http://www.gnu.org/copyleft/gpl.html GNU/GPL

// This file is part of the AdsManager Component,
// a Joomla! Classifieds Component by Thomas Papin
// Email: thomas.papin@free.fr
//
// no direct access
defined('_VALID_MOS') or die('Direct Access to this location is not allowed.');

// ensure user has access to this function
if (!($acl->acl_check( 'administration', 'edit', 'users', $my->usertype, 'components', 'all' )
		| $acl->acl_check( 'administration', 'edit', 'users', $my->usertype, 'components', $option ))) {
	mosRedirect( 'index2.php', _NOT_AUTH );
}

require_once( $mainframe->getPath( 'admin_html' ) );
require_once( $mainframe->getPath( 'class' ) );
if (file_exists($mosConfig_absolute_path .'/components/'.$option.'/lang/lang_' . $mosConfig_lang . '.php'))
	include_once( $mosConfig_absolute_path .'/components/'.$option.'/lang/lang_' . $mosConfig_lang . '.php' );
else
	include_once( $mosConfig_absolute_path .'/components/'.$option.'/lang/lang_english.php' );

$act = mosGetParam( $_REQUEST, 'act', "" );
switch($act)
{
	case "configuration":	
	switch($task) {
		case "save":
			saveConfiguration($option);
			break;

		case "edit":
		default:
			editConfiguration($option);
			break;
	}
	break;
				
	case "ads":
	switch ($task) {
		case "save" :
			saveAd($option);
			break;

		case "edit" :
			displayAd( $option);
			break;

		case "new" :
			$id = '';
			newAd( $option);
			break;
	
		case "delete" :
			deleteAd($option);
			break;

		case "publish" :
			publishAd($option);
			break;

		case "listCategories" :
			default:
			listAds($option);
			break;

	}
	break;
	
	case "categories" :	
	switch($task) {
		case "save" :
			saveCategory($option);
			break;
			
		case "edit" :
			displayCategory($option);
			break;

		case "new" :
			newCategory( $option);
			break;
			
		case "delete" :
			deleteCategory($option);
			break;
			
		case "publish" :
			publishCategory($option);
			break;
			
		case 'orderup':
		$tid = mosGetParam( $_REQUEST, 'tid', array(0) );
		if (!is_array( $tid )) {
			$tid = array(0);
		}
		orderCategory( intval( $tid[0]), -1, $option );
		break;

		case 'orderdown':
		$tid = mosGetParam( $_REQUEST, 'tid', array(0) );
		if (!is_array( $tid )) {
			$tid = array(0);
		}
		orderCategory( intval( $tid[0] ), 1, $option );
		break;
		
		case 'saveorder':
		$tid = mosGetParam( $_REQUEST, 'tid', array(0) );
		if (!is_array( $tid )) {
			$tid = array(0);
		}
		saveOrder( $tid ,$option);
		break;
			
		default:
			listCategories($option);
	}
	break;
	
	case "tools":
	{
		switch($task) {
			case "installjoomfish":
				installJoomfish($option);
				break;
			case "installsef":
				installSEF($option);
				break;
			case "displayMarketplace":
				displayConvertMarketplace($option);
				break;
			case "importMarketplace":
				importMarketplace($option);
				break;
			default:
				displayTools($option);
				break;
		}
	}		
	break;
	
	case "columns":
	{	
		switch($task) {
			case "new":
			case "edit":
				editColumn($option);
				break;
				
			case "save":
				saveColumn($option);
				break;
				
			case "delete":
				removeColumn($option);
				break;
					
			default:
				showColumns($option);
				break;
		}
	}	
		break;
		
	case "positions":
	{	
		switch($task) {
			case "edit":
				editPosition($option);
				break;
				
			case "save":
				savePosition($option);
				break;
					
			default:
				showPositions($option);
				break;
		}
	}	
		break;
	
	case "fields":
	{	
		switch($task) {
			case "new":
			case "edit":
				editField($option);
				break;
				
			case "save":
				saveField($option);
				break;
				
			case "delete":
				removeField($option);
				break;
				
			case 'orderup':
			$tid = mosGetParam( $_REQUEST, 'tid', array(0) );
			if (!is_array( $tid )) {
				$tid = array(0);
			}
			orderField( intval( $tid[0]), -1, $option );
			break;
	
			case 'orderdown':
			$tid = mosGetParam( $_REQUEST, 'tid', array(0) );
			if (!is_array( $tid )) {
				$tid = array(0);
			}
			orderField( intval( $tid[0] ), 1, $option );
			break;
			
			case 'saveorder':
			$tid = mosGetParam( $_REQUEST, 'tid', array(0) );
			if (!is_array( $tid )) {
				$tid = array(0);
			}
			saveFieldOrder( $tid ,$option);
			break;
			
			case "publish" :
			publishField($option);
			break;
			
			case "required" :
			requiredField($option);
			break;
				
			default:
				showField($option);
				break;
		}
	}	
		break;
	
	default:
		displayMain($option);
		break;
}

function getLangDefinition($text) {
	if(defined($text)) $returnText = constant($text); 
	else $returnText = $text;
	return $returnText;
}

/****************************************************************************/
/******************       Configuration          ****************************/
/****************************************************************************/

function saveConfiguration($option) {
	global $database;
	$row = new adsManagerConf($database);

	// bind it to the table
	if (!$row -> bind($_POST)) {
		echo "<script> alert('"
			.$row -> getError()
			."'); window.history.go(-1); </script>\n";
		exit();
	}

	// store it in the db
	if (!$row -> store()) {
		echo "<script> alert('"
			.$row -> getError()
			."'); window.history.go(-1); </script>\n";
		exit();	
	}
	
	// clean any existing cache files
	mosCache::cleanCache( $option );

	mosRedirect("index2.php?option=$option&act=configuration", ADSMANAGER_CONFIGURATION_SAVED);
}


function editConfiguration($option)
{
	global $database;

	$database->setQuery("SELECT * FROM #__adsmanager_config"  );
	$rows = $database -> loadObjectList();
	if ($database -> getErrorNum()) {
		echo $database -> stderr();
		return false;
	}
	
	HTML_adsmanager::editConfiguration($option, $rows[0]);
}


/****************************************************************************/
/******************       Categories             ****************************/
/****************************************************************************/
function saveOrder( &$tid,$option ) {
	global $database;

	$total		= count( $tid );
	$order 		= mosGetParam( $_POST, 'order', array(0) );
	$row 		= new adsManagerCategory( $database );

	// update ordering values
	for( $i=0; $i < $total; $i++ ) {
		$row->load( $tid[$i] );
		if ($row->ordering != $order[$i]) {
			$row->ordering = $order[$i];
			if (!$row->store()) {
				echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
				exit();
			} // if
		} // if
	} // for

	// clean any existing cache files
	mosCache::cleanCache( $option );
	
	mosRedirect("index2.php?option=$option&act=categories", ADSMANAGER_CATEGORIES_REORDER);
} // saveOrder

/**
* Moves the order of a record
* @param integer The increment to reorder by
*/
function orderCategory( $uid, $inc, $option ) {
	global $database;

	$row = new adsManagerCategory( $database );
	$row->load( $uid );
	$row->move( $inc, "parent = $row->parent" );

	// clean any existing cache files
	mosCache::cleanCache( $option );

	mosRedirect("index2.php?option=$option&act=categories", "");
}

function displayCategory($option){
	global $database;
	
	$id = mosGetParam( $_REQUEST, 'tid', array(0) );
	if (is_array( $id )) {
		$id = $id[0];
	}
	
	if(!isset($id))
	{
		mosRedirect("index2.php?option=$option&act=contest", ADSMANAGER_ERROR_IN_URL);
		return;
	}
	
	$database->setQuery( "SELECT c.* FROM #__adsmanager_categories as c ".
						 "WHERE 1 ORDER BY c.parent,c.ordering");
	$rows = $database->loadObjectList();
	if ($database -> getErrorNum()) {
		echo $database -> stderr();
		return false;
	}
						 
	// establish the hierarchy of the menu
	$children = array();
	// first pass - collect children
	foreach ($rows as $v ) {
		$pt 	= $v->parent;
		$list 	= @$children[$pt] ? $children[$pt] : array();
		array_push( $list, $v );
		$children[$pt] = $list;
	}
	

	$database->setQuery("SELECT * FROM #__adsmanager_categories WHERE id=".$id );
	$rows = $database -> loadObjectList();
	if ($database -> getErrorNum()) {
		echo $database -> stderr();
		return false;
	}
	
	HTML_adsmanager::displaycategory($option, $rows[0],$children);
}

function newCategory( $option){
	global $database;
	$database->setQuery( "SELECT c.* FROM #__adsmanager_categories as c ".
						 "WHERE 1 ORDER BY c.parent,c.ordering");
	$rows = $database->loadObjectList();
	if ($database -> getErrorNum()) {
		echo $database -> stderr();
		return false;
	}
						 
	// establish the hierarchy of the menu
	$children = array();
	// first pass - collect children
	foreach ($rows as $v ) {
		$pt 	= $v->parent;
		$list 	= @$children[$pt] ? $children[$pt] : array();
		array_push( $list, $v );
		$children[$pt] = $list;
	}
	
	$row = new adsManagerCategory($database);
	
	HTML_adsmanager::displaycategory($option, $row,$children);
}

function saveCategory($option){
	global $database,$mosConfig_absolute_path;
	$row = new adsManagerCategory($database);

	// bind it to the table
	if (!$row -> bind($_POST)) {
		echo "<script> alert('"
			.$row -> getError()
			."'); window.history.go(-1); </script>\n";
		exit();
	}
	
	// store it in the db
	if (!$row -> store()) {
		echo "<script> alert('"
			.$row -> getError()
			."'); window.history.go(-1); </script>\n";
		exit();	
	}
	
	// get configuration
	$database->setQuery( "SELECT * FROM #__adsmanager_config");
	$confs = $database->loadObjectList();
	if ($database -> getErrorNum()) {
		echo $database -> stderr();
		return false;
	}
	
	// image2 delete
	if ( $_POST['cb_image'] == "delete") {
		$pict = $mosConfig_absolute_path."/images/$option/categories/".$row->id."cat.jpg";
		if ( file_exists( $pict)) {
			unlink( $pict);
		}
		$pict = $mosConfig_absolute_path."/images/$option/categories/".$row->id."cat_t.jpg";
		if ( file_exists( $pict)) {
			unlink( $pict);
		}
	}
							
	if (isset( $_FILES['cat_image'])) {
		if ( $_FILES['cat_image']['size'] > $confs[0]->max_image_size) {
			mosRedirect("index2.php?option=$option&act=categories", ADSMANAGER_IMAGETOOBIG);
			return;
		}
	}

	// image1 upload
	if (isset( $_FILES['cat_image']) and !$_FILES['cat_image']['error'] ) {
		$path= $mosConfig_absolute_path."/images/$option/categories/";
		createImageAndThumb($_FILES['cat_image']['tmp_name'],$row->id."cat.jpg",$row->id."cat_t.jpg",
							$confs[0]->cat_max_width,
							$confs[0]->cat_max_height,
							$confs[0]->cat_max_width_t,
							$confs[0]->cat_max_height_t,
							"",
							$path,
							$_FILES['cat_image']['name']);
	}	
	
	// clean any existing cache files
	mosCache::cleanCache( $option );

	mosRedirect("index2.php?option=$option&act=categories", ADSMANAGER_CATEGORY_SAVED);
}

function deleteCategory($option){
	global $database;
	
	$tid = $_POST['tid'];
	if (!is_array($tid) || count($tid) < 1) {
		echo "<script> alert('Select an category to delete'); window.history.go(-1);</script>\n";
		exit();
	}

	if (count($tid))
	{
		$ids = implode(',', $tid);
		$database->setQuery("SELECT * FROM #__adsmanager_categories \nWHERE id not IN ($ids) AND parent IN ($ids)");
		if ($database->loadResult()) 
		{
			echo "<script> alert('".ADSMANAGER_DELETE_CATEGORY_SELECT_CHIDLS."'); window.history.go(-1); </script>\n";
			exit();
		}
		$database->setQuery("DELETE FROM #__adsmanager_categories \nWHERE id IN ($ids)");
	}
	if (!$database->query()) {
		echo "<script> alert('"
			.$database -> getErrorMsg()
			."'); window.history.go(-1); </script>\n";
	}
	
	if (count($tid))
	{
		$ids = implode(',', $tid);
		$database->setQuery("DELETE FROM #__adsmanager_ads \nWHERE category IN ($ids)");
	}
	if (!$database->query()) {
		echo "<script> alert('"
			.$database -> getErrorMsg()
			."'); window.history.go(-1); </script>\n";
	}
	
	// clean any existing cache files
	mosCache::cleanCache( $option );
	
	mosRedirect("index2.php?option=$option&act=categories", ADSMANAGER_CATEGORIES_DELETED);
}

function listCategories($option){
	global $database;
	
	$database->setQuery( "SELECT c.* FROM #__adsmanager_categories as c ".
						 "WHERE 1 ORDER BY c.parent,c.ordering");
	$rows = $database->loadObjectList();
	if ($database -> getErrorNum()) {
		echo $database -> stderr();
		return false;
	}
	
	require_once( $GLOBALS['mosConfig_absolute_path'] . '/administrator/includes/pageNavigation.php' );
	$pageNav = new mosPageNav( count($rows), 0,count($rows) );
						 
	// establish the hierarchy of the menu
	$children = array();
	// first pass - collect children
	foreach ($rows as $v ) {
		$pt 	= $v->parent;
		$list 	= @$children[$pt] ? $children[$pt] : array();
		array_push( $list, $v );
		$children[$pt] = $list;
	}
	
	HTML_adsmanager::listcategories($option, count($rows),$children,$pageNav);
}

function publishCategory($option){
	global $database;
	
	$tid = $_GET['tid'];
	if (!is_array($tid) || count($tid) < 1) {
		echo "<script> alert('Select an item to publish'); window.history.go(-1);</script>\n";
		exit();
	}
	
	if(isset($_GET['publish']))
	{
		$publish = $_GET['publish'];
	}
	else
	{
		mosRedirect("index2.php?option=$option&act=categories", ADSMANAGER_ERROR_IN_URL);
		return;
	}

	if (count($tid))
	{
		$ids = implode(',', $tid);
		$database->setQuery("UPDATE #__adsmanager_categories SET `published` = '$publish' WHERE `id` IN ($ids) ");
	}
	if (!$database->query()) {
		echo "<script> alert('"
			.$database -> getErrorMsg()
			."'); window.history.go(-1); </script>\n";
	}
	
	// clean any existing cache files
	mosCache::cleanCache( $option );
	
	mosRedirect("index2.php?option=$option&act=categories","");
}

/****************************************************************************/
/******************       Ads                    ****************************/
/****************************************************************************/
function createImageAndThumb($src_file,$image_name,$thumb_name,
							$max_width,
						    $max_height,
							$max_width_t,
							$max_height_t,
							$tag,
							$path,
							$orig_name)
{
    ini_set('memory_limit', '20M');
	
	$src_file = urldecode($src_file);
	
	/*if (extension_loaded('exif')) 
	{
		$type2 = exif_imagetype($src_file);
		$types = array( 
			IMAGETYPE_JPEG => 'jpeg', 
			IMAGETYPE_GIF => 'gif', 
			IMAGETYPE_PNG => 'png' 
		); 
    
		$type = $types[$type2]; 
	}
	else
	{*/
		$orig_name = strtolower($orig_name);
		$findme  = '.jpg';
		$pos = strpos($orig_name, $findme);
		if ($pos === false)
		{
			$findme  = '.jpeg';
			$pos = strpos($orig_name, $findme);
			if ($pos === false)
			{
				$findme  = '.gif';
				$pos = strpos($orig_name, $findme);
				if ($pos === false)
				{
					$findme  = '.png';
					$pos = strpos($orig_name, $findme);
					if ($pos === false)
					{
						return;
					}
					else
					{
						$type = "png";
					}
				}
				else
				{
					$type = "gif";
				}
			}
			else
			{
				$type = "jpeg";
			}
		}
		else
		{
			$type = "jpeg";
		}
	//}
	
	$max_h = $max_height;
	$max_w = $max_width;
	$max_thumb_h = $max_height_t;
	$max_thumb_w = $max_width_t;
	
	if ( file_exists( "$path/$image_name")) {
		unlink( "$path/$image_name");
	}
	
	if ( file_exists( "$path/$thumb_name")) {
		unlink( "$path/$thumb_name");
	}
	
	$read = 'imagecreatefrom' . $type; 
	$write = 'image' . $type; 
	
	$src_img = $read($src_file);
	
	// height/width
	$imginfo = getimagesize($src_file);
	$src_w = $imginfo[0];
	$src_h = $imginfo[1];
	
	$zoom_h = $max_h / $src_h;
    $zoom_w = $max_w / $src_w;
    $zoom   = min($zoom_h, $zoom_w);
    $dst_h  = $zoom<1 ? round($src_h*$zoom) : $src_h;
    $dst_w  = $zoom<1 ? round($src_w*$zoom) : $src_w;
	
	$zoom_h = $max_thumb_h / $src_h;
    $zoom_w = $max_thumb_w / $src_w;
    $zoom   = min($zoom_h, $zoom_w);
    $dst_thumb_h  = $zoom<1 ? round($src_h*$zoom) : $src_h;
    $dst_thumb_w  = $zoom<1 ? round($src_w*$zoom) : $src_w;
	
	$dst_img = imagecreatetruecolor($dst_w,$dst_h);
	$white = imagecolorallocate($dst_img,255,255,255);
	imagefill($dst_img,0,0,$white);
	imagecopyresampled($dst_img,$src_img, 0,0,0,0, $dst_w,$dst_h,$src_w,$src_h);
	$textcolor = imagecolorallocate($dst_img, 255, 255, 255);
	if (isset($tag))
		imagestring($dst_img, 5, 5, 5, "$tag", $textcolor);    
	if($type == 'jpeg'){
        $desc_img = $write($dst_img,"$path/$image_name", 75);
	}else{
        $desc_img = $write($dst_img,"$path/$image_name", 2);
	}
	
	
	$dst_t_img = imagecreatetruecolor($dst_thumb_w,$dst_thumb_h);
	$white = imagecolorallocate($dst_t_img,255,255,255);
	imagefill($dst_t_img,0,0,$white);
	imagecopyresampled($dst_t_img,$src_img, 0,0,0,0, $dst_thumb_w,$dst_thumb_h,$src_w,$src_h);
	$textcolor = imagecolorallocate($dst_t_img, 255, 255, 255);
	if (isset($tag))
		imagestring($dst_t_img, 2, 2, 2, "$tag", $textcolor);
	if($type == 'jpeg'){
        $desc_img = $write($dst_t_img,"$path/$thumb_name", 75);
	}else{
        $desc_img = $write($dst_t_img,"$path/$thumb_name", 2);
	}

}

function saveAd($option){
	global $database,$mosConfig_absolute_path;
	$row = new adsManagerAd($database);

	// bind it to the table
	if (!$row -> bind($_POST)) {
		echo "<script> alert('"
			.$row -> getError()
			."'); window.history.go(-1); </script>\n";
		exit();
	}

	// store it in the db
	if (!$row -> store()) {
		echo "<script> alert('"
			.$row -> getError()
			."'); window.history.go(-1); </script>\n";
		exit();	
	}
	
	// get configuration
	$database->setQuery( "SELECT * FROM #__adsmanager_config");
	$rows = $database->loadObjectList();
	if ($database -> getErrorNum()) {
		echo $database -> stderr();
		return false;
	}
	
	//get fields
	$database->setQuery( "SELECT * FROM #__adsmanager_fields WHERE published = 1");
	$fields = $database->loadObjectList();
	if ($database -> getErrorNum()) {
		echo $database -> stderr();
		return false;
	}	
	
	$query .= "UPDATE #__adsmanager_ads ";
	
	$first=0;
	foreach($fields as $field)
	{ 	
		if ($field->type == "multiselect")
		{	
			$value = mosGetParam( $_POST, $field->name, array() );
			//$valueA = explode("|*|",$value);
			$value = ",".implode(',', $value).",";
			if ($first == 0)
				$query .= "SET"; 
			else
				$query .= ",";
			$first = 1;
			$query .= " $field->name = '".$value."' ";		
		}
		else if ($field->type == "multicheckbox")
		{
			$value = mosGetParam( $_POST, $field->name, array() );
			$value = ",".implode(',', $value).",";
			if ($first == 0)
				$query .= "SET"; 
			else
				$query .= ",";
			$first = 1;
			$query .= " $field->name = '".$value."' ";
		}
		else if ($field->type == "file")
		{
			if (isset( $_FILES[$field->name]) and !$_FILES[$field->name]['error'] ) {
				$database->setQuery( "SELECT ".$field->name." FROM #__adsmanager_ads WHERE id = ".$row->id);
				$old_filename = $database->loadResult();
				@unlink($mosConfig_absolute_path."/images/com_adsmanager/files/".$old_filename);
				
				$filename = $_FILES[$field->name]['name'];
				while(file_exists($mosConfig_absolute_path."/images/com_adsmanager/files/".$filename)){
					$filename = "copy_".$filename;
				}
				@move_uploaded_file($_FILES[$field->name]['tmp_name'],
									$mosConfig_absolute_path."/images/com_adsmanager/files/".$filename);									
				if ($first == 0)
					$query .= "SET"; 
				else
					$query .= ",";
				$first = 1;
				$query .= " $field->name = '".$filename."' ";
			}
		}
		else
		{
			$value = mosGetParam( $_POST, $field->name, "" );
			if ($first == 0)
				$query .= "SET"; 
			else
				$query .= ",";
			$first = 1;
			$query .= " $field->name = '".$value."' ";
		}
	}
	$query .= "WHERE id = ".$row->id;
	
	if ($first != 0)
	{
		$database->setQuery( $query);
		$database->query();
	}
	
	$nbImages = $rows[0]->nb_images;
	
	for($i = 1 ;$i < $nbImages + 1; $i++)
	{	
		$ext_name = chr(ord('a')+$i-1);
		$cb_image = mosGetParam( $_POST, "cb_image$i", "" );
		// image1 delete
		if ( $cb_image == "delete") {
			$pict = $mosConfig_absolute_path."/images/$option/ads/".$row->id.$ext_name."_t.jpg";
			if ( file_exists( $pict)) {
				unlink( $pict);
			}
			$pic = $mosConfig_absolute_path."/images/$option/ads/".$row->id.$ext_name.".jpg";
			if ( file_exists( $pic)) {
				unlink( $pic);
			}
		}
							
		if (isset( $_FILES["ad_picture$i"])) {
			if ( $_FILES["ad_picture$i"]['size'] > $rows[0]->max_image_size) {
				mosRedirect("index2.php?option=$option&act=ads&catid=".$row->category, ADSMANAGER_IMAGETOOBIG);
				return;
			}
		}
		
		// image1 upload
		if (isset( $_FILES["ad_picture$i"]) and !$_FILES["ad_picture$i"]['error'] ) {
			createImageAndThumb($_FILES["ad_picture$i"]['tmp_name'],$row->id.$ext_name.".jpg",$row->id.$ext_name."_t.jpg",
								$rows[0]->max_width,
								$rows[0]->max_height,
								$rows[0]->max_width_t,
								$rows[0]->max_height_t,
								$rows[0]->tag,
								$mosConfig_absolute_path."/images/$option/ads/",
								$_FILES["ad_picture$i"]['name']);
		}
	}
	
	// clean any existing cache files
	mosCache::cleanCache( $option );

	mosRedirect("index2.php?option=$option&act=ads&catid=".$row->category, ADSMANAGER_AD_SAVED);
}

function displayAd( $option ){
	global $database;
	
	$id = mosGetParam( $_REQUEST, 'tid', array(0) );
	if (is_array( $id )) {
		$id = $id[0];
	}
	
	if(!isset($id))
	{
		mosRedirect("index2.php?option=$option&act=ads", ADSMANAGER_ERROR_IN_URL);
		return;
	}
	
	$database->setQuery( "SELECT c.* FROM #__adsmanager_categories as c ".
						 "WHERE 1 ORDER BY c.parent,c.ordering");
	$rows = $database->loadObjectList();
	if ($database -> getErrorNum()) {
		echo $database -> stderr();
		return false;
	}
						 
	// establish the hierarchy of the menu
	$children = array();
	// first pass - collect children
	foreach ($rows as $v ) {
		$pt 	= $v->parent;
		$list 	= @$children[$pt] ? $children[$pt] : array();
		array_push( $list, $v );
		$children[$pt] = $list;
	}

	$database->setQuery("SELECT * FROM #__adsmanager_ads WHERE id=".$id );
	$rows = $database -> loadObjectList();
	if ($database -> getErrorNum()) {
		echo $database -> stderr();
		return false;
	}
	
	// get configuration
	$database->setQuery( "SELECT * FROM #__adsmanager_config");
	$confs = $database->loadObjectList();
	if ($database -> getErrorNum()) {
		echo $database -> stderr();
		return false;
	}
	
	//get fields
	$database->setQuery( "SELECT * FROM #__adsmanager_fields WHERE published = 1 ORDER by ordering");
	$fields = $database->loadObjectList();
	if ($database -> getErrorNum()) {
		echo $database -> stderr();
		return false;
	}	
	
	//get value fields
	$database->setQuery( "SELECT * FROM #__adsmanager_field_values ORDER by ordering ");
	$fieldvalues = $database->loadObjectList();
	if ($database -> getErrorNum()) {
		echo $database -> stderr();
		return false;
	}
	
	$field_values = array();
	// first pass - collect children
	foreach ($fieldvalues as $v ) {
		$pt 	= $v->fieldid;
		$list 	= @$field_values[$pt] ? $field_values[$pt] : array();
		array_push( $list, $v );
		$field_values[$pt] = $list;
	}
	
	HTML_adsmanager::displayAd($option, $rows[0],$fields,$field_values,$children,$confs[0]->nb_images);
}

function newAd( $option){
	global $database;
	
	$database->setQuery( "SELECT c.* FROM #__adsmanager_categories as c ".
						 "WHERE 1 ORDER BY c.parent,c.ordering");
	$rows = $database->loadObjectList();
	if ($database -> getErrorNum()) {
		echo $database -> stderr();
		return false;
	}
						 
	// establish the hierarchy of the menu
	$children = array();
	// first pass - collect children
	foreach ($rows as $v ) {
		$pt 	= $v->parent;
		$list 	= @$children[$pt] ? $children[$pt] : array();
		array_push( $list, $v );
		$children[$pt] = $list;
	}
	
	$row = new adsManagerAd($database);
	
	// get configuration
	$database->setQuery( "SELECT * FROM #__adsmanager_config");
	$confs = $database->loadObjectList();
	if ($database -> getErrorNum()) {
		echo $database -> stderr();
		return false;
	}
	
	//get fields
	$database->setQuery( "SELECT * FROM #__adsmanager_fields WHERE published = 1 ORDER by ordering");
	$fields = $database->loadObjectList();
	if ($database -> getErrorNum()) {
		echo $database -> stderr();
		return false;
	}	
	
	//get value fields
	$database->setQuery( "SELECT * FROM #__adsmanager_field_values ORDER by ordering ");
	$fieldvalues = $database->loadObjectList();
	if ($database -> getErrorNum()) {
		echo $database -> stderr();
		return false;
	}
	
	$field_values = array();
	// first pass - collect children
	foreach ($fieldvalues as $v ) {
		$pt 	= $v->fieldid;
		$list 	= @$field_values[$pt] ? $field_values[$pt] : array();
		array_push( $list, $v );
		$field_values[$pt] = $list;
	}
	
	HTML_adsmanager::displayAd($option,$row,$fields,$field_values,$children,$confs[0]->nb_images);
}

function deleteAd($option){	
	global $database;
	
	$tid = $_POST['tid'];
	if (!is_array($tid) || count($tid) < 1) {
		echo "<script> alert('Select an item to delete'); window.history.go(-1);</script>\n";
		exit();
	}

	// get configuration
	$database->setQuery( "SELECT * FROM #__adsmanager_config");
	$database->loadObject($conf);
	if ($database -> getErrorNum()) {
		echo $database -> stderr();
		return false;
	}

	foreach ($tid as $adid)
	{
		$database->setQuery("SELECT * FROM #__adsmanager_ads WHERE id=$adid");
		$database->loadObject($ad);
		
		$database->setQuery( "SELECT name FROM #__adsmanager_fields WHERE `type` = 'file'");
		$file_fields = $database->loadObjectList();
		foreach($file_fields as $file_field)
		{
			$filename = "\$ad->".$file_field->name;
			eval("\$filename = \"$filename\";");
			@unlink($mosConfig_absolute_path."/images/com_adsmanager/files/".$filename);
		}
		
		$database->setQuery("DELETE FROM #__adsmanager_ads WHERE id=$adid");
		if ($database->getErrorNum()) {
			echo $database->stderr();
		} else {
			$database->query();
		}

		$nbImages = $conf->nb_images;
	
		for($i = 1 ;$i < $nbImages + 1; $i++)
		{	
			$ext_name = chr(ord('a')+$i-1);
			$pict = $mosConfig_absolute_path."/images/com_adsmanager/ads/".$ad->id.$ext_name."_t.jpg";
			if ( file_exists( $pict)) {
				unlink( $pict);
			}
			$pic = $mosConfig_absolute_path."/images/com_adsmanager/ads/".$ad->id.$ext_name.".jpg";
			if ( file_exists( $pic)) {
				unlink( $pic);
			}
		}
	}
	
	// clean any existing cache files
	mosCache::cleanCache( $option );
	
	mosRedirect("index2.php?option=$option&act=ads", ADSMANAGER_ADS_DELETED);
}

function recurseSearch ($rows,&$list,$catid){
	foreach($rows as $row) {
		if ($row->parent == $catid)
		{
			$list[]= $row->id;
			recurseSearch($rows,$list,$row->id);
		} 
	}
}

function listAds($option){
	global $database,$mosConfig_list_limit,$mainframe;
	
	$catid = mosGetParam( $_REQUEST, 'catid', 0 );
	
	$database->setQuery("SELECT c.name, c.id FROM #__adsmanager_categories as c WHERE id=".$catid);
	$cats = $database -> loadObjectList();
	if ($database -> getErrorNum()) {
		echo $database -> stderr();
		return false;
	}
	
	/****************************/	
	$database->setQuery( "SELECT c.* FROM #__adsmanager_categories as c ".
						 "WHERE 1 ORDER BY c.parent,c.ordering");
	$rows = $database->loadObjectList();
	if ($database -> getErrorNum()) {
		echo $database -> stderr();
		return false;
	}
						 
	// establish the hierarchy of the menu
	$children = array();
	// first pass - collect children
	foreach ($rows as $v ) {
		$pt 	= $v->parent;
		$listtemp 	= @$children[$pt] ? $children[$pt] : array();
		array_push( $listtemp, $v );
		$children[$pt] = $listtemp;
	}
	
	// establish the hierarchy of the menu
	$list[] = $catid;
	recurseSearch($rows,$list,$catid);
	$listids = implode(',', $list);
	$database->setQuery("SELECT count(*) FROM #__adsmanager_ads WHERE category IN ($listids)");			
	$total = $database->loadResult();
		
	$limit = intval( $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit ) );
	$limitstart = intval( $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 ) );
		
	$database->setQuery("SELECT a.*,u.username,c.name as catname FROM #__adsmanager_ads as a ".
						"LEFT JOIN #__users as u ON a.userid = u.id ". 
						"LEFT JOIN #__adsmanager_categories as c ON c.id = a.category ".
						"WHERE a.category IN ($listids) ".
						"ORDER BY a.id DESC",
						$limitstart,$limit);
		
	/********************************/				
	require_once( $GLOBALS['mosConfig_absolute_path'] . '/administrator/includes/pageNavigation.php' );
	$pageNav = new mosPageNav( $total, $limitstart,$limit );
	$navlink = "index2.php?option=$option&act=ads&catid=".$catid;

	$rows = $database -> loadObjectList();
	if ($database -> getErrorNum()) {
		echo $database -> stderr();
		return false;
	}
	
	if(!isset($cats[0]))
	{
		$cats[0]->id = 0;
		$cats[0]->name ="";
	}
	
	// get configuration
	$database->setQuery( "SELECT * FROM #__adsmanager_config");
	$confs = $database->loadObjectList();
	if ($database -> getErrorNum()) {
		echo $database -> stderr();
		return false;
	}
	
	HTML_adsmanager::listAds($cats[0],$option, $rows,$pageNav,$navlink,$children,$confs[0]->nb_images);
}

function publishAd($option){
	global $database;
	
	$tid = $_GET['tid'];
	if (!is_array($tid) || count($tid) < 1) {
		echo "<script> alert('Select an item to publish'); window.history.go(-1);</script>\n";
		exit();
	}
	
	$catid= $_GET['catid'];
	
	if(isset($_GET['publish']))
	{
		$publish = $_GET['publish'];
	}
	else
	{
		mosRedirect("index2.php?option=$option&act=ads&catid=".$catid, ADSMANAGER_ERROR_IN_URL);
		return;
	}

	if (count($tid))
	{
		$ids = implode(',', $tid);
		$database->setQuery("UPDATE #__adsmanager_ads SET `published` = '$publish' WHERE `id` IN ($ids) ");
	}
	if (!$database->query()) {
		echo "<script> alert('"
			.$database -> getErrorMsg()
			."'); window.history.go(-1); </script>\n";
	}
	mosRedirect("index2.php?option=$option&act=ads&catid=".$catid,"");
}


function displayConvertMarketplace($option){
	global $database;
	
	$database->setQuery( "SELECT c.* FROM #__marketplace_categories as c ".
						 "WHERE 1 ORDER BY c.parent,c.sort_order");
	$rows = $database->loadObjectList();
	if ($database -> getErrorNum()) {
		echo $database -> stderr();
		return false;
	}
						 
	// establish the hierarchy of the menu
	$children = array();
	// first pass - collect children
	foreach ($rows as $v ) {
		$pt 	= $v->parent;
		$list 	= @$children[$pt] ? $children[$pt] : array();
		array_push( $list, $v );
		$children[$pt] = $list;
	}
	
	$database->setQuery("SELECT a.*, c.name as cat FROM #__marketplace_ads as a ".
						"LEFT JOIN #__marketplace_categories as c ON c.id = a.category ".
						"WHERE 1 ".
						"ORDER BY a.id DESC");
	$ads = $database->loadObjectList();
	
	HTML_adsmanager::displayConvertMarketplace($option,$ads,$children);
}

function importMarketplace($option){
	global $database,$mosConfig_absolute_path;
	
	$database->setQuery( "SELECT c.* FROM #__marketplace_categories as c ".
						 "WHERE 1 ORDER BY c.parent,c.sort_order");
	$cats = $database->loadObjectList();
	if ($database -> getErrorNum()) {
		echo $database -> stderr();
		return false;
	}
	
	// get configuration
	$database->setQuery( "SELECT * FROM #__adsmanager_config");
	$confs = $database->loadObjectList();
	if ($database -> getErrorNum()) {
		echo $database -> stderr();
		return false;
	}
	
	foreach($cats as $cat) {
		if ((!isset($cat->name))||($cat->name=='')) { $name = 'NULL'; } else { $name = $cat->name; }
		if ((!isset($cat->description))||($cat->description=='')) { $description = 'NULL'; } else { $description = $cat->description; }
		
		$query = "INSERT INTO `#__adsmanager_categories` (`id`, `parent`, `name`, `description`, `ordering`, `published`) ".
				 "VALUES (".$cat->id.",".$cat->parent.",'".$cat->name."','".$cat->description."',".$cat->sort_order.",".$cat->published.")";
		$database->setQuery($query);
		$database->query();
		echo $query."<br/>";
		
		if((isset($cat->image))&&($cat->image != ''))
		{
			$pict = $mosConfig_absolute_path."/components/com_marketplace/images/categories/".$cat->image;
			$image_name = $mosConfig_absolute_path."/images/com_adsmanager/categories/".$cat->id."cat.jpg";
			$thumb_name = $mosConfig_absolute_path."/images/com_adsmanager/categories/".$cat->id."cat_t.jpg";
			if (file_exists($pict)) {
				$path= $mosConfig_absolute_path."/images/$option/categories/";
				createImageAndThumb($pict,$cat->id."cat.jpg",$cat->id."cat_t.jpg",
								$confs[0]->cat_max_width,
								$confs[0]->cat_max_height,
								$confs[0]->cat_max_width_t,
								$confs[0]->cat_max_height_t,
								"",
								$path,
								$cat->image);
				/*@copy($pict,$mosConfig_absolute_path."/images/com_adsmanager/categories/".$cat->id."cat.jpg");
				@copy($pict_t,$mosConfig_absolute_path."/images/com_adsmanager/categories/".$cat->id."cat_t.jpg");*/
			}
		}
	}
	
	$database->setQuery("SELECT a.*, c.name as cat FROM #__marketplace_ads as a ".
						"LEFT JOIN #__marketplace_categories as c ON c.id = a.category ".
						"WHERE 1 ".
						"ORDER BY a.id DESC");
	$ads = $database->loadObjectList();
	
	foreach($ads as $ad) {
		if ((!isset($ad->name))||($ad->name=='')) { $name = 'NULL'; } else { $name = $ad->name; }
		if ((!isset($ad->city))||($ad->city=='')) { $city = 'NULL'; } else { $city = $ad->city; }
		if ((!isset($ad->phone1))||($ad->phone1=='')) { $phone1 = 'NULL'; } else { $phone1 = $ad->phone1; }
		if ((!isset($ad->zip))||($ad->zip=='')) { $zip = 'NULL'; } else { $zip = $ad->zip; }
		if ((!isset($ad->ad_headline))||($ad->ad_headline=='')) { $ad_headline = 'NULL'; } else { $ad_headline = $ad->ad_headline; }
		if ((!isset($ad->ad_text))||($ad->ad_text=='')) { $ad_text = 'NULL'; } else { $ad_text = $ad->ad_text; }
		if ((!isset($ad->email))||($ad->email=='')) { $email = 'NULL'; } else { $email = $ad->email; }
		if ((!isset($ad->date_created))||($ad->date_created=='')) { $date_created = 'NULL'; } else { $date_created = $ad->date_created; }
		if ((!isset($ad->ad_price))||($ad->ad_price=='')) { $ad_price = 'NULL'; } else { $ad_price = $ad->ad_price; }
		
		$query = "INSERT INTO `#__adsmanager_ads` (`id`, `category`, `userid`, `name`, `zip`, ".
				 "`ad_city`, `ad_phone`, `email`, `ad_headline`, `ad_text`, ".
				 "`ad_price`, `date_created`, `published`) ".
				 " VALUES (".$ad->id.",".$ad->category.",".$ad->userid.",'".$name."','".$zip."','".
					$city."','".$phone1."','".$email."','".$ad_headline."','".$ad_text."',".
					$ad_price.",".$date_created.",".$ad->published.")";
		echo $query."<br/>";
		$database->setQuery($query);
		$database->query();
		
		$pict = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$ad->id."a.jpg";
		$pict_t = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$ad->id."a_t.jpg";
		if (file_exists( $pict)) {
			@copy($pict,$mosConfig_absolute_path."/images/com_adsmanager/ads/".$ad->id."a.jpg");
			@copy($pict_t,$mosConfig_absolute_path."/images/com_adsmanager/ads/".$ad->id."a_t.jpg");
		}
		
		$pict = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$ad->id."b.jpg";
		$pict_t = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$ad->id."b_t.jpg";
		if (file_exists( $pict)) {
			@copy($pict,$mosConfig_absolute_path."/images/com_adsmanager/ads/".$ad->id."b.jpg");
			@copy($pict_t,$mosConfig_absolute_path."/images/com_adsmanager/ads/".$ad->id."b_t.jpg");
		}	
		
		$pict = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$ad->id."c.jpg";
		$pict_t = $mosConfig_absolute_path."/components/com_marketplace/images/entries/".$ad->id."c_t.jpg";
		if (file_exists( $pict)) {
			@copy($pict,$mosConfig_absolute_path."/images/com_adsmanager/ads/".$ad->id."c.jpg");
			@copy($pict_t,$mosConfig_absolute_path."/images/com_adsmanager/ads/".$ad->id."c_t.jpg");
		}		
	}
	
	//mosRedirect("index2.php?option=$option&act=categories",ADSMANAGER_IMPORT_SUCCESS);
}

function displayTools($option){
	HTML_adsmanager::displayTools($option);
}

function displayMain($option){
	HTML_adsmanager::displayMain($option);
}

function showField( $option ) {
	global $database;

	$database->setQuery( "SELECT f.* FROM #__adsmanager_fields AS f ".
						 "WHERE 1 ORDER by f.ordering" );

	$rows = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return;
	}
	
	require_once( $GLOBALS['mosConfig_absolute_path'] . '/administrator/includes/pageNavigation.php' );
	$pageNav = new mosPageNav( count($rows), 0,count($rows) );

	HTML_adsmanager::showFields( $rows, $option ,$pageNav );
}

function editField($option) {
	global $database,$mosConfig_dbprefix;

	$tid = mosGetParam( $_REQUEST, 'tid', 0 );
	if (is_array( $tid )) {
		$tid = $tid[0];
	}

	$row = new adsManagerField( $database );
	// load the row from the db table
	$row->load( $tid );
	
	
	$database->setQuery( "SELECT c.* FROM #__adsmanager_columns AS c ".
						 "WHERE 1 ORDER by c.ordering" );

	$rows = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return;
	}
	
	$database->setQuery( "SELECT c.* FROM #__adsmanager_positions AS c WHERE 1 " );

	$rows2 = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return;
	}
	
	/****************************/	
	$database->setQuery( "SELECT c.* FROM #__adsmanager_categories as c ".
						 "WHERE 1 ORDER BY c.parent,c.ordering");
	$catstemp = $database->loadObjectList();
	if ($database -> getErrorNum()) {
		echo $database -> stderr();
		return false;
	}
						 
	// establish the hierarchy of the menu
	$cats = array();
	// first pass - collect children
	foreach ($catstemp as $v ) {
		$pt 	= $v->parent;
		$listtemp 	= @$cats[$pt] ? $cats[$pt] : array();
		array_push( $listtemp, $v );
		$cats[$pt] = $listtemp;
	}
	
	$columns = array();
	$types = array();
	$lists = array();
	$positions = array();
	$cbfields = array();
	$sort_direction = array();
	$display_title_list = array();

	$types[] = mosHTML::makeOption( 'checkbox', 'Check Box (Single)' );
	$types[] = mosHTML::makeOption( 'multicheckbox', 'Check Box (Muliple)' );
	//$types[] = mosHTML::makeOption( 'date', 'Date' );
	$types[] = mosHTML::makeOption( 'select', 'Drop Down (Single Select)' );
	$types[] = mosHTML::makeOption( 'multiselect', 'Drop Down (Multi-Select)' );
	$types[] = mosHTML::makeOption( 'emailaddress', 'Email Address' );	
	$types[] = mosHTML::makeOption( 'number', 'Number Text' );	
	$types[] = mosHTML::makeOption( 'price', 'Price' );	
	//$types[] = mosHTML::makeOption( 'editorta', 'Editor Text Area' );
	$types[] = mosHTML::makeOption( 'textarea', 'Text Area' );
	$types[] = mosHTML::makeOption( 'text', 'Text Field' );
	$types[] = mosHTML::makeOption( 'url', 'URL' );
	$types[] = mosHTML::makeOption( 'radio', 'Radio Button' );
	$types[] = mosHTML::makeOption( 'file', 'File' );
	
	
	$columns[] = mosHTML::makeOption( '-1', 'No Column' );
	foreach($rows as $col)
	{
		if ((@$col->name)&&($col->name!=""))
			$coln = getLangDefinition($col->name);
		$columns[] = mosHTML::makeOption( "$col->id", "$coln" );
	}
	
	$fvalues = $database->setQuery( "SELECT fieldtitle,fieldvalue "
		. "\n FROM #__adsmanager_field_values"
		. "\n WHERE fieldid=$tid"
		. "\n ORDER BY ordering" );
	$fvalues = $database->loadObjectList();
	
	$database->setQuery("SHOW TABLES LIKE '".$mosConfig_dbprefix."comprofiler_fields'"  );
	//echo "SHOW TABLES LIKE '".$mosConfig_dbprefix."comprofiler_fields'" ;
	$tables = $database -> loadObjectList();
	if (count($tables) > 0)
	{
		echo "toto";
		$database->setQuery("SELECT * FROM #__comprofiler_fields WHERE 1"  );
		$cb_fields = $database -> loadObjectList();
	}
	
	$cbfields[] = mosHTML::makeOption( '-1', ADSMANAGER_NOT_USED );
	if (isset($cb_fields))
	{
		foreach($cb_fields as $cb)
		{
			$cbfields[] = mosHTML::makeOption( $cb->fieldid, "(".$cb->fieldid.") ".$cb->name );
		}
	}
	echo "count=".count($cb_fields);
	
	$positions[] = mosHTML::makeOption( '-1', ADSMANAGER_NO_DISPLAY );
	
	foreach($rows2 as $pos)
	{
		if ((@$pos->title)&&($pos->title!=""))
			$p = "(".getLangDefinition($pos->title).")";
		else
			$p = "";
		$positions[] = mosHTML::makeOption( "$pos->id", "$pos->name.$p" );
	}

	$sort_direction[] = mosHTML::makeOption( 'DESC', ADSMANAGER_CMN_SORT_DESC );
	$sort_direction[] = mosHTML::makeOption( 'ASC', ADSMANAGER_CMN_SORT_ASC );
	
	$display_title_list[] = mosHTML::makeOption( '0', ADSMANAGER_NO_DISPLAY );
	$display_title_list[] = mosHTML::makeOption( '1', ADSMANAGER_DISPLAY_DETAILS );
	$display_title_list[] = mosHTML::makeOption( '2', ADSMANAGER_DISPLAY_LIST );
	$display_title_list[] = mosHTML::makeOption( '3', ADSMANAGER_DISPLAY_LIST_AND_DETAILS );
	
	$lists['display_title'] = mosHTML::selectList( $display_title_list, 'display_title', 'class="inputbox" size="1"', 'value', 'text', $row->display_title );
		
	$lists['type'] = mosHTML::selectList( $types, 'type', 'class="inputbox" size="1" onchange="selType(this.options[this.selectedIndex].value);"', 'value', 'text', $row->type );

	$lists['required'] = mosHTML::yesnoSelectList( 'required', 'class="inputbox" size="1"', $row->required );
	
	$lists['columns'] = mosHTML::selectList( $columns, 'columnid', 'class="inputbox" size="1"', 'value', 'text', $row->columnid );

	$lists['positions'] = mosHTML::selectList( $positions, 'pos', 'class="inputbox" size="1"', 'value', 'text', $row->pos );

	$lists['profile'] = mosHTML::yesnoSelectList( 'profile', 'class="inputbox" size="1"', $row->profile );

	$lists['cbfields'] = mosHTML::selectList( $cbfields, 'cb_field', 'class="inputbox" size="1"', 'value', 'text', $row->cb_field );
	
	if (!isset($row->editable))
		$row->editable = 1;
	$lists['editable'] = mosHTML::yesnoSelectList( 'editable', 'class="inputbox" size="1"', $row->editable );
	
	$lists['searchable'] = mosHTML::yesnoSelectList( 'searchable', 'class="inputbox" size="1"', $row->searchable );
	
	$lists['sort'] = mosHTML::yesnoSelectList( 'sort', 'class="inputbox" size="1"', $row->sort );
	
	$lists['sort_direction'] = mosHTML::selectList( $sort_direction, 'sort_direction', 'class="inputbox" size="1"', 'value', 'text', $row->sort_direction );
	
	$lists['published'] = mosHTML::yesnoSelectList( 'published', 'class="inputbox" size="1"', $row->published );

	HTML_adsmanager::editfield( $row, $lists, $fvalues, $option, $tid ,$cats,count($catstemp));
}

function saveField( $option ) {
	global $database, $my, $_POST, $mosConfig_live_site, $ueConfig;

	$row = new adsManagerField( $database );
	if (!$row->bind( $_POST )) {
		echo "<script type=\"text/javascript\"> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	
	mosMakeHtmlSafe($row);

	$row->name = str_replace(" ", "", strtolower($row->name));
	
	if (!$row->check()) {
		echo "<script type=\"text/javascript\"> alert('".$row->getError()."'); window.history.go(-2); </script>\n";
		exit();
	}
	if (!$row->store($_POST['fieldid'])) {
		echo "<script type=\"text/javascript\"> alert('".$row->getError()."'); window.history.go(-2); </script>\n";
		exit();
	}
	$fieldValues = array();
	$fieldNames  = array();
	$fieldNames  = $_POST['vNames'];
	$fieldValues = $_POST['vValues'];
	$j=1;
	if($row->fieldid > 0) {
		$database->setQuery( "DELETE FROM #__adsmanager_field_values"
			. " WHERE fieldid='".$row->fieldid."'" );
		if(!$database->loadResult()) echo $database->getErrorMsg();
	} else {
		$database->setQuery( "SELECT MAX(fieldid) FROM #__adsmanager_fields");
		$maxID=$database->loadResult();
		$row->fieldid=$maxID;
		echo $database->getErrorMsg();
	}

	//foreach ($fieldNames as $fieldName) {
	$j=0;$i=0;
	while(isset($fieldNames[$i])){
		$fieldName  = $fieldNames[$i];
		$fieldValue = intval($fieldValues[$i]);
		$i++;
		
		if(trim($fieldName)!=null || trim($fieldName)!='') {
			$database->setQuery( "INSERT INTO #__adsmanager_field_values (fieldid,fieldtitle,fieldvalue,ordering)"
				. " VALUES('$row->fieldid','".htmlspecialchars($fieldName)."','".htmlspecialchars($fieldValue)."',$j)"
			);
			if(!$database->loadResult()) echo $database->getErrorMsg();
			$j++;
		}
	}
	
	$field_catsid = mosGetParam( $_POST, "field_catsid", array() );
	$field_catsid = ",".implode(',', $field_catsid).",";
	if ($field_catsid != "")
	{
		$query = "UPDATE #__adsmanager_fields SET catsid ='$field_catsid' WHERE fieldid=$row->fieldid ";
		$database->setQuery( $query);
		$database->query();
	}

	//Update Ad Fields
    $database->setQuery("SELECT $row->name FROM #__adsmanager_ads WHERE 1");
    $database->loadObjectList();
	if ($database->getErrorNum()) {
		$database->setQuery("ALTER TABLE #__adsmanager_ads ADD `$row->name` TEXT NOT NULL");
		$result = $database->query();
    }
    
    if ($row->profile == 1)
    {
		//Update Profile Fields
		$database->setQuery("SELECT $row->name FROM #__adsmanager_profile WHERE 1");
		$database->loadObjectList();
		if ($database->getErrorNum()) {
			$database->setQuery("ALTER TABLE #__adsmanager_profile ADD `$row->name` TEXT NOT NULL");
			$result = $database->query();
		}
	}
	else
	{
		//Update Profile Fields
		$database->setQuery("SELECT $row->name FROM #__adsmanager_profile WHERE 1");
		$database->loadObjectList();
		if (!$database->getErrorNum()) {
			$database->setQuery("ALTER TABLE #__adsmanager_profile DROP `$row->name`");
			$result = $database->query();
		}
	}

	mosRedirect( "index2.php?option=$option&act=fields", ADSMANAGER_UPDATE_SUCCESSFULL);
}

function removeField($option ) {
	global $database, $acl, $ueConfig;

	$tid = mosGetParam( $_REQUEST, 'tid', 0 );
	
	if (!is_array( $tid ) || count( $tid ) < 1) {
		echo "<script type=\"text/javascript\"> alert('Select an item to delete'); window.history.go(-1);</script>\n";
		exit;
	}
	$msg = '';
	
	foreach($tid as $id)
	{
		$row = new adsManagerField( $database );
		// load the row from the db table
		$row->load( $id );
		
		if(($row->name == "name")||($row->name == "email")||($row->name == "ad_text")||($row->name == "ad_headline"))
		{
			mosRedirect( "index2.php?option=$option&act=fields", ADSMANAGER_ERROR_SYSTEM_FIELD);
			return;
		}
	
		//Update Ad Fields
		$database->setQuery("SELECT $row->name FROM #__adsmanager_ads WHERE 1");
		$database->loadObjectList();
		if (!$database->getErrorNum()) {
			$database->setQuery("ALTER TABLE #__adsmanager_ads DROP `$row->name`");
			$result = $database->query();
		}
		
		//Update Profile Fields
		$database->setQuery("SELECT $row->name FROM #__adsmanager_profile WHERE 1");
		$database->loadObjectList();
		if (!$database->getErrorNum()) {
			$database->setQuery("ALTER TABLE #__adsmanager_profile DROP `$row->name`");
			$result = $database->query();
		}
	}
	
	if (count($tid))
	{
		$ids = implode(',', $tid);
		$database->setQuery("DELETE FROM #__adsmanager_fields WHERE fieldid IN ($ids)");
	}
	if (!$database->query()) {
		echo "<script> alert('"
			.$database -> getErrorMsg()
			."'); window.history.go(-1); </script>\n";
	}
	
	if (count($tid))
	{
		
		$ids = implode(',', $tid);
		$database->setQuery("DELETE FROM #__adsmanager_field_values WHERE fieldid  IN ($ids)");
	}
	if (!$database->query()) {
		echo "<script> alert('"
			.$database -> getErrorMsg()
			."'); window.history.go(-1); </script>\n";
	}
	
	mosRedirect( "index2.php?option=$option&act=fields", $msg );
}


function saveFieldOrder( &$tid,$option ) {
	global $database;

	$total		= count( $tid );
	$order 		= mosGetParam( $_POST, 'order', array(0) );
	$row 		= new adsManagerField( $database );

	// update ordering values
	for( $i=0; $i < $total; $i++ ) {
		$row->load( $tid[$i] );
		if ($row->ordering != $order[$i]) {
			$row->ordering = $order[$i];
			if (!$row->store()) {
				echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
				exit();
			} // if
		} // if
	} // for

	// clean any existing cache files
	mosCache::cleanCache( $option );
	
	mosRedirect("index2.php?option=$option&act=fields", ADSMANAGER_FIELDS_REORDER);
} // saveOrder

/**
* Moves the order of a record
* @param integer The increment to reorder by
*/
function orderField( $uid, $inc, $option ) {
	global $database;

	$row = new adsManagerField( $database );
	$row->load( $uid );
	$row->move( $inc, "1" );

	// clean any existing cache files
	mosCache::cleanCache( $option );

	mosRedirect("index2.php?option=$option&act=fields", "");
}

function publishField($option){
	global $database;
	
	$tid = $_GET['tid'];
	if (!is_array($tid) || count($tid) < 1) {
		echo "<script> alert('Select an item to publish'); window.history.go(-1);</script>\n";
		exit();
	}
	
	if(isset($_GET['publish']))
	{
		$publish = $_GET['publish'];
	}
	else
	{
		mosRedirect("index2.php?option=$option&act=fields", ADSMANAGER_ERROR_IN_URL);
		return;
	}

	if (count($tid))
	{
		$ids = implode(',', $tid);
		$database->setQuery("UPDATE #__adsmanager_fields SET `published` = '$publish' WHERE `fieldid` IN ($ids) ");
	}
	if (!$database->query()) {
		echo "<script> alert('"
			.$database -> getErrorMsg()
			."'); window.history.go(-1); </script>\n";
	}
	else
		mosRedirect("index2.php?option=$option&act=fields", "");
}

function requiredField($option){
	global $database;
	
	$tid = $_GET['tid'];
	if (!is_array($tid) || count($tid) < 1) {
		echo "<script> alert('Select an item to publish'); window.history.go(-1);</script>\n";
		exit();
	}
	
	if(isset($_GET['required']))
	{
		$required = $_GET['required'];
	}
	else
	{
		mosRedirect("index2.php?option=$option&act=fields", ADSMANAGER_ERROR_IN_URL);
		return;
	}

	if (count($tid))
	{
		$ids = implode(',', $tid);
		echo "UPDATE #__adsmanager_ads SET `required` = '$required' WHERE `fieldid` IN ($ids) ";
		$database->setQuery("UPDATE #__adsmanager_fields SET `required` = '$required' WHERE `fieldid` IN ($ids) ");
	}
	if (!$database->query()) {
		echo "<script> alert('"
			.$database -> getErrorMsg()
			."'); window.history.go(-1); </script>\n";
	}
	else
		mosRedirect("index2.php?option=$option&act=fields", ADSMANAGER_UPDATE_SUCCESSFULL);
}

function showColumns( $option ) {
	global $database;

	$database->setQuery( "SELECT c.* FROM #__adsmanager_columns AS c ".
						 "WHERE 1 ORDER by c.ordering" );

	$rows = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return;
	}
	
	$database->setQuery( "SELECT c.* FROM #__adsmanager_fields AS c ".
						 "WHERE c.columnid != -1 ORDER by c.columnorder,c.fieldid" );

	$fields = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return;
	}
	
	// establish the hierarchy of the menu
	$fColumn = array();
	// first pass - collect children
	foreach ($fields as $f ) {
		$pt 	= $f->columnid;
		$list 	= @$fColumn[$pt] ? $fColumn[$pt] : array();
		array_push( $list, $f );
		$fColumn[$pt] = $list;
	}

	HTML_adsmanager::showColumns( $rows, $fColumn,$option );
}

function editColumn($option) {
	global $database;

	$tid = mosGetParam( $_REQUEST, 'tid', 0 );
	if (is_array( $tid )) {
		$tid = $tid[0];
	}

	$row = new adsManagerColumn( $database );
	// load the row from the db table
	$row->load( $tid );
	
	
	/************* Mod by TomekOmel ***********/
	$database->setQuery( "SELECT c.* FROM #__adsmanager_categories as c ".
						 "WHERE 1 ORDER BY c.parent,c.ordering");
	$catstemp = $database->loadObjectList();
	if ($database -> getErrorNum()) {
		echo $database -> stderr();
		return false;
	}
			 
	// establish the hierarchy of the menu
	$cats = array();
	// first pass - collect children
	foreach ($catstemp as $v ) {
		$pt 	= $v->parent;
		$listtemp 	= @$cats[$pt] ? $cats[$pt] : array();
		array_push( $listtemp, $v );
		$cats[$pt] = $listtemp;
	}
	/************ Mod by TomekOmel *************/

	HTML_adsmanager::editColumn( $row, $option, $cats, count($catstemp));
}

function saveColumn( $option ) {
	global $database, $my, $_POST, $mosConfig_live_site, $ueConfig;

	$row = new adsManagerColumn( $database );
	if (!$row->bind( $_POST )) {
		echo "<script type=\"text/javascript\"> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	
	/************* Mod by TomekOmel ***********/
	
	mosMakeHtmlSafe($row);
	
	$field_catsid = mosGetParam( $_POST, "catsid", array() );
	$field_catsid = ",".implode(',', $field_catsid).",";
	
	if ($field_catsid != "")
	{
		$query = "UPDATE #__adsmanager_columns SET catsid ='$field_catsid' WHERE id=$row->id ";
		$database->setQuery( $query);
		$database->query();
	}
	/************ Mod by TomekOmel *************/
	
	if (!$row->store()) {
		echo "<script type=\"text/javascript\"> alert('".$row->getError()."'); window.history.go(-2); </script>\n";
		exit();
	}
	
	mosCache::cleanCache( $option );

	mosRedirect( "index2.php?option=$option&act=columns", ADSMANAGER_UPDATE_SUCCESSFULL);
}

function removeColumn($option ) {
	global $database, $acl, $ueConfig;

	$tid = mosGetParam( $_REQUEST, 'tid', 0 );
	
	if (!is_array( $tid ) || count( $tid ) < 1) {
		echo "<script type=\"text/javascript\"> alert('".ADSMANAGER_SELECT_ITEM_TO_BE_DELETED."'); window.history.go(-1);</script>\n";
		exit;
	}
	$msg = '';
	
	if (count($tid))
	{
		$ids = implode(',', $tid);
		$database->setQuery("DELETE FROM #__adsmanager_columns WHERE id IN ($ids)");
	}
	if (!$database->query()) {
		echo "<script> alert('"
			.$database -> getErrorMsg()
			."'); window.history.go(-1); </script>\n";
	}
	
	if (count($tid))
	{
		$ids = implode(',', $tid);
		$database->setQuery("UPDATE #__adsmanager_fields SET `columnid` = '-1' WHERE `columnid` IN ($ids) ");
	}
	if (!$database->query()) {
		echo "<script> alert('"
			.$database -> getErrorMsg()
			."'); window.history.go(-1); </script>\n";
	}
	
	mosRedirect( "index2.php?option=$option&act=columns", $msg );
}


function showPositions( $option ) {
	global $database;

	$database->setQuery( "SELECT * FROM #__adsmanager_positions WHERE 1 " );

	$rows = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return;
	}
	
	$database->setQuery( "SELECT f.* FROM #__adsmanager_fields AS f ".
						 "WHERE 1 ORDER by f.posorder" );

	$fields = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return;
	}
	
	// establish the hierarchy of the menu
	$fDisplay = array();
	// first pass - collect children
	foreach ($fields as $f ) {
		$pt 	= $f->pos;
		$list 	= @$fDisplay[$pt] ? $fDisplay[$pt] : array();
		array_push( $list, $f );
		$fDisplay[$pt] = $list;
	}

	HTML_adsmanager::showPositions( $rows, $fDisplay,$option );
}

function editPosition($option) {
	global $database;

	$tid = mosGetParam( $_REQUEST, 'tid', 0 );
	if (is_array( $tid )) {
		$tid = $tid[0];
	}

	$row = new adsManagerPosition( $database );
	// load the row from the db table
	$row->load( $tid );

	HTML_adsmanager::editPosition( $row, $option);
}

function savePosition( $option ) {
	global $database, $my, $_POST, $mosConfig_live_site, $ueConfig;

	$row = new adsManagerPosition( $database );
	if (!$row->bind( $_POST )) {
		echo "<script type=\"text/javascript\"> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	
	if (!$row->store()) {
		echo "<script type=\"text/javascript\"> alert('".$row->getError()."'); window.history.go(-2); </script>\n";
		exit();
	}

	mosRedirect( "index2.php?option=$option&act=positions", ADSMANAGER_UPDATE_SUCCESSFULL);
}

function installjoomfish($option)
{
	global $mosConfig_absolute_path;
	
	if(file_exists($mosConfig_absolute_path . "/administrator/components/com_joomfish/contentelements/")){
		$error = 0;
		
		@copy($mosConfig_absolute_path . "/administrator/components/$option/joomfish/adsmanager_ads.xml",$mosConfig_absolute_path . "/administrator/components/com_joomfish/contentelements/adsmanager_ads.xml");
			
		@copy($mosConfig_absolute_path . "/administrator/components/$option/joomfish/adsmanager_categories.xml",$mosConfig_absolute_path . "/administrator/components/com_joomfish/contentelements/adsmanager_categories.xml");

		@copy($mosConfig_absolute_path . "/administrator/components/$option/joomfish/adsmanager_columns.xml",$mosConfig_absolute_path . "/administrator/components/com_joomfish/contentelements/adsmanager_columns.xml");
			
		@copy($mosConfig_absolute_path . "/administrator/components/$option/joomfish/adsmanager_config.xml",$mosConfig_absolute_path . "/administrator/components/com_joomfish/contentelements/adsmanager_config.xml");
			
		@copy($mosConfig_absolute_path . "/administrator/components/$option/joomfish/adsmanager_fields.xml",$mosConfig_absolute_path . "/administrator/components/com_joomfish/contentelements/adsmanager_fields.xml");
		
		@copy($mosConfig_absolute_path . "/administrator/components/$option/joomfish/adsmanager_field_values.xml",$mosConfig_absolute_path . "/administrator/components/com_joomfish/contentelements/adsmanager_field_values.xml");
		
			
		mosRedirect( "index2.php?option=$option&act=tools", ADSMANAGER_INSTALL_SUCCESSFULL);
	}
	else
	{
		mosRedirect( "index2.php?option=$option&act=tools", ADSMANAGER_ERROR_INSTALL);
	}
}

function installsef($option)
{
	global $mosConfig_absolute_path;
	
	if(file_exists($mosConfig_absolute_path . "/components/com_sef/sef_ext/")){
		if(!file_exists($mosConfig_absolute_path . "/components/com_sef/sef_ext/$option.php"))
		{
			@copy($mosConfig_absolute_path . "/administrator/components/$option/sef/$option.php",$mosConfig_absolute_path . "/components/com_sef/sef_ext/$option.php");
			mosRedirect( "index2.php?option=$option&act=tools", ADSMANAGER_INSTALL_SUCCESSFULL);
		}
		else
		{
			mosRedirect( "index2.php?option=$option&act=tools", ADSMANAGER_ALREADY_INSTALL);
		}	
	}
	else
	{
		mosRedirect( "index2.php?option=$option&act=tools", ADSMANAGER_ERROR_INSTALL);
	}
}

?>