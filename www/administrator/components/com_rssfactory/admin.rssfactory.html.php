<?php
/**
* @package rssFactory
* @version 1.0
* @copyright www.thefactory.ro
*/

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

class HTML_RSSReader {

	function edit( $option, &$row, &$build, $id ) {
	    /*@var $row db_rssfactory_config*/
	   global $mosConfig_live_site;
		mosMakeHtmlSafe($row,ENT_QUOTES,'description');
	  $xajax=InitializeXajax();
	  $xajax->printJavascript(XAJAX_PATH);
	  $xajax->errorHandlerOn();
	  mosCommonHTML::loadOverlib();

	?>
	<script language="javascript" type="text/javascript">
	function catchange() {
		var form = document.adminForm;
		form.cat.value=form.helpcat.value;
	}
	function submitbutton(pressbutton) {
		var form = document.adminForm;
		if ( pressbutton == 'cancel') {
			submitform(pressbutton);
			return;
		}
		if (form.cat.value == "" ) {
			alert("External RSS document require a CATEGORY");
		} else if (form.title.value == "" ) {
			alert("External RSS document require a Title");
		} else if (form.url.value=="") {
			alert("You must fill in the url of the RSS docuemnt");
		} else {
			submitform( pressbutton );
		}
	}
		function ShowProgress(){
			el=document.getElementById('div_progress');
			el.style.display='block';
		}
		function HideProgress(){
			el=document.getElementById('div_progress');
			el.style.display='none';
		}
	</script>
	<table class="adminheading">
	<tr>
		<th>
		<?php echo $id[0]==''?'Add':'Edit'; ?> RSS <?php /* echo "id=$id row->id=".$row->id."row->title:".$row->title." row->url:".$row->url;*/?>
		</th>
	</tr>
	</table>
	<div id="div_progress" style="display:none;color:white;width:100px;background-color:red;">Processing...</div>
	<form action="index2.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
	<table class="adminform">
	<tr>
		<td width="20%" align="right">
		Title:
		</td>
		<td width="80%">
		<input class="text_area" type="text" name="title" size="50" maxlength="200" value="<?php echo $row->title; ?>" />
		</td>
	</tr>
	<tr>
		<td align="right">
		URL:
		</td>
		<td>
		<input class="text_area" type="text" name="url" size="100" maxlength="300" value="<?php echo $row->url; ?>" />
		</td>
	</tr>
	<tr>
		<td align="right">
		Category:
		</td>
		<td valign="top">
		<input class="text_area" type="text" name="cat" size="30" maxlength="100" value="<?php echo $row->cat; ?>" />
		<?php echo $build['category'];?>
		<?php echo mosToolTip('To create a new Category , just edit the Category name in the input box'); ?>
		</td>
	</tr>
	<tr>
		<td align="right">
		Nr Feeds (0 for showing all):
		</td>
		<td>
		<input class="text_area" type="text" name="nrfeeds" size="2" maxlength="2" value="<?php echo $row->nrfeeds; ?>" />
		</td>
	</tr>
	<tr>
		<td align="right">
		Order:
		</td>
		<td>
		<?php echo $build['ordering'];?>
		</td>
	</tr>
	<tr>
		<td align="right">Current Icon:
		</td>
		<td><?php echo HTMLCreateSiteIco($row); ?>
         &nbsp; New Icon:  <input type="file" name="siteicon"><br/>
         <a href="#" onclick="javascript:xajax_jax_RefreshIcon('<?php echo $row->id;?>')" >Reload from Favicon </a>
        </td>
	</tr>

	<tr>
		<td align="right">
		Published:
		</td>
		<td>
		<?php echo $build['published'];?>
		</td>
	</table>

	<input type="hidden" name="id" value="<?php echo $row->id;?>" />
	<input type="hidden" name="option" value="<?php echo $option;?>" />
	<input type="hidden" name="task" value="" />
	</form>
	<?php
	}

