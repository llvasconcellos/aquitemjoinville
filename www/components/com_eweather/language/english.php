<?php
/**
* @version $Id: weather.php,v 0.1 2005/05/05 10:00:00 stingrey Exp $
* @package Mambo
* @subpackage Contact
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined('_VALID_MOS') or die('Direct Access to this location is not allowed.');

define("_W_ACTUAL", "Current Values");
define("_W_FORECAST", "Forecast");
define("_W_LOC_DATA", "Location Data");
define("_W_WIND", "Wind");
define("_W_TEMP", "Temp");
define("_W_WINDCHILL", "Wind Chill");
define("_W_WINDSPEED", "Speed");
define("_W_WINDDIR", "Direction");
define("_W_WINDGUST", "Gusts");
define("_W_SUNRISE", "Sunrise");
define("_W_SUNSET", "Sunset");
define("_W_OBST", "Weather Station");
define("_W_LAT", "Latitude");
define("_W_LON", "Longitude");
define("_W_DEWP", "Dewpoint");
define("_W_VISIBILITY", "Visibility");
define("_W_HUMIDITY", "Humidity");
define("_W_UV_INDEX", "UV Index");
define("_W_UV_LOW", "Low");
define("_W_UV_MED", "Medium");
define("_W_UV_HIGH", "High");
define("_W_UV_SHIGH", "Extreme");
define("_W_PRESSURE", "Pressure");
define("_W_UNKNOWN_ERROR", "It's a unknown error ocurred!");
define("_W_ERROR_TITLE", "Error");
define("_W_ERROR_DESCR", "Error Description");
define("_W_ERROR_CODE", "Error Code");
define("_W_ERROR_NOPARTNERID", "No partner ID available!");
define("_W_ERROR_NOPASSWORD", "No key available!");
define("_W_FORECAST_SUNRISE", "Sunrise");
define("_W_FORECAST_SUNSET", "Sunset");
define("_W_FORECAST_TEMP_MAX", "Hi");
define("_W_FORECAST_TEMP_MIN", "Lo");
define("_W_FORECAST_WINDSPEED", "Speed");
define("_W_FORECAST_DAY", "Day");
define("_W_FORECAST_NIGHT"," Night");
define("_W_FORECAST_SUN", "Sun");
define("_W_FORECAST_TEMP", "Temperature");
define("_W_FORECAST_WIND", "Wind");
define("_W_FORECAST_HUMI", "Humidity");
define("_W_FORECAST_DIRECTION", "Direct.");
define("_W_FORECAST_RAIN", "Chance of Precip.");
define("_W_FORECAST_FTITLE", "Show details for day");
define("_W_FORECAST_BACK", "Back to overview");
define("_W_FORECAST_FOR", "for");
define("_W_FORECAST_D_DAY", "Daytime");
define("_W_FORECAST_D_NIGHT", "Evening");
define("_W_FORECAST_TEMP_D_MAX", "High");
define("_W_FORECAST_TEMP_D_MIN", "Low");
define("_W_FORECAST_D_RAIN", "Chance of Precip.");
define("_W_BAROMETER", "Barom.");
define("_W_PROVIDER", "Provided by");
define("_W_MOD_BUTTON", "Show more details");
define("_W_SELECT_LOCATION", "Select your city...");

// Language tags for administration section
define("_WEATHER_TITLE", "Configuration for eWeather");
define("_WEATHER_PARAM_TITLE", "Parameter");
define("_WEATHER_VALUE_TITLE", "Value");
define("_WEATHER_DESCRIB_TITLE", "Description");
define("_WEATHER_PARTNER_ID", "Partner ID");
define("_WEAHTER_PARTNER_ID_D", "You need a Partner ID provided by <a href=\"http://www.weather.com/services/xmloap.html\" target=\"_blank\">http://www.weather.com</a>.");
define("_WEATHER_PARTNER_KEY", "Partner Key");
define("_WEAHTER_PARTNER_KEY_D", "You need a Key provided by <a href=\"http://www.weather.com/services/xmloap.html\" target=\"_blank\">http://www.weather.com</a>.");
define("_WEATHER_DEFAULT_LOCATION", "Location");
define("_WEATHER_DEFAULT_LOCATION_D", "Default Location");
define("_WEATHER_DEFAULT_LOC_CODE", "Locations Code");
define("_WEATHER_DEFAULT_LOC_CODE_D", "Location Code for selected city.");
define("_WEATHER_CACHE_TIME", "Cache Time");
define("_WEATHER_CACHE_TIME_D", "Time for caching the weather data. Minimale value is 1800 seconds (30 Min.)");
define("_WEATHER_UNITS", "Units");
define("_WEATHER_UNITS_D", "Definition of units for display (english or metric)");
define("_WEATHER_FORECAST_DAYS", "Days");
define("_WEATHER_UNITS_ENG", "English");
define("_WEATHER_UNITS_INT", "Metric");
define("_WEATHER_FORECAST_DAYS_D", "Count of days for forecast");
define("_WEATHER_SHOW_FOOTER", "Show Footer");
define("_WEATHER_SHOW_FOOTER_D", "Displays the footer in the component");
define("_WEATHER_SHOW_FORECAST", "Display Forecast");
define("_WEATHER_SHOW_FORECAST_D", "Display in componentent the forecast");
define("_WEATHER_TIME_FORMAT", "Time format");
define("_WEATHER_TIME_FORMAT_D", "Time format for display in weather forecast. Look for parameters in strftime function. US English recommendation: %I:%M %p");
define("_WEATHER_DATE_FORMAT_LONG", "Date format (long).");
define("_WEATHER_DATE_FORMAT_LONG_D", "Date format in a long format for headers. Look for parameters in strftime function. US English recommendation: %B %d, %Y, %I:%M %p");
define("_WEATHER_DATE_FORMAT_SHORT", "Date format (short)");
define("_WEATHER_DATE_FORMAT_SHORT_D", "Date format in short format for display in overviews. Look for parameters in strftime function.  US English recommendation: %a, %b %d");
define("_WEATHER_DATE_FORMAT_DETAIL", "Date format (detail)");
define("_WEATHER_DATE_FORMAT_DETAIL_D", "Date format for detailed forecast. Look for parameters in strftime function. US English recommendation: %A, %B %d, %Y");
define("_WEATHER_ICONSET", "Icon Style");
define("_WEATHER_ICONSET_D", "Select an Icon Style for display.");
// Version 1.0.5 Beta
define("_WEATHER_USE_PROXY", "Proxy");
define("_WEATHER_USE_PROXY_D", "Activation a proxy connection to weather.com.");
define("_WEATHER_PROXY_HOST", "Proxy Host");
define("_WEATHER_PROXY_HOST_D", "Hostname or IP addresse for your proxy.");
define("_WEATHER_PROXY_PORT", "Proxy Port");
define("_WEATHER_PROXY_PORT_D", "Port for proxy connection.");
define("_WEATHER_USE_PROXY_AUTH", "Proxy authentification");
define("_WEATHER_USE_PROXY_AUTH_D", "Is used to authenticate the server to the proxy");
define("_WEATHER_PROXY_AUTH_USER", "Proxy User Id");
define("_WEATHER_PROXY_AUTH_USER_D", "The user id for authenticate against the proxy.");
define("_WEATHER_PROXY_AUTH_PWD","Proxy password");
define("_WEATHER_PROXY_AUTH_PWD_D", "the password needed for authentication against the proxy.");

define("_WEATHER_REGION", "Region");
define("_WEATHER_COUNTRY", "Country");
define("_WEATHER_CITY", "City");
define("_WEATHER_CITY_CODE", "City Code");
define("_WEATHER_PROFILE_UPDATE", "Profile updated!");
define("_WEATHER_PROFILE_SAVED", "Profile saved!");
define("_WEATHER_PROFILE_ERROR", "Error - Profile not saved!");
define("_WEATHER_SAVE_BUTTON", "&nbsp;&nbsp;&nbsp;Save&nbsp;&nbsp;&nbsp;");
define("_WEATHER_CANCEL_BUTTON", "&nbsp;&nbsp;&nbsp;Cancel&nbsp;&nbsp;&nbsp;");
define("_WEATHER_SHOW_ALL", "Show all installed Cities");
define("_WEATHER_GO_INST", "Back to Locations");

?>