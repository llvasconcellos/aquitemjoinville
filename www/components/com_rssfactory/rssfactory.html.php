<?php
/**
* @package rssFactory
* @version 1.0
* @copyright www.thefactory.ro
* @license: commercial
*/
defined( '_VALID_MOS' ) or die( 'Restricted access' );
class HTML_rssfactory {
   function PseudoCron(){
	 	global $mosConfig_live_site;

		if (isset($_SESSION['secretkey'])){

			echo "<iframe height=\"0\" width=\"0\" src=\"".COMPONENT_PATH."pseudorefresh.php?key=".md5($_SESSION['secretkey'])."\" FRAMEBORDER=0 name=\"cronframe\"></iframe>";
		}
	}
   function displayCats( &$description,&$categories,&$config ) {
		global $database,$Itemid;
		echo overlibInitCall ();
    ?>
	<?php if ($config->showSearch) { ?>
	<script>
	        function getcontent(id){
            if (document.getElementById){
                el=document.getElementById(id);
                if (el) return el.innerHTML;
            }

            return '&nbsp;';
        }
	</script>
	<script language="JavaScript" src="<?php echo COMPONENT_PATH.'rssfactory.js';?>" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo COMPONENT_PATH;?>css/rss_css.css" />
	<form name="rsssearchform" method="get" action="index.php">
	<input type="hidden" name="option" value="com_rssfactory">
	<input type="hidden" name="task" value="search">
	<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>">
	<?php } ?>

	<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" class="contentpane">
		<tr>
			<td colspan="2" class="componentheading" width="60%"><?php echo $description ?>
			</td>
		</tr>
	<tr><td colspan="2" width="500">&nbsp;</td></tr>
	<?php if ($config->showSearch) { ?>
	<tr><td>&nbsp;</td><td align="right">Busca nas Notícias:<input type="text" class="rsssearchbox" name="search"> </td></tr>
	<?php } ?>
    <tr><td colspan="2"><ul>
	<?php
	$listcat='';
    if ($config->force_output_charset==''){
        $current_encoding=_ISO;
    }else{
        $current_encoding=$config->force_output_charset;
    }
    if (strpos($current_encoding, '=')!==false) $current_encoding=substr($current_encoding,strpos($current_encoding, '=')+1);

	if (count($categories )){
		foreach($categories as $cat) {
			$link=sefRelToAbs('index.php?option=com_rssfactory&task=showcat&cat='.urlencode($cat['cat']).'&Itemid='.$Itemid);

			$database->setQuery("
			     select count(*) from
                      #__rssfactory left join #__rssfactory_cache on #__rssfactory.id=#__rssfactory_cache.rssid
                 where cat='".$cat['cat']."'
			");
        	$nrFeeds=$database->loadResult();

			$listcat.='<li><a href="'.$link.'" class="category">'.$cat['cat'].'</a>&nbsp;<i>( '.
					$nrFeeds.' notícias / '.
					$cat['Nr'].' fontes )</i></li>';
			if ($config->cat_previewnr>0) { //nrpreview_feeds>0
				$database->query();
				$query = "SELECT a.*,b.nrfeeds,b.id feedid,b.encoding FROM #__rssfactory_cache a left join  #__rssfactory b on a.rssid=b.id where b.published = 1 and b.cat='".$cat['cat']."' order by b.ordering,a.id";
				$database->setQuery( $query ,0,$config->cat_previewnr);
				$rows = $database->loadObjectList();
				if ($rows){
					$listcat.='<ul>';
					foreach($rows as $row){
						$row->item_title=change_encoding($row->item_title,$row->encoding,$current_encoding);
						$row->item_description=change_encoding($row->item_description,$row->encoding,$current_encoding);

						$listcat.="<li><span onmouseover=\"return overlib(getcontent('ICONT$row->id'));\" onmouseout='nd();'>".$row->item_title."</span></li>";
						$listcat.="<div style=\"display: none;\" class=\"excerpt\" id=\"ICONT$row->id\">";
						$string=preg_replace('/\<script(.*?)>(.*?)\<\/script\>/','',htmlspecialchars_decode(rawurldecode($row->item_description)));
	     				$string=preg_replace('/\<script(.*?)\/>/','',$string);
	     				$listcat.=$string."</div>";
					}
					$listcat.='<li><a href="'.$link.'" class="category">... mais notícias</a></li></ul><br>';
				}

			}

		}
	}else{
		$listcat='<strong>Sem notícias no momento ...</strong>';
	}

	echo $listcat;
	?>
	</ul></td></tr></table>
	<?php if ($config->showSearch) { ?>
	</form>
	<?php }
	if($config->use_pseudocron && PseudoCron($config))
			HTML_rssfactory::PseudoCron();

   }
   function displayFeeds(&$rows,&$ads,&$rand_keys,&$config,&$img){
       global $mosConfig_live_site,$Itemid;

       /*@var $config db_rssfactory_config */
   	    echo overlibInitCall ();
        if ($config->liststyle=='tabbed'){
            $tabs = new mosTabs(0);
        }
        if ($config->showfeeddescription=='overlib'){
            ?>
            <script>
                var ol_fgclass='';
                var ol_bgclass='';
                var ol_textfontclass='';
                var ol_captionfontclass='';
                var ol_closefontclass='';
            </script>
            <?php
        }

     ?>
		<script language="JavaScript" src="<?php echo COMPONENT_PATH.'rssfactory.js';?>" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo COMPONENT_PATH;?>css/rss_css.css" />

       	<style type="text/css">
	     .dynamic-tab-pane-control .tab-row .tab.selected {
			width: <?php echo $config->twidth;?>px !important;
			height: <?php echo $config->theight;?>px !important;
			background-image:	url( components/com_rssfactory/images/tab_active.png ) !important;
			background-repeat: no-repeat;
			border-bottom-width:	0;
			z-index: 3;
			margin: 1px -1px -10px 0px;
			padding-top: 10px;
			top: -2px;
			font: 12px Arial,Helvetica,sans-serif;


		}
	    .dynamic-tab-pane-control .tab-row .tab {
			width: <?php echo $config->twidth;?>px;
			height: <?php echo $config->theight;?>px;
			background-image: url( components/com_rssfactory/images/tab.png );
			position: relative;
			top: 0;
			display: inline;
			float: left;
			overflow: hidden;
			cursor: pointer;
			margin: 1px -1px -10px 0px;
			padding-top: 10px;
			border: 0;
			z-index: 1;
			font: 12px Arial,Helvetica,sans-serif;
			white-space: nowrap;
			text-align: center;
		}
	    .dynamic-tab-pane-control .tab-row .tab.hover {
			font:	12px Tahoma, Helvetica, sans-serif;
			width: <?php echo $config->twidth;?>px;
			height: <?php echo $config->theight;?>px;
			background-image:	url( components/com_rssfactory/images/tab_hover.png );
			background-repeat: no-repeat;
		}
     	</style>
    	<?php if ($config->showSearch) { ?>
        <form name="rsssearchform" method="get" action="index.php">
    	<input type="hidden" name="option" value="com_rssfactory">
    	<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>">
     	<input type="hidden" name="cat" value="<?php echo mosGetParam( $_REQUEST, 'cat', "" ) ?>">
       	<input type="hidden" name="task" value="search">
    	<?php }
    	if ($config->showcategory){
    	?>
			<div align='center'><a href='index.php?option=com_rssfactory&Itemid=<?php echo $Itemid;?>'>Voltar para categorias « </a></div>
    	<?php
    	}
    	?>
        <table class="rsscontainer" width="100%">
        <?php if (!$config->showcategory && $config->description) { ?>
		<tr>
			<td colspan="2" class="componentheading" width="60%"><?php echo $config->description ?>
			</td>
		</tr>
    	<tr><td colspan="2" width="500">&nbsp;</td></tr>
    	<?php } ?>
    	<?php if ($config->showSearch) { ?>
        	<?php if (mosGetParam( $_REQUEST, 'search', "" )!="") { ?>
            	<tr><td align="center">Resultados da busca por "<?php echo mosGetParam( $_REQUEST, 'search', "" )  ?>"</td></tr>
        	<?php } ?>
    	<tr><td align="right">Busca nas notícias:<input type="text" class="rsssearchbox" name="search"> </td></tr>
    	<?php }

    	$j=0;
    	$curid=-1;
        $k=0;
        if ($config->liststyle=='tabbed'){
		  echo "</table>";

          $tabs->startPane("feedsPane");

        }
        $wastab=0;

        foreach ($rows as $row){

            if ($curid!=$row->rssid){
                $i=0;
                if ($config->liststyle=='tiled'){
                	if ($curid!=-1) echo "</tbody></table></td></tr><tr class='feedseparator'><td>&nbsp;</td></tr>";
                }
                //ads

                if ($config->liststyle=='tiled'){
                 ?>
                 <tr><td>
                	<table class=feedtable>
                	<tbody>
                    <tr><td>
                        <table class=feedtableheader>
                    	<tbody>
                        	<tr>
                                <td ><span class=rsstitle><?php echo $row->channel_title ?></span> <!--(5)--></td>
                                <td  width='5%'nowrap='nowrap' align='right'><!--$newestdat--></td>
                            </tr>
            	       </table>
            	       </tbody>
        	        </td></tr>

                 <?php
                 }
                 if ($config->liststyle=='tabbed'){
                    if ($wastab!=0) {
						echo "</tbody></table>";
						$tabs->endTab();
					}
                    $tabs->startTab($row->channel_title,"aatab_$row->feedid");
                    $wastab=1;
                    ?>
                	<table class=feedtable>
                	<tbody>
                    <?php
                  }

            }else{
                $i++;
                if (($config->limitrss)&&($i>=$row->nrfeeds)&&($row->nrfeeds>0)) continue; // limit to nrfeeds
            }
            $curid=$row->rssid;

        	foreach ($rand_keys as $key1){
        		if ($key1==$k) {
        		?>
        		  <tr ><td class="rss_ads"><?php echo stripslashes($ads[$j]->Adtext);?></td ></tr >
        		<?php
        		$j++;
        		}
        	}
        	$k++;
            switch ($config->showfeeddescription){
            case "table":
                HTML_rssfactory::PrintTableCell($row,$config,$img);
            break;
            default:
            case "overlib":
                HTML_rssfactory::PrintOverlibCell($row,$config,$img);
            break;
           }
        }
    if ($config->liststyle=='tabbed'){
		if ($wastab!=0) {
			echo "</tbody></table>";
			$tabs->endTab();
		}
        $tabs->endPane();

    }

	if ($config->liststyle=='tiled'){
		if ($curid!=-1) echo "</tbody></table></td></tr><tr class='feedseparator'><td>&nbsp;</td></tr>";
	}
	if ($config->liststyle=='tabbed'){
	//	if ($curid!=-1) echo "</tbody></table>";
	}
	?>
	</table>

	<?php
	if ($config->showSearch) {
		echo "</form>";
	 }
	if (!count($row)) echo '<strong>Sem notícias no momento ...</strong>';

	if($config->use_pseudocron && PseudoCron($config))
			HTML_rssfactory::PseudoCron();


   }
   function PrepareString($in_string)
   {
        $string=str_replace('<a href=','<a rel="nofollow" target="_blank" href=',htmlspecialchars_decode(rawurldecode( $in_string)));
 		$string=preg_replace('/\<script(.*?)>(.*?)\<\/script\>/','',$string);
 		$string=preg_replace('/\<script(.*?)\/>/','',$string);
 		$string=preg_replace('/\<object(.*?)\>/','',$string); // IE operation aborted" bug
 		$string=preg_replace('/\<\/object\>/','',$string);

       return $string;
   }

   function PrintTableCell($row,$config,$img,$prefix='')
   {
      /*@var $config db_rssfactory_config*/
    global $mosConfig_live_site,$mosConfig_absolute_path;
	$desc2="return overlib(URLDecode('".urlencode($row->channel_title )."'), BELOW, RIGHT,VAUTO,WIDTH,350,
            FGCOLOR,'".OL_FGCOLOR."',BGCOLOR,'".OL_BGCOLOR."',
            TEXTCOLOR ,'".OL_TXCOLOR."',CAPCOLOR,'".OL_CAPCOLOR."',
            TEXTSIZE ,".OL_TXSIZE.",CAPTIONSIZE,".OL_CAPSIZE.",
            BORDER , ".OL_BORDERSIZE.");";


    ?>
        <tr><td class=feedlist>
	     <span class=feedline>
	     <?php if (!$config->hideBullet){ ?>
			<img class="feedbump" name='img<?php echo $row->id ?>' src="<?php echo COMPONENT_PATH;?>images/<?php echo $img[$row->id]?>" />
		 <?php } ?>
			<?php if ($config->use_favicons) echo  HTMLCreateSiteIco($row); ?>
	     <?php if (!$config->hideDate){ ?>
            <span class=feeddate><?php echo ($row->item_date=='')?date($config->date_format.', ',strtotime($row->date)):date($config->date_format.', ',strtotime($row->item_date)); ?>
	        </span>
		 <?php } ?>
    		  <span id=rsslink onclick="opendiv('<?php echo $prefix;?>ICONT<?php echo $row->id ?>');" style="cursor: pointer">
                <span class=feedtablelink> <?php echo rawurldecode($row->item_title )?></span></span>
                <span class="channellink"><a rel="nofollow" target="_blank" class=feedtablelink onmouseout="return nd();" onmouseover="<?php echo $desc2 ?>" href="<?php echo $row->channel_link ?>" >»»</a></span>
        </span>
	    <div style="display: <?php echo ($config->table_view_open=='1')?'block':'none' ?>;" class="excerpt" id="<?php echo $prefix;?>ICONT<?php echo $row->id ?>">
	     <?php
	           echo HTML_rssfactory::PrepareString(htmlspecialchars_decode(rawurldecode( $row->item_description)));
	     		?><br>
	     		<a <?php if ($cfg->output_iframe=='') { ?>target="_blank"<?php } ?> class=feedtablelink onclick="swapimg('img<?php echo $row->id ?>');"
                    href="<?php echo sefRelToAbs('index.php?option=com_rssfactory&task=visit&linkvisited='.$row->id); ?>">
             <span class="readmore">Leia mais...</span></a>
        </div>
        </td></tr>
    <?php
   }
   function PrintOverlibCell($row,$config,$img,$prefix='')
   {
        /*@var $config db_rssfactory_config*/
    global $mosConfig_live_site;
	$desc2="return overlib(URLDecode('".urlencode($row->channel_title )."'), BELOW, RIGHT,VAUTO,WIDTH,350,
            FGCOLOR,'".OL_FGCOLOR."',BGCOLOR,'".OL_BGCOLOR."',
            TEXTCOLOR ,'".OL_TXCOLOR."',CAPCOLOR,'".OL_CAPCOLOR."',
            TEXTSIZE ,".OL_TXSIZE.",CAPTIONSIZE,".OL_CAPSIZE.",
            BORDER , ".OL_BORDERSIZE.");";

