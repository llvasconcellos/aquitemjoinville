<?php
//
// Copyright (C) 2006 Thomas Papin
// http://www.gnu.org/copyleft/gpl.html GNU/GPL

// This file is part of the AdsManager Component,
// a Joomla! Classifieds Component by Thomas Papin
// Email: thomas.papin@free.fr
//
// no direct access
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' ); 

class HTML_adsmanager{

function getLangDefinition($text) {
	if(defined($text)) $returnText = constant($text); 
	else $returnText = $text;
	return $returnText;
}
	
function displayMain($option){
 HTML_adsmanager::header($option,ADSMANAGER_MAIN_PAGE); 

}

function recurseMarketplaceCategories($option, $id, $level, $children,$num,$option) {
	if (@$children[$id]) {
		foreach ($children[$id] as $row) {
			 ?>
			 <tr class="row<?php echo ($num & 1); ?>">
			 
			<td><?php echo $row->id; ?></td>
			<?php 
				$text ="";
				for($i=1;$i<$level;$i++)
					$text .= "&nbsp;&nbsp;&nbsp;&nbsp;";
				if ($level > 0)
					$text .= "&nbsp;&nbsp;&nbsp;&nbsp;<sup>L</sup>&nbsp;";
				$text .=$row->name;
			?>
			<td>
				<?php echo $text; ?>
			</td>
			<?php
			$num++;
			$num = HTML_adsmanager::recurseMarketplaceCategories($option, $row->id, $level+1, $children,$num,$option);
		}
	}
	return $num;
}



function displayConvertMarketplace($option,$ads,$cats){
?>
<?php HTML_adsmanager::header($option,ADSMANAGER_CONVERT_MARKETPLACE); ?>

<h3><?php echo ADSMANAGER_TOOLS_MARKETPLACE_CATEGORIES; ?></h3>
<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
<tr>
<th class="title" width="2%">Id</th>
<th class="title" width="30%"><?php echo ADSMANAGER_TH_CATEGORY;?></th>
<?php
HTML_adsmanager::recurseMarketplaceCategories($option, 0, 0, $cats,0,$option);
?>
</table>
<h3><?php echo ADSMANAGER_TOOLS_MARKETPLACE_ADS; ?></h3>
<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
<tr>
<th class="title" width="2%">Id</th>
<th class="title" width="30%"><?php echo ADSMANAGER_TH_TITLE;?></th>
<th class="title" width="30%"><?php echo ADSMANAGER_TH_CATEGORY;?></th>
<?php
if (isset($ads)) {
	$total = count($ads);
	foreach($ads as $ad) {
		?>
		<tr>
			<td><?php echo $ad->id; ?></td>
			<td><?php echo $ad->ad_headline; ?></td>
			<td><?php echo $ad->cat; ?></td>
		</tr>
		<?php
	}
}
?>
</table>
<br />
<h3><a href="index2.php?option=<?php echo $option; ?>&act=tools&task=importMarketplace"><?php echo ADSMANAGER_IMPORT_MARKETPLACE;?></a></h3>
<?php
}

function displayTools($option){
?>
<?php HTML_adsmanager::header($option,ADSMANAGER_TOOLS_MAIN_PAGE); ?>

<ul>
<li><a href="index2.php?option=<?php echo $option; ?>&act=tools&task=displayMarketplace"><?php echo ADSMANAGER_CONVERT_MARKETPLACE;?></a></li>
<li><a href="index2.php?option=<?php echo $option; ?>&act=tools&task=installjoomfish"><?php echo ADSMANAGER_INSTALL_JOOMFISH;?></a></li>
<li><a href="index2.php?option=<?php echo $option; ?>&act=tools&task=installsef"><?php echo ADSMANAGER_INSTALL_SEF;?></a></li>
</ul>
<?php	
}

function selectCBFields($cbfields,$cb,$id){
	if (isset($cbfields[0]))
	{
	?>
		<select id='comprofiler_<?php echo $id; ?>' name='comprofiler_<?php echo $id; ?>'>
	<?php
		foreach($cbfields as $field)
		{
			if ($cb->cb_field == $field->fieldid)
				echo "<option value='".$field->fieldid."' selected>(".$field->fieldid.") ".$field->name."</option>";
			else
				echo "<option value='".$field->fieldid."'>(".$field->fieldid.") ".$field->name."</option>";
		
		}
	?>
		</select>
	<?php
	}
}

function editConfiguration($option,$row)
{
	global $mosConfig_lang;
?>
<?php HTML_adsmanager::header($option,ADSMANAGER_CONFIGURATION_PANEL); ?>
<script type="text/javascript">
function submitbutton(pressbutton) {
	   <?php getEditorContents( 'editor1', 'fronttext' ); ?>
	   <?php getEditorContents( 'editor2', 'rules_text' ); ?>
	   <?php getEditorContents( 'editor3', 'recall_text' ); ?>
       submitform(pressbutton);
   }
</script>
<table width="100%">
<tr><td>
<form action="index2.php" method="post" name="adminForm">
<?php 
$configtabs = new mosTabs( 0 );
$configtabs->startPane( "config" );
$configtabs->startTab(ADSMANAGER_TAB_GENERAL,"general-page");
?>
<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
	<tr>
		<td><?php echo ADSMANAGER_ADS_PER_PAGE;?></td>
		<td><input type="text" name="ads_per_page" value=<?php echo $row->ads_per_page; ?> /></td>
		<td><?php echo ADSMANAGER_ADS_PER_PAGE_LONG;?></td>
	</tr>	
	<tr>
		<td><?php echo ADSMANAGER_AUTO_PUBLISH; ?></td>
		<td>
		 <select id='auto_publish' name='auto_publish'>
			<option value='1' <?php if ($row->auto_publish == 1) { echo "selected"; } ?>><?php echo ADSMANAGER_YES; ?></option>
			<option value='0' <?php if ($row->auto_publish == 0) { echo "selected"; } ?>><?php echo ADSMANAGER_NO; ?></option>
		  </select>
		</td>
		<td><?php echo ADSMANAGER_AUTO_PUBLISH_LONG; ?></td>
	</tr>
	<tr>
		<td><?php echo ADSMANAGER_SUBMISSION_TYPE; ?></td>
		<td>
		<select id='submission_type' name='submission_type'>
			<option value='0' <?php if ($row->submission_type == 0) { echo "selected"; } ?>><?php echo ADSMANAGER_SUBMISION_WITH_ACCOUNT_CREATION; ?></option>
			<option value='1' <?php if ($row->submission_type == 1) { echo "selected"; } ?>><?php echo ADSMANAGER_SUBMISSION_ALLOWED_ONLY_FOR_REGISTERS; ?></option>
			<option value='2' <?php if ($row->submission_type == 2) { echo "selected"; } ?>><?php echo ADSMANAGER_SUBMISSION_ALLOWED_FOR_VISITORS; ?></option>
		</select>
		</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><?php echo ADSMANAGER_ROOT_SUBMIT; ?></td>
		<td>
		<select id='root_allowed' name='root_allowed'>
			<option value='1' <?php if ($row->root_allowed == 1) { echo "selected"; } ?>><?php echo ADSMANAGER_ROOT_SUBMIT_ALLOWED; ?></option>
			<option value='0' <?php if ($row->root_allowed == 0) { echo "selected"; } ?>><?php echo ADSMANAGER_ROOT_SUBMIT_NOT_ALLOWED; ?></option>
		</select>
		</td>
		<td><?php echo ADSMANAGER_ROOT_SUBMIT_LONG; ?></td>
	</tr>
	<tr>
		<td><?php echo ADSMANAGER_NB_ADS_BY_USER; ?></td>
		<td><input type="text" name="nb_ads_by_user" value=<?php echo $row->nb_ads_by_user; ?> /></td>
		<td><?php echo ADSMANAGER_NB_ADS_BY_USER_LONG; ?></td>
	</tr>
	<tr>
	<td><?php echo ADSMANAGER_EMAIL_ON_NEW; ?></td>
	<td>
	 <select id='send_email_on_new' name='send_email_on_new'>
		<option value='1' <?php if ($row->send_email_on_new == 1) { echo "selected"; } ?>><?php echo ADSMANAGER_YES; ?></option>
		<option value='0' <?php if ($row->send_email_on_new == 0) { echo "selected"; } ?>><?php echo ADSMANAGER_NO; ?></option>
	  </select>
	</td>
	<td><?php echo ADSMANAGER_EMAIL_ON_NEW_LONG; ?></td>
	</tr>
	<tr>
		<td><?php echo ADSMANAGER_EMAIL_ON_UPDATE; ?></td>
		<td>
		 <select id='send_email_on_update' name='send_email_on_update'>
			<option value='1' <?php if ($row->send_email_on_update == 1) { echo "selected"; } ?>><?php echo ADSMANAGER_YES; ?></option>
			<option value='0' <?php if ($row->send_email_on_update == 0) { echo "selected"; } ?>><?php echo ADSMANAGER_NO; ?></option>
		  </select>
		</td>
		<td><?php echo ADSMANAGER_EMAIL_ON_UPDATE_LONG; ?></td>
	</tr>
	<tr>
		<td><?php echo ADSMANAGER_COMMUNITY_BUILDER; ?></td>
		<td>
		<select id='comprofiler' name='comprofiler'>
			<option value='2' <?php if ($row->comprofiler == 2) { echo "selected"; } ?>><?php echo ADSMANAGER_FULL; ?></option>
			<option value='1' <?php if ($row->comprofiler == 1) { echo "selected"; } ?>><?php echo ADSMANAGER_PROFILE; ?></option>
			<option value='0' <?php if ($row->comprofiler == 0) { echo "selected"; } ?>><?php echo ADSMANAGER_NO; ?></option>
		</select>
		</td>
		<td><?php echo ADSMANAGER_COMMUNITY_BUILDER_LONG; ?></td>
	</tr>
	<tr>
		<td><?php echo ADSMANAGER_DISPLAY_MODE; ?></td>
		<td>
		<select id='display_expand' name='display_expand'>
			<option value='1' <?php if ($row->display_expand == 1) { echo "selected"; } ?>><?php echo ADSMANAGER_SHORT_AND_EXPAND_MODE; ?></option>
			<option value='2' <?php if ($row->display_expand == 2) { echo "selected"; } ?>><?php echo ADSMANAGER_EXPAND_MODE; ?></option>
			<option value='0' <?php if ($row->display_expand == 0) { echo "selected"; } ?>><?php echo ADSMANAGER_SHORT_MODE; ?></option>
		</select>
		</td>
		<td><?php echo ADSMANAGER_DISPLAY_MODE_LONG; ?></td>
	</tr>
	<tr>
		<td><?php echo ADSMANAGER_LAST_ADS; ?></td>
		<td>
		<select id='display_last' name='display_last'>
			<option value='2' <?php if ($row->display_last == 2) { echo "selected"; } ?>><?php echo ADSMANAGER_LAST_BOTTOM;?></option>
			<option value='1' <?php if ($row->display_last == 1) { echo "selected"; } ?>><?php echo ADSMANAGER_LAST_TOP;  ?></option>
			<option value='0' <?php if ($row->display_last == 0) { echo "selected"; } ?>><?php echo ADSMANAGER_LAST_NONE; ?></option>
		</select>
		</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
	<td><?php echo ADSMANAGER_SHOW_RSS; ?></td>
	<td>
	 <select id='show_rss' name='show_rss'>
		<option value='1' <?php if ($row->show_rss == 1) { echo "selected"; } ?>><?php echo ADSMANAGER_YES; ?></option>
		<option value='0' <?php if ($row->show_rss == 0) { echo "selected"; } ?>><?php echo ADSMANAGER_NO; ?></option>
	  </select>
	</td>
	<td>&nbsp;<?php echo ADSMANAGER_SHOW_RSS_LONG; ?></td>
	</tr>
</table>
<?php   
$configtabs->endTab();
$configtabs->startTab(ADSMANAGER_TAB_CONTACT,"contact-page");
?>
<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
	<tr>
		<td><?php echo ADSMANAGER_SHOW_CONTACT; ?></td>
		<td>
		<select id='show_contact' name='show_contact'>
			<option value='1' <?php if ($row->show_contact == 1) { echo "selected"; } ?>><?php echo ADSMANAGER_SHOW_CONTACT_LOGGED_ONLY; ?></option>
			<option value='0' <?php if ($row->show_contact == 0) { echo "selected"; } ?>><?php echo ADSMANAGER_SHOW_CONTACT_ALL; ?></option>
		</select>
		</td>
		<td><?php echo ADSMANAGER_SHOW_CONTACT_LONG; ?></td>
	</tr>
	<tr>
		<td><?php echo ADSMANAGER_DISPLAY_FULLNAME; ?></td>
		<td>
		<select id='display_fullname' name='display_fullname'>
			<option value='1' <?php if ($row->display_fullname == 1) { echo "selected"; } ?>><?php echo ADSMANAGER_YES; ?></option>
			<option value='0' <?php if ($row->display_fullname == 0) { echo "selected"; } ?>><?php echo ADSMANAGER_NO; ?></option>
		</select>
		</td>
		<td><?php echo ADSMANAGER_DISPLAY_FULLNAME_LONG; ?></td>
	</tr>
	<tr>
		<td><?php echo ADSMANAGER_ALLOW_ATTACHMENT; ?></td>
		<td>
		<select id='allow_attachement' name='allow_attachement'>
			<option value='1' <?php if ($row->allow_attachement == 1) { echo "selected"; } ?>><?php echo ADSMANAGER_YES; ?></option>
			<option value='0' <?php if ($row->allow_attachement == 0) { echo "selected"; } ?>><?php echo ADSMANAGER_NO; ?></option>
		</select>
		</td>
		<td><?php echo ADSMANAGER_ALLOW_ATTACHMENT_LONG; ?></td>
	</tr>
	<tr>
		<td><?php echo ADSMANAGER_CONTACT_BY_PMS; ?></td>
		<td>
		<select id='allow_contact_by_pms' name='allow_contact_by_pms'>
			<option value='1' <?php if ($row->allow_contact_by_pms == 1) { echo "selected"; } ?>><?php echo ADSMANAGER_YES; ?></option>
			<option value='0' <?php if ($row->allow_contact_by_pms == 0) { echo "selected"; } ?>><?php echo ADSMANAGER_NO; ?></option>
		</select>
		</td>
		<td><?php echo ADSMANAGER_CONTACT_BY_PMS_LONG; ?></td>
	</tr>
	<tr>
		<td><?php echo ADSMANAGER_EMAIL_DISPLAY; ?></td>
		<td>
		<select id='email_display' name='email_display'>
			<option value='2' <?php if ($row->email_display == 2) { echo "selected"; } ?>><?php echo ADSMANAGER_EMAIL_DISPLAY_FORM;?></option>
			<option value='1' <?php if ($row->email_display == 1) { echo "selected"; } ?>><?php echo ADSMANAGER_EMAIL_DISPLAY_IMAGE;?></option>
			<option value='0' <?php if ($row->email_display == 0) { echo "selected"; } ?>><?php echo ADSMANAGER_EMAIL_DISPLAY_LINK;?></option>
		</select>
		</td>
		<td><?php echo ADSMANAGER_EMAIL_DISPLAY_LONG; ?></td>
	</tr>
</table>
<?php   
$configtabs->endTab();
$configtabs->startTab(ADSMANAGER_TAB_IMAGE,"image-page");
?>
<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
	<tr>
		<td><?php echo ADSMANAGER_NB_IMAGES; ?></td>
		<td><input type="text" name="nb_images" value=<?php echo $row->nb_images; ?> /></td>
		<td><?php echo ADSMANAGER_NB_IMAGES_LONG; ?></td>
	</tr>
	<tr>
	  <td><?php echo ADSMANAGER_MAX_IMAGE_SIZE;?></td>
	  <td><input type="text" name="max_image_size" value=<?php echo $row->max_image_size; ?> /></td>
	  <td><?php echo ADSMANAGER_MAX_IMAGE_SIZE_LONG;?></td>
    </tr>
    <tr>
	  <td><?php echo ADSMANAGER_MAX_IMAGE_WIDTH;?></td>
	  <td><input type="text" name="max_width" value=<?php echo $row->max_width; ?> /></td>
	  <td><?php echo ADSMANAGER_MAX_IMAGE_WIDTH_LONG;?></td>
    </tr>
    <tr>
	  <td><?php echo ADSMANAGER_MAX_IMAGE_HEIGHT;?></td>
	  <td><input type="text" name="max_height" value=<?php echo $row->max_height; ?> /></td>
	  <td><?php echo ADSMANAGER_MAX_IMAGE_HEIGHT_LONG;?></td>
    </tr>
    <tr>
	  <td><?php echo ADSMANAGER_MAX_THUMBNAIL_WIDTH;?></td>
	  <td><input type="text" name="max_width_t" value=<?php echo $row->max_width_t; ?> /></td>
	  <td><?php echo ADSMANAGER_MAX_THUMBNAIL_WIDTH_LONG;?></td>
    </tr>
    <tr>
	  <td><?php echo ADSMANAGER_MAX_THUMBNAIL_HEIGHT;?></td>
	  <td><input type="text" name="max_height_t" value=<?php echo $row->max_height_t; ?> /></td>
	  <td><?php echo ADSMANAGER_MAX_THUMBNAIL_HEIGHT_LONG;?></td>
    </tr>
    <tr>
		<td><?php echo ADSMANAGER_IMAGE_TAG; ?></td>
		<td><input type="text" name="tag" value="<?php echo $row->tag; ?>" /></td>
		<td><?php echo ADSMANAGER_IMAGE_TAG_LONG; ?></td>
	</tr>
	<tr>
		<td><?php echo ADSMANAGER_IMAGE_DISPLAY; ?></td>
		<td>
		<select id='image_display' name='image_display'>
			<option value='default' <?php if ($row->image_display == 'default') { echo "selected"; } ?>><?php echo ADSMANAGER_IMAGE_DISPLAY_DEFAULT; ?></option>
			<option value='lightbox' <?php if ($row->image_display == 'lightbox') { echo "selected"; } ?>><?php echo ADSMANAGER_IMAGE_DISPLAY_LIGHTBOX; ?></option>
			<option value='popup' <?php if ($row->image_display == 'popup') { echo "selected"; } ?>><?php echo ADSMANAGER_IMAGE_DISPLAY_POPUP; ?></option>
		</select>
		</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
	  <td><?php echo ADSMANAGER_MAX_CATIMAGE_WIDTH;?></td>
	  <td><input type="text" name="cat_max_width" value=<?php echo $row->cat_max_width; ?> /></td>
	  <td><?php echo ADSMANAGER_MAX_CATIMAGE_WIDTH_LONG;?></td>
    </tr>
    <tr>
	  <td><?php echo ADSMANAGER_MAX_CATIMAGE_HEIGHT;?></td>
	  <td><input type="text" name="cat_max_height" value=<?php echo $row->cat_max_height; ?> /></td>
	  <td><?php echo ADSMANAGER_MAX_CATIMAGE_HEIGHT_LONG;?></td>
    </tr>
    <tr>
	  <td><?php echo ADSMANAGER_MAX_CATTHUMBNAIL_WIDTH;?></td>
	  <td><input type="text" name="cat_max_width_t" value=<?php echo $row->cat_max_width_t; ?> /></td>
	  <td><?php echo ADSMANAGER_MAX_CATTHUMBNAIL_WIDTH_LONG;?></td>
    </tr>
    <tr>
	  <td><?php echo ADSMANAGER_MAX_CATTHUMBNAIL_HEIGHT;?></td>
	  <td><input type="text" name="cat_max_height_t" value=<?php echo $row->cat_max_height_t; ?> /></td>
	  <td><?php echo ADSMANAGER_MAX_CATTHUMBNAIL_HEIGHT_LONG;?></td>
    </tr>	
</table>
<?php   
$configtabs->endTab();
$configtabs->startTab(ADSMANAGER_TAB_TEXT,"text-page");
?>
<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
	<tr>
		<td><?php echo ADSMANAGER_FRONTPAGE; ?></td>
		<?php $fronttext = stripslashes($row->fronttext); ?>
		<td><?php editorArea( 'editor1',  "$fronttext" , 'fronttext', '100%;', '350', '75', '20' ) ; ?></td>
		<td><?php echo ADSMANAGER_FRONTPAGE_LONG; ?></td>
	</tr>
	<tr>
		<td><?php echo ADSMANAGER_RULES; ?></td>
		<?php $rules_text = stripslashes($row->rules_text); ?>
		<td><?php editorArea( 'editor2', "$rules_text" , 'rules_text', '100%;', '350', '75', '20' ) ; ?></td>
		<td>&nbsp;</td>
	</tr>
</table>

<?php   
$configtabs->endTab();
$configtabs->startTab(ADSMANAGER_TAB_EXPIRATION,"Expiration-page");
?>
<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
<tr>
		<td><?php echo ADSMANAGER_EXPIRATION; ?></td>
		<td>
		<select id='expiration' name='expiration'>
			<option value='1' <?php if ($row->expiration == 1) { echo "selected"; } ?>><?php echo ADSMANAGER_YES; ?></option>
			<option value='0' <?php if ($row->expiration == 0) { echo "selected"; } ?>><?php echo ADSMANAGER_NO; ?></option>
		</select>
		</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><?php echo ADSMANAGER_AD_DURATION; ?></td>
		<td><input type="text" name="ad_duration" value="<?php echo $row->ad_duration; ?>" /></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><?php echo ADSMANAGER_RECALL; ?></td>
		<td>
		<select id='recall' name='recall'>
			<option value='1' <?php if ($row->recall == 1) { echo "selected"; } ?>><?php echo ADSMANAGER_YES; ?></option>
			<option value='0' <?php if ($row->recall == 0) { echo "selected"; } ?>><?php echo ADSMANAGER_NO; ?></option>
		</select>
		</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><?php echo ADSMANAGER_RECALL_TIME; ?></td>
		<td><input type="text" name="recall_time" value="<?php echo $row->recall_time; ?>" /></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><?php echo ADSMANAGER_RECALL_TEXT; ?></td>
		<?php $recall_text = stripslashes($row->recall_text); ?>
		<td><?php editorArea( 'editor3',  "$recall_text" , 'recall_text', '100%;', '350', '75', '20' ) ; ?></td>
		<td>&nbsp;</td>
	</tr>
</table>   
<?php
$configtabs->endTab();
$configtabs->endPane();
?>

<input type="hidden" name="option" value="<?php echo $option; ?>" />

<input type="hidden" name="task" value="" />

<input type="hidden" name="id" value=<?php echo $row->id ?> />

<input type="hidden" name="act" value="configuration" />

</form> 
</td></tr></table>
	<?php
}

function displayLinkText($text,$link){
	echo '<a href="'.$link.'">'.$text.'</a>';
}

function displayLinkImage($img,$link){
	echo '<a href="'.$link.'"><img src="'.$img.'" border=0 /></a>';
}

function displayPublish($published,$link) {
	if ($published == 1 ) {
	// Published
		$img = 'tick.png';
		$plink = $link."&publish=0";
	} else {
	// Unpublished
		$img = 'publish_x.png';
		$plink = $link."&publish=1";
	}
	?>
	<a href="<?php echo $plink; ?>">
		<img src="images/<?php echo $img;?>" width="12" height="12" border="0" alt="<?php echo $alt; ?>" />
	</a>
	<?php
}

function displayRequired($required,$link) {
	if ($required == 1 ) {
	// Published
		$img = 'tick.png';
		$plink = $link."&required=0";
	} else {
	// Unpublished
		$img = 'publish_x.png';
		$plink = $link."&required=1";
	}
	?>
	<a href="<?php echo $plink; ?>">
		<img src="images/<?php echo $img;?>" width="12" height="12" border="0" alt="<?php echo $alt; ?>" />
	</a>
	<?php
}

function listAds($cat,$option, $rows,$pagenav,$navlink,$cats,$nb_images)
{
	global $mosConfig_absolute_path,$mosConfig_live_site;
?>
<?php HTML_adsmanager::header($option,ADSMANAGER_CATEGORY_ITEMS.$cat->name); ?>
<br />
<?php echo '<p>'.$pagenav->writePagesCounter().'</p>'; ?>
<form action="index2.php" method="post" name="adminForm">
<select name="catid" id="catid" onchange="document.adminForm.submit();">
<option value="0" <?php if (!isset($cat)) echo selected; ?>><?php echo ADSMANAGER_MENU_ALL_ADS; ?></option>
<?php HTML_adsmanager::selectCategories(0,"",$cats,$cat->id,-1); ?>
</select>
<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">

<tr>
<th class="title" width="5"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows); ?>);" /></th>

