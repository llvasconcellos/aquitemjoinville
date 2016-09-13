<?php
/**
* @version $Id: eweather.php,v 1.1.0 2006/04/30 10:00:00 stingrey Exp $
* @package eWeather
* @subpackage eWeather
* @copyright (C) 2000 - 2006 MamboBaer.de (Harald Baer)
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* eWeather is Free Software
*/

/** ensure this file is being included by a parent file */
defined('_VALID_MOS') or die('Direct Access to this location is not allowed.');

// load the html drawing class
require_once( $mainframe->getPath('front_html'));

include_once($mosConfig_absolute_path."/administrator/components/com_eweather/config.eweather.php");
if (file_exists($mosConfig_absolute_path.'/components/com_eweather/language/'.$mosConfig_lang.'.php')) {
   include_once($mosConfig_absolute_path.'/components/com_eweather/language/'.$mosConfig_lang.'.php');
} else {
   include_once($mosConfig_absolute_path.'/components/com_eweather/language/english.php');
}

switch($task) {
    case "view_weather":
         viewWeather();
         HTML_weather::showProvider();
         if ($weatherShowFooter == "1") HTML_weather::showFooter();
         break;
    case "profiles":
         displayLocations($Itemid);
         break;
     default:
         viewWeather();
         HTML_weather::showProvider();
         if ($weatherShowFooter == "1") HTML_weather::showFooter();
         break;
}

function displayLocations($myItemid){
  global $mosConfig_absolute_path, $database, $my, $weatherDefaultLocationID, $option;

  $conf_filter_region    = mosGetParam($_POST, 'filter_region', '');
  $conf_filter_countries = mosGetParam($_POST, 'filter_countries', '');
  $conf_filter_cities    = mosGetParam($_POST, 'filter_cities', '');
  $save                  = mosGetParam($_POST, 'save_button', '');
  $cancel                = mosGetParam($_POST, 'cancel_button', '');
  // if cancel button pressed than back to the main site
  if ($cancel <> "") {
     mosRedirect("index.php?option=$option&Itemid=".$myItemid,"");
     return;
  }

  // Check for User Profile and default settings
  if ($my->id <> 0) {
     if (($conf_filter_region == "") AND ($conf_filter_countries == "") AND ($conf_filter_cities == "")){
        $sql = "SELECT * FROM `#__eweather_profiles` WHERE `uid` = '".$my->id."'";
        $database->setQuery($sql);
        $database->loadObject($userProfiles);
        if (count($userProfiles) <> 0) {
           $weatherLocationID = $userProfiles->locid;
           $sql = "SELECT * FROM `#__eweather_locations` WHERE `loc_id` = '".$weatherLocationID."'";
           $database->setQuery($sql);
           $database->loadObject($locInfo);
           if (count($locInfo) <> 0) {
              $conf_filter_region    = $locInfo->region;
              $conf_filter_countries = $locInfo->country;
              $conf_filter_cities    = $locInfo->city;
           }
        }
     }
  }

  if (($weatherLocationID == "") AND ($conf_filter_region == "") AND ($conf_filter_countries == "") AND ($conf_filter_cities == "")){
     $sql = "SELECT * FROM `#__eweather_locations` WHERE `loc_id` = '".$weatherDefaultLocationID."'";
     $database->setQuery($sql);
     $database->loadObject($locInfo);
     if (count($locInfo) <> 0) {
        $conf_filter_region    = $locInfo->region;
        $conf_filter_countries = $locInfo->country;
        $conf_filter_cities    = $locInfo->city;
     }
  }

  // load all region infos
  $sql = "SELECT * FROM `#__eweather_locations` GROUP BY `region` ORDER BY `region` ASC";
  $database->setQuery($sql);
  $regions = $database->loadObjectList();
  if (count($regions) <> 0 ){
    foreach($regions as $region){
       $tempregion[] = mosHTML::makeOption($region->region , $region->region);
    }
  } else {
    $tempregion[]="";
  }
  $lists['regions'] = mosHTML::selectList($tempregion, 'filter_region', 'class="inputbox" size="1" onchange="document.locationForm.submit( );"', 'value', 'text', $conf_filter_region);

  // load counties in order to the selected region
  if ($conf_filter_region == "") $conf_filter_region = $regions[0]->region;
  $sql = "SELECT * FROM `#__eweather_locations` WHERE `region` = '".$conf_filter_region."' GROUP BY `country` ORDER BY `country` ASC";
  $database->setQuery($sql);
  $countries = $database->loadObjectList();
  if (count($countries) <> 0) {
    foreach($countries as $country){
       $tempcountry[] = mosHTML::makeOption($country->country , $country->country);
    }
  } else {
    $tempcountry[]="";
  }
  $lists['countries'] = mosHTML::selectList($tempcountry, 'filter_countries', 'class="inputbox" size="1" onchange="document.locationForm.submit( );"', 'value', 'text', $conf_filter_countries);

  // select the country in order to previous values
  $sql = "SELECT * FROM `#__eweather_locations` WHERE `country` = '".$conf_filter_countries."' ORDER BY `city` ASC";
  $database->setQuery($sql);
  $cities = $database->loadObjectList();
  if (count($cities) <> 0) {
     foreach($cities as $city){
         $tempcity[] = mosHTML::makeOption($city->city , $city->city);
     }
  } else {
     $sql = "SELECT * FROM `#__eweather_locations` WHERE `country` = '".$conf_filter_countries."' ORDER BY `city` ASC";
     $database->setQuery();
     $cities = $database->loadObjectList();
     if (count($cities) <> 0) {
        foreach($cities as $city){
            $tempcity[] = mosHTML::makeOption($city->city , $city->city);
        }
     } else {
       $tempcity[]="";
     }
  }
  $lists['cities'] = mosHTML::selectList($tempcity, 'filter_cities', 'class="inputbox" size="1" onchange="document.locationForm.submit( );"', 'value', 'text', $conf_filter_cities);

  // if save button pressed than save and back to the main site
  if ($save <> "") {
      $sql = "SELECT * FROM `#__eweather_locations` WHERE `region` = '".$conf_filter_region."' AND `country` = '".$conf_filter_countries."' AND `city` = '".$conf_filter_cities."'";
      $database->setQuery($sql);
      $database -> loadObject($myCity);
      if (count($myCity) <> 0){
          $database->setQuery("SELECT * FROM #__eweather_profiles WHERE `uid` = '".$my->id."'");
          $database->loadObject($myID);
          if (count($myID) <> 0){
             $database->setQuery("UPDATE `#__eweather_profiles` SET `locid` = '".$myCity->loc_id."' WHERE `id` =".$myID->id);
             $result = $database->query();
             $mosmsg = _WEATHER_PROFILE_UPDATE;
          } else {
             $database->setQuery("INSERT INTO `#__eweather_profiles` ( `id` , `uid` , `locid` ) VALUES ('', '".$my->id."', '".$myCity->loc_id."');");
             $result = $database->query();
             $mosmsg = _WEATHER_PROFILE_SAVED;
          }
      } else {
          $mosmsg = _WEATHER_PROFILE_ERROR;
      }
      mosRedirect("index.php?option=$option&Itemid=".$myItemid, $mosmsg);
  }

  HTML_weather::displayLocationForm($lists, $option);
}

