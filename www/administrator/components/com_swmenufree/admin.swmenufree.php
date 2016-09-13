<?php
/**
* swmenufree v4.6
* http://swonline.biz
* Copyright 2006 Sean White
**/

// ensure this file is being included by a parent file
//error_reporting (E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
if (file_exists($mosConfig_absolute_path.'/administrator/components/com_swmenufree/language/default.ini'))
{
$filename = $mosConfig_absolute_path.'/administrator/components/com_swmenufree/language/default.ini';
$handle = fopen($filename, "r");
$contents = fread($handle, filesize($filename));
fclose($handle);
	include($mosConfig_absolute_path.'/administrator/components/com_swmenufree/language/'.$contents);
}else
{
	include($mosConfig_absolute_path.'/administrator/components/com_swmenufree/language/english.php');
}
require_once( $mainframe->getPath( 'admin_html' ) );
require_once( $mosConfig_absolute_path . "/includes/frontend.php");
require_once( $mosConfig_absolute_path . "/administrator/components/com_swmenufree/admin.swmenufree.class.php");


$cid = mosGetParam( $_REQUEST, 'cid', array(0) );

if (!is_array( $cid )) {
	$cid = array(0);
}
switch ($task)
{
	case 'preview':
	preview($cid[0], $option );
	break;
	
	case 'images':
	imageManager($cid[0], $option );
	break;
	
	case 'imageFiles':
	imageFiles($cid[0], $option );
	break;
	
	case "saveedit":
	saveconfig($cid[0], $option);
	break;

	case 'changelanguage':
	changeLanguage( );
	break;
	
	case 'uploadfile':
	uploadPackage( );
	break;

	case "upgrade":
	upgrade($option);
	break;

	case "exportMenu":
	$msg= exportMenu($cid[0], $option);
	mosRedirect( "index2.php?task=showmodules&option=$option&limit=$limit&limitstart=$limitstart",$msg );
	break;

	case "manualsave":
	saveCSS($cid[0], $option);
	break;

	case "editDhtmlMenu":
	editDhtmlMenu( $cid[0], $option );
	break;

	case "editCSS":
	editCSS( $cid[0], $option );
	break;

	default:
	editDhtmlMenu( $cid[0], $option );
	break;
}

function preview( &$cid, $option )
{
	global $database,$mosConfig_absolute_path;
	include($mosConfig_absolute_path.'/administrator/components/com_swmenufree/preview.php');
}

function imageManager( &$cid, $option )
{
	global $database,$mosConfig_absolute_path,$mosConfig_live_site;
	include($mosConfig_absolute_path.'/administrator/components/com_swmenufree/ImageManager/manager.php');
}

function imageFiles( &$cid, $option )
{
	global $database,$mosConfig_absolute_path,$mosConfig_live_site;
	include($mosConfig_absolute_path.'/administrator/components/com_swmenufree/ImageManager/images.php');
}

