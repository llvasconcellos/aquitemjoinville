<?php
/**
* @package rssFactory
* @version 1.0
* @copyright www.thefactory.ro
* @license: commercial
*/
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

function filterPublished() {
    $active=mosGetParam($_REQUEST,'publish_filter',null);
	$pub[] = mosHTML::makeOption( '', _CMN_SELECT );
	$pub[] = mosHTML::makeOption( '1', _CMN_PUBLISHED );
	$pub[] = mosHTML::makeOption( '0', _CMN_UNPUBLISHED );
	$pub_list=mosHTML::selectList( $pub, 'publish_filter', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', $active );

	return $pub_list;
}
function filterCategory() {
	global $database;
     $active=mosGetParam($_REQUEST,'catid',null);
	$categories[] = mosHTML::makeOption( '', _SEL_CATEGORY );
	$database->setQuery( 'select distinct cat as value,cat as text from #__rssfactory' );
	$categories = array_merge( $categories, $database->loadObjectList() );

	$category = mosHTML::selectList( $categories, 'catid', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', $active );

	return $category;
}
function saveToFile($filename,$content){
    if (!is_writable($filename) &&(file_exists($filename)))
        chmod($filename,0777);
    if ($fp=fopen($filename, 'w+')) {
	      $r=fputs($fp, $content, strlen($content));
	      fclose($fp);
	      return $r;
    }else
         return false;


}
function GetJoomlaSession(){
    if (!empty($_COOKIE['sessioncookie']))
        return $_COOKIE['sessioncookie'];
    $s=mosMainFrame::sessionCookieName();
    if (!empty($s) && !empty($_COOKIE[$s]))
        return $_COOKIE[$s];
    return $_COOKIE["PHPSESSID"];
}
function remote_read_url( $uri ) {

    if ( function_exists('curl_init') ){
        $handle = curl_init();

        curl_setopt ($handle, CURLOPT_URL, $uri);
        curl_setopt ($handle, CURLOPT_MAXREDIRS,5);
        curl_setopt ($handle, CURLOPT_AUTOREFERER, 1);
        if (!SITE_SAFE_MODE_ON)  curl_setopt ($handle, CURLOPT_FOLLOWLOCATION ,1);
        curl_setopt ($handle, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt ($handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($handle, CURLOPT_TIMEOUT, 100);
        $buffer = curl_exec($handle);

        curl_close($handle);
        return $buffer;
    } else  if ( ini_get('allow_url_fopen') ) {
        $fp = @fopen( $uri, 'r' );
        if ( !$fp )
            return false;
     	stream_set_timeout($fp, 20);
        $linea = '';
        while( $remote_read = fread($fp, 4096) )
            $linea .= $remote_read;
   		$info = stream_get_meta_data($fp);
        fclose($fp);
    	if ($info['timed_out'])
    	   return false;
        return $linea;
    } else {
       return false;
    }
}

  /**
   * Encodes UTF-8 characters to HTML entities
   *
   * @author <vpribish at shopping dot com>
   * @link   http://www.php.net/manual/en/function.utf8-decode.php
   */
function utf8_tohtml ($str) {
    $ret = '';
    $max = strlen($str);
    $last = 0;  // keeps the index of the last regular character
    for ($i=0; $i<$max; $i++) {
      $c = $str{$i};
      $c1 = ord($c);
      if ($c1>>5 == 6) {  // 110x xxxx, 110 prefix for 2 bytes unicode
        $ret .= substr($str, $last, $i-$last); // append all the regular characters we've passed
        $c1 &= 31; // remove the 3 bit two bytes prefix
        $c2 = ord($str{++$i}); // the next byte
        $c2 &= 63;  // remove the 2 bit trailing byte prefix
        $c2 |= (($c1 & 3) << 6); // last 2 bits of c1 become first 2 of c2
        $c1 >>= 2; // c1 shifts 2 to the right
        $ret .= '&#' . ($c1 * 100 + $c2) . ';'; // this is the fastest string concatenation
        $last = $i+1;
      }
    }
    return $ret . substr($str, $last, $i); // append the last batch of regular characters
  }

function ParseRss_toCache2($rssid,$rssurl,$rss,$nrfeeds){
    global $mosConfig_absolute_path;
    global $database;
    require_once( $mosConfig_absolute_path . '/components/com_rssfactory/magpierss/rss_fetch.inc');
    if (!class_exists("MagpieRSS")) return;
    init();
//   $resp = new MagpieRSS( $rss, 'ISO-8859-1',null, true );
   $resp = new MagpieRSS( $rss, 'UTF-8',null, true );
//   var_dump($resp->source_encoding);
    // if RSS parsed successfully
    if ( !$resp or $resp->ERROR) {
        return ParseRss_toCache($rssid,$rssurl,$rss,$nrfeeds);
    }
	$items = $resp->items;

    $numItems=0;
	$query = "delete FROM #__rssfactory_cache where rssid='$rssid' ";
	$database->setQuery( $query );
	$database->query();
    $row=new rsscache_db($database);
    $now = date( "Y-m-d H:i:s", time()+$mosConfig_offset*60*60 );
	foreach ($items as $item) {
		if($numItems<$nrfeeds && $nrfeeds!=0){
	        $row->id=null;
	        $row->channel_title =$resp->channel['title'];
	        $row->channel_link=$resp->channel['link'];
	        $row->rssid=$rssid;
	        $row->rssurl=$rssurl;
	        $row->date=$now;

	        $row->channel_description=$resp->channel['description'];

	        $row->item_title=$item['title'];
	        if (isset($item['atom_content'])) {
	            $row->item_description=$item['atom_content'];
	        }else
	            $row->item_description=$item['description'];
	        $row->item_link=$item['link'];

	        if (isset($item['link'])) {
	            $row->item_source=$item['link'];
	        }

			$rawDate = $item['pubdate']? $item['pubdate']: $item['dc']['date'];
			if (!$rawDate) $rawDate = $item['dc:date']? $item['dc:date']: $item['pubDate'];
			if($rawDate){
	    		$pat = "/(\d{4})-(\d{2})-(\d{2})T(\d{2}):(\d{2})(:(\d{2}))?(?:([-+])(\d{2}):?(\d{2})|(Z))?/";
	    		if ( preg_match( $pat, $rawDate, $match ) ) {
	    		    $dat= parse_w3cdtf($rawDate);
	    		}
	    		else
	    			$dat= strtotime($rawDate);
	    		if ($dat>strtotime('1990-1-1')){
	   	    		$publishDate = date('Y-m-d H:i:s',$dat);
	                $row->item_date=$publishDate;
	    		}

			}
	        $row->store();
	        $numItems++;
        }
        elseif($nrfeeds==0){
			$row->id=null;
	        $row->channel_title =$resp->channel['title'];
	        $row->channel_link=$resp->channel['link'];
	        $row->rssid=$rssid;
	        $row->rssurl=$rssurl;
	        $row->date=$now;

	        $row->channel_description=$resp->channel['description'];

	        $row->item_title=$item['title'];
	        if (isset($item['atom_content'])) {
	            $row->item_description=$item['atom_content'];
	        }else
	            $row->item_description=$item['description'];
	        $row->item_link=$item['link'];

	        if (isset($item['link'])) {
	            $row->item_source=$item['link'];
	        }

			$rawDate = $item['pubdate']? $item['pubdate']: $item['dc']['date'];
			if (!$rawDate) $rawDate = $item['dc:date']? $item['dc:date']: $item['pubDate'];
			if($rawDate){
	    		$pat = "/(\d{4})-(\d{2})-(\d{2})T(\d{2}):(\d{2})(:(\d{2}))?(?:([-+])(\d{2}):?(\d{2})|(Z))?/";
	    		if ( preg_match( $pat, $rawDate, $match ) ) {
	    		    $dat= parse_w3cdtf($rawDate);
	    		}
	    		else
	    			$dat= strtotime($rawDate);
	    		if ($dat>strtotime('1990-1-1')){
	   	    		$publishDate = date('Y-m-d H:i:s',$dat);
	                $row->item_date=$publishDate;
	    		}

			}
	        $row->store();
	        $numItems++;
		}

	}
    return $numItems;
    //return $nrfeeds;

}
function ParseRss_toCache($rssid,$rssurl,$rss,$nrfeeds){
    //PREPARE ADS!!
    global $database,$mosConfig_offset;
    $now = date( "Y-m-d H:i:s", time()+$mosConfig_offset*60*60 );
	require_once(DOMIT_INCLUDE_PATH . 'xml_domit_rss.php');
    if ($rss=='') return;
    $rssDoc =& new xml_domit_rss_document();
    $success=$rssDoc->parseRSS( $rss );
	if (!$success){
        return 0;//ParseRss_toCache2($rssid,$rssurl,$rss);
    }
    $row=new rsscache_db($database);

    $currChannel =& $rssDoc->getChannel(0);
    if (!$currChannel)
    {
        return ;
    }
    $numItems = $currChannel->getItemCount();
    $nrnew=0;
	$query = "delete FROM #__rssfactory_cache where rssid='$rssid' ";
	$database->setQuery( $query );
	$database->query();

    for ($i = 0; $i < $numItems; $i++) {
    	if($numItems<$nrfeeds){
	        $currItem =& $currChannel->getItem($i);
	        $row->id=null;
	        $row->channel_title =$currChannel->getTitle();
	        $row->channel_link=$currChannel->getLink();
	        $row->rssid=$rssid;
	        $row->rssurl=$rssurl;
	        $row->date=$now;
	        $row->channel_description=$currChannel->getDescription();

	        $numCategories =& $currChannel->getCategoryCount();

	        if ($numCategories>0){
	             $row->channel_category=& $currChannel->getCategory(0);
	        }
	        $row->item_title=$currItem->getTitle();
	        $row->item_description=$currItem->getDescription();
	        $row->item_link=$currItem->getLink();

	        if ($currChannel->hasElement('source')) {
	            $row->item_source=$currChannel->getElementText('source');
	        }

	        if ($currItem->hasElement('pubdate')) {
	            $rawDate=$currItem->getElementText('pubdate');
				$pat = "/(\d{4})-(\d{2})-(\d{2})T(\d{2}):(\d{2})(:(\d{2}))?(?:([-+])(\d{2}):?(\d{2})|(Z))?/";
				if ( preg_match( $pat, $rawDate, $match ) ) {
					$publishDate = date('Y-m-d H:i:s', parse_w3cdtf($rawDate));
				}
				else
					$publishDate = date('Y-m-d H:i:s', strtotime($rawDate));
	            $row->item_date=$publishDate;
	        }
	        $row->store();
        }
        elseif($nrfeeds==0){
			$currItem =& $currChannel->getItem($i);
	        $row->id=null;
	        $row->channel_title =$currChannel->getTitle();
	        $row->channel_link=$currChannel->getLink();
	        $row->rssid=$rssid;
	        $row->rssurl=$rssurl;
	        $row->date=$now;
	        $row->channel_description=$currChannel->getDescription();

	        $numCategories =& $currChannel->getCategoryCount();

	        if ($numCategories>0){
	             $row->channel_category=& $currChannel->getCategory(0);
	        }
	        $row->item_title=$currItem->getTitle();
	        $row->item_description=$currItem->getDescription();
	        $row->item_link=$currItem->getLink();

	        if ($currChannel->hasElement('source')) {
	            $row->item_source=$currChannel->getElementText('source');
	        }

	        if ($currItem->hasElement('pubdate')) {
	            $rawDate=$currItem->getElementText('pubdate');
				$pat = "/(\d{4})-(\d{2})-(\d{2})T(\d{2}):(\d{2})(:(\d{2}))?(?:([-+])(\d{2}):?(\d{2})|(Z))?/";
				if ( preg_match( $pat, $rawDate, $match ) ) {
					$publishDate = date('Y-m-d H:i:s', parse_w3cdtf($rawDate));
				}
				else
					$publishDate = date('Y-m-d H:i:s', strtotime($rawDate));
	            $row->item_date=$publishDate;
	        }
	        $row->store();
		}

    }
    return $numItems;
}
function refresh_specific_RSS(&$row){
    global $database,$cfg,$mosConfig_absolute_path;

    if (! SITE_SAFE_MODE_ON) set_time_limit(180);
    $cfg=new db_rssfactory_config($database);
    $cfg->LoadConfig();

	$nr=0;
	$waserr=0;

	$rss=remote_read_url($row->url);
	CleanRss($rss);

	if (!rss) $waserr=1;
	else{
		$nr=ParseRss_toCache2($row->id,$row->url,$rss,$row->nrfeeds);

    }

    if (preg_match('/<?xml.*encoding=[\'"](.*?)[\'"].*?>/m', $rss, $m)) {
        $in_enc = strtoupper($m[1]);
    }
    else {
        $in_enc = 'UTF-8';
    }
 	$rss=addslashes($rss);
    $query = "update #__rssfactory set temprss='$rss',date=now(), rsserror=$waserr,encoding='$in_enc'".
		  ( (($waserr==1) && ($cfg->unpublisherr))?",published=0":"" ).
		  " where id=$row->id";
	$database->setQuery( $query );
	$database->query();
	return $nr;
}

/*======================================================================*\
    Function: parse_w3cdtf
    Purpose:  parse a W3CDTF date into unix epoch

    NOTE: http://www.w3.org/TR/NOTE-datetime
\*======================================================================*/

function phl_parse_w3cdtf ( $date_str ) {

    # regex to match wc3dtf
    $pat = "/(\d{4})-(\d{2})-(\d{2})T(\d{2}):(\d{2})(:(\d{2}))?(?:([-+])(\d{2}):?(\d{2})|(Z))?/";
		//$pat = "/(\d{4})-(\d{2})-(\d{2})T(\d{2}):(\d{2}):(\d{2})([-+])(\d{2}):(\d{2})/";

    if ( preg_match( $pat, $date_str, $match ) ) {
        list( $year, $month, $day, $hours, $minutes, $seconds) =
            array( $match[1], $match[2], $match[3], $match[4], $match[5], $match[6]);

        # calc epoch for current date assuming GMT
        $epoch = gmmktime( $hours, $minutes, $seconds, $month, $day, $year);

        $offset = 0;
        if ( $match[10] == 'Z' ) {
            # zulu time, aka GMT
        }
        else {
            list( $tz_mod, $tz_hour, $tz_min ) =
                array( $match[8], $match[9], $match[10]);

            # zero out the variables
            if ( ! $tz_hour ) { $tz_hour = 0; }
            if ( ! $tz_min ) { $tz_min = 0; }

            $offset_secs = (($tz_hour*60)+$tz_min)*60;

            # is timezone ahead of GMT?  then subtract offset
            #
            if ( $tz_mod == '+' ) {
                $offset_secs = $offset_secs * -1;
            }

            $offset = $offset_secs;
        }
        $epoch = $epoch + $offset;
        return $epoch;
    }
    else {
        return -1;
    }
}

function PseudoCron($cfg){

    global $database;

	if (! SITE_SAFE_MODE_ON) set_time_limit(180);
    $nowtime=microtime_float();

    if ($cfg->lastcron+($cfg->refreshinterval*60)>$nowtime){
		unset($_SESSION['secretkey']);
		return false;
	}
	else{
		if(!isset($_SESSION))
    		session_start();
    	$_SESSION['secretkey']=md5($nowtime);
    	return true;
    }
}
if (!function_exists('microtime_float')) {
	function microtime_float()
	{
	   list($usec, $sec) = explode(" ", microtime());
	   return ((float)$usec + (float)$sec);
	}
}
if (!function_exists('htmlspecialchars_decode')) {
       function htmlspecialchars_decode($str) {
               $trans = get_html_translation_table(HTML_SPECIALCHARS);

               $decode = ARRAY();
               foreach ($trans AS $char=>$entity) {
                       $decode[$entity] = $char;
               }

               $str = strtr($str, $decode);
               return $str;
       }
}
  // *** Overlib initialisation - Check if DIV "overDiv" is not present and load library, otherwise skip it to avoid duplicate routine initialisation (IE6 issue !!)
if (!function_exists('overlibInitCall')) {
	function overlibInitCall () {
		global $mosConfig_live_site;
		$txt = "";
		$txt .=  '<script language="javascript"> '."\n";
		$txt .=  "  if ( !document.getElementById('overDiv') ) {  "."\n";
		$txt .=  "     document.writeln('<div id=\"overDiv\" style=\"position:absolute; visibility:hidden; z-index:10000;\"></div>'); "."\n";
		$txt .=  "     document.writeln('<scr'+'ipt language=\"Javascript\" src=\"" .$mosConfig_live_site. "/includes/js/overlib_mini.js\"></scr'+'ipt>'); "."\n";
		$txt .=  "  } "."\n";
		$txt .=  "</script> "."\n";
		return $txt;
	}
}
function GetSiteIcon(&$row)
{
    global $mosConfig_absolute_path;
	if(isset($row->url))
		$host = parse_url($row->url);
	else
		$host = array('host'=>'');
	$picurl = 'http://'.$host['host'].'/favicon.ico';
	$contents=remote_read_url( $picurl );
	if (!$contents) return false;
	$handle = fopen( $mosConfig_absolute_path.'/components/com_rssfactory/images/ico_'.md5($host['host']).'.ico', "wb");
	fwrite($handle, $contents) ;
	fclose($handle);
}
function HTMLCreateSiteIco(&$row)
{
	global $mosConfig_live_site,$mosConfig_absolute_path;
	$obj_vars=get_object_vars($row);
	if (array_key_exists('rssurl', $obj_vars))
		$host=parse_url($row->rssurl);
	else
		$host=parse_url($row->url);
	if (! file_exists($mosConfig_absolute_path.'/components/com_rssfactory/images/ico_'.md5($host['host']).'.ico'))
		GetSiteIcon($row);
	if (file_exists($mosConfig_absolute_path.'/components/com_rssfactory/images/ico_'.md5($host['host']).'.ico')){
		$img= $mosConfig_live_site.'/components/com_rssfactory/images/ico_'.md5($host['host']).'.ico';
	}else{
		$img= $mosConfig_live_site.'/components/com_rssfactory/images/default.ico';
	}
	return "<img class='siteicon' id='feedicon_$row->id' src='$img' border=0 />";


}
function SaveSiteIco_file(&$row)
{
	global $mosConfig_live_site,$mosConfig_absolute_path;
	$obj_vars=get_object_vars($row);
	if (array_key_exists('rssurl', $obj_vars))
		$host=parse_url($row->rssurl);
	else
		$host=parse_url($row->url);
    $tmpfile=$_FILES['siteicon']['tmp_name'];
	if (!file_exists($tmpfile)) return;
	move_uploaded_file($tmpfile,$mosConfig_absolute_path.'/components/com_rssfactory/images/ico_'.md5($host['host']).'.ico');


}
function jax_RefreshIcon($feedid)
{
    global $database;
	if (! SITE_SAFE_MODE_ON) set_time_limit(180);
 	$row = new mosRSSReader( $database );
    $row->id=$feedid;
    $row->load();
    GetSiteIcon($row);
    $js_reload="
            var now = new Date();
            if (document.getElementById('feedicon_$feedid')) {
                document.getElementById('feedicon_$feedid').src =
                    document.getElementById('feedicon_$row->id').src +'?'+ now.getTime();
            }
    ";
	$objResponse = new xajaxResponse();

	$objResponse->addScript	($js_reload);
	$objResponse->addScript	("HideProgress();alert('Icon Refreshed!');");
	return $objResponse;

}
function jax_ClearCache($isCaps)
{
	global $database;
	$query = "delete FROM #__rssfactory_cache ";
	$database->setQuery( $query );
	$database->query();

	$objResponse = new xajaxResponse();
	$objResponse->addAssign("nr_feeds","innerHTML",0);
	$objResponse->addScript	("HideProgress();alert('Cache Cleared!');");
	return $objResponse;
}
function jax_RefreshFeed($feedid,$nrfeeds)
{
	global $database,$mosConfig_absolute_path;
	if (! SITE_SAFE_MODE_ON) set_time_limit(180);
	$objResponse = new xajaxResponse();
	$query = "select * FROM #__rssfactory where id='$feedid' ";
	$database->setQuery( $query );
	$row=null;
	$database->LoadObject($row);
	if (!$row){
		$msg='Feed does not exist!';
	}else{
		require_once( $mosConfig_absolute_path .'/includes/domit/xml_domit_include.php' );
		$nr=refresh_specific_RSS($row);
		$msg=$nr.' Feeds added!';
		if($nrfeeds!=0)
			$objResponse->addAssign("nr_feeds_$feedid","innerHTML",$nr);
		else
			$objResponse->addAssign("nr_feeds_$feedid","innerHTML",'All');

	}
	$objResponse->addScript	("HideProgress();alert('$msg!');");
	return $objResponse;
}
function jax_RefreshAllFeeds(){

	global $database,$mosConfig_absolute_path;
	if (! SITE_SAFE_MODE_ON) set_time_limit(6000);
	require_once( $mosConfig_absolute_path .'/includes/domit/xml_domit_include.php' );
	$query = "select * FROM #__rssfactory order by id ";
	$database->setQuery( $query );
	$objResponse = new xajaxResponse();

	$rows=$database->LoadObjectList();
	$nr=0;
	foreach($rows as $row){
		$nr_1=refresh_specific_RSS($row);
		$nr+=$nr_1;
		if($row->nrfeeds!=0)
    		$objResponse->addAssign("nr_feeds_$row->id","innerHTML",$nr_1);
    	else
    		$objResponse->addAssign("nr_feeds_$row->id","innerHTML",'All');
    }
	$msg=$nr.' Feeds added!';
	$objResponse->addScript	("HideProgress();alert('$msg!');");
	return $objResponse;
}
function InitializeXajax()
{
	global $mosConfig_live_site,$mosConfig_absolute_path;
	require_once ($mosConfig_absolute_path.'/administrator/components/com_rssfactory/xajax/xajax.inc.php');
    $xajax = new xajax($mosConfig_live_site.'/administrator/index2.php?option=com_rssfactory&jaxx=1');
	$xajax->registerExternalFunction ("jax_ClearCache",$mosConfig_absolute_path."/components/com_rssfactory/rssfactory.functions.php");
	$xajax->registerExternalFunction ("jax_RefreshFeed",$mosConfig_absolute_path."/components/com_rssfactory/rssfactory.functions.php");
	$xajax->registerExternalFunction ("jax_RefreshAllFeeds",$mosConfig_absolute_path."/components/com_rssfactory/rssfactory.functions.php");
	$xajax->registerExternalFunction ("jax_RefreshIcon",$mosConfig_absolute_path."/components/com_rssfactory/rssfactory.functions.php");

	return $xajax;
}
function CleanRss(&$rss){

   if (!preg_match("/<\?xml.*?encoding\s*=\s*[\"'](.*?)[\"'].*?\?>/is", $rss, $matches)) {
        if(preg_match("/<\?xml(\s).*?\?>/is", $rss, $matches)) {
            $rss = preg_replace("/<\?xml[\s](.*?)\?>/is", '<?xml $1 encoding="iso-8859-1"?>', $rss);
        }
    }


}
function change_encoding($data, $input, $output)
{
	$input =encoding($input);
	$output =encoding($output);

	if ($input==$output || $input=='' || $output=='') return $data;

	if (function_exists('iconv') && ($return = @iconv($input, "$output//IGNORE", $data)))
	{
		return $return;
	}
	elseif (function_exists('iconv') && ($return = @iconv($input, $output, $data)))
	{
		return $return;
	}
	elseif (function_exists('mb_convert_encoding') && ($return = @mb_convert_encoding($data, $output, $input)))
	{
		return $return;
	}
	elseif ($input == 'ISO-8859-1' && $output == 'UTF-8')
	{
		return utf8_encode($data);
	}
	elseif ($input == 'UTF-8' && $output == 'ISO-8859-1')
	{
		return utf8_decode($data);
	}
	return $data;
}
function encoding($encoding)
{
	// Character sets are case-insensitive (though we'll return them in the form given in their registration)
	switch (strtoupper($encoding))
	{
		case 'ANSI_X3.4-1968':
		case 'ISO-IR-6':
		case 'ANSI_X3.4-1986':
		case 'ISO_646.IRV:1991':
		case 'ASCII':
		case 'ISO646-US':
		case 'US-ASCII':
		case 'US':
		case 'IBM367':
		case 'CP367':
		case 'CSASCII':
			return 'US-ASCII';

		case 'ISO_8859-1:1987':
		case 'ISO-IR-100':
		case 'ISO_8859-1':
		case 'ISO-8859-1':
		case 'LATIN1':
		case 'L1':
		case 'IBM819':
		case 'CP819':
		case 'CSISOLATIN1':
			return 'ISO-8859-1';

		case 'ISO_8859-2:1987':
		case 'ISO-IR-101':
		case 'ISO_8859-2':
		case 'ISO-8859-2':
		case 'LATIN2':
		case 'L2':
		case 'CSISOLATIN2':
			return 'ISO-8859-2';

		case 'ISO_8859-3:1988':
		case 'ISO-IR-109':
		case 'ISO_8859-3':
		case 'ISO-8859-3':
		case 'LATIN3':
		case 'L3':
		case 'CSISOLATIN3':
			return 'ISO-8859-3';

		case 'ISO_8859-4:1988':
		case 'ISO-IR-110':
		case 'ISO_8859-4':
		case 'ISO-8859-4':
		case 'LATIN4':
		case 'L4':
		case 'CSISOLATIN4':
			return 'ISO-8859-4';

		case 'ISO_8859-5:1988':
		case 'ISO-IR-144':
		case 'ISO_8859-5':
		case 'ISO-8859-5':
		case 'CYRILLIC':
		case 'CSISOLATINCYRILLIC':
			return 'ISO-8859-5';

		case 'ISO_8859-6:1987':
		case 'ISO-IR-127':
		case 'ISO_8859-6':
		case 'ISO-8859-6':
		case 'ECMA-114':
		case 'ASMO-708':
		case 'ARABIC':
		case 'CSISOLATINARABIC':
			return 'ISO-8859-6';

		case 'ISO_8859-7:1987':
		case 'ISO-IR-126':
		case 'ISO_8859-7':
		case 'ISO-8859-7':
		case 'ELOT_928':
		case 'ECMA-118':
		case 'GREEK':
		case 'GREEK8':
		case 'CSISOLATINGREEK':
			return 'ISO-8859-7';

		case 'ISO_8859-8:1988':
		case 'ISO-IR-138':
		case 'ISO_8859-8':
		case 'ISO-8859-8':
		case 'HEBREW':
		case 'CSISOLATINHEBREW':
			return 'ISO-8859-8';

		case 'ISO_8859-9:1989':
		case 'ISO-IR-148':
		case 'ISO_8859-9':
		case 'ISO-8859-9':
		case 'LATIN5':
		case 'L5':
		case 'CSISOLATIN5':
			return 'ISO-8859-9';

		case 'ISO-8859-10':
		case 'ISO-IR-157':
		case 'L6':
		case 'ISO_8859-10:1992':
		case 'CSISOLATIN6':
		case 'LATIN6':
			return 'ISO-8859-10';

		case 'ISO_6937-2-ADD':
		case 'ISO-IR-142':
		case 'CSISOTEXTCOMM':
			return 'ISO_6937-2-add';

		case 'JIS_X0201':
		case 'X0201':
		case 'CSHALFWIDTHKATAKANA':
			return 'JIS_X0201';

		case 'JIS_ENCODING':
		case 'CSJISENCODING':
			return 'JIS_Encoding';

		case 'SHIFT_JIS':
		case 'MS_KANJI':
		case 'CSSHIFTJIS':
			return 'Shift_JIS';

		case 'EXTENDED_UNIX_CODE_PACKED_FORMAT_FOR_JAPANESE':
		case 'CSEUCPKDFMTJAPANESE':
		case 'EUC-JP':
			return 'EUC-JP';

		case 'EXTENDED_UNIX_CODE_FIXED_WIDTH_FOR_JAPANESE':
		case 'CSEUCFIXWIDJAPANESE':
			return 'Extended_UNIX_Code_Fixed_Width_for_Japanese';

		case 'BS_4730':
		case 'ISO-IR-4':
		case 'ISO646-GB':
		case 'GB':
		case 'UK':
		case 'CSISO4UNITEDKINGDOM':
			return 'BS_4730';

		case 'SEN_850200_C':
		case 'ISO-IR-11':
		case 'ISO646-SE2':
		case 'SE2':
		case 'CSISO11SWEDISHFORNAMES':
			return 'SEN_850200_C';

		case 'IT':
		case 'ISO-IR-15':
		case 'ISO646-IT':
		case 'CSISO15ITALIAN':
			return 'IT';

		case 'ES':
		case 'ISO-IR-17':
		case 'ISO646-ES':
		case 'CSISO17SPANISH':
			return 'ES';

		case 'DIN_66003':
		case 'ISO-IR-21':
		case 'DE':
		case 'ISO646-DE':
		case 'CSISO21GERMAN':
			return 'DIN_66003';

		case 'NS_4551-1':
		case 'ISO-IR-60':
		case 'ISO646-NO':
		case 'NO':
		case 'CSISO60DANISHNORWEGIAN':
		case 'CSISO60NORWEGIAN1':
			return 'NS_4551-1';

		case 'NF_Z_62-010':
		case 'ISO-IR-69':
		case 'ISO646-FR':
		case 'FR':
		case 'CSISO69FRENCH':
			return 'NF_Z_62-010';

		case 'ISO-10646-UTF-1':
		case 'CSISO10646UTF1':
			return 'ISO-10646-UTF-1';

		case 'ISO_646.BASIC:1983':
		case 'REF':
		case 'CSISO646BASIC1983':
			return 'ISO_646.basic:1983';

		case 'INVARIANT':
		case 'CSINVARIANT':
			return 'INVARIANT';

		case 'ISO_646.IRV:1983':
		case 'ISO-IR-2':
		case 'IRV':
		case 'CSISO2INTLREFVERSION':
			return 'ISO_646.irv:1983';

		case 'NATS-SEFI':
		case 'ISO-IR-8-1':
		case 'CSNATSSEFI':
			return 'NATS-SEFI';

		case 'NATS-SEFI-ADD':
		case 'ISO-IR-8-2':
		case 'CSNATSSEFIADD':
			return 'NATS-SEFI-ADD';

		case 'NATS-DANO':
		case 'ISO-IR-9-1':
		case 'CSNATSDANO':
			return 'NATS-DANO';

		case 'NATS-DANO-ADD':
		case 'ISO-IR-9-2':
		case 'CSNATSDANOADD':
			return 'NATS-DANO-ADD';

		case 'SEN_850200_B':
		case 'ISO-IR-10':
		case 'FI':
		case 'ISO646-FI':
		case 'ISO646-SE':
		case 'SE':
		case 'CSISO10SWEDISH':
			return 'SEN_850200_B';

		case 'KS_C_5601-1987':
		case 'ISO-IR-149':
		case 'KS_C_5601-1989':
		case 'KSC_5601':
		case 'KOREAN':
		case 'CSKSC56011987':
			return 'KS_C_5601-1987';

		case 'ISO-2022-KR':
		case 'CSISO2022KR':
			return 'ISO-2022-KR';

		case 'EUC-KR':
		case 'CSEUCKR':
			return 'EUC-KR';

		case 'ISO-2022-JP':
		case 'CSISO2022JP':
			return 'ISO-2022-JP';

		case 'ISO-2022-JP-2':
		case 'CSISO2022JP2':
			return 'ISO-2022-JP-2';

		case 'JIS_C6220-1969-JP':
		case 'JIS_C6220-1969':
		case 'ISO-IR-13':
		case 'KATAKANA':
		case 'X0201-7':
		case 'CSISO13JISC6220JP':
			return 'JIS_C6220-1969-jp';

		case 'JIS_C6220-1969-RO':
		case 'ISO-IR-14':
		case 'JP':
		case 'ISO646-JP':
		case 'CSISO14JISC6220RO':
			return 'JIS_C6220-1969-ro';

		case 'PT':
		case 'ISO-IR-16':
		case 'ISO646-PT':
		case 'CSISO16PORTUGUESE':
			return 'PT';

		case 'GREEK7-OLD':
		case 'ISO-IR-18':
		case 'CSISO18GREEK7OLD':
			return 'greek7-old';

		case 'LATIN-GREEK':
		case 'ISO-IR-19':
		case 'CSISO19LATINGREEK':
			return 'latin-greek';

		case 'NF_Z_62-010_(1973)':
		case 'ISO-IR-25':
		case 'ISO646-FR1':
		case 'CSISO25FRENCH':
			return 'NF_Z_62-010_(1973)';

		case 'LATIN-GREEK-1':
		case 'ISO-IR-27':
		case 'CSISO27LATINGREEK1':
			return 'Latin-greek-1';

		case 'ISO_5427':
		case 'ISO-IR-37':
		case 'CSISO5427CYRILLIC':
			return 'ISO_5427';

		case 'JIS_C6226-1978':
		case 'ISO-IR-42':
		case 'CSISO42JISC62261978':
			return 'JIS_C6226-1978';

		case 'BS_VIEWDATA':
		case 'ISO-IR-47':
		case 'CSISO47BSVIEWDATA':
			return 'BS_viewdata';

		case 'INIS':
		case 'ISO-IR-49':
		case 'CSISO49INIS':
			return 'INIS';

		case 'INIS-8':
		case 'ISO-IR-50':
		case 'CSISO50INIS8':
			return 'INIS-8';

		case 'INIS-CYRILLIC':
		case 'ISO-IR-51':
		case 'CSISO51INISCYRILLIC':
			return 'INIS-cyrillic';

		case 'ISO_5427:1981':
		case 'ISO-IR-54':
		case 'ISO5427CYRILLIC1981':
			return 'ISO_5427:1981';

		case 'ISO_5428:1980':
		case 'ISO-IR-55':
		case 'CSISO5428GREEK':
			return 'ISO_5428:1980';

		case 'GB_1988-80':
		case 'ISO-IR-57':
		case 'CN':
		case 'ISO646-CN':
		case 'CSISO57GB1988':
			return 'GB_1988-80';

		case 'GB_2312-80':
		case 'ISO-IR-58':
		case 'CHINESE':
		case 'CSISO58GB231280':
			return 'GB_2312-80';

		case 'NS_4551-2':
		case 'ISO646-NO2':
		case 'ISO-IR-61':
		case 'NO2':
		case 'CSISO61NORWEGIAN2':
			return 'NS_4551-2';

		case 'VIDEOTEX-SUPPL':
		case 'ISO-IR-70':
		case 'CSISO70VIDEOTEXSUPP1':
			return 'videotex-suppl';

		case 'PT2':
		case 'ISO-IR-84':
		case 'ISO646-PT2':
		case 'CSISO84PORTUGUESE2':
			return 'PT2';

		case 'ES2':
		case 'ISO-IR-85':
		case 'ISO646-ES2':
		case 'CSISO85SPANISH2':
			return 'ES2';

		case 'MSZ_7795.3':
		case 'ISO-IR-86':
		case 'ISO646-HU':
		case 'HU':
		case 'CSISO86HUNGARIAN':
			return 'MSZ_7795.3';

		case 'JIS_C6226-1983':
		case 'ISO-IR-87':
		case 'X0208':
		case 'JIS_X0208-1983':
		case 'CSISO87JISX0208':
			return 'JIS_C6226-1983';

		case 'GREEK7':
		case 'ISO-IR-88':
		case 'CSISO88GREEK7':
			return 'greek7';

		case 'ASMO_449':
		case 'ISO_9036':
		case 'ARABIC7':
		case 'ISO-IR-89':
		case 'CSISO89ASMO449':
			return 'ASMO_449';

		case 'ISO-IR-90':
		case 'CSISO90':
			return 'iso-ir-90';

		case 'JIS_C6229-1984-A':
		case 'ISO-IR-91':
		case 'JP-OCR-A':
		case 'CSISO91JISC62291984A':
			return 'JIS_C6229-1984-a';

		case 'JIS_C6229-1984-B':
		case 'ISO-IR-92':
		case 'ISO646-JP-OCR-B':
		case 'JP-OCR-B':
		case 'CSISO92JISC62991984B':
			return 'JIS_C6229-1984-b';

		case 'JIS_C6229-1984-B-ADD':
		case 'ISO-IR-93':
		case 'JP-OCR-B-ADD':
		case 'CSISO93JIS62291984BADD':
			return 'JIS_C6229-1984-b-add';

		case 'JIS_C6229-1984-HAND':
		case 'ISO-IR-94':
		case 'JP-OCR-HAND':
		case 'CSISO94JIS62291984HAND':
			return 'JIS_C6229-1984-hand';

		case 'JIS_C6229-1984-HAND-ADD':
		case 'ISO-IR-95':
		case 'JP-OCR-HAND-ADD':
		case 'CSISO95JIS62291984HANDADD':
			return 'JIS_C6229-1984-hand-add';

		case 'JIS_C6229-1984-KANA':
		case 'ISO-IR-96':
		case 'CSISO96JISC62291984KANA':
			return 'JIS_C6229-1984-kana';

		case 'ISO_2033-1983':
		case 'ISO-IR-98':
		case 'E13B':
		case 'CSISO2033':
			return 'ISO_2033-1983';

		case 'ANSI_X3.110-1983':
		case 'ISO-IR-99':
		case 'CSA_T500-1983':
		case 'NAPLPS':
		case 'CSISO99NAPLPS':
			return 'ANSI_X3.110-1983';

		case 'T.61-7BIT':
		case 'ISO-IR-102':
		case 'CSISO102T617BIT':
			return 'T.61-7bit';

		case 'T.61-8BIT':
		case 'T.61':
		case 'ISO-IR-103':
		case 'CSISO103T618BIT':
			return 'T.61-8bit';

		case 'ECMA-CYRILLIC':
		case 'ISO-IR-111':
		case 'KOI8-E':
		case 'CSISO111ECMACYRILLIC':
			return 'ECMA-cyrillic';

		case 'CSA_Z243.4-1985-1':
		case 'ISO-IR-121':
		case 'ISO646-CA':
		case 'CSA7-1':
		case 'CA':
		case 'CSISO121CANADIAN1':
			return 'CSA_Z243.4-1985-1';

		case 'CSA_Z243.4-1985-2':
		case 'ISO-IR-122':
		case 'ISO646-CA2':
		case 'CSA7-2':
		case 'CSISO122CANADIAN2':
			return 'CSA_Z243.4-1985-2';

		case 'CSA_Z243.4-1985-GR':
		case 'ISO-IR-123':
		case 'CSISO123CSAZ24341985GR':
			return 'CSA_Z243.4-1985-gr';

		case 'ISO_8859-6-E':
		case 'CSISO88596E':
		case 'ISO-8859-6-E':
			return 'ISO-8859-6-E';

		case 'ISO_8859-6-I':
		case 'CSISO88596I':
		case 'ISO-8859-6-I':
			return 'ISO-8859-6-I';

		case 'T.101-G2':
		case 'ISO-IR-128':
		case 'CSISO128T101G2':
			return 'T.101-G2';

		case 'ISO_8859-8-E':
		case 'CSISO88598E':
		case 'ISO-8859-8-E':
			return 'ISO-8859-8-E';

		case 'ISO_8859-8-I':
		case 'CSISO88598I':
		case 'ISO-8859-8-I':
			return 'ISO-8859-8-I';

		case 'CSN_369103':
		case 'ISO-IR-139':
		case 'CSISO139CSN369103':
			return 'CSN_369103';

		case 'JUS_I.B1.002':
		case 'ISO-IR-141':
		case 'ISO646-YU':
		case 'JS':
		case 'YU':
		case 'CSISO141JUSIB1002':
			return 'JUS_I.B1.002';

		case 'IEC_P27-1':
		case 'ISO-IR-143':
		case 'CSISO143IECP271':
			return 'IEC_P27-1';

		case 'JUS_I.B1.003-SERB':
		case 'ISO-IR-146':
		case 'SERBIAN':
		case 'CSISO146SERBIAN':
			return 'JUS_I.B1.003-serb';

		case 'JUS_I.B1.003-MAC':
		case 'MACEDONIAN':
		case 'ISO-IR-147':
		case 'CSISO147MACEDONIAN':
			return 'JUS_I.B1.003-mac';

		case 'GREEK-CCITT':
		case 'ISO-IR-150':
		case 'CSISO150':
		case 'CSISO150GREEKCCITT':
			return 'greek-ccitt';

		case 'NC_NC00-10:81':
		case 'CUBA':
		case 'ISO-IR-151':
		case 'ISO646-CU':
		case 'CSISO151CUBA':
			return 'NC_NC00-10:81';

		case 'ISO_6937-2-25':
		case 'ISO-IR-152':
		case 'CSISO6937ADD':
			return 'ISO_6937-2-25';

		case 'GOST_19768-74':
		case 'ST_SEV_358-88':
		case 'ISO-IR-153':
		case 'CSISO153GOST1976874':
			return 'GOST_19768-74';

		case 'ISO_8859-SUPP':
		case 'ISO-IR-154':
		case 'LATIN1-2-5':
		case 'CSISO8859SUPP':
			return 'ISO_8859-supp';

		case 'ISO_10367-BOX':
		case 'ISO-IR-155':
		case 'CSISO10367BOX':
			return 'ISO_10367-box';

		case 'LATIN-LAP':
		case 'LAP':
		case 'ISO-IR-158':
		case 'CSISO158LAP':
			return 'latin-lap';

		case 'JIS_X0212-1990':
		case 'X0212':
		case 'ISO-IR-159':
		case 'CSISO159JISX02121990':
			return 'JIS_X0212-1990';

		case 'DS_2089':
		case 'DS2089':
		case 'ISO646-DK':
		case 'DK':
		case 'CSISO646DANISH':
			return 'DS_2089';

		case 'US-DK':
		case 'CSUSDK':
			return 'us-dk';

		case 'DK-US':
		case 'CSDKUS':
			return 'dk-us';

		case 'KSC5636':
		case 'ISO646-KR':
		case 'CSKSC5636':
			return 'KSC5636';

		case 'UNICODE-1-1-UTF-7':
		case 'CSUNICODE11UTF7':
			return 'UNICODE-1-1-UTF-7';

		case 'ISO-2022-CN':
			return 'ISO-2022-CN';

		case 'ISO-2022-CN-EXT':
			return 'ISO-2022-CN-EXT';

		case 'UTF-8':
			return 'UTF-8';

		case 'ISO-8859-13':
			return 'ISO-8859-13';

		case 'ISO-8859-14':
		case 'ISO-IR-199':
		case 'ISO_8859-14:1998':
		case 'ISO_8859-14':
		case 'LATIN8':
		case 'ISO-CELTIC':
		case 'L8':
			return 'ISO-8859-14';

		case 'ISO-8859-15':
		case 'ISO_8859-15':
		case 'LATIN-9':
			return 'ISO-8859-15';

		case 'ISO-8859-16':
		case 'ISO-IR-226':
		case 'ISO_8859-16:2001':
		case 'ISO_8859-16':
		case 'LATIN10':
		case 'L10':
			return 'ISO-8859-16';

		case 'GBK':
		case 'CP936':
		case 'MS936':
		case 'WINDOWS-936':
			return 'GBK';

		case 'GB18030':
			return 'GB18030';

		case 'OSD_EBCDIC_DF04_15':
			return 'OSD_EBCDIC_DF04_15';

		case 'OSD_EBCDIC_DF03_IRV':
			return 'OSD_EBCDIC_DF03_IRV';

		case 'OSD_EBCDIC_DF04_1':
			return 'OSD_EBCDIC_DF04_1';

		case 'ISO-11548-1':
		case 'ISO_11548-1':
		case 'ISO_TR_11548-1':
		case 'CSISO115481':
			return 'ISO-11548-1';

		case 'KZ-1048':
		case 'STRK1048-2002':
		case 'RK1048':
		case 'CSKZ1048':
			return 'KZ-1048';

		case 'ISO-10646-UCS-2':
		case 'CSUNICODE':
			return 'ISO-10646-UCS-2';

		case 'ISO-10646-UCS-4':
		case 'CSUCS4':
			return 'ISO-10646-UCS-4';

		case 'ISO-10646-UCS-BASIC':
		case 'CSUNICODEASCII':
			return 'ISO-10646-UCS-Basic';

		case 'ISO-10646-UNICODE-LATIN1':
		case 'CSUNICODELATIN1':
		case 'ISO-10646':
			return 'ISO-10646-Unicode-Latin1';

		case 'ISO-10646-J-1':
			return 'ISO-10646-J-1';

		case 'ISO-UNICODE-IBM-1261':
		case 'CSUNICODEIBM1261':
			return 'ISO-Unicode-IBM-1261';

		case 'ISO-UNICODE-IBM-1268':
		case 'CSUNICODEIBM1268':
			return 'ISO-Unicode-IBM-1268';

		case 'ISO-UNICODE-IBM-1276':
		case 'CSUNICODEIBM1276':
			return 'ISO-Unicode-IBM-1276';

		case 'ISO-UNICODE-IBM-1264':
		case 'CSUNICODEIBM1264':
			return 'ISO-Unicode-IBM-1264';

		case 'ISO-UNICODE-IBM-1265':
		case 'CSUNICODEIBM1265':
			return 'ISO-Unicode-IBM-1265';

		case 'UNICODE-1-1':
		case 'CSUNICODE11':
			return 'UNICODE-1-1';

		case 'SCSU':
			return 'SCSU';

		case 'UTF-7':
			return 'UTF-7';

		case 'UTF-16BE':
			return 'UTF-16BE';

		case 'UTF-16LE':
			return 'UTF-16LE';

		case 'UTF-16':
			return 'UTF-16';

		case 'CESU-8':
		case 'CSCESU-8':
			return 'CESU-8';

		case 'UTF-32':
			return 'UTF-32';

		case 'UTF-32BE':
			return 'UTF-32BE';

		case 'UTF-32LE':
			return 'UTF-32LE';

		case 'BOCU-1':
		case 'CSBOCU-1':
			return 'BOCU-1';

		case 'ISO-8859-1-WINDOWS-3.0-LATIN-1':
		case 'CSWINDOWS30LATIN1':
			return 'ISO-8859-1-Windows-3.0-Latin-1';

		case 'ISO-8859-1-WINDOWS-3.1-LATIN-1':
		case 'CSWINDOWS31LATIN1':
			return 'ISO-8859-1-Windows-3.1-Latin-1';

		case 'ISO-8859-2-WINDOWS-LATIN-2':
		case 'CSWINDOWS31LATIN2':
			return 'ISO-8859-2-Windows-Latin-2';

		case 'ISO-8859-9-WINDOWS-LATIN-5':
		case 'CSWINDOWS31LATIN5':
			return 'ISO-8859-9-Windows-Latin-5';

		case 'HP-ROMAN8':
		case 'ROMAN8':
		case 'R8':
		case 'CSHPROMAN8':
			return 'hp-roman8';

		case 'ADOBE-STANDARD-ENCODING':
		case 'CSADOBESTANDARDENCODING':
			return 'Adobe-Standard-Encoding';

		case 'VENTURA-US':
		case 'CSVENTURAUS':
			return 'Ventura-US';

		case 'VENTURA-INTERNATIONAL':
		case 'CSVENTURAINTERNATIONAL':
			return 'Ventura-International';

		case 'DEC-MCS':
		case 'DEC':
		case 'CSDECMCS':
			return 'DEC-MCS';

		case 'IBM850':
		case 'CP850':
		case '850':
		case 'CSPC850MULTILINGUAL':
			return 'IBM850';

		case 'PC8-DANISH-NORWEGIAN':
		case 'CSPC8DANISHNORWEGIAN':
			return 'PC8-Danish-Norwegian';

		case 'IBM862':
		case 'CP862':
		case '862':
		case 'CSPC862LATINHEBREW':
			return 'IBM862';

		case 'PC8-TURKISH':
		case 'CSPC8TURKISH':
			return 'PC8-Turkish';

		case 'IBM-SYMBOLS':
		case 'CSIBMSYMBOLS':
			return 'IBM-Symbols';

		case 'IBM-THAI':
		case 'CSIBMTHAI':
			return 'IBM-Thai';

		case 'HP-LEGAL':
		case 'CSHPLEGAL':
			return 'HP-Legal';

		case 'HP-PI-FONT':
		case 'CSHPPIFONT':
			return 'HP-Pi-font';

		case 'HP-MATH8':
		case 'CSHPMATH8':
			return 'HP-Math8';

		case 'ADOBE-SYMBOL-ENCODING':
		case 'CSHPPSMATH':
			return 'Adobe-Symbol-Encoding';

		case 'HP-DESKTOP':
		case 'CSHPDESKTOP':
			return 'HP-DeskTop';

		case 'VENTURA-MATH':
		case 'CSVENTURAMATH':
			return 'Ventura-Math';

		case 'MICROSOFT-PUBLISHING':
		case 'CSMICROSOFTPUBLISHING':
			return 'Microsoft-Publishing';

		case 'WINDOWS-31J':
		case 'CSWINDOWS31J':
			return 'Windows-31J';

		case 'GB2312':
		case 'CSGB2312':
			return 'GB2312';

		case 'BIG5':
		case 'CSBIG5':
			return 'Big5';

		case 'MACINTOSH':
		case 'MAC':
		case 'CSMACINTOSH':
			return 'macintosh';

		case 'IBM037':
		case 'CP037':
		case 'EBCDIC-CP-US':
		case 'EBCDIC-CP-CA':
		case 'EBCDIC-CP-WT':
		case 'EBCDIC-CP-NL':
		case 'CSIBM037':
			return 'IBM037';

		case 'IBM038':
		case 'EBCDIC-INT':
		case 'CP038':
		case 'CSIBM038':
			return 'IBM038';

		case 'IBM273':
		case 'CP273':
		case 'CSIBM273':
			return 'IBM273';

		case 'IBM274':
		case 'EBCDIC-BE':
		case 'CP274':
		case 'CSIBM274':
			return 'IBM274';

		case 'IBM275':
		case 'EBCDIC-BR':
		case 'CP275':
		case 'CSIBM275':
			return 'IBM275';

		case 'IBM277':
		case 'EBCDIC-CP-DK':
		case 'EBCDIC-CP-NO':
		case 'CSIBM277':
			return 'IBM277';

		case 'IBM278':
		case 'CP278':
		case 'EBCDIC-CP-FI':
		case 'EBCDIC-CP-SE':
		case 'CSIBM278':
			return 'IBM278';

		case 'IBM280':
		case 'CP280':
		case 'EBCDIC-CP-IT':
		case 'CSIBM280':
			return 'IBM280';

		case 'IBM281':
		case 'EBCDIC-JP-E':
		case 'CP281':
		case 'CSIBM281':
			return 'IBM281';

		case 'IBM284':
		case 'CP284':
		case 'EBCDIC-CP-ES':
		case 'CSIBM284':
			return 'IBM284';

		case 'IBM285':
		case 'CP285':
		case 'EBCDIC-CP-GB':
		case 'CSIBM285':
			return 'IBM285';

		case 'IBM290':
		case 'CP290':
		case 'EBCDIC-JP-KANA':
		case 'CSIBM290':
			return 'IBM290';

		case 'IBM297':
		case 'CP297':
		case 'EBCDIC-CP-FR':
		case 'CSIBM297':
			return 'IBM297';

		case 'IBM420':
		case 'CP420':
		case 'EBCDIC-CP-AR1':
		case 'CSIBM420':
			return 'IBM420';

		case 'IBM423':
		case 'CP423':
		case 'EBCDIC-CP-GR':
		case 'CSIBM423':
			return 'IBM423';

		case 'IBM424':
		case 'CP424':
		case 'EBCDIC-CP-HE':
		case 'CSIBM424':
			return 'IBM424';

		case 'IBM437':
		case 'CP437':
		case '437':
		case 'CSPC8CODEPAGE437':
			return 'IBM437';

		case 'IBM500':
		case 'CP500':
		case 'EBCDIC-CP-BE':
		case 'EBCDIC-CP-CH':
		case 'CSIBM500':
			return 'IBM500';

		case 'IBM851':
		case 'CP851':
		case '851':
		case 'CSIBM851':
			return 'IBM851';

		case 'IBM852':
		case 'CP852':
		case '852':
		case 'CSPCP852':
			return 'IBM852';

		case 'IBM855':
		case 'CP855':
		case '855':
		case 'CSIBM855':
			return 'IBM855';

		case 'IBM857':
		case 'CP857':
		case '857':
		case 'CSIBM857':
			return 'IBM857';

		case 'IBM860':
		case 'CP860':
		case '860':
		case 'CSIBM860':
			return 'IBM860';

		case 'IBM861':
		case 'CP861':
		case '861':
		case 'CP-IS':
		case 'CSIBM861':
			return 'IBM861';

		case 'IBM863':
		case 'CP863':
		case '863':
		case 'CSIBM863':
			return 'IBM863';

		case 'IBM864':
		case 'CP864':
		case 'CSIBM864':
			return 'IBM864';

		case 'IBM865':
		case 'CP865':
		case '865':
		case 'CSIBM865':
			return 'IBM865';

		case 'IBM868':
		case 'CP868':
		case 'CP-AR':
		case 'CSIBM868':
			return 'IBM868';

		case 'IBM869':
		case 'CP869':
		case '869':
		case 'CP-GR':
		case 'CSIBM869':
			return 'IBM869';

		case 'IBM870':
		case 'CP870':
		case 'EBCDIC-CP-ROECE':
		case 'EBCDIC-CP-YU':
		case 'CSIBM870':
			return 'IBM870';

		case 'IBM871':
		case 'CP871':
		case 'EBCDIC-CP-IS':
		case 'CSIBM871':
			return 'IBM871';

		case 'IBM880':
		case 'CP880':
		case 'EBCDIC-CYRILLIC':
		case 'CSIBM880':
			return 'IBM880';

		case 'IBM891':
		case 'CP891':
		case 'CSIBM891':
			return 'IBM891';

		case 'IBM903':
		case 'CP903':
		case 'CSIBM903':
			return 'IBM903';

		case 'IBM904':
		case 'CP904':
		case '904':
		case 'CSIBBM904':
			return 'IBM904';

		case 'IBM905':
		case 'CP905':
		case 'EBCDIC-CP-TR':
		case 'CSIBM905':
			return 'IBM905';

		case 'IBM918':
		case 'CP918':
		case 'EBCDIC-CP-AR2':
		case 'CSIBM918':
			return 'IBM918';

		case 'IBM1026':
		case 'CP1026':
		case 'CSIBM1026':
			return 'IBM1026';

		case 'EBCDIC-AT-DE':
		case 'CSIBMEBCDICATDE':
			return 'EBCDIC-AT-DE';

		case 'EBCDIC-AT-DE-A':
		case 'CSEBCDICATDEA':
			return 'EBCDIC-AT-DE-A';

		case 'EBCDIC-CA-FR':
		case 'CSEBCDICCAFR':
			return 'EBCDIC-CA-FR';

		case 'EBCDIC-DK-NO':
		case 'CSEBCDICDKNO':
			return 'EBCDIC-DK-NO';

		case 'EBCDIC-DK-NO-A':
		case 'CSEBCDICDKNOA':
			return 'EBCDIC-DK-NO-A';

		case 'EBCDIC-FI-SE':
		case 'CSEBCDICFISE':
			return 'EBCDIC-FI-SE';

		case 'EBCDIC-FI-SE-A':
		case 'CSEBCDICFISEA':
			return 'EBCDIC-FI-SE-A';

		case 'EBCDIC-FR':
		case 'CSEBCDICFR':
			return 'EBCDIC-FR';

		case 'EBCDIC-IT':
		case 'CSEBCDICIT':
			return 'EBCDIC-IT';

		case 'EBCDIC-PT':
		case 'CSEBCDICPT':
			return 'EBCDIC-PT';

		case 'EBCDIC-ES':
		case 'CSEBCDICES':
			return 'EBCDIC-ES';

		case 'EBCDIC-ES-A':
		case 'CSEBCDICESA':
			return 'EBCDIC-ES-A';

		case 'EBCDIC-ES-S':
		case 'CSEBCDICESS':
			return 'EBCDIC-ES-S';

		case 'EBCDIC-UK':
		case 'CSEBCDICUK':
			return 'EBCDIC-UK';

		case 'EBCDIC-US':
		case 'CSEBCDICUS':
			return 'EBCDIC-US';

		case 'UNKNOWN-8BIT':
		case 'CSUNKNOWN8BIT':
			return 'UNKNOWN-8BIT';

		case 'MNEMONIC':
		case 'CSMNEMONIC':
			return 'MNEMONIC';

		case 'MNEM':
		case 'CSMNEM':
			return 'MNEM';

		case 'VISCII':
		case 'CSVISCII':
			return 'VISCII';

		case 'VIQR':
		case 'CSVIQR':
			return 'VIQR';

		case 'KOI8-R':
		case 'CSKOI8R':
			return 'KOI8-R';

		case 'HZ-GB-2312':
			return 'HZ-GB-2312';

		case 'IBM866':
		case 'CP866':
		case '866':
		case 'CSIBM866':
			return 'IBM866';

		case 'IBM775':
		case 'CP775':
		case 'CSPC775BALTIC':
			return 'IBM775';

		case 'KOI8-U':
			return 'KOI8-U';

		case 'IBM00858':
		case 'CCSID00858':
		case 'CP00858':
		case 'PC-MULTILINGUAL-850+EURO':
			return 'IBM00858';

		case 'IBM00924':
		case 'CCSID00924':
		case 'CP00924':
		case 'EBCDIC-LATIN9--EURO':
			return 'IBM00924';

		case 'IBM01140':
		case 'CCSID01140':
		case 'CP01140':
		case 'EBCDIC-US-37+EURO':
			return 'IBM01140';

		case 'IBM01141':
		case 'CCSID01141':
		case 'CP01141':
		case 'EBCDIC-DE-273+EURO':
			return 'IBM01141';

		case 'IBM01142':
		case 'CCSID01142':
		case 'CP01142':
		case 'EBCDIC-DK-277+EURO':
		case 'EBCDIC-NO-277+EURO':
			return 'IBM01142';

		case 'IBM01143':
		case 'CCSID01143':
		case 'CP01143':
		case 'EBCDIC-FI-278+EURO':
		case 'EBCDIC-SE-278+EURO':
			return 'IBM01143';

		case 'IBM01144':
		case 'CCSID01144':
		case 'CP01144':
		case 'EBCDIC-IT-280+EURO':
			return 'IBM01144';

		case 'IBM01145':
		case 'CCSID01145':
		case 'CP01145':
		case 'EBCDIC-ES-284+EURO':
			return 'IBM01145';

		case 'IBM01146':
		case 'CCSID01146':
		case 'CP01146':
		case 'EBCDIC-GB-285+EURO':
			return 'IBM01146';

		case 'IBM01147':
		case 'CCSID01147':
		case 'CP01147':
		case 'EBCDIC-FR-297+EURO':
			return 'IBM01147';

		case 'IBM01148':
		case 'CCSID01148':
		case 'CP01148':
		case 'EBCDIC-INTERNATIONAL-500+EURO':
			return 'IBM01148';

		case 'IBM01149':
		case 'CCSID01149':
		case 'CP01149':
		case 'EBCDIC-IS-871+EURO':
			return 'IBM01149';

		case 'BIG5-HKSCS':
			return 'Big5-HKSCS';

		case 'IBM1047':
		case 'IBM-1047':
			return 'IBM1047';

		case 'PTCP154':
		case 'CSPTCP154':
		case 'PT154':
		case 'CP154':
		case 'CYRILLIC-ASIAN':
			return 'PTCP154';

		case 'AMIGA-1251':
		case 'AMI1251':
		case 'AMIGA1251':
		case 'AMI-1251':
			return 'Amiga-1251';

		case 'KOI7-SWITCHED':
			return 'KOI7-switched';

		case 'BRF':
		case 'CSBRF':
			return 'BRF';

		case 'TSCII':
		case 'CSTSCII':
			return 'TSCII';

		case 'WINDOWS-1250':
			return 'windows-1250';

		case 'WINDOWS-1251':
			return 'windows-1251';

		case 'WINDOWS-1252':
			return 'windows-1252';

		case 'WINDOWS-1253':
			return 'windows-1253';

		case 'WINDOWS-1254':
			return 'windows-1254';

		case 'WINDOWS-1255':
			return 'windows-1255';

		case 'WINDOWS-1256':
			return 'windows-1256';

		case 'WINDOWS-1257':
			return 'windows-1257';

		case 'WINDOWS-1258':
			return 'windows-1258';

		default:
			return (string) $encoding;
	}
}
?>