<th class="title" width="5%">Id</th>
<th class="title" width="20%"><?php echo ADSMANAGER_TH_TITLE;?></th>
<th class="title" width="5%"><?php echo ADSMANAGER_TH_PUBLISH;?></th>
<th class="title" width="30%"><?php echo ADSMANAGER_TH_IMAGE;?></th>
<th class="title" width="10%"><?php echo ADSMANAGER_TH_USER;?></th>
<th class="title" width="10%"><?php echo ADSMANAGER_TH_CATEGORY;?></th>
<th class="title" width="10%"><?php echo ADSMANAGER_TH_DATE;?></th>

</tr>

<?php
	$k = 0;
	for($i=0; $i < count( $rows ); $i++) {
	$row = $rows[$i];

    ?>
     <tr class="row<?php echo $k; ?>">
	<td><input type="checkbox" id="cb<?php echo $i;?>" name="tid[]" value="<?php echo $row->id; ?>" onclick="isChecked(this.checked);" /></td>

	<td><?php echo $row->id; ?></td>
	<td><?php HTML_adsmanager::displayLinkText($row->ad_headline,"index2.php?option=$option&act=ads&task=edit&catid=".$row->category."&tid[]=".$row->id); ?></td>
	<td><?php HTML_adsmanager::displayPublish($row->published,"index2.php?option=$option&act=ads&task=publish&catid=".$row->category."&tid[]=".$row->id); ?></td>
	<td>
	<?php
	for($j=1;$j < $nb_images + 1;$j++)
	{
		$ext_name = chr(ord('a')+$j-1);
		$pic = $mosConfig_absolute_path."/images/$option/ads/".$row->id.$ext_name."_t.jpg";
		if (file_exists($pic)) 
		{
			echo "<img src='".$mosConfig_live_site."/images/$option/ads/".$row->id.$ext_name."_t.jpg'>";
		} 
		echo '&nbsp;';  
	}
	?>
	</td>
	<td><?php echo $row->username; ?></td>
	<td><?php echo '<a href="index2.php?option='.$option.'&act=ads&catid='.$row->category.'">'.$row->catname.'</a>'; ?></td>
	<td><?php echo $row->date_created; ?></td>
	</tr>
<?php
	$k = !$k;
	} 

