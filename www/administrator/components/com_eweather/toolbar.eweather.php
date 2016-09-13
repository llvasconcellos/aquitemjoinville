<?php
/**
* @version $Id: toolbar.eweather.php,v 1.1.0 2006/04/30 10:00:00 stingrey Exp $
* @package eWeather
* @subpackage Toolbar eWeather
* @copyright (C) 2000 - 2006 MamboBaer.de (Harald Baer)
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* eWeather is Free Software
*/

/** ensure this file is being included by a parent file */
defined('_VALID_MOS') or die('Direct Access to this location is not allowed.');

require_once($mainframe->getPath('toolbar_html'));
require_once($mainframe->getPath('toolbar_default'));

switch ($task) {

  case "location":
    TOOLBAR_eWeather::_LOCATION_MENU();
    break;
  case "instLocation":
    TOOLBAR_eWeather::_LOCATION_MENU();
    break;
  case "showConfig":
    TOOLBAR_eWeather::_CONFIG_MENU();
    break;
  case "showCountry":
    TOOLBAR_eWeather::_COUNTRY_MENU();
    break;
  case "about":
    TOOLBAR_eWeather::_ABOUT_MENU();
    break;

  default:
    TOOLBAR_eWeather::_DEFAULT();
    break;
}

?>