<?php
/**
* @package rssFactory
* @version 1.0
* @copyright www.thefactory.ro
* @license: commercial
*/

defined( '_VALID_MOS' ) or die('Direct Access to this location is not allowed.' );

function vardump($var){
	echo '<pre>';
	var_dump($var);
	echo '</pre>';
}

class rssreader_ads extends mosDBTable {

	/** @var int(11) Primary key */
	var $id=null;
	/** @var varchar(250) */
	var $title=null;
	/** @var text */
	var $Adtext=null;
	/** @var int(11) */
	var $published=null;


	function rssreader_ads( &$_db) {

	    $this->mosDBTable( '#__rssfactory_ads', 'id',  $_db ); //ancestor Constructor call
                    // Please check if the tool presumed well your settings

	}

}

class db_rssfactory_config extends mosDBTable {

	/** @var int(11) Primary key */
	var $id=null;
	/** @var int(11) */
	var $nrads=null;
	/** @var text */
	var $description=null;
	/** @var varchar(50) */
	var $refresh_password=null;
	var $showSearch=null;
	var $unpublisherr=null;
	var $showcategory=null;
	var $liststyle=null;
	var $limitrss=null;
    var $showfeeddescription=null;
	var $refreshinterval=10; //minutes
	var $lastcron=null; //microtime
	var $use_pseudocron=null; // use or not pseudocron
	var $use_favicons=null; // use or not pseudocron
	var $date_format=null; // use or not pseudocron
	var $hideDate=null;
	var $hideBullet=null;
	var $table_view_open=null;
	var $cat_previewnr=null;
	var $force_charset=null;
	var $params=null;


	function db_rssfactory_config( &$_db) {

	    $this->mosDBTable( '#__rssfactory_config', 'id',  $_db ); //ancestor Constructor call
                    // Please check if the tool presumed well your settings

	}
    function LoadConfig(){
		$this->_db->setQuery( "SELECT * FROM $this->_tbl LIMIT 1" );

		$res=$this->_db->loadObject( $this );
		$pars=new mosParameters($this->params);
		$arr=$pars->toArray();
		if (count($arr))
		  foreach ($arr as $k=>$v){
		      $this->$k=$v;
		  }

		return $res;
    }
    function getParamnames()
    {
        return array('force_output_charset','twidth','theight','output_iframe','iframe_height');
    }
}



class rsscache_db extends mosDBTable {

	/** @var bigint(20) Primary key */
	var $id=null;
	/** @var int(11) */
	var $rssid=null;
	/** @var varchar(250) */
	var $rssurl=null;
	/** @var datetime */
	var $date=null;
	/** @var text */
	var $channel_title=null;
	/** @var text */
	var $channel_link=null;
	/** @var text */
	var $channel_description=null;
	/** @var tinytext */
	var $channel_category=null;
	/** @var text */
	var $item_title=null;
	/** @var text */
	var $item_description=null;
	/** @var text */
	var $item_link=null;
	/** @var datetime */
	var $item_date=null;
	/** @var text */
	var $item_source=null;
	/** @var text */
	var $item_category=null;



	function rsscache_db( &$_db) {

	    $this->mosDBTable( '#__rssfactory_cache', 'id',  $_db ); //ancestor Constructor call
                    // Please check if the tool presumed well your settings

	}

}


class mosRSSReader extends mosDBTable {

	var $id=null;
	var $ordering=null;

	var $title=null;
	var $url=null;

	var $published=null;
	var $nrfeeds=null;

	var $cat=null;
	var $temprss=null;
	var $date=null;
	var $rsserror=null;
	var $encoding=null;


