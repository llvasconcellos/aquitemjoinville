<?php
/**
* @version $Id: admin.eweather.html.php,v 1.1.0 2006/04/30 10:00:00 stingrey Exp $
* @package eWeather
* @subpackage Admin eWeather
* @copyright (C) 2000 - 2006 MamboBaer.de (Harald Baer)
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* eWeather is Free Software
*/

/** ensure this file is being included by a parent file */
defined('_VALID_MOS') or die('Direct Access to this location is not allowed.');


class HTML_eweather{

  function showInstLocations($option, &$lists){
    global $mosConfig_live_site;

    $content = "<form action=\"index2.php?option=com_eweather\" method=\"post\" name=\"adminForm\">\n"
              ."  <table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\n"
              ."    <tr>\n"
              ."      <td width=\"100%\" style=\"border-bottom: 1px solid #CCCCCC;\" width=\"100%\">\n"
              ."        <img src=\"".$mosConfig_live_site."/administrator/components/com_eweather/images/eWeather.png\" alt=\"\" style=\"margin-right:10px;\" />\n"
              ."        <font style=\"color: #C64934;font-size: 18px;font-weight: bold; text-align: left;\">eWeather - Install Locations</font>\n"
              ."      </td>\n"
              ."    </tr>\n"
              ."  </table>\n"
              ."  <br />\n"
              ."  <table width=\"30%\">\n"
              ."    <tr><td>\n"
              ."      <table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"adminlist\">\n"
              ."        <tr>\n"
              ."          <th colspan=\"2\" align=\"center\">"._W_LOC_DATA."</th>\n"
              ."        </tr>\n"
              ."        <tr>\n"
              ."          <td width=\"30%\">\n"
              ."            "._WEATHER_REGION
              ."          </td>\n"
              ."          <td>\n"
              ."            :&nbsp;".$lists['regions']
              ."          </td>\n"
              ."        </tr>\n"
              ."        <tr>\n"
              ."          <td width=\"30%\">\n"
              ."            "._WEATHER_COUNTRY
              ."          </td>\n"
              ."          <td>\n"
              ."            :&nbsp;".$lists['countries']
              ."          </td>\n"
              ."        </tr>\n"
              ."        <tr>\n"
              ."          <td colspan=\"2\" align=\"center\">\n"
              ."            <input type=\"SUBMIT\" name=\"save_button\" value=\""._WEATHER_SAVE_BUTTON."\" class=\"button\" align=\"center\">\n"
              ."            <input type=\"SUBMIT\" name=\"cancel_button\" value=\""._WEATHER_CANCEL_BUTTON."\" class=\"button\" align=\"center\">\n"
              ."          </td>\n"
              ."        </tr>\n"
              ."        <tr>\n"
              ."          <th colspan=\"2\" align=\"center\">&nbsp;</th>\n"
              ."        </tr>\n"
              ."      </table>\n"
              ."    </td></tr>\n"
              ."  </table>\n"
              ."  <input type=\"hidden\" name=\"option\" value=\"$option\">\n"
              ."  <input type=\"hidden\" name=\"task\" value=\"instLocation\">\n"
              ."</form>\n";

    echo $content;
  }

  function showLocation($option, $list){
    global $mosConfig_live_site;

    $content = "<form action=\"index2.php?option=com_eweather\" method=\"post\" name=\"adminForm\">\n"
              ."  <table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\n"
              ."    <tr>\n"
              ."      <td width=\"100%\">\n"
              ."        <img src=\"".$mosConfig_live_site."/administrator/components/com_eweather/images/eWeather.png\" alt=\"\" style=\"margin-right:10px;\" />\n"
              ."        <font style=\"color: #C64934;font-size: 18px;font-weight: bold; text-align: left;\">eWeather - Locations</font>\n"
              ."      </td>\n"
              ."    </tr>\n"
              ."  </table>\n"
              ."  <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"adminlist\">\n"
              ."    <tr>\n"
              ."      <th colspan=\"2\" align=\"left\">"._WEATHER_REGION."&nbsp;/&nbsp;"._WEATHER_COUNTRY."</th>\n"
              ."    </tr>\n"
              .$list
              ."    <tr>\n"
              ."      <th colspan=\"2\">&nbsp;</th>\n"
              ."    </tr>\n"
              ."  </table>\n"
              ."  <input type=\"hidden\" name=\"option\" value=\"$option\">\n"
              ."  <input type=\"hidden\" name=\"task\" value=\"\">\n"
              ."</form>\n";

    echo $content;
  }

