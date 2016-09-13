<?php
/**
* @package rssFactory
* @version 1.0
* @copyright www.thefactory.ro
*/
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );



if(file_exists($mosConfig_absolute_path."/components/$option/rssfactory.config.php")){
	require_once($mosConfig_absolute_path."/components/$option/rssfactory.config.php");
}elseif(file_exists($mosConfig_absolute_path."/components/$option/rssfactory_pro.config.php")) {
	require_once($mosConfig_absolute_path."/components/$option/rssfactory_pro.config.php");
}
$admin_class = ADMINCLASSNAME;
$class = CLASSNAME;
if(!class_exists($admin_class)){
	require_once($mosConfig_absolute_path."/components/$option/".$class.".class.php");
}
require_once($mosConfig_absolute_path."/administrator/components/$option/admin.".$class.".html.php");
require_once($mosConfig_absolute_path."/components/$option/overlib.config.php");
require_once($mosConfig_absolute_path."/components/$option/rssfactory.functions.php");

global $database,$task;

$jaxx= mosGetParam( $_REQUEST, 'jaxx', '' );

if ($jaxx=='1'){
	$xajax=InitializeXajax();
	$xajax->processRequests();
	exit;
}
$rss_adm = new $admin_class($database);
/*@var $rss rss*/
//var_dump($task);
if(empty($task)){
	$task = "default";
}
if($task == "refreshfeed"){
        $xajax=InitializeXajax();
        $feedid = mosGetParam( $_REQUEST, 'feedid', '0' );
        jax_RefreshFeed($feedid);
}

if(method_exists($rss_adm,$meth_adm[$task])){
	$oparams = $extra_params[$task];
	$func = $meth_adm[$task];
	$rss_adm->$func($_REQUEST,$oparams);
}
?>