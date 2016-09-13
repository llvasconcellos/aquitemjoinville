<?php
/**
* @version $Id: weather.php,v 0.1 2005/05/05 10:00:00 stingrey Exp $
* @package Mambo
* @subpackage Contact
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/*Arquivo traduzido para Português do Brasil em 06 de dezembro de 2006 por:
  Fernando Soares (Santa Cruz do Sul-RS, Brazil)
  fsoares@fsoares.com.br

  É permitido copiar, reproduzir, modificar e distribuir este arquivo sob os
  termos da Gnu General Public License (GPL).
  Você pode consultar uma cópia desta licensa em:
  http://www.gnu.org/copyleft/gpl.html
*/

/** ensure this file is being included by a parent file */
defined('_VALID_MOS') or die('Direct Access to this location is not allowed.');

define("_W_ACTUAL", "Valores Atuais");
define("_W_FORECAST", "Previsão");
define("_W_LOC_DATA", "Local");
define("_W_WIND", "Vento");
define("_W_TEMP", "Temp.");
define("_W_WINDCHILL", "STérm");
define("_W_WINDSPEED", "Velocidade");
define("_W_WINDDIR", "Direção");
define("_W_WINDGUST", "Velocidade máx.");
define("_W_SUNRISE", "Amanhecer");
define("_W_SUNSET", "Anoitecer");
define("_W_OBST", "Estação");
define("_W_LAT", "Latitude");
define("_W_LON", "Longitude");
define("_W_DEWP", "Ponto de Orvalho");
define("_W_VISIBILITY", "Visibilidade");
define("_W_HUMIDITY", "Humidade");
define("_W_UV_INDEX", "Índice UV");
define("_W_UV_LOW", "Baixo");
define("_W_UV_MED", "Médio");
define("_W_UV_HIGH", "Alto");
define("_W_UV_SHIGH", "Extremo");
define("_W_PRESSURE", "Pressão");
define("_W_UNKNOWN_ERROR", "Ocorreu um erro desconhecido");
define("_W_ERROR_TITLE", "Erro");
define("_W_ERROR_DESCR", "Ocorreu o seguinte erro");
define("_W_ERROR_CODE", "Código do erro");
define("_W_ERROR_NOPARTNERID", "Partner ID não disponível!");
define("_W_ERROR_NOPASSWORD", "key não disponível!");
define("_W_FORECAST_SUNRISE", "Sai");
define("_W_FORECAST_SUNSET", "Se põe");
define("_W_FORECAST_TEMP_MAX", "Máx");
define("_W_FORECAST_TEMP_MIN", "Mín");
define("_W_FORECAST_WINDSPEED", "Vel.");
define("_W_FORECAST_DAY", "Dia");
define("_W_FORECAST_NIGHT"," Noite");
define("_W_FORECAST_SUN", "Sol");
define("_W_FORECAST_TEMP", "Temperatura");
define("_W_FORECAST_WIND", "Vento");
define("_W_FORECAST_HUMI", "Humid.");
define("_W_FORECAST_DIRECTION", "Dir.");
define("_W_FORECAST_RAIN", "Precip.");
define("_W_FORECAST_FTITLE", "Detalhes para o dia");
define("_W_FORECAST_BACK", "Voltar à visualização geral");
define("_W_FORECAST_FOR", "para");
define("_W_FORECAST_D_DAY", "Dia");
define("_W_FORECAST_D_NIGHT", "Noite");
define("_W_FORECAST_TEMP_D_MAX", "Temperatura máx.");
define("_W_FORECAST_TEMP_D_MIN", "Temperatura mín.");
define("_W_FORECAST_D_RAIN", "Precipitação");
define("_W_BAROMETER", "Bar");
define("_W_PROVIDER", "Provido por");
define("_W_MOD_BUTTON", "Mais detalhes");
define("_W_SELECT_LOCATION", "Selecione sua cidade...");