  function showCountry($option, $list, $count, $country){
    global $mosConfig_live_site;

    $content = "<form action=\"index2.php?option=com_eweather\" method=\"post\" name=\"adminForm\">\n"
              ."  <table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\n"
              ."    <tr>\n"
              ."      <td width=\"100%\">\n"
              ."        <img src=\"".$mosConfig_live_site."/administrator/components/com_eweather/images/eWeather.png\" alt=\"\" style=\"margin-right:10px;\" />\n"
              ."        <font style=\"color: #C64934;font-size: 18px;font-weight: bold; text-align: left;\">eWeather - Cities</font>\n"
              ."      </td>\n"
              ."    </tr>\n"
              ."  </table>\n"
              ."  <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"adminlist\">\n"
              ."    <tr>\n"
              ."      <th width=\"1%\"><input type=\"checkbox\" name=\"toggle\" value=\"\" onclick=\"checkAll(".$count.");\" /></th>\n"
              ."      <th align=\"left\">".$country."</th>\n"
              ."      <th align=\"left\">"._WEATHER_CITY_CODE."</th>\n"
              ."      <th align=\"left\">"._WEATHER_COUNTRY."</th>\n"
              ."      <th align=\"left\">"._WEATHER_REGION."</th>\n"
              ."    </tr>\n"
              .$list
              ."    <tr>\n"
              ."      <th colspan=\"5\">&nbsp;</th>\n"
              ."    </tr>\n"
              ."  </table>\n"
              ."  <input type=\"hidden\" name=\"option\" value=\"$option\">\n"
              ."  <input type=\"hidden\" name=\"task\" value=\"\">\n"
              ."  <input type=\"hidden\" name=\"boxchecked\" value=\"0\" />\n"
              ."</form>\n";

    echo $content;
  }

