<?php
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

define(CLASSNAME,'rssfactory');

//aici constante
define(COMPONENT_PATH,$mosConfig_live_site."/components/com_".CLASSNAME."/");
define(COMPONENT_ADMINPATH,$mosConfig_live_site."/administrator/components/com_".CLASSNAME."/");
define(XAJAX_PATH,$mosConfig_live_site."/administrator/components/com_".CLASSNAME."/xajax");

define(DOMIT_INCLUDE_PATH,$mosConfig_absolute_path .'/includes/domit/');
define(MAGPIE_DIR,$mosConfig_absolute_path . "/components/com_".CLASSNAME."/magpierss/");
define(MAGPIE_CACHE_ON,0);
define(ADMINCLASSNAME,'admin_rssfactory');
define(FRONT_HTML,'HTML_rssfactory');
define(BACK_HTML,'HTML_RSSReader');

define(COMPONENT_HOME_PAGE,"http://www.thefactory.ro/");
define(COMPONENT_VERSION,"1.1.1");

define(COMPONENT_PATH,$mosConfig_live_site."/components/com_".CLASSNAME."/");
define(COMPONENT_ADMINPATH,$mosConfig_live_site."/administrator/components/com_".CLASSNAME."/");

if (@ini_get('safe_mode') == 1) define(SITE_SAFE_MODE_ON,true);
    else define(SITE_SAFE_MODE_ON,false);

//// pune array cu task => methode de clasa atentie la securitate

$meth = array(
			'visit' => 'visitLink',
			'refresh' => 'refreshRSS',
			'showcat' => 'listRSS',
			'search' => 'listRSS',
			'default' => 'showCats',
);

$meth_adm = array(
			'save' => 'saveRSS',
			'remove' => 'delRSS',
			'publish' => 'publishRSS',
			'unpublish' => 'publishRSS',
			'new' => 'editRSS',
			'edit' => 'editRSS',
			'backup' => 'generateBackup',
			'orderup' => 'orderRSS',
			'orderdown' => 'orderRSS',
			'showconfig' => 'showConfig',
			'saveconfig' => 'saveConfig',
			'showads' => 'showAds',
			'saveads' => 'saveAds',
			'removeads' => 'delAds',
			'publishads' => 'publishAds',
			'unpublishads' => 'publishAds',
			'newads' => 'editAds',
			'editads' => 'editAds',
			'importcsv' => 'showImportCSV',
			'savecsv' => 'saveCSV',
			'restore' => 'showRestore',
			'restorebackup' => 'restoreBackup',
			'catman' => 'CategoryManager',
			'savecats' => 'SaveCategories',
			'about' => 'ShowAboutBox',
			'refreshfeed' => 'jax_RefreshFeed',
			'default' => 'showLinks'
);
$extra_params = array(
			'save' => null,
			'remove' => null,
			'publish' => 1,
			'unpublish' => 0,
			'new' => null,
			'edit' => null,
			'orderup' => -1,
			'orderdown' => 1,
			'showconfig' => null,
			'saveconfig' => null,
			'showads' => null,
			'saveads' => null,
			'removeads' => null,
			'publishads' => 1,
			'unpublishads' => 0,
			'newads' => null,
			'editads' => null,
			'importcsv' => null,
			'savecsv' => null,
			'restore' => null,
			'catman' => null,
			'savecats' => null,
			'about' => null,
			'refreshfeed' => null,
			'default' => null
);
?>