?>
</table>

<input type="hidden" name="option" value="<?php echo $option; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="act" value="ads" />
<input type="hidden" name="boxchecked" value="0" />
<?php 
echo $pagenav->getListFooter(); 
?>
</form> 
<?php
}

function recurseCategories($option, $id, $level, $children,$pageNav,$num,$nb,$option) {
	if (@$children[$id]) {
		$n = 0; 
		$total = count($children[$id]);
		foreach ($children[$id] as $row) {
			 ?>
			 <tr class="row<?php echo ($num & 1); ?>">
			 <td><input type="checkbox" id="cb<?php echo $num;?>" name="tid[]" value="<?php echo $row->id; ?>" onclick="isChecked(this.checked);" /></td>
		
			<td><?php echo $row->id; ?></td>
			<?php 
				$text ="";
				for($i=1;$i<$level;$i++)
					$text .= "&nbsp;&nbsp;&nbsp;&nbsp;";
				if ($level > 0)
					$text .= "&nbsp;&nbsp;&nbsp;&nbsp;<sup>L</sup>&nbsp;";
				$text .=$row->name;
			?>
			<td>
				<?php HTML_adsmanager::displayLinkText($text,"index2.php?option=$option&act=categories&task=edit&tid[]=".$row->id); ?>
			</td>
			<td>
			<?php 
				$pict = "../images/$option/categories/".$row->id."cat_t.jpg";
				if (file_exists($pict)) 
				{
				  echo '<img src="../images/'.$option.'/categories/'.$row->id.'cat_t.jpg"/>';
				}
				else
				{
				  echo '<img src="../components/'.$option.'/images/default.gif"/>';
				}
			?>
			</td>
			<td><?php HTML_adsmanager::displayLinkImage("../includes/js/ThemeOffice/mainmenu.png","index2.php?option=$option&act=ads&catid=".$row->id); ?></td>
			<td align="right">
			<?php echo $pageNav->orderUpIcon( $num, ($n > 0)); ?>
			</td>
			<td align="left">
			<?php echo $pageNav->orderDownIcon( $num, $nb, ($n < $total -1 )); ?>
			</td>
			<td align="center" colspan="2">
			<input type="text" name="order[]" size="5" value="<?php echo $row->ordering; ?>" class="text_area" style="text-align: center" />
			</td>
			<td><?php HTML_adsmanager::displayPublish($row->published,"index2.php?option=$option&act=categories&task=publish&tid[]=".$row->id); ?></td>
			</tr>
			<?php
			$num++;
			$num = HTML_adsmanager::recurseCategories($option, $row->id, $level+1, $children,$pageNav,$num,$nb,$option);
			$n++;
		}
	}
	return $num;
}