  function listConfiguration($option, &$lists){
    global $mosConfig_live_site, $weatherPartnerID, $weatherPassword, $weatherCacheTime, $weatherTimeFormat, $weatherLongDateFormat,
           $weatherShortDateFormat, $weatherShowForecast, $weatherShowFooter, $weatherDayForecast, $weatherUnits, $weatherDefaultLocationID,
           $weatherDetailDateFormat, $weatherIconsStyle, $weatherUseProxy, $weatherProxyHost, $weatherProxyPort,
           $weatherUseProxyAuth, $weatherProxyAuthUser, $weatherProxyAuthPwd, $mosConfig_absolute_path;

    if ($weatherUnits == "m") {
        $x_weatherUnits = "0";
    } else {
        $x_weatherUnits = "1";
    }
    $tempdir   = array();
    $templates = GetDirectory($mosConfig_absolute_path."/components/com_eweather/images");
    foreach ($templates AS $template) {
            $tempdir[]=mosHTML::makeOption( $template , $template );
    }

    $content = "<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\n"
              ."  <tr>\n"
              ."    <td width=\"100%\">\n"
              ."      <img src=\"".$mosConfig_live_site."/administrator/components/com_eweather/images/eWeather.png\" alt=\"\" style=\"margin-right:10px;\" />\n"
              ."      <font style=\"color: #C64934;font-size: 18px;font-weight: bold; text-align: left;\">eWeather - Settings</font>\n"
              ."    </td>\n"
              ."  </tr>\n"
              ."</table>\n"
              ."<form action=\"index2.php?option=com_eweather\" method=\"post\" name=\"adminForm\">\n"
              ."<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"adminlist\">\n"
              ."  <tr>\n"
              ."    <th align=\"left\">"._WEATHER_PARAM_TITLE."</th>\n"
              ."    <th align=\"left\">"._WEATHER_VALUE_TITLE."</th>\n"
              ."    <th align=\"left\">"._WEATHER_DESCRIB_TITLE."</th>\n"
              ."  </tr>\n"
              ."  <tr>\n"
              ."    <td>"._WEATHER_PARTNER_ID.":</td>\n"
              ."    <td><input type=\"text\" name=\"partner_ID\" value=\"$weatherPartnerID\" maxlength=\"30\" size=\"31\"></td>\n"
              ."    <td>"._WEAHTER_PARTNER_ID_D."</td>\n"
              ."  </tr>\n"
              ."  <tr>\n"
              ."    <td>"._WEATHER_PARTNER_KEY.":</td>\n"
              ."    <td><input type=\"text\" name=\"partner_key\" value=\"$weatherPassword\" maxlength=\"30\" size=\"31\"></td>\n"
              ."    <td>"._WEAHTER_PARTNER_KEY_D."</td>\n"
              ."  </tr>\n"
              ."  <tr>\n"
              ."    <td valign=\"top\">"._WEATHER_DEFAULT_LOCATION.":</td>\n"
              ."    <td>\n"
              ."      ".$lists['regions']."<br>\n"
              ."      ".$lists['countries']."<br>\n"
              ."      ".$lists['cities']."<br>\n"
              ."    </td>\n"
              ."    <td valign=\"top\">"._WEATHER_DEFAULT_LOCATION_D."</td>\n"
              ."  </tr>\n"
              ."  <tr>\n"
              ."    <td>"._WEATHER_DEFAULT_LOC_CODE.":</td>\n"
              ."    <td><input type=\"text\" readonly name=\"default_location\" value=\"$weatherDefaultLocationID\" maxlength=\"15\" size=\"16\"></td>\n"
              ."    <td>"._WEATHER_DEFAULT_LOC_CODE_D."</td>\n"
              ."  </tr>\n"
              ."  <tr>\n"
              ."    <td>"._WEATHER_CACHE_TIME.":</td>\n"
              ."    <td><input type=\"text\" name=\"cache_time\" value=\"$weatherCacheTime\" maxlength=\"5\" size=\"6\"></td>\n"
              ."    <td>"._WEATHER_CACHE_TIME_D."</td>\n"
              ."  </tr>\n"
              ."  <tr>\n"
              ."    <td>"._WEATHER_UNITS.":</td>\n"
              ."    <td>".mosHTML::yesnoRadioList('weather_units', 'class="inputbox"', $x_weatherUnits, _WEATHER_UNITS_ENG, _WEATHER_UNITS_INT)."</td>\n"
              ."    <td>"._WEATHER_UNITS_D."</td>\n"
              ."  </tr>\n"
              ."  <tr>\n"
              ."    <td>"._WEATHER_SHOW_FORECAST.":</td>\n"
              ."    <td>".mosHTML::yesnoRadioList('show_forecast', 'class="inputbox"', $weatherShowForecast)."</td>\n"
              ."    <td>"._WEATHER_SHOW_FORECAST_D."</td>\n"
              ."  </tr>\n"
              ."  <tr>\n"
              ."    <td>"._WEATHER_ICONSET.":</td>\n"
              ."    <td>". mosHTML::selectList( $tempdir, 'icon_style', 'class="inputbox" size="1"', 'value', 'text', $weatherIconsStyle )."</td>\n"
              ."    <td>"._WEATHER_ICONSET_D."</td>\n"
              ."  </tr>\n"
              ."  <tr>\n"
              ."    <td>"._WEATHER_FORECAST_DAYS.":</td>\n"
              ."    <td>".mosHTML::integerSelectList('5', '10', '5', 'forecast_days', '',$weatherDayForecast)."</td>\n"
              ."    <td>"._WEATHER_FORECAST_DAYS_D."</td>\n"
              ."  </tr>\n"
              ."  <tr>\n"
              ."    <td>"._WEATHER_TIME_FORMAT.":</td>\n"
              ."    <td><input type=\"text\" name=\"time_format\" value=\"$weatherTimeFormat\" maxlength=\"20\" size=\"21\"></td>\n"
              ."    <td>"._WEATHER_TIME_FORMAT_D."</td>\n"
              ."  </tr>\n"
              ."  <tr>\n"
              ."    <td>"._WEATHER_DATE_FORMAT_LONG.":</td>\n"
              ."    <td><input type=\"text\" name=\"date_format_long\" value=\"$weatherLongDateFormat\" maxlength=\"20\" size=\"21\"></td>\n"
              ."    <td>"._WEATHER_DATE_FORMAT_LONG_D."</td>\n"
              ."  </tr>\n"
              ."  <tr>\n"
              ."    <td>"._WEATHER_DATE_FORMAT_SHORT.":</td>\n"
              ."    <td><input type=\"text\" name=\"date_format_short\" value=\"$weatherShortDateFormat\" maxlength=\"20\" size=\"21\"></td>\n"
              ."    <td>"._WEATHER_DATE_FORMAT_SHORT_D."</td>\n"
              ."  </tr>\n"
              ."  <tr>\n"
              ."    <td>"._WEATHER_DATE_FORMAT_DETAIL.":</td>\n"
              ."    <td><input type=\"text\" name=\"date_format_detail\" value=\"$weatherDetailDateFormat\" maxlength=\"20\" size=\"21\"></td>\n"
              ."    <td>"._WEATHER_DATE_FORMAT_DETAIL_D."</td>\n"
              ."  </tr>\n"
              ."  <tr>\n"
              ."    <td>"._WEATHER_USE_PROXY.":</td>\n"
              ."    <td>".mosHTML::yesnoRadioList('use_proxy', 'class="inputbox"', $weatherUseProxy)."</td>\n"
              ."    <td>"._WEATHER_USE_PROXY_D."</td>\n"
              ."  </tr>\n"
              ."  <tr>\n"
              ."    <td>"._WEATHER_PROXY_HOST.":</td>\n"
              ."    <td><input type=\"text\" name=\"proxy_host\" value=\"$weatherProxyHost\" maxlength=\"255\" size=\"31\"></td>\n"
              ."    <td>"._WEATHER_PROXY_HOST_D."</td>\n"
              ."  </tr>\n"
              ."  <tr>\n"
              ."    <td>"._WEATHER_PROXY_PORT.":</td>\n"
              ."    <td><input type=\"text\" name=\"proxy_port\" value=\"$weatherProxyPort\" maxlength=\"5\" size=\"6\"></td>\n"
              ."    <td>"._WEATHER_PROXY_PORT_D."</td>\n"
              ."  </tr>\n"
              ."  <tr>\n"
              ."    <td>"._WEATHER_USE_PROXY_AUTH.":</td>\n"
              ."    <td>".mosHTML::yesnoRadioList('use_proxy_auth', 'class="inputbox"', $weatherUseProxyAuth)."</td>\n"
              ."    <td>"._WEATHER_USE_PROXY_AUTH_D."</td>\n"
              ."  </tr>\n"
              ."  <tr>\n"
              ."    <td>"._WEATHER_PROXY_AUTH_USER.":</td>\n"
              ."    <td><input type=\"text\" name=\"proxy_auth_user\" value=\"$weatherProxyAuthUser\" maxlength=\"20\" size=\"21\"></td>\n"
              ."    <td>"._WEATHER_PROXY_AUTH_USER_D."</td>\n"
              ."  </tr>\n"
              ."  <tr>\n"
              ."    <td>"._WEATHER_PROXY_AUTH_PWD.":</td>\n"
              ."    <td><input type=\"text\" name=\"proxy_auth_pwd\" value=\"$weatherProxyAuthPwd\" maxlength=\"20\" size=\"21\"></td>\n"
              ."    <td>"._WEATHER_PROXY_AUTH_PWD_D."</td>\n"
              ."  </tr>\n"
              ."  <tr>\n"
              ."    <td>"._WEATHER_SHOW_FOOTER.":</td>\n"
              ."    <td>".mosHTML::yesnoRadioList('show_footer', 'class="inputbox"', $weatherShowFooter)."</td>\n"
              ."    <td>"._WEATHER_SHOW_FOOTER_D."</td>\n"
              ."  </tr>\n"
              ."  <tr>\n"
              ."    <th colspan=\"4\">&nbsp;</th>\n"
              ."  </tr>\n"
              ."</table>\n"
              ."<input type=\"hidden\" name=\"option\" value=\"$option\">\n"
              ."<input type=\"hidden\" name=\"task\" value=\"showConfig\">\n"
              ."</form>\n";

    echo $content;
  }
}

function GetDirectory($path) {
  $arr = array();
  if (!@is_dir( $path )) {
     return $arr;
  }
  $handle = opendir( $path );
  while ($file = readdir($handle)) {
        $dir = mosPathName( $path.'/'.$file, false );
        if (is_dir( $dir )) {
            if (($file <> ".") && ($file <> "..")) {
               $arr[] = trim( $file );
            }
        }
  }
  closedir($handle);
  asort($arr);
  return $arr;
}

?>