	function showLinks( $option, &$rows, &$pageNav,&$lists ) {
		global $mosConfig_live_site;
    	$search=mosGetParam($_REQUEST,'search','');
		mosCommonHTML::loadOverlib();
	  $xajax=InitializeXajax();
	  $xajax->printJavascript(XAJAX_PATH);
	  $xajax->errorHandlerOn();
	?>
		<script language="javascript" type="text/javascript">
		function ShowProgress(){
			el=document.getElementById('div_progress');
			el.style.display='block';
		}
		function HideProgress(){
			el=document.getElementById('div_progress');
			el.style.display='none';
		}
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == "cancel") {
				submitform( pressbutton );
				return;
			}
			submitform( pressbutton );
		}
		</script>
		<form action="index2.php" method="post" name="adminForm">
		<div id="div_progress" style="display:none;color:white;width:100px;background-color:red;">Processing...</div>
		<table class="adminheading">
		<tr>
			<th>
			RSS link Manager&nbsp;&nbsp;&nbsp;<span class="editlinktip">Refresh all links -
			<img name="image1" src="<?php echo COMPONENT_PATH.'images/refresh.jpg'; ?>" border="0"
			onmouseout="this.src='<?php echo COMPONENT_PATH.'images/refresh.jpg'; ?>'"
			onmouseover="this.src='<?php echo COMPONENT_PATH.'images/refresh2.jpg'; ?>';"
			onclick="ShowProgress();xajax_jax_RefreshAllFeeds()"/></span>
			</th>
			<td align="right" valign="top">
			Filter:
			</td>
			<td align="right" valign="top">
			<input type="text" name="search" value="<?php echo $search;?>" class="text_area" onChange="document.adminForm.submit();" />
			</td>
			<td align="right" valign="top">
			<?php echo $lists['catid'];?>
			</td>
			<td align="right" valign="top">
			<?php echo $lists['published'];?>
			</td>

		</tr>
		</table>
		<table class="adminlist">
		<tr>
			<th width="20" align="center">
			<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $rows ); ?>);" />
			</th>
		 	<th width="20" align="center">
		 	ID
			</th>
			<th width="5%" nowrap="nowrap" align="center">
			Published
			</th>
			<th width="5%" colspan="2" align="center">
			Order
			</th>
			<th width="16px" nowrap="nowrap" align="left">
			&nbsp;
			</th>
			<th width="15%" nowrap="nowrap" align="left">
			Title
			</th>
			<th width="10%" nowrap="nowrap" align="left">
			Category
			</th>
			<th width="3%" nowrap="nowrap">
			Nr Feeds
			</th>
			<th colspan="*%">
			URL
			</th>
			<th width="15%" nowrap="nowrap">
			Lastrefresh
			</th>
			<th width="5%" nowrap="nowrap">
			Had Error
			</th>
		</tr>
		<?php
		$k=0;
		for ($i=0, $n=count($rows); $i<$n; $i++) {
			$row = $rows[$i];
			$pub = $row->published ? 0 : 1 ;
		?>
		<tr class="<?php echo "row$k";?>">
			<td align="center">
			<?php echo mosHTML::idBox($i,$row->id,false);?>
			</td>
			<td align="center">
			<?php echo $row->id;?>
			</td>
			<td align="center">
			<a href="javascript: void(0);" onClick="return listItemTask('cb<?php echo $i ?>','<?php echo  ($row->published)?'unpublish':'publish' ?>')"><img src="<?php echo ($row->published)?'images/publish_g.png':'images/publish_x.png' ?>" border=0></a>
			</td>
			<td width="10" align="center">
			<?php echo $pageNav->orderUpIcon($i,($row->ordering > 0));?>
			</td>
			<td width="10" align="center">
			<?php echo $pageNav->orderDownIcon($i,($row->ordering < $n));?>
			</td>
			<td><?php echo HTMLCreateSiteIco($row); ?></td>
			<td>
			<a href="javascript: void(0);" onClick="return listItemTask('cb<?php echo $i ?>','edit')"><?php echo $row->title;?></a>
			</td>
			<td>
			<?php echo $row->cat;?>
			</td>
			<td>
			<span id="nr_feeds_<?php echo $row->id; ?>"><?php echo ($row->nrfeeds)?($row->nrfeeds):'All';?></span>&nbsp;<img name="image1" src="<?php echo COMPONENT_PATH.'images/refresh.jpg'; ?>" border="0" onmouseout="this.src='<?php echo COMPONENT_PATH.'images/refresh.jpg'; ?>'" onmouseover="this.src='<?php echo COMPONENT_PATH.'images/refresh2.jpg'; ?>';" onclick="ShowProgress();xajax_jax_RefreshFeed('<?php echo $row->id?>','<?php echo $row->nrfeeds?>')"/>
			</td>
			<td>
			<?php echo $row->url;?>
			</td>
			<td>
			<?php echo $row->date;?>
			</td>
			<td>
			<?php
            echo ($row->rsserror)?
            "<img src='$mosConfig_live_site/includes/js/ThemeOffice/warning.png' border=0 onMouseOver=\"return overlib('There was a timeout, or the resource is no longer available.', CAPTION, 'Last refresh caused error', BELOW, RIGHT);\" onMouseOut='return nd();'>":'-';
            ?>
			</td>
		</tr>
		<?php
			$k = 1 - $k;
		}
		?>
	</table>
	<?php echo $pageNav->getListFooter(); ?>
	<input type="hidden" name="option" value="<?php echo $option;?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	</form>
	<?php
	}

	function editAds( $option, &$row, &$build, $id ) {
		mosMakeHtmlSafe($row,ENT_QUOTES,'description');
	  mosCommonHTML::loadOverlib();
	?>
	<script language="javascript" type="text/javascript">
	function submitbutton(pressbutton) {
		var form = document.adminForm;
		if ( pressbutton == 'cancel') {
			submitform(pressbutton);
			return;
		}
		if (form.title.value == "" ) {
			alert("Ads require a Title");
		} else {
			<?php getEditorContents( 'editor1', 'Adtext' ) ; ?>
			submitform( pressbutton );
		}
	}
	</script>
	<table class="adminheading">
	<tr>
		<th>
		<?php echo $id==''?'Add':'Edit'; ?> RSS <?php /* echo "id=$id row->id=".$row->id."row->title:".$row->title." row->url:".$row->url;*/?>
		<?php echo mosToolTip('If you need to insert JAVASCRIPT (for instance for Adsense) Turn the WYSIWYG editor off, insert your ads , then turn it back on'); ?>

		</th>
	</tr>
	</table>
	<form action="index2.php" method="post" name="adminForm" id="adminForm">
	<table class="adminform">
	<tr>
		<td width="20%" align="right">
		Ad title:
		</td>
		<td width="80%">
		<input class="text_area" type="text" name="title" size="50" maxlength="200" value="<?php echo $row->title; ?>" />
		</td>
	</tr>
	<tr>
		<td align="right">
		Ad text:
		</td>
		<td>
		<?php	editorArea( 'editor1',  $row->Adtext , 'Adtext', '70%;', '250', '60', '20' ) ;	?>
		</td>
	</tr>
	<tr>
		<td align="right">
		Published:
		</td>
		<td>
		<?php echo $build['published'];?>
		</td>
	</table>

	<input type="hidden" name="id" value="<?php echo $row->id;?>" />
	<input type="hidden" name="option" value="<?php echo $option;?>" />
	<input type="hidden" name="task" value="" />
	</form>
	<?php
	}


	function showAds( $option, &$rows, &$pageNav ) {
	  mosCommonHTML::loadOverlib();
	?>
		<script language="javascript" type="text/javascript">
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == "cancel") {
				submitform( pressbutton );
				return;
			}
			submitform( pressbutton );
		}
		</script>
		<form action="index2.php" method="post" name="adminForm">
		<table class="adminheading">
		<tr>
			<th>
			RSS link Manager - ADS
    		<?php echo mosToolTip('If you need to insert JAVASCRIPT (for instance for Adsense) Turn the WYSIWYG editor off, insert your ads , then turn it back on'); ?>
			</th>
		</tr>
		</table>
		<table class="adminlist">
		<tr>
			<th width="20" align="center">
			<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $rows ); ?>);" />
			</th>
			<th width="10%" nowrap="nowrap" align="center">
			Published
			</th>
			<th width="*%" nowrap="nowrap" align="left">
			Title
			</th>
		</tr>
		<?php
		for ($i=0; $i<count($rows); $i++) {
			$row = $rows[$i];
			$pub = $row->published ? 0 : 1 ;
		?>
		<tr class="<?php echo "row".($i % 2);?>">
			<td width="20" align="center">
			<?php echo mosHTML::idBox($i,$row->id,false);?>
			</td>
			<td width="10%" align="center">

			<a href="javascript: void(0);" onClick="return listItemTask('cb<?php echo $i ?>','<?php echo  ($row->published)?'unpublishads':'publishads' ?>')"><img src="<?php echo ($row->published)?'images/publish_g.png':'images/publish_x.png' ?>" border=0></a>
			</td>
			<td>
			<a href="javascript: void(0);" onClick="return listItemTask('cb<?php echo $i ?>','editads')"><?php echo $row->title;?></a>
			</td>
		</tr>
		<?php
		}
		?>
	</table>
	<?php echo $pageNav->getListFooter(); ?>
	<input type="hidden" name="option" value="<?php echo $option;?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	</form>
	<?php
	}//showads
	function showConfig( $option, &$row,&$version) {
		global $database,$mosConfig_live_site,$mosConfig_absolute_path;



		require ($mosConfig_absolute_path."/administrator/components/$option/xajax/xajax.inc.php");
	      $tabs = new mosTabs(1);
		  mosCommonHTML::loadOverlib();
		  $xajax=InitializeXajax();
		  $xajax->printJavascript(XAJAX_PATH);
		  $xajax->errorHandlerOn();
		$database->setQuery('select sum(nrfeeds) from #__rssfactory ');
        $nrfeeds=$database->LoadResult();
		$database->setQuery('select count(*) from #__rssfactory ');
        $nrsources=$database->LoadResult();

	?>
    <script>
        var ol_fgclass='';
        var ol_bgclass='';
        var ol_textfontclass='';
        var ol_captionfontclass='';
        var ol_closefontclass='';
    </script>
	<link rel="stylesheet" href="<?php echo COMPONENT_ADMINPATH; ?>js_color_picker_v2.css" media="screen">
	<script src="<?php echo COMPONENT_ADMINPATH; ?>color_functions.js"></script>
	<script type="text/javascript" src="<?php echo COMPONENT_ADMINPATH; ?>js_color_picker_v2.js"></script>

		<script language="javascript" type="text/javascript">
		form_widget_amount_slider_handle='<?php echo COMPONENT_ADMINPATH.'images/slider_handle.gif'; ?>';
		function ShowProgress(){
			el=document.getElementById('div_progress');
			el.style.display='block';
		}
		function HideProgress(){
			el=document.getElementById('div_progress');
			el.style.display='none';
		}
		function submitbutton(pressbutton) {
			if (window.tinyMCE!=null){
				tinyMCE.execCommand('mceFocus', false,'description');
				//alert('tinyMCE');
			}
			var form = document.adminForm;
			if (pressbutton == "cancel") {
				submitform( pressbutton );
				return;
			}
			<?php getEditorContents( 'editor1', 'description' ) ; ?>
			submitform( pressbutton );
		}
		function view_style_changed(){
			var form = document.adminForm;
            el=document.getElementById('opt_descript');
            if (form.showfeeddescription.value=='table'){
    			el.style.display='block';
            }else{
    			el.style.display='none';
            }
        }
        function iframe_changed(){
			var form = document.adminForm;
            el=document.getElementById('opt_iframe_height');
            if (form.showfeeddescription.value!=''){
    			el.style.display='block';
            }else{
    			el.style.display='none';
            }
        }
        function category_changed(){
			var form = document.adminForm;
            el=document.getElementById('opt_preview');
            if (form.showcategory[1].checked){
    			el.style.display='block';
            }else{
    			el.style.display='none';
            }
        }
		</script>

		<form action="index2.php" method="post" name="adminForm" enctype="multipart/form-data">
		<input type="hidden" name="id" value="<?php echo $row->id;?>">
		<table class="adminheading">
		<tr>
			<th>
			RSS link Manager - Configuration
			</th>
		</tr>
		</table>
		<div id="div_progress" style="display:none;color:white;width:100px;background-color:red;">Processing...</div>
<?php
      $tabs->startPane("configPane");

      $tabs->startTab("General","tab1");
?>
		<table class="adminlist">
		<tr>
			<td width="30%">
			Nr of Ads to display per page:<br>(The ads will be mingled randomly in the news list)
			</td>
			<td width="70%" nowrap="nowrap">
			<input class="text_area" type="text" name="nrads" size="3" maxlength="2" value="<?php echo $row->nrads;?>" />
			<?php echo mosToolTip('Set it to 0 if you do not use Ads in the RSS list'); ?>
			</td>
		</tr>
		<tr>
			<td width="30%">
			Show Searchbox :
			</td>
			<td width="70%" nowrap="nowrap">
			<?php echo mosHTML::yesnoRadioList('showSearch','class="inputbox"',$row->showSearch); ?>
			<?php echo mosToolTip('Displays a Search box on top of the feeds. If the Search mambot is enabled the site search box should deliver the same results'); ?>
			</td>
		</tr>
		<tr>
			<td width="30%">
			Unpublish if the RSSreturns errors :
			</td>
			<td width="70%" nowrap="nowrap">
			<?php echo mosHTML::yesnoRadioList('unpublisherr','class="inputbox"',$row->unpublisherr); ?>
			<?php echo mosToolTip('Automatically unpublish Feeds if there are errors refreshing them'); ?>
			</td>
		</tr>
		<?php echo HTML_RSSReader::buildTabOptions(1,null);?>
		</table>
<?php
      $tabs->endTab();

      $tabs->startTab("Refresh","tab2");
?>
		<table class="adminlist">
		<tr>
			<td width="30%">
			Refresh link password :
			</td>
			<td width="70%" nowrap="nowrap">
			<input class="text_area" type="text" name="refresh_password" size="30" maxlength="60" value="<?php echo $row->refresh_password;?>" /><br />
            Your current refresh link for RSSfeeds is:<br/>
            <a target="_blank" href="<?php echo $mosConfig_live_site ?>/index.php?option=<?php echo $option; ?>&task=refresh&password=<?php echo $row->refresh_password;?>">
            <strong><?php echo $mosConfig_live_site ?>/index.php?option=<?php echo $option; ?>&task=refresh&password=<?php echo $row->refresh_password;?></strong></a>
			<?php echo mosToolTip('Used for CRON updates in the CPANEL backend. It is recommanded you use this feature even if the pseudocron is enabled'); ?>
			<br>
			If you want to refresh your feeds now , please click the above link.
			</td>
		</tr>
		<tr>
			<td width="30%">
			Use Pseudocron Refresh: <strong> Important Setting</strong>
			</td>
			<td width="70%" nowrap="nowrap">
			<?php echo mosHTML::yesnoRadioList('use_pseudocron','class="inputbox"',$row->use_pseudocron); ?>
			<?php echo mosToolTip('The feeds are refreshed as long as people surf the site. This setting does not slow down the loading time of the website, but could create intense server processor usage if the interval is set to tight'); ?>
			</td>
		</tr>
		<tr>
			<td width="30%">
			Pseudocron refresh timer: <strong> Important Setting</strong>
			</td>
			<td width="70%" nowrap="nowrap">
			<input class="text_area" type="text" name="refreshinterval" size="10" maxlength="10" value="<?php echo $row->refreshinterval;?>" /> Minutes
			<?php echo mosToolTip('Used only if Pseudocron is enabled. This is the interval between refreshes. Do not set it to tight'); ?>
			</td>
		</tr>
		<?php echo HTML_RSSReader::buildTabOptions(2,null);?>
		</table>
<?php
      $tabs->endTab();

      $tabs->startTab("Display","tab3");
?>
		<table class="adminlist">
		<tr>
			<td width="30%">
			Show first the category list so the user can narrow it down  :
			</td>
			<td width="70%" nowrap="nowrap">
			<?php echo mosHTML::yesnoRadioList('showcategory','class="inputbox" onchange="category_changed();"',$row->showcategory); ?>
			<?php echo mosToolTip('If set to yes, then the Component will display firstly a list of categories, and by clicking them, the user gets to the feeds'); ?>
			<span id="opt_preview" style="display:<?php echo ($row->showcategory)?'block':'none'; ?>;">
			 Number of preview items in categories: <input type="text" name="cat_previewnr" value="<?php echo ($row->cat_previewnr); ?>">
			 <?php echo mosToolTip('Number of news previewed in the categorylist'); ?>
			</span>

			</td>
		</tr>
		<tr>
			<td width="30%">
			Should it show only the first X (amount set in  feed management) news links (if you choose no, all news are shown) :
			</td>
			<td width="70%" nowrap="nowrap">
			<?php echo mosHTML::yesnoRadioList('limitrss','class="inputbox" ',$row->limitrss); ?>
			<?php echo mosToolTip('If set to n, then the number of news displayed will be unlimited'); ?>
			</td>
		</tr>
		<tr>
			<td width="30%">
			Choose an output style for the feeds:
			</td>
			<td width="70%" nowrap="nowrap">
			<?php
			  	$lst[] = mosHTML::makeOption( 'tiled', 'Tiled' );
            	$lst[] = mosHTML::makeOption( 'list', 'List' );
            	$lst[] = mosHTML::makeOption( 'tabbed', 'Tabbed View' );

                echo mosHTML::selectList( $lst, 'liststyle', 'class="inputbox" ', 'value', 'text', $row->liststyle );
             ?>
			<?php echo mosToolTip('Tiled: the Feeds are displayed in blocks; List: all feeds are displayed as a list'); ?>
			</td>
		</tr>
		<tr>
			<td width="30%">
			Choose how to display the full story/news:
			</td>
			<td width="70%" nowrap="nowrap">
			<?php
			     $lst=array();
			  	$lst[] = mosHTML::makeOption( '', 'Popup to Original site' );
            	$lst[] = mosHTML::makeOption( '1', 'In a wrapper in your site' );

                echo mosHTML::selectList( $lst, 'output_iframe', 'class="inputbox"  onchange="iframe_changed();"', 'value', 'text', $row->output_iframe );
             ?>
			<?php echo mosToolTip('Wether to popup the original site, or to display it in a wrapper in your content area.'); ?>
			<span id="opt_iframe_height" style="display:<?php echo ($row->output_iframe!='')?'block':'none'; ?>;">
			     Iframe height: <input type="text" name="iframe_height" size="10" value="<?php echo ($row->iframe_height)?($row->iframe_height):'800'; ?>">
			</span>
			</td>
		</tr>
		<tr>
			<td width="30%">
			Selected tab image:
			</td>
			<td width="70%" nowrap="nowrap" height="34px">
			<div style="width:<?php echo $row->twidth+250;?>px;">
				<div style="float:left;background-image:url('<?php echo $mosConfig_live_site."/components/com_rssfactory/images/tab_active.png";?>');background-repeat:no-repeat;width:<?php echo $row->twidth;?>px;height:<?php echo $row->theight;?>px;text-align:center;color:#ffffff;">
				 		<br>EXAMPLE
				 </div>
				 <div style="float:right;padding-top:10px;"><input type="file" name="st_image"></div>

			</div>
			<?php echo mosToolTip('You can upload your own background for the tabbed display. GIF,PNG or JPEG'); ?>
		</tr>

		<tr>
			<td width="30%">
			Hover tab image:
			</td>
			<td width="70%" nowrap="nowrap" height="34px">

					<div style="width:<?php echo $row->twidth+250;?>px;">
						<div style="float:left;background-image:url('<?php echo $mosConfig_live_site."/components/com_rssfactory/images/tab_hover.png";?>');background-repeat:no-repeat;width:<?php echo $row->twidth;?>px;height:<?php echo $row->theight;?>px;text-align:center;color:#000000;">
						 		<br>EXAMPLE
						 </div>
						 <div style="float:right;padding-top:10px;"><input type="file" name="ht_image"></div>

					</div>

			</td>
		</tr>
		<tr>
			<td width="30%">
			Simple tab image:
			</td>
			<td width="70%" nowrap="nowrap" height="34px">
					<div style="width:<?php echo $row->twidth+250;?>px;">
						<div style="float:left;background-image:url('<?php echo $mosConfig_live_site."/components/com_rssfactory/images/tab.png";?>');background-repeat:no-repeat;width:<?php echo $row->twidth;?>px;height:<?php echo $row->theight;?>px;text-align:center;color:#000000;">
						 		<br>EXAMPLE
						 </div>
						 <div style="float:right;padding-top:10px;"><input type="file" name="sit_image"></div>

					</div>
			</td>
		</tr>
		<tr>
			<td width="30%">
			Tab image dimensions:
			</td>
			<td width="70%" nowrap="nowrap" height="34px">
				<div style="width:220px;">
					<div style="width:100px;float:left;">
						<div style="float:left;text-align:center;color:#000;padding-top:3px;">
						 		Width:
						 </div>
						 <div style="float:right;"><input type="text" name="twidth" value="<?php echo $row->twidth;?>" size="5"></div>

					</div>
					<div style="width:100px;float:right">
						<div style="float:left;text-align:center;color:#000;padding-top:3px;">
						 		Height:
						 </div>
						 <div style="float:right;"><input type="text" name="theight" value="<?php echo $row->theight;?>" size="5"></div>

					</div>
				</div>
			<?php echo mosToolTip('Input the tab width and height. It is recommanded to put in the height and width of the background image'); ?>
			</td>
		</tr>
		<tr>
			<td width="30%">
			How to display feed content :
			</td>
			<td width="70%" nowrap="nowrap">
			<?php
			  	$lst2[] = mosHTML::makeOption( 'overlib', 'Overlib' );
            	$lst2[] = mosHTML::makeOption( 'table', 'Table' );

                echo mosHTML::selectList( $lst2, 'showfeeddescription', 'class="inputbox" onchange="view_style_changed();"', 'value', 'text', $row->showfeeddescription );
             ?>
			<?php echo mosToolTip('overlib: Feed content appears as tooltip; table: Feed content appears as a table under each title'); ?>
			<span id="opt_descript" style="display:<?php echo ($row->showfeeddescription=='table')?'block':'none'; ?>;">
			 <input type="checkbox" name="table_view_open" value="1" <?php echo ($row->table_view_open)?'checked':''; ?>> List always open
			</span>
			</td>
		</tr>
		<tr>
			<td width="30%">
			Date Format :
			</td>
			<td width="70%" nowrap="nowrap">
			<?php
			  	$lst3[] = mosHTML::makeOption( 'Y-m-d H:i:s', 'YYYY-MM-DD h:m:s' );
			  	$lst3[] = mosHTML::makeOption( 'm/d/Y H:i:s', 'MM/DD/YYYY h:m:s' );
			  	$lst3[] = mosHTML::makeOption( 'd/m/Y H:i:s', 'DD/MM/YYYY h:m:s' );
			  	$lst3[] = mosHTML::makeOption( 'd-m-Y H:i:s', 'DD-MM-YYYY h:m:s' );
			  	$lst3[] = mosHTML::makeOption( 'n/j/y H:i:s', 'm/d/yy h:m:s' );
			  	$lst3[] = mosHTML::makeOption( 'j/n/y H:i:s', 'd/m/yy h:m:s' );
			  	$lst3[] = mosHTML::makeOption( 'j-m-y H:i:s', 'd-m-yy h:m:s' );
			  	//$lst3[] = mosHTML::makeOption( '', '' );

                echo mosHTML::selectList( $lst3, 'date_format', 'class="inputbox"', 'value', 'text', $row->date_format );
             ?>
			<?php echo mosToolTip('Date display Format. '); ?>
			</td>
		</tr>
		<tr>
			<td width="30%">
			Hide Date in Feed Display:
			</td>
			<td width="70%" nowrap="nowrap">
			<?php echo mosHTML::yesnoRadioList('hideDate','class="inputbox"',$row->hideDate); ?>
			<?php echo mosToolTip('If set to Yes, the date will not show before the feeds'); ?>
			</td>
		</tr>
		<tr>
			<td width="30%">
			Hide Bullet in Feed Display:
			</td>
			<td width="70%" nowrap="nowrap">
			<?php echo mosHTML::yesnoRadioList('hideBullet','class="inputbox"',$row->hideBullet); ?>
			<?php echo mosToolTip('If set to Yes, the bullet Gif will not display before the feed'); ?>
			</td>
		</tr>
		<tr>
			<td width="30%">
			Use Sites Favicons as Icons before feeds:
			</td>
			<td width="70%" nowrap="nowrap">
			<?php echo mosHTML::yesnoRadioList('use_favicons','class="inputbox"',$row->use_favicons); ?>
			<?php echo mosToolTip('If set to Yes, there will be icons before the Feed title accourding to the source site. The default icon is in /components/'.$option.'/images/default.ico'); ?>
			</td>
		</tr>
		<tr>
			<td width="30%" valign="top">
			Component Description (appears on top of Category list):
			<?php echo mosToolTip('This description apears on to of the Category list, like an introduction'); ?>
			</td>
			<td width="70%" nowrap="nowrap" >
				<?php	editorArea( 'editor1',  $row->description , 'description', '60%;', '250', '60', '20' ) ;	?>
			</td>
		</tr>
		<?php echo HTML_RSSReader::buildTabOptions(3,null);?>
		</table>
<?php
      $tabs->endTab();

      $tabs->startTab("Charset Settings","tab3_1");

?>
	<table class="adminlist">
		<tr>
			<td width="30%">
			Force HTML encoding :
			</td>
			<td width="70%" nowrap="nowrap">
                <input class="text_area" type="text" name="force_charset" size="30" maxlength="60" value="<?php echo $row->force_charset;?>" />
                <?php echo mosToolTip('If your webpage uses ISO or Windows-1252, and you add UTF-8 feeds, and the feeds display with faulty characters, set this as utf-8, and the page with RSS will be forced to this charset <br> Leave blank if unsure'); ?>
			</td>
		</tr>
		<tr>
			<td width="30%">
			Force Feed output encoding :
			</td>
			<td width="70%" nowrap="nowrap">
                <input class="text_area" type="text" name="force_output_charset" size="30" maxlength="60" value="<?php echo $row->force_output_charset;?>" />
                <?php echo mosToolTip('If not set we will use the default Webpage encoding -you can see it in your language file, for ex: DEFINE(\\\'_ISO\\\',\\\'charset=iso-8859-1\\\');<br> if the feeds do not display correctly please eforce here your character set <br> Leave blank if unsure'); ?>
			</td>
		</tr>
		<?php echo HTML_RSSReader::buildTabOptions(31,null);?>
	</table>
<?php
      $tabs->endTab();

      $tabs->startTab("Overlib Colors","tab4");

?>
	<table class="adminlist">
		<tr>
			<td colspan=2>
			<div>
			<span onMouseOver="return overlib('SAMPLE Text', CAPTION, 'Sample CAPTION', BELOW, RIGHT,
                FGCOLOR,document.adminForm.ol_fgcolor.value,BGCOLOR,document.adminForm.ol_bgcolor.value,
                TEXTCOLOR ,document.adminForm.ol_txcolor.value,CAPCOLOR,document.adminForm.ol_capcolor.value,
                TEXTSIZE ,document.adminForm.ol_txsize.value,CAPTIONSIZE,document.adminForm.ol_capsize.value,
                BORDER , document.adminForm.ol_bordersize.value);"
                onMouseOut='return nd();'>
                >>>>>>>>>>>> Move your mouse over this area to see a demo of the colors you choose <<<<<<<<<< </span>
			</div>
			</td>
		</tr>
		<tr>
			<td width="30%">
			Foreground Color:
			</td>
			<td width="70%" nowrap="nowrap">
            <div style="width:103px;width/* */:/**/100px;width: /**/100px;height:20px;border:1px solid #7F9DB9;">
            <input type="text" name="ol_fgcolor" value="<?php echo OL_FGCOLOR; ?>" style="width:80px;font-size:12px;height:17px;float:left;border:0px;padding-top:2px" maxlength="7" size="10">
			<img src="<?php echo COMPONENT_ADMINPATH; ?>images/select_arrow.gif"
                onmouseover="this.src='<?php echo COMPONENT_ADMINPATH; ?>images/select_arrow_over.gif'"
                onmouseout="this.src='<?php echo COMPONENT_ADMINPATH; ?>images/select_arrow.gif'"
                onclick="showColorPicker(this,document.adminForm.ol_fgcolor);" style="float:right;padding-right:1px;padding-top:1px" />
            </div>
			</td>
		</tr>
		<tr>
			<td width="30%">
			Background Color:
			</td>
			<td width="70%" nowrap="nowrap">
            <div style="width:103px;width/* */:/**/100px;width: /**/100px;height:20px;border:1px solid #7F9DB9;">
            <input type="text" name="ol_bgcolor" value="<?php echo OL_BGCOLOR; ?>" style="width:80px;font-size:12px;height:17px;float:left;border:0px;padding-top:2px" maxlength="7" size="10">
			<img src="<?php echo COMPONENT_ADMINPATH; ?>images/select_arrow.gif"
                onmouseover="this.src='<?php echo COMPONENT_ADMINPATH; ?>images/select_arrow_over.gif'"
                onmouseout="this.src='<?php echo COMPONENT_ADMINPATH; ?>images/select_arrow.gif'"
                onclick="showColorPicker(this,document.adminForm.ol_bgcolor);" style="float:right;padding-right:1px;padding-top:1px" />
            </div>
			</td>
		</tr>
		<tr>
			<td width="30%">
			Text Color:
			</td>
			<td width="70%" nowrap="nowrap">
            <div style="width:103px;width/* */:/**/100px;width: /**/100px;height:20px;border:1px solid #7F9DB9;">
            <input type="text" name="ol_txcolor" value="<?php echo OL_TXCOLOR; ?>" style="width:80px;font-size:12px;height:17px;float:left;border:0px;padding-top:2px" maxlength="7" size="10">
			<img src="<?php echo COMPONENT_ADMINPATH; ?>images/select_arrow.gif"
                onmouseover="this.src='<?php echo COMPONENT_ADMINPATH; ?>images/select_arrow_over.gif'"
                onmouseout="this.src='<?php echo COMPONENT_ADMINPATH; ?>images/select_arrow.gif'"
                onclick="showColorPicker(this,document.adminForm.ol_txcolor);" style="float:right;padding-right:1px;padding-top:1px" />
            </div>
			</td>
		</tr>
		<tr>
			<td width="30%">
			Caption Color:
			</td>
			<td width="70%" nowrap="nowrap">
            <div style="width:103px;width/* */:/**/100px;width: /**/100px;height:20px;border:1px solid #7F9DB9;">
            <input type="text"  name="ol_capcolor" value="<?php echo OL_CAPCOLOR; ?>" style="width:80px;font-size:12px;height:17px;float:left;border:0px;padding-top:2px" maxlength="7" size="10">
			<img src="<?php echo COMPONENT_ADMINPATH; ?>images/select_arrow.gif"
                onmouseover="this.src='<?php echo COMPONENT_ADMINPATH; ?>images/select_arrow_over.gif'"
                onmouseout="this.src='<?php echo COMPONENT_ADMINPATH; ?>images/select_arrow.gif'"
                onclick="showColorPicker(this,document.adminForm.ol_capcolor);" style="float:right;padding-right:1px;padding-top:1px" />
            </div>
			</td>
		</tr>
		<tr>
			<td width="30%">
			Text Size:
			</td>
			<td width="70%" nowrap="nowrap">
			<input name="ol_txsize" value="<?php echo OL_TXSIZE; ?>">
			</td>
		</tr>
		<tr>
			<td width="30%">
			Caption Size:
			</td>
			<td width="70%" nowrap="nowrap">
			<input name="ol_capsize" value="<?php echo OL_CAPSIZE; ?>">
			</td>
		</tr>
		<tr>
			<td width="30%">
			Border Size:
			</td>
			<td width="70%" nowrap="nowrap">
			<input name="ol_bordersize" value="<?php echo OL_BORDERSIZE; ?>">
			</td>
		</tr>
		<?php echo HTML_RSSReader::buildTabOptions(4,null);?>
	</table>