function listcategories($option, $nb, $children,$pageNav)
{
?>
<?php HTML_adsmanager::header($option,ADSMANAGER_LIST_CATEGORIES); ?>
<br />
<form action="index2.php" method="post" name="adminForm">
<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">

<tr>
<th class="title" width="2%"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo $nb; ?>);" /></th>
<th class="title" width="2%">Id</th>
<th class="title" width="30%"><?php echo ADSMANAGER_TH_CATEGORY;?></th>
<th class="title" width="5%"><?php echo ADSMANAGER_TH_IMAGE;?></th>
<th class="title" width="5%"><?php echo ADSMANAGER_TH_ADS;?></th>
<th colspan="2" align="center" width="5%">
<?php echo ADSMANAGER_REORDER; ?>
</th>
<th width="3%">
<?php echo ADSMANAGER_ORDER; ?>
</th>
<th width="3%">
<a href="javascript: saveorder( <?php echo $nb-1; ?> )"><img src="images/filesave.png" border="0" width="16" height="16" /></a>
</th>
<th class="title" width="40%"><?php echo ADSMANAGER_TH_PUBLISH;?></th>
</tr>
<?php
HTML_adsmanager::recurseCategories($option, 0, 0, $children,$pageNav,0,$nb,$option);
?>
</table>

<input type="hidden" name="option" value="<?php echo $option; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="act" value="categories" />
<input type="hidden" name="boxchecked" value="0" />
</form> 
	<?php
}

function selectCategories($id, $level, $children,$catid,$nodisplaycatid,$multiple=0,$catsid="") {
	if (@$children[$id]) {
		foreach ($children[$id] as $row) {
			if ($row->id != $nodisplaycatid) {
				if ((($multiple == 0)&&($row->id != $catid))
				    ||
				    (($multiple == 1)&&(strpos($catsid, ",$row->id,") === false)))
					echo "<option value='".$row->id."'>".$level.$row->name."</option>";
				else
					echo "<option value='".$row->id."' selected>".$level.$row->name."</option>";
				
				HTML_adsmanager::selectCategories($row->id, $level.$row->name." >> ", $children,$catid,$nodisplaycatid,$multiple,$catsid);
			}
		}
	}
}

function displayFields($row,$fields,$field_values)
{
	global $mosConfig_live_site;
	
	foreach($fields as $field)
	{
		echo "<tr><td>".HTML_adsmanager::getLangDefinition($field->title)."</td><td>\n";
		$name = $field->name;
		$value = "@\$row->".$field->name;
		eval("\$value = \"\".$value;");
		$value = HTML_adsmanager::getLangDefinition($value);
		switch($field->type)
		{
			case 'checkbox':
				if ($field->required == 1)
					$mosReq = "mosReq='1'";
								
				if ($value == 1)
					echo "<input class='inputbox' type='checkbox' $mosReq mosLabel='$field->title' checked='checked' name='$name' value='1' />\n";
				else
					echo "<input class='inputbox' type='checkbox' $mosReq mosLabel='$field->title' name='$name' value='1' />\n";
				break;
			case 'multicheckbox':
				echo "<table class='cbMulti'>\n";
				$k = 0;
				for ($i=0 ; $i < $field->rows;$i++)
				{
					echo "<tr>\n";
					for ($j=0 ; $j < $field->cols;$j++)
					{
						$fieldvalue = @$field_values[$field->fieldid][$k]->fieldvalue;
						$fieldtitle = @$field_values[$field->fieldid][$k]->fieldtitle;
						if (@$fieldtitle)
						{
							$fieldtitle = HTML_adsmanager::getLangDefinition($fieldtitle);
						}
						echo "<td>\n";
						if (isset($field_values[$field->fieldid][$k]->fieldtitle))
						{
							if (($field->required == 1)&($k==0))
								$mosReq = "mosReq='1'";
							else
								$mosReq = "";
							
							if (strpos($value, $fieldvalue) === false)
								echo "<input class='inputbox' type='checkbox' $mosReq  mosLabel='$field->title' name='".$name."[]' value='$fieldvalue' />&nbsp;$fieldtitle&nbsp;\n";
							else
								echo "<input class='inputbox' type='checkbox' $mosReq  mosLabel='$field->title' checked='checked' name='".$name."[]' value='$fieldvalue' />&nbsp;$fieldtitle&nbsp;\n";
							
						}
						echo "</td>\n";
						$k++;
					}
					echo "</tr>\n";
				}
				echo "</table>\n";
				break;

			case 'select':
				if ($field->required == 1)
					echo "<select id='$name' name='$name' mosReq='1' mosLabel='$field->title' class='adsmanager_required'>\n";
				else
					echo "<select id='$name' name='$name' mosLabel='$field->title' class='adsmanager'>\n";
					
				if ($value=="")
					echo "<option value=''>&nbsp;</option>\n";	
				foreach($field_values[$field->fieldid] as $v)
				{
					$v->fieldtitle = HTML_adsmanager::getLangDefinition($v->fieldtitle);
					
					if ($value == $v->fieldvalue)
						echo "<option value='$v->fieldvalue' selected >$v->fieldtitle</option>\n";
					else
						echo "<option value='$v->fieldvalue' >$v->fieldtitle</option>\n";
				}
				
				echo "</select>\n";
				break;
				
			case 'multiselect':
				if ($field->required == 1)
					echo "<select id=\"".$name."[]\" name=\"".$name."[]\" mosReq='1' mosLabel='$field->title' multiple='multiple' size='$field->size' class='adsmanager_required'>\n";
				else
					echo "<select id='".$name."[]' name=\"".$name."[]\" mosLabel='$field->title' multiple='multiple' size='$field->size' class='adsmanager'>\n";
					
				if ($value=="")
					echo "<option value=''>&nbsp;</option>\n";	
				foreach($field_values[$field->fieldid] as $v)
				{
					$v->fieldtitle = HTML_adsmanager::getLangDefinition($v->fieldtitle);
					if ($field->required == 1)
						$mosReq = "mosReq='1'";
						
					if (strpos($value, ",".$v->fieldvalue.",") === false)
						echo "<option value='$v->fieldvalue' >$v->fieldtitle</option>\n";
					else
						echo "<option value='$v->fieldvalue' selected >$v->fieldtitle</option>\n";
				}
				
				echo "</select>\n";
				break;
				
			case 'textarea':
				if ($field->required == 1)
					echo "<textarea class='adsmanager_required' mosReq='1' mosLabel='$field->title' id='$name' name='$name' cols='".$field->cols."' rows='".$field->rows."' wrap='VIRTUAL'>$value</textarea>\n"; 
				else
					echo "<textarea class='adsmanager' id='$name' mosLabel='$field->title' name='$name' cols='".$field->cols."' rows='".$field->rows."' wrap='VIRTUAL'>$value</textarea>\n"; 	
				break;
				
			case 'number':
			case 'price':
				if ($field->required == 1)
					echo "<input class='adsmanager_required' mosReq='1' id='$name' type='text' test='number' mosLabel='$field->title' name='$name' size='$field->size' maxlength='$field->maxlength' value='$value'>\n"; 
				else
					echo "<input class='adsmanager' id='$name' type='text' name='$name' test='number' mosLabel='$field->title' size='$field->size' maxlength='$field->maxlength' value='$value'>\n";
				break;
			case 'emailaddress':
				if ($field->required == 1)
					echo "<input class='adsmanager_required' mosReq='1' id='$name' type='text' test='emailaddress' mosLabel='$field->title' name='$name' size='$field->size' maxlength='$field->maxlength' value='$value'>\n"; 
				else
					echo "<input class='adsmanager' id='$name' type='text' test='emailaddress' name='$name' mosLabel='$field->title' size='$field->size' maxlength='$field->maxlength' value='$value'>\n";
				break;
				
			case 'url':
			case 'text':
			
				if ($field->required == 1)
					echo "<input class='adsmanager_required' mosReq='1' id='$name' type='text' mosLabel='$field->title' name='$name' size='$field->size' maxlength='$field->maxlength' value='$value'>\n"; 
				else
					echo "<input class='adsmanager' id='$name' type='text' name='$name' mosLabel='$field->title' size='$field->size' maxlength='$field->maxlength' value='$value'>\n";
				break;
				
			case 'radio':
				echo "<table class='cbMulti'>\n";
				$k = 0;
				for ($i=0 ; $i < $field->rows;$i++)
				{
					echo "<tr>\n";
					for ($j=0 ; $j < $field->cols;$j++)
					{
						$fieldvalue = @$field_values[$field->fieldid][$k]->fieldvalue;
						$fieldtitle = @$field_values[$field->fieldid][$k]->fieldtitle;
						echo "<td>\n";
						if (isset($field_values[$field->fieldid][$k]->fieldtitle))
						{
							if (($field->required == 1)&($k==0))
								$mosReq = "mosReq='1'";
							else
								$mosReq = "";
						
							if ($value == $fieldvalue)
								echo "<input type='radio' $mosReq name='$name' mosLabel='$field->title' value='$fieldvalue' checked='checked' />&nbsp;$fieldtitle&nbsp;\n";
							else
								echo "<input type='radio' $mosReq name='$name' mosLabel='$field->title' value='$fieldvalue'/>&nbsp;$fieldtitle&nbsp;\n";
						}
						echo "</td>\n";
						$k++;
					}
					echo "</tr>\n";
				}
				echo "</table>\n";
				break;
			case 'file':
				echo "<input id='$name' type='file' name='$name' mosLabel='$strtitle'/>";
				if (isset($value)&&($value != ""))
				{
					echo "<br/><label></label><a href='$mosConfig_live_site/images/com_adsmanager/files/$value' target='_blank'>".ADSMANAGER_DOWNLOAD_FILE."</a>";
				}
				break;
		}
		echo "</td><td>&nbsp;</td></tr>";		
	}
}

function displayAd($option,$row,$fields,$field_values,$cats,$nb_images)
{
	global $my,$mosConfig_absolute_path;
?>
<?php HTML_adsmanager::header($option,ADSMANAGER_AD_EDITION); ?>
<form action="index2.php" method="post" name="adminForm" id="adminForm" class="adminForm" enctype="multipart/form-data">
<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
<tr>
<td><?php echo ADSMANAGER_FORM_CATEGORY;?></td>
<td>
<select name="category" id="category">
<?php HTML_adsmanager::selectCategories(0,"",$cats,$row->category,-1); ?>
</select>
</td>
<td>&nbsp;</td>
</tr>
<?php
	HTML_adsmanager::displayFields($row,$fields,$field_values);	
?>
<?php
for($i = 1; $i < $nb_images + 1; $i++)
{
	$ext_name = chr(ord('a')+$i-1);
	?>
	<tr>
	<td><?php echo ADSMANAGER_FORM_AD_PICTURE." ".$i; ?></td>
	<td>
	<input type="file" name="ad_picture<?php echo $i;?>"/>
	<br />
	<?php 
	   $pic = $mosConfig_absolute_path."/images/$option/ads/".$row->id.$ext_name."_t.jpg";
	   if (file_exists($pic)) 
	   {
		 echo '<img src="../images/'.$option.'/ads/'.$row->id.$ext_name.'_t.jpg"/>';
		 echo "<input type='checkbox' name='cb_image$i' value='delete'>".ADSMANAGER_AD_DELETE_IMAGE;
	   }
	?>
	<br />
	</td>
	<td>&nbsp;</td>
	</tr>
	<?php
}
?>

<tr>
<td><?php echo ADSMANAGER_TH_PUBLISH; ?></td>
<td>
<select name="published" id="published">
<option value="1" <?php if ($row->published == 1) { echo "selected"; } ?>><?php echo ADSMANAGER_PUBLISH; ?></option>
<option value="0" <?php if ($row->published == 0) { echo "selected"; } ?>><?php echo ADSMANAGER_NO_PUBLISH ?></option>
</select>
</td>
<td>&nbsp;</td>
</tr>

</table>
<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
<?php if (isset($row->userid)) { $userid = $row->userid; } else { $userid = $my->id; } ?>
<?php if (isset($row->date_created)) { $date_created = $row->date_created; } else { $date_created = date("Y-m-d"); } ?>

<input type="hidden" name="date_created" value="<?php echo $date_created; ?>" />
<input type="hidden" name="userid" value="<?php echo $userid; ?>" />
<input type="hidden" name="option" value="<?php echo $option; ?>" />
<input type="hidden" name="act" value="ads" />
<input type="hidden" name="task" value="" />
</form>
<?php 
}

function displayCategory($option,$row,$cats)
{
	global $mosConfig_absolute_path;
?>
<script type="text/javascript">
function submitbutton(pressbutton) {
	   <?php getEditorContents( 'editor1', 'description' ); ?>
       submitform(pressbutton);
   }
</script>
<?php HTML_adsmanager::header($option,ADSMANAGER_CATEGORY_EDITION); ?>
<form action="index2.php" method="post" name="adminForm" id="adminForm" class="adminForm" enctype="multipart/form-data">
<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">

<tr>
<td><?php echo ADSMANAGER_TH_TITLE; ?></td>
<td><input type="text" size="50" maxsize="100" name="name" value="<?php echo @$row->name; ?>" /></td>
<td>&nbsp;</td>
</tr>

<tr>
<td><?php echo ADSMANAGER_TH_PARENT; ?></td>
<td>
<select name="parent" id="parent">
<option value="0"><?php echo ADSMANAGER_ROOT; ?></option>
<?php HTML_adsmanager::selectCategories(0,"Root >> ",$cats,@$row->parent,@$row->id); ?>
</select>
</td>
<td>&nbsp;</td>
</tr>

<tr>
<td><?php echo ADSMANAGER_TH_IMAGE; ?></td>
<td>
<input type="file" name="cat_image"/>
<?php 
   $a_pic = "$mosConfig_absolute_path/images/$option/categories/".@$row->id."cat.jpg";
   if (file_exists($a_pic)) 
   {
     echo '<img src="../images/'.$option.'/categories/'.@$row->id.'cat.jpg"/>';
     echo "<input type='checkbox' name='cb_image' value='delete'>".ADSMANAGER_AD_DELETE_IMAGE;
   }
?>
</td>
</tr>
<tr>
<td><?php echo ADSMANAGER_TH_DESCRIPTION; ?></td>
<td><?php editorArea( 'editor1',  @$row->description , 'description', '100%;', '350', '75', '20' ) ; ?></td>
<td>&nbsp;</td>
</tr>
<tr>
<td><?php echo ADSMANAGER_TH_PUBLISH; ?></td>
<td>
<select name="published" id="published">
<option value="1" <?php if ($row->published == 1) { echo "selected"; } ?>><?php echo ADSMANAGER_PUBLISH; ?></option>
<option value="0" <?php if ($row->published == 0) { echo "selected"; } ?>><?php echo ADSMANAGER_NO_PUBLISH ?></option>
</select>
</td>
<td>&nbsp;</td>
</tr>

</table>
<input type="hidden" name="id" value="<?php echo @$row->id; ?>" />
<input type="hidden" name="option" value="<?php echo $option; ?>" />
<input type="hidden" name="act" value="categories" />
<input type="hidden" name="task" value="" />
</form>
<?php 
}

function header($option,$text)
{
?>
<table border="0" class="adminheading" cellpadding="0" cellspacing="0" width="100%">
<tr valign="middle">
<th class="config"><a href="index2.php?option=<?php echo $option; ?>">AdsManager</a> : <?php echo $text; ?></th>
</tr>
</table>
<h3><a href="index2.php?option=<?php echo $option; ?>&act=configuration&task=edit"><?php echo ADSMANAGER_CONFIGURATION; ?></a> - 
<a href="index2.php?option=<?php echo $option; ?>&act=fields"><?php echo ADSMANAGER_FIELDS; ?></a> - 
<a href="index2.php?option=<?php echo $option; ?>&act=columns"><?php echo ADSMANAGER_COLUMNS; ?></a> - 
<a href="index2.php?option=<?php echo $option; ?>&act=positions"><?php echo ADSMANAGER_AD_DISPLAY; ?></a> - 
<a href="index2.php?option=<?php echo $option; ?>&act=categories"><?php echo ADSMANAGER_LIST_CATEGORIES;?></a> - 
<a href="index2.php?option=<?php echo $option; ?>&act=ads"><?php echo ADSMANAGER_LIST_ADS;?></a> -
<a href="index2.php?option=<?php echo $option; ?>&act=tools"><?php echo ADSMANAGER_TOOLS;?></a></h3>
<?php
}

function showFields( &$rows, $option ,$pageNav) {
		global $mosConfig_offset;
?>
<?php HTML_adsmanager::header($option,ADSMANAGER_FIELDS_LIST); ?>
<script type="text/javascript">
function cbsaveorder( n ) {
	cbcheckAll_button( n );
	submitform('savefieldorder');
}

//needed by sbsaveorder function
function cbcheckAll_button( n ) {
	for ( var j = 0; j <= n; j++ ) {
		box = eval( "document.adminForm.cb" + j );
		if ( box.checked == false ) {
			box.checked = true;
		}
	}
}
</script>
<form action="index2.php" method="post" name="adminForm">
  <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
    <tr>
      <th width="2%" class="title">#</td>
      <th width="3%" class="title"> <input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($rows); ?>);" />
      </th>
      <th width="10%" class="title"><?php echo ADSMANAGER_TH_NAME;?></th>
      <th width="10%" class="title"><?php echo ADSMANAGER_TH_TITLE; ?></th>
      <th width="10%" class="title"><?php echo ADSMANAGER_TH_TYPE; ?></th>
      <th width="5%" class="title"><?php echo ADSMANAGER_TH_REQUIRED;?></th>
      <th width="5%" class="title"><?php echo ADSMANAGER_TH_PUBLISH;?></th>
      <th width="5%" class="title" colspan="2"><?php echo ADSMANAGER_TH_REORDER; ?></th>
	  <th width="1%"><a href="javascript: saveorder( <?php echo count( $rows )-1; ?> )"><img src="images/filesave.png" border="0" width="16" height="16" /></a></th>
    </tr>
<?php
		$k = 0;
		for ($i=0, $n=count( $rows ); $i < $n; $i++) {
			$row =& $rows[$i];
?>
    <tr class="<?php echo "row$k"; ?>">
      <td><?php echo $i+1?></td>
      <td><input type="checkbox" id="cb<?php echo $i;?>" name="tid[]" value="<?php echo $row->fieldid; ?>" onClick="isChecked(this.checked);" /></td>
      <td> <a href="index2.php?option=<?php echo $option; ?>&act=fields&task=edit&tid=<?php echo $row->fieldid; ?>">
        <?php echo $row->name; ?> </a> </td>
       <?php $row->title = HTML_adsmanager::getLangDefinition($row->title);?>
      <td><?php echo $row->title; ?></td>
      <td><?php echo $row->type; ?></td>
      <td width="10%"><?php HTML_adsmanager::displayRequired($row->required,"index2.php?option=$option&act=fields&task=required&tid[]=".$row->fieldid); ?></td>
      <td width="10%"><?php HTML_adsmanager::displayPublish($row->published,"index2.php?option=$option&act=fields&task=publish&tid[]=".$row->fieldid); ?></td> 
      <td>
		<?php echo $pageNav->orderUpIcon($i); ?>
      </td>
      <td>
		<?php echo $pageNav->orderDownIcon($i,$n); ?>
      </td>
	  <td align="center">
	  <input type="text" name="order[]" size="5" value="<?php echo $row->ordering; ?>" class="text_area" style="text-align: center" />
	  </td>
    </tr>
    <?php $k = 1 - $k; } ?>
  </table>
  <input type="hidden" name="option" value="<?php echo $option;?>" />
  <input type="hidden" name="task" value="showField" />
  <input type="hidden" name="boxchecked" value="0" />
  <input type="hidden" name="act" value="fields" />
</form>
<?php }

function editfield( &$row, $lists, $fieldvalues, $option, $tabid,$cats,$nbcats ) {
		global $my, $acl, $task;
?>
<?php HTML_adsmanager::header($option,ADSMANAGER_EDIT_FIELD); ?>
<script type="text/javascript">
  function getObject(obj) {
    var strObj;
    if (document.all) {
      strObj = document.all.item(obj);
    } else if (document.getElementById) {
      strObj = document.getElementById(obj);
    }
    return strObj;
  }
  
   function submitbutton(pressbutton) {
     if (pressbutton == 'showField') {
       document.adminForm.type.disabled=false;
       submitform(pressbutton);
       return;
     }
     var coll = document.adminForm;
     var errorMSG = '';
     var iserror=0;
     if (coll != null) {
       var elements = coll.elements;
       // loop through all input elements in form
       for (var i=0; i < elements.length; i++) {
         // check if element is mandatory; here mosReq=1
         if (elements.item(i).getAttribute('mosReq') == 1) {
           if (elements.item(i).value == '') {
             //alert(elements.item(i).getAttribute('mosLabel') + ':' + elements.item(i).getAttribute('mosReq'));
             // add up all error messages
             errorMSG += elements.item(i).getAttribute('mosLabel') + ' : <?php echo ADSMANAGER_REGWARN_ERROR; ?>\n';
             // notify user by changing background color, in this case to red
             elements.item(i).style.background = "red";
             iserror=1;
           }
         }
       }
     }
     if(iserror==1) {
       alert(errorMSG);
     } else {
       document.adminForm.type.disabled=false;
       submitform(pressbutton);
     }
   }

  function insertRow() {
    var oTable = getObject("fieldValuesBody");
    var oRow, oCell ,oCellCont, oInput;
    var oCell2 ,oCellCont2, oInput2;
    var i, j;
    i=document.adminForm.valueCount.value;
    i++;
    // Create and insert rows and cells into the first body.
    oRow = document.createElement("TR");
    oTable.appendChild(oRow);

    oCell = document.createElement("TD");
    oCell = document.createElement("TD");
    oInput=document.createElement("INPUT");
    oInput.name="vNames["+i+"]";
    oInput.setAttribute('mosLabel','Name');
    oInput.setAttribute('mosReq',0);
    oCell.appendChild(oInput);
    oCell2 = document.createElement("TD");
    oInput2=document.createElement("INPUT");
    oInput2.name="vValues["+i+"]";
    oInput2.setAttribute('mosLabel','Name');
    oInput2.setAttribute('mosReq',0); 
    oCell2.appendChild(oInput2);
     
    oRow.appendChild(oCell);
    oRow.appendChild(oCell2);
    oInput.focus();

    document.adminForm.valueCount.value=i;
  }

  function disableAll() {
    var elem;
    elem=getObject('divValues');
    elem.style.visibility = 'hidden';
    elem.style.display = 'none';
    elem=getObject('divColsRows');
    elem.style.visibility = 'hidden';
    elem.style.display = 'none';
    elem=getObject('divText');
    elem.style.visibility = 'hidden';
    elem.style.display = 'none';
    if (elem=getObject('vNames[0]')) {
      elem.setAttribute('mosReq',0);
    }
    if (elem=getObject('vValues[0]')) {
      elem.setAttribute('mosReq',0);
    }
  }
  
  function selType(sType) {
    var elem;
    //alert(sType);
    switch (sType) {
      case 'editorta':
      case 'textarea':
        disableAll();
        elem=getObject('divText');
        elem.style.visibility = 'visible';
        elem.style.display = 'block';
        elem=getObject('divColsRows');
        elem.style.visibility = 'visible';
        elem.style.display = 'block';
      break;
      
      case 'emailaddress':
      case 'number':
      case 'price':
      case 'password':
      case 'text':
      case 'url':
        disableAll();
        elem=getObject('divText');
        elem.style.visibility = 'visible';
        elem.style.display = 'block';
      break;
      
      case 'select':
      case 'multiselect':
        disableAll();
        elem=getObject('divValues');
        elem.style.visibility = 'visible';
        elem.style.display = 'block';
        if (elem=getObject('vNames[0]')) {
          elem.setAttribute('mosReq',1);
        }
        if (elem=getObject('vValues[0]')) {
		  elem.setAttribute('mosReq',1);
		}
      break;
      
      case 'radio':
      case 'multicheckbox':
        disableAll();
        elem=getObject('divColsRows');
        elem.style.visibility = 'visible';
        elem.style.display = 'block';
        elem=getObject('divValues');
        elem.style.visibility = 'visible';
        elem.style.display = 'block';
        if (elem=getObject('vNames[0]')) {
          elem.setAttribute('mosReq',1);
        }
        if (elem=getObject('vValues[0]')) {
          elem.setAttribute('mosReq',1);
        }
      break;

      case 'delimiter':
      default: 
        disableAll();
    }
  }

  function prep4SQL(o){
	if(o.value!='') {
		o.value=o.value.replace('ad_','');
    		o.value='ad_' + o.value.replace(/[^a-zA-Z]+/g,'');
	}
  }

</script>
	<form action="index2.php?option=com_adsmanager" method="POST" name="adminForm">
	<table cellspacing="0" cellpadding="0" width="100%">
	<tr valign="top">
		<td width="60%">
	<table class="adminform">
		<th colspan="3">
			Parameters
		</th>
		<tr>
			<td width="20%"><?php echo ADSMANAGER_FIELD_TYPE;?></td>
			<td width="20%"><?php echo $lists['type']; ?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="20%"><?php echo ADSMANAGER_FIELD_NAME;?></td>
			<td align=left  width="20%"><input onchange="prep4SQL(this);" type="text" name="name" mosReq=1 mosLabel="Name" class="inputbox" value="<?php echo $row->name; ?>" /></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="20%"><?php echo ADSMANAGER_FIELD_TITLE;?></td>
			<td width="20%" align=left><input type="text" name="title" mosReq=1 mosLabel="Title" class="inputbox" value="<?php echo $row->title; ?>" /></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="20%"><?php echo ADSMANAGER_FIELD_DISPLAY_TITLE;?></td>
			<td width="20%"><?php echo $lists['display_title']; ?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="20%"><?php echo ADSMANAGER_FIELD_DESCRIPTION;?></td>
			<td width="20%" align=left><input type="text" name="description" mosLabel="Description" size="40" value="<?php echo $row->description; ?>" /></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="20%"><?php echo ADSMANAGER_FIELD_REQUIRED;?></td>
			<td width="20%"><?php echo $lists['required']; ?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="20%"><?php echo ADSMANAGER_FIELD_COLUMN;?></td>
			<td width="20%"><?php echo $lists['columns']; ?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="20%"><?php echo ADSMANAGER_FIELD_COLUMN_ORDER;?></td>
			<td width="20%" align=left><input type="text" name="columnorder" mosLabel="Title" class="inputbox" value="<?php echo $row->columnorder; ?>" /></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="20%"><?php echo ADSMANAGER_FIELD_POSITION_DISPLAY;?></td>
			<td width="20%"><?php echo $lists['positions']; ?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="20%"><?php echo ADSMANAGER_FIELD_POSITION_ORDER;?></td>
			<td width="20%" align=left><input type="text" name="posorder" mosLabel="Title" class="inputbox" value="<?php echo $row->posorder; ?>" /></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="20%"><?php echo ADSMANAGER_FIELD_PUBLISHED;?></td>
			<td width="20%"><?php echo $lists['published']; ?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="20%"><?php echo ADSMANAGER_FIELD_SEARCHABLE;?></td>
			<td width="20%"><?php echo $lists['searchable']; ?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="20%"><?php echo ADSMANAGER_FIELD_EDITABLE;?></td>
			<td width="20%"><?php echo $lists['editable']; ?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="20%"><?php echo ADSMANAGER_FIELD_PROFILE;?></td>
			<td width="20%"><?php echo $lists['profile']; ?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="20%"><?php echo ADSMANAGER_FIELD_CB;?></td>
			<td width="20%"><?php echo $lists['cbfields']; ?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="20%"><?php echo ADSMANAGER_FIELD_SORT_OPTION;?></td>
			<td width="20%"><?php echo $lists['sort']; ?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="20%"><?php echo ADSMANAGER_FIELD_SORT_DIRECTION;?></td>
			<td width="20%"><?php echo $lists['sort_direction']; ?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="20%"><?php echo ADSMANAGER_FIELD_SIZE;?></td>
			<td width="20%"><input type="text" name="size" mosLabel="Size" class="inputbox" value="<?php echo $row->size; ?>" /></td>
			<td>&nbsp;</td>
		</tr>
		</table>
		<div id=page1  class="pagetext">
		
		</div>
		<div id=divText  class="pagetext">
		<table cellpadding="4" cellspacing="1" border="0" width="100%" class="adminform">
		<tr>
			<td width="20%"><?php echo ADSMANAGER_FIELD_MAX_LENGTH;?></td>
			<?php
				if (!isset($row->maxlength)||($row->maxlength ==""))
					$row->maxlength = 20;
			?>
			<td width="20%"><input type="text" name="maxlength" mosLabel="Max Length" class="inputbox" value="<?php echo $row->maxlength; ?>" /></td>
			<td>&nbsp;</td>
		</tr>
		</table>
		</div>
		<div id=divColsRows  class="pagetext">
		<table cellpadding="4" cellspacing="1" border="0" width="100%" class="adminform">
		<tr>
			<td width="20%"><?php echo ADSMANAGER_FIELD_COLS;?></td>
			<td width="20%"><input type="text" name="cols" mosLabel="Cols" class="inputbox" value="<?php echo $row->cols; ?>" /></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="20%"><?php echo ADSMANAGER_FIELD_ROWS;?></td>
			<td width="20%"><input type="text" name="rows"  mosLabel="Rows" class="inputbox" value="<?php echo $row->rows; ?>" /></td>
			<td>&nbsp;</td>
		</tr>
		</table>
		</div>
		<div id=divValues style="text-align:left;">
		<?php echo ADSMANAGER_FIELD_VALUES_EXPLANATION;?>
		<input type=button onclick="insertRow();" value="Add a Value" />
		<table align=left id="divFieldValues" cellpadding="4" cellspacing="1" border="0" width="100%" class="adminform" >
		<tr>
			<th width="20%"><?php echo ADSMANAGER_FIELD_VALUE_NAME;?></th>
			<th width="20%"><?php echo ADSMANAGER_FIELD_VALUE_VALUE;?></th>
		</tr>
		<tbody id="fieldValuesBody">
		<tr>
			<td>&nbsp;</td><td>&nbsp;</td>
		</tr>
	<?php	
		//echo "count:".count( $fieldvalues );
		//print_r (array_values($fieldvalues));
		for ($i=0, $n=count( $fieldvalues ); $i < $n; $i++) {
			//print "count:".$i;
			$fieldvalue = $fieldvalues[$i];
			if ($i==0) $req =1;
			else $req = 0;
			echo "<tr>\n<td width=\"20%\"><input type=text mosReq=0  mosLabel='Name' value='".stripslashes($fieldvalue->fieldtitle)."' name=vNames[$i] /></td>\n<td width=\"20%\"><input type=text mosReq=0 mosLabel='Value' value='".stripslashes($fieldvalue->fieldvalue)."' name=vValues[$i] /></td>\n</tr>\n";
		}
		if ($i > 0)
			$i--;
		if(count( $fieldvalues )< 1) {
			echo "<tr>\n<td width=\"20%\"><input type=text mosReq=0  mosLabel='Name' value='' name=vNames[0] /></td>\n<td width=\"20%\"><input type=text mosReq=0  mosLabel='Value' value='' name=vValues[0] /></td>\n</tr>\n";
			$i=0;
		}
	?>
		</tbody>
		</table>
		</div>
				  </td><td width="40%">
  <table class="adminform">
		<th><?php echo ADSMANAGER_FORM_CATEGORY; ?></th>
		<tr><td>	
			<select name="field_catsid[]" multiple='multiple' id="field_catsid[]" size="<?php echo $nbcats+2;?>">
			<?php
			if (strpos($row->catsid, ",-1,") === false)
				echo "<option value='-1'>".ADSMANAGER_MENU_ALL_ADS."</option>";
			else
				echo "<option value='-1' selected>".ADSMANAGER_MENU_ALL_ADS."</option>";
			HTML_adsmanager::selectCategories(0,"",$cats,-1,-1,1,$row->catsid);
			?>
			</select>
		</td></tr>
  </table>
  </td></tr>
  </table>
  <input type="hidden" name="valueCount" value=<?php echo $i; ?> />
  <input type="hidden" name="fieldid" value="<?php echo $row->fieldid; ?>" />
  <input type="hidden" name="ordering" value="<?php echo $row->ordering; ?>" />
  <input type="hidden" name="option" value="<?php echo $option; ?>" />
  <input type="hidden" name="act" value="fields" />
  <input type="hidden" name="task" value="" />
</form>
  
<?php 
	if($row->fieldid > 0) {
		print "<script type=\"text/javascript\"> document.adminForm.name.readOnly=true; </script>";	
		/*print "<script type=\"text/javascript\"> document.adminForm.type.disabled=true; </script>";*/
	}
	
		print "<script type=\"text/javascript\"> disableAll(); </script>";
		print "<script type=\"text/javascript\"> selType('".$row->type."'); </script>";	
}


function showColumns( $rows,$fColumn, $option )
{
?>
<?php HTML_adsmanager::header($option,ADSMANAGER_LIST_COLUMNS); ?>
<br />
<form action="index2.php" method="post" name="adminForm">
<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
<tr>
<?php
for($i=0,$nb=count($rows);$i < $nb ;$i++) {
?>
	<td>
	<table>
		<tr>
			<td>
			<?php $name = $rows[$i]->name; if (isset($name)) { $name = HTML_adsmanager::getLangDefinition($name); } ?>
			<a href="index2.php?option=<?php echo $option;?>&act=columns&task=edit&tid[]=<?php echo $rows[$i]->id; ?>"><?php echo $name;?></a>
			</td>
			<td>
			<input type="checkbox" id="cb<?php echo $i;?>" name="tid[]" value="<?php echo $rows[$i]->id; ?>" onclick="isChecked(this.checked);" />
			</td>
		</tr>
		<tr>
		<td>
			<select multiple='multiple'>
			<?php	
			
			foreach($fColumn[$rows[$i]->id] as $field)
			{
				echo '<option value="'.$field->fieldid.'">'.$field->name.'</option>';
			}
			?>
			</select>
		</td>
		</tr>
	</table>
	</td>
<?php
}
?>
</tr>
</table>

<input type="hidden" name="option" value="<?php echo $option; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="act" value="columns" />
<input type="hidden" name="boxchecked" value="0" />
</form> 
	<?php
}

function editColumn( $row, $option, $cats,$nbcats)
{
?>
<?php HTML_adsmanager::header($option,ADSMANAGER_COLUMN_EDITION); ?>
<form action="index2.php" method="post" name="adminForm" id="adminForm" class="adminForm" enctype="multipart/form-data">
<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
<tr valign="top">
<td width="60%">
<table class="adminform">
<th colspan="3">Parameters</th>
<tr>
<td><?php echo ADSMANAGER_TH_TITLE; ?></td>
<td><input type="text" size="50" maxsize="100" name="name" value="<?php echo @$row->name; ?>" /></td>
<td>&nbsp;</td>
</tr>

<tr>
<td><?php echo ADSMANAGER_ORDER; ?></td>
<td><input type="text" size="50" maxsize="100" name="ordering" value="<?php echo @$row->ordering; ?>" /></td>
<td>&nbsp;</td>
</tr>
</table>
</td>
<?php  // Mod by TomekOmel ?>

<td width="40%">
  <table class="adminform">
		<th><?php echo ADSMANAGER_FORM_CATEGORY; ?></th>
		<tr><td>
				
			<select name="catsid[]" multiple='multiple' id="catsid[]" size="<?php echo $nbcats+2;?>">
			<?php
			
			if (strpos($row->catsid, ",-1,") === false)
				echo "<option value='-1'>".ADSMANAGER_MENU_ALL_ADS."</option>";
			else
				echo "<option value='-1' selected>".ADSMANAGER_MENU_ALL_ADS."</option>";
			HTML_adsmanager::selectCategories(0,"",$cats,-1,-1,1,$row->catsid);
			?>
			</select>
		</td></tr>
  </table>
</td>
</tr>

<?php  // End Mod by TomekOmel ?> 

</table>
<input type="hidden" name="id" value="<?php echo @$row->id; ?>" />
<input type="hidden" name="option" value="<?php echo $option; ?>" />
<input type="hidden" name="act" value="columns" />
<input type="hidden" name="task" value="" />
</form>
<?php 
}

function showPositions( $rows,$fDisplay, $option )
{
?>
<?php HTML_adsmanager::header($option,ADSMANAGER_POSITIONS); ?>
<br />
<link rel="stylesheet" href="../components/com_adsmanager/css/adsmanager.css" type="text/css" />
<?php echo ADSMANAGER_AD_DISPLAY_EXPLANATION."<br />"; ?>
<div class="adsmanager_ads" align="left">
	<div class="adsmanager_top_ads">	
		<h2 class="adsmanager_ads_title">	
		<?php echo "<b>".HTML_adsmanager::getLangDefinition($rows[0]->title)."</b>"; 
		if (isset($fDisplay[1]))
		{
			foreach($fDisplay[1] as $field)
			{
				echo HTML_adsmanager::getLangDefinition($field->title);
				echo "<br />";
			}
		} ?>
		</h2>
		<div>
		<?php echo ADSMANAGER_SHOW_OTHERS."<b>USER</b>";?>	
		</div>
		<div class="adsmanager_ads_kindof">
		<?php echo "<b>".HTML_adsmanager::getLangDefinition($rows[1]->title)."</b>"; 
		if (isset($fDisplay[2]))
		{
			foreach($fDisplay[2] as $field)
			{
				echo HTML_adsmanager::getLangDefinition($field->title);
				echo "<br />";		
			}
		}
		?>
		</div>
		</div>
	<div class="adsmanager_ads_main">
		<div class="adsmanager_ads_body">
			<div class="adsmanager_ads_desc">
			<?php echo "<b>".HTML_adsmanager::getLangDefinition($rows[2]->title)."</b>"; 
			if (isset($fDisplay[3]))
			{	
				foreach($fDisplay[3] as $field)
				{
					echo HTML_adsmanager::getLangDefinition($field->title);
					echo "<br />";
				}
			} ?>
			</div>
			<div class="adsmanager_ads_price">
			<?php echo "<b>".HTML_adsmanager::getLangDefinition($rows[3]->title)."</b>"; 
			if (isset($fDisplay[4]))
			{
				 foreach($fDisplay[4] as $field)
				{
					echo HTML_adsmanager::getLangDefinition($field->title);
					echo "<br />";
				} 
			}?>
			</div>
			<div class="adsmanager_ads_contact">
			<?php echo "<b>".HTML_adsmanager::getLangDefinition($rows[4]->title)."</b>"; 
			if (isset($fDisplay[5]))
			{		
				foreach($fDisplay[5] as $field)
				{	
					HTML_adsmanager::getLangDefinition($field->title);
					echo "<br />";
				} 
			}?>
			</div>
		</div>
		<div class="adsmanager_ads_image">
			<img align="center" src="../components/com_adsmanager/images/nopic.gif">				</div>
		<div class="adsmanager_spacer"></div>
	</div>
</div>
<?php
}

function editPosition( $row, $option)
{
?>
<?php HTML_adsmanager::header($option,ADSMANAGER_POSITION_EDITION); ?>
<form action="index2.php" method="post" name="adminForm" id="adminForm" class="adminForm" enctype="multipart/form-data">
<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">

<tr>
<td><?php echo $row->name; ?></td>
<td><input type="text" size="50" maxsize="100" name="name" value="<?php echo @$row->title; ?>" /></td>
<td>&nbsp;</td>
</tr>

</table>
<input type="hidden" name="id" value="<?php echo @$row->id; ?>" />
<input type="hidden" name="option" value="<?php echo $option; ?>" />
<input type="hidden" name="act" value="positions" />
<input type="hidden" name="task" value="" />
</form>
<?php 
}

}

?>