<?php
/**
* @version $Id: admin.eweather.php,v 1.1.0 2006/04/30 10:00:00 stingrey Exp $
* @package eWeather
* @subpackage Admin eWeather
* @copyright (C) 2000 - 2006 MamboBaer.de (Harald Baer)
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* eWeather is Free Software
*/

/** ensure this file is being included by a parent file */
defined('_VALID_MOS') or die('Direct Access to this location is not allowed.');
global $mosConfig_absolute_path, $mosConfig_admin_template, $mosConfig_live_site, $_CONFIG;;

require_once($mainframe->getPath('admin_html'));

if ($_CONFIG->SITEPATH == "") {
   $_CONFIG->SITEPATH = $mosConfig_absolute_path;
   $_CONFIG->SITEURL  = $mosConfig_live_site;
}

//Get right Language file
if (file_exists($_CONFIG->SITEPATH.'/components/com_eweather/language/'.$mosConfig_lang.'.php')){
  include($_CONFIG->SITEPATH.'/components/com_eweather/language/'.$mosConfig_lang.'.php');
}else{
  include($_CONFIG->SITEPATH.'/components/com_eweather/language/english.php');
}
//include configuration file
if (file_exists($_CONFIG->SITEPATH.'/administrator/components/com_eweather/config.eweather.php')){
  include($_CONFIG->SITEPATH.'/administrator/components/com_eweather/config.eweather.php');
}else{
  die ("Error finding configuration file (".$_CONFIG->SITEPATH."/administrator/components/com_eweather/config.eweather.php)");
}


// determine the action which helps to determine the final task
if (!empty($act)){
   $table = $act;
}elseif (empty($table)){
   $table = "sessions";
}

switch ($task) {
    case "instLocation":
         instLocation($option);
         break;
    case "allLocations":
         showLocations($option);
         break;
    case "showConfig":
         showConfig($option);
         break;
   case "save":
        saveConfiguration($option);
        break;
    case "removeCity":
         removeCity($option);
         break;
    case "showCountry":
         showCountry($option);
         break;
    case "about":
         showInfo($option);
         break;

    default:
        showLocations($option);
        break;
}

