<?php
/**
* @version $Id: weather.php,v 0.1 2005/05/05 10:00:00 stingrey Exp $
* @package Mambo
* @subpackage Contact
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/*Archivo traducido a castellano el 30 de abril de 2006 por:
  Juan Antonio Añel Cabanelas (Ourense, España)
  aetherlux@gulo.org
  aetherlux@es.gnu.org

  Permiso para copiar, reproducir, modificar y distribuir este archivo bajo
  los términos de la Gnu General Public License (GPL).
  Se puede consultar una copia de esta licencia en:
  http://www.gnu.org/copyleft/gpl.html
*/

/** ensure this file is being included by a parent file */
defined('_VALID_MOS') or die('Direct Access to this location is not allowed.');

define("_W_ACTUAL", "Valores Actuales");
define("_W_FORECAST", "Predicción");
define("_W_LOC_DATA", "Lugar");
define("_W_WIND", "Viento");
define("_W_TEMP", "Temp.");
define("_W_WINDCHILL", "Sens. Térmica");
define("_W_WINDSPEED", "Velocidad");
define("_W_WINDDIR", "Dirección");
define("_W_WINDGUST", "Velocidad máx.");
define("_W_SUNRISE", "Amanecer");
define("_W_SUNSET", "Ocaso");
define("_W_OBST", "Estación");
define("_W_LAT", "Latitud");
define("_W_LON", "Longitud");
define("_W_DEWP", "Dep. Rocío");
define("_W_VISIBILITY", "Visibilidad");
define("_W_HUMIDITY", "Humedad");
define("_W_UV_INDEX", "Índice UV");
define("_W_UV_LOW", "Bajo");
define("_W_UV_MED", "Medio");
define("_W_UV_HIGH", "Alto");
define("_W_UV_SHIGH", "Extremo");
define("_W_PRESSURE", "Presión");
define("_W_UNKNOWN_ERROR", "Ha ocurrido un error desconocido");
define("_W_ERROR_TITLE", "Error");
define("_W_ERROR_DESCR", "Se ha producido el siguiente error");
define("_W_ERROR_CODE", "Error Code");
define("_W_ERROR_NOPARTNERID", "¡Partner ID no disponible!");
define("_W_ERROR_NOPASSWORD", "no key available!");
define("_W_FORECAST_SUNRISE", "Sale");
define("_W_FORECAST_SUNSET", "Se pone");
define("_W_FORECAST_TEMP_MAX", "Max");
define("_W_FORECAST_TEMP_MIN", "Min");
define("_W_FORECAST_WINDSPEED", "Velocidad");
define("_W_FORECAST_DAY", "Día");
define("_W_FORECAST_NIGHT"," Noche");
define("_W_FORECAST_SUN", "Sol");
define("_W_FORECAST_TEMP", "Temperatura");
define("_W_FORECAST_WIND", "Viento");
define("_W_FORECAST_HUMI", "Humedad");
define("_W_FORECAST_DIRECTION", "Direcc.");
define("_W_FORECAST_RAIN", "Precip.");
define("_W_FORECAST_FTITLE", "Detalles para el día");
define("_W_FORECAST_BACK", "Atrás para vista general");
define("_W_FORECAST_FOR", "para");
define("_W_FORECAST_D_DAY", "Día");
define("_W_FORECAST_D_NIGHT", "Noche");
define("_W_FORECAST_TEMP_D_MAX", "Temperatura máx.");
define("_W_FORECAST_TEMP_D_MIN", "Temperatura mín.");
define("_W_FORECAST_D_RAIN", "Precipitación");
define("_W_BAROMETER", "Barom.");
define("_W_PROVIDER", "Por gentileza de");
define("_W_MOD_BUTTON", "Más detalles");
define("_W_SELECT_LOCATION", "Selecciona tu ciudad...");