	function mosRSSReader( &$db ) {
		$this->mosDBTable( '#__rssfactory', 'id', $db );
	}
}
// Class rss - functiile din task switch devin methode pentru clasa
class rssfactory {
	var $cook;
	var $cfg;
	var $html;

function visitLink(&$arr){
    global $database,$cfg;
	$linkv = trim( mosGetParam( $arr, 'linkvisited', "" ) );

	$row=new rsscache_db($database);
	$row->load($linkv);
	$query = "SELECT * FROM #__rssfactory_user where sid='$this->cook' and newsid='$linkv' ";
	$database->setQuery( $query );
	if (!$database->loadResult()){

		$query = "insert into #__rssfactory_user (sid,newsid,date) values ('$this->cook','$linkv',now()) ";
		$database->setQuery( $query );
		$database->query();
	}
	if ($this->cfg->output_iframe){
        $this->html->ShowFeedInWrapper($row,$this->cfg);
        return;
	}else{
	   header('Status: 301 Moved Permanently');
	   header('Location: '.$row->item_link);
	   exit;
	}

}

function refreshRSS(&$arr){
    global $database;
	if (! SITE_SAFE_MODE_ON) set_time_limit(0);
	$pass=mosGetParam($arr,'password','');
	if ($pass!=$this->cfg->refresh_password){
	   mosRedirect('index.php?mosmsg=Password+incorrect');

	}
	$query = "SELECT * FROM #__rssfactory where published = 1 order by ordering,id";
	$database->setQuery( $query );
	$rows = $database->loadObjectList();

	$old_e=error_reporting(0);
	echo "<html><body><ul>";
	foreach ( $rows as $row) {
		$nr=refresh_specific_RSS($row);
		echo "<li>".$row->url."&nbsp;, $nr</li>";
	}
	echo "</ul></body></html>";
	error_reporting($old_e);
	return;
}



function showCats(&$arr) {
    global $database,$mainframe,$Itemid;
    //<meta http-equiv="Content-Type" content="text/html;charset=utf-8 >
     if ($this->cfg->force_charset!='') $mainframe->addMetaTag( 'Content-Type', 'text/html; charset='.$this->cfg->force_charset );


    if ($this->cfg->showcategory){
    	$database->setQuery('select cat,count(*) as Nr,sum(nrfeeds) as NrFeeds from #__rssfactory where published=1 group by cat having count(*)>0');
    	$cats=$database->loadAssocList();

        $this->html->displayCats($this->cfg->description,$cats,$this->cfg,$Itemid);
    }else{
        $this->listRSS($arr);
    }
	return;
}



function listRSS(&$arr){
    //PREPARE ADS!!
    global $database,$mainframe,$Itemid,$task;
	$searchterm = mosGetParam($arr,'search','');
    if ($this->cfg->force_charset!='') $mainframe->addMetaTag( 'Content-Type', 'text/html; charset='.$this->cfg->force_charset );


    $query = 'SELECT * FROM #__rssfactory_ads where published=1 ORDER BY RAND() limit '.$this->cfg->nrads;
    $database->setQuery( $query );
    $ads = $database->loadObjectList();


    $query = "delete from #__rssfactory_user where UNIX_TIMESTAMP()-UNIX_TIMESTAMP(date) > 3600";
    $database->setQuery( $query );
    $database->query();

    $category = mosGetParam($arr,'cat','');

    if($task=='search'){
        $this->cfg->limitrss=0; //no limitation in search

        if ($category!=''){
            $query = "SELECT a.*,b.nrfeeds FROM #__rssfactory_cache a left join  #__rssfactory b on a.rssid=b.id where b.published = 1 and b.cat='$category' ".
                    " and (item_title like '%$searchterm%' or item_description like '%$searchterm%' ) order by a.rssid,b.ordering,a.id";
        }else{
            $query = "SELECT a.*,b.nrfeeds FROM #__rssfactory_cache a left join  #__rssfactory b on a.rssid=b.id where b.published = 1 ".
                " and (item_title like '%$searchterm%' or item_description like '%$searchterm%' ) order by a.rssid,b.ordering,a.id";
        }
    }else{
        if ($category!=''){
            $query = "SELECT a.*,b.nrfeeds,b.id feedid,b.encoding FROM #__rssfactory_cache a left join  #__rssfactory b on a.rssid=b.id where b.published = 1 and b.cat='$category' order by b.ordering,a.id";
        }else{
            $query = "SELECT a.*,b.nrfeeds,b.id feedid,b.encoding FROM #__rssfactory_cache a left join  #__rssfactory b on a.rssid=b.id where b.published = 1 order by b.ordering,a.id";
        }

    }

    $database->setQuery( $query );
    $rows = $database->loadObjectList();
    if ($this->cfg->force_output_charset==''){
        $current_encoding=_ISO;
    }else{
        $current_encoding=$this->cfg->force_output_charset;
    }
    if (strpos($current_encoding, '=')!==false) $current_encoding=substr($current_encoding,strpos($current_encoding, '=')+1);
    //Random positioning of ads
    if (count($rows)==0){
    	$rand_keys =array();
    	$rows=array();
    }
    else{
    	if (count($ads)==1){
    		$rand_keys =array(array_rand($rows, 1	));
    	}else
    	{
    		$rand_keys =(count($ads)>0)? array_rand(range(1, count($ads)), count($ads)):array();
    	}
        foreach ($rows as $row){
    			$query = "SELECT * FROM #__rssfactory_user where sid='$this->cook' and newsid=$row->id ";
    			$database->setQuery( $query );
    			if (!$database->loadResult()){
    				$img[$row->id]='exp0.gif';
    			}else {
    				$img[$row->id]='exp1.gif';
                }
                $row->item_title=change_encoding($row->item_title,$row->encoding,$current_encoding);
                $row->item_description=change_encoding($row->item_description,$row->encoding,$current_encoding);
        }
    }
    $this->html->displayFeeds($rows,$ads,$rand_keys,$this->cfg,$img);
    return;

}

