<?php
/**
* @version $Id: mod_magpierss.php 2006-11-24 eddychang $
* @package JoomlaExtensions
* @copyright Copyright (C) 2006 TaiwanJoomla.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
**/

// no direct access
defined( '_VALID_MOS' ) or die( 'Restricted access' );
global $mosConfig_absolute_path, $mosConfig_cachepath;

//to keep off php WARNINGs and NOTICEs 
ini_set('display_errors', 0);

//use joomla to get the params
$url 		= trim( $params->get( 'url', '' ) );
$num_items 	= intval( $params->get( 'num_items', 5 ) );
$show_time	= intval($params->get( 'show_time', 0 ));
$is_cache	= intval($params->get( 'is_cache', 1 ));
$cache_age  =intval($params->get( 'cache_age', 3600 ));

//pre-define the magpierss
require_once( "".$mosConfig_absolute_path."/modules/magpierss/rss_fetch.inc" );
require_once( "".$mosConfig_absolute_path."/modules/magpierss/rss_utils.inc" );
define('MAGPIE_OUTPUT_ENCODING', 'UTF-8');
if($is_cache==1)
    define('MAGPIE_CACHE_DIR', "".$mosConfig_cachepath);


	$rss = fetch_rss( $url );
    $items = array_slice($rss->items, 0, $num_items);
    
    //check if there is an error
	if ( $rss ) {
	
	//Title will be add next time~~
	//echo "Channel Title: " . $rss->channel['title'] . "<p>";
	echo "<ul>";
	foreach ( $items as $item ) {
		
		$href = $item['link'];
		$title = $item['title'];
		if($show_time==1){
			$published = parse_w3cdtf($item['dc']['date']);
		   echo "<li><a href=$href>$title</a>(" . date("Y-m-d h:i:s A", $published).")</li>";
		}else{
		   echo "<li><a href=$href>$title</a></li>";
		}
	}
	echo "</ul>";
    }else{
    	echo "An error occured!  " .
        "<br>Error Message: " . magpie_error();
    }


?>