// Language tags for administration section
define("_WEATHER_TITLE", "Configuración de eWeather");
define("_WEATHER_PARAM_TITLE", "Parámetro");
define("_WEATHER_VALUE_TITLE", "Valor");
define("_WEATHER_DESCRIB_TITLE", "Descripción");
define("_WEATHER_PARTNER_ID", "Partner ID");
define("_WEAHTER_PARTNER_ID_D", "Necesita un Partner ID proveido por <a href=\"http://www.weather.com/services/xmloap.html\" target=\"_blank\">http://www.weather.com</a>.");
define("_WEATHER_PARTNER_KEY", "Partner Key");
define("_WEAHTER_PARTNER_KEY_D", "Necesita una Key proveida por <a href=\"http://www.weather.com/services/xmloap.html\" target=\"_blank\">http://www.weather.com</a>.");
define("_WEATHER_DEFAULT_LOCATION", "Localización");
define("_WEATHER_DEFAULT_LOCATION_D", "Localización por defecto");
define("_WEATHER_DEFAULT_LOC_CODE", "Cógidos de localizaciones");
define("_WEATHER_DEFAULT_LOC_CODE_D", "Código de localización para la ciudad seleccionada.");
define("_WEATHER_CACHE_TIME", "Intervalo de cache");
define("_WEATHER_CACHE_TIME_D", "Intervalo de obtención de los datos de previsión. Valor mínimo: 1800 segundos (30 Min.)");
define("_WEATHER_UNITS", "Unidades");
define("_WEATHER_UNITS_D", "Sistema de unidades a utilizar (inglés o métrico)");
define("_WEATHER_FORECAST_DAYS", "Días");
define("_WEATHER_UNITS_ENG", "Inglés");
define("_WEATHER_UNITS_INT", "Métrico");
define("_WEATHER_FORECAST_DAYS_D", "Días de predicción");
define("_WEATHER_SHOW_FOOTER", "Mostrar pie");
define("_WEATHER_SHOW_FOOTER_D", "Muestra el pie en el componente");
define("_WEATHER_SHOW_FORECAST", "Muestra la predicción");
define("_WEATHER_SHOW_FORECAST_D", "Muestra la predicción en el componente");
define("_WEATHER_TIME_FORMAT", "Formato de hora");
define("_WEATHER_TIME_FORMAT_D", "Formato de hora a mostrar en la predicción meteorológica. Busca parámetros en la función strftime");
define("_WEATHER_DATE_FORMAT_LONG", "Formato de fecha (largo)");
define("_WEATHER_DATE_FORMAT_LONG_D", "Formato de fecha en formato largo para cabeceras. Busca parámetros en la función strftime");
define("_WEATHER_DATE_FORMAT_SHORT", "Formato de fecha (corto)");
define("_WEATHER_DATE_FORMAT_SHORT_D", "Formato de fecha corto para mostrar en las vistas generales. Busca parámetros en la función strftime");
define("_WEATHER_DATE_FORMAT_DETAIL", "Formato de fecha (detalle)");
define("_WEATHER_DATE_FORMAT_DETAIL_D", "Formato para predicción detallada. Busca parámetros en la función strftime");
define("_WEATHER_ICONSET", "Estilo de iconos");
define("_WEATHER_ICONSET_D", "Selecciona un estio de iconos para mostrar.");
// Version 1.0.5 Beta
define("_WEATHER_USE_PROXY", "Proxy");
define("_WEATHER_USE_PROXY_D", "Activa conexión a través de  proxy a weather.com.");
define("_WEATHER_PROXY_HOST", "Proxy Host");
define("_WEATHER_PROXY_HOST_D", "Hostname o dirección IP de tu proxy.");
define("_WEATHER_PROXY_PORT", "Puerto del proxy");
define("_WEATHER_PROXY_PORT_D", "Puerto para la conexión por proxy.");
define("_WEATHER_USE_PROXY_AUTH", "Autentificación del proxy.");
define("_WEATHER_USE_PROXY_AUTH_D", "Utilizado para autentificar el servidor frente al proxy");
define("_WEATHER_PROXY_AUTH_USER", "Proxy User Id");
define("_WEATHER_PROXY_AUTH_USER_D", "El user id para autentificarse frente al proxy.");
define("_WEATHER_PROXY_AUTH_PWD","Proxy password");
define("_WEATHER_PROXY_AUTH_PWD_D", "El password necesario para autentificarse frente al proxy.");

define("_WEATHER_REGION", "Región");
define("_WEATHER_COUNTRY", "País");
define("_WEATHER_CITY", "Ciudad");
define("_WEATHER_CITY_CODE", "Código de ciudad");
define("_WEATHER_PROFILE_UPDATE", "¡Perfil actualizado!");
define("_WEATHER_PROFILE_SAVED", "¡Perfil guardado!");
define("_WEATHER_PROFILE_ERROR", "Error - Perfil no guardado!");
define("_WEATHER_SAVE_BUTTON", "&nbsp;&nbsp;&nbsp;Guardar&nbsp;&nbsp;&nbsp;");
define("_WEATHER_CANCEL_BUTTON", "&nbsp;&nbsp;&nbsp;Cancelar&nbsp;&nbsp;&nbsp;");
define("_WEATHER_SHOW_ALL", "Mostrar todas las ciudades instaladas");
define("_WEATHER_GO_INST", "Atrás para localizaciones");

?>