	function rssfactory(&$db){
		$this->cfg=new db_rssfactory_config($db);
		$this->cfg->LoadConfig();
		//echo $this->theight;
		$this->cook = GetJoomlaSession();
		$html_class = FRONT_HTML;
		$this->html = new $html_class;

	}


}
// Class rss
class admin_rssfactory{
	var $html_admin;

	function restoreBackup(&$arr,$oparams=null){
    global $database,$option;

    $tmpfile=$_FILES['bakupfile']['tmp_name'];
    $truncate=mosGetParam($arr,'truncate','NO');
    if ($truncate=="YES") {
        $database->setQuery("truncate table #__rssfactory");
        $database->query();
    }

    $handle = fopen($tmpfile, "r");
    $count=0;
    if ($handle) {
       	while (!feof($handle)){
       		unset($categories,$urls,$nrnews);
           	$buffer = fgets($handle);
           	preg_match_all('/\/\*category=(.*?)\*\//',$buffer,$categories);
           	preg_match_all('/\/\*url=(.*?)\*\//',$buffer,$urls);
           	preg_match_all('/\/\*nrnews=(.*?)\*\//',$buffer,$nrnews);
			$category[] = $categories[1][0];
           	$url[] = $urls[1][0];
           	$nrfeeds[] = $nrnews[1][0];
           	$database->setQuery($buffer);
	        if ($database->query()){
				$count++;
			}
        }
       fclose($handle);
    }
	$this->html_admin->ShowRestoredBackup($option,$category,$url,$nrfeeds);
	//mosRedirect( "index2.php?option=$option&mosmsg=Backup+Restored+$count+Feeds+Added" );

}
	function generateBackup(&$arr,$oparams=null){
	    global $database;

	    $backupname="rss_reader2_backup".date('Y-m-d').".sql";

	    $database->setQuery("select * from #__rssfactory");
	    $rows = $database->loadObjectList();
	    $csv="";
	    foreach($rows as $row)
	    {
	        $InsertDump = "INSERT INTO #__rssfactory VALUES (";
	        $arr = mosObjectToArray($row);
	        foreach($arr as $key => $value)
	        {
	            $value = mysql_real_escape_string( $value );
	            $value = str_replace( "\n", '\r\n', $value );
	            $value = str_replace( "\r", '', $value );
	            $InsertDump .= "'$value',";
	        }
	        $csv .= rtrim($InsertDump,',') . ") /*category=".$row->cat."*//*url=".$row->url."*//*nrnews=".$row->nrfeeds."*/;\n";
	    }
	    $filesize=strlen($csv);

		header("Expires: 0");
	    // HTTP/1.1
	    header("Cache-Control: no-store, no-cache, must-revalidate");
	    header("Cache-Control: post-check=0, pre-check=0", false);
	    // HTTP/1.0
	    header("Pragma: no-cache");
	    header("Content-type: text/csv");
	    header('Content-Disposition: attachment; filename="'.$backupname.'"');
	    header("Content-Length: $filesize");

	    echo $csv;
	    exit;
	}
	function showRestore(&$arr,$oparams=null){
		global $option;

	     $this->html_admin->ShowRestoreBackup($option);

	}
	function saveCSV(&$arr,$oparams=null) {
		global $database,$option;

	    $tmpfile=$_FILES['csvfile']['tmp_name'];
	    $csvsep=mosGetParam($arr,'csvseparator','TAB');
	    if ($csvsep=="TAB") $csvsep="\t";

	    $handle = fopen($tmpfile, "r");
	    $count=0;
	    while (($data = fgetcsv($handle, 10000, $csvsep)) !== FALSE) {
	        $cat=$data[0];
	        $title=$data[1];
	        $url=$data[2];
	    	$row = new mosRSSReader( $database );
	        $row->title=$title;
	        $row->cat=$cat;
	        $row->url=$url;
	        $row->published=1;
	        $row->ordering=$count;
	        if ($row->store()) $count++;
	       // var_dump($row);
	    }
	    fclose($handle);

		mosRedirect( "index2.php?option=$option&mosmsg=$count+Feeds+Added" );

	}