function viewWeather(){
  global $mosConfig_absolute_path, $database, $weatherTitle, $weatherShowFooter, $weatherClass, $weatherDayClass,
         $weatherIconsStyle, $weatherShowForecast, $weatherPartnerID, $weatherPassword, $weatherDefaultLocationID,
         $weatherUnits, $weatherDayForecast, $weatherLongDateFormat, $weatherTimeFormat, $detail_view, $weatherCacheTime,
         $weatherDetailDateFormat, $weatherShortDateFormat;

  if ($weatherPartnerID == "") {
     HTML_weather::displayHeader();
     HTML_weather::displayErrorMessage(_W_ERROR_TITLE, _W_ERROR_DESCR, _W_ERROR_NOPARTNERID);
     return;
  }

  if ($weatherPassword == "") {
     HTML_weather::displayHeader();
     HTML_weather::displayErrorMessage(_W_ERROR_TITLE, _W_ERROR_DESCR, _W_ERROR_NOPASSWORD);
     return;
  }

  include_once($mosConfig_absolute_path."/components/com_eweather/eweather.main.php");

  $weatherClass = parseWeather();

  if ($weatherClass->e_error != ''){
     HTML_weather::displayErrorMessage(_W_ERROR_TITLE, _W_ERROR_DESCR, $weatherClass->e_error);
  } else {
     HTML_weather::displayHeader();
     HTML_weather::displayWeather($weatherClass, $weatherIconsStyle);
     if (isset($detail_view)){
         HTML_weather::displayDetailForecast($weatherClass->dayf_forecasts[$detail_view], $weatherIconsStyle, $weatherClass->dayf_lastupdate, $weatherClass->h_speed, $weatherClass->h_temp, $weatherDetailDateFormat);
     } elseif (($weatherClass->n_channels == 4) && ($weatherShowForecast == "1")) {
         HTML_weather::displayForecast($weatherClass, $weatherIconsStyle, $weatherShortDateFormat);
     }
  }
}

?>