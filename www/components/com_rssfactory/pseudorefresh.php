<?php
/**
* @package rssFactory
* @version 1.0
* @copyright www.thefactory.ro
*/

	define( "_VALID_MOS", 1 );
	define(MAX_RUN_TIME,60); //seconds

	include_once('../../configuration.php');
	if (file_exists($mosConfig_absolute_path."/version.php")) {
		include_once($mosConfig_absolute_path."/version.php");
	} elseif (file_exists($mosConfig_absolute_path."/includes/version.php")) {
		include_once($mosConfig_absolute_path."/includes/version.php");
	}
	if (file_exists($mosConfig_absolute_path."/classes/database.php")) {
		include_once($mosConfig_absolute_path."/classes/database.php");
	} elseif (file_exists($mosConfig_absolute_path."/includes/database.php")) {
		include_once($mosConfig_absolute_path."/includes/database.php");
	}
	if (file_exists($mosConfig_absolute_path."/includes/joomla.php")) {
		require_once( $mosConfig_absolute_path .'/includes/joomla.php' );
	}elseif(file_exists($mosConfig_absolute_path."/includes/mambo.php")) {
		require_once( $mosConfig_absolute_path .'/includes/mambo.php' );
	}

	$database = new database($mosConfig_host, $mosConfig_user, $mosConfig_password, $mosConfig_db, $mosConfig_dbprefix);

	require_once( $mosConfig_absolute_path .'/includes/domit/xml_domit_include.php' );

	if (file_exists( $mosConfig_absolute_path."/components/com_rssfactory/rssfactory.functions.php") ) {
		include_once( $mosConfig_absolute_path."/components/com_rssfactory/rssfactory.functions.php");
	} else {
		return;
	}
	if (file_exists( $mosConfig_absolute_path."/components/com_rssfactory/rssfactory.class.php") ) {
		include_once( $mosConfig_absolute_path."/components/com_rssfactory/rssfactory.class.php");
	} else {
		return;
	}

	if (! SITE_SAFE_MODE_ON) set_time_limit(0);
	ignore_user_abort();

	$key=mosGetParam($_GET,'key','');
	$pass=mosGetParam($_GET,'password','');

	session_start();
	$secretkey=mosGetParam($_SESSION,'secretkey','');


// CHECK FOR AUTHENTICATION //

	if ($password !='') {
		//check uname and pass
		if (md5($cfg->refresh_password)!=$pass){
			echo "Bad user/pass combination";
			exit;
		}

	}else{
		if ($key=='' || ($key!=md5($secretkey))) {
			echo "Bad Key - $secretkey";
			exit;
		}
	}

// END CHECK FOR AUTHENTICATION //
	$cfg= new db_rssfactory_config($database);
    $cfg->LoadConfig();
    $cfg->lastcron=microtime_float();

    $database->setQuery("update `#__rssfactory_config` set `lastcron`='".microtime_float()."'");
	$database->query();
    $_SESSION['secretkey']="";

	//first update the never refreshed feeds.
	$starttime=microtime_float();

	$query = "SELECT * FROM #__rssfactory where published = 1 and date is null order by rand() limit 1";
	$database->setQuery( $query );

	$rows = $database->loadObjectList();
	while (count($rows)>0){
		refresh_specific_RSS($rows[0]);
		$currenttime=microtime_float();
		$database->setQuery( $query );
		$rows = $database->loadObjectList();
		if ($currenttime-$starttime>MAX_RUN_TIME) return; // max run time
	}

	//first update the other feeds.

	$query = "SELECT * FROM #__rssfactory where published = 1 and DATE_SUB(now(),INTERVAL $cfg->refreshinterval MINUTE) >date order by rand() limit 1";
	$database->setQuery( $query );
	$rows = $database->loadObjectList();
	while (count($rows)>0){
		refresh_specific_RSS($rows[0]);
		$currenttime=microtime_float();

		$database->setQuery( $query );
		$rows = $database->loadObjectList();
		if ($currenttime-$starttime>MAX_RUN_TIME) return; // max run time
	}

?>