function editDhtmlMenu($id, $option){
	global $database, $my, $mainframe, $mosConfig_absolute_path,$mosConfig_dbprefix;
	global $mosConfig_lang, $mosConfig_offset,$mosConfig_db;

	
	$swmenufree_array=array();
	$sql="SELECT id FROM #__modules where module='mod_swmenufree'";
	$database->setQuery($sql);
	$id=$database->loadResult();
	//echo $id;
	$now = date( "Y-m-d H:i:s", time()+$mosConfig_offset*60*60 );

	$row = new mosModule( $database );
	// load the row from the db table
	$row->load( $id );
	$params = mosParseParams( $row->params );
	$menu = @$params->menutype ? $params->menutype : 'mainmenu';
	$menustyle = @$params->menustyle ? $params->menustyle : 'transmenu';
	$hybrid = @$params->hybrid ? $params->hybrid: 0 ;
	$css_load = @$params->cssload ? $params->cssload: 0 ;
	$use_table = @$params->tables ? $params->tables: 0 ;
	$moduleID = @$params->moduleID;
	$parent_id = @$params->parentid ? $params->parentid : '0';
	$modulename = $row->title;
	$cache = @$params->cache ? $params->cache : 0;
	$moduleclass_sfx = @$params->moduleclass_sfx ? $params->moduleclass_sfx : "";
	$cache_time = @$params->cache_time ? $params->cache_time : "1 hour";
	$active_menu = @$params->active_menu ? $params->active_menu : 0;
	$parent_level = @$params->parent_level ? $params->parent_level: 0;
	$levels = @$params->levels ? $params->levels: 0;
	$onload_hack = @$params->onload_hack ? $params->onload_hack: 0;
	$editor_hack = @$params->editor_hack ? $params->editor_hack: 0;
	$sub_indicator = @$params->sub_indicator ? $params->sub_indicator: 0;
	$selectbox_hack = @$params->selectbox_hack ? $params->selectbox_hack: 0;
	$auto_position = @$params->auto_position ? $params->auto_position: 0;
	$padding_hack = @$params->padding_hack ? $params->padding_hack: 0;
	$show_shadow = @$params->show_shadow ? $params->show_shadow: 0;
	$template = @$params->template ? $params->template: "";
	$language = @$params->language ? $params->language: "";
	$component = @$params->component ? $params->component: "";

	
	if(!$id){
		$menustyle = mosGetParam( $_REQUEST, 'menutype', "transmenu" );
	}
		$row2 = new swmenufreeMenu( $database );
		$row2->load( '1' );
	
	if (!$row2->id){
		if (!$row2->gosumenu()) {
					echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
					exit();
				}
			$row2->id=1;
	}
	$padding1 = explode("px", $row2->main_padding);
	$padding2 = explode("px", $row2->sub_padding);
	for($i=0;$i<4; $i++){
		$padding1[$i]=trim($padding1[$i]);
		$padding2[$i]=trim($padding2[$i]);
	}
	$border1 = explode(" ", $row2->main_border);
	$border2 = explode(" ", $row2->sub_border);

	$border1[0]=rtrim(trim($border1[0]),'px');
	$border2[0]=rtrim(trim($border2[0]),'px');
	$border1[1]=trim($border1[1]);
	$border2[1]=trim($border2[1]);
	$border1[2]=trim($border1[2]);
	$border2[2]=trim($border2[2]);

	$border3 = explode(" ", $row2->main_border_over);
	$border4 = explode(" ", $row2->sub_border_over);

	$border3[0]=rtrim(trim($border3[0]),'px');
	$border4[0]=rtrim(trim($border4[0]),'px');
	$border3[1]=trim($border3[1]);
	$border4[1]=trim($border4[1]);
	$border3[2]=trim($border3[2]);
	$border4[2]=trim($border4[2]);

	$database->setQuery( "SELECT position, ordering, showtitle, title FROM #__modules"
	. "\nORDER BY ordering"
	);
	if (!($orders = $database->loadObjectList())) {
		echo $database->stderr();
		return false;
	}
	$lists=array();
	// build the order lists to be used to make the javascript arrays

	// hard code options for now
	$orders2 = array();
	$orders2['left'] = array();
	$orders2['right'] = array();
	$orders2['top'] = array();
	$orders2['bottom'] = array();
	$orders2['inset'] = array();
	$orders2['user1'] = array();
	$orders2['user2'] = array();

	$l = 0;
	$r = 0;
	for ($i=0, $n=count( $orders ); $i < $n; $i++) {
		$ord = 0;
		if (array_key_exists( $orders[$i]->position, $orders2 )) {
			$ord =count( array_keys( $orders2[$orders[$i]->position] ) ) + 1;
		}
		$orders2[$orders[$i]->position][] = mosHTML::makeOption( $ord, $ord.'::'.addslashes( $orders[$i]->title ) );
	}

	// make an array for the left and right positions
	foreach ( array_keys( $orders2 ) as $v ) {
		$ord = count( array_keys( $orders2[$v] ) ) + 1;
		$orders2[$v][] = mosHTML::makeOption( $ord, $ord.'::last' );
		##$pos[] = mosHTML::makeOption( 'left' );
		##$pos[] = mosHTML::makeOption( 'right' );
		$pos[] = mosHTML::makeOption( $v );
	}

	// build the html select list
	$lists['module_position'] = mosHTML::selectList( $pos, 'position2',
	'class="inputbox" size="1" onchange="changeDynaList(\'ordering\',orders,this.options[this.selectedIndex].value, originalPos, originalOrder);"',
	'value', 'text', $row->position ? $row->position : 'left' );

	// get selected pages for $lists['selections']

	$query = 'SELECT menuid AS value FROM #__modules_menu WHERE moduleid='.$id;
	$database->setQuery( $query );
	$lookup = $database->loadObjectList();

	$cssload[]= mosHTML::makeOption( '0', _SW_CSS_DYNAMIC_SELECT );
	$cssload[]= mosHTML::makeOption( '1', _SW_CSS_LINK_SELECT );
	$cssload[]= mosHTML::makeOption( '2', _SW_CSS_IMPORT_SELECT );
	$cssload[]= mosHTML::makeOption( '3', _SW_CSS_NONE_SELECT );
	$lists['cssload']= mosHTML::selectList( $cssload, 'cssload','id="cssload" class="inputbox" size="1" style="width:200px" ','value', 'text', $css_load ? $css_load : '0' );

	$cachet[]= mosHTML::makeOption( '10 seconds',  _SW_10SECOND_SELECT );
	$cachet[]= mosHTML::makeOption( '1 minute', _SW_1MINUTE_SELECT );
	$cachet[]= mosHTML::makeOption( '30 minutes', _SW_30MINUTE_SELECT );
	$cachet[]= mosHTML::makeOption( '1 hour', _SW_1HOUR_SELECT );
	$cachet[]= mosHTML::makeOption( '6 hours', _SW_6HOUR_SELECT );
	$cachet[]= mosHTML::makeOption( '12 hours', _SW_12HOUR_SELECT );
	$cachet[]= mosHTML::makeOption( '1 day', _SW_1DAY_SELECT );
	$cachet[]= mosHTML::makeOption( '3 days', _SW_3DAY_SELECT );
	$cachet[]= mosHTML::makeOption( '1 week', _SW_1WEEK_SELECT );
	$lists['cache_time']= mosHTML::selectList( $cachet, 'cache_time','id="cache_time" class="inputbox" size="1" style="width:200px" ','value', 'text', $cache_time ? $cache_time : '1 hour' );

	$tables[]= mosHTML::makeOption( '0', _SW_SHOW_TABLES_SELECT );
	$tables[]= mosHTML::makeOption( '1', _SW_SHOW_BLOGS_SELECT );
	$lists['tables']= mosHTML::selectList( $tables, 'tables','id="tables" class="inputbox" size="1" style="width:200px" ','value', 'text', $use_table ? $use_table : '0' );

	$lists['parent_level'] = mosHTML::integerSelectList(0,10,1, 'parent_level', 'class="inputbox"', $parent_level );
	$lists['levels'] = mosHTML::integerSelectList(0,10,1, 'levels', 'class="inputbox"', $levels );
	$lists['hybrid'] = mosHTML::yesnoRadioList( 'hybrid', 'class="inputbox"', $hybrid );
	$lists['active_menu'] = mosHTML::yesnoRadioList( 'active_menu', 'class="inputbox"', $active_menu );
	$lists['cache'] = mosHTML::yesnoRadioList( 'cache', 'class="inputbox"', $cache );
	$lists['onload_hack'] = mosHTML::yesnoRadioList( 'onload_hack', 'class="inputbox"', $onload_hack );
	$lists['editor_hack'] = mosHTML::yesnoRadioList( 'editor_hack', 'class="inputbox"', $editor_hack );
	$lists['padding_hack'] = mosHTML::yesnoRadioList( 'padding_hack', 'class="inputbox"', $padding_hack );
	$lists['auto_position'] = mosHTML::yesnoRadioList( 'auto_position', 'class="inputbox"', $auto_position );

	$lists['sub_indicator'] = mosHTML::yesnoRadioList( 'sub_indicator', 'class="inputbox"', $sub_indicator);
	$lists['selectbox_hack'] = mosHTML::yesnoRadioList( 'selectbox_hack', 'class="inputbox"', $selectbox_hack );
	$lists['show_shadow'] = mosHTML::yesnoRadioList( 'show_shadow', 'class="inputbox"', $show_shadow );

	$lists['showtitle'] = mosHTML::yesnoRadioList( 'showtitle', 'class="inputbox"', $row->showtitle?$row->showtitle:0);
	$lists['access']        = mosAdminMenus::Access( $row );
	// build the html select list for published
	$lists['published'] =mosHTML::yesnoRadioList( 'published', 'class="inputbox"', $row->published?$row->published:0);

	$query = 'SELECT DISTINCT #__menu.menutype AS value FROM #__menu';
	$database->setQuery( $query );
	$menutypes = $database->loadObjectList();
	//$menutypes3[]= mosHTML::makeOption( '-999', 'Select Source Menu' );
	//$menutypes3[]= mosHTML::makeOption( '-999', '-----------------' );
	$menutypes3[]= mosHTML::makeOption( 'swcontentmenu', _SW_SOURCE_CONTENT_SELECT );
	$menutypes3[]= mosHTML::makeOption( '-999', '-----------------');
	if(file_exists($mosConfig_absolute_path."/components/com_virtuemart/virtuemart.php")){
	$menutypes3[]= mosHTML::makeOption( 'virtuemart', 'Virtuemart Component' );
	$menutypes3[]= mosHTML::makeOption( '-999', '-----------------');
	}
	$menutypes3[]= mosHTML::makeOption( '-999', _SW_SOURCE_EXISTING_SELECT );
	$menutypes3[]= mosHTML::makeOption( '-999','-----------------' );



	foreach($menutypes as $menutypes2){
		$menutypes3[]= mosHTML::makeOption( addslashes($menutypes2->value), addslashes($menutypes2->value) );
	}
	$lists['menutype']= mosHTML::selectList( $menutypes3, 'menutype',' id="menutype" class="inputbox" size="1" style="width:200px" onchange="changeDynaList(\'parentid\',orders2,document.getElementById(\'menutype\').options[document.getElementById(\'menutype\').selectedIndex].value, originalPos2, originalOrder2);"','value', 'text', $menu ? $menu : 'mainmenu' );
	$categories3[]= mosHTML::makeOption( 0, 'TOP' );


	$sql =  "SELECT DISTINCT #__sections.id AS value, #__sections.title AS text
                FROM #__sections                                    
                INNER JOIN #__content ON #__content.sectionid = #__sections.id
                AND #__sections.published = 1
                ";

	$database->setQuery( $sql );
	$sections = $database->loadObjectList();
	$categories3[]= mosHTML::makeOption( -999, '--------' );
	$categories3[]= mosHTML::makeOption( -999, 'Sections' );
	$categories3[]= mosHTML::makeOption( -999, '--------' );
	foreach($sections as $sections2){
		$categories3[]= mosHTML::makeOption( ($sections2->value), $sections2->text );
	}
	$categories3[]= mosHTML::makeOption( -999, '----------' );
	$categories3[]= mosHTML::makeOption( -999, 'Categories' );
	$categories3[]= mosHTML::makeOption( -999, '----------' );


	$sql =  "SELECT DISTINCT #__categories.id AS value, #__categories.title AS text
                FROM #__categories                                  
                INNER JOIN #__content ON #__content.catid = #__categories.id
                AND #__categories.published = 1
                ";
	$database->setQuery( $sql );
	$categories = $database->loadObjectList();

	foreach($categories as $categories2){
		$categories3[]= mosHTML::makeOption( ($categories2->value+1000), $categories2->text );
	}

	foreach($categories3 as $category){
		$menuitems['swcontentmenu'][] = mosHTML::makeOption( $category->value, addslashes($category->text) );

	}

if(file_exists($mosConfig_absolute_path."/components/com_virtuemart/virtuemart.php")){
	$categories4[]= mosHTML::makeOption( 0, 'All Categories (top)' );


	$sql =  "SELECT DISTINCT #__vm_category.category_id AS value, #__vm_category.category_name AS text
                FROM #__vm_category ";

	$database->setQuery( $sql );
	$sections = $database->loadObjectList();
	$categories4[]= mosHTML::makeOption( -999, '--------' );
	$categories4[]= mosHTML::makeOption( -999, 'Categories' );
	$categories4[]= mosHTML::makeOption( -999, '--------' );
	foreach($sections as $sections2){
		$categories4[]= mosHTML::makeOption( ($sections2->value), $sections2->text );
	}

	foreach($categories4 as $category){
		$menuitems['virtuemart'][] = mosHTML::makeOption( $category->value, addslashes($category->text) );

	}
}
	$menuitems2=array();
	$database->setQuery( "SELECT m.*"
	. "\n FROM #__menu m"
	//. "\n WHERE type != 'url'"
	//. "\n WHERE type != 'separator'"
	. "\n WHERE published = '1'"
	. "\n ORDER BY menutype, parent, ordering"
	);
	$mitems = $database->loadObjectList();
	$mitems_temp = $mitems;

	// establish the hierarchy of the menu
	$children = array();
	// first pass - collect children
	foreach ( $mitems as $v ) {
		$id = $v->id;
		$pt = $v->parent;
		$list = @$children[$pt] ? $children[$pt] : array();
		array_push( $list, $v );
		$children[$pt] = $list;
	}
	// second pass - get an indent list of the items
	$list = swmenuTreeRecurse( intval( $mitems[0]->parent ), '', array(), $children );

	// Code that adds menu name to Display of Page(s)
	$text_count = "0";
	$mitems_spacer = "";
	foreach ($list as $list_a) {
		foreach ($mitems_temp as $mitems_a) {
			if ($mitems_a->id == $list_a->id) {
				// Code that inserts the blank line that seperates different menus
				if ($mitems_a->menutype <> $mitems_spacer) {
					$list_temp[] = mosHTML::makeOption( -99, '----' );
					$menuitems[$mitems_a->menutype][] = mosHTML::makeOption( 0, "TOP" );
					$mitems_spacer = $mitems_a->menutype;
				}
				$text = addslashes($mitems_a->menutype." / ".$list_a->treename);
				$text2 = addslashes($list_a->treename);
				$list_temp[] = mosHTML::makeOption( $list_a->id, $text );
				$menuitems[$mitems_a->menutype][] = mosHTML::makeOption( $list_a->id, $text2 );
				if ( strlen($text) > $text_count) {
					$text_count = strlen($text);
				}
			}
		}
	}
	$list = $list_temp;

	$mitems2 = array();
	$mitems2[] = mosHTML::makeOption( 0, 'All' );
	$mitems2[] = mosHTML::makeOption( -99, '----' );
	$mitems2[] = mosHTML::makeOption( -999, 'None' );

	foreach ($list as $item) {
		$mitems2[] = mosHTML::makeOption( $item->value, $item->text );
	}
	$lists['selections'] = mosHTML::selectList( $mitems2, 'selections[]', 'class="inputbox" size="20" style="width:580px" multiple="multiple"', 'value', 'text', $lookup?$lookup:0 );

	$database->setQuery( "SELECT DISTINCT #__templates_menu.template AS text FROM #__templates_menu WHERE client_id=0"	);
	$list = $database->loadObjectList();

	$template2 = array();
	$template2[] = mosHTML::makeOption( "All", 'All' );
	//$template[] = mosHTML::makeOption( -99, '----' );
	//$template[] = mosHTML::makeOption( -999, 'None' );

	foreach ($list as $item) {
		$template2[] = mosHTML::makeOption( $item->text, $item->text );
	}
	$lists['templates'] = mosHTML::selectList( $template2, 'template', 'class="inputbox"  style="width:130px" ', 'text', 'text', $template );

	if(TableExists($mosConfig_dbprefix."languages",$mosConfig_db)) {
	
	$database->setQuery( "SELECT DISTINCT #__languages.name AS text, #__languages.code AS value FROM #__languages"	);
	$list = $database->loadObjectList();

	$language2 = array();
	$language2[] = mosHTML::makeOption( "All", 'All' );
	//$template[] = mosHTML::makeOption( -99, '----' );
	//$template[] = mosHTML::makeOption( -999, 'None' );

	foreach ($list as $item) {
		$language2[] = mosHTML::makeOption( $item->value, $item->text );
	}
	$lists['languages'] = mosHTML::selectList( $language2, 'language', 'class="inputbox"  style="width:130px" ', 'value', 'text', $language );
	}else{
		
		$lists['languages']=$mosConfig_lang;
	}
	$database->setQuery( "SELECT DISTINCT #__components.name AS text, #__components.option AS value FROM #__components WHERE link !=''"	);
	$list = $database->loadObjectList();

	$component2 = array();
	$component2[] = mosHTML::makeOption( "All", 'All' );
	$component2[] = mosHTML::makeOption( "com_content", 'Content' );
	//$template[] = mosHTML::makeOption( -999, 'None' );

	foreach ($list as $item) {
		$component2[] = mosHTML::makeOption( $item->value, $item->text );
	}
	$lists['components'] = mosHTML::selectList( $component2, 'component', 'class="inputbox"  style="width:130px" ', 'value', 'text', $component );

	$align[]= mosHTML::makeOption( 'left','left' );
	$align[]= mosHTML::makeOption( 'right','right' );
	$align[]= mosHTML::makeOption( 'texttop','texttop' );
	$align[]= mosHTML::makeOption( 'absmiddle','absmiddle' );
	$align[]= mosHTML::makeOption( 'baseline','baseline' );
	$align[]= mosHTML::makeOption( 'absbottom','absbottom' );
	$align[]= mosHTML::makeOption( 'bottom','bottom' );
	$align[]= mosHTML::makeOption( 'middle','middle' );
	$align[]= mosHTML::makeOption( 'top','top' );
	$lists['align']= mosHTML::selectList( $align, 'tree-image_align','id="tree-image_align" class="inputbox" onchange="treeInfoUpdate();"','value', 'text', '' );

	$lists['showname'] = mosHTML::yesnoSelectList( 'tree-image_showname', 'class="inputbox" id="tree-image_showname" onchange="treeInfoUpdate();"', 1 );
	$lists['target'] = mosHTML::yesnoSelectList( 'tree-image_target', 'class="inputbox" id="tree-image_target" onchange="treeInfoUpdate();"', 1 );
	$lists['showitem'] = mosHTML::yesnoSelectList( 'tree-image_showitem', 'class="inputbox" id="tree-image_showitem" onchange="treeInfoUpdate();"', 1 );

	
	$cssload=array();
	$cssload[]= mosHTML::makeOption( 'none', 'none' );
	$cssload[]= mosHTML::makeOption( 'solid', 'solid' );
	$cssload[]= mosHTML::makeOption( 'dashed', 'dashed' );
	$cssload[]= mosHTML::makeOption( 'inset', 'inset' );
	$cssload[]= mosHTML::makeOption( 'outset', 'outset' );
	$cssload[]= mosHTML::makeOption( 'grooved', 'grooved' );
	$cssload[]= mosHTML::makeOption( 'double', 'double' );
	$lists['main_border_style']= mosHTML::selectList( $cssload, 'main_border_style','id="main_border_style" class="inputbox" onchange="doMainBorder();" size="1" style="width:100px"','value', 'text', $border1[1] );
	$lists['sub_border_style']= mosHTML::selectList( $cssload, 'sub_border_style','id="sub_border_style" class="inputbox" onchange="doSubBorder();" size="1" style="width:100px"','value', 'text', $border2[1] );
	$lists['main_border_over_style']= mosHTML::selectList( $cssload, 'main_border_over_style','id="main_border_over_style" class="inputbox" onchange="doMainBorder();" size="1" style="width:100px"','value', 'text', $border3[1] );
	$lists['sub_border_over_style']= mosHTML::selectList( $cssload, 'sub_border_over_style','id="sub_border_over_style" class="inputbox" onchange="doSubBorder();" size="1" style="width:100px"','value', 'text', $border4[1] );

	
	$cssload=array();
	$cssload[]= mosHTML::makeOption( 'Arial, Helvetica, sans-serif', 'Arial, Helvetica, sans-serif' );
	$cssload[]= mosHTML::makeOption( '\'Times New Roman\', Times, serif', 'Times New Roman, Times, serif' );
	$cssload[]= mosHTML::makeOption( 'Georgia, \'Times New Roman\', Times, serif', 'Georgia, Times New Roman, Times, serif' );
	$cssload[]= mosHTML::makeOption( 'Verdana, Arial, Helvetica, sans-serif', 'Verdana, Arial, Helvetica, sans-serif' );
	$cssload[]= mosHTML::makeOption( 'Geneva, Arial, Helvetica, sans-serif', 'Geneva, Arial, Helvetica, sans-serif' );
	$cssload[]= mosHTML::makeOption( 'Tahoma, Arial, sans-serif', 'Tahoma, Arial, sans-serif' );
	$lists['font_family']= mosHTML::selectList( $cssload, 'font_family','id="font_family" class="inputbox" size="1" style="width:230px"','value', 'text', $row2->font_family );
	$lists['sub_font_family']= mosHTML::selectList( $cssload, 'sub_font_family','id="sub_font_family" class="inputbox" size="1" style="width:230px"','value', 'text', $row2->sub_font_family );

	
	$cssload=array();
	$cssload[]= mosHTML::makeOption( 'normal', 'normal' );
	$cssload[]= mosHTML::makeOption( 'bold', 'bold' );
	$cssload[]= mosHTML::makeOption( 'bolder', 'bolder' );
	$cssload[]= mosHTML::makeOption( 'lighter', 'lighter' );
	$lists['font_weight']= mosHTML::selectList( $cssload, 'font_weight','id="font_weight" class="inputbox" size="1" style="width:100px"','value', 'text', $row2->font_weight );
	$lists['font_weight_over']= mosHTML::selectList( $cssload, 'font_weight_over','id="font_weight_over" class="inputbox" size="1" style="width:100px"','value', 'text', $row2->font_weight_over );

	$cssload=array();
	$cssload[]= mosHTML::makeOption( 'left', 'left' );
	$cssload[]= mosHTML::makeOption( 'right', 'right' );
	$cssload[]= mosHTML::makeOption( 'center', 'center' );
	$cssload[]= mosHTML::makeOption( 'justify', 'justify' );
	$lists['main_align']= mosHTML::selectList( $cssload, 'main_align','id="main_align" class="inputbox" size="1" style="width:100px"','value', 'text', $row2->main_align );
	$lists['sub_align']= mosHTML::selectList( $cssload, 'sub_align','id="sub_align" class="inputbox" size="1" style="width:100px"','value', 'text', $row2->sub_align );

	$cssload=array();
	if($menustyle=="tigramenu"){
		$cssload[]= mosHTML::makeOption( 'absolute', 'absolute' );
		$cssload[]= mosHTML::makeOption( 'relative', 'relative' );
		
	}else{
		$cssload[]= mosHTML::makeOption( 'left', 'left' );
		$cssload[]= mosHTML::makeOption( 'right', 'right' );
		$cssload[]= mosHTML::makeOption( 'center', 'center' );
	}
	$lists['position']= mosHTML::selectList( $cssload, 'position','id="position" class="inputbox" size="1" style="width:120px"','value', 'text', $row2->position ? $row2->position : '0' );

	$cssload=array();
	
		$cssload[]= mosHTML::makeOption( 'transmenu', _SW_TRANS_MENU );
		$cssload[]= mosHTML::makeOption( 'mygosumenu', _SW_MYGOSU_MENU );
		$cssload[]= mosHTML::makeOption( 'tigramenu', _SW_TIGRA_MENU );
		
	$lists['menustyle']= mosHTML::selectList( $cssload, 'menustyle','id="menustyle" class="inputbox" size="1" onChange="changeOrientation();" style="width:200px"','value', 'text', $menustyle ? $menustyle : 'transmenu' );

	
	$cssload=array();
	if($menustyle=="transmenu"){
		$cssload[]= mosHTML::makeOption( 'horizontal/down', 'horizontal/down/right' );
		$cssload[]= mosHTML::makeOption( 'vertical/right', 'vertical/right' );
		$cssload[]= mosHTML::makeOption( 'horizontal/up', 'horizontal/up' );
		$cssload[]= mosHTML::makeOption( 'vertical/left', 'vertical/left' );
		$cssload[]= mosHTML::makeOption( 'horizontal/left', 'horizontal/down/left' );
	}else{
		$cssload[]= mosHTML::makeOption( 'horizontal', 'horizontal' );
		$cssload[]= mosHTML::makeOption( 'vertical', 'vertical' );
	}
	$lists['orientation']= mosHTML::selectList( $cssload, 'orientation','id="orientation" class="inputbox" size="1" style="width:120px"','value', 'text', $row2->orientation ? $row2->orientation : '0' );

	HTML_swmenufree::MenuConfig( $menustyle,$row2,$row, $menu, $padding1, $padding2, $border1, $border2, $border3, $border4, $modulename, $parent_id,$orders2, $lists,$menuitems,$moduleclass_sfx);
	HTML_swmenufree::footer( );
		

}