	function showImportCSV(&$arr,$oparams=null) {
		global $option;
		$this->html_admin->ShowImport($option);
	}

	function saveRSS(&$arr,$oparams=null) {
		global $database,$handle,$option;

		$row = new mosRSSReader( $database );
		if (!$row->bind( $arr )) {
			echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}
	    SaveSiteIco_file($row);
		if (!$row->store()) {
			echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}

		mosRedirect( "index2.php?option=$option&mosmsg=Rss+saved" );
	}

	function orderRSS( &$arr,$oparams=null) {
		global $database,$option;
		$uid = mosGetParam($arr,'cid',array());
		$inc = $oparams;
		$query = "select ordering from #__rssfactory where id = $uid";
		$database->setQuery( $query );
		$ord = $database->loadResult();

		if ( $inc == -1 ) {
			$query = "update #__rssfactory set ordering = ordering + 1 where ordering = ".($ord-1);
			$database->setQuery( $query );
			$database->query();

			$query = "update #__rssfactory set ordering = ".($ord - 1)." where id=$uid";
			$database->setQuery( $query );
			$database->query();

		} else if ($inc == 1 ) {
			$query = "update #__rssfactory set ordering = ordering - 1 where ordering = ".($ord + 1);
			$database->setQuery( $query );
			$database->query();

			$query = "update #__rssfactory set ordering = ".($ord + 1)." where id=$uid";
			$database->setQuery( $query );
			$database->query();
		}

		mosRedirect( "index2.php?option=$option" );
	}

	function editRSS( &$arr,$oparams=null ) {
		global $database,$option;
		$build = array();
		$cid = mosGetParam($arr,'cid',array());
		$id = $cid['0'];
		if ( $id == '') {
			$database->setQuery( "SELECT max(ordering) FROM #__rssfactory" );
			$max = $database->loadResult();
		}

		$row = new mosRSSReader( $database );
		$row->load( $id );

		if ( $id == '') {
			$new_ord = $max + 1;
			$row->published = 1;
			$row->approved = 1;
			$row->ordering = $new_ord;
			$build['ordering'] = "<input type=\"hidden\" name=\"ordering\" value=\"$new_ord\">New items default to the last place";
			$build['published'] = mosHTML::yesnoRadioList('published','class="inputbox"',$row->published);
		} else {
			$query = "select ordering as value, title as text from #__rssfactory order by cat,ordering";
			$build['ordering'] = mosAdminMenus::SpecificOrdering($row,$id,$query,1);
			$build['published'] = mosHTML::yesnoRadioList('published','class="inputbox"',$row->published);
		}
		$database->setQuery('select distinct cat value,cat text from #__rssfactory');
		$cats=$database->loadResultArray();

		$categories[] = mosHTML::makeOption( '', _SEL_CATEGORY );
		$database->setQuery( 'select distinct cat as value,cat as text from #__rssfactory' );
		$categories = array_merge( $categories, $database->loadObjectList() );
		$build['category'] = mosHTML::selectList( $categories, 'helpcat', 'class="inputbox" size="1" onchange="catchange();"', 'value', 'text', $row->cat );


		$this->html_admin->edit( $option, $row, $build,$id );
	}