<?php
      $tabs->endTab();

      $tabs->startTab("Cache","tab5");
?>
	<table class="adminlist">
		<tr>
			<td width="30%">
			Cache content:
			</td>
			<td width="70%" nowrap="nowrap"><span id="nr_feeds">
			<?php
				$database->setQuery("select count(*) from #__rssfactory_cache");
				echo $database->LoadResult();
			 ?></span> Feeds
			</td>
		</tr>
		<tr>
			<td width="30%">
			Clear Cache:
			</td>
			<td width="70%" nowrap="nowrap">
				<input type="button" value="clear" onclick="javascript:ShowProgress();xajax_jax_ClearCache(0);"/>
			</td>
		</tr>
		<?php echo HTML_RSSReader::buildTabOptions(5,null);?>
	</table>
<?php
      $tabs->endTab();

      $tabs->startTab("About","tab6");
?>
	<table class="adminlist">
		<tr>
			<td width="30%">
			About Component:
			</td>
			<td width="70%" nowrap="nowrap">
			<?php  echo $nrfeeds;
			 ?> feeds in <?php echo $nrsources;?> sources
			</td>
		</tr>
		<tr>
			<td width="30%">
			Component Version:
			</td>
			<td width="70%" nowrap="nowrap">
			<?php echo COMPONENT_VERSION; ?>
			</td>
		</tr>
		<tr>
			<td width="30%">
			Latest version available:
			</td>
			<td width="70%" nowrap="nowrap">
			<?php echo $version->latestversion; ?>
			</td>
		</tr>
		<tr>
			<td width="30%">
			to Subscribe to the newsletter regarding this component:
			</td>
			<td width="70%" nowrap="nowrap">
			<a href="<?php echo $version->newsletter; ?>" target="_blank">click here</a>
			<?php echo mosToolTip('You will recieve only Information regarding component news and announcements'); ?>
			</td>
		</tr>
		<?php echo HTML_RSSReader::buildTabOptions(6,null);?>

		</table>
