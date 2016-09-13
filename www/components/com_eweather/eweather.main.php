<?php
/**
* @version $Id: eweather.main.php,v 1.1.0 2006/04/30 10:00:00 stingrey Exp $
* @package eWeather
* @subpackage eWeather
* @copyright (C) 2000 - 2006 MamboBaer.de (Harald Baer)
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* eWeather is Free Software
*/

/** ensure this file is being included by a parent file */
defined('_VALID_MOS') or die('Direct Access to this location is not allowed.');

function parseWeather(){
  global $mosConfig_absolute_path, $database, $weatherTitle, $weatherShowFooter, $weatherClass, $weatherDayClass,
         $weatherIconsStyle, $weatherShowForecast, $weatherPartnerID, $weatherPassword, $weatherDefaultLocationID,
         $weatherUnits, $weatherDayForecast, $weatherLongDateFormat, $weatherTimeFormat, $detail_view, $weatherCacheTime,
         $weatherShortDateFormat, $weatherUseProxy, $weatherProxyHost, $weatherProxyPort, $weatherUseProxyAuth,
         $weatherProxyAuthUser, $weatherProxyAuthPwd, $my;

  require_once( $mosConfig_absolute_path.'/includes/domit/xml_domit_include.php' );

  if ($my->id <> 0) {
     $database -> setQuery("SELECT * FROM #__eweather_profiles WHERE `uid` = '".$my->id."'");
     $userProfiles = $database -> loadObjectList();
     if (count($userProfiles) <> 0) {
        $weatherDefaultLocationID = $userProfiles[0]->locid;
     }
  }

  $newCacheTime = time() - $weatherCacheTime;
  $database -> setQuery("SELECT * FROM #__eweather_cache WHERE `locid` = '".$weatherDefaultLocationID."'");
  $rows = $database -> loadObjectList();
  $cacheCount = count($rows);

  $xmlDoc =& new DOMIT_Document();
  if ($weatherUseProxy == "1"){
     $xmlDoc->setProxyConnection($weatherProxyHost, '/', $weatherProxyPort);
     if ($weatherUseProxyAuth == "1"){
        $xmlDoc->setProxyAuthorization($weatherProxyAuthUser, $weatherProxyAuthPwd);
     }
  }

  $xmlDoc->resolveErrors(true);
  $weatherClass = & new weather_global();

  if ($cacheCount != 0) {
    $cacheID = $rows[0]->id;
    if ($rows[0]->lastupdate < $newCacheTime) {
        $weather_url = "http://xoap.weather.com/weather/local/".$weatherDefaultLocationID."?cc=*&dayf=".$weatherDayForecast."&unit=".$weatherUnits."&par=".$weatherPartnerID."&key=".$weatherPassword;

        $success = $xmlDoc->loadXML($weather_url, true);
        if (!$success) {
           $weatherClass->e_error = "Error number ".$xmlDoc->getErrorCode().": ".$xmlDoc->getErrorString();
           return $weatherClass;
        } else {
           $newFeed = $xmlDoc->toString(false);
           $id=(int)$rows[0]->id;
           $sql = "UPDATE #__eweather_cache SET `lastupdate` = '".time()."',`feed` = '$newFeed' WHERE `id` = '$id'";
        }

    } else {
        $success = $xmlDoc->parseXML($rows[0]->feed, true);
    }
  } else {
      $weather_url = "http://xoap.weather.com/weather/local/".$weatherDefaultLocationID."?cc=*&dayf=".$weatherDayForecast."&unit=".$weatherUnits."&par=".$weatherPartnerID."&key=".$weatherPassword;
      $success = $xmlDoc->loadXML($weather_url, true);
      if (!$success) {
         $weatherClass->e_error = "Error number ".$xmlDoc->getErrorCode().": ".$xmlDoc->getErrorString();
         return $weatherClass;
      } else {
         $newFeed = $xmlDoc->toString(false);
         $sql = "INSERT INTO #__eweather_cache ( `id` , `lastupdate` , `locid` , `feed` ) VALUES ('','".time()."', '$weatherDefaultLocationID', '$newFeed');";
      }
  }

  $element = &$xmlDoc->documentElement;
  $numChannels = count($xmlDoc->documentElement->childNodes);
  $weatherClass->n_channels = count($xmlDoc->documentElement->childNodes);

  if ($element->getTagName() == 'weather'){
     $nodeCount = count($xmlDoc->documentElement->childNodes);
     for ($i = 0; $i < $nodeCount; $i++) {
         $currentNode =& $xmlDoc->documentElement->childNodes[$i];
         switch($currentNode->nodeName){
           case 'head':
                 $headNode = $currentNode;
                 $headNodeCount = count($headNode->childNodes);
                 for ($x = 0; $x < $headNodeCount; $x++) {
                     if ($headNode->childNodes[$x]->nodeName == "ut") $weatherClass->h_temp = $headNode->childNodes[$x]->firstChild->nodeValue;
                     if ($headNode->childNodes[$x]->nodeName == "ud") $weatherClass->h_distance = $headNode->childNodes[$x]->firstChild->nodeValue;
                     if ($headNode->childNodes[$x]->nodeName == "us") $weatherClass->h_speed = $headNode->childNodes[$x]->firstChild->nodeValue;
                     if ($headNode->childNodes[$x]->nodeName == "ur") $weatherClass->h_precipitation = $headNode->childNodes[$x]->firstChild->nodeValue;
                     if ($headNode->childNodes[$x]->nodeName == "up") $weatherClass->h_pressure = $headNode->childNodes[$x]->firstChild->nodeValue;
                 }
                 break;
           case 'loc':
                 $locNode = $currentNode;
                 $weatherClass->loc_code = $locNode->getAttribute('id');
                 $locNodeCount = count($locNode->childNodes);
                 for ($x = 0; $x < $locNodeCount; $x++) {
                     if ($locNode->childNodes[$x]->nodeName == "dnam") $weatherClass->loc_city = $locNode->childNodes[$x]->firstChild->nodeValue;
                     if ($locNode->childNodes[$x]->nodeName == "tm") $weatherClass->loc_localtime = $locNode->childNodes[$x]->firstChild->nodeValue;
                     if ($locNode->childNodes[$x]->nodeName == "lat") $weatherClass->loc_latitude = $locNode->childNodes[$x]->firstChild->nodeValue;
                     if ($locNode->childNodes[$x]->nodeName == "lon") $weatherClass->loc_longitude = $locNode->childNodes[$x]->firstChild->nodeValue;
                     if ($locNode->childNodes[$x]->nodeName == "sunr"){
                        $weatherClass->loc_sunrise = strftime($weatherTimeFormat, strtotime($locNode->childNodes[$x]->firstChild->nodeValue));
                     }
                     if ($locNode->childNodes[$x]->nodeName == "suns"){
                        $weatherClass->loc_sunset = strftime($weatherTimeFormat, strtotime($locNode->childNodes[$x]->firstChild->nodeValue));
                     }
                     if ($locNode->childNodes[$x]->nodeName == "zone") $weatherClass->loc_timezone = $locNode->childNodes[$x]->firstChild->nodeValue;
                 }
                 break;
           case 'cc':
                 $ccNode = $currentNode;
                 $ccNodeCount = count($ccNode->childNodes);
                 for ($x = 0; $x < $ccNodeCount; $x++) {
                     if ($ccNode->childNodes[$x]->nodeName == "bar") {
                       $ccNodeCount_x = 0;
                       $ccNodeCount_x = count($ccNode->childNodes[$x]->childNodes);
                       for ($y = 0; $y < $ccNodeCount_x; $y++) {
                         if ($ccNode->childNodes[$x]->childNodes[$y]->nodeName == "r") $weatherClass->cc_barpressure = $ccNode->childNodes[$x]->childNodes[$y]->firstChild->nodeValue;
                         if ($ccNode->childNodes[$x]->childNodes[$y]->nodeName == "d") $weatherClass->cc_bartext = $ccNode->childNodes[$x]->childNodes[$y]->firstChild->nodeValue;
                       }
                     } elseif ($ccNode->childNodes[$x]->nodeName == "uv") {
                       $ccNodeCount_x = 0;
                       $ccNodeCount_x = count($ccNode->childNodes[$x]->childNodes);
                       for ($y = 0; $y < $ccNodeCount_x; $y++) {
                         if ($ccNode->childNodes[$x]->childNodes[$y]->nodeName == "i") $weatherClass->cc_uvindex = $ccNode->childNodes[$x]->childNodes[$y]->firstChild->nodeValue;
                         if ($ccNode->childNodes[$x]->childNodes[$y]->nodeName == "t") $weatherClass->cc_uvtext = $ccNode->childNodes[$x]->childNodes[$y]->firstChild->nodeValue;
                       }
                     } elseif ($ccNode->childNodes[$x]->nodeName == "moon") {
                       $ccNodeCount_x = 0;
                       $ccNodeCount_x = count($ccNode->childNodes[$x]->childNodes);
                       for ($y = 0; $y < $ccNodeCount_x; $y++) {
                         if ($ccNode->childNodes[$x]->childNodes[$y]->nodeName == "icon") $weatherClass->cc_moonicon = $ccNode->childNodes[$x]->childNodes[$y]->firstChild->nodeValue;
                         if ($ccNode->childNodes[$x]->childNodes[$y]->nodeName == "t") $weatherClass->cc_moontext = $ccNode->childNodes[$x]->childNodes[$y]->firstChild->nodeValue;
                       }
                     } elseif ($ccNode->childNodes[$x]->nodeName == "wind") {
                       $ccNodeCount_x = 0;
                       $ccNodeCount_x = count($ccNode->childNodes[$x]->childNodes);
                       for ($y = 0; $y < $ccNodeCount_x; $y++) {
                         if ($ccNode->childNodes[$x]->childNodes[$y]->nodeName == "s") $weatherClass->cc_windspeed = $ccNode->childNodes[$x]->childNodes[$y]->firstChild->nodeValue;
                         if ($ccNode->childNodes[$x]->childNodes[$y]->nodeName == "gust") $weatherClass->cc_windgust = $ccNode->childNodes[$x]->childNodes[$y]->firstChild->nodeValue;
                         if ($ccNode->childNodes[$x]->childNodes[$y]->nodeName == "d") $weatherClass->cc_winddirection = $ccNode->childNodes[$x]->childNodes[$y]->firstChild->nodeValue;
                         if ($ccNode->childNodes[$x]->childNodes[$y]->nodeName == "t") $weatherClass->cc_windtext = $ccNode->childNodes[$x]->childNodes[$y]->firstChild->nodeValue;
                       }
                     } else {
                       if ($ccNode->childNodes[$x]->nodeName == "lsup") {
                          $weatherClass->cc_lastupdate = strftime($weatherLongDateFormat, strtotime(ereg_replace(" Local Time", "", $ccNode->childNodes[$x]->firstChild->nodeValue)));
                       }
                       if ($ccNode->childNodes[$x]->nodeName == "obst") $weatherClass->cc_observatory = $ccNode->childNodes[$x]->firstChild->nodeValue;
                       if ($ccNode->childNodes[$x]->nodeName == "tmp") $weatherClass->cc_temp = $ccNode->childNodes[$x]->firstChild->nodeValue;
                       if ($ccNode->childNodes[$x]->nodeName == "flik") $weatherClass->cc_windchill = $ccNode->childNodes[$x]->firstChild->nodeValue;
                       if ($ccNode->childNodes[$x]->nodeName == "t") $weatherClass->cc_text = $ccNode->childNodes[$x]->firstChild->nodeValue;
                       if ($ccNode->childNodes[$x]->nodeName == "icon") $weatherClass->cc_icon = $ccNode->childNodes[$x]->firstChild->nodeValue;
                       if ($ccNode->childNodes[$x]->nodeName == "hmid") $weatherClass->cc_humidity = $ccNode->childNodes[$x]->firstChild->nodeValue;
                       if ($ccNode->childNodes[$x]->nodeName == "vis") $weatherClass->cc_visibility = $ccNode->childNodes[$x]->firstChild->nodeValue;
                       if ($ccNode->childNodes[$x]->nodeName == "dewp") $weatherClass->cc_dewp = $ccNode->childNodes[$x]->firstChild->nodeValue;
                     }
                 }
                 break;
           case 'dayf':
                 $dayfNode = $currentNode;
                 $dayfNodeCount = count($dayfNode->childNodes);
                 for ($x = 0; $x < $dayfNodeCount; $x++) {
                     if ($dayfNode->childNodes[$x]->nodeName == "lsup") {
                        $weatherClass->dayf_lastupdate = strftime ($weatherLongDateFormat, strtotime (ereg_replace("Local Time", "", $dayfNode->childNodes[$x]->firstChild->nodeValue)));
                     }
                     if ($dayfNode->childNodes[$x]->nodeName == "day") {
                         $weatherDayClass =& new weather_day();
                         $weatherDayClass->day_num = $dayfNode->childNodes[$x]->getAttribute('d');
                         $weatherDayClass->day_weekday = $dayfNode->childNodes[$x]->getAttribute('t');
                         $weatherDayClass->day_date = $dayfNode->childNodes[$x]->getAttribute('dt');
                         $dayCount = count($dayfNode->childNodes[$x]->childNodes);
                         for ($y = 0; $y < $dayCount; $y++) {
                             if ($dayfNode->childNodes[$x]->childNodes[$y]->nodeName == "hi") $weatherDayClass->day_temp_max = $dayfNode->childNodes[$x]->childNodes[$y]->firstChild->nodeValue;
                             if ($dayfNode->childNodes[$x]->childNodes[$y]->nodeName == "low") $weatherDayClass->day_temp_min = $dayfNode->childNodes[$x]->childNodes[$y]->firstChild->nodeValue;
                             if ($dayfNode->childNodes[$x]->childNodes[$y]->nodeName == "sunr"){
                                $weatherDayClass->day_sunrise = strftime($weatherTimeFormat, strtotime($dayfNode->childNodes[$x]->childNodes[$y]->firstChild->nodeValue));
                             }
                             if ($dayfNode->childNodes[$x]->childNodes[$y]->nodeName == "suns"){
                                $weatherDayClass->day_sunset = strftime($weatherTimeFormat, strtotime($dayfNode->childNodes[$x]->childNodes[$y]->firstChild->nodeValue));
                             }
                             if ($dayfNode->childNodes[$x]->childNodes[$y]->nodeName == "part") {
                                 $partCount = count($dayfNode->childNodes[$x]->childNodes[$y]->childNodes);
                                 for ($z = 0; $z < $dayCount; $z++) {
                                     $flag = $dayfNode->childNodes[$x]->childNodes[$y]->getAttribute('p');
                                     if ($flag == "d"){
                                         if ($dayfNode->childNodes[$x]->childNodes[$y]->childNodes[$z]->nodeName == "icon") $weatherDayClass->day_d_icon = $dayfNode->childNodes[$x]->childNodes[$y]->childNodes[$z]->firstChild->nodeValue;
                                         if ($dayfNode->childNodes[$x]->childNodes[$y]->childNodes[$z]->nodeName == "t") $weatherDayClass->day_d_text = $dayfNode->childNodes[$x]->childNodes[$y]->childNodes[$z]->firstChild->nodeValue;
                                         if ($dayfNode->childNodes[$x]->childNodes[$y]->childNodes[$z]->nodeName == "bt") $weatherDayClass->day_d_windtextd = $dayfNode->childNodes[$x]->childNodes[$y]->childNodes[$z]->firstChild->nodeValue;
                                         if ($dayfNode->childNodes[$x]->childNodes[$y]->childNodes[$z]->nodeName == "ppcp") $weatherDayClass->day_d_precipitation = $dayfNode->childNodes[$x]->childNodes[$y]->childNodes[$z]->firstChild->nodeValue;
                                         if ($dayfNode->childNodes[$x]->childNodes[$y]->childNodes[$z]->nodeName == "hmid") $weatherDayClass->day_d_humidity = $dayfNode->childNodes[$x]->childNodes[$y]->childNodes[$z]->firstChild->nodeValue;
                                         if ($dayfNode->childNodes[$x]->childNodes[$y]->childNodes[$z]->nodeName == "wind"){
                                             $dayWindCount = count($dayfNode->childNodes[$x]->childNodes[$y]->childNodes[$z]->childNodes);
                                             for ($v = 0; $v < $dayWindCount; $v++) {
                                                 if ($dayfNode->childNodes[$x]->childNodes[$y]->childNodes[$z]->childNodes[$v]->nodeName == "s") $weatherDayClass->day_d_windspeed = $dayfNode->childNodes[$x]->childNodes[$y]->childNodes[$z]->childNodes[$v]->firstChild->nodeValue;
                                                 if ($dayfNode->childNodes[$x]->childNodes[$y]->childNodes[$z]->childNodes[$v]->nodeName == "gust") $weatherDayClass->day_d_windgust = $dayfNode->childNodes[$x]->childNodes[$y]->childNodes[$z]->childNodes[$v]->firstChild->nodeValue;
                                                 if ($dayfNode->childNodes[$x]->childNodes[$y]->childNodes[$z]->childNodes[$v]->nodeName == "d") $weatherDayClass->day_d_winddirection = $dayfNode->childNodes[$x]->childNodes[$y]->childNodes[$z]->childNodes[$v]->firstChild->nodeValue;
                                                 if ($dayfNode->childNodes[$x]->childNodes[$y]->childNodes[$z]->childNodes[$v]->nodeName == "t") $weatherDayClass->day_d_windtext = $dayfNode->childNodes[$x]->childNodes[$y]->childNodes[$z]->childNodes[$v]->firstChild->nodeValue;
                                             }
                                         }
                                     } else {
                                         if ($dayfNode->childNodes[$x]->childNodes[$y]->childNodes[$z]->nodeName == "icon") $weatherDayClass->day_n_icon = $dayfNode->childNodes[$x]->childNodes[$y]->childNodes[$z]->firstChild->nodeValue;
                                         if ($dayfNode->childNodes[$x]->childNodes[$y]->childNodes[$z]->nodeName == "t") $weatherDayClass->day_n_text = $dayfNode->childNodes[$x]->childNodes[$y]->childNodes[$z]->firstChild->nodeValue;
                                         if ($dayfNode->childNodes[$x]->childNodes[$y]->childNodes[$z]->nodeName == "bt") $weatherDayClass->day_n_windtextd = $dayfNode->childNodes[$x]->childNodes[$y]->childNodes[$z]->firstChild->nodeValue;
                                         if ($dayfNode->childNodes[$x]->childNodes[$y]->childNodes[$z]->nodeName == "ppcp") $weatherDayClass->day_n_precipitation = $dayfNode->childNodes[$x]->childNodes[$y]->childNodes[$z]->firstChild->nodeValue;
                                         if ($dayfNode->childNodes[$x]->childNodes[$y]->childNodes[$z]->nodeName == "hmid") $weatherDayClass->day_n_humidity = $dayfNode->childNodes[$x]->childNodes[$y]->childNodes[$z]->firstChild->nodeValue;
                                         if ($dayfNode->childNodes[$x]->childNodes[$y]->childNodes[$z]->nodeName == "wind"){
                                             $dayWindCount = count($dayfNode->childNodes[$x]->childNodes[$y]->childNodes[$z]->childNodes);
                                             for ($v = 0; $v < $dayWindCount; $v++) {
                                                 if ($dayfNode->childNodes[$x]->childNodes[$y]->childNodes[$z]->childNodes[$v]->nodeName == "s") $weatherDayClass->day_n_windspeed = $dayfNode->childNodes[$x]->childNodes[$y]->childNodes[$z]->childNodes[$v]->firstChild->nodeValue;
                                                 if ($dayfNode->childNodes[$x]->childNodes[$y]->childNodes[$z]->childNodes[$v]->nodeName == "gust") $weatherDayClass->day_n_windgust = $dayfNode->childNodes[$x]->childNodes[$y]->childNodes[$z]->childNodes[$v]->firstChild->nodeValue;
                                                 if ($dayfNode->childNodes[$x]->childNodes[$y]->childNodes[$z]->childNodes[$v]->nodeName == "d") $weatherDayClass->day_n_winddirection = $dayfNode->childNodes[$x]->childNodes[$y]->childNodes[$z]->childNodes[$v]->firstChild->nodeValue;
                                                 if ($dayfNode->childNodes[$x]->childNodes[$y]->childNodes[$z]->childNodes[$v]->nodeName == "t") $weatherDayClass->day_n_windtext = $dayfNode->childNodes[$x]->childNodes[$y]->childNodes[$z]->childNodes[$v]->firstChild->nodeValue;
                                             }
                                         }
                                     }
                                 }
                             }
                         }
                         $weatherClass->dayf_forecasts[] = & $weatherDayClass;
                     }
                 }
                 break;
         }
     }
     $database -> setQuery($sql);
     $database -> query();
  } elseif ($element->getTagName() == 'error') {
      $x_error = $xmlDoc->documentElement->childNodes[0]->firstChild->nodeValue."\n";
      $x_error.="<br>"._W_ERROR_CODE.": ".$xmlDoc->documentElement->childNodes[0]->getAttribute('type')."\n";
      $weatherClass->e_error = $x_error;
  } else {
      $weatherClass->e_error = _W_UNKNOWN_ERROR;
  }
  return $weatherClass;
}

?>