	$desc="return overlib(getcontent('".$prefix."ICONT$row->id'),CAPTION, getcontent('CAPT$row->id'),
            BELOW, RIGHT,VAUTO,WIDTH,350,
            FGCOLOR,'".OL_FGCOLOR."',BGCOLOR,'".OL_BGCOLOR."',
            TEXTCOLOR ,'".OL_TXCOLOR."',CAPCOLOR,'".OL_CAPCOLOR."',
            TEXTSIZE ,".OL_TXSIZE.",CAPTIONSIZE,".OL_CAPSIZE.",
            BORDER , ".OL_BORDERSIZE.");";
    ?>
        <tr><td class=feedlist>
	     <span class=feedline>
        	     <?php if (!$config->hideBullet){ ?>
        			<img class="feedbump" name='img<?php echo $row->id ?>' src="<?php echo COMPONENT_PATH;?>images/<?php echo $img[$row->id]?>" />
        		 <?php } ?>
        			<?php if ($config->use_favicons) echo  HTMLCreateSiteIco($row); ?>
        	     <?php if (!$config->hideDate){ ?>
                    <span class=feeddate><?php echo ($row->item_date=='')?date($config->date_format.', ',strtotime($row->date)):date($config->date_format.', ',strtotime($row->item_date)); ?>
        	        </span>
        		 <?php } ?>
        		  <span id=rsslink>
					<a <?php if ($config->output_iframe=='') { ?>target="_blank"<?php } ?> class=feedtablelink onclick="swapimg('img<?php echo $row->id ?>');"
						onmouseout="return nd();" onmouseover="<?php echo $desc ?>"
                        href="<?php echo sefRelToAbs('index.php?option=com_rssfactory&task=visit&linkvisited='.$row->id); ?>">
                        <?php echo rawurldecode($row->item_title );?>
					</a>
                <span class="channellink"><a target="_blank" class=feedtablelink onmouseout="return nd();" onmouseover="<?php echo $desc2 ?>" href="<?php echo $row->channel_link ?>" >»»</a></span>
                 </span>
        </span>
			<div style="display: none;" class="excerpt" id="CAPT<?php echo $row->id ?>"><?php echo str_replace(chr(13),' ',str_replace(chr(10),' ',htmlspecialchars_decode(rawurldecode($row->item_title)))) ?></div>
		    <div style="display: none;" class="excerpt" id="<?php echo $prefix;?>ICONT<?php echo $row->id ?>">
	     <?php
	           echo HTML_rssfactory::PrepareString(htmlspecialchars_decode(rawurldecode( $row->item_description)));
	    ?>
        </div>
        </td></tr>
    <?php
    }
   function ShowFeedInWrapper($row,&$config)
    {
        global $database;

        /*@var $row rsscache_db*/
        /*@var $config db_rssfactory_config*/

        $rss=new mosRSSReader($database);
        $rss->load($row->rssid);
        if ($config->showcategory)
            $link=sefRelToAbs('index.php?option=com_rssfactory&task=showcat&cat='.$rss->cat);
        else
            $link=sefRelToAbs('index.php?option=com_rssfactory');
        ?>
            <div><a href="<?php echo $link;?>"><<&nbsp;Voltar para as notícias</a></div>
            <iframe style="width:100%;height:<?php echo $config->iframe_height;?>px;border:0;" src="<?php echo $row->item_link;?>"></iframe>
        <?php
    }

}
?>