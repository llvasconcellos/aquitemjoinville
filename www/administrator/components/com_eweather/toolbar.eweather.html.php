<?php
/**
* @version $Id: toolbar.eweather.html.php,v 1.1.0 2006/04/30 10:00:00 stingrey Exp $
* @package eWeather
* @subpackage Toolbar eWeather
* @copyright (C) 2000 - 2006 MamboBaer.de (Harald Baer)
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* eWeather is Free Software
*/

/** ensure this file is being included by a parent file */
defined('_VALID_MOS') or die('Direct Access to this location is not allowed.');

class TOOLBAR_eWeather{

  function _LOCATION_MENU() {
    mosMenuBar::startTable();
    mosMenuBar::custom('allLocations', '../components/com_eweather/images/location.png', '../components/com_eweather/images/location_f2.png', 'Locations', false);
    mosMenuBar::spacer();
    mosMenuBar::custom('showConfig', '../components/com_eweather/images/settings.png', '../components/com_eweather/images/settings_f2.png', 'Config', false);
    mosMenuBar::spacer();
    mosMenuBar::custom('about', '../components/com_eweather/images/info.png', '../components/com_eweather/images/info_f2.png', 'About', false);
    mosMenuBar::endTable();
  }
  function _COUNTRY_MENU() {
    mosMenuBar::startTable();
    mosMenuBar::deleteList('', 'removeCity');
    mosMenuBar::spacer();
    mosMenuBar::custom('instLocation', '../components/com_eweather/images/inst_loc.png', '../components/com_eweather/images/inst_loc_f2.png', 'Inst. City', false);
    mosMenuBar::spacer();
    mosMenuBar::divider();
    mosMenuBar::spacer();
    mosMenuBar::divider();
    mosMenuBar::spacer();
    mosMenuBar::custom('allLocations', '../components/com_eweather/images/location.png', '../components/com_eweather/images/location_f2.png', 'Locations', false);
    mosMenuBar::spacer();
    mosMenuBar::custom('showConfig', '../components/com_eweather/images/settings.png', '../components/com_eweather/images/settings_f2.png', 'Config', false);
    mosMenuBar::spacer();
    mosMenuBar::custom('about', '../components/com_eweather/images/info.png', '../components/com_eweather/images/info_f2.png', 'About', false);
    mosMenuBar::endTable();
  }
  function _CONFIG_MENU() {
    mosMenuBar::startTable();
    mosMenuBar::save();
    mosMenuBar::spacer();
    mosMenuBar::custom('instLocation', '../components/com_eweather/images/inst_loc.png', '../components/com_eweather/images/inst_loc_f2.png', 'Inst. City', false);
    mosMenuBar::spacer();
    mosMenuBar::divider();
    mosMenuBar::spacer();
    mosMenuBar::divider();
    mosMenuBar::spacer();
    mosMenuBar::custom('allLocations', '../components/com_eweather/images/location.png', '../components/com_eweather/images/location_f2.png', 'Locations', false);
    mosMenuBar::spacer();
    mosMenuBar::custom('about', '../components/com_eweather/images/info.png', '../components/com_eweather/images/info_f2.png', 'About', false);
    mosMenuBar::endTable();
  }
  function _ABOUT_MENU() {
    mosMenuBar::startTable();
    mosMenuBar::custom('instLocation', '../components/com_eweather/images/inst_loc.png', '../components/com_eweather/images/inst_loc_f2.png', 'Inst. City', false);
    mosMenuBar::spacer();
    mosMenuBar::divider();
    mosMenuBar::spacer();
    mosMenuBar::divider();
    mosMenuBar::spacer();
    mosMenuBar::custom('allLocations', '../components/com_eweather/images/location.png', '../components/com_eweather/images/location_f2.png', 'Locations', false);
    mosMenuBar::spacer();
    mosMenuBar::custom('showConfig', '../components/com_eweather/images/settings.png', '../components/com_eweather/images/settings_f2.png', 'Config', false);
    mosMenuBar::endTable();
  }
  function _DEFAULT() {
    mosMenuBar::startTable();
    mosMenuBar::custom('instLocation', '../components/com_eweather/images/inst_loc.png', '../components/com_eweather/images/inst_loc_f2.png', 'Inst. City', false);
    mosMenuBar::spacer();
    mosMenuBar::divider();
    mosMenuBar::spacer();
    mosMenuBar::divider();
    mosMenuBar::spacer();
    mosMenuBar::custom('showConfig', '../components/com_eweather/images/settings.png', '../components/com_eweather/images/settings_f2.png', 'Config', false);
    mosMenuBar::spacer();
    mosMenuBar::custom('about', '../components/com_eweather/images/info.png', '../components/com_eweather/images/info_f2.png', 'About', false);
    mosMenuBar::endTable();
  }
}

?>