function saveconfig($id, $option){

	global $database, $my, $mainframe,$mosConfig_absolute_path,$mosConfig_lang;

	$moduleid = mosGetParam( $_REQUEST, 'moduleID', array(0) );
	$menutype = mosGetParam( $_REQUEST, 'menutype', "mainmenu" );
	$menu = mosGetParam( $_REQUEST, 'menuid', array() );
	$export = mosGetParam( $_REQUEST, 'export2', 0 );
	
	$msg=_SW_SAVE_MENU_MESSAGE;

	$row = new mosModule( $database );
	if (!$row->bind( $_POST )) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	if (!$row->check()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	$row->position=mosGetParam($_POST, "position2", "left");
	if (!$row->store()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	$row->checkin();
	$row->updateOrder( "position='$row->position'" );

	$row->module="mod_swmenufree";

	$parent_id=mosGetParam( $_REQUEST, 'parentid', 0 );
	$levels=mosGetParam( $_REQUEST, 'levels', 0 );

	$moduleID = $row->id;
	$menustyle = mosGetParam( $_REQUEST, 'menustyle', 'popoutmenu' );
	$css_load = mosGetParam( $_REQUEST, 'cssload', 0 );
	$hybrid = mosGetParam( $_REQUEST, 'hybrid', 0 );
	$active_menu = mosGetParam( $_REQUEST, 'active_menu', 0 );
	$editor_hack = mosGetParam( $_REQUEST, 'editor_hack', 0 );
	$parent_level = mosGetParam( $_REQUEST, 'parent_level', 0 );
	$cache = mosGetParam( $_REQUEST, 'cache', 0 );
	$cache_time = mosGetParam( $_REQUEST, 'cache_time', "1 hour" );
	$moduleclass_sfx = mosGetParam( $_REQUEST, 'moduleclass_sfx', "" );
	$tables = mosGetParam( $_REQUEST, 'tables', 0 );

	$sub_indicator = mosGetParam( $_REQUEST, 'sub_indicator', 0 );

	$selectbox_hack = mosGetParam( $_REQUEST, 'selectbox_hack', 0 );
	$show_shadow = mosGetParam( $_REQUEST, 'show_shadow', 0 );
	$padding_hack = mosGetParam( $_REQUEST, 'padding_hack', 0 );
	$auto_position = mosGetParam( $_REQUEST, 'auto_position', 0 );

	$template = mosGetParam( $_REQUEST, 'template', "" );
	$language = mosGetParam( $_REQUEST, 'language', "" );

	$component = mosGetParam( $_REQUEST, 'component', "" );



	if(($row->module != "mod_mainmenu")){
		$params = "menutype=".$menutype."\n";
		$params.= "menustyle=".$menustyle."\n";
		$params.= "moduleID=".$row->id."\n";
		$params.= "levels=".$levels."\n";
		$params.= "parentid=".$parent_id."\n";
		$params.= "parent_level=".$parent_level."\n";
		$params.= "hybrid=".$hybrid."\n";
		$params.= "active_menu=".$active_menu."\n";
		$params.= "tables=".$tables."\n";
		$params.= "cssload=".$css_load."\n";
		$params.= "sub_indicator=".$sub_indicator."\n";
		$params.= "selectbox_hack=".$selectbox_hack."\n";
		$params.= "padding_hack=".$padding_hack."\n";
		$params.= "auto_position=".$auto_position."\n";
		$params.= "show_shadow=".$show_shadow."\n";
		$params.= "cache=".$cache."\n";
		$params.= "cache_time=".$cache_time."\n";
		$params.= "moduleclass_sfx=".$moduleclass_sfx."\n";
		$params.= "editor_hack=".$editor_hack."\n";
		$params.= "template=".$template."\n";
		$params.= "language=".$language."\n";
		$params.= "component=".$component."\n";
		$row->params = $params;




		if (!$row->store()) {
			echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}
	}

	$menus = mosGetParam( $_POST, 'selections', array() );

	$database->setQuery( "DELETE FROM #__modules_menu WHERE moduleid='$row->id'" );
	$database->query();

	foreach ($menus as $menuid){
		$database->setQuery( "INSERT INTO #__modules_menu"
		. "\nSET moduleid='$row->id', menuid='$menuid'"
		);
		$database->query();
	}



$id2=$row->id;


	$row = new swmenufreeMenu( $database );

	if (!$row->bind( $_POST )) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}

	$row->id=1;

	$database->setQuery( "SELECT COUNT(*) FROM #__swmenufree_config");
	$database->query();
	$count=$database->loadResult();

	if($count >= 1) {
		$ret = $row->_db->updateObject( $row->_tbl, $row, $row->_tbl_key );
	} else {
		$ret = $row->_db->insertObject( $row->_tbl, $row, $row->_tbl_key );
	}
	
	if($export){

		$msg=exportMenu($id2,$option);
	}
	if($cache){
		$file = $mosConfig_absolute_path."/modules/mod_swmenufree/cache/menu.cache";
		$data="";

		if ( !file_exists($file)){
			touch ($file);
			$handle = fopen ($file, 'w'); // Let's open for read and write
			// $filedate=$now;
			$swmenufree_array=swGetMenuLinks2($menutype,$row->id,$hybrid,$tables);
			$ordered = chain('ID', 'PARENT', 'ORDER', $swmenufree_array, $parent_id, $levels);
			foreach ($ordered as $swarray){
				$data.=implode("'..'",$swarray)."\n";
			}
			fwrite ($handle, $data); // Don't forget to increment the counter
			fclose ($handle); // Done
		}else{
			$handle = fopen ($file, 'w'); // Let's open for read and write
			$swmenufree_array=swGetMenuLinks2($menutype,$row->id,$hybrid,$tables);
			$ordered = chain('ID', 'PARENT', 'ORDER', $swmenufree_array, $parent_id, $levels);
			foreach ($ordered as $swarray){
				$data.=implode("'..'",$swarray)."\n";
			}
			fwrite ($handle, $data); // Don't forget to increment the counter
			fclose ($handle);
		}

	}



		mosRedirect( "index2.php?option=$option",$msg );
	
}



function exportMenu($id,$option){
	global $mosConfig_absolute_path,$database;
	include( $mosConfig_absolute_path . "/modules/mod_swmenufree/styles.php");
	$css="";

	
	$query = "SELECT * FROM #__swmenufree_config WHERE id = 1";
    $database->setQuery( $query );
    $result = $database->loadObjectList();
    $swmenupro=array();
while (list ($key, $val) = each ($result[0]))
{
    $swmenufree[$key]=$val;
}
	$row = new mosModule( $database );
	// load the row from the db table
	$row->load( $id );
	$params = mosParseParams( $row->params );
	$menu = @$params->menutype ? $params->menutype : 'mainmenu';
	$menustyle = @$params->menustyle;
	$hybrid = @$params->hybrid ? $params->hybrid: 0 ;
	$css_load = @$params->cssload ? $params->cssload: 0 ;
	$use_table = @$params->tables ? $params->tables: 0 ;
	$levels = @$params->levels ? $params->levels: 25 ;
	$show_shadow = @$params->show_shadow ? $params->show_shadow: 0 ;
	$moduleID = @$params->moduleID;
	$parent_id = @$params->parentid ? $params->parentid : '0';
	$modulename = $row->title;

	//echo $menustyle;
	switch ($menustyle)
	{
		case "mygosumenu":
		$css=   gosuMenuStyle($swmenufree);
		break;
		case "tigramenu":
		$css=   tigraMenuStyle($swmenufree);
		break;
		case "transmenu":
		$css=  transMenuStyle($swmenufree,$show_shadow);
		break;
		
	}

//echo "css:".$css;
	$file = $mosConfig_absolute_path."/modules/mod_swmenufree/styles/menu.css";
	if ( !file_exists($file)){
		touch ($file);
		$handle = fopen ($file, 'w'); // Let's open for read and write


	}
	else{
		$handle = fopen ($file, 'w'); // Let's open for read and write

	}
	rewind ($handle); // Go back to the beginning

	if(fwrite ($handle, $css)){
		$msg=_SW_SAVE_MENU_CSS_MESSAGE;
	}else{
		$msg=_SW_NO_SAVE_MENU_CSS_MESSAGE;
	} // Don't forget to increment the counter

	fclose ($handle); // Done


	return $msg;
}

function saveCSS($id, $option){

	global $database, $my, $mainframe,$mosConfig_absolute_path;

	$returntask = mosGetParam( $_REQUEST, 'returntask', "showmodules" );
	$css=mosGetParam($_POST,'filecontent',"");
	$id=mosGetParam($_POST,'id',0);

	$css=str_replace( '\\', '', $css );
	$file = $mosConfig_absolute_path."/modules/mod_swmenufree/styles/menu.css";
	if ( !file_exists($file)){
		touch ($file);
		$handle = fopen ($file, 'w'); // Let's open for read and write


	}
	else{
		$handle = fopen ($file, 'w'); // Let's open for read and write

	}
	rewind ($handle); // Go back to the beginning

	fwrite ($handle, $css); // Don't forget to increment the counter
	fclose ($handle); // Done


	//echo $css;
	
	$msg=_SW_SAVE_CSS_MESSAGE;

	if($returntask=="editCSS"){
		echo "<span class='message'>".$msg."</span>\n";
		editCSS($id, $option);

	}else{
		mosRedirect( "index2.php?option=$option",$msg );
	}

}


function editCSS( $id,$option ) {
	global $mosConfig_absolute_path, $database;
	
	$file = $mosConfig_absolute_path .'/modules/mod_swmenufree/styles/menu.css';
	$id=mosGetParam($_REQUEST,'id',0);

	if ($fp = fopen( $file, 'r' )) {
		$content = fread( $fp, filesize( $file ) );
		//$content = htmlspecialchars( $content );
		$row = new mosModule( $database );
		// load the row from the db table
		$row->load( $id );
		$params = mosParseParams( $row->params );
		$menu->source = @$params->menutype ? $params->menutype : 'mainmenu';
		$menu->name=$row->title;
		HTML_swmenufree::editCSS($id, $content,$menu);
		HTML_swmenufree::footer( );
	} else {
		mosRedirect( 'index2.php?option='. $option .'&client='. $client, 'Operation Failed: Could not open'. $file );
	}
}



function chain2($primary_field, $parent_field, $sort_field, $rows, $root_id=0, $maxlevel=25)
{
	$c = new chain2($primary_field, $parent_field, $sort_field, $rows, $root_id, $maxlevel);
	return $c->chainmenu_table;
}

class chain2
{
	var $table;
	var $rows;
	var $chainmenu_table;
	var $primary_field;
	var $parent_field;
	var $sort_field;

	function chain2($primary_field, $parent_field, $sort_field, $rows, $root_id, $maxlevel)
	{
		$this->rows = $rows;
		$this->primary_field = $primary_field;
		$this->parent_field = $parent_field;
		$this->sort_field = $sort_field;
		$this->buildchain($root_id,$maxlevel);
	}

	function buildchain($rootcatid,$maxlevel)
	{
		$row_array = array_values($this->rows);
		$row_array_size = sizeOf($row_array);
		for ($i=0;$i<$row_array_size;$i++)
		{
			$row = $row_array[$i];
			$this->table[$row[$this->parent_field]][ $row[$this->primary_field]] = $row;
		}
		$this->makeBranch($rootcatid,0,$maxlevel);
	}


	function makeBranch($parent_id,$level,$maxlevel)
	{
		$rows=$this->table[$parent_id];
		$key_array1 = array_keys($rows);
		$key_array_size1 = sizeOf($key_array1);
		for ($j=0;$j<$key_array_size1;$j++)
		//  foreach($rows as $key=>$value)
		{
			$key = $key_array1[$j];
			$rows[$key]['key'] = $this->sort_field;
		}

		usort($rows,'chainmenuCMP2');
		$row_array = array_values($rows);
		$row_array_size = sizeOf($row_array);
		for ($i=0;$i<$row_array_size;$i++)
		// foreach($rows as $item)
		{
			$item = $row_array[$i];
			$item['ORDER']=($i+1);
			$item['indent'] = $level;
			$this->chainmenu_table[] = $item;
			if((isset($this->table[$item[$this->primary_field]])) && (($maxlevel>$level+1) || ($maxlevel==0)))
			{
				$this->makeBranch($item[$this->primary_field], $level+1, $maxlevel);
			}
		}
	}
}

function chainmenuCMP2($a,$b)
{
	if($a[$a['key']] == $b[$b['key']])
	{
		return 0;
	}
	return($a[$a['key']]<$b[$b['key']])?-1:1;
}


function swmenuTreeRecurse($id, $indent, $list, &$children, $maxlevel=9999, $level=0) {
	if (@$children[$id] && $level <= $maxlevel) {
		foreach ($children[$id] as $v) {
			$id = $v->id;
			$txt = $v->name;
			$pt = $v->parent;
			$list[$id] = $v;
			$list[$id]->treename = "$indent$txt";
			$list[$id]->children = count( @$children[$id] );
			$list = swmenuTreeRecurse( $id, "$indent$txt/", $list, $children, $maxlevel, $level+1 );
		}
	}
	return $list;
}





function swGetMenuLinks2($menu,$id,$hybrid,$use_tables){
	global $mosConfig_lang, $database,$my,$mosConfig_absolute_path,$mosConfig_offset;
	$now = date( "Y-m-d H:i:s", time()+$mosConfig_offset*60*60 );
	$swmenufree_array=array();
	if ($menu=="swcontentmenu") {
		$sql =  "SELECT #__sections.* 
                FROM #__sections 
                INNER JOIN #__content ON #__content.sectionid = #__sections.id
                AND #__sections.published = 1
                AND ( publish_up = '0000-00-00 00:00:00' OR publish_up <= '$now'  )
                AND ( publish_down = '0000-00-00 00:00:00' OR publish_down >= '$now' )
                ORDER BY #__content.ordering
                ";
		$database->setQuery( $sql   );
		$result = $database->loadObjectList();

		for($i=0;$i<count($result);$i++) {
			$result2=$result[$i];
			
			if($use_tables){
				$url="index.php?option=com_content&task=section&id=" . $result2->id ;
			}else{
				$url="index.php?option=com_content&task=blogsection&id=" . $result2->id ;
			}

			$swmenufree_array[] =array("TITLE" => $result2->title, "URL" =>  $url , "ID" => $result2->id  , "PARENT" => 0 ,  "ORDER" => $result2->ordering, "TARGET" => 0,"ACCESS" => $result2->access );
		}

		$sql =  "SELECT #__categories.* 
				FROM #__categories
                INNER JOIN #__content ON #__content.catid = #__categories.id

                AND #__categories.published = 1
                AND ( publish_up = '0000-00-00 00:00:00' OR publish_up <= '$now'  )
                AND ( publish_down = '0000-00-00 00:00:00' OR publish_down >= '$now' )
                ORDER BY #__content.ordering
                ";

		$database->setQuery( $sql   );
		$result = $database->loadObjectList();

		for($i=0;$i<count($result);$i++) {
			$result2=$result[$i];

						
			if($use_tables){
				$url="index.php?option=com_content&task=category&id=" . $result2->id ;
			}else{
				$url="index.php?option=com_content&task=blogcategory&id=" . $result2->id ;
			}

			$swmenufree_array[] =array("TITLE" => $result2->title, "URL" =>  $url , "ID" => $result2->id+1000  , "PARENT" => $result2->section ,  "ORDER" => $result2->ordering, "TARGET" => 0,"ACCESS" => $result2->access );
		}

		$sql =  "SELECT #__content.* 
				FROM #__content
                INNER JOIN #__categories ON #__content.catid = #__categories.id
                AND #__content.state = 1
                AND ( publish_up = '0000-00-00 00:00:00' OR publish_up <= '$now'  )
                AND ( publish_down = '0000-00-00 00:00:00' OR publish_down >= '$now' )
                ORDER BY #__content.ordering
                ";
		$database->setQuery( $sql   );
		$result = $database->loadObjectList();

		for($i=0;$i<count($result);$i++) {
			$result2=$result[$i];

			$url="index.php?option=com_content&task=view&id=" . $result2->id ;
			$swmenufree_array[] =array("TITLE" => $result2->title, "URL" =>  $url , "ID" => $result2->id+10000  , "PARENT" => $result2->catid+1000 ,  "ORDER" => $result2->ordering, "TARGET" => 0,"ACCESS" => $result2->access  );
		}
	}else if ($menu=="virtuemart") {
		$sql =  "SELECT #__vm_category.* ,#__vm_category_xref.*
		         FROM #__vm_category 
                INNER JOIN #__vm_category_xref ON #__vm_category_xref.category_child_id= #__vm_category.category_id
                AND #__vm_category.category_publish = 'Y'
                ORDER BY #__vm_category.list_order
                ";
		$database->setQuery( $sql   );
		$result = $database->loadObjectList();

		for($i=0;$i<count($result);$i++) {
			$result2=$result[$i];
			$url="index.php?option=com_virtuemart&page=shop.browse&category_id=" . $result2->category_id . "&Itemid=".($result2->category_id+10000) ;
			$swmenufree_array[] =array("TITLE" => $result2->category_name, "URL" =>  $url , "ID" => ($result2->category_id+10000)  , "PARENT" => ($result2->category_parent_id?($result2->category_parent_id+10000):0) ,  "ORDER" => $result2->list_order, "TARGET" => 0,"ACCESS" => 0 );
		}
	}else{
		if ($hybrid){
				$sql =  "SELECT #__content.*
				FROM #__content
                INNER JOIN #__categories ON #__content.catid = #__categories.id
                AND #__content.state = 1
                AND ( publish_up = '0000-00-00 00:00:00' OR publish_up <= '$now'  )
                AND ( publish_down = '0000-00-00 00:00:00' OR publish_down >= '$now' )
                ORDER BY #__content.catid,#__content.ordering
                ";
			$database->setQuery( $sql   );
			$hybrid_content = $database->loadObjectList();	
			
			
			$sql =  "SELECT #__categories.*
				FROM #__categories
                WHERE #__categories.published = 1
                ORDER BY #__categories.ordering
                ";
			$database->setQuery( $sql   );
			$hybrid_cat = $database->loadObjectList();		
		}
				
		$sql = "SELECT #__menu.* 
				FROM #__menu
                WHERE #__menu.menutype = '".$menu."' AND published = '1'
                ORDER BY parent, ordering
            ";

		$database->setQuery( $sql   );
		$result = $database->loadObjectList();

		$swmenufree_array=array();

		for($i=0;$i<count($result);$i++) {
			$result2=$result[$i];
			

			switch ($result2->type) {
				case 'separator';
				//$result2->link = "seperator";
				break;

				case 'url':
				if (eregi( "index.php\?", $result2->link )) {
					if (!eregi( "Itemid=", $result2->link )) {
						$result2->link .= "&Itemid=$result2->id";
					}
				}
				break;

				default:
				$result2->link .= "&Itemid=$result2->id";
				break;
			}
			$swmenufree_array[] =array("TITLE" => $result2->name, "URL" =>  $result2->link , "ID" => $result2->id  , "PARENT" => $result2->parent ,  "ORDER" => $result2->ordering, "TARGET" => $result2->browserNav,"ACCESS" => $result2->access );

			if ($hybrid){
				$opt=array();
				parse_str($result2->link, $opt);
				$opt['task'] = @$opt['task'] ? $opt['task']: 0;
				$opt['id'] = @$opt['id'] ? $opt['id']: 0;
				
				
				if ($opt['task']=="blogcategory" || $opt['task']=="category" ) {
					
				for($j=0;$j<count($hybrid_content);$j++){	
					$row=$hybrid_content[$j];
					if($row->catid==$opt['id']){
						
							$url="index.php?option=com_content&task=view&id=" . $row->id ."&Itemid=".$result2->id;
							$swmenufree_array[] =array("TITLE" => $row->title, "URL" =>  $url , "ID" => $row->id+100000  , "PARENT" => $result2->id ,  "ORDER" => $row->ordering, "TARGET" => 0,"ACCESS" => $row->access );
						}	
					}
				}else if ($opt['task']=="blogsection" || $opt['task']=="section" ) {	
				
				for($j=0;$j<count($hybrid_cat);$j++){	
				$row=$hybrid_cat[$j];
					if($row->section==$opt['id'] && $opt['id']){
						//$j=count($hybrid_cat);
														
							if($use_tables){
							$url="index.php?option=com_content&task=category&id=".$row->id."&Itemid=".$result2->id;
							}else{
							$url="index.php?option=com_content&task=blogcategory&id=".$row->id."&Itemid=".$result2->id;
							}
							$swmenufree_array[] =array("TITLE" => $row->title, "URL" =>  $url , "ID" => $row->id+10000  , "PARENT" => $result2->id ,  "ORDER" => $row->ordering, "TARGET" => 0,"ACCESS" => $row->access );
							
							for($k=0;$k<count($hybrid_content);$k++){	
							$row2=$hybrid_content[$k];
								if($row2->catid==$row->id){
									
									$url="index.php?option=com_content&task=view&id=" . $row2->id ."&Itemid=".$result2->id;
									$swmenufree_array[] =array("TITLE" => $row2->title, "URL" =>  $url , "ID" => $row2->id+100000  , "PARENT" => $row->id+10000 ,  "ORDER" => $row2->ordering, "TARGET" => 0,"ACCESS" => $row2->access );
									}	
								}
							}
						}
					}		
				}
			}
		}

	return $swmenufree_array;
}



function get_Version($directory){

	global $mosConfig_absolute_path,$database,$mainframe;
	
	
	if(file_exists($mosConfig_absolute_path . '/includes/domit/xml_domit_lite_include.php')){
	require_once( $mosConfig_absolute_path . '/includes/domit/xml_domit_lite_include.php' );
	$componentBaseDir	= $directory;


	$xmlDoc = new DOMIT_Lite_Document();
	$xmlDoc->resolveErrors( true );

	if (!$xmlDoc->loadXML( $componentBaseDir , false, true )) {
		continue;
	}

	$root = &$xmlDoc->documentElement;


	$element 			= &$root->getElementsByPath('version', 1);
	$version 		= $element ? $element->getText() : '';
	}else{

	$parser =& new mosXMLDescription($directory);
	if ($parser->getType() == 'component'){		
	
	$version 		= $parser->getVersion('component');
	}else{
		
		$version 		= $parser->getVersion('module');
	}
	}
	return $version;


}

function changeLanguage(){
	
	global $mosConfig_absolute_path;
	
	$lang=strval( mosGetParam( $_REQUEST, 'language', "english.php" ));
	
	
	$file = $mosConfig_absolute_path."/administrator/components/com_swmenufree/language/default.ini";
	if ( !file_exists($file)){
		touch ($file);
		$handle = fopen ($file, 'w'); // Let's open for read and write


	}
	else{
		$handle = fopen ($file, 'w'); // Let's open for read and write

	}
	rewind ($handle); // Go back to the beginning

	if(fwrite ($handle, $lang)){
		$msg=_SW_SAVE_MENU_CSS_MESSAGE;
	}else{
		$msg=_SW_NO_SAVE_MENU_CSS_MESSAGE;
	} // Don't forget to increment the counter

	fclose ($handle); // Done

	
	mosRedirect( "index2.php?task=upgrade&option=com_swmenufree",$msg );
	
	
	
}

function upgrade($option,$installdir=""){

	global $mosConfig_absolute_path,$database,$mainframe;
	global $mosConfig_dbprefix;
	global $mosConfig_db;

	//require_once( $mosConfig_absolute_path . '/includes/domit/xml_domit_lite_include.php' );
	$componentBaseDir	= mosPathName( $mosConfig_absolute_path . '/administrator/components/' );
	$componentDirs 		= mosReadDirectory( $componentBaseDir );
	
	$row->message="";
	$row->database_version=1;
	$columncount=0;
	
	if(TableExists($mosConfig_dbprefix."swmenufree_config",$mosConfig_db)){
		$query = "SELECT * FROM #__swmenufree_config WHERE id = 1";
$database->setQuery( $query );
$result = $database->loadObjectList();
$swmenufree=array();
if ($result){
while (list ($key, $val) = each ($result[0]))
{
	//echo "1";
	$columncount++;
    $swmenufree[$key]=$val;
}
}
//echo count($swmenufree);
	  if($columncount<42 && $columncount>1){
	  	$row->message.=sprintf(_SW_TABLE_UPGRADE,'#__swmenufree_config')."<br />";
	  	$database->setQuery("ALTER TABLE `#__swmenufree_config` 
  			ADD `extra` mediumtext,
  			MODIFY orientation varchar(20)
 			 ");
		$database->query();
	  	$row->database_version=0;
	  }
	}else{
		$row->message.=sprintf(_SW_TABLE_CREATE,'#__swmenufree_config')."<br />";
		$database->setQuery("CREATE TABLE `#__swmenufree_config` (
  `id` int(11) NOT NULL default '0',
  `main_top` smallint(8) default '0',
  `main_left` smallint(8) default '0',
  `main_height` smallint(8) default '20',
  `sub_border_over` varchar(30) default '0',
  `main_width` smallint(8) default '100',
  `sub_width` smallint(8) default '100',
  `main_back` varchar(7) default '#4682B4',
  `main_over` varchar(7) default '#5AA7E5',
  `sub_back` varchar(7) default '#4682B4',
  `sub_over` varchar(7) default '#5AA7E5',
  `sub_border` varchar(30) default '#FFFFFF',
  `main_font_size` smallint(8) default '0',
  `sub_font_size` smallint(8) default '0',
  `main_border_over` varchar(30) default '0',
  `sub_font_color` varchar(7) default '#000000',
  `main_border` varchar(30) default '#FFFFFF',
  `main_font_color` varchar(7) default '#000000',
  `sub_font_color_over` varchar(7) default '#FFFFFF',
  `main_font_color_over` varchar(7) default '#FFFFFF',
  `main_align` varchar(8) default 'left',
  `sub_align` varchar(8) default 'left',
  `sub_height` smallint(7) default '20',
  `position` varchar(10) default 'absolute',
  `orientation` varchar(20) default NULL,
  `font_family` varchar(50) default 'Arial',
  `font_weight` varchar(10) default 'normal',
  `font_weight_over` varchar(10) default 'normal',
  `level2_sub_top` int(11) default '0',
  `level2_sub_left` int(11) default '0',
  `level1_sub_top` int(11) NOT NULL default '0',
  `level1_sub_left` int(11) NOT NULL default '0',
  `main_back_image` varchar(100) default NULL,
  `main_back_image_over` varchar(100) default NULL,
  `sub_back_image` varchar(100) default NULL,
  `sub_back_image_over` varchar(100) default NULL,
  `specialA` varchar(50) default '80',
  `main_padding` varchar(40) default '0px 0px 0px 0px',
  `sub_padding` varchar(40) default '0px 0px 0px 0px',
  `specialB` varchar(100) default '50',
  `sub_font_family` varchar(50) default 'Arial',
  `extra` mediumtext,
  PRIMARY KEY  (`id`)
)");
		$database->query();
	}
	
	
	
	$database->setQuery("SELECT COUNT(*) FROM `#__components` WHERE admin_menu_link LIKE '%com_swmenufree%'");
	$com_entries=$database->loadResult();
  	
  	if($com_entries!=1){
  		$row->message.=_SW_UPDATE_LINKS."<br />";
  		$database->setQuery("DELETE FROM `#__components` WHERE admin_menu_link like '%com_swmenufree%'");
  		$database->query();
  		
  		$database->setQuery("INSERT INTO `#__components` VALUES ('', 'swMenuFree', 'option=com_swmenufree', 0, 0, 'option=com_swmenufree', 'swMenuFree', 'com_swmenufree', 0, 'js/ThemeOffice/component.png', 0, '')");
  		$database->query();
  	}
  	
  	if(file_exists($mosConfig_absolute_path . '/modules/mod_swmenufree.xml')){
  		$row->module_version=get_Version($mosConfig_absolute_path . '/modules/mod_swmenufree.xml');
  		$row->new_module_version=get_Version($mosConfig_absolute_path . '/administrator/components/com_swmenufree/modules/mod_swmenufree.sw');
  	//$row->new_module_version=2;	
  	if($row->module_version<$row->new_module_version){
  			if(copydirr($mosConfig_absolute_path."/administrator/components/com_swmenufree/modules",$mosConfig_absolute_path."/modules",0757,false)){
				unlink($mosConfig_absolute_path . '/modules/mod_swmenufree.xml');
  				rename($mosConfig_absolute_path."/modules/mod_swmenufree.sw",$mosConfig_absolute_path."/modules/mod_swmenufree.xml");
				$row->message.=_SW_MODULE_SUCCESS."<br />";
			}else{
				$row->message.=_SW_MODULE_FAIL."<br />";
			}
  		}
  	}else{
  		if(copydirr($mosConfig_absolute_path."/administrator/components/com_swmenufree/modules",$mosConfig_absolute_path."/modules",0757,false)){
				rename($mosConfig_absolute_path."/modules/mod_swmenufree.sw",$mosConfig_absolute_path."/modules/mod_swmenufree.xml");
				$row->message.=_SW_MODULE_SUCCESS."<br />";
			}else{
				$row->message.=_SW_MODULE_FAIL."<br />";
			}
  	}
  	
	
	$row->component_version=get_Version($mosConfig_absolute_path . '/administrator/components/com_swmenufree/swmenufree.xml');
	$row->module_version=get_Version($mosConfig_absolute_path . '/modules/mod_swmenufree.xml');
	
	$langfile="english.php";	
	if (file_exists($mosConfig_absolute_path.'/administrator/components/com_swmenufree/language/default.ini'))
{
	$filename = $mosConfig_absolute_path.'/administrator/components/com_swmenufree/language/default.ini';
$handle = fopen($filename, "r");
$langfile = fread($handle, filesize($filename));
fclose($handle);
	
}
	
	$basedir =$mosConfig_absolute_path . "/administrator/components/com_swmenufree/language/"; 
    $handle=opendir($basedir);
    $lang=array();
    $lists=array(); 
     while ($file = readdir($handle)) { 
     if ($file == "." || $file == ".." || $file == "default.ini") { } else { 
     	$lang[]= mosHTML::makeOption( $file, $file );
	    }
      $lists['langfiles']= mosHTML::selectList( $lang, 'language','id="language" class="inputbox" size="1" style="width:200px"','value', 'text',$langfile);
     } 
     closedir($handle); 
	
	HTML_swmenufree::upgradeForm( $row ,$lists);
	HTML_swmenufree::footer( );
}




function copydirr($fromDir,$toDir,$chmod=0757,$verbose=false)
/*
copies everything from directory $fromDir to directory $toDir
and sets up files mode $chmod
*/
{
	//* Check for some errors
	$errors=array();
	$messages=array();
	if (!is_writable($toDir))
	$errors[]='target '.$toDir.' is not writable';
	if (!is_dir($toDir))
	$errors[]='target '.$toDir.' is not a directory';
	if (!is_dir($fromDir))
	$errors[]='source '.$fromDir.' is not a directory';
	if (!empty($errors))
	{
		if ($verbose)
		foreach($errors as $err)
		echo '<strong>Error</strong>: '.$err.'<br />';
		return false;
	}
	//*/
	$exceptions=array('.','..');
	//* Processing
	$handle=opendir($fromDir);
	while (false!==($item=readdir($handle)))
	if (!in_array($item,$exceptions))
	{
		//* cleanup for trailing slashes in directories destinations
		$from=str_replace('//','/',$fromDir.'/'.$item);
		$to=str_replace('//','/',$toDir.'/'.$item);
		//*/
		if (is_file($from))
		{
			if (@copy($from,$to))
			{
				chmod($to,$chmod);
				touch($to,filemtime($from)); // to track last modified time
				$messages[]='File copied from '.$from.' to '.$to;
			}
			else
			$errors[]='cannot copy file from '.$from.' to '.$to;
		}
		if (is_dir($from))
		{
			if (@mkdir($to))
			{
				chmod($to,$chmod);
				$messages[]='Directory created: '.$to;
			}
			else
			$errors[]='cannot create directory '.$to;
			copydirr($from,$to,$chmod,$verbose);
		}
	}
	closedir($handle);
	//*/
	//* Output
	if ($verbose)
	{
		foreach($errors as $err)
		echo '<strong>Error</strong>: '.$err.'<br />';
		foreach($messages as $msg)
		echo $msg.'<br />';
	}
	//*/
	return true;
}

function uploadPackage(  ) {
	global $mosConfig_absolute_path;

	$userfile = mosGetParam( $_FILES, 'userfile', null );

	if (!$userfile) {

		exit();
	}

	$userfile_name = $userfile['name'];

	$msg = '';
	$resultdir = uploadFile( $userfile['tmp_name'], $userfile['name'], $msg );
	$msg=extractArchive($userfile['name']);

	if(file_exists($msg."/swmenufree.xml")){
	$upload_version=get_Version($msg."/swmenufree.xml");
	}else{
		$upload_version=0;
	}
	$current_version=get_Version($mosConfig_absolute_path . '/administrator/components/com_swmenufree/swmenufree.xml');

	if($upload_version=="swmenufree_language_file"){
		if(copydirr($msg,$mosConfig_absolute_path . '/administrator/components/com_swmenufree/language',0757,false)){
		$message=_SW_LANGUAGE_SUCCESS;
		}else{
			$message=_SW_LANGUAGE_FAIL;
		}
	
	
	}else if($current_version<$upload_version){
		if(copydirr($msg,$mosConfig_absolute_path . '/administrator/components/com_swmenufree',0757,false)){
		$message=_SW_COMPONENT_SUCCESS;
		}else{
			$message=_SW_COMPONENT_FAIL;
		}
	}else{

		$message=_SW_INVALID_FILE;
	}
    deldir($msg);
	unlink($mosConfig_absolute_path."/media/".$userfile['name']);

	mosRedirect( "index2.php?&option=com_swmenufree&task=upgrade",$message );

}

/**
* @param string The name of the php (temporary) uploaded file
* @param string The name of the file to put in the temp directory
* @param string The message to return
*/
function uploadFile( $filename, $userfile_name, &$msg ) {
	global $mosConfig_absolute_path;
	$baseDir = mosPathName( $mosConfig_absolute_path . '/media' );

	if (file_exists( $baseDir )) {
		if (is_writable( $baseDir )) {
			if (move_uploaded_file( $filename, $baseDir . $userfile_name )) {
				if (mosChmod( $baseDir . $userfile_name )) {
					return true;
				} else {
					$msg = 'Failed to change the permissions of the uploaded file.';
				}
			} else {
				$msg = 'Failed to move uploaded file to <code>/media</code> directory.';
			}
		} else {
			$msg = 'Upload failed as <code>/media</code> directory is not writable.';
		}
	} else {
		$msg = 'Upload failed as <code>/media</code> directory does not exist.';
	}
	return false;
}

function extractArchive($filename) {
	global $mosConfig_absolute_path;

	$base_Dir 		= mosPathName( $mosConfig_absolute_path . '/media/' );

	$archivename 	= $base_Dir . $filename;
	$tmpdir 		= uniqid( 'install_' );

	$extractdir 	= mosPathName( $base_Dir . $tmpdir );
	$archivename 	= mosPathName( $archivename, false );

	//$this->unpackDir( $extractdir );

	if (eregi( '.zip$', $archivename )) {
		// Extract functions
		require_once( $mosConfig_absolute_path . '/administrator/includes/pcl/pclzip.lib.php' );
		require_once( $mosConfig_absolute_path . '/administrator/includes/pcl/pclerror.lib.php' );
		//require_once( $mosConfig_absolute_path . '/administrator/includes/pcl/pcltrace.lib.php' );
		//require_once( $mosConfig_absolute_path . '/administrator/includes/pcl/pcltar.lib.php' );
		$zipfile = new PclZip( $archivename );
		//if($this->isWindows()) {
		//		define('OS_WINDOWS',1);
		//	} else {
		//		define('OS_WINDOWS',0);
		//	}

		$ret = $zipfile->extract( PCLZIP_OPT_PATH, $extractdir );
		if($ret == 0) {
			$this->setError( 1, 'Unrecoverable error "'.$zipfile->errorName(true).'"' );
			return false;
		}
	} else {
		require_once( $mosConfig_absolute_path . '/includes/Archive/Tar.php' );
		$archive = new Archive_Tar( $archivename );
		$archive->setErrorHandling( PEAR_ERROR_PRINT );

		if (!$archive->extractModify( $extractdir, '' )) {
			$this->setError( 1, 'Extract Error' );
			return false;
		}
	}


	return $extractdir;
}


function deldir( $dir ) {
	$current_dir = opendir( $dir );
	$old_umask = umask(0);
	while ($entryname = readdir( $current_dir )) {
		if ($entryname != '.' and $entryname != '..') {
			if (is_dir( $dir . $entryname )) {
				deldir( mosPathName( $dir . $entryname ) );
			} else {
				@chmod($dir . $entryname, 0777);
				unlink( $dir . $entryname );
			}
		}
	}
	umask($old_umask);
	closedir( $current_dir );
	return rmdir( $dir );
}

function TableExists($tablename, $db) {
  global $database;
  
  $database->setQuery("SELECT 1 FROM ".$tablename." LIMIT 0");
  $mysql_result =  $database->query();
  if ($mysql_result){
  	//echo "true";
  	return true;
  }else{
  	return false;
  }
  
   // Get a list of tables contained within the database.
   //$result = mysql_list_tables($db);
   //$rcount = mysql_num_rows($result);

   // Check each in list for a match.
   //for ($i=0;$i<$rcount;$i++) {
   //    if (mysql_tablename($result, $i)==$tablename) return true;
   //}
   //return false;
}
?>
