<?php
// no direct access
defined( '_VALID_MOS' ) or die( 'Restricted access' );

function selectCategories($id, $level, $children,$catid) {
	if (@$children[$id]) {
		foreach ($children[$id] as $row) {
			?>
			<option value="<?php echo $row->id; ?>" <?php if ($catid == $row->id) echo "selected='selected'"; ?>><?php echo $level.$row->name; ?></option>
			<?php 
			selectCategories($row->id, $level." >> ",$children,$catid);
		}
	}
}


/****************************************************/
$catid = intval( mosGetParam( $_GET, 'catid', -1 ));
$text_search = mosGetParam($_GET,'text_search','');
$itemid = intval($params->get( 'default_itemid', mosGetParam( $_GET, 'Itemid', 0 ) )) ;
$advanced_search = intval($params->get( 'advanced_search', 1)) ;

$database->setQuery( "SELECT c.* FROM #__adsmanager_categories as c ".
						 "WHERE c.published = 1 ORDER BY c.parent,c.ordering");
						 
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

if (file_exists($mosConfig_absolute_path .'/components/com_adsmanager/lang/lang_' . $mosConfig_lang . '.php'))
	include_once( $mosConfig_absolute_path .'/components/com_adsmanager/lang/lang_' . $mosConfig_lang . '.php' );
else
	include_once( $mosConfig_absolute_path .'/components/com_adsmanager/lang/lang_english.php' );

$url = "index.php";
?>
<form action="<?php echo $url; ?>" method="get">
<input type="hidden" name="option" value="com_adsmanager" />
<input type="hidden" name="Itemid" value="<?php echo $itemid; ?>" />
<input type="hidden" name="page" value="search" />
<input type="text" name="text_search" value="<?php echo $text_search; ?>" onblur="if(this.value=='') this.value='<?php echo $text_search; ?>';" onfocus="if(this.value=='<?php echo $text_search; ?>') this.value='';"/>
<select name="catid" id="category">
<option value="0" <?php if ($catid == -1) echo "selected='selected'"; ?>><?php echo ADSMANAGER_MENU_ALL_ADS; ?></option>
<?php selectCategories(0,"",$children,$catid); ?>
</select>
<input type="submit" value="<?php echo _SEARCH_TITLE; ?>"/>
</form>
<br /><br />
<?php if ($advanced_search == 1)
{
?>
<div><a href="<?php echo sefRelToAbs("index.php?option=com_adsmanager&amp;page=show_search&amp;catid=$catid&amp;Itemid=$itemid");?>"><?php echo ADSMANAGER_ADVANCED_SEARCH; ?></a></div>
<?php
}
?>