<?php
      $tabs->endTab();

      $tabs->endPane();
?>

	<input type="hidden" name="option" value="<?php echo $option;?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	</form>
	<?php
	}
    function ShowImport($option){
        ?>
	<script language="javascript" type="text/javascript">
	function submitbutton(pressbutton) {
		var form = document.adminForm;
		if ( pressbutton == 'cancel') {
			submitform(pressbutton);
			return;
		}
		if (form.csvfile.value == "" ) {
			alert("File must have a Value !");
		}  else {
			submitform( pressbutton );
		}
	}
	</script>
	<div> There are sample files in the component archive and in  your component admin Folder</div>
		<form action="index2.php" method="post" name="adminForm" enctype="multipart/form-data">
		<table class="adminheading">
		<tr>
		<td>
		  <select name="csvseparator">
		  <option value="TAB" selected>TAB Character</option>
		  <option value=";">;</option>
		  <option value=",">,</option>
		  </select>
		</td>
        </tr>
		<tr>
		<td>
		  <input type="file" name="csvfile" size="50">
		</td>
        </tr>
        </table>
    	<input type="hidden" name="option" value="<?php echo $option;?>" />
    	<input type="hidden" name="task" value="" />
    	<input type="hidden" name="boxchecked" value="0" />
    	</form>
        <?php

    }

    function ShowRestoreBackup($option){
        ?>
	<script language="javascript" type="text/javascript">
	function submitbutton(pressbutton) {
		var form = document.adminForm;
		if ( pressbutton == 'cancel') {
			submitform(pressbutton);
			return;
		}
		if (form.bakupfile.value == "" ) {
			alert("File must have a Value !");
		}  else {
		      if (form.truncate.value=="YES"){
    		      if (!confirm("Are you sure that you want your old feeds to be REPLACED?")) return;
    		  }
			submitform( pressbutton );
		}
	}
	</script>
		<form action="index2.php" method="post" name="adminForm" enctype="multipart/form-data">
		<table class="adminheading">
		<tr>
		<td>
		  Do you want to delete the old data?
		  <select name="truncate">
		  <option value="YES" selected>YES</option>
		  <option value="NO">NO</option>
		  </select>
		</td>
        </tr>
		<tr>
		<td>
		  <input type="file" name="bakupfile" size="50">
		</td>
        </tr>
        </table>
    	<input type="hidden" name="option" value="<?php echo $option;?>" />
    	<input type="hidden" name="task" value="" />
    	<input type="hidden" name="boxchecked" value="0" />
    	</form>
        <?php

    }
    function ShowRestoredBackup($option,$category,$url,$nrfeeds){
    	$count_cat=count($category)-1;
    	$count_news=0;
    	for($i=0;$i<$count_cat;$i++){
    		$nr=$nrfeeds[$i]?$nrfeeds[$i]:'All';
    		echo 'Category: '.strtoupper($category[$i]).', Feed: <a href="'.$url[$i].'">'.$url[$i].'</a>, News: '.$nr.' -- OK<br />';
    	}
    	echo $count_cat.' categories added!';

    	function refreshBackup($option){
    		global $mosConfig_absolute_path;
    		echo '<div id="div_progress" style="display:none;color:white;width:100px;background-color:red;">Processing...</div>';
    		require ($mosConfig_absolute_path."/administrator/components/$option/xajax/xajax.inc.php");
    		$xajax=InitializeXajax();
    		$xajax->printJavascript(XAJAX_PATH);
	  		$xajax->errorHandlerOn();
    	?>
    	<script language="javascript">
    		function xajax_jax_RefreshAllFeeds(){return xajax.call("jax_RefreshAllFeeds", arguments, 1);}
    		function ShowProgress(){
				el=document.getElementById('div_progress');
				el.style.display='block';
			}
			function HideProgress(){
				el=document.getElementById('div_progress');
				el.style.display='none';
			}
    		ShowProgress();
    		xajax_jax_RefreshAllFeeds();
    	</script>
    	<?php
    	}
    	refreshBackup($option);
    }

    function showCatManager($option,$rows)
    {
        ?>
	<script language="javascript" type="text/javascript">
	function delecat(nr,enable){
        el=document.getElementById('cat_new_'+nr);
        el.disabled=enable;

    }
	</script>
	   <span>To add new categories, just <a href="index2.php?option=<?php echo $option;?>&task=new">Add new feeds</a> with the desired New category written in. The category will be then created automatically</span>
		<form action="index2.php" method="post" name="adminForm" >
		<table class="adminlist">
		<tr>
		  <th>Current Category name</th>
		  <th>New Category Name (Press Save to preserve changes)</th>
		  <th>Delete Categories (This will empty the category name, not delete the feeds in it ) </th>
		</tr>
		<?php
		$i=0;
        foreach ($rows as $row) {
         $i++;?>
		<tr>
		<td>
		  <strong><?php echo $row->cat; ?></strong>
		</td>
		<td width="300">
		<input type="hidden" name="cat_orig_<?php echo $i; ?>" value="<?php echo $row->cat; ?>">
		<input type="text" size="30" id="cat_new_<?php echo $i; ?>"  name="cat_new_<?php echo $i; ?>" value="<?php echo $row->cat; ?>">
		</td>
		<td>
		Delete :<input type="checkbox" value="1" name="cat_delete_<?php echo $i; ?>" onclick="delecat(<?php echo $i; ?>,this.checked)">
		</td>
        </tr>
        <?php  } ?>
        </table>
    	<input type="hidden" name="nrcats" value="<?php echo $i;?>" />
    	<input type="hidden" name="option" value="<?php echo $option;?>" />
    	<input type="hidden" name="task" value="" />
    	<input type="hidden" name="boxchecked" value="0" />
    	</form>
        <?php

    }
    function showAbout( $option,&$version)
    {
        $ver1=explode('.',COMPONENT_VERSION);
        $ver2=explode('.',$version->latestversion);
        $isNew=false;

        for($i=0;$i<count($ver1);$i++){
            if (intval($ver1[$i])<intval($ver2[$i])){
                $isNew=true;
                break;
            }
            if (intval($ver1[$i])>intval($ver2[$i])){
                $isNew=false;
                break;
            }
        }

        if ($isNew){
            $ver_info= "new Version available!!";
        }else{
            $ver_info= "no new Version available!!";

        }
        ?>
            <div id="info_ver">
                <span style="color:red"><?php echo $ver_info; ?> </span><br/>
            </div>
            <div id="info_div" style="border:1px solid black;width:350px;margin-top:20px;">
                Your installed version : <?php echo COMPONENT_VERSION; ?><br/>
                Latest version available : <?php echo $version->latestversion; ?><br/>
            </div>
        <?php if ($isNew){ ?>
            <div id="download_div" style="border:1px solid black;width:350px;margin-top:20px;">
            <a href="<?php echo $version->downloadlink; ?>" target="_blank">To download the latest version click here</a>
            </div>
        <?php } ?>
        <?php if ($version->newsletter){ ?>
            <div style="margin-top:20px;">
            To subscribe to the newsletter regarding The RSSFactory please follow this
            <a href="<?php echo $version->newsletter; ?>" target="_blank">link</a>
            </div>
        <?php } ?>

        <?php if ($version->announcements){ ?>
            <div style="margin-top:20px;">
            Latest Announcements: <br>
            <?php echo $version->announcements; ?>
            </div>
        <?php } ?>
        <?php if ($version->releasenotes){ ?>
            <div style="margin-top:20px;">
            Latest Release Notes: <br>
            <?php echo $version->releasenotes; ?>
            </div>
        <?php } ?>

        <?php
    }
    function buildTabOptions($tab,$option=null){
    	return ;
    }
}

?>
