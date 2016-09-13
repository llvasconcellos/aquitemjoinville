<?php
/*
// "Simple RSS Feed Reader" Module for Joomla! 1.0.x & Mambo 4.5.x/4.6.x - Version 1.4
// License: http://www.gnu.org/copyleft/gpl.html
// Authors: Fotis Evangelou - George Chouliaras
// Copyright (c) 2006 - 2007 JoomlaWorks.gr - http://www.joomlaworks.gr
// Project page at http://www.joomlaworks.gr - Demos at http://demo.joomlaworks.gr
// ***Last update: October 26th, 2007***
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

global $mosConfig_offset, $mosConfig_live_site, $mosConfig_absolute_path, $mosConfig_locale, $mainframe;

// module parameters
$moduleclass_sfx 	= $params->get( 'moduleclass_sfx','');
$srfr_cache			= intval($params->get('srfr_cache',30));
$srfr_timeout		= intval($params->get('srfr_timeout',10));
$srfr_fitems		= intval($params->get('srfr_fitems',5));
$srfr_totalitems	= intval($params->get('srfr_totalitems'));
$srfr_ftimezone		= intval($params->get('srfr_ftimezone',0));
$srfr_fname			= intval($params->get('srfr_fname',1));
$srfr_fititle		= intval($params->get('srfr_fititle',1));
$srfr_fitime		= intval($params->get('srfr_fitime',1));
$srfr_fi_content	= $params->get('srfr_fi_content','none');
$srfr_fi_words		= intval($params->get('srfr_fi_words',''));
$srfr_fi_hideimages	= intval($params->get('srfr_fi_hideimages',0));
$striptags 			= intval($params->get('striptags',0));

$srfr_url01	= $params->get( 'srfr_url01', 'http://feeds.feedburner.com/joomlaworks' );
$srfr_url02 = $params->get( 'srfr_url02', '' );
$srfr_url03 = $params->get( 'srfr_url03', '' );
$srfr_url04 = $params->get( 'srfr_url04', '' );
$srfr_url05 = $params->get( 'srfr_url05', '' );
$srfr_url06 = $params->get( 'srfr_url06', '' );
$srfr_url07 = $params->get( 'srfr_url07', '' );
$srfr_url08 = $params->get( 'srfr_url08', '' );
$srfr_url09 = $params->get( 'srfr_url09', '' );
$srfr_url10 = $params->get( 'srfr_url10', '' );
$srfr_url11 = $params->get( 'srfr_url11', '' );
$srfr_url12 = $params->get( 'srfr_url12', '' );
$srfr_url13 = $params->get( 'srfr_url13', '' );
$srfr_url14 = $params->get( 'srfr_url14', '' );
$srfr_url15 = $params->get( 'srfr_url15', '' );
$srfr_url16 = $params->get( 'srfr_url16', '' );
$srfr_url17 = $params->get( 'srfr_url17', '' );
$srfr_url18 = $params->get( 'srfr_url18', '' );
$srfr_url19 = $params->get( 'srfr_url19', '' );
$srfr_url20 = $params->get( 'srfr_url20', '' );

// SimplePie Setup
if(!class_exists("SimplePie")){
    require_once($mosConfig_absolute_path.'/modules/mod_jw_srfr/simplepie.inc');
}
require_once($mosConfig_absolute_path.'/modules/mod_jw_srfr/idn/idna_convert.class.php');

// Call the feeds
$myfeeds = array();
$myfeeds[] = ''.$srfr_url01.'';
if ($srfr_url02) {$myfeeds[] = ''.$srfr_url02.'';}
if ($srfr_url03) {$myfeeds[] = ''.$srfr_url03.'';}
if ($srfr_url04) {$myfeeds[] = ''.$srfr_url04.'';}
if ($srfr_url05) {$myfeeds[] = ''.$srfr_url05.'';}
if ($srfr_url06) {$myfeeds[] = ''.$srfr_url06.'';}
if ($srfr_url07) {$myfeeds[] = ''.$srfr_url07.'';}
if ($srfr_url08) {$myfeeds[] = ''.$srfr_url08.'';}
if ($srfr_url09) {$myfeeds[] = ''.$srfr_url09.'';}
if ($srfr_url10) {$myfeeds[] = ''.$srfr_url10.'';}
if ($srfr_url11) {$myfeeds[] = ''.$srfr_url11.'';}
if ($srfr_url12) {$myfeeds[] = ''.$srfr_url12.'';}
if ($srfr_url13) {$myfeeds[] = ''.$srfr_url13.'';}
if ($srfr_url14) {$myfeeds[] = ''.$srfr_url14.'';}
if ($srfr_url15) {$myfeeds[] = ''.$srfr_url15.'';}
if ($srfr_url16) {$myfeeds[] = ''.$srfr_url16.'';}
if ($srfr_url17) {$myfeeds[] = ''.$srfr_url17.'';}
if ($srfr_url18) {$myfeeds[] = ''.$srfr_url18.'';}
if ($srfr_url19) {$myfeeds[] = ''.$srfr_url19.'';}
if ($srfr_url20) {$myfeeds[] = ''.$srfr_url20.'';}
 
// This array will hold the items we'll be grabbing.
$first_items = array();
 
// Let's go through the array, feed by feed, and store the items we want.
foreach ($myfeeds as $url) {

    // Use the long syntax
    $feed = new SimplePie();
	$feed->set_feed_url($url);	
	
	// Set timeout
	$feed->set_timeout($srfr_timeout); 

	// Check if the cache folder exists
	if(file_exists($mosConfig_absolute_path.'/cache')) {
		$feed->enable_cache(true);
		$feed->set_cache_duration($srfr_cache*60);
		$feed->set_cache_location($mosConfig_absolute_path . '/cache');
	} else {
		$feed->enable_cache(false);
	}

    $feed->init();
 
	// As long as we're not trying to grab more items than the feed has, go through them one by one and add them to the array.
	for ($x = 0; $x < $feed->get_item_quantity($srfr_fitems); $x++) {$first_items[] = $feed->get_item($x);}
 
    // We're done with this feed, so let's release some memory.
    unset($feed);
}
 
// We need to sort the items by date with a user-defined sorting function.
// Since usort() won't accept "SimplePie::sort_items", we need to wrap it in a new function.
if(!function_exists("sort_items")){
	function sort_items($a, $b) {return SimplePie::sort_items($a, $b);}
}
 
// Now we can sort $first_items with our custom sorting function.
usort($first_items, "sort_items");

/* ----------------------- Content Handling ----------------------- */