// Language tags for administration section
define("_WEATHER_TITLE", "Configuração do eWeather");
define("_WEATHER_PARAM_TITLE", "Parâmetro");
define("_WEATHER_VALUE_TITLE", "Valor");
define("_WEATHER_DESCRIB_TITLE", "Descrição");
define("_WEATHER_PARTNER_ID", "Partner ID");
define("_WEAHTER_PARTNER_ID_D", "Precisa de um Partner ID fornecido por <a href=\"http://www.weather.com/services/xmloap.html\" target=\"_blank\">http://www.weather.com</a>.");
define("_WEATHER_PARTNER_KEY", "Partner Key");
define("_WEAHTER_PARTNER_KEY_D", "Precisa de um Key fornecido por <a href=\"http://www.weather.com/services/xmloap.html\" target=\"_blank\">http://www.weather.com</a>.");
define("_WEATHER_DEFAULT_LOCATION", "Localidade");
define("_WEATHER_DEFAULT_LOCATION_D", "Localidade padrão");
define("_WEATHER_DEFAULT_LOC_CODE", "Códigos de localidades");
define("_WEATHER_DEFAULT_LOC_CODE_D", "Código de localidade para a cidade selecionada.");
define("_WEATHER_CACHE_TIME", "Intervalo de cache");
define("_WEATHER_CACHE_TIME_D", "Intervalo de obtenção dos dados de previsão. Valor mínimo: 1800 segundos (30 Min.)");
define("_WEATHER_UNITS", "Unidades");
define("_WEATHER_UNITS_D", "Sistema de unidades a utilizar (inglês ou métrico)");
define("_WEATHER_FORECAST_DAYS", "Dias");
define("_WEATHER_UNITS_ENG", "Inglês");
define("_WEATHER_UNITS_INT", "Métrico");
define("_WEATHER_FORECAST_DAYS_D", "Dias de previsão");
define("_WEATHER_SHOW_FOOTER", "Mostrar Rodapé");
define("_WEATHER_SHOW_FOOTER_D", "Mostra o rodapé no componente");
define("_WEATHER_SHOW_FORECAST", "Mostra a previsão");
define("_WEATHER_SHOW_FORECAST_D", "Mostra a previsão no componente");
define("_WEATHER_TIME_FORMAT", "Formato de hora");
define("_WEATHER_TIME_FORMAT_D", "Formato de hora a mostrar na previsão meteorológica. Busca parâmetros na função strftime");
define("_WEATHER_DATE_FORMAT_LONG", "Formato de data (longo)");
define("_WEATHER_DATE_FORMAT_LONG_D", "Formato de data em formato longo para cabeçalhos. Busca parâmetros na função strftime");
define("_WEATHER_DATE_FORMAT_SHORT", "Formato de data (curto)");
define("_WEATHER_DATE_FORMAT_SHORT_D", "Formato de data curto para mostrar nas visualizações gerais. Busca parâmetros na função strftime");
define("_WEATHER_DATE_FORMAT_DETAIL", "Formato de data (detalhe)");
define("_WEATHER_DATE_FORMAT_DETAIL_D", "Formato para previsão detalhada. Busca parâmetros na função strftime");
define("_WEATHER_ICONSET", "Estilo de ícones");
define("_WEATHER_ICONSET_D", "Selecione um estio de ícones para mostrar.");
// Version 1.0.5 Beta
define("_WEATHER_USE_PROXY", "Proxy");
define("_WEATHER_USE_PROXY_D", "Ativa conexão através de  proxy com weather.com.");
define("_WEATHER_PROXY_HOST", "Proxy Host");
define("_WEATHER_PROXY_HOST_D", "Nome do Host ou endereço IP do servidor proxy.");
define("_WEATHER_PROXY_PORT", "Porta do proxy");
define("_WEATHER_PROXY_PORT_D", "Porta para a conexão por proxy.");
define("_WEATHER_USE_PROXY_AUTH", "Autenticação do proxy.");
define("_WEATHER_USE_PROXY_AUTH_D", "Utilizado para autenticar o servidor junto ao proxy");
define("_WEATHER_PROXY_AUTH_USER", "ID de Usuário do Proxy");
define("_WEATHER_PROXY_AUTH_USER_D", "ID de usuário para autenticar-se junto ao proxy.");
define("_WEATHER_PROXY_AUTH_PWD","Senha do Proxy");
define("_WEATHER_PROXY_AUTH_PWD_D", "Senha necessária para autenticar-se junto ao proxy.");

define("_WEATHER_REGION", "Região");
define("_WEATHER_COUNTRY", "País");
define("_WEATHER_CITY", "Cidade");
define("_WEATHER_CITY_CODE", "Código de cidade");
define("_WEATHER_PROFILE_UPDATE", "Perfil atualizado!");
define("_WEATHER_PROFILE_SAVED", "Perfil salvo!");
define("_WEATHER_PROFILE_ERROR", "Erro - Perfil não foi salvo!");
define("_WEATHER_SAVE_BUTTON", "&nbsp;&nbsp;&nbsp;Salvar&nbsp;&nbsp;&nbsp;");
define("_WEATHER_CANCEL_BUTTON", "&nbsp;&nbsp;&nbsp;Cancelar&nbsp;&nbsp;&nbsp;");
define("_WEATHER_SHOW_ALL", "Mostrar todas as cidades instaladas");
define("_WEATHER_GO_INST", "Voltar para localidades");

?>