function instLocation($option){
  global $database, $mosConfig_absolute_path, $conf_filter_region, $conf_filter_countries;

  $conf_filter_region    = mosGetParam($_POST, 'filter_new_region', 'Africa');
  $conf_filter_countries = mosGetParam($_POST, 'filter_new_countries', '');
  $conf_cancel_button    = mosGetParam($_POST, 'cancel_button', '');
  $conf_save_button      = mosGetParam($_POST, 'save_button', '');

  if ($conf_cancel_button <> "") mosRedirect("index2.php?option=$option&task=allLocations", $mosmsg);
  if ($conf_save_button <> "") {
      $sql = "SELECT * FROM `#__eweather_prefs` WHERE `region` = '".$conf_filter_region."' AND `country` = '".$conf_filter_countries."'";
      $database->setQuery($sql);
      $database->loadObject($new_country);
      if (file_exists($mosConfig_absolute_path."/administrator/components/com_eweather/loc_data/".$new_country->loc_id.".php")) {
         include_once($mosConfig_absolute_path."/administrator/components/com_eweather/loc_data/".$new_country->loc_id.".php");
         $sql_add = "";
         foreach ($city_data as $city) {
                 $sql_add     = "INSERT INTO `#__eweather_locations` (`id`, `city`, `country`, `region`, `loc_id`) VALUES ('', '".$city['name']."', '".$conf_filter_countries."', '".$conf_filter_region."', '".$city['accid']."');\r\n";
                 $country_add = $database->setQuery($sql_add);
                 $result      = $database->query();
         }
         $mosmsg = "Location File for ".$conf_filter_countries." installed!";
      } else {
         $mosmsg = "Location File (".$new_country->loc_id.".php) for ".$conf_filter_countries." not available! <br>";
      }
     mosRedirect("index2.php?option=$option&task=allLocations", $mosmsg);
  }

  $tempregion  = array();
  $tempcountry = array();

  $sql = "SELECT `region` FROM `#__eweather_prefs` GROUP BY `region` ORDER BY `region` ASC";
  $database-> setQuery($sql);
  $regions = $database -> loadObjectList();
  foreach($regions as $region){
     $tempregion[] = mosHTML::makeOption($region->region , $region->region);
  }
  $lists['regions'] = mosHTML::selectList($tempregion, 'filter_new_region', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', $conf_filter_region);

  $sql = "SELECT `country` FROM `#__eweather_prefs` WHERE `region` = '".$conf_filter_region."' GROUP BY `country` ORDER BY `country` ASC";
  $database-> setQuery($sql);
  $countries = $database -> loadObjectList();
  foreach($countries as $country){
     $tempcountry[] = mosHTML::makeOption($country->country , $country->country);
  }
  $lists['countries'] = mosHTML::selectList($tempcountry, 'filter_new_countries', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', $conf_filter_countries);

  HTML_eweather::showInstLocations($option, $lists);
}

function removeCity($option){
  global $database;
  $cities = mosGetParam($_REQUEST, 'city_list', '');
  if (is_array($cities)){
     foreach ($cities as $city){
             $database->setQuery("DELETE FROM `#__eweather_locations` WHERE `id` = '".$city."'");
             $database->query();
     }
  }
  mosRedirect("index2.php?option=$option", $mosmsg);
}

function showLocations($option){
  global $database;

  $sql = "SELECT `region`,`country`,COUNT(`city`) AS city_count FROM `#__eweather_locations` GROUP BY `country` ORDER BY `region`, `country` ASC";
  $database->setQuery($sql);
  $regions = $database->loadObjectList();
  $tmp_region = "";
  foreach ($regions as $region){
          if ($tmp_region <> $region->region){
             $list.= "<tr>\n"
                    ."  <td style=\"font-weight: bold; background: url('components/com_eweather/images/region_title.png');\">".$region->region."</td>\n"
                    ."  <td style=\"font-weight: bold; background: url('components/com_eweather/images/region_title.png');\">&nbsp;</td>\n"
                    ."</tr>\n"
                    ."<tr>\n"
                    ."  <td style=\"text-indent: 20px;\"><a href=\"index2.php?option=com_eweather&task=showCountry&country=".$region->country."\">".$region->country."&nbsp;(".$region->city_count.")</a></td>\n"
                    ."  <td align=\"right\" width=\"5%\">".$region->city_count."</td>\n"
                    ."</tr>\n";
             $tmp_region = $region->region;
          }else{
             $list.= "<tr>\n"
                    ."  <td style=\"text-indent: 20px;\"><a href=\"index2.php?option=com_eweather&task=showCountry&country=".$region->country."\">".$region->country."&nbsp;(".$region->city_count.")</a></td>\n"
                    ."  <td align=\"right\" width=\"5%\">".$region->city_count."</td>\n"
                    ."</tr>\n";
          }
  }
  HTML_eweather::showLocation($option, $list);
}

function showCountry($option){
  global $database;

  $country = mosGetParam($_REQUEST, 'country', '');
  $sql = "SELECT * FROM `#__eweather_locations` WHERE `country` = '".$country."' ORDER BY `city` ASC";
  $database->setQuery($sql);
  $cities = $database->loadObjectList();
  $i = 0;
  foreach ($cities as $city){
          $list.= "<tr>\n"
                 ."  <td width=\"1%\"><input type=\"checkbox\" id=\"cb".$i++."\" name=\"city_list[]\" value=\"".$city->id."\" onclick=\"isChecked(this.checked);\" /></td>\n"
                 ."  <td style=\"white-space: nowrap;\">".$city->city."</td>\n"
                 ."  <td width=\"5%\" style=\"white-space: nowrap;\">".$city->loc_id."</td>\n"
                 ."  <td width=\"5%\" style=\"white-space: nowrap;\">".$city->country."</td>\n"
                 ."  <td width=\"5%\" style=\"white-space: nowrap;\">".$city->region."</td>\n"
                 ."</tr>\n";
  }
  HTML_eweather::showCountry($option, $list, $i, $country);
}

function showConfig($option){
  global $weatherPartnerID;

  $lists = displayLocations();
  HTML_eweather::listConfiguration($option, $lists);
}

function showInfo($option){
  global $mosConfig_absolute_path;

  echo "<form action=\"index2.php?option=com_eweather\" method=\"post\" name=\"adminForm\">\n";
  echo "  <table border=\"0\" class=\"adminform\">\n";
  echo "    <tr>\n";
  echo "      <td>\n";
  echo "        <div style=\"text-align:left;\" >\n";
  require_once($mosConfig_absolute_path."/components/$option/eweather.html");
  echo "        </div>\n";
  echo "      </td>\n";
  echo "    </tr>\n";
  echo "  </table>\n";
  echo "  <input type=\"hidden\" name=\"option\" value=\"$option\">\n";
  echo "  <input type=\"hidden\" name=\"task\" value=\"\">\n";
  echo "</form>\n";
}

function saveConfiguration($option){
  global $mosConfig_absolute_path;

  $conf_partnerID          = mosGetParam( $_POST, 'partner_ID', '');
  $conf_partner_key        = mosGetParam( $_POST, 'partner_key', '');
  $conf_partner_key        = mosGetParam( $_POST, 'partner_key', '');
  $conf_default_location   = mosGetParam( $_POST, 'default_location', '');
  $conf_cache_time         = intval(mosGetParam( $_POST, 'cache_time', '1800'));
  $conf_units              = intval(mosGetParam( $_POST, 'weather_units', '0'));
  $conf_iconstyle          = mosGetParam( $_POST, 'icon_style', 'default' );
  $conf_forecast_days      = intval(mosGetParam( $_POST, 'forecast_days', '10'));
  $conf_show_footer        = intval(mosGetParam( $_POST, 'show_footer', '1'));
  $conf_show_forecast      = intval(mosGetParam( $_POST, 'show_forecast', '1'));
  $conf_time_format        = mosGetParam( $_POST, 'time_format', '');
  $conf_date_format_long   = mosGetParam( $_POST, 'date_format_long', '');
  $conf_date_format_short  = mosGetParam( $_POST, 'date_format_short', '');
  $conf_date_format_detail = mosGetParam( $_POST, 'date_format_detail', '');
  $conf_use_proxy          = mosGetParam( $_POST, 'use_proxy', '0');
  $conf_proxy_host         = mosGetParam( $_POST, 'proxy_host', '');
  $conf_proxy_port         = mosGetParam( $_POST, 'proxy_port', '');
  $conf_use_proxy_auth     = mosGetParam( $_POST, 'use_proxy_auth', '0');
  $conf_proxy_auth_user    = mosGetParam( $_POST, 'proxy_auth_user', '');
  $conf_proxy_auth_pwd     = mosGetParam( $_POST, 'proxy_auth_pwd', '');

  if (intval(mosGetParam( $_POST, 'weather_units', '0')) == 0) {
     $conf_units = "m";
  } else {
     $conf_units = "s";
  }

  if ($conf_cache_time < 1800) $conf_cache_time = 1800;

  $configfile = $mosConfig_absolute_path."/administrator/components/com_eweather/config.eweather.php";
  clearstatcache();
  @chmod ($configfile, 0777);

  $configtxt = "<?php\r\n"
              ."  \$weatherVersion = \"1.1.0 Beta\";\r\n"
              ."  \$weatherPartnerID = \"".$conf_partnerID."\";\r\n"
              ."  \$weatherPassword = \"".$conf_partner_key."\";\r\n"
              ."  \$weatherDefaultLocationID = \"".$conf_default_location."\";\r\n"
              ."  \$weatherCacheTime = ".$conf_cache_time.";\r\n"
              ."  \$weatherUnits = \"".$conf_units."\";\r\n"

              ."  \$weatherDayForecast = \"".$conf_forecast_days."\";\r\n"
              ."  \$weatherShowFooter = \"".$conf_show_footer."\";\r\n"
              ."  \$weatherIconsStyle = \"".$conf_iconstyle."\";\r\n"

              ."  \$weatherShowForecast = \"".$conf_show_forecast."\";\r\n"
              ."  \$weatherTimeFormat = \"".$conf_time_format."\";\r\n"
              ."  \$weatherLongDateFormat = \"".$conf_date_format_long."\";\r\n"
              ."  \$weatherShortDateFormat = \"".$conf_date_format_short."\";\r\n"
              ."  \$weatherDetailDateFormat = \"".$conf_date_format_detail."\";\r\n"
              ."  \$weatherUseProxy = \"".$conf_use_proxy."\";\r\n"
              ."  \$weatherProxyHost = \"".$conf_proxy_host."\";\r\n"
              ."  \$weatherProxyPort = \"".$conf_proxy_port."\";\r\n"
              ."  \$weatherUseProxyAuth = \"".$conf_use_proxy_auth."\";\r\n"
              ."  \$weatherProxyAuthUser = \"".$conf_proxy_auth_user."\";\r\n"
              ."  \$weatherProxyAuthPwd = \"".$conf_proxy_auth_pwd."\";\r\n"
              ."?>\r\n";

  if ($fp = fopen("$configfile", "w+")) {
     fputs($fp, $configtxt, strlen($configtxt));
     fclose ($fp);
  }

  $mosmsg = "Config is saved !";
  mosRedirect("index2.php?option=$option&task=config", $mosmsg);
}

function displayLocations(){
  global $mosConfig_absolute_path, $database, $weatherDefaultLocationID;

  $conf_filter_region    = mosGetParam( $_POST, 'filter_region', '');
  $conf_filter_countries = mosGetParam( $_POST, 'filter_countries', '');
  $conf_filter_cities    = mosGetParam( $_POST, 'filter_cities', '');
  //echo $weatherLocationID;
  if (($conf_filter_region == "") AND ($conf_filter_countries == "") AND ($conf_filter_cities == "")){
     $sql = "SELECT * FROM `#__eweather_locations` WHERE `loc_id` = '".$weatherDefaultLocationID."'";
     $database->setQuery($sql);
     $database -> loadObject($locInfo);
     if (count($locInfo) <> 0) {
        $conf_filter_region = $locInfo->region;
        $conf_filter_countries = $locInfo->country;
        $conf_filter_cities = $locInfo->city;
     }
  }

  // load all region infos
  $sql = "SELECT * FROM `#__eweather_locations` GROUP BY `region` ORDER BY `region` ASC";
  $database->setQuery($sql);
  $regions = $database -> loadObjectList();
  if (count($regions) <> 0) {
    foreach($regions as $region){
       $tempregion[] = mosHTML::makeOption($region->region , $region->region);
    }
  } else {
    $tempregion[]="";
  }
  $lists['regions'] = mosHTML::selectList($tempregion, 'filter_region', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', $conf_filter_region);

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
  $lists['countries'] = mosHTML::selectList($tempcountry, 'filter_countries', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', $conf_filter_countries);

  // select the country in order to previous values
  $sql = "SELECT * FROM `#__eweather_locations` WHERE `country` = '".$conf_filter_countries."' ORDER BY `city` ASC";
  $database->setQuery($sql);
  $cities = $database->loadObjectList();
  if (count($cities) <> 0) {
     foreach($cities as $city){
         $tempcity[] = mosHTML::makeOption($city->city , $city->city);
     }
  } else {
     $sql = "SELECT * FROM `#__eweather_locations` WHERE `country` = '".$countries[0]->country."' AND `region` = '".$conf_filter_region."' ORDER BY `city` ASC";
     $database->setQuery($sql);
     $cities = $database->loadObjectList();
     if (count($cities) <> 0) {
        foreach($cities as $city){
            $tempcity[] = mosHTML::makeOption($city->city , $city->city);
        }
     } else {
       $tempcity[]="";
     }
  }
  $lists['cities'] = mosHTML::selectList($tempcity, 'filter_cities', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', $conf_filter_cities);

  $sql = "SELECT * FROM `#__eweather_locations` WHERE `city` = '".$conf_filter_cities."'";
  $database->setQuery($sql);
  $defaultcities = $database->loadObjectList();
  if (count($defaultcities) <> 0) $weatherDefaultLocationID = $defaultcities[0]->loc_id;

  return $lists;
}

?>