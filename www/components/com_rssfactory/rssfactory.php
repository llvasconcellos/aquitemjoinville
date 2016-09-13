<?php
/**
* @package rssFactory
* @version 1.0
* @copyright www.thefactory.ro
* @license: commercial
*/

$option="com_rssfactory";

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
if(file_exists($mosConfig_absolute_path."/components/$option/rssfactory.config.php")){
	require_once($mosConfig_absolute_path."/components/$option/rssfactory.config.php");
}elseif(file_exists($mosConfig_absolute_path."/components/$option/rssfactory_pro.config.php")) {
	require_once($mosConfig_absolute_path."/components/$option/rssfactory_pro.config.php");
}
$class = CLASSNAME;
if(!class_exists($class)){
	require_once($mosConfig_absolute_path."/components/$option/".$class.".class.php");
}
require_once($mosConfig_absolute_path."/components/$option/".$class.".html.php");
require_once($mosConfig_absolute_path."/components/$option/$class.functions.php");
require_once($mosConfig_absolute_path."/components/$option/overlib.config.php");


global $database,$task;

///$meth array tip task=>method
$rss = new $class($database);
/*@var $rss rss*/
//var_dump($task);
if(empty($task)){
	$task = "default";
}
if(method_exists($rss,$meth[$task])){

	$func = $meth[$task];
	$rss->$func($_REQUEST);
}
?>