// Word limitation
if (!function_exists('word_limiter')) {
	function word_limiter($str, $limit = 100, $end_char = '&#8230;') {
		  if (trim($str) == '')
			return $str;
		  preg_match('/\s*(?:\S*\s*){'. (int) $limit .'}/', $str, $matches);
		  if (strlen($matches[0]) == strlen($str))
			$end_char = '';
		  return rtrim($matches[0]).$end_char;
	}
}

// OUTPUT
?>

<!-- JW "Simple RSS Feed Reader" Module (v1.4) starts here -->
<script language="javascript" type="text/javascript">
<!--
var srfrCSS = '<' + 'style type="text/css" media="screen">'
+ '@import "modules/mod_jw_srfr/mod_jw_srfr.css";'
+ '</' + 'style>';
document.write(srfrCSS);
-->
</script>
<noscript>
<link rel="stylesheet" type="text/css" href="modules/mod_jw_srfr/mod_jw_srfr.css" />
</noscript>
<?php if ($feed->error){ echo '<span class="message">'.$feed->error().'</span>'; } ?>
<div id="srfr-container<?php echo $moduleclass_sfx; ?>">
  <ul class="srfr">
    <?php
	if($srfr_totalitems) { $i=0; }
	foreach($first_items as $key => $item) {
		if($srfr_totalitems) {if($i>=$srfr_totalitems) continue;}
		$feed = $item->get_feed();
	?>
    <li class="srfr-row<?php echo ($key%2); ?>">
      <!-- feed item title -->
      <?php if($srfr_fititle) { ?>
      <a class="srfr-feed-title" target="_blank" href="<?php echo $item->get_permalink(); ?>">
	  	<?php echo $item->get_title(); ?>
      </a>
      <?php } ?>
      <!-- feed item timestamp -->
      <?php if($srfr_fitime) { ?>
      <span class="srfr-feed-timestamp">
      <?php
		if($srfr_ftimezone) {
			echo $item->get_date('G:i (\G\M\T) - j.m.Y'); // GMT timezone
		} else {
			echo $item->get_date('j M Y | g:i a'); // Local timezone
		}
	  ?>
      </span>
      <?php } ?>
      <!-- feed name -->
      <?php if($srfr_fname) { ?>
      <a class="srfr-feed-name" target="_blank" href="<?php echo $feed->get_permalink(); ?>">
	  	<?php echo $feed->get_title(); ?>
      </a>
      <?php } ?>
      <!-- feed item intro/full text -->
      <?php
		// Assign
		$introtext = $item->get_description();
		$fulltext = $item->get_content();
		
		// Remove images
		if ($srfr_fi_hideimages) {
			//$introtext = preg_replace("/<img[^>]+\>/i", "", $introtext);
			//$fulltext = preg_replace("/<img[^>]+\>/i", "", $fulltext);
			$introtext = preg_replace("/<img.+?>/", "", $introtext);
			$fulltext = preg_replace("/<img.+?>/", "", $fulltext);
		}		
			
		// HTML cleanup
		$allowed_tags = "<img><p><br><a><b>"; // These tags will NOT be stripped off!
		if ($striptags) {
			$introtext = strip_tags($introtext, $allowed_tags);
			$fulltext = strip_tags($fulltext, $allowed_tags);
		}
			
		// Word limitation
		if ($srfr_fi_words) {
			$introtext = word_limiter($item->get_description(),$srfr_fi_words);
			$fulltext = word_limiter($item->get_content(),$srfr_fi_words);
		}
	  ?>      
	  <?php if($srfr_fi_content=="intro") { ?>
      <p class="srfr-feed-intro"><?php echo $introtext; ?></p>
      <?php } ?>
	  <?php if($srfr_fi_content=="full") { ?>
      <p class="srfr-feed-full"><?php echo $fulltext; ?></p>
      <?php } ?> 
    </li>
    <?php 
		if($srfr_totalitems) { $i++; }
	}
	?>
  </ul>
</div>
<!-- JW "Simple RSS Feed Reader" Module (v1.4) ends here -->