	function delRSS(&$arr,$oparams=null ) {
		global $database,$option;
		$cid = mosGetParam($arr,'cid',array());
		if (!is_array( $cid ) || count( $cid ) < 1) {
			echo "<script> alert('Select an item to delete'); window.history.go(-1);</script>n";
			exit;
		}
		if (count( $cid )) {
			$cids = implode( ',', $cid );
			$database->setQuery( "DELETE FROM #__rssfactory WHERE id IN ($cids)" );
			if (!$database->query()) {
				echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>n";
			}
			$database->setQuery("delete from #__rssfactory_cache where rssid in ($cids)");
			if (!$database->query()) {
				echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>n";
			}
		}
		mosRedirect( "index2.php?option=$option&mosmsg=RSS+deleted" );
	}

	function showLinks(&$arr,$oparams=null) {
		global $database, $mainframe, $mosConfig_list_limit,$option;
		$search=mosGetParam($arr,'search','');
		$catid=mosGetParam($arr,'catid','');
		$publish=mosGetParam($arr,'publish_filter','');

		$where='1=1';
		$where.=($search=="")?"":" and title like '%$search%' ";
		$where.=($catid=="")?"":" and cat='$catid' ";
		$where.=($publish=="")?"":" and published=$publish ";

		$limit = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit );
		$limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );

		$database->setQuery( "SELECT count(*) FROM #__rssfactory where $where" );
		$total = $database->loadResult();

		require_once( $GLOBALS['mosConfig_absolute_path'] . '/administrator/includes/pageNavigation.php' );
		$pageNav = new mosPageNav( $total, $limitstart, $limit );
		$database->setQuery( "SELECT * FROM #__rssfactory where $where ORDER BY cat,ordering,id",$pageNav->limitstart,$pageNav->limit);
		$rows = $database->loadObjectList();

		if ($database->getErrorNum()) {
			echo $database->stderr();
			return false;
		}
		$lists=array();
		$lists['catid']=filterCategory();
		$lists['published']=filterPublished();
		$this->html_admin->showLinks( $option, $rows, $pageNav,$lists);
	}

	function publishRSS(&$arr,$oparams=1 ) {
		global $database, $my, $option;
		$cid = mosGetParam($arr,'cid',array());
		$publish = $oparams;
		$catid = mosGetParam( $arr, 'catid', array(0) );

		if (!is_array( $cid ) || count( $cid ) < 1) {
			$action = $publish ? 'publish' : 'unpublish';
			echo "<script> alert('Select an item to $action'); window.history.go(-1);</script>\n";
			exit;
		}

		$cids = implode( ',', $cid );

		$database->setQuery( "UPDATE #__rssfactory SET published='$publish' WHERE id IN ($cids)");
		if (!$database->query()) {
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		}

		if (count( $cid ) == 1) {
			$row = new mosRSSReader( $database );
		}
		mosRedirect( "index2.php?option=$option" );
	}

	//--ads
	function saveAds( &$arr,$oparams=null ) {
		global $database,$handle,$option;

		$row = new rssreader_ads( $database );
		if (!$row->bind( $arr )) {
			echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}

		if (!$row->store()) {
			echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}

		mosRedirect( "index2.php?option=$option&task=showads&mosmsg=AD+saved" );
	}


	function editAds( &$arr,$oparams=null ) {
		global $database,$option;
		$build = array();
		$cid = mosGetParam($arr,'cid',array());
		$id = $cid['0'];

		$row = new rssreader_ads( $database );
		$row->load( $id );
		$build['published'] = mosHTML::yesnoRadioList('published','class="inputbox"',$row->published);

		$this->html_admin->editAds( $option, $row, $build,$id );

	}

	function delAds( &$arr,$oparams=null ) {
		global $database,$option;
		$cid = mosGetParam($arr,'cid',array());
		if (!is_array( $cid ) || count( $cid ) < 1) {
			echo "<script> alert('Select an item to delete'); window.history.go(-1);</script>n";
			exit;
		}
		if (count( $cid )) {
			$cids = implode( ',', $cid );
			$database->setQuery( "DELETE FROM #__rssfactory_ads WHERE id IN ($cids)" );
			if (!$database->query()) {
				echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>n";
			}
		}
		mosRedirect( "index2.php?option=$option&task=showads&mosmsg=AD+deleted" );
	}

	function showAds( &$arr,$oparams=null ) {
		global $database, $mainframe, $mosConfig_list_limit,$option;

		$limit = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit );
		$limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );

		$database->setQuery( "SELECT count(*) FROM #__rssfactory_ads" );
		$total = $database->loadResult();

		require_once( $GLOBALS['mosConfig_absolute_path'] . '/administrator/includes/pageNavigation.php' );
		$pageNav = new mosPageNav( $total, $limitstart, $limit );
		$database->setQuery( "SELECT * FROM #__rssfactory_ads ORDER BY id" ,$pageNav->limitstart,$pageNav->limit);
		$rows = $database->loadObjectList();

		if ($database->getErrorNum()) {
			echo $database->stderr();
			return false;
		}
		$javascript = 'onchange="document.adminForm.submit();"';
		$this->html_admin->showAds( $option, $rows, $pageNav);
	}

	function publishAds( &$arr,$oparams=1  ) {
		global $database, $my,$option;
		$cid = mosGetParam($arr,'cid',array());
		$publish = $oparams;
		$catid = mosGetParam( $arr, 'catid', array(0) );

		if (!is_array( $cid ) || count( $cid ) < 1) {
			$action = $publish ? 'publish' : 'unpublish';
			echo "<script> alert('Select an item to $action'); window.history.go(-1);</script>\n";
			exit;
		}

		$cids = implode( ',', $cid );

		$database->setQuery( "UPDATE #__rssfactory_ads SET published='$publish' WHERE id IN ($cids)");
		if (!$database->query()) {
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		}

		if (count( $cid ) == 1) {
			$row = new rssreader_ads( $database );
		}
		mosRedirect( "index2.php?option=$option&task=showads" );
	}

	function showConfig( &$arr,$oparams=null ) {
		global $database,$option;
	    $row= new db_rssfactory_config($database);
	    $row->LoadConfig();
	    require_once($GLOBALS['mosConfig_absolute_path']."/administrator/components/$option/version_info.php");
	    $version=new component_version_info($option);
		$this->html_admin->showConfig( $option,$row,$version);

	}

	function saveConfig( &$arr,$oparams=null ) {
		global $database,$handle,$mosConfig_absolute_path,$option;
		$tab_path = $mosConfig_absolute_path."/components/com_rss/images/";
		define(TAB_IMAGES_PATH,$tab_path);
		$row = new db_rssfactory_config( $database );
		if (!$row->bind( $arr )) {
			echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}
		$row->table_view_open=($row->table_view_open)?$row->table_view_open:0;


		$txt = array();
	    foreach ($arr as $k=>$v){
	        if (in_array($k,$row->getParamnames())){
				if (get_magic_quotes_gpc()) {
					$v = stripslashes( $v );
				}
				$txt[] = "$k=$v";
	        }
	    }
	    $row->params = implode( "\n", $txt );
		if (!$row->store()) {
			echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}

		$ol_cfg_file=$mosConfig_absolute_path."/components/$option/overlib.config.php";
	    $ol_cfg="<?php
	        define('OL_FGCOLOR','".mosGetParam($arr,'ol_fgcolor')."');
	        define('OL_BGCOLOR','".mosGetParam($arr,'ol_bgcolor')."');
	        define('OL_TXCOLOR','".mosGetParam($arr,'ol_txcolor')."');
	        define('OL_CAPCOLOR','".mosGetParam($arr,'ol_capcolor')."');
	        define('OL_TXSIZE','".mosGetParam($arr,'ol_txsize')."');
	        define('OL_CAPSIZE','".mosGetParam($arr,'ol_capsize')."');
	        define('OL_BORDERSIZE','".mosGetParam($arr,'ol_bordersize')."');
	        ?>";
	    chmod($ol_cfg_file,0766);
	    if (!is_writable($ol_cfg_file)){
			echo "<script> alert('".$ol_cfg_file." is not writable. Overlib Colors not saved!'); </script>\n";
			echo "<script>  window.history.go(-1); </script>\n";
			exit();
	    }else{
	        if ($fp=fopen($ol_cfg_file, 'w+')) {
			      fputs($fp, $ol_cfg, strlen($ol_cfg));
			      fclose($fp);
	        }
	    }

	    if($_FILES['st_image']){
	  			$file_name = "tab_active.png";
	  			echo $file_name;
	    		echo $path = TAB_IMAGES_PATH.$file_name;
	    		move_uploaded_file($_FILES['st_image']['tmp_name'], $path);
	    	}
	    if($_FILES['ht_image']){
	  			$file_name = "tab_hover.png";
	    		$path = TAB_IMAGES_PATH."/".$file_name;
	    		chmod($path,0777);
	    		move_uploaded_file($_FILES['ht_image']['tmp_name'], $path);

	    	}
	     if($_FILES['sit_image']){
	  			$file_name = "tab.png";
	    		$path = TAB_IMAGES_PATH."/".$file_name;
	    		chmod($path,0777);
	    		move_uploaded_file($_FILES['sit_image']['tmp_name'], $path);
	    	}

		mosRedirect( "index2.php?option=$option&task=showconfig","Config saved successfully" );
	}

	function CategoryManager( &$arr,$oparams=null )
	{
		global $database,$handle,$option;


		$database->setQuery( "SELECT distinct cat FROM #__rssfactory " );
		$rows = $database->loadObjectList();
		$this->html_admin->showCatManager( $option,$rows);

	}
	function SaveCategories( &$arr,$oparams=null )
	{
		global $database,$handle,$option;
		$nrcats = mosGetParam( $arr, 'nrcats', 0 );
		for ($i=1;$i<=$nrcats;$i++){
	        $oldcat=mosGetParam( $arr, 'cat_orig_'.$i);
	        $newcat=mosGetParam( $arr, 'cat_new_'.$i );
	        $delecat=mosGetParam( $arr, 'cat_delete_'.$i, 0 );
	        if ($delecat){
	        	$database->setQuery( "update #__rssfactory set cat=null where cat='$oldcat'" );
	        	$database->query();

	        }else if ($newcat!==$oldcat){
	        	$database->setQuery( "update #__rssfactory set cat='$newcat' where cat='$oldcat'" );
	        	$database->query();
	        	if ($oldcat==''){
	            	$database->setQuery( "update #__rssfactory set cat='$newcat' where cat is null" );
	            	$database->query();
	            }
	        }
	    }
		mosRedirect( "index2.php?option=$option&mosmsg=Categories+saved" );
	}
	function ShowAboutBox( &$arr,$oparams=null )
	{
		global $option;
	    require_once($GLOBALS['mosConfig_absolute_path']."/administrator/components/$option/version_info.php");
	    $version=new component_version_info($option);
		$this->html_admin->showAbout( $option,$version);
	}

	function admin_rssfactory(&$db){
		$html_class = BACK_HTML;
		$this->html_admin = new $html_class;
	}
}
?>