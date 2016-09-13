<?php

// no direct access
defined( '_VALID_MOS' ) or die( 'Restricted access' );
if(file_exists($mosConfig_absolute_path."/components/com_rssfactory_pro/rssfactory_pro.config.php")){
	require_once( $mosConfig_absolute_path."/components/com_rssfactory_pro/rssfactory_pro.config.php");
}elseif(file_exists($mosConfig_absolute_path."/components/com_rssfactory/rssfactory.config.php")){
	require_once( $mosConfig_absolute_path."/components/com_rssfactory/rssfactory.config.php");
}else {
    return ;
}
$class = CLASSNAME;
$_MAMBOTS->registerFunction( 'onSearch', 'botSearchRSSFactoryfeeds' );
function botSearchRSSFactoryfeeds( $text, $phrase='', $ordering='' ) {
	global $database, $my, $_MAMBOTS;

	// check if param query has previously been processed
	if ( !isset($_MAMBOTS->_search_mambot_params[$class]) ) {
		// load mambot params info
		$query = "SELECT params"
		. "\n FROM #__mambots"
		. "\n WHERE element = '$class.searchbot'"
		. "\n AND folder = 'search'"
		;
		$database->setQuery( $query );
		$database->loadObject($mambot);

		// save query to class variable
		$_MAMBOTS->_search_mambot_params[$class] = $mambot;
	}

	// pull query data from class variable
	$mambot = $_MAMBOTS->_search_mambot_params[$class];

	$botParams = new mosParameters( $mambot->params );

	$limit = $botParams->def( 'search_limit', 50 );

	$text = trim( $text );
	if ($text == '') {
		return array();
	}

	$wheres = array();
	switch ($phrase) {
		case 'exact':
			$wheres2 = array();
			$wheres2[] = "LOWER(item_title) LIKE '%$text%'";
			$wheres2[] = "LOWER(item_description) LIKE '%$text%'";
			$where = '(' . implode( ') OR (', $wheres2 ) . ')';
			break;

		case 'all':
		case 'any':
		default:
			$words = explode( ' ', $text );
			$wheres = array();
			foreach ($words as $word) {
				$wheres2 = array();
		  		$wheres2[] = "LOWER(item_title) LIKE '%$word%'";
				$wheres2[] = "LOWER(item_description) LIKE '%$word%'";
				$wheres[] = implode( ' OR ', $wheres2 );
			}
			$where = '(' . implode( ($phrase == 'all' ? ') AND (' : ') OR ('), $wheres ) . ')';
			break;
	}


	switch ( $ordering ) {
		case 'alpha':
			$order = 'item_title ASC';
			break;

		case 'category':
			$order = 'channel_category ASC, item_title ASC';
			break;

		case 'oldest':
			$order = 'item_date ASC, item_title ASC';
			break;
		case 'newest':
			$order = 'item_date DESC, item_title ASC';
			break;
		case 'popular':
		default:
			$order = 'item_title ASC';
	}

	$query = "SELECT item_title AS title,"
	. "\n item_date AS created,"
	. "\n item_description AS text,"
	. "\n concat('RssFactory / ',b.cat) AS section,"
	. "\n CONCAT( 'index.php?option=com_$class&task=visit&linkvisited=', a.id ) AS href,"
	. "\n '1' AS browsernav"
	. "\n FROM #__rssfactory_cache a "
	. "\n INNER JOIN #__rssfactory AS b ON b.id = a.rssid"
	. "\n WHERE ( $where )"
	. "\n AND b.published = 1"
	. "\n ORDER BY $order"
	;

	$database->setQuery( $query, 0, $limit );
	$rows = $database->loadObjectList();

	return $rows;
}
?>