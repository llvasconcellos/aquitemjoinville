<?php
/**
* @version $Id: mod_minifrontpage.php 1.2
* Erwin Schro + Andy Sikumbang
* http://www.templateplazza.com
* @based on mod_section_thumbnail, mod_ultraDGM_News, mod_mostreadrecent, mod_mostread
* @package Joomla 1.0.12
* -------------------------------------------------------------------------------------------
* @version $Id: mod_section_thumbnails.php 3.02
* @package Mambo_4.5.1
* @copyright (C) 2000 - 2004 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

global $mosConfig_offset, $mosConfig_live_site, $mainframe;

// Move this CSS link into your index.php header to make this module valid XHTML 
echo '<link href="'.$mosConfig_live_site.'/modules/minifrontpage/style.css" rel="stylesheet" type="text/css" />';
echo '<!-- MiniFrontPage Joomla Module by TemplatePlazza.com -->';
echo '<table width="100%" cellpadding="0" cellspacing="0"><tr><td width="100"><div class="myBox" style="text-align:center;height:20px;">CINEMA</div></td><td style="padding-left:5px;"><a style="color: #ff7510;text-decoration:none;" href="index.php?option=com_content&task=blogsection&id=6&Itemid=7">Clique aqui para ver toda a programação</a></td></tr></table>';
echo '<div style="font-size:5px; background-color:#4f729a;margin-top:1px;">&nbsp;</div>';

//---------------------------------Functions for thumbnails utility---------------------------------------
if (!function_exists("fptn_thumb_size"))
{
	function fptn_thumb_size($file, $wdth, $hgth, &$image, &$xtra, $class, $aspect)
	{
		global $mosConfig_absolute_path, $mosConfig_live_site;
		if($class!='') $xtra .= ' class="'.$class.'"';
		
		// Find the extension of the file
		$ext = substr(strrchr(basename($mosConfig_absolute_path.$file), '.'), 1);
		$thumb = str_replace('.'.$ext, '_thumb.'.$ext, $file);
		$image = '';
		$image_path = $mosConfig_absolute_path.$thumb;
		$image_site = $mosConfig_live_site.$thumb;
		$found = false;
		
		if (file_exists($image_path))
		{
			$size = '';
			$wx = $hy = 0;
			if (function_exists( 'getimagesize' ))
			{
				$size = @getimagesize( $image_path );
				if (is_array( $size ))
				{
					$wx = $size[0];
					$hy = $size[1];
					$size = 'width="'.$wx.'" height="'.$hy.'"';
				}
	    	}
//	    	if ($wx == $wdth && $hy == $hgth)
	    	//if ( $wx == $wdth )
	    	//{
				$found = true;
				$image= '<img src="'.$image_site.'" '.$size.$xtra.' />';
			//}
		}
	
		if (!$found)
		{
			$size = '';
			$wx = $hy = 0;
			$size = @getimagesize( $mosConfig_absolute_path.$file );
			if (is_array( $size ))
			{
				$wx = $size[0];
				$hy = $size[1];
			}
			fptn_calcsize($wx, $hy, $wdth, $hgth, $aspect);
			switch ($ext)
			{
				case 'jpg':
				case 'jpeg':
				case 'png':
					fptn_thumbit($mosConfig_absolute_path.$file,$image_path,$ext,$wdth,$hgth);
					$size = 'width="'.$wdth.'" height="'.$hgth.'"';
					$image= '<img  src="'.$image_site.'" '.$size.$xtra.' />';
					break;
	
				case 'gif':
					if (function_exists("imagegif")) {
						fptn_thumbit($mosConfig_absolute_path.$file,$image_path,$ext,$wdth,$hgth);
						$size = 'width="'.$wdth.'" height="'.$hgth.'"';
						$image= '<img src="'.$image_site.'" '.$size.$xtra.' />';
						break;
	        		}
					
				default:
					$size = 'width="'.$wdth.'" height="'.$hgth.'"';
					$image= '<img src="'.$mosConfig_live_site.$file.'" '.$size.$xtra.' />';
					break;
			}
		}
	}

	function fptn_thumbIt ($file, $thumb, $ext, &$new_width, &$new_height) 
	{
		$img_info = getimagesize ( $file );
		$orig_width = $img_info[0];
		$orig_height = $img_info[1];
		
		if($orig_width<$new_width || $orig_height<$new_height)
		{
			$new_width = $orig_width;
			$new_height = $orig_height;
		}
		
		switch ($ext) {
			case 'jpg':
			case 'jpeg':
				$im  = imagecreatefromjpeg($file);
				$tim = imagecreatetruecolor ($new_width, $new_height);
				fptn_ImageCopyResampleBicubic($tim, $im, 0,0,0,0, $new_width, $new_height, $orig_width, $orig_height);
				imagedestroy($im);
	
				imagejpeg($tim, $thumb, 75);
				imagedestroy($tim);
				break;

			case 'png':
				$im  = imagecreatefrompng($file);
				$tim = imagecreatetruecolor ($new_width, $new_height);
				fptn_ImageCopyResampleBicubic($tim, $im, 0,0,0,0, $new_width, $new_height, $orig_width, $orig_height);
				imagedestroy($im);

				imagepng($tim, $thumb, 9);
				imagedestroy($tim);
				break;

			case 'gif':
				if (function_exists("imagegif")) {
					$im  = imagecreatefromgif($file);
					$tim = imagecreatetruecolor ($new_width, $new_height);
					fptn_ImageCopyResampleBicubic($tim, $im, 0,0,0,0, $new_width, $new_height, $orig_width, $orig_height);
					imagedestroy($im);

					imagegif($tim, $thumb, 75);
					imagedestroy($tim);
    			}
				break;

			default:
				break;
		}
	}

	function fptn_ImageCopyResampleBicubic (&$dst_img, &$src_img, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h) 
	{
		if ($dst_w==$src_w && $dst_h==$src_h) {
			$dst_img = $src_img;
			return;
		}
  		ImagePaletteCopy ($dst_img, $src_img);
		$rX = $src_w / $dst_w;
		$rY = $src_h / $dst_h;
		$w = 0;
		for ($y = $dst_y; $y < $dst_h; $y++) 
		{
			$ow = $w; $w = round(($y + 1) * $rY);
			$t = 0;
			for ($x = $dst_x; $x < $dst_w; $x++) 
			{
				$r = $g = $b = 0; $a = 0;
				$ot = $t; $t = round(($x + 1) * $rX);
				for ($u = 0; $u < ($w - $ow); $u++) 
				{
					for ($p = 0; $p < ($t - $ot); $p++) 
					{
						$c = ImageColorsForIndex ($src_img, ImageColorAt ($src_img, $ot + $p, $ow + $u));
						$r += $c['red'];
          				$g += $c['green'];
          				$b += $c['blue'];
          				$a++;
        			}
				}
				if(!$a) $a = 1;
				ImageSetPixel ($dst_img, $x, $y, ImageColorClosest ($dst_img, $r / $a, $g / $a, $b / $a));
			}
		}
	}

	function fptn_calcsize($srcx, $srcy, &$forcedwidth, &$forcedheight, $aspect) 
	{
		if ($forcedwidth > $srcx)  $forcedwidth = $srcx;
		if ($forcedheight > $srcy) $forcedheight = $srcy;
		if ( $forcedwidth <=0 && $forcedheight > 0) {
			$forcedwidth = round(($forcedheight * $srcx) / $srcy);
		} 
		else if ( $forcedheight <=0 && $forcedwidth > 0) {
			$forcedheight = round(($forcedwidth * $srcy) / $srcx);
		}
		else if ( $forcedwidth/$srcx>1 && $forcedheight/$srcy>1) {
			//May not make an image larger!
			$forcedwidth = $srcx;
			$forcedheight = $srcy;
		}
		else if ( $forcedwidth/$srcx<1 && $aspect) {
			//$forcedheight = round(($forcedheight * $forcedwidth) /$srcx);
			$forcedheight = round( ($srcy/$srcx) * $forcedwidth );
			$forcedwidth = $forcedwidth;
		}
	}


	function fptn_limittext($txt,$limit)
	{
	    $len=strlen($txt);
	    if ($len <= $limit)
	        return $txt;
	    else
	    {
	        $txt = substr($txt,0,$limit);
	        $pos = strrpos($txt," ");
	        if($pos >0)
			{
		        $txt = substr($txt,0,$pos);
		    	if (($tpos =strrpos($txt,"<")) >  strrpos($txt,">") && $tpos>0)
		    	{
			  		$txt = substr($txt,0,$tpos-1);
			  	}
			}
	        return $txt . "...";
	    }
	}
}

if (!function_exists("fptn_get_id"))
{

	function fptn_get_id ($id, $option="com_content") 
	{
		global $database, $Itemid;
	
		$_Itemid = "";
	
		// Content Item Link
		if ($_Itemid == "") {
			$database->setQuery( "SELECT id "
				."FROM #__menu "
				."WHERE type='content_item_link' AND published='1' AND link='index.php?option=$option&task=view&id=$id'" );
			$_Itemid = $database->loadResult();
		}
	
		// Typed Content Link
		if ($_Itemid == "") {
			$database->setQuery( "SELECT id "
				."FROM #__menu "
				."WHERE type='content_typed' AND published='1' AND link='index.php?option=$option&task=view&id=$id'" );
			$_Itemid = $database->loadResult();
		}
	
		// Content Section List
		if ($_Itemid == "") {
			$database->setQuery( "SELECT m.id "
				."FROM #__content AS i "
				."LEFT JOIN #__sections AS s ON i.sectionid=s.id "
				."LEFT JOIN #__menu AS m ON m.componentid=s.id "
				."WHERE m.type='content_section' AND m.published='1' AND i.id='$id'" );
			$_Itemid = $database->loadResult();
		}
	
		// Content Category List
		if ($_Itemid == "") {
			$database->setQuery( "SELECT sectionid, catid "
				."FROM #__content WHERE id='$id'" );
			$row = null;
			$database->loadObject( $row );
	
			$database->setQuery("SELECT id "
				."FROM #__menu "
				."WHERE type='content_category' AND published='1' AND link='index.php?option=$option&task=category&sectionid=$row->sectionid&id=$row->catid'");
			$_Itemid = $database->loadResult();
		}
	
		// Content Section Blog (specific)
		if ($_Itemid == "") {
			$database->setQuery( "SELECT m.id "
				."FROM #__content AS i "
				."LEFT JOIN #__sections AS s ON i.sectionid=s.id "
				."LEFT JOIN #__menu AS m ON m.componentid=s.id "
				."WHERE m.type='content_blog_section' AND m.published='1' AND i.id='$id'" );
			$_Itemid = $database->loadResult();
		}
	
		// Content Category Blog (specific)
		if ($_Itemid == "") {
			$database->setQuery( "SELECT m.id "
				."FROM #__content AS i "
				."LEFT JOIN #__categories AS c ON i.catid=c.id "
				."LEFT JOIN #__menu AS m ON m.componentid=c.id "
				."WHERE m.type='content_blog_category' AND m.published='1' AND i.id='$id'" );
			$_Itemid = $database->loadResult();
		}
	
		// Content Section Blog (global)
		if ($_Itemid == "") {
			// Search in global blog section
			$database->setQuery( "SELECT id "
				."FROM #__menu "
				."WHERE type='content_blog_section' AND published='1' AND componentid='0'" );
			$_Itemid = $database->loadResult();
		}
	
		// Content Category Blog (global)
		if ($_Itemid == "") {
			$database->setQuery( "SELECT id "
				."FROM #__menu "
				."WHERE type='content_blog_category' AND published='1' AND componentid='0'" );
			$_Itemid = $database->loadResult();
		}
	
		//echo $_Itemid;
	
		if ($_Itemid != "") {
			return $_Itemid;
		} else {
			return $Itemid;
		}
	}
}

//added by remush
//this fuction to show Thumbnail image
if (!function_exists("showThumb") ) {
function showThumb($row_images,$row_image,$params,$row_itemid,$row_id){
	
	$thumb_embed = intval( $params->get( 'thumb_embed', 0 ) );
	$thumb_width = intval( $params->get( 'thumb_width', 32 ) );
	$thumb_height = intval( $params->get( 'thumb_height', 32 ) );
	$aspect = intval( $params->get( 'aspect', 0 ) );
	$default_image_path = "/modules/minifrontpage/default.gif";
	
	
	if ($thumb_embed == 1) 
	{
		echo '<a href="'. sefRelToAbs( 'index.php?option=com_content&amp;task=view&amp;id=' . 
		$row_id .'&amp;Itemid=' . $row_itemid) .'">';
						
		if (!empty($row_images))
		{
				$img = "/images/stories/" . strtok($row_images,"|\r\n");
				$class="";
				$extra = ' align="left" alt="article thumbnail" ';
					   	
				fptn_thumb_size($img, $thumb_width, $thumb_height, $image, $extra, $class, $aspect);
					
				echo  $image;
					
		}
		else if ($row_image !="")
		{
			echo '<img src="'.$mosConfig_live_site.'/images/stories/' . $row_image .' " width="' . $thumb_width . '" height="' . $thumb_height .'" style="float: left;" alt="article image" />';
		}
		else {
						
			$img = $default_image_path;
			$class="";
			$extra = ' align="left" alt="article thumbnai" ';
					   	
			fptn_thumb_size($img, $thumb_width, $thumb_height, $image, $extra, $class, $aspect);
			echo $image;
		}
		echo '</a>';
	}

}
}
//---------------------------------End Functions For thumbnails utility---------------------------------------

// Get All Parameters
$moduleclass_sfx 	= $params->get( 'moduleclass_sfx', '' );
$sections 			= $params->get( 'sections', '1,2,3' ) ;
$categories 		= $params->get( 'categories', '1,3,7' ) ;
$order				= $params->get( 'order', 1);
$period 			= intval( $params->get( 'period', 366 ) );
$loadorder 			= intval( $params->get( 'loadorder', 1 ) );
$cat_title 			= intval( $params->get( 'cat_title', 0 ) );
$show_front			= intval( $params->get( 'show_front', 0 ) );
$show_title 		= intval( $params->get( 'show_title', 1 ) );
$title_link 		= intval( $params->get( 'title_link', 1 ) );
$show_author 		= intval( $params->get( 'show_author', 0 ) );
$show_date 			= intval( $params->get( 'show_date', 0 ) );
$limit 				= intval( $params->get( 'limit', 200 ) );
$fulllink			= $params->get( 'fulllink','' );
$header_title_links = $params->get( 'header_title_links', "" );
$columns 			= intval( $params->get( 'columns', 1 ) );
$count 				= intval( $params->get( 'count', 5 ) );
$num_intro 			= intval( $params->get( 'num_intro', 1) );
$thumb_enable 		= 1;
$thumb_embed 		= intval( $params->get( 'thumb_embed', 0 ) );
$thumb_width 		= intval( $params->get( 'thumb_width', 32 ) );
$thumb_height 		= intval( $params->get( 'thumb_height', 32 ) );
$aspect 			= intval( $params->get( 'aspect', 0 ) );
$allowed_tags 		=  "<i><b>"; 

// please change these here
$skip = 0; // whether you want skip some items or not
$sep = " | "; // separator between articles date and creator

if ($columns > 4) $columns = 4; // limit nmber of columns
$anotherlink = ( ($count - $num_intro) ==0 ) ? 0 : 1 ;



if ($order == 0) $orderby = "a.created";
else if ($order == 1)$orderby  = "a.hits";
else $orderby  = "RAND()";

// css classes - hardcoded
$class_date = "minifp-date";
$class_author = "minifp-date";
$class_another_links = "minifp-anotherlinks";
$class_minifulllink = "minifp-full_link";
$class_introtitle = 'minifp-introtitle';
$class_categoria = 'minifp-anotherlinks';

// if there's no image in an article, give it a default one - change image name here if you have one
$default_image_path = "/modules/minifrontpage/default.gif";
/* used for finding images path on img tag */
$image_path = $params->get( 'image_path', 'images/stories' );

$now 		= _CURRENT_SERVER_TIME;
$access 	= !$mainframe->getCfg( 'shownoauth' );
$nullDate 	= $database->getNullDate();

$whereCatid = '';
if ($categories) {
	$catids = explode( ',', $categories );
	mosArrayToInts( $catids );
	$whereCatid = "\n AND ( a.catid=" . implode( " OR a.catid=", $catids ) . " )";
}
$whereSecid = '';
if ($sections) {
	$secids = explode( ',', $sections );
	mosArrayToInts( $secids );
	$whereSecid = "\n AND ( a.sectionid=" . implode( " OR a.sectionid=", $secids ) . " )";
}

$query = "SELECT a.*, u.name, cc.image AS image"
		. "\n FROM #__content AS a"
		. "\n LEFT JOIN #__content_frontpage AS f ON f.content_id = a.id"
		. "\n LEFT JOIN #__users AS u ON u.id = a.created_by"
		. "\n INNER JOIN #__categories AS cc ON cc.id = a.catid"
		. "\n INNER JOIN #__sections AS s ON s.id = a.sectionid"
		. "\n WHERE ( a.state = 1 AND a.sectionid > 0 )"
		. "\n AND ( a.publish_up = " . $database->Quote( $nullDate ) 
		. " OR a.publish_up <= " . $database->Quote( $now ) . " )"
		. "\n AND ( a.publish_down = " . $database->Quote( $nullDate ) 
		. " OR a.publish_down >= " . $database->Quote( $now ) . " )"
		. ( $access ? "\n AND a.access <= " . (int) $my->gid 
		. " AND cc.access <= " . (int) $my->gid 
		. " AND s.access <= " . (int) $my->gid : '' )
		. $whereCatid
		. $whereSecid
		. "\n AND ((TO_DAYS('" . date( 'Y-m-d', time()+$mosConfig_offset*60*60 ) . "') - TO_DAYS(a.created)) <= '" . $period . "')"
		. ( $show_front == '0' ? "\n AND f.content_id IS NULL" : '' )
		. "\n AND s.published = 1"
		. "\n AND cc.published = 1"
		. "\n ORDER BY $orderby DESC"
		. "\n limit $skip," . $count;


//echo $query;
$database->setQuery( $query );
$rows = $database->loadObjectList();
echo $database->getErrorMsg();


$col = 0;
$pwidth = intval(100/$columns);

$rc = count($rows);
$counter = $num_intro;

for ( $r = 0; $r < $rc; $r++) 
{
	if ($thumb_embed && $counter) 
	{	
	/* Regex tool for finding image path on img tag - thx to Jerson Figueiredo */	
	preg_match_all("#<img(.*)>#", $rows[$r]->introtext . $rows[$r]->fulltext, $txtimg);
	if (!empty($txtimg[0])) 
	{
		foreach ($txtimg[0] as $txtimgel) 
		{
			$rows[$r]->introtext = str_replace($txtimgel,"",$rows[$r]->introtext);
			if ( strstr($txtimgel, $image_path) ) 
			{
				if (strstr($txtimgel, 'src="/')) {
					preg_match_all("#src=\"\/" . addslashes($image_path) . "\/([\:\-\/\_A-Za-z0-9\.]+)\"#",$txtimgel,$txtimgelsr);
				}
				else {
					preg_match_all("#src=\"" . addslashes($image_path) . "\/([\:\-\/\_A-Za-z0-9\.]+)\"#",$txtimgel,$txtimgelsr);
				}
				
				if (!empty($rows[$r]->images)) {
					$rows[$r]->images = $txtimgelsr[1][0] . "\n" . $rows[$r]->images;
				}
				else {
					$rows[$r]->images = $txtimgelsr[1][0];
				}
			} 
			elseif (preg_match_all("#http#",$txtimgel,$txtimelsr,PREG_PATTERN_ORDER) > 0) {
				preg_match_all("#src=\"([\-\/\_A-Za-z0-9\.\:]+)\"#",$txtimgel,$txtimgelsr);
				if (!empty($rows[$r]->images)) {
					$rows[$r]->images = $txtimgelsr[1][0] . "\n" . $rows[$r]->images;
				}
				else {
					$rows[$r]->images = $txtimgelsr[1][0];
				}
			}
		}
		}
	} // end of thumbnail processing
	$rows[$r]->introtext= preg_replace("/{[^}]*}/","",$rows[$r]->introtext);
	$rows[$r]->itemid =  fptn_get_id($rows[$r]->id);

	// stripped html by default
	$rows[$r]->introtext = strip_tags($rows[$r]->introtext,$allowed_tags);
  	if($limit > 0) {
        $rows[$r]->introtext = fptn_limittext($rows[$r]->introtext,$limit);
	}
	$counter--;
}


//---------------------------------------------- View MiniFrontPage -----------------------------------------------

if ($thumb_enable == 1 )
{
	$ini_intro = 1;
	
	echo '<table width="100%" class="minifp">';
		
	foreach ( $rows as $row ) 
	{
		// - add category title -
		if ($cat_title) {
			$query = "SELECT name FROM #__categories WHERE id =". $row->catid;
			$database->setQuery( $query );
			$database->loadObject($categ);
		}
		
		if ($show_title) {
			$title = '<a href="'. sefRelToAbs( 'index.php?option=com_content&amp;task=view&amp;id=' .$row->id . '&amp;Itemid=' . $row->itemid ) .'">'.  $row->title . '</a>';
		}
		else $title = "";
		
		if ( $num_intro ) 
		{
			if ($col==0) echo '<tr>';
			
			echo '<td valign="top" width="' . $pwidth . '%" class="minifp">';
		
			if ($loadorder == 1) 
			{
				showThumb($row->images,$row->image,$params,$row->itemid,$row->id);				
			}
			
			if ($cat_title) echo '<span class="'.$class_categoria.'">'.   $categ->name . '</span>';
			
			if ($show_title) {
				if ($title_link == 1) { echo '<span class="'.$class_introtitle.'">'.$title.'</span>'; }
				else { echo '<span class="'.$class_introtitle.'">'.  $row->title . '</span>'; }
				echo "<p />";
			}
			
			if ($show_date) {
				echo '<span class="'.$class_date.'">';
				echo mosFormatDate ($row->publish_up, $params->get( 'date_format' ));
				echo '</span>';
			}
			
			if ( $row->created_by_alias ) { $author = $row->created_by_alias; }
	    	else { $author = htmlspecialchars( $row->name ); }        
			
	    	if ($show_date && $show_author) {
	    		echo $sep;
    	   	}
    	   	
	    	if ($show_author==1) {
				echo '<span class="'.$class_author.'">'.$author.'</span>';
	    	}
	    	echo '<p />';
			
			
	    	if ($loadorder == 0) {
		    	
				showThumb($row->images,$row->image,$params,$row->itemid,$row->id);
		    }	
				          
			if ( ($limit > 1)  ) { 
				echo $row->introtext; 
				echo '<br />';
			}
			
			else { 
					echo '<div style="clear: both;"></div>'; 
			}
			
			if ($fulllink !="")
			{
				echo '<a class="minifp-full-link" href="'. sefRelToAbs( 'index.php?option=com_content&amp;task=view&amp;id=' . $row->id .'&amp;Itemid=' . $row->itemid) .'">'. $fulllink . '</a>' ;
			}
			
			echo "</td>";
			
			$num_intro = $num_intro - 1;
						
			if ( $num_intro == 0 ) 
			{
				$ini_intro = 0;
				
				if ( ( ( ($col + 1) % $columns ) == 0 ) && $anotherlink ) echo "</tr><tr>";
				if ( ( ( ($col + 1) % $columns ) == 0 ) && !$anotherlink ) echo "</tr>";
				if ($anotherlink) {
				echo '<td valign="top" colspan="'.$columns.'">';
					if ($header_title_links != "") echo "<span class='".$class_another_links."'>".$header_title_links."</span>";
					else echo "<p />";
					echo '<ul class="minifp">';
				}
				else { }
			}
		}  
		
		else if ( ($num_intro==0) && ($ini_intro == 1) ) 
		{
			if ( ( ($col + 1) % $columns ) == 0 ) echo "</tr><tr>";
			
				echo '<td valign="top" colspan="'.$columns.'">';
				if ($header_title_links != "") echo "<span class='".$class_another_links."'>".$header_title_links."</span>";
				else echo "<p />";
				echo '<ul class="minifp">';
				echo "<li class='minifp'>". $title ."</li>";
				$ini_intro = 0;
				continue;
			
		}
		else { 
			echo "<li class='minifp'>". $title ."</li>";
		}
					
		$col = ($col + 1) % $columns;
		if ($col == 0 && $num_intro) echo "</tr>";
						
	}
	
	if ( ($num_intro==0) && $anotherlink) { echo "</ul></td></tr>"; } 
	
	
	echo '</table>';
	
}


?>
