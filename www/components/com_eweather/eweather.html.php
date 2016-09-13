<?php
/**
* @version $Id: eweather.html.php,v 1.1.0 2006/04/30 10:00:00 stingrey Exp $
* @package eWeather
* @subpackage eWeather
* @copyright (C) 2000 - 2006 MamboBaer.de (Harald Baer)
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* eWeather is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

class weather_day {
  var $day_num = null;
  var $day_weekday = null;
  var $day_date = null;
  var $day_temp_max = null;
  var $day_temp_min = null;
  var $day_sunrise = null;
  var $day_sunset = null;
  // Day Part
  var $day_d_icon = null;
  var $day_d_text = null;
  var $day_d_windspeed = null;
  var $day_d_windgust = null;
  var $day_d_winddirection = null;
  var $day_d_windtext = null;
  var $day_d_precipitation = null;
  var $day_d_windtextd = null;
  var $day_d_humidity = null;
  // Night Part
  var $day_n_icon = null;
  var $day_n_text = null;
  var $day_n_windspeed = null;
  var $day_n_windgust = null;
  var $day_n_winddirection = null;
  var $day_n_windtext = null;
  var $day_n_precipitation = null;
  var $day_n_windtextd = null;
  var $day_n_humidity = null;
}

class weather_global {
  // Header Tag Informations
  var $h_temp = null;
  var $h_distance = null;
  var $h_speed = null;
  var $h_precipitation = null;
  var $h_pressure = null;

  var $e_error = null;
  var $n_channels = null;

  // Location Tag Information
  var $loc_city = null;
  var $loc_code = null;
  var $loc_localtime = null;
  var $loc_longitude = null;
  var $loc_latitude = null;
  var $loc_sunrise = null;
  var $loc_sunset = null;
  var $loc_timezone = null;

  // Current Conditions Tag Information
  var $cc_lastupdate = null;
  var $cc_observatory = null;
  var $cc_temp = null;
  var $cc_windchill = null;
  var $cc_text = null;
  var $cc_icon = null;
  var $cc_windspeed = null;
  var $cc_winddirection = null;
  var $cc_windtext = null;
  var $cc_windgust = null;
  var $cc_barpressure = null;
  var $cc_bartext = null;
  var $cc_humidity = null;
  var $cc_uvindex = null;
  var $cc_uvtext = null;
  var $cc_moonicon = null;
  var $cc_moontext = null;
  var $cc_visibility = null;
  var $cc_dewp =null;

  // Forecast Tag Information
  var $dayf_lastupdate = null;
  var $dayf_forecasts = array();

}

class HTML_weather {

  function displayHeader(){
    global $mosConfig_live_site, $Itemid, $database;

    $mname = new mosMenu( $database );
    $mname->load($Itemid);
    echo "<div class=\"componentheading\">".$mname->name."</div><br />\n";
  }

  function displayWeather(&$weather, $weatherIconsStyle){
    global $mosConfig_live_site, $mosConfig_absolute_path;

    $cont_xx = "<table width=\"98%\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\" align=\"center\">\n"
              ."  <tr>\n"
              ."    <td class=\"sectiontableheader\" valign=\"middle\">"
              ."      "._W_ACTUAL."&nbsp;-&nbsp;".$weather->cc_lastupdate."\n"
              ."    </td>\n"
              ."  </tr>\n"
              ."  <tr>\n"
              ."    <td>&nbsp;</td>\n"
              ."  </tr>\n"
              ."  <tr>\n"
              ."    <td>\n"
              ."      <table border=\"0\" width=\"99%\" align=\"center\" cellpadding=\"2\" cellspacing=\"0\">\n"
              ."        <tr>\n"
              ."          <td width=\"33%\"style=\"font-size: 13px; color: #000000; border-left: 1px solid #CCCCCC; border-right: 1px solid #CCCCCC; text-indent: 5px; background: url(".$mosConfig_live_site."/components/com_eweather/images/".$weatherIconsStyle."/subhead.png) repeat-x;\"><b>".$weather->loc_city."</b></td>\n"
              ."          <td>&nbsp;</td>\n"
              ."          <td width=\"33%\"style=\"font-size: 13px; color: #000000; border-left: 1px solid #CCCCCC; border-right: 1px solid #CCCCCC; text-indent: 5px; background: url(".$mosConfig_live_site."/components/com_eweather/images/".$weatherIconsStyle."/subhead.png) repeat-x;\"><b>"._W_WIND."</b></td>\n"
              ."          <td>&nbsp;</td>\n"
              ."          <td width=\"33%\" style=\"font-size: 13px; color: #000000; border-left: 1px solid #CCCCCC; border-right: 1px solid #CCCCCC; text-indent: 5px; background: url(".$mosConfig_live_site."/components/com_eweather/images/".$weatherIconsStyle."/subhead.png) repeat-x;\"><b>"._W_LOC_DATA."</b></td>\n"
              ."        </tr>\n"
              ."        <tr>\n"
              ."          <td valign=\"top\" style=\"border: 1px solid #CCCCCC;\">\n"

              ."            <table border=\"0\" width=\"100%\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\n"
              ."              <tr>\n"
              ."                <td>\n"
              ."                  <div align=\"center\"><img src=\"".$mosConfig_live_site."/components/com_eweather/images/".$weatherIconsStyle."/large/".$weather->cc_icon.".png\" alt=\"\" border=\"0\" /></div>\n"
              ."                  <div style=\"font-size: 13px; font-weight: normal; text-align: center\">".$weather->cc_text."</div>\n"
              ."                </td>\n"
              ."                <td>\n"
              ."                  <div style=\"font-size: 23px; font-weight: bold; text-align: center;\">".$weather->cc_temp."°".$weather->h_temp."</div><br />\n"
              ."                </td>\n"
              ."              </tr>\n"
              ."            </table>\n"
              ."            <table border=\"0\" width=\"100%\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\n"
              ."              <tr>\n"
              ."                <td>\n"
              ."                  <table border=\"0\" width=\"100%\" cellspacing=\"0\" summary=\"\">\n"
              ."                    <tr style=\"background: #DFDFDF;\">\n"
              ."                      <td>\n"
              ."                        <div style=\"font-size: 11px; font-weight: normal; color: #000000; text-align: left;\">"._W_WINDCHILL.":</div>\n"
              ."                      </td>\n"
              ."                      <td>\n"
              ."                        <div style=\"font-size: 11px; font-weight: normal; color: #000000; text-align: right;\">".$weather->cc_windchill."°".$weather->h_temp."</div>\n"
              ."                      </td>\n"
              ."                    </tr>\n"
              ."                    <tr style=\"background: #EFEFEF;\">\n"
              ."                      <td>\n"
              ."                        <div style=\"font-size: 11px; font-weight: normal; color: #000000; text-align: left;\">"._W_SUNRISE.":</div>\n"
              ."                      </td>\n"
              ."                      <td>\n"
              ."                        <div style=\"font-size: 11px; font-weight: normal; color: #000000; text-align: right;\">".$weather->loc_sunrise."</div>\n"
              ."                      </td>\n"
              ."                    </tr>\n"
              ."                    <tr style=\"background: #DFDFDF;\">\n"
              ."                      <td>\n"
              ."                        <div style=\"font-size: 11px; font-weight: normal; color: #000000; text-align: left;\">"._W_SUNSET.":</div>\n"
              ."                      </td>\n"
              ."                      <td>\n"
              ."                        <div style=\"font-size: 11px; font-weight: normal; color: #000000; text-align: right;\">".$weather->loc_sunset."</div>\n"
              ."                      </td>\n"
              ."                    </tr>\n"
              ."                  </table>\n"
              ."                </td>\n"
              ."                <td>\n"
              ."                 <div align=\"center\"><img src=\"".$mosConfig_live_site."/components/com_eweather/images/".$weatherIconsStyle."/moon/".$weather->cc_moonicon.".gif\" border=\"0\" alt=\"\" /><br />".$weather->cc_moontext."</div>\n"
              ."                </td>\n"
              ."              </tr>\n"
              ."            </table>\n"
              ."          </td>\n"

              ."          <td>&nbsp;</td>\n"

              ."          <td valign=\"top\" style=\"border: 1px solid #CCCCCC\">\n"

              ."            <table border=\"0\" width=\"100%\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\n"
              ."              <tr>\n"
              ."                <td>\n"
              ."                  <div align=\"center\"><img src=\"".$mosConfig_live_site."/components/com_eweather/images/".$weatherIconsStyle."/winddirs/wind_".$weather->cc_windtext.".gif\" alt=\"\" border=\"0\" /></div>\n"
              ."                </td>\n"
              ."                <td>\n"
              ."                  <div style=\"font-size: 23px; font-weight: bold; text-align: center;\">".$weather->cc_windtext."</div><br />\n"
              ."                </td>\n"
              ."              </tr>\n"
              ."            </table><br />\n"
              ."            <table border=\"0\" width=\"100%\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\n"
              ."              <tr>\n"
              ."                <td valign=\"middle\">\n"

              ."                  <table border=\"0\" width=\"80%\" cellspacing=\"0\" align=\"center\">\n"
              ."                    <tr style=\"background: #DFDFDF;\">\n"
              ."                      <td>\n"
              ."                        <div style=\"font-size: 11px; font-weight: normal; color: #000000; text-align: left;\">"._W_WINDSPEED.":</div>\n"
              ."                      </td>\n"
              ."                      <td>\n"
              ."                        <div style=\"font-size: 11px; font-weight: normal; color: #000000; text-align: right;\">".$weather->cc_windspeed."&nbsp;".$weather->h_speed."</div>\n"
              ."                      </td>\n"
              ."                    </tr>\n"
              ."                    <tr style=\"background: #EFEFEF;\">\n"
              ."                      <td>\n"
              ."                        <div style=\"font-size: 11px; font-weight: normal; color: #000000; text-align: left;\">"._W_WINDDIR.":</div>\n"
              ."                      </td>\n"
              ."                      <td>\n"
              ."                        <div style=\"font-size: 11px; font-weight: normal; color: #000000; text-align: right;\">".$weather->cc_winddirection."°</div>\n"
              ."                      </td>\n"
              ."                    </tr>\n"
              ."                    <tr style=\"background: #DFDFDF;\">\n"
              ."                      <td>\n"
              ."                        <div style=\"font-size: 11px; font-weight: normal; color: #000000; text-align: left;\">"._W_WINDGUST.":</div>\n"
              ."                      </td>\n"
              ."                      <td>\n"
              ."                        <div style=\"font-size: 11px; font-weight: normal; color: #000000; text-align: right;\">".$weather->cc_windgust."&nbsp;".$weather->h_speed."</div>\n"
              ."                      </td>\n"
              ."                    </tr>\n"
              ."                  </table>\n"

              ."                </td>\n"
              ."              </tr>\n"
              ."            </table>\n"


              ."          </td>\n"

              ."          <td>&nbsp;</td>\n"

              ."          <td valign=\"top\" style=\"border: 1px solid #CCCCCC;\">\n"

              ."            <br />\n"
              ."            <table border=\"0\" width=\"98%\" cellspacing=\"0\" align=\"center\" summary=\"\">\n"
              ."              <tr style=\"background: #DFDFDF;\">\n"
              ."                <td>\n"
              ."                  <div style=\" color: #000000;\">"._W_OBST.":</div>\n"
              ."                </td>\n"
              ."                <td style=\"text-align: right; color: #000000;\">\n"
              ."                ".$weather->cc_observatory."\n"
              ."                </td>\n"
              ."              </tr>\n"
              ."              <tr style=\"background: #EFEFEF;\">\n"
              ."                <td>\n"
              ."                  <div style=\" color: #000000;\">"._W_LAT.":</div>\n"
              ."                </td>\n"
              ."                <td style=\"text-align: right; color: #000000;\">\n"
              ."                ".$weather->loc_latitude."\n"
              ."                </td>\n"
              ."              </tr>\n"
              ."              <tr style=\"background: #DFDFDF;\">\n"
              ."                <td>\n"
              ."                  <div style=\" color: #000000;\">"._W_LON.":</div>\n"
              ."                </td>\n"
              ."                <td style=\"text-align: right; color: #000000;\">\n"
              ."                ".$weather->loc_longitude."\n"
              ."                </td>\n"
              ."              </tr>\n"
              ."              <tr style=\"background: #EFEFEF;\">\n"
              ."                <td>\n"
              ."                  <div style=\" color: #000000;\">"._W_DEWP.":</div>\n"
              ."                </td>\n"
              ."                <td style=\"text-align: right; color: #000000;\">\n"
              ."                ".$weather->cc_dewp."°".$weather->h_temp."\n"
              ."                </td>\n"
              ."              </tr>\n"
              ."              <tr style=\"background: #DFDFDF;\">\n"
              ."                <td>\n"
              ."                  <div style=\" color: #000000;\">"._W_VISIBILITY.":</div>\n"
              ."                </td>\n"
              ."                <td style=\"text-align: right; color: #000000;\">\n"
              ."                ".$weather->cc_visibility."&nbsp;".$weather->h_distance."\n"
              ."                </td>\n"
              ."              </tr>\n"
              ."              <tr style=\"background: #EFEFEF; color: #000000;\">\n"
              ."                <td>\n"
              ."                  <div style=\" color: #000000;\">"._W_HUMIDITY.":</div>\n"
              ."                </td>\n"
              ."                <td style=\"text-align: right; color: #000000;\">\n"
              ."                ".$weather->cc_humidity."%\n"
              ."                </td>\n"
              ."              </tr>\n"
              ."              <tr style=\"background: #DFDFDF;\">\n"
              ."                <td>\n"
              ."                  <div style=\" color: #000000;\">"._W_PRESSURE.":</div>\n"
              ."                </td>\n"
              ."                <td style=\"text-align: right; color: #000000;\">\n"
              ."                ".$weather->cc_barpressure."&nbsp;".$weather->h_pressure."&nbsp;(".$weather->cc_bartext.")\n"
              ."                </td>\n"
              ."              </tr>\n"
              ."            </table>\n"
              ."            <br />\n"
              ."            <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"174\" align=\"center\" summary=\"\">\n"
              ."            <tbody>\n"
              ."              <tr>\n"
              ."                <td colspan=\"4\" style=\"height: 2px;\"></td>\n"
              ."              </tr>\n"
              ."              <tr>\n"
              ."                <td colspan=\"4\" valign=\"top\">\n"
              ."                  <face=\"verdana\" size=\"1\">&nbsp;<b>"._W_UV_INDEX."&nbsp;(".$weather->cc_uvindex.")</b></font>\n"
              ."                </td>\n"
              ."              </tr>\n"
              ."              <tr>\n"
              ."                <td rowspan=\"3\" style=\"height: 3px; width: 4px;\"></td>\n"
              ."              </tr>\n"
              ."              <tr>\n"
              ."                <td colspan=\"4\" height=\"4\">\n"
              ."                  <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"height: 2; \" summary=\"\">\n"
              ."                  <tbody>\n"
              ."                    <tr>\n";

              for ($y = 0; $y < 11; $y++) {
                 if($weather->cc_uvindex != $y){
                    $cont_xx.= "          <td width=\"15\"></td>\n";
                 } else {
                    $cont_xx.= "          <td width=\"15\"><img src=\"".$mosConfig_live_site."/components/com_eweather/images/".$weatherIconsStyle."/arrow.gif\" height=\"6\" width=\"6\" alt=\"\" /></td>\n";
                 }
              }


    $cont_xx.= "        </tr>\n"
              ."        </tbody>\n"
              ."      </table>\n"
              ."    </td>\n"
              ."  </tr>\n"
              ."  <tr>\n"
              ."    <td colspan=\"4\" height=\"4\">\n"
              ."      <img src=\"".$mosConfig_live_site."/components/com_eweather/images/".$weatherIconsStyle."/uvkey.gif\" height=\"10\" width=\"166\" alt=\"\" />\n"
              ."    </td>\n"
              ."  </tr>\n"
              ."  <tr>\n"
              ."    <td colspan=\"4\" style=\"height: 1px;\"></td>\n"
              ."  </tr>\n"
              ."  <tr>\n"
              ."    <td rowspan=\"3\" style=\"width: 4px;\"></td>\n"
              ."  </tr>\n"
              ."  <tr>\n"
              ."    <td width=\"42\"><face=\"Verdana,sans-serif\" size=\"-2\">"._W_UV_LOW."</font></td>\n"
              ."    <td width=\"42\"><face=\"Verdana,sans-serif\" size=\"-2\">"._W_UV_MED."</font></td>\n"
              ."    <td width=\"42\"><face=\"Verdana,sans-serif\" size=\"-2\">"._W_UV_HIGH."</font></td>\n"
              ."    <td width=\"42\"><face=\"Verdana,sans-serif\" size=\"-2\">"._W_UV_SHIGH."</font></td>\n"
              ."  </tr>\n"
              ."  <tr>\n"
              ."    <td width=\"42\"><face=\"Verdana,sans-serif\" size=\"-2\">0</font></td>\n"
              ."    <td width=\"42\"><face=\"Verdana,sans-serif\" size=\"-2\">&nbsp;</font></td>\n"
              ."    <td width=\"42\"><face=\"Verdana,sans-serif\" size=\"-2\">&nbsp;</font></td>\n"
              ."    <td width=\"42\" align=\"right\" style=\"text-align: right;\"><face=\"Verdana,sans-serif\" size=\"-2\">+10</font></td>\n"
              ."  </tr>\n"
              ."  <tr>\n"
              ."    <td colspan=\"4\" style=\"height: 6px;\"></td>\n"
              ."  </tr>\n"
              ."  </tbody>\n"
              ."</table>\n"

              ."          </td>\n"

              ."        </tr>\n"
              ."      </table>\n"
              ."    </td>\n"
              ."  </tr>\n"
              ."</table><br /><br />\n";

    echo $cont_xx;
  }


  function displayForecast(&$weather, $weatherIconsStyle, $date_format){
    global $mosConfig_live_site, $Itemid;

    $day_counter = count($weather->dayf_forecasts);
    $content = "<table width=\"98%\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\" align=\"center\" summary=\"\">\n"
              ."  <tr>"
              ."    <td class=\"sectiontableheader\" valign=\"middle\">"
              ."      "._W_FORECAST."&nbsp;-&nbsp;".$weather->dayf_lastupdate."\n"
              ."    </td>\n"
              ."  </tr>\n"
              ."  <tr>\n"
              ."    <td>\n"
              ."      <br />\n"
              ."      <table border=\"0\" cellspacing=\"1\" cellpadding=\"1\" align=\"center\" summary=\"\">\n"
              ."        <tr>\n";

    for ($x = 0; $x < $day_counter; $x++) {
    $v = strftime($date_format, strtotime($weather->dayf_forecasts[$x]->day_date));
    $content.= "          <td>\n"
              ."      <table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" summary=\"\">\n"
              ."        <tr>\n"
              //  background=\"".$mosConfig_live_site."/components/com_eweather/images/".$weatherIconsStyle."/subhead.png\"
              ."          <td style=\" border-left: 1px solid #CCCCCC; border-right: 1px solid #CCCCCC; background: url(".$mosConfig_live_site."/components/com_eweather/images/".$weatherIconsStyle."/subhead.png) repeat-x;\" height=\"19\" colspan=\"2\">\n"
              //  valign=\"absmiddle\"
              ."            <div style=\"font-weight: bold; text-align: center; color: #000000; border: 0px; vertical-align: bottom;\">\n"
              ."              <a href=\"index.php?option=com_eweather&amp;Itemid=".$Itemid."&amp;detail_view=".$x."\" title=\""._W_FORECAST_FTITLE."\">\n"
              ."              <img src=\"".$mosConfig_live_site."/components/com_eweather/images/".$weatherIconsStyle."/plus.gif\" align=\"left\" border=\"0\" alt=\"\" />\n"
              ."              </a>\n"
              ."            ".$v."</div>\n"
              ."          </td>\n"
              ."        </tr>\n"
              ."        <tr>\n"
              ."          <td style=\"border-left: 1px solid #CCCCCC; border-right: 1px solid #CCCCCC;\">\n"
              ."            <div style=\"font-weight: bold; text-align: center;\">"._W_FORECAST_DAY."</div>\n"
              ."          </td>\n"
              ."          <td style=\"border-right: 1px solid #CCCCCC;\">\n"
              ."            <div style=\"font-weight: bold; text-align: center;\">"._W_FORECAST_NIGHT."</div>\n"
              ."          </td>\n"
              ."        <tr>\n"
              ."          <td style=\"border-left: 1px solid #CCCCCC; border-right: 1px solid #CCCCCC; border-bottom: 1px solid #CCCCCC;\">\n"
              ."            <div align=\"center\"><img src=\"".$mosConfig_live_site."/components/com_eweather/images/".$weatherIconsStyle."/small/".$weather->dayf_forecasts[$x]->day_d_icon.".png\" border=\"0\" alt=\"\" /><br /></div>\n"
              ."          </td>\n"
              ."          <td style=\"border-right: 1px solid #CCCCCC; border-bottom: 1px solid #CCCCCC;\">\n"
              ."            <div align=\"center\"><img src=\"".$mosConfig_live_site."/components/com_eweather/images/".$weatherIconsStyle."/small/".$weather->dayf_forecasts[$x]->day_n_icon.".png\" border=\"0\" alt=\"\" /><br /></div>\n"
              ."          </td>\n"
              ."        </tr>\n"
              ."        <tr>\n"
              ."          <td style=\"border-left: 1px solid #CCCCCC; border-right: 1px solid #CCCCCC;\" colspan=\"2\">\n"
              ."            <div style=\"font-weight: bold; text-align: center; color: #000000; background: #EFEFEF;\">"._W_FORECAST_TEMP."</div>\n"
              ."          </td>\n"
              ."        </tr>\n"
              ."        <tr>\n"
              ."          <td style=\"border-left: 1px solid #CCCCCC; border-right: 1px solid #CCCCCC; border-bottom: 1px solid #CCCCCC;\">\n"
              ."            <div align=\"center\">"._W_FORECAST_TEMP_MAX.": ".$weather->dayf_forecasts[$x]->day_temp_max."°".$weather->h_temp."<br /></div>\n"
              ."          </td>\n"
              ."          <td style=\"border-right: 1px solid #CCCCCC; border-bottom: 1px solid #CCCCCC;\">\n"
              ."            <div align=\"center\">"._W_FORECAST_TEMP_MIN.": ".$weather->dayf_forecasts[$x]->day_temp_min."°".$weather->h_temp."<br /></div>\n"
              ."          </td>\n"
              ."        </tr>\n"
              ."        <tr>\n"
              ."          <td style=\"border-left: 1px solid #CCCCCC; border-right: 1px solid #CCCCCC;\" colspan=\"2\">\n"
              ."            <div style=\"font-weight: bold; text-align: center; color: #000000; background: #EFEFEF;\">"._W_FORECAST_RAIN."</div>\n"
              ."          </td>\n"
              ."        </tr>\n"
              ."        <tr>\n"
              ."          <td style=\"border-left: 1px solid #CCCCCC; border-right: 1px solid #CCCCCC; border-bottom: 1px solid #CCCCCC;\">\n"
              ."            <div align=\"center\">".$weather->dayf_forecasts[$x]->day_d_precipitation."%<br /></div>\n"
              ."          </td>\n"
              ."          <td style=\"border-right: 1px solid #CCCCCC; border-bottom: 1px solid #CCCCCC;\">\n"
              ."            <div align=\"center\">".$weather->dayf_forecasts[$x]->day_n_precipitation."%<br /></div>\n"
              ."          </td>\n"
              ."        </tr>\n"
              ."      </table>\n";
              if ($x == 4) {
                  $content.= "</td></tr><tr><td colspan=\"15\" height=\"10\"></td></tr><tr>";
              } elseif ($x != $day_counter-1) {
                  $content.= "<td width=\"15\"></td>";
              }
    }

    $content.= "    </tr></table>\n"
              ."    </td>\n"
              ."  </tr>\n"
              ."</table>\n";
    echo $content;
  }

  function displayDetailForecast(&$weather, $weatherIconsStyle, $lastUpdate, $metric_v, $metric_t, $date_format){
    global $mosConfig_live_site, $Itemid;

    $v = strftime($date_format, strtotime($weather->day_date));
    $content = "<table width=\"98%\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\" align=\"center\" summary=\"\">\n"
              ."  <tr>"
              ."    <td class=\"sectiontableheader\" valign=\"middle\">"
              ."      "._W_FORECAST."&nbsp;-&nbsp;".$lastUpdate."\n"
              ."    </td>\n"
              ."  </tr>\n"
              ."  <tr>\n"
              ."    <td>\n"
              ."      <br />\n"
              ."      <table width=\"70%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" summary=\"\">\n"
              ."        <tr>\n"
              ."          <td background=\"".$mosConfig_live_site."/components/com_eweather/images/".$weatherIconsStyle."/subhead.png\" style=\"font-size: 13px; color: #000000; border-left: 1px solid #CCCCCC; border-right: 1px solid #CCCCCC; text-indent: 5px;\">\n"
              ."            <div style=\"font-weight: bold; text-align: center; color: #000000; border: 0px; vertical-align: bottom;\" valign=\"absmiddle\">\n"
              ."              <a href=\"index.php?option=com_eweather&amp;Itemid=".$Itemid."\" title=\""._W_FORECAST_BACK."\">\n"
              ."              <img src=\"".$mosConfig_live_site."/components/com_eweather/images/".$weatherIconsStyle."/minus.gif\" align=\"left\" border=\"0\" alt=\"\" />\n"
              ."              </a>\n"
              ."            </div>\n"
              ."            <b>"._W_FORECAST."&nbsp;"._W_FORECAST_FOR."&nbsp;".$v."</b>\n"
              ."          </td>\n"
              ."        </tr>\n"
              ."        <tr>\n"
              ."          <td style=\"border-left: 1px solid #CCCCCC; border-right: 1px solid #CCCCCC; border-bottom: 1px solid #CCCCCC;\">\n"
              ."            <br />\n"
              ."            <table width=\"98%\" align=\"center\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\" summary=\"\">\n"
              ."              <tr>\n"
              ."                <td colspan=\"2\" align=\"center\" style=\"padding-bottom: 5px; border-bottom: 1px solid #CCCCCC;\">\n"

              ."            <table border=\"0\" width=\"290\" cellspacing=\"0\" align=\"center\" cellpadding=\"2\" cellspacing=\"5\" summary=\"\">\n"
              ."              <tr style=\"background: #DFDFDF;\">\n"
              ."                <td>\n"
              ."                  <div style=\"font-size: 11px; font-weight: normal; color: #000000; text-align: left;\">"._W_FORECAST_TEMP_D_MAX.":</div>\n"
              ."                </td>\n"
              ."                <td>\n"
              ."                  <div style=\"font-size: 11px; font-weight: normal; color: #000000; text-align: right;\">".$weather->day_temp_max."°".$metric_t."</div>\n"
              ."                </td>\n"
              ."                <td>\n"
              ."                  <div style=\"font-size: 11px; font-weight: normal; color: #000000; text-align: left;\">"._W_SUNRISE.":</div>\n"
              ."                </td>\n"
              ."                <td>\n"
              ."                  <div style=\"font-size: 11px; font-weight: normal; color: #000000; text-align: right;\">".$weather->day_sunrise."</div>\n"
              ."                </td>\n"
              ."              </tr>\n"
              ."              <tr style=\"background: #EFEFEF;\">\n"
              ."                <td>\n"
              ."                  <div style=\"font-size: 11px; font-weight: normal; color: #000000; text-align: left;\">"._W_FORECAST_TEMP_D_MIN.":</div>\n"
              ."                </td>\n"
              ."                <td>\n"
              ."                  <div style=\"font-size: 11px; font-weight: normal; color: #000000; text-align: right;\">".$weather->day_temp_min."°".$metric_t."</div>\n"
              ."                </td>\n"
              ."                <td>\n"
              ."                  <div style=\"font-size: 11px; font-weight: normal; color: #000000; text-align: left;\">"._W_SUNSET.":</div>\n"
              ."                </td>\n"
              ."                <td>\n"
              ."                  <div style=\"font-size: 11px; font-weight: normal; color: #000000; text-align: right;\">".$weather->day_sunset."</div>\n"
              ."                </td>\n"
              ."              </tr>\n"
              ."            </table>\n"


              ."                </td>\n"
              ."              </tr>\n"
              ."              <tr>\n"
              ."                <td align=\"center\">\n"
              ."                  <div align=\"center\"><b>"._W_FORECAST_D_DAY."</b></div>\n"
              ."                </td>\n"
              ."                <td align=\"center\">\n"
              ."                  <div align=\"center\"><b>"._W_FORECAST_D_NIGHT."</b></div>\n"
              ."                </td>\n"
              ."              </tr>\n"
              ."              <tr>\n"
              ."                <td width=\"50%\" valign=\"top\">\n"

              ."                  <table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\" summary=\"\">\n"
              ."                    <tr>\n"
              ."                      <td width=\"50%\" height=\"140\">\n"
              ."                        <div align=\"center\"><img src=\"".$mosConfig_live_site."/components/com_eweather/images/".$weatherIconsStyle."/large/".$weather->day_d_icon.".png\" border=\"0\" alt=\"\" /><br /></div>\n"
              ."                      </td>\n"
              ."                      <td width=\"50%\" height=\"140\" valign=\"middle\">\n"
              ."                        <div style=\"font-size: 13px; font-weight: bold; text-align: center; vertical-align: top;\">".$weather->day_d_text."<br /><br /></div>\n"

              ."            <table border=\"0\" width=\"100%\" cellspacing=\"0\" summary=\"\">\n"
              ."              <tr style=\"background: #DFDFDF;\">\n"
              ."                <td>\n"
              ."                  <div style=\"font-size: 11px; font-weight: normal; color: #000000; text-align: left;\">"._W_FORECAST_D_RAIN.":</div>\n"
              ."                </td>\n"
              ."                <td>\n"
              ."                  <div style=\"font-size: 11px; font-weight: normal; color: #000000; text-align: right;\">".$weather->day_d_precipitation."%</div>\n"
              ."                </td>\n"
              ."              </tr>\n"
              ."              <tr style=\"background: #EFEFEF;\">\n"
              ."                <td>\n"
              ."                  <div style=\"font-size: 11px; font-weight: normal; color: #000000; text-align: left;\">"._W_HUMIDITY.":</div>\n"
              ."                </td>\n"
              ."                <td>\n"
              ."                  <div style=\"font-size: 11px; font-weight: normal; color: #000000; text-align: right;\">".$weather->day_d_humidity."%</div>\n"
              ."                </td>\n"
              ."              </tr>\n"
              ."            </table>\n"


              ."                      </td>\n"
              ."                    </tr>\n"
              ."                    <tr>\n"
              ."                      <td width=\"50%\" height=\"140\" valign=\"middle\">\n"
              ."                        <div style=\"font-size: 13px; font-weight: bold; text-align: center; vertical-align: top;\">".$weather->day_d_windtext."<br /><br /></div>\n"



              ."            <table border=\"0\" width=\"100%\" cellspacing=\"0\" summary=\"\">\n"
              ."              <tr style=\"background: #DFDFDF;\">\n"
              ."                <td>\n"
              ."                  <div style=\"font-size: 11px; font-weight: normal; color: #000000; text-align: left;\">"._W_WINDSPEED.":</div>\n"
              ."                </td>\n"
              ."                <td>\n"
              ."                  <div style=\"font-size: 11px; font-weight: normal; color: #000000; text-align: right;\">".$weather->day_d_windspeed."&nbsp;".$metric_v."</div>\n"
              ."                </td>\n"
              ."              </tr>\n"
              ."              <tr style=\"background: #EFEFEF;\">\n"
              ."                <td>\n"
              ."                  <div style=\"font-size: 11px; font-weight: normal; color: #000000; text-align: left;\">"._W_WINDDIR.":</div>\n"
              ."                </td>\n"
              ."                <td>\n"
              ."                  <div style=\"font-size: 11px; font-weight: normal; color: #000000; text-align: right;\">".$weather->day_d_winddirection."°</div>\n"
              ."                </td>\n"
              ."              </tr>\n"
              ."              <tr style=\"background: #DFDFDF;\">\n"
              ."                <td>\n"
              ."                  <div style=\"font-size: 11px; font-weight: normal; color: #000000; text-align: left;\">"._W_WINDGUST.":</div>\n"
              ."                </td>\n"
              ."                <td>\n"
              ."                  <div style=\"font-size: 11px; font-weight: normal; color: #000000; text-align: right;\">".$weather->day_d_windgust."&nbsp;".$metric_v."</div>\n"
              ."                </td>\n"
              ."              </tr>\n"
              ."            </table>\n"

              ."                      </td>\n"
              ."                      <td width=\"50%\" height=\"140\">\n"
              ."                        <div align=\"center\"><img src=\"".$mosConfig_live_site."/components/com_eweather/images/".$weatherIconsStyle."/winddirs/wind_".$weather->day_d_windtext.".gif\" border=\"0\" alt=\"\" /><br /></div>\n"
              ."                      </td>\n"
              ."                    </tr>\n"
              ."                  </table>\n"
              ."                </td>\n"
              ."                <td width=\"50%\" valign=\"top\" style=\"border-left: 1px solid #CCCCCC; margin-left: 3px;\">\n"
              ."                  <table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\" summary=\"\">\n"
              ."                    <tr>\n"
              ."                      <td width=\"50%\" height=\"140\">\n"
              ."                        <div align=\"center\"><img src=\"".$mosConfig_live_site."/components/com_eweather/images/".$weatherIconsStyle."/large/".$weather->day_n_icon.".png\" border=\"0\" alt=\"\" /><br /></div>\n"
              ."                      </td>\n"
              ."                      <td width=\"50%\" height=\"140\" valign=\"middle\">\n"
              ."                        <div style=\"font-size: 13px; font-weight: bold; text-align: center; vertical-align: top;\">".$weather->day_n_text."<br /><br /></div>\n"


              ."            <table border=\"0\" width=\"100%\" cellspacing=\"0\" summary=\"\">\n"
              ."              <tr style=\"background: #DFDFDF;\">\n"
              ."                <td>\n"
              ."                  <div style=\"font-size: 11px; font-weight: normal; color: #000000; text-align: left;\">"._W_FORECAST_D_RAIN.":</div>\n"
              ."                </td>\n"
              ."                <td>\n"
              ."                  <div style=\"font-size: 11px; font-weight: normal; color: #000000; text-align: right;\">".$weather->day_n_precipitation."%</div>\n"
              ."                </td>\n"
              ."              </tr>\n"
              ."              <tr style=\"background: #EFEFEF;\">\n"
              ."                <td>\n"
              ."                  <div style=\"font-size: 11px; font-weight: normal; color: #000000; text-align: left;\">"._W_HUMIDITY.":</div>\n"
              ."                </td>\n"
              ."                <td>\n"
              ."                  <div style=\"font-size: 11px; font-weight: normal; color: #000000; text-align: right;\">".$weather->day_n_humidity."%</div>\n"
              ."                </td>\n"
              ."              </tr>\n"
              ."            </table>\n"



              ."                      </td>\n"
              ."                    </tr>\n"
              ."                    <tr>\n"
              ."                      <td width=\"50%\" height=\"140\">\n"
              ."                        <div style=\"font-size: 13px; font-weight: bold; text-align: center; vertical-align: top;\">".$weather->day_n_windtext."<br /><br /></div>\n"

              ."            <table border=\"0\" width=\"100%\" cellspacing=\"0\" summary=\"\">\n"
              ."              <tr style=\"background: #DFDFDF;\">\n"
              ."                <td>\n"
              ."                  <div style=\"font-size: 11px; font-weight: normal; color: #000000; text-align: left;\">"._W_WINDSPEED.":</div>\n"
              ."                </td>\n"
              ."                <td>\n"
              ."                  <div style=\"font-size: 11px; font-weight: normal; color: #000000; text-align: right;\">".$weather->day_n_windspeed."&nbsp;".$metric_v."</div>\n"
              ."                </td>\n"
              ."              </tr>\n"
              ."              <tr style=\"background: #EFEFEF;\">\n"
              ."                <td>\n"
              ."                  <div style=\"font-size: 11px; font-weight: normal; color: #000000; text-align: left;\">"._W_WINDDIR.":</div>\n"
              ."                </td>\n"
              ."                <td>\n"
              ."                  <div style=\"font-size: 11px; font-weight: normal; color: #000000; text-align: right;\">".$weather->day_n_winddirection."°</div>\n"
              ."                </td>\n"
              ."              </tr>\n"
              ."              <tr style=\"background: #DFDFDF;\">\n"
              ."                <td>\n"
              ."                  <div style=\"font-size: 11px; font-weight: normal; color: #000000; text-align: left;\">"._W_WINDGUST.":</div>\n"
              ."                </td>\n"
              ."                <td>\n"
              ."                  <div style=\"font-size: 11px; font-weight: normal; color: #000000; text-align: right;\">".$weather->day_n_windgust."&nbsp;".$metric_v."</div>\n"
              ."                </td>\n"
              ."              </tr>\n"
              ."            </table>\n"

              ."                      </td>\n"
              ."                      <td width=\"50%\" height=\"140\">\n"
              ."                        <div align=\"center\"><img src=\"".$mosConfig_live_site."/components/com_eweather/images/".$weatherIconsStyle."/winddirs/wind_".$weather->day_n_windtext.".gif\" border=\"0\" alt=\"\" /><br /></div>\n"
              ."                      </td>\n"
              ."                    </tr>\n"
              ."                  </table>\n"
              ."                </td>\n"
              ."              </tr>\n"
              ."            </table>\n"
              ."            <br />\n"
              ."          </td>\n"
              ."        </tr>\n"
              ."      </table>\n"
              ."    </td>\n"
              ."  </tr>\n"
              ."</table>\n";
    echo $content;

  }

  function displayLocationForm(&$lists, $option){
    global $mosConfig_live_site, $my, $database, $Itemid;

    $mname = new mosMenu( $database );
    $mname->load($Itemid);
    $content = "<div class=\"componentheading\">".$mname->name."&nbsp;-&nbsp;"._W_SELECT_LOCATION."</div><br />\n";
    if($my->id == 0){
      $content.= "Sie haben keine Berechtigung!!\n";
    } else {
      $content.= "<form action=\"index.php?option=com_eweather&amp;Itemid=".$Itemid."&amp;task=profiles\" method=\"post\" name=\"locationForm\">\n"
                ."<table width=\"50%\" border=\"0\" cellspacing=\"1\" cellpadding=\"5\" align=\"center\" summary=\"\">\n"
                ."  <tr>\n"
                ."    <td width=\"30%\" style=\"border-bottom: 1px solid #CCCCCC\">\n"
                ."      "._WEATHER_REGION.":\n"
                ."    </td>\n"
                ."    <td style=\"border-bottom: 1px solid #CCCCCC\">\n"
                ."      ".$lists['regions']."\n"
                ."    </td>\n"
                ."  </tr>\n"

                ."  <tr>\n"
                ."    <td width=\"30%\" style=\"border-bottom: 1px solid #CCCCCC\">\n"
                ."      "._WEATHER_COUNTRY.":\n"
                ."    </td>\n"
                ."    <td style=\"border-bottom: 1px solid #CCCCCC\">\n"
                ."      ".$lists['countries']."\n"
                ."    </td>\n"
                ."  </tr>\n"

                ."  <tr>\n"
                ."    <td width=\"30%\" style=\"border-bottom: 1px solid #CCCCCC\">\n"
                ."      "._WEATHER_CITY.":\n"
                ."    </td>\n"
                ."    <td style=\"border-bottom: 1px solid #CCCCCC\">\n"
                ."      ".$lists['cities']."\n"
                ."    </td>\n"
                ."  </tr>\n"
                ."  <tr align\"center\">\n"
                ."    <td colspan=\"1\" align=\"center\">\n"
                ."      <input type=\"SUBMIT\" name=\"save_button\" value=\""._WEATHER_SAVE_BUTTON."\" class=\"button\" align=\"center\">\n"
                ."    </td>\n"
                ."    <td colspan=\"1\" align=\"center\">\n"
                ."      <input type=\"SUBMIT\" name=\"cancel_button\" value=\""._WEATHER_CANCEL_BUTTON."\" class=\"button\" align=\"center\">\n"
                ."    </td>\n"
                ."  </tr>\n"
                ."</table>\n"
                ."<input type=\"hidden\" name=\"option\" value=\"".$option."\">\n"
                ."<input type=\"hidden\" name=\"task\" value=\"profiles\">\n"
                ."<input type=\"hidden\" name=\"act\" value=\"\">\n"
                ."</form>\n";
    }
    echo $content;
  }

  function displayErrorMessage($error_title, $error_descr, $error_msg){
    global $mosConfig_live_site;

    $content = "<table width=\"50%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" summary=\"\">\n"
              ."  <tr>\n"
              ."    <td style=\"border-left: 1px solid #000070; border-right: 1px solid #000070;\" align=\"center\" background=\"".$mosConfig_live_site."/components/com_eweather/images/tbl_error.png\" height=\"22\">\n"
              ."      <div align=\"center\" style=\"color: #FFFFFF; font-weight: bold;\">.::&nbsp;".$error_title."&nbsp;::.</div>\n"
              ."    </td>\n"
              ."  </tr>\n"
              ."  <tr>\n"
              ."    <td style=\"border-left: 1px solid #000070; border-right: 1px solid #000070; border-bottom: 1px solid #000070;\">\n"
              ."      <table width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"5\" cellpadding=\"5\" summary=\"\">\n"
              ."        <tr>\n"
              ."          <td>\n"
              ."            <div style=\"font-weight: bold;\">".$error_descr.":</div><br />\n"
              ."            <div style=\"text-indent: 0px;\">".$error_msg."</div><br />\n"
              ."          </td>\n"
              ."        </tr>\n"
              ."      </table>\n"
              ."    </td>\n"
              ."  </tr>\n"
              ."</table>\n";

    echo $content;
  }

  function showProvider(){
    global $mosConfig_live_site, $my, $Itemid;

    $content = "<br /><table width=\"98%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n"
              ."  <tr>\n";
    if ($my->id > "0"){
       $content.= "    <td valign=\"bottom\" align=\"left\" style=\"border-top: 1px solid #cccccc; margin-top: 2px; padding-top: 5px; padding-bottom: 5px; text-align: left;\">\n"
                 ."      <div align=\"left\"><a class=\"back_button\" href=\"index.php?option=com_eweather&amp;Itemid=".$Itemid."&amp;task=profiles\">"._W_SELECT_LOCATION."</a></div>\n"
                 ."    </td>\n";
    }
    $content.= "    <td align=\"right\" style=\"border-top: 1px solid #cccccc; margin-top: 2px; padding-top: 5px; padding-bottom: 5px; text-align: right;\">\n"
              ."      <div align=\"right\"><font class=\"small\">"._W_PROVIDER.":&nbsp;<a href=\"http://www.weather.com\" target=\"blank\">\n"
              ."      <img src=\"".$mosConfig_live_site."/components/com_eweather/images/TWClogo_64px.png\" border=\"0\" alt=\"www.weather.com\" /></a>\n"
              ."      </font></div>\n"
              ."    </td>\n"
              ."  </tr>\n"
              ."</table>\n";

    echo $content;
  }

  function showFooter(){
    global $weatherVersion;

     echo "<p align='center'><font class='small'><a href='http://www.mambobaer.de' target='blank'>eWeather ".$weatherVersion."</a> - &copy; 2005 by <a href='http://www.mambobaer.de' target='blank'>MamboBaer</a></p>";
  }

}
?>