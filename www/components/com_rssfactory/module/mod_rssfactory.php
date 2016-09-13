<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

if(file_exists($mosConfig_absolute_path."/components/com_rssfactory_pro/rssfactory_pro.config.php")){
	require_once( $mosConfig_absolute_path."/components/com_rssfactory_pro/rssfactory_pro.config.php");
}elseif(file_exists($mosConfig_absolute_path."/components/com_rssfactory/rssfactory.config.php")){
	require_once( $mosConfig_absolute_path."/components/com_rssfactory/rssfactory.config.php");
}else {
	echo "You have to have an installed copy of RSS Factory (c) The Factory Team.";
    echo "To get one copy <a target='_blank' href='http://www.thefactory.ro/shop/joomla-components-and-modules.html'> go here and order one! </a>";
}
global $option,$task;

$class = CLASSNAME;
$rss_path=$mosConfig_absolute_path."/components/com_$class/";

if(!class_exists($class)){
	require_once( $rss_path.$class.".class.php");
}

$html_class = FRONT_HTML;
if(!class_exists($html_class)){
	require_once( $rss_path.$class.".html.php");
}


require_once( $rss_path.$class.".functions.php");
require_once( $rss_path."overlib.config.php");
if ($option!=='rssfactory' && $option!=='com_rssfactory' && $option!=='com_rssfactory_pro' && $option!=='rssfactory_pro' ) {
?>
    <script>
        var ol_fgclass='';
        var ol_bgclass='';
        var ol_textfontclass='';
        var ol_captionfontclass='';
        var ol_closefontclass='';
    </script>
    <script language="JavaScript" src="<?php echo $mosConfig_live_site; ?>/components/com_<?php echo $class;?>/rssfactory.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo $mosConfig_live_site; ?>/components/com_<?php echo $class;?>/css/rss_css.css" />
<?php
}


if (!function_exists('overlibInitCall')) {
	function overlibInitCall () {
		global $mosConfig_live_site;
		$txt = "";
		$txt .=  '<script language="javascript"> '."\n";
		$txt .=  "  if ( !document.getElementById('overDiv') ) {  "."\n";
		$txt .=  "     document.writeln('<div id=\"overDiv\" style=\"position:absolute; visibility:hidden; z-index:10000;\"></div>'); "."\n";
		$txt .=  "     document.writeln('<scr'+'ipt language=\"Javascript\" src=\"" .$mosConfig_live_site. "/includes/js/overlib_mini.js\"></scr'+'ipt>'); "."\n";
		$txt .=  "  } "."\n";
		$txt .=  "</script> "."\n";
		return $txt;
	}
}
if (!function_exists('htmlspecialchars_decode')) {
       function htmlspecialchars_decode($str) {
               $trans = get_html_translation_table(HTML_SPECIALCHARS);

               $decode = ARRAY();
               foreach ($trans AS $char=>$entity) {
                       $decode[$entity] = $char;
               }

               $str = strtr($str, $decode);
               return $str;
       }
}
$cfg=new db_rssfactory_config($database);
$cfg->LoadConfig();
if($config->use_pseudocron && PseudoCron($config))
		HTML_rssfactory::PseudoCron();

$moduleclass_sfx 	= $params->get( 'moduleclass_sfx' );
$sort_order			=$params->get( 'sort_order' );
$nr_feeds			=$params->get( 'nr_feeds' );
$adv_filter			=$params->get( 'adv_filter' );
$show_Category		=$params->get( 'show_Category' );
$nrchar				=$params->get( 'nrchars' );
$showfeeddescription=$params->get( 'showfeeddescription' );
$table_view_open	=$params->get( 'table_view_open' );
$hide_icon			=$params->get( 'hide_icon' );
$hide_date			=$params->get( 'hide_date' );
$hide_bullet		=$params->get( 'hide_bullet' );

$cfg->showfeeddescription=$showfeeddescription;
$cfg->table_view_open=$table_view_open;
$cfg->hideBullet=$hide_bullet;
$cfg->hideDate=$hide_date;
$cfg->use_favicons=$hide_icon;

if ($cfg->force_charset!='') $mainframe->addMetaTag( 'Content-Type', 'text/html; charset='.$cfg->force_charset );



echo overlibInitCall ();

if ($sort_order=="1") $order=" order by item_date desc ";
if ($sort_order=="2") $order=" order by RAND() ";

$where=($show_Category=="")?"":" left join  #__rssfactory b on a.rssid=b.id where b.cat='$show_Category' ";

if ($adv_filter && ($option=='com_content' || $option=='content')&&($task='view')){
	$id=mosGetParam($_REQUEST,'id','');
	if ($id){
		$database->setQuery("select * from #__content where id=$id");
		$row=null;
		$database->LoadObject($row);
		$curcat=$row->catid;
		for($i=1;$i<=9;$i++){
			if ($curcat==$params->get( "catid$i" )){
				$where=" left join #__rssfactory b on a.rssid=b.id where b.cat='".$params->get( "show_Category$i" )."' ";
				break;
			}
		}
	}
}

$database->setQuery("select a.* from #__rssfactory_cache a $where $order limit $nr_feeds");
$rows=$database->LoadObjectList();

$cook = GetJoomlaSession();
$i=0;
echo "<div id='feedtable$moduleclass_sfx'><table width='100%' id='feedtable'>";
for ($i=0;$i<count($rows);$i++){
       /*@var $row rsscache_db*/
       $row=$rows[$i];
		$query = "SELECT * FROM #__rssfactory_user where sid='$cook' and newsid=$row->id ";
		$database->setQuery( $query );
		if (!$database->loadResult()){
			$img[$row->id]='exp0.gif';
		}else {
			$img[$row->id]='exp1.gif';
		}
		//show first x chars in title
		if($nrchars)
			$row->item_title = substr($row->item_title,0,$nrchars-1);

        switch ($config->showfeeddescription){
            case "table":
                eval(FRONT_HTML.'::PrintTableCell($row,$cfg,$img,"M_".$module->id."_");');
            break;
            default:
            case "overlib":
                eval(FRONT_HTML.'::PrintOverlibCell($row,$cfg,$img,"M_".$module->id."_");');
            break;
        }
}

echo "</table></div>";

?>