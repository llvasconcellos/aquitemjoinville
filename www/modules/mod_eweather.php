<?php
/**
* @version $Id: mod_eWeather.php,v 1.01 2005/06/29 10:00:00 eddieajau Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

global $mosConfig_absolute_path, $mosConfig_lang, $weatherTitle, $weatherShowFooter, $weatherClass, $weatherDayClass,
       $weatherIconsStyle, $weatherShowForecast, $weatherPartnerID, $weatherPassword, $weatherDefaultLocationID,
       $weatherUnits, $weatherDayForecast, $weatherLongDateFormat, $weatherTimeFormat, $detail_view, $weatherCacheTime,
       $weatherShortDateFormat, $weatherUseProxy, $weatherProxyHost, $weatherProxyPort, $weatherUseProxyAuth,
       $weatherProxyAuthUser, $weatherProxyAuthPwd;

$moduleclass_sfx = $params->get( 'moduleclass_sfx' );

if (file_exists($mosConfig_absolute_path."/administrator/components/com_eweather/config.eweather.php")) {
     include_once($mosConfig_absolute_path."/administrator/components/com_eweather/config.eweather.php");

     if (file_exists($mosConfig_absolute_path."/components/com_eweather/language/".$mosConfig_lang.".php")) {
        include_once($mosConfig_absolute_path."/components/com_eweather/language/".$mosConfig_lang.".php");
     } else {
        include_once($mosConfig_absolute_path."/components/com_eweather/language/english.php");
     }
     include_once($mosConfig_absolute_path."/components/com_eweather/eweather.html.php");
     include_once($mosConfig_absolute_path."/components/com_eweather/eweather.main.php");

     $weatherClass = parseWeather();
     showWeather($weatherClass);

} else {
     echo "Please install compontent com_eweather first!\n";
}

function showWeather(&$weather) {
  global $weatherIconsStyle, $database, $mosConfig_live_site;

  $database -> setQuery("SELECT * FROM #__menu WHERE `link` = 'index.php?option=com_eweather'");
  $mname = $database -> loadObjectList();
  if (count($mname) > 0 ){
     $myItemID = $mname[0]->id;
  } else {
     $myItemID = "0";
  }

  $content = "<table border=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;\" align=\"center\" width=\"99%\">\n"
            ."  <tr>\n"
            ."    <td colspan=\"2\" align=\"center\" style=\"border-bottom: 1px solid #CCCCCC;\">\n"
            ."      <div align=\"center\"><strong>".$weather->loc_city."</strong></div>\n"
            ."    </td>\n"
            ."  </tr>\n"
            ."  <tr>\n"
            ."    <td>\n"
            ."      <div align=\"center\" valign=\"middle\"><img src=\"".$mosConfig_live_site."/components/com_eweather/images/".$weatherIconsStyle."/small/".$weather->cc_icon.".png\" alt=\"\" border=\"0\"></div>\n"
            ."    </td>\n"
            ."    <td valign=\"top\">\n"

            ."      <table border=\"0\" style=\"margin: 0px; padding: 0px;\" cellspacing=\"0\" cellpadding=\"0\" width=\"99%\" align=\"center\">\n"
            ."        <tr>\n"
            ."          <td style=\"margin: 0px; padding: 0px; text-align: left;\">\n"
            ."            <strong>"._W_TEMP.":</strong>\n"
            ."          </td>\n"
            ."          <td style=\"margin: 0px; padding: 0px; text-align: right;\">\n"
            ."            ".$weather->cc_temp."°".$weather->h_temp."\n"
            ."          </td>\n"
            ."        </tr>\n"
            ."        <tr>\n"
            ."          <td style=\"margin: 0px; padding: 0px; text-align: left;\">\n"
            ."            <strong>"._W_WINDCHILL.":</strong>\n"
            ."          </td>\n"
            ."          <td style=\"margin: 0px; padding: 0px; text-align: right;\">\n"
            ."            ".$weather->cc_windchill."°".$weather->h_temp."\n"
            ."          </td>\n"
            ."        </tr>\n"
            ."        <tr>\n"
            ."          <td style=\"margin: 0px; padding: 0px; text-align: left;\">\n"
            ."            <strong>"._W_FORECAST_HUMI.":</strong>\n"
            ."          </td>\n"
            ."          <td style=\"margin: 0px; padding: 0px; text-align: right;\">\n"
            ."            ".$weather->cc_humidity."%\n"
            ."          </td>\n"
            ."        </tr>\n"
            ."      </table>\n"

            ."    </td>\n"
            ."  </tr>\n"
            ."</table>\n"

            ."<table border=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse;\" align=\"center\" width=\"99%\">\n"
            ."  <tr>\n"
            ."    <td valign=\"top\">\n"

            ."      <table border=\"0\" style=\"margin: 0px; padding: 0px;\" cellspacing=\"0\" cellpadding=\"0\" width=\"99%\" align=\"center\">\n"
            ."        <tr>\n"
            ."          <td style=\"margin: 0px; padding: 0px; text-align: left;\">\n"
            ."            <strong>"._W_FORECAST_WINDSPEED.":</strong>\n"
            ."          </td>\n"
            ."          <td style=\"margin: 0px; padding: 0px; text-align: right;\">\n"
            ."            ".$weather->cc_windspeed."&nbsp;".$weather->h_speed."\n"
            ."          </td>\n"
            ."        </tr>\n"
            ."        <tr>\n"
            ."          <td style=\"margin: 0px; padding: 0px; text-align: left;\">\n"
            ."            <strong>"._W_FORECAST_DIRECTION.":</strong>\n"
            ."          </td>\n"
            ."          <td style=\"margin: 0px; padding: 0px; text-align: right;\">\n"
            ."            ".$weather->cc_winddirection."°\n"
            ."          </td>\n"
            ."        </tr>\n"
            ."        <tr>\n"
            ."          <td style=\"margin: 0px; padding: 0px; text-align: left;\">\n"
            ."            <strong>"._W_BAROMETER.":</strong>\n"
            ."          </td>\n"
            ."          <td style=\"margin: 0px; padding: 0px; text-align: right;\">\n"
            ."            ".$weather->cc_barpressure."&nbsp;".$weather->h_pressure."\n"
            ."          </td>\n"
            ."        </tr>\n"
            ."      </table>\n"

            ."    </td>\n"
            ."    <td>\n"
            ."      <div align=\"center\"><img src=\"".$mosConfig_live_site."/components/com_eweather/images/".$weatherIconsStyle."/winddirs_small/wind_".$weather->cc_windtext.".gif\" alt=\"\" border=\"0\"></div>\n"
            ."      <div align=\"center\"><strong>".$weather->cc_windtext."</strong></div>\n"
            ."    </td>\n"
            ."  </tr>\n"
            ."  <tr>\n"
            ."    <td colspan=\"2\" style=\"border-top: 1px solid #CCCCCC; text-align: center; padding-top: 8px; float: none;\" align=\"center\">\n"
            ."      <a class=\"button\" style=\"float: none;\" href=\"index.php?option=com_eweather&Itemid=".$myItemID."\">"._W_MOD_BUTTON."</a>\n"
            ."    </td>\n"
            ."  </tr>\n"
            ."  <tr>\n"
            ."    <td colspan=\"2\" align=\"right\" style=\"padding-top: 15px;\">\n"
            ."      <div align=\"right\"><font class=\"small\">"._W_PROVIDER.":&nbsp;<a href=\"http://www.weather.com\" target=\"blank\">\n"
            ."      <img src=\"".$mosConfig_live_site."/components/com_eweather/images/TWClogo_32px.png\" border=\"0\"></a></div>\n"
            ."    </td>\n"
            ."  </tr>\n"
            ."</table>\n";

  echo $content;
  return;
}

?>