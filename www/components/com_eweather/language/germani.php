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

define("_W_ACTUAL", "Aktuelle Werte");
define("_W_FORECAST", "Vorhersage");
define("_W_LOC_DATA", "Lokationsdaten");
define("_W_WIND", "Wind");
define("_W_TEMP", "Temp");
define("_W_WINDCHILL", "Gefühlt");
define("_W_WINDSPEED", "Geschwindigkeit");
define("_W_WINDDIR", "Richtung");
define("_W_WINDGUST", "Max. Geschw.");
define("_W_SUNRISE", "Sonnenaufgang");
define("_W_SUNSET", "Sonnenuntergang");
define("_W_OBST", "Wetterstation");
define("_W_LAT", "Breitengrad");
define("_W_LON", "Längengrad");
define("_W_DEWP", "Taupunkt");
define("_W_VISIBILITY", "Sichtweite");
define("_W_HUMIDITY", "Luftfeuchtigkeit");
define("_W_UV_INDEX", "UV Index");
define("_W_UV_LOW", "Wenig");
define("_W_UV_MED", "Mittel");
define("_W_UV_HIGH", "Hoch");
define("_W_UV_SHIGH", "Extrem");
define("_W_PRESSURE", "Luftdruck");
define("_W_UNKNOWN_ERROR", "Es ist ein unbekannter Fehler aufgetreten!");
define("_W_ERROR_TITLE", "Fehler");
define("_W_ERROR_DESCR", "Folgender Fehler ist aufgetreten");
define("_W_ERROR_CODE", "Fehlercode");
define("_W_ERROR_NOPARTNERID", "Keine Partner ID vorhanden!");
define("_W_ERROR_NOPASSWORD", "Kein Kennwort vorhanden!");
define("_W_FORECAST_SUNRISE", "Auf");
define("_W_FORECAST_SUNSET", "Ab");
define("_W_FORECAST_TEMP_MAX", "Max");
define("_W_FORECAST_TEMP_MIN", "Min");
define("_W_FORECAST_WINDSPEED", "Gesch.");
define("_W_FORECAST_DAY", "Tag");
define("_W_FORECAST_NIGHT"," Nacht");
define("_W_FORECAST_SUN", "Sonne");
define("_W_FORECAST_TEMP", "Temperatur");
define("_W_FORECAST_WIND", "Wind");
define("_W_FORECAST_HUMI", "Feucht");
define("_W_FORECAST_DIRECTION", "Richt.");
define("_W_FORECAST_RAIN", "Niederschlag");
define("_W_FORECAST_FTITLE", "Details über den Tag aufrufen");
define("_W_FORECAST_BACK", "Zurück zur Übersicht");
define("_W_FORECAST_FOR", "für");
define("_W_FORECAST_D_DAY", "Tagsüber");
define("_W_FORECAST_D_NIGHT", "Nachts");
define("_W_FORECAST_TEMP_D_MAX", "Max. Temperatur");
define("_W_FORECAST_TEMP_D_MIN", "Min. Temperatur");
define("_W_FORECAST_D_RAIN", "Regenwarscheinlichkeit");
define("_W_BAROMETER", "Barom.");
define("_W_PROVIDER", "Bereitgestellt von");
define("_W_MOD_BUTTON", "Mehr Details zeigen");
define("_W_SELECT_LOCATION", "Eigenen Ort auswählen...");

// Language tags for administration section
define("_WEATHER_TITLE", "Konfiguration für eWeather");
define("_WEATHER_PARAM_TITLE", "Parameter");
define("_WEATHER_VALUE_TITLE", "Wert");
define("_WEATHER_DESCRIB_TITLE", "Beschreibung");
define("_WEATHER_PARTNER_ID", "Partner ID");
define("_WEAHTER_PARTNER_ID_D", "Hier muß eine entsprechende Partner ID von <a href=\"http://www.weather.com/services/xmloap.html\" target=\"_blank\">http://www.weather.com</a> eingetragen werden.");
define("_WEATHER_PARTNER_KEY", "Partner Key");
define("_WEAHTER_PARTNER_KEY_D", "Den erhaltenen Key bei der Registration auf <a href=\"http://www.weather.com/services/xmloap.html\" target=\"_blank\">http://www.weather.com</a> eintragen.");
define("_WEATHER_DEFAULT_LOCATION", "Ort");
define("_WEATHER_DEFAULT_LOCATION_D", "Auswahl für die Vorgabe des Ortes nicht angemeldeter Benutzer.");
define("_WEATHER_DEFAULT_LOC_CODE", "Lokations Code");
define("_WEATHER_DEFAULT_LOC_CODE_D", "Der lokations Code der ausgewählten Stadt.");
define("_WEATHER_CACHE_TIME", "Zeit für Cache");
define("_WEATHER_CACHE_TIME_D", "Die Zeit in Sekunden für den Cache. Der minimale Wert beträgt 1800 Sekunden (30 Min.)");
define("_WEATHER_UNITS", "Einheiten");
define("_WEATHER_UNITS_D", "Definiert die Einheiten für die Anzeige");
define("_WEATHER_FORECAST_DAYS", "Tage");
define("_WEATHER_UNITS_ENG", "Englisch");
define("_WEATHER_UNITS_INT", "Metrisch");
define("_WEATHER_FORECAST_DAYS_D", "Anzahl der Tage für die Vorhersage");
define("_WEATHER_SHOW_FOOTER", "Zeige Footer");
define("_WEATHER_SHOW_FOOTER_D", "Zeigt den Footer in der Komponente an");
define("_WEATHER_SHOW_FORECAST", "Zeige Vorhersage");
define("_WEATHER_SHOW_FORECAST_D", "Zeigt die Wettervorhersage an");
define("_WEATHER_TIME_FORMAT", "Zeitformat");
define("_WEATHER_TIME_FORMAT_D", "Zeitformat für Anzeige in der Wettervorhersage. Formatierungen entsprechen der strftime Funktion");
define("_WEATHER_DATE_FORMAT_LONG", "Datumsformat (lang)");
define("_WEATHER_DATE_FORMAT_LONG_D", "Datumsformat im Langformat für Überschriften. Formatierungen entsprechen der strftime Funktion");
define("_WEATHER_DATE_FORMAT_SHORT", "Datumsformat (kurz)");
define("_WEATHER_DATE_FORMAT_SHORT_D", "Datumsformat im Kurzformat für Übersichten. Formatierungen entsprechen der strftime Funktion");
define("_WEATHER_DATE_FORMAT_DETAIL", "Datumsformat (detail)");
define("_WEATHER_DATE_FORMAT_DETAIL_D", "Datumsformat für Wettervorhersage in Detailansicht. Formatierungen entsprechen der strftime Funktion");
define("_WEATHER_ICONSET", "Icon Style");
define("_WEATHER_ICONSET_D", "Wähle einen Icon Style für die Darstellung aus.");
// Version 1.0.5 Beta
define("_WEATHER_USE_PROXY", "Proxy");
define("_WEATHER_USE_PROXY_D", "aktiviert einen Proxy für die Verbindung vom Webserver.");
define("_WEATHER_PROXY_HOST", "Proxy Host");
define("_WEATHER_PROXY_HOST_D", "Hostname oder IP Adresse für den Proxy.");
define("_WEATHER_PROXY_PORT", "Proxy Port");
define("_WEATHER_PROXY_PORT_D", "Port für die Proxyverbindung.");
define("_WEATHER_USE_PROXY_AUTH", "Proxy Authentifizierung");
define("_WEATHER_USE_PROXY_AUTH_D", "Wird eine Proxy Authentifizierung benötigt?");
define("_WEATHER_PROXY_AUTH_USER", "Proxy Benutzer");
define("_WEATHER_PROXY_AUTH_USER_D", "Die benötigte Benutzer-ID für den Proxy.");
define("_WEATHER_PROXY_AUTH_PWD","Proxy Kennwort");
define("_WEATHER_PROXY_AUTH_PWD_D", "Das benötigte Kennwort für die Proxy Authentifizierung.");

define("_WEATHER_REGION", "Region");
define("_WEATHER_COUNTRY", "Land");
define("_WEATHER_CITY", "Stadt");
define("_WEATHER_CITY_CODE", "Städtecode");
define("_WEATHER_PROFILE_UPDATE", "Profil aktualisiert!");
define("_WEATHER_PROFILE_SAVED", "Profil gespeichert!");
define("_WEATHER_PROFILE_ERROR", "Fehler - Profil nicht gespeichert!");
define("_WEATHER_SAVE_BUTTON", "&nbsp;&nbsp;&nbsp;Speichern&nbsp;&nbsp;&nbsp;");
define("_WEATHER_CANCEL_BUTTON", "&nbsp;&nbsp;&nbsp;Abbruch&nbsp;&nbsp;&nbsp;");
define("_WEATHER_SHOW_ALL", "Zeige alle installierten Orte");
define("_WEATHER_GO_INST", "Zurück zur Lokationsverwaltung");

?>