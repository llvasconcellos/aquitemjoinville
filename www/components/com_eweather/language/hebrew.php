<?php
/**
* @version $Id: weather.php,v 0.1 2005/05/05 10:00:00 stingrey Exp $
* @package Mambo
* @subpackage Contact
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
* Translated By Benny Davidovich (www.otv.co.il)
*/

/** ensure this file is being included by a parent file */
defined('_VALID_MOS') or die('Direct Access to this location is not allowed.');

define("_W_ACTUAL", "ערכים נוכחים");
define("_W_FORECAST", "תחזית");
define("_W_LOC_DATA", "נתוני איזור");
define("_W_WIND", "רוח");
define("_W_TEMP", "מעלות");
define("_W_WINDCHILL", "מורגש");
define("_W_WINDSPEED", "מהירות");
define("_W_WINDDIR", "כיוון");
define("_W_WINDGUST", "מהירות מקס..");
define("_W_SUNRISE", "זריחה");
define("_W_SUNSET", "שקיעה");
define("_W_OBST", "תחנת חיזוי");
define("_W_LAT", "קו רוחב");
define("_W_LON", "קו אורך");
define("_W_DEWP", "נקודת קיפאון");
define("_W_VISIBILITY", "ראות");
define("_W_HUMIDITY", "לחות");
define("_W_UV_INDEX", "רמת UV");
define("_W_UV_LOW", "נמוך");
define("_W_UV_MED", "בינוני");
define("_W_UV_HIGH", "גבוהה");
define("_W_UV_SHIGH", "קיצוני");
define("_W_PRESSURE", "לחץ");
define("_W_UNKNOWN_ERROR", "התרחשה תקלה לא ידועה!");
define("_W_ERROR_TITLE", "תקלה");
define("_W_ERROR_DESCR", "Folgender Fehler ist aufgetreten");
define("_W_ERROR_CODE", "קוד שגיאה");
define("_W_ERROR_NOPARTNERID", "אין זהוי משתמש בנמצא!");
define("_W_ERROR_NOPASSWORD", "אין מפתח בנימצא!");
define("_W_FORECAST_SUNRISE", "זריחה");
define("_W_FORECAST_SUNSET", "שקיעה");
define("_W_FORECAST_TEMP_MAX", "מקס");
define("_W_FORECAST_TEMP_MIN", "מינ");
define("_W_FORECAST_WINDSPEED", "מהירות");
define("_W_FORECAST_DAY", "יום");
define("_W_FORECAST_NIGHT"," לילה");
define("_W_FORECAST_SUN", "שמש");
define("_W_FORECAST_TEMP", "טמפרטורה");
define("_W_FORECAST_WIND", "רוח");
define("_W_FORECAST_HUMI", "לחות");
define("_W_FORECAST_DIRECTION", "כיוון.");
define("_W_FORECAST_RAIN", "משקעים.");
define("_W_FORECAST_FTITLE", "הצג מידע ליום");
define("_W_FORECAST_BACK", "חזרה לכללי");
define("_W_FORECAST_FOR", "עבור");
define("_W_FORECAST_D_DAY", "שעות היום");
define("_W_FORECAST_D_NIGHT", "בלילה");
define("_W_FORECAST_TEMP_D_MAX", "טמפרטורה מקס.");
define("_W_FORECAST_TEMP_D_MIN", "טמפרטורה מינ.");
define("_W_FORECAST_D_RAIN", "משקעים");
define("_W_BAROMETER", "ברום.");
define("_W_PROVIDER", "סופק עי");
define("_W_MOD_BUTTON", "הצג מידע נוסף");
define("_W_SELECT_LOCATION", "בחר את עירך....");

// Language tags for administration section
define("_WEATHER_TITLE", "הגדרות עבור eWeather");
define("_WEATHER_PARAM_TITLE", "פרמטר");
define("_WEATHER_VALUE_TITLE", "ערך");
define("_WEATHER_DESCRIB_TITLE", "תיאור");
define("_WEATHER_PARTNER_ID", "זהוי משתמש");
define("_WEAHTER_PARTNER_ID_D", "You need a Partner ID provided by <a href=\"http://www.weather.com/services/xmloap.html\" target=\"_blank\">http://www.weather.com</a>.");
define("_WEATHER_PARTNER_KEY", "מפתח משתמש");
define("_WEAHTER_PARTNER_KEY_D", "You need a Key provided by <a href=\"http://www.weather.com/services/xmloap.html\" target=\"_blank\">http://www.weather.com</a>.");
define("_WEATHER_DEFAULT_LOCATION", "איזור");
define("_WEATHER_DEFAULT_LOCATION_D", "איוזר בררת מחדל");
define("_WEATHER_DEFAULT_LOC_CODE", "קוד איזור");
define("_WEATHER_DEFAULT_LOC_CODE_D", "קוד אזור עבור עיר נבחרת.");
define("_WEATHER_CACHE_TIME", "זמן למיטמון");
define("_WEATHER_CACHE_TIME_D", "זמן למיטמון המידע. מינימום מותר 1800 שניות (30 דקות)");
define("_WEATHER_UNITS", "יחידה");
define("_WEATHER_UNITS_D", "הגדרת יחידת המידה לתצוגה (אנגלית מטרית).");
define("_WEATHER_FORECAST_DAYS", "ימים");
define("_WEATHER_UNITS_ENG", "אנגלית");
define("_WEATHER_UNITS_INT", "מטרית");
define("_WEATHER_FORECAST_DAYS_D", "מספר ימים לחיזוי");
define("_WEATHER_SHOW_FOOTER", "הצג תחתית");
define("_WEATHER_SHOW_FOOTER_D", "הצג את התחתית ברכיב");
define("_WEATHER_SHOW_FORECAST", "הצג תחזית");
define("_WEATHER_SHOW_FORECAST_D", "הצג את התחזית גם ברכיב");
define("_WEATHER_TIME_FORMAT", "פורמט זמן");
define("_WEATHER_TIME_FORMAT_D", "פורמט זמן לתצוגה במערכת. הסתכלו בפרמטר STRFTIME");
define("_WEATHER_DATE_FORMAT_LONG", "פורמט תאריך (ארוך)");
define("_WEATHER_DATE_FORMAT_LONG_D", "פורמט זמן לתצוגה במערכת. הסתכלו בפרמטר STRFTIME");
define("_WEATHER_DATE_FORMAT_SHORT", "פורמט תאריך (קצר)");
define("_WEATHER_DATE_FORMAT_SHORT_D", "Dateformat in short format for display in overviews. Look for parameters in strftime function");
define("_WEATHER_DATE_FORMAT_DETAIL", "פורמט תאריך (מידע)");
define("_WEATHER_DATE_FORMAT_DETAIL_D", "Dateformat for detailed forecast. Look for parameters in strftime function");
define("_WEATHER_ICONSET", "סגנון צלמית");
define("_WEATHER_ICONSET_D", "בחר סגנון צלמית לתצוגה.");

define("_WEATHER_REGION", "איזור");
define("_WEATHER_COUNTRY", "מדינה");
define("_WEATHER_CITY", "עיר");
define("_WEATHER_CITY_CODE", "קוד עיר");
define("_WEATHER_PROFILE_UPDATE", "פרופיל עודכן!");
define("_WEATHER_PROFILE_SAVED", "פרופיל נשמר!");
define("_WEATHER_PROFILE_ERROR", "שגיאה - פרופיל לא נשמר!");
define("_WEATHER_SAVE_BUTTON", "&nbsp;&nbsp;&nbsp;Save&nbsp;&nbsp;&nbsp;");
define("_WEATHER_CANCEL_BUTTON", "&nbsp;&nbsp;&nbsp;Cancel&nbsp;&nbsp;&nbsp;");
define("_WEATHER_SHOW_ALL", "הצג את כל הערים שהותקנו");
define("_WEATHER_GO_INST", "בחזרה לאזורים");

?>