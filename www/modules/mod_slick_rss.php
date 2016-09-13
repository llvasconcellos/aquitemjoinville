<?php
/**
* @version $Id: mod_slick_rss.php  2007-23-01 15:12:03Z davidwhthomas $
* @package mod_slick_rss
* @author David Thomas davidwhthomas@gmail.com
* @license Creative Commons Attribution-Noncommercial-Share Alike 2.5 License http://creativecommons.org/licenses/by-nc-sa/2.5/
* @version 1.4
* @credit: Joomla! Open Source Matters for the RSS parsing code
* @description: Joomla module to show list of RSS newslinks with tooltip info box for item description text.
*/

// following line is to prevent direct access to this script via the url
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

// feed output
global $mosConfig_absolute_path, $mosConfig_cachepath;

// Include SimplePie RSS Parser, supports utf-8 and international character sets in newsfeeds
include_once('mod_slick_rss/simplepie.inc');

// check if cache directory exists and is writeable
$cacheDir 		= $mosConfig_cachepath .'/';	
if ( !is_writable( $cacheDir ) ) {	
	return 'Cache Directory Unwriteable';
	$cache_exists = false;
}else{
	$cache_exists = true;
}

$rssurl1 			= $params->get( 'rssurl1',NULL );
$rssurl2 			= $params->get( 'rssurl2',NULL );
$rssurl3 			= $params->get( 'rssurl3',NULL );
$rssurl4 			= $params->get( 'rssurl4',NULL );
$rssurl5 			= $params->get( 'rssurl5',NULL );
$rssitems 			= $params->get( 'rssitems', 5 );
$rssdesc 			= $params->get( 'rssdesc', 1 );
$rssimage 			= $params->get( 'rssimage', 1 );
$rssitemtitle_words = $params->def( 'rssitemtitle_words', 0 );
$rssitemdesc		= $params->get( 'rssitemdesc', 0 );
$rssitemdesc_images	= $params->get( 'rssitemdesc_images', 1 );
$rssitemdesc_words	= $params->get( 'rssitemdesc_words', 0 );
$rsstitle			= $params->get( 'rsstitle', 1 );
$rsscache			= $params->get( 'rsscache', 3600 );
$link_target		= $params->get( 'link_target', 1 );
$override_charset	= $params->get( 'override_charset', 0 );
$translate_encoding	= $params->get( 'translate_encoding', 1 );
$rssitem_show_enclosure	= $params->get( 'rssitem_show_enclosure', 1 );

$enable_tooltip     = $params->get( 'enable_tooltip','yes' );
$tooltip_desc_words	= $params->def( 't_word_count_desc', 25 );
$tooltip_desc_images= $params->def( 'tooltip_desc_images', 1 );
$tooltip_title_words= $params->def( 't_word_count_title', 25 );
$tooltip_bgcolor    = $params->get( 'tooltip_bgcolor','#24537d' );
$tooltip_capcolor   = $params->get( 'tooltip_capcolor','#ffffff' );
$tooltip_fgcolor    = $params->get( 'tooltip_fgcolor','#E1F0FF' );
$tooltip_textcolor  = $params->get( 'tooltip_textcolor','#000000' );
$tooltip_border     = $params->get( 'tooltip_border','1' );
$tooltip_extra_invocation_string = $params->get( 'tooltip_extra_invocation_string','' );

if($tooltip_extra_invocation_string){
	$tooltip_extra_invocation_string = ",".$tooltip_extra_invocation_string; //add leading comma for parameter list
}
switch($link_target){ //open links in this window or new window?
	case 1:
		$link_target='_blank';
		break;
	case 0:
		$link_target='_self';
		break;
	default:
		$link_target='_blank';
		break;
}
$contentBuffer	= '';

//add support for multiple RSS feeds
$rssFeeds = array($rssurl1, $rssurl2, $rssurl3, $rssurl4, $rssurl5);

//strip empty array elements
foreach ($rssFeeds as $index => $value) {
	if (empty($value)) unset($rssFeeds[$index]);
}

//loop through and display each newsfeed	
foreach($rssFeeds as $rssurl){
	$feed = new SimplePie();
	$feed->feed_url($rssurl);
	
	/**Handle RSS and Joomla encoding differences **/	
	if($override_charset){ 
		//set / override Joomla HTML page metatag charset to match RSS character encoding
		$feed->handle_content_type(); 
	}
	
	//if the rss and joomla charset encodings are different 
	//and the default joomla charset page html header is not being overwritten, 
	//try to output RSS feed with joomla encoding 
	//* Note: 
	//If your default charset does not support them (e.g Chinese in ISO-8859-1) , some characters may be displayed as ? 
	//but it works with ISO-8859-1 for most accented characters (french, italian, spanish etc...
	//see here for list of characters supported by ISO-8859-1 
	// http://en.wikipedia.org/wiki/ISO_8859-1#Code_table
	//If you're displaying asian characters, if possible, convert or use UTF-8 for your Joomla site.
	
	$feed_encoding = strtolower($feed->get_encoding()); //get encoding of current RSS feed
	$joomla_encoding = str_replace('charset=','',_ISO); //get Joomla configuration charset from language file
	
	if(($feed_encoding !== $joomla_encoding) && $translate_encoding && !$override_charset ){ 
		//convert RSS feed to default joomla encoding
	  $feed->output_encoding(strtoupper($joomla_encoding));
	}
	
	//check and set caching
	if($cache_exists) {
		$feed->cache_location($cacheDir);
		$feed->caching = true;
		$cache_time = (intval($rsscache) / 60); //convery from seconds to minutes
		$feed->cache_max_minutes($cache_time);
	}
	else {
		$feed->caching = false;
	}
	//$feed->replace_headers(true); //change <h1><h2> and <h3> html header tags in newsfeed to <h4>
	$feed->strip_ads(true);
	$feed->init(); //initialise the newsfeed parsing
	
	//$feed_encoding = strtolower("charset=".$feed->get_encoding());
	//$joomla_encoding = _ISO;
	
	//check for error message
	if (isset($feed->error)) {
		echo '<div class="sr_error">' . "\r\n";
			echo '<p>' . htmlspecialchars($feed->error) . "</p>\r\n";
		echo '</div>' . "\r\n";
	}
		
		
	//print_r($feed);
	
	//die();
		
		
		
	//start showing the feed meta-info (title, desc and image)
	$content_buffer = '';
	$content_buffer = '<table cellpadding="0" cellspacing="0" >' . "\n";
	
	// feed title			
	if ( $feed->get_feed_title() && $rsstitle ) {

		$content_buffer .= "<tr>\n";
		$content_buffer .= "	<td>\n";
		$content_buffer .= "		<strong>\n";
		$content_buffer .= "		<a href=\"" . $feed->get_feed_link()  . "\" target=\"_blank\">\n";
		$content_buffer .= $feed->get_feed_title() . "</a>\n";
		$content_buffer .= "		</strong>\n";
		$content_buffer .= "	</td>\n";
		$content_buffer .= "</tr>\n";

	}
	
	// feed description
	if ( $rssdesc ) {
		
		$content_buffer .= "<tr>\n";
		$content_buffer .= "	<td>\n";
		$content_buffer .= $feed->get_feed_description();
		$content_buffer .= "	</td>\n";
		$content_buffer .= "</tr>\n";
	}
	
	// feed image
	if ( $rssimage && $feed->get_image_url() ) {
		$content_buffer .= "<tr>\n";
		$content_buffer .= "	<td align=\"center\">\n";
		$content_buffer .= "		<image src=\"" . $feed->get_image_url() . "\" alt=\"" . $feed->get_image_title() . "\"/>\n";
		$content_buffer .= "	</td>\n";
		$content_buffer .= "</tr>\n";
	}		
	
	//end feed meta-info
	//start processing feed items
	$content_buffer .= "<tr>\n";
	$content_buffer .= "	<td>\n";
	$content_buffer .= "		<ul class=\"newsfeed" . $moduleclass_sfx . "\">\n";
	//if there are items in the feed
	if($feed->get_item_quantity()){	
	//start looping through the feed items
	foreach ($feed->get_items(0, $rssitems) as $currItem) {	
	
		// item title							
		$item_title = trim($currItem->get_title());
		
		// item title word limit check
		if ( $rssitemtitle_words ) {
			$item_titles = explode( ' ', $item_title );
			$count = count( $item_titles );
			if ( $count > $rssitemtitle_words ) {
				$item_title = '';
				for( $i=0; $i < $rssitemtitle_words; $i++ ) {
					$item_title .= ' '. $item_titles[$i];
				}
				$item_title .= '...';
			}
		}	
		
		// item description
		if($rssitemdesc){
			$desc = trim($currItem->get_description());
			if(!$rssitemdesc_images){
				$desc = preg_replace("/<img[^>]+\>/i", "", $desc);
			}	
			
			//item description word limit check
			if ( $rssitemdesc_words ) {
				$texts = explode( ' ', $desc );
				$count = count( $texts );
				if ( $count > $rssitemdesc_words ) {
					$desc = '';
					for( $i=0; $i < $rssitemdesc_words; $i++ ) {
						$desc .= ' '. $texts[$i];
					}
					$desc .= '...';
				}
			}									
		}
		
		// tooltip text
		if ( $enable_tooltip =='yes' ) {
			//load support js library
			mosCommonHTML::loadOverlib();
			
			//tooltip item title
			$t_item_title = trim($currItem->get_title());
			
			// tooltip title word limit check
			if ( $tooltip_title_words ) {
				$t_item_titles = explode( ' ', $t_item_title );
				$count = count( $t_item_titles );
				if ( $count > $tooltip_title_words ) {
					$tooltip_title = '';
					for( $i=0; $i < $tooltip_title_words; $i++ ) {
						$tooltip_title .= ' '. $t_item_titles[$i];
					}
					$tooltip_title .= '...';						
				}else{
					$tooltip_title = $t_item_title;	
				}
			}else{
				$tooltip_title = $t_item_title;	
			}
			
			//tooltip item description
			$text = trim($currItem->get_description());
			if(!$tooltip_desc_images){
				$text = preg_replace("/<img[^>]+\>/i", "", $text);
			}
			
			// tooltip desc word limit check
			if ( $tooltip_desc_words ) {
				$texts = explode( ' ', $text );
				$count = count( $texts );
				if ( $count > $tooltip_desc_words ) {
					$text = '';
					for( $i=0; $i < $tooltip_desc_words; $i++ ) {
						$text .= ' '. $texts[$i];
					}
					$text .= '...';
				}
			}
			
			//build tooltip content
			$text = preg_replace("/(\r\n|\n|\r)/", " ", $text); //replace new line characters in tooltip, important!
			$tooltip_title = preg_replace("/(\r\n|\n|\r)/", " ", $tooltip_title); //replace new line characters in tooltip title, important!
			$text = htmlspecialchars(addslashes(html_entity_decode($text))); //format text for overlib popup html display
			$tooltip = " onmouseover=\"overlib('".$text."', CAPTION, '".htmlspecialchars(addslashes(html_entity_decode($tooltip_title)))."', FGCOLOR, '".$tooltip_fgcolor."', BGCOLOR, '".$tooltip_bgcolor."', BORDER, ".$tooltip_border.", CAPCOLOR, '".$tooltip_capcolor."', TEXTCOLOR, '".$tooltip_textcolor."'".$tooltip_extra_invocation_string.");\" onmouseout=\"return nd();\" "; //assign mouseover text to put in title hyperlink
		}else{ 
			$tooltip = "";
		}							
		
		//start assigning item content to output buffer
		$content_buffer .= "<li class=\"newsfeed" . $moduleclass_sfx . "\">\n";
		
		
		//print_r($currItem);
		
		
		if ($currItem->get_permalink()) {
			$content_buffer .=  "<b>" . $currItem->get_date('H:i:s') . "</b> -       <a ".$tooltip." href=\"" . $currItem->get_permalink() . "\" target=\"".$link_target."\">\n";
			$content_buffer .= "      " . html_entity_decode($item_title) . "</a>\n";
			if($rssitemdesc){ //show item desc
				$content_buffer .= "      <br />" . html_entity_decode($desc) . "\n";
			}
		}   
		
		//check if feed has enclosure tag (used for podcasts,  embedding video / audio feeds etc...)
		if( $rssitem_show_enclosure){
		if ($enclosure = $currItem->get_enclosure() ) {
			//if it's an image, show it
			if($enclosure->get_type() == "image/jpeg" && $rssitemdesc_images){
				$content_buffer .= "<br />" .
				"<a href='" . $currItem->get_link() . "' target='".$link_target."'>\n" .
				"<img src='" . $enclosure->get_link() . "' alt='image' /></a>";
			}else{ //link to media file
				$content_buffer .= "        <a href=\"" . $enclosure->get_link() . "\" target=\"_blank\">\n";
				$content_buffer .= "       (". $enclosure->get_type() . " ".$enclosure->get_size()."MB )</a>\n";
			}
		}
		}		
		$content_buffer .= "</li>\n";
	}				
	
	} //end item quantity check if statement
	
	$content_buffer .= "    </ul>\n";
	$content_buffer .= "	</td>\n";
	$content_buffer .= "</tr>\n";
	$content_buffer .= "</table>\n";
	
	//last processing!
	//$content_buffer = html_entity_decode($content_buffer); //add fix for html entities not being decoded (e.g &quot; etc...)
	
	//display the newsfeed!	
	print $content_buffer;
} //next feed loop
?>