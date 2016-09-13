<?php
//
// Copyright (C) 2006 Thomas Papin
// http://www.gnu.org/copyleft/gpl.html GNU/GPL

// This file is part of the AdsManager Component,
// a Joomla! Classifieds Component by Thomas Papin
// Email: thomas.papin@free.fr
//
// no direct access
defined( '_VALID_MOS' ) or die( 'Restricted access' );

class adsmanager_html {

	function getLangDefinition($text) {
		if(defined($text)) $returnText = constant($text); 
		else $returnText = $text;
		return $returnText;
	}
	
	function cutLongWord($text) {
    
     $limit = 40;
     // On stocke tous les mots dans un tableau
     $tab = explode(' ', $text);
     foreach($tab as $k => $str) {
     // On coupe tous les mots > à $limit
     $tab[$k] = wordwrap($str, $limit, " ", true);
     }
     // On reconstitut la chaine de départ
     $string = implode(' ', $tab);
     return $string;
    } 



	function display_state($state){
		switch($state)
		{
			case 0:
				echo ADSMANAGER_STATE_0;break;
			case 1:
				echo ADSMANAGER_STATE_1;break;
			case 2:
				echo ADSMANAGER_STATE_2;break;
			case 3:
				echo ADSMANAGER_STATE_3;break;
			case 4:
				echo ADSMANAGER_STATE_4;break;
		}
	}
	
	function reorderDate( $date ){
		if (defined('ADSMANAGER_DATE_FORMAT_LC'))
			$format = ADSMANAGER_DATE_FORMAT_LC;
		else
			$format = _DATE_FORMAT_LC;

		if ( $date && ereg( "([0-9]{4})-([0-9]{2})-([0-9]{2})", $date, $regs ) ) {
			$date = mktime( 0, 0, 0, $regs[2], $regs[3], $regs[1] );
			$date = $date > -1 ? strftime( $format, $date) : '-';
		}
		return $date;
	}
	
	function selectCategories($id, $level, $children,&$catid,$root_allowed,$option,$itemid,$linkoption) {
		if (@$children[$id]) {
			foreach ($children[$id] as $row) {
				if (($root_allowed == 1)||(!@$children[$row->id])) {
					?>
					<option value="<?php echo sefRelToAbs("index.php?option=$option$linkoption&amp;catid=".$row->id."&amp;Itemid=$itemid"); ?>" <?php if ($row->id == $catid) { echo "selected='selected'"; } ?>><?php echo $level.$row->name; ?></option>
					<?php 
				}
				adsmanager_html::selectCategories($row->id, $level.$row->name." >> ", $children,$catid,$root_allowed,$option,$itemid,$linkoption);
			}
		}
	}
	
	function showFieldValue($row,$field,$field_values,$email_display,$option,$itemid,$mode)
	{
		global $mosConfig_live_site;
		
		if ((strpos($field->catsid, ",$row->category,") !== false)||(strpos($field->catsid, ",-1,") !== false))
		{
			if (($field->type != 'checkbox')&&(($field->display_title & $mode) == $mode))
			{
				echo adsmanager_html::getLangDefinition($field->title).": ";
			}
			
			if ($field->title)
			$name = $field->name;
			$value = "\$row->".$field->name;
			eval("\$value = \"$value\";");
			$value = adsmanager_html::getLangDefinition($value);
			switch($field->type)
			{
				case 'checkbox':
					if (($field->display_title & $mode) == $mode)
					{
						echo adsmanager_html::getLangDefinition($field->title);
						if ($value == 1)
							echo ":&nbsp;".ADSMANAGER_YES."<br />";
						else
							echo ":&nbsp;".ADSMANAGER_NO."<br />";
					}
					else if ($value == 1)
					{
						echo adsmanager_html::getLangDefinition($field->title)."<br />";
					}		
					break;
					
				case 'multicheckbox':
					
					for($i=0,$nb=count($field_values[$field->fieldid]);$i < $nb ;$i++)
					{
						$fieldvalue = @$field_values[$field->fieldid][$i]->fieldvalue;
						$fieldtitle = @$field_values[$field->fieldid][$i]->fieldtitle;

						if (strpos($value, $fieldvalue) !== false)
						{

							echo adsmanager_html::getLangDefinition($fieldtitle)."<br />";
						}
					}
					
					break;
	
				case 'select':
					if (isset($field_values[$field->fieldid])) {
					foreach($field_values[$field->fieldid] as $v)
					{
						if ($value == $v->fieldvalue)
						{
							echo adsmanager_html::getLangDefinition($v->fieldtitle)."<br />";
						}
					}
					}
					break;
	
				case 'multiselect':
					if (isset($field_values[$field->fieldid])) {
					foreach($field_values[$field->fieldid] as $v)
					{
						if (strpos($value, ",".$v->fieldvalue.",") === false)
						{
						}
						else
						{
							echo adsmanager_html::getLangDefinition($v->fieldtitle)."<br />";
						}
					}
					}
					break;
				
				case 'emailaddress':
					if ($value != "")
					{
						switch($email_display) {
							case 2:
								$emailForm = sefRelToAbs("index.php?option=$option&amp;page=show_message_form&amp;mode=0&amp;adid=".$row->id."&amp;Itemid=".$itemid);
								echo '<a href="'.$emailForm.'">'.ADSMANAGER_EMAIL_FORM.'</a><br />';
								break;
							case 1:
								echo adsmanager_html::Txt2Png($value,$option);
								break;
							default:
								echo ADSMANAGER_FORM_EMAIL.": <a href='mailto:".$value."'>".adsmanager_html::cutLongWord($value)."</a>";
								break;
						
						}
					}
					break;
				
				case 'url':
					if ($value != "")
					{
						echo "<a href='http://$value' target='_blank'>$value</a>";
					}
					echo "<br />";
					break;
				case 'textarea':
					echo adsmanager_html::cutLongWord(str_replace(array("\r\n", "\n", "\r"), "<br />", $value))."<br />";
					break;
				case 'number':
				case 'text':
					echo adsmanager_html::cutLongWord($value)."<br />";
					break;
				case 'price':
					if ($value != "")
						echo sprintf(ADSMANAGER_DEVICE,$value);
					echo "<br />";
					break;
				case 'radio':	
					for($i=0,$nb=count($field_values[$field->fieldid]);$i < $nb ;$i++)
					{
						$fieldvalue = @$field_values[$field->fieldid][$i]->fieldvalue;
						$fieldtitle = @$field_values[$field->fieldid][$i]->fieldtitle;
						if ($value == $fieldvalue)
							echo $fieldtitle."<br />";
					}
					break;
				case 'file':
					if ($value != "")
					{
						echo "<a href='$mosConfig_live_site/images/com_adsmanager/files/$value' target='_blank'>".ADSMANAGER_DOWNLOAD_FILE."</a></b>";
						echo "<br />";
					}
					break;
			}
		}
	}
	
	function show_search($option,$fields_searchable,$field_values,$catid,$cats,$itemid)
	{
		?>
		<script language="JavaScript" type="text/JavaScript">
		<!--
		function jumpmenu(target,obj,restore){
		  eval(target+".location='"+obj.options[obj.selectedIndex].value+"'");	
		  obj.options[obj.selectedIndex].innerHTML="<?php echo ADSMANAGER_WAIT;?>";	
		}		
		//-->
		</script>
		<div class="adsmanager_search_box">
		<div class="adsmanager_inner_box">
			<form action="index.php" method="get">
			<input type="hidden" name="option" value="<?php echo $option; ?>" />
			<input type="hidden" name="page" value="show_result" />
			<div align="left"><table>
			<tr><td><?php echo ADSMANAGER_FORM_CATEGORY; ?></td>
			<td><select name='category_choose' onchange="jumpmenu('parent',this)">			
			 <option value="<?php echo sefRelToAbs("index.php?option=$option&amp;page=show_search&amp;catid=0&amp;Itemid=$itemid"); ?>" <?php if ($catid == 0) echo 'selected="selected"'; ?>><?php echo ADSMANAGER_MENU_ALL_ADS; ?></option>
			<?php
			 $linkoption = "&amp;page=show_search";
			 adsmanager_html::selectCategories(0,"",$cats,$catid,1,$option,$itemid,$linkoption); 
			?>
			</select></td></tr>
			<?php 
			foreach($fields_searchable as $fsearch) {
				if (($catid == 0)||(strpos($fsearch->catsid, ",$catid,") !== false)||(strpos($fsearch->catsid, ",-1,") !== false))
				{
					echo "<tr><td>".adsmanager_html::getLangDefinition($fsearch->title)."</td><td>";
					switch($fsearch->type)
					{
						case 'checkbox':
							echo "<input class='inputbox' type='checkbox' name='$fsearch->title' value='1' />\n";
							break;
						case 'multicheckbox':
							echo "<table class='cbMulti'>\n";
							$k = 0;
							for ($i=0 ; $i < $fsearch->rows;$i++)
							{
								echo "<tr>\n";
								for ($j=0 ; $j < $fsearch->cols;$j++)
								{
									$fieldvalue = @$field_values[$fsearch->fieldid][$k]->fieldvalue;
									$fieldtitle = @$field_values[$fsearch->fieldid][$k]->fieldtitle;
									if (isset($fieldtitle))
										$fieldtitle=adsmanager_html::getLangDefinition($fieldtitle);
									echo "<td>\n";
									if (isset($field_values[$fsearch->fieldid][$k]->fieldtitle))
									{		
										echo "<input class='inputbox' type='checkbox' name='".$fsearch->name."[]' value='$fieldvalue' />&nbsp;$fieldtitle&nbsp;\n";
									}
									echo "</td>\n";
									$k++;
								}
								echo "</tr>\n";
							}
							echo "</table>\n";
							break;
	
						case 'radio':
						case 'select':
							echo "<select id='".$fsearch->name."' name='".$fsearch->name."'>\n";
							echo "<option value='' >&nbsp;</option>\n";	
							if (isset($field_values[$fsearch->fieldid])) {
							foreach($field_values[$fsearch->fieldid] as $v)
							{
								$ftitle = adsmanager_html::getLangDefinition($v->fieldtitle);
								echo "<option value='$v->fieldvalue' >$ftitle</option>\n";
							}
							}
							
							echo "</select>\n";
							break;
						
						case 'multiselect':
						
							echo "<select name=\"".$fsearch->name."[]\" multiple='multiple' size='$fsearch->size'>\n";	
							if (isset($field_values[$fsearch->fieldid])) {
							foreach($field_values[$fsearch->fieldid] as $v)
							{
								$ftitle = adsmanager_html::getLangDefinition($v->fieldtitle);
								if ($field->required == 1)
									$mosReq = "mosReq='1'";
									
								echo "<option value='$v->fieldvalue' >$ftitle</option>\n";
							}
							}
							
							echo "</select>\n";
							break;
							
						case 'textarea':
						case 'number':
						case 'price':
						case 'emailaddress':
						case 'url':
						case 'text':
							echo "<input name='".$fsearch->name."' id='".$fsearch->name."' maxlength='20' class='inputbox' type='text' size='20' />";
							break;
					}
					echo "</td>";
				}
			}?>
			</table></div>
			<input type="submit" value="<?php echo ADSMANAGER_SUBMIT_BUTTON; ?>" />
			<input type="hidden" name="order" value="<?php echo $order; ?>" />
			<input type="hidden" name="expand" value="<?php echo $expand; ?>" />
			<input type="hidden" name="catid" value="<?php echo $catid;?>" />
			<input type="hidden" name="Itemid" value="<?php echo $itemid;?>" />
			</form> 		  
		</div>
		</div>
		<?php
	}
		
	function show_list($catid,$cat_description,$name,$url,$page,$rows,$pagenav,$navlink,
					   $show_contact,$expand ,$order,$text_search,
					   $itemid,$option,$userid,$update_possible,
					   $searchs,
					   $columns,$fColumn,$positions,$fDisplay,$field_values,
					   $conf,
					   $fields_searchable)
	{
		global $mosConfig_live_site,$mosConfig_absolute_path,$mosConfig_live_site,$my;
		
		if ($text_search=="")
			$text_search= ADSMANAGER_SEARCH_TEXT;
			
		/* Display Title */
		?>
		<br />
		<h1 class="contentheading">
		<?php
			if (($catid == 0)||(!file_exists($mosConfig_absolute_path.'/images/'.$option.'/categories/'.$catid.'cat_t.jpg')))
				echo '<img  class="imgheading" src="'.$mosConfig_live_site.'/components/'.$option.'/images/default.gif" alt="default" />';
			else
				echo '<img  class="imgheading" src="'.$mosConfig_live_site.'/images/'.$option.'/categories/'.$catid.'cat_t.jpg" alt="'.$name.'" />';
			echo $name;
			if ($conf->show_rss == 1)
			{
				$linkrss = sefRelToAbs("index.php?option=$option&amp;page=rss&amp;catid=$catid&amp;Itemid=".$itemid);
				echo '<a href="'.$linkrss.'" target="_blank"><img align="right" class="imgheading" src="'.$mosConfig_live_site.'/components/'.$option.'/images/rss.png" alt="rss" /></a>';
			}
		?>
		</h1>
		<div class="adsmanager_description">
		<?php echo $cat_description; ?>
		</div>
		<?php if ($conf->display_expand == 1) { ?>
		<div class="adsmanager_subtitle">
		<?php 
		/* Display SubTitle */
			$target = sefRelToAbs($url."&amp;limit=".$pagenav->limit."&amp;limitstart=".$pagenav->limitstart."&amp;expand=0&amp;Itemid=".$itemid);
		    echo '<a href="'. $target.'">'.ADSMANAGER_MODE_TEXT.ADSMANAGER_SHORT_TEXT.'</a>';
		    echo " / ";
		    $target = sefRelToAbs($url."&amp;limit=".$pagenav->limit."&amp;limitstart=".$pagenav->limitstart."&amp;expand=1&amp;Itemid=".$itemid);
		    echo '<a href="'.$target.'">'.ADSMANAGER_EXPAND_TEXT.'</a>';
		?>
		</div>
		<?php } ?>
		<script language="JavaScript" type="text/JavaScript">
		<!--
		function jumpmenu(target,obj){
		  eval(target+".location='"+obj.options[obj.selectedIndex].value+"'");	
		  obj.options[obj.selectedIndex].innerHTML="<?php echo ADSMANAGER_WAIT;?>";			
		}		
		//-->
		</script>
		<div class="adsmanager_search_box">
		<div class="adsmanager_inner_box">
			<?php echo '<div align="left">'.$pagenav->writePagesCounter().'</div>'; ?>
			<form action="index.php" method="get">
			<input type="hidden" name="option" value="<?php echo $option; ?>" />
			<input type="hidden" name="page" value="<?php echo $page;?>" />
			<?php
			switch($page)
			{
				case "show_user":
					echo '<input type="hidden" name="userid" value="'.$userid.'" />';
					break;
				case "show_category":
					echo '<input type="hidden" name="catid" value="'.$catid.'" />';
					break;
			}
			?>
			<div align="left"><input name="text_search" id="text_search" maxlength="20" alt="search" class="inputbox" type="text" size="20" value="<?php echo $text_search;?>"  onblur="if(this.value=='') this.value='';" onfocus="if(this.value=='<?php echo $text_search;?>') this.value='';" /></div>
			<div align="left"><a href="<?php echo sefRelToAbs("index.php?option=$option&amp;page=show_search&amp;catid=$catid&amp;Itemid=$itemid");?>"><?php echo ADSMANAGER_ADVANCED_SEARCH; ?></a></div>
			<input type="hidden" name="order" value="<?php echo $order; ?>" />
			<input type="hidden" name="expand" value="<?php echo $expand; ?>" />
			<input type="hidden" name="Itemid" value="<?php echo $itemid;?>" />
			</form> 
			<?php echo ADSMANAGER_ORDER_BY_TEXT; ?>
			<?php if (isset($searchs)) { ?>
			<select name="order" size="1" onchange="jumpmenu('parent',this)">
					<option value="<?php echo sefRelToAbs($url."&amp;expand=".$expand."&amp;order=0&amp;Itemid=".$itemid);?>" <?php if ($order == "0") { echo "selected='selected'"; } ?>><?php echo ADSMANAGER_DATE; ?></option>
					<?php /*<option value="<?php echo sefRelToAbs($url."&amp;order=-1");?>" <?php if ($order == "-1") { echo "selected='selected'"; } ?>><?php echo ADSMANAGER_ORDER_HITS; ?></option> */ ?>
				<?php foreach($searchs as $s)
				   {
	               ?>
					<option value="<?php echo sefRelToAbs($url."&amp;expand=".$expand."&amp;order=".$s->fieldid."&amp;Itemid=".$itemid);?>" <?php if ($order == $s->fieldid) { echo "selected='selected'"; } ?>><?php echo adsmanager_html::getLangDefinition($s->title); ?></option>
					<?php
				   }
				 ?>
			</select>	
			<?php } ?>			  
		</div>
		</div>
		
		<?php adsmanager_html::showGeneralLink($option,$itemid,$catid,$conf->comprofiler); ?>
		<br />
		<?php
		if ($pagenav->total != 0 ) 
		{
			if ($expand == 0)
			{
			?>
				<table class="adsmanager_table">
				<tr>
				  <th><?php echo ADSMANAGER_AD;?></th>
				  <?php if (isset($columns)) {
				  foreach($columns as $col)
				  {
					echo "<th>".adsmanager_html::getLangDefinition($col->name)."</th>";
				  }
				  }
				  ?>
				  <th><?php echo ADSMANAGER_DATE;?></th>
				</tr>
			<?php
			}
			else
			{
				adsmanager_html::loadScriptImage($conf->image_display,$option);
			}
			
			if (isset($rows)) {
			foreach($rows as $row) {
				if ($expand == 1)
				{
					adsmanager_html::show_html_ad($row,$show_contact,$option,$itemid,$positions,$fDisplay,$field_values,$conf,0,$update_possible);
				}
				else
				{
				$linkTarget = sefRelToAbs( "index.php?option=$option&amp;page=show_ad&amp;adid=".$row->id."&amp;catid=".$row->category."&amp;Itemid=".$itemid);
				?>
				<tr>
					<td class="adsmanager_table_description">
						<?php
						$ok = 0;$i=1;
						while(!$ok)
						{
							if ($i < $conf->nb_images + 1)
							{
								$ext_name = chr(ord('a')+$i-1);
								$pic = $mosConfig_absolute_path."/images/$option/ads/".$row->id.$ext_name."_t.jpg";
								if (file_exists( $pic)) 
								{
									echo "<a href='".$linkTarget."'><img src='".$mosConfig_live_site."/images/$option/ads/".$row->id.$ext_name."_t.jpg' alt='".htmlspecialchars(stripslashes(adsmanager_html::cutLongWord($row->ad_headline)),ENT_QUOTES)."' /></a>";
									$ok = 1;
								}
							}
							else if ($conf->nb_images != 0)
							{
								if ((ADSMANAGER_NOPIC != "")&&(file_exists($mosConfig_absolute_path."/components/$option/images/".ADSMANAGER_NOPIC)))
									echo "<a href='".$linkTarget."'><img src='".$mosConfig_live_site."/components/$option/images/".ADSMANAGER_NOPIC."' alt='nopic' /></a>"; 
								else
									echo "<a href='".$linkTarget."'><img src='".$mosConfig_live_site."/components/$option/images/nopic.gif' alt='nopic' /></a>"; 
								$ok = 1;
							}   
							else
							{
								$ok = 1;
							}
							$i++;   	
						}
						?>
						<div>
						<h2>
							<?php echo '<a href="'.$linkTarget.'">'.stripslashes(adsmanager_html::cutLongWord($row->ad_headline)).'</a>'; ?>
							<span class="adsmanager_cat"><?php echo "(".$row->parent." / ".$row->cat.")"; ?></span>
						</h2>
						<?php 
							$row->ad_text = str_replace ('<br />'," ",stripslashes(adsmanager_html::cutLongWord($row->ad_text)));
							$af_text = substr($row->ad_text, 0, 100)."...";
							echo $af_text;
						?>
						</div>
						
						<?php 
						if (($my->id == $row->userid)&&($update_possible == 1))	{
						?>
						<div>
						<?php
							$target = sefRelToAbs("index.php?option=$option&amp;Itemid=$itemid&amp;page=write_ad&amp;adid=$row->id"."&amp;Itemid=".$itemid);
							echo "<a href='".$target."'>".ADSMANAGER_AD_EDIT."</a>";
							echo "&nbsp;";
							$target = sefRelToAbs("index.php?option=$option&amp;Itemid=$itemid&amp;page=delete_ad&amp;adid=$row->id"."&amp;Itemid=".$itemid);
							echo "<a href='".$target."'>".ADSMANAGER_AD_DELETE."</a>";
						?>
						</div>
						<?php
						}
						?>			
					</td>
					<?php if (isset($columns))
					   {
						  foreach($columns as $col) {
							echo '<td class="center">';
							if(isset($fColumn[$col->id]))
							{
								foreach($fColumn[$col->id] as $field)
								{
									adsmanager_html::showFieldValue($row,$field,$field_values,$conf->email_display,$option,$itemid,2); /* 2 = List */
								}
							}
							echo "</td>";
						 }
					   }
					?>
					<td class="center">
						<?php echo adsmanager_html::reorderDate($row->date_created); ?>
						<br />
						<?php
						if ($row->userid != 0)
						{
						   echo ADSMANAGER_FROM; 

						   if ($conf->comprofiler == 2)
						   {
							$target = sefRelToAbs("index.php?option=com_comprofiler&amp;task=userProfile&amp;tab=AdsManagerTab&amp;user=".$row->userid."&amp;Itemid=".$itemid);
						   }
						   else
						   {
							$target = sefRelToAbs("index.php?option=$option&amp;page=show_user&amp;userid=".$row->userid."&amp;Itemid=".$itemid);
						   }
						   
						   echo "<a href='".$target."'>".$row->user."</a><br/>";
						}
						?>
						<?php echo sprintf(ADSMANAGER_VIEWS,$row->views); ?>
					</td>
				</tr>
			<?php	
				}
			}
			}
			
			if ($expand == 1) {
				?>
				<div class="back_button">
				<a href='javascript:history.go(-1)'>
				<?php echo ADSMANAGER_BACK_TEXT; ?>
				</a>
				</div>
				<br />
				<br />
				<?php
			}
			else {
				?>
				</table>
				<?php
			}
			echo '<p align="center">'.$pagenav->writePagesLinks($navlink).'</p>'; 
		}
		else
		{
			echo ADSMANAGER_NOENTRIES; 
		}
	}
	
	function show_rules($text)
	{
		echo '<h1 class="contentheading">'.ADSMANAGER_RULES.'</h1>';
		echo stripslashes($text);	
	}
	
	function show_pathway($paths,$option)
	{
		global $cur_template,$mosConfig_absolute_path,$mosConfig_live_site;
		?>
		<div class="adsmanager_pathway">
		<?php 
			$pathway ="";
			$nb = count($paths);
			for ($i = $nb - 1 ; $i >0;$i--)
			{
				$pathway .= '<a href="'.$paths[$i]->link.'">'.$paths[$i]->text.'</a>';
				$filenamearrow = $mosConfig_absolute_path."/templates/$cur_template/images/arrow.png";
				if (file_exists($filenamearrow))
					$pathway .= ' <img src="'.$mosConfig_live_site.'/templates/'.$cur_template.'/images/arrow.png" alt="arrow" /> ';
				else
					$pathway .= ' <img src="'.$mosConfig_live_site.'/components/'.$option.'/images/arrow.png" alt="arrow" /> ';
			}
			$pathway .= '<a href="'.$paths[0]->link.'">'.$paths[0]->text.'</a>';
		
		echo $pathway;
		?>
		</div>
		<?php
	}
	
	function show_subcats($subcats)
	{
	?>
		<div class="adsmanager_subcats">
	<?php
	    $nb = count($subcats);
		if ($nb != 0)
		{
			for ($i = 0 ; $i < $nb - 1;$i++) {
				echo '<a href="'.$subcats[$i]->link.'">'.$subcats[$i]->text.'</a>';
				echo ' | ';
			}
			echo '<a href="'.$subcats[$nb - 1]->link.'">'.$subcats[$nb - 1]->text.'</a>';
		}
	?>
		</div>
	<?php
	}
	
	function Txt2Png( $text,$option ) 
	{
		global $mosConfig_absolute_path,$mosConfig_live_site;
	
		$png2display = md5($text);
		$filenameforpng = $mosConfig_absolute_path."/images/".$option."/email/". $png2display . ".png";
		$filename = $mosConfig_live_site."/images/".$option."/email/". $png2display . ".png";
		if (!file_exists($filenameforpng)) # we dont need to create file twice (md5)
		{	
			# definitions
			$font = $mosConfig_absolute_path . "/components/$option/font/verdana.ttf";
			# create image / png
			$fontsize = 9;
			$textwerte = imagettfbbox($fontsize, 0, $font, $text);
			$textwerte[2] += 8;
			$textwerte[5] = abs($textwerte[5]);
			$textwerte[5] += 4;
			$image=imagecreate($textwerte[2], $textwerte[5]);
			$farbe_body=imagecolorallocate($image,255,255,255); 
			$farbe_b = imagecolorallocate($image,0,0,0); 
			$textwerte[5] -= 2;
			imagettftext ($image, 9, 0, 3,$textwerte[5],$farbe_b, $font, $text);
			#display image
			imagepng($image, "$filenameforpng"); 
		}
	
		$text = "<img src='$filename' border='0' alt='email' />";
		return $text;
	}
	
	function loadScriptImage($image_display,$option)
	{
		global $mosConfig_live_site,$mainframe;
		
		switch($image_display)
		{
			case 'popup':
				$mainframe->addCustomHeadTag('
				<script language="JavaScript" type="text/javascript">
				<!--
				function popup(img) {
				titre="Popup Image";
				titre="Agrandissement"; 
				w=open("","image","width=400,height=400,toolbar=no,scrollbars=no,resizable=no"); 
				w.document.write("<html><head><title>"+titre+"</title></head>"); 
				w.document.write("<script language=\"javascript\">function checksize() { if	(document.images[0].complete) {	window.resizeTo(document.images[0].width+10,document.images[0].height+50); window.focus();} else { setTimeout(\'checksize()\',250) }}</"+"script>"); 
				w.document.write("<body onload=\"checksize()\" leftMargin=0 topMargin=0 marginwidth=0 marginheight=0>");
				w.document.write("<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" height=\"100%\"><tr>");
				w.document.write("<td valign=\"middle\" align=\"center\"><img src=\""+img+"\" border=0 alt=\"Mon image\">"); 
				w.document.write("</td></tr></table>");
				w.document.write("</body></html>"); 
				w.document.close(); 
				} 
				
				-->
				</script>');
				break;
			case 'lightbox':
				$mainframe->addCustomHeadTag('<script type="text/javascript" src="'.$mosConfig_live_site.'/components/'.$option.'/lightbox/js/prototype.js"></script>');
				$mainframe->addCustomHeadTag('<script type="text/javascript" src="'.$mosConfig_live_site.'/components/'.$option.'/lightbox/js/scriptaculous.js?load=effects"></script>');
				$mainframe->addCustomHeadTag('<script type="text/javascript" src="'.$mosConfig_live_site.'/components/'.$option.'/lightbox/js/lightbox.js"></script>');
				$mainframe->addCustomHeadTag('<link rel="stylesheet" href="'.$mosConfig_live_site.'/components/'.$option.'/lightbox/css/lightbox.css" type="text/css" media="screen" />');
				break;
			default:
				break;
		}
	}
	
	function show_html_ad($row,$show_contact,$option,$itemid,$positions,$fDisplay,$field_values,$conf,$unique,$update_possible)
	{	
		global $mosConfig_live_site,$mosConfig_absolute_path,$my;
		
		if ($unique == 1) {
			adsmanager_html::loadScriptImage($conf->image_display,$option);
		}
		?>
		<div class="adsmanager_ads" align="left">
			<div class="adsmanager_top_ads">	
				<h2 class="adsmanager_ads_title">	
				<?php if (@$positions[0]->title) {$strtitle = adsmanager_html::getLangDefinition($positions[0]->title);} ?>
				<?php echo "<b>".@$strtitle."</b>"; 
				if (isset($fDisplay[1]))
				{
					foreach($fDisplay[1] as $field)
					{
						adsmanager_html::showFieldValue($row,$field,$field_values,$conf->email_display,$option,$itemid,1); /* 1 = Ad Mode */
					}
				} ?>
				</h2>
				<div>
				<?php 
				if ($row->userid != 0)
				{
					echo ADSMANAGER_SHOW_OTHERS; 
					if ($conf->comprofiler == 2)
				    {
						$target = sefRelToAbs("index.php?option=com_comprofiler&amp;task=userProfile&amp;tab=AdsManagerTab&amp;user=".$row->userid."&amp;Itemid=".$itemid);
					}
				    else
				    {
						$target = sefRelToAbs("index.php?option=$option&amp;page=show_user&amp;userid=".$row->userid."&amp;Itemid=".$itemid);
				    }
					echo "<a href='$target'><b>".$row->user."</b></a>";
					
					if (($my->id == $row->userid)&&($update_possible == 1))	{
					?>
					<div>
					<?php
						$target = sefRelToAbs("index.php?option=$option&amp;Itemid=$itemid&amp;page=write_ad&amp;adid=$row->id"."&amp;Itemid=".$itemid);
						echo "<a href='".$target."'>".ADSMANAGER_AD_EDIT."</a>";
						echo "&nbsp;";
						$target = sefRelToAbs("index.php?option=$option&amp;Itemid=$itemid&amp;page=delete_ad&amp;adid=$row->id"."&amp;Itemid=".$itemid);
						echo "<a href='".$target."'>".ADSMANAGER_AD_DELETE."</a>";
					?>
					</div>
					<?php
					}
				}
				?>
				</div>
				<div class="adsmanager_ads_kindof">
				<?php if (@$positions[1]->title) {$strtitle = adsmanager_html::getLangDefinition($positions[1]->title);} ?>
				<?php echo "<b>".@$strtitle."</b>"; 
				if (isset($fDisplay[2]))
				{
					foreach($fDisplay[2] as $field)
					{
						adsmanager_html::showFieldValue($row,$field,$field_values,$conf->email_display,$option,$itemid,1); /* 1 = Ad Mode */
					}
				}
				?>
				</div>
			</div>
			<div class="adsmanager_ads_main">
				<div class="adsmanager_ads_body">
					<div class="adsmanager_ads_desc">
					<?php if (@$positions[2]->title) {$strtitle = adsmanager_html::getLangDefinition($positions[2]->title);} ?>
					<?php echo "<b>".@$strtitle."</b>"; 
					if (isset($fDisplay[3]))
					{	
						foreach($fDisplay[3] as $field)
						{
							adsmanager_html::showFieldValue($row,$field,$field_values,$conf->email_display,$option,$itemid,1); /* 1 = Ad Mode */	
						}
					} ?>
					</div>
					<div class="adsmanager_ads_desc">
					<?php if (@$positions[5]->title) {$strtitle = adsmanager_html::getLangDefinition($positions[5]->title);} ?>
					<?php echo "<b>".@$strtitle."</b>"; 
					if (isset($fDisplay[6]))
					{	
						foreach($fDisplay[6] as $field)
						{
							adsmanager_html::showFieldValue($row,$field,$field_values,$conf->email_display,$option,$itemid,1); /* 1 = Ad Mode */	
						}
					} ?>
					</div>
					<div class="adsmanager_ads_price">
					<?php if (@$positions[3]->title) {$strtitle = adsmanager_html::getLangDefinition($positions[3]->title); } ?>
					<?php echo "<b>".@$strtitle."</b>"; 
					if (isset($fDisplay[4]))
					{
						 foreach($fDisplay[4] as $field)
						{
							adsmanager_html::showFieldValue($row,$field,$field_values,$conf->email_display,$option,$itemid,1); /* 1 = Ad Mode */
						} 
					}?>
					</div>
					<div class="adsmanager_ads_contact">
					<?php if (@$positions[4]->title) {$strtitle = adsmanager_html::getLangDefinition($positions[4]->title);} ?>
					<?php echo "<b>".@$strtitle."</b>"; 
					if ($show_contact == 1) {		
						if (isset($fDisplay[5]))
						{		
							foreach($fDisplay[5] as $field)
							{	
								adsmanager_html::showFieldValue($row,$field,$field_values,$conf->email_display,$option,$itemid,1); /* 1 = Ad Mode */
							} 
						}
						if (($row->userid != 0)&&($conf->allow_contact_by_pms == 1))
						{
							$pmsText= sprintf(ADSMANAGER_PMS_FORM,$row->user);
							$pmsForm = sefRelToAbs("index.php?option=$option&amp;page=show_message_form&amp;mode=1&amp;adid=".$row->id."&amp;Itemid=".$itemid);
							echo '<a href="'.$pmsForm.'">'.$pmsText.'</a><br />';
						}
					}
					else
					{
						echo ADSMANAGER_CONTACT_NOT_LOGGED;
					}
					?>
					</div>
			    </div>
				<div class="adsmanager_ads_image">
					<?php
					$image_found =0;
					for($i=1;$i < $conf->nb_images + 1;$i++)
					{
						$ext_name = chr(ord('a')+$i-1);
						$pic = $mosConfig_absolute_path."/images/$option/ads/".$row->id.$ext_name."_t.jpg";
						$piclink 	= $mosConfig_live_site."/images/$option/ads/".$row->id.$ext_name.".jpg";
						if (file_exists($pic)) 
						{
						    switch($conf->image_display)
						    {
								case 'popup':
									echo "<a href=\"javascript:popup('$piclink');\"><img src='".$mosConfig_live_site."/images/$option/ads/".$row->id.$ext_name."_t.jpg' alt='".htmlspecialchars(stripslashes($row->ad_headline),ENT_QUOTES)."' /></a>";
									break;
								case 'lightbox':
									echo "<a href='".$piclink."' rel='lightbox[roadtrip$row->id]'><img src='".$mosConfig_live_site."/images/$option/ads/".$row->id.$ext_name."_t.jpg' alt='".htmlspecialchars(stripslashes($row->ad_headline),ENT_QUOTES)."' /></a>";
									break;
								case 'default':	
								default:
									echo "<a href='".$piclink."' target='_blank'><img src='".$mosConfig_live_site."/images/$option/ads/".$row->id.$ext_name."_t.jpg' alt='".htmlspecialchars(stripslashes($row->ad_headline),ENT_QUOTES)."' /></a>";
									break;
							}
							$image_found = 1;
						}   
					}
					if (($image_found == 0)&&($conf->nb_images >  0))
					{
						if ((ADSMANAGER_NOPIC != "")&&(file_exists($mosConfig_absolute_path."/components/$option/images/".ADSMANAGER_NOPIC)))
							echo '<img align="center" src="'.$mosConfig_live_site.'/components/'.$option.'/images/'.ADSMANAGER_NOPIC.'" alt="nopic" /></a>'; 
						else
							echo '<img align="center" src="'.$mosConfig_live_site.'/components/'.$option.'/images/nopic.gif" alt="nopic" />'; 
					}
					?>
				</div>
				<div class="adsmanager_spacer"></div>
			</div>
		</div>
		<?php if ($unique == 1) { ?>
			<div class="back_button">
			<a href='javascript:history.go(-1)'>
			<?php echo ADSMANAGER_BACK_TEXT; ?>
			</a>
			</div>
		<?php 
		} else {
			echo "<br />";
		}
		?>
	<?php
	}
	
	function show_message_form($option,$ad,$user,$mode,$allow_attachement,$itemid)
	{
		?>
		<script language="javascript" type="text/javascript">
		function submitbutton() {
			var form = document.forms["saveForm"];// document.getElementById("saveForm");
			var r = new RegExp("[^0-9\.,]", "i");

		<?php if ($mode == 0) { ?>
			// do field validation
			if (form.email.value == "") {
				alert( "<?php echo ADSMANAGER_REGWARN_EMAIL;?>" );
			} else {
		<?php } ?>
				form.submit();
		<?php if ($mode == 0) { ?>
			}
		<?php } ?>
		}
		</script>
		<fieldset id="adsmanager_fieldset">
			<!-- titel -->
			<legend>
			<?php  echo ADSMANAGER_FORM_MESSAGE_WRITE; ?>
			</legend>
			<!-- titel -->
		<!-- form -->
		<?php $target = sefRelToAbs("index.php?option=$option&amp;page=send_message&amp;mode=$mode&amp;Itemid=$itemid");?>
		<form action="<?php echo $target;?>" method="post" name="saveForm" enctype="multipart/form-data">
				<?php if ($mode == 0) { ?>
				<!-- name -->
					<label for="name"><?php echo ADSMANAGER_FORM_NAME; ?></label>
					<?php echo "<input class='adsmanager_required' id='name' type='text' name='name' maxlength='50' value='".$user->name."' />"; ?>
				<!-- name -->
				<br />
				<!-- email -->
					<label for="email"><?php echo ADSMANAGER_FORM_EMAIL; ?></label>
					<?php echo "<input class='adsmanager_required' id='email' type='text' name='email' maxlength='50' value='".$user->email."' />"; ?>
				<!-- email -->
				<br />
				<?php } ?>
				<!-- title -->
					<label for="title"><?php echo ADSMANAGER_FORM_MESSAGE_TITLE; ?></label>
					<?php echo "<input class='adsmanager_required' id='title' type='text' name='title' maxlength='50' value=\"".ADSMANAGER_EMAIL_TITLE.htmlspecialchars(stripslashes($ad->ad_headline),ENT_QUOTES)."\" />"; ?>
				<!-- title -->
	
				<br />
				<!-- body -->
					<label for="body"><?php echo ADSMANAGER_FORM_MESSAGE_BODY; ?></label>
					<?php  echo "<textarea class='adsmanager_required' id='body' name='body' cols='40' rows='10' wrap='VIRTUAL'>".ADSMANAGER_EMAIL_BODY.htmlspecialchars(stripslashes($ad->ad_text),ENT_QUOTES)."</textarea>"; ?>
				<!-- body -->
				<br />
				<?php if (($mode == 0)&&($allow_attachement == 1)) { ?>
				<!-- Attach -->
					<label for="body"><?php echo ADSMANAGER_ATTACH_FILE; ?></label>
					<input id="attach_file" type="file" name="attach_file" />
				<br />
				<?php } ?>
				<!-- buttons -->
					<label for="adid"></label>
					<input type="hidden" name="gflag" value="0">
					<?php
					echo "<input type='hidden' name='adid' value='".$ad->id."' />";
					?>
					<input type="button" value=<?php echo ADSMANAGER_SEND_EMAIL_BUTTON; ?> onclick="submitbutton()" />
				<!-- buttons -->
	
			  </form>
			  <!-- form -->
		</fieldset>
	
	<?php
	}
	
	function show_notallowed($option)
	{
		global $mosConfig_live_site;
	?>
		<?php echo '<img src="components/'.$option.'/images/warning.gif" alt="warning" border="0" align="center">'; ?>
		<b><?php echo ADSMANAGER_ADD_NOTALLOWED;?></b>
	<?php
	}
	
	function displayFields($row,$default,$fields,$field_values,$catid)
	{
		if (isset($fields))
		{
		foreach($fields as $field)
		{
			if ((strpos($field->catsid, ",$catid,") !== false)||(strpos($field->catsid, ",-1,") !== false))
			{
				$strtitle = adsmanager_html::getLangDefinition( $field->title);
				if (isset($strtitle)) {
					echo "<label>".$strtitle."</label>\n";
					$strtitle = htmlspecialchars($strtitle ,ENT_QUOTES);
				}
				$name = $field->name;
				$value = "@\$row->".$field->name;
				eval("\$value = \"\".$value;");
				$value = adsmanager_html::getLangDefinition($value);
				if (($value == "")&&($field->profile == 1))
				{
					$value ="\$default->".$field->name;
					eval("\$value = \"$value\";");
					$value = adsmanager_html::getLangDefinition($value);
				}
				$disabled="";
				$read_only="";
				
				switch($field->type)
				{
					case 'checkbox':
						if ($field->required == 1)
							$mosReq = "mosReq='1'";
						else
							$mosReq = "";
																
						if ($value == 1)
							echo "<input class='inputbox' type='checkbox' $mosReq mosLabel='$strtitle' checked='checked' name='$name' value='1' />\n";
						else
							echo "<input class='inputbox' type='checkbox' $mosReq mosLabel='$strtitle' name='$name' value='1' />\n";
						break;
					case 'multicheckbox':
						$k = 0;
						echo "<table>";
						for ($i=0 ; $i < $field->rows;$i++)
						{
							echo "<tr>";
							for ($j=0 ; $j < $field->cols;$j++)
							{
								echo "<td>";
								$fieldvalue = @$field_values[$field->fieldid][$k]->fieldvalue;
								$fieldtitle = @$field_values[$field->fieldid][$k]->fieldtitle;
								if (isset($fieldtitle))
									$fieldtitle=adsmanager_html::getLangDefinition($fieldtitle);
								if (isset($field_values[$field->fieldid][$k]->fieldtitle))
								{
									if (($field->required == 1)&&($k==0))
										$mosReq = "mosReq='1'";
									else
										$mosReq = "";
									
									if ((strpos($value, ",".$fieldvalue.",") === false) &&
										(strpos($value, $fieldtitle."|*|") === false) &&
										(strpos($value, "|*|".$fieldtitle) === false) &&
										($value !=  $fieldtitle))
										echo "<input class='inputbox' type='checkbox' $mosReq  mosLabel='$strtitle' name='".$name."[]' value='$fieldvalue' />&nbsp;$fieldtitle&nbsp;\n";
									else
										echo "<input class='inputbox' type='checkbox' $mosReq  mosLabel='$strtitle' checked='checked' name='".$name."[]' value='$fieldvalue' />&nbsp;$fieldtitle&nbsp;\n";
									
								}
								echo "</td>";
								$k++;
							}
							echo "</tr>";
						}
						echo "</table>";
						break;
	
					case 'select':
						if ($field->editable == 0)
							$disabled = "disabled=true";
						else
							$disabled = "";
							
						if ($field->required == 1)
							echo "<select id='$name' name='$name' mosReq='1' mosLabel='$strtitle' class='adsmanager_required' $disabled>\n";
						else
							echo "<select id='$name' name='$name' mosLabel='$strtitle' class='adsmanager' $disabled>\n";
							
						if ($value=="")
							echo "<option value=''>&nbsp;</option>\n";	
						if (isset($field_values[$field->fieldid])) {
						foreach($field_values[$field->fieldid] as $v)
						{
							$ftitle = adsmanager_html::getLangDefinition($v->fieldtitle);
							if (($value == $v->fieldvalue)||($value == $ftitle))
								echo "<option value='$v->fieldvalue' selected='selected' >$ftitle</option>\n";
							else
								echo "<option value='$v->fieldvalue' >$ftitle</option>\n";
						}
						}
						
						echo "</select>\n";
						break;
						
					case 'multiselect':
						if ($field->editable == 0)
							$disabled = "disabled=true";
						else
							$disabled = "";
						if ($field->required == 1)
							echo "<select id=\"".$name."[]\" name=\"".$name."[]\" mosReq='1' mosLabel='$strtitle' multiple='multiple' size='$field->size' class='adsmanager_required' $disabled>\n";
						else
							echo "<select id='".$name."[]' name=\"".$name."[]\" mosLabel='$strtitle' multiple='multiple' size='$field->size' class='adsmanager' $disabled>\n";
							
						if ($value=="")
							echo "<option value=''>&nbsp;</option>\n";	
						if (isset($field_values[$field->fieldid])) {
						foreach($field_values[$field->fieldid] as $v)
						{
							$ftitle = adsmanager_html::getLangDefinition($v->fieldtitle);
							if ($field->required == 1)
								$mosReq = "mosReq='1'";
								
							if ((strpos($value, ",".$v->fieldvalue.",") === false) &&
								(strpos($value, $ftitle."|*|") === false) &&
								(strpos($value, "|*|".$ftitle) === false) &&
								($value !=  $ftitle))
								echo "<option value='$v->fieldvalue' >$ftitle</option>\n";
							else
								echo "<option value='$v->fieldvalue' selected='selected' >$ftitle</option>\n";
						}
						}
						
						echo "</select>\n";
						break;
						
					case 'textarea':
						if ($field->editable == 0)
							$read_only = "readonly=true";
						else
							$read_only = "";

						if ($field->required == 1)
							echo "<textarea class='adsmanager_required' mosReq='1' mosLabel='$strtitle' id='$name' name='$name' cols='".$field->cols."' rows='".$field->rows."' wrap='VIRTUAL' onkeypress='CaracMax(this, $field->maxlength) ;' $read_only>$value</textarea>\n"; 
						else
							echo "<textarea class='adsmanager' id='$name' mosLabel='$strtitle' name='$name' cols='".$field->cols."' rows='".$field->rows."' wrap='VIRTUAL' onkeypress='CaracMax(this, $field->maxlength) ;' $read_only>$value</textarea>\n"; 	
						break;
						
					case 'number':
					case 'price':
						if ($field->editable == 0)
							$read_only = "readonly=true";
						else
							$read_only = "";
							
						if ($field->required == 1)
							echo "<input class='adsmanager_required' mosReq='1' id='$name' type='text' test='number' mosLabel='$strtitle' name='$name' size='$field->size' maxlength='$field->maxlength' $read_only value='$value' />\n"; 
						else
							echo "<input class='adsmanager' id='$name' type='text' name='$name' test='number' mosLabel='$strtitle' size='$field->size' maxlength='$field->maxlength' $read_only value='$value' />\n";
						break;
					case 'emailaddress':
						if ($field->editable == 0)
							$read_only = "readonly=true";
						else
							$read_only = "";
							
						if ($field->required == 1)
							echo "<input class='adsmanager_required' mosReq='1' id='$name' type='text' test='emailaddress' mosLabel='$strtitle' name='$name' size='$field->size' maxlength='$field->maxlength' $read_only value='$value' />\n"; 
						else
							echo "<input class='adsmanager' id='$name' type='text' test='emailaddress' name='$name' mosLabel='$strtitle' size='$field->size' maxlength='$field->maxlength' $read_only value='$value' />\n";
						break;
						
					case 'url':
						if ($field->editable == 0)
							$read_only = "readonly=true";
						else
							$read_only = "";
							
						echo "http://";
						if ($field->required == 1)
							echo "<input class='adsmanager_required' mosReq='1' id='$name' type='text' mosLabel='$strtitle' name='$name' size='$field->size' maxlength='$field->maxlength' $read_only value='".htmlspecialchars($value,ENT_QUOTES)."' />\n"; 
						else
							echo "<input class='adsmanager' id='$name' type='text' name='$name' mosLabel='$strtitle' size='$field->size' maxlength='$field->maxlength' $read_only value='".htmlspecialchars($value,ENT_QUOTES)."' />\n";
						break;
					case 'text':
						if ($field->editable == 0)
							$read_only = "readonly=true";
						else
							$read_only = "";
						
						if ($field->required == 1)
							echo "<input class='adsmanager_required' mosReq='1' id='$name' type='text' mosLabel='$strtitle' name='$name' size='$field->size' maxlength='$field->maxlength' $read_only value='".htmlspecialchars($value,ENT_QUOTES)."' />\n"; 
						else
							echo "<input class='adsmanager' id='$name' type='text' name='$name' mosLabel='$strtitle' size='$field->size' maxlength='$field->maxlength' $read_only value='".htmlspecialchars($value,ENT_QUOTES)."' />\n";
						break;
						
					case 'radio':
						$k = 0;
						echo "<table>";
						for ($i=0 ; $i < $field->rows;$i++)
						{
							echo "<tr>";
							for ($j=0 ; $j < $field->cols;$j++)
							{
								echo "<td>";
								$fieldvalue = @$field_values[$field->fieldid][$k]->fieldvalue;
								$fieldtitle = @$field_values[$field->fieldid][$k]->fieldtitle;
								if (isset($field_values[$field->fieldid][$k]->fieldtitle))
								{
									if (($field->required == 1)&&($k==0))
										$mosReq = "mosReq='1'";
									else
										$mosReq = "";
								
									if (($value == $fieldvalue)||($value == $fieldtitle))
										echo "<input type='radio' $mosReq name='$name' mosLabel='$strtitle' value='$fieldvalue' checked='checked' />&nbsp;$fieldtitle&nbsp;\n";
									else
										echo "<input type='radio' $mosReq name='$name' mosLabel='$strtitle' value='$fieldvalue' />&nbsp;$fieldtitle&nbsp;\n";
								}
								$k++;
								echo "</td>";
							}
							echo "</tr>";
						}
						echo "</table>";
						break;
					case 'file':
						echo "<input id='$name' type='file' name='$name' mosLabel='$strtitle'/>";
						if (isset($value)&&($value != ""))
						{
							echo "<br/><label></label><a href='$mosConfig_live_site/images/com_adsmanager/files/$value' target='_blank'>".ADSMANAGER_DOWNLOAD_FILE."</a>";
						}
						break;
				}
				if ((@$field->description)&&($field->description !="")) {
					$fieldTip = str_replace(array('"','<','>',"\\"), array("&quot;","&lt;","&gt;","\\\\"), adsmanager_html::getLangDefinition($field->description));
					$tipTitle = str_replace(array('"','<','>',"\\"), array("&quot;","&lt;","&gt;","\\\\"), adsmanager_html::getLangDefinition($field->title));
					$fieldTip = str_replace(array("'","&#039;"), "\\'", $fieldTip);
					$tipTitle = str_replace(array("'","&#039;"), "\\'", $tipTitle);
				?>
					<img src="includes/js/ThemeOffice/tooltip.png" alt="tooltip" style="border:0" onmouseover="return overlib('<?php echo $fieldTip ?>', CAPTION, '<?php echo $tipTitle ?>:');" onmouseout="return nd();"  />
				<?php
				}
				echo "<br />";		
			}
		}
		}
	}

	function show_write_form($isUpdateMode,$row,$default,$fields,$field_values,$catid,$cats,$itemid,$option,$conf,$errorMsg)
	{		
		global $mosConfig_absolute_path,$mosConfig_live_site,$database,$my;
		
		/* Submission_type == 2 -> Visitor can post new ad */
		if (($conf->submission_type == 2)&&($my->id == "0"))
		{
			echo ADSMANAGER_WARNING_NEW_AD_NO_ACCOUNT."<br />";
		}
		else
			$userid=$my->id;
			
	    switch($errorMsg)
		{
			case "bad_password":
				echo ADSMANAGER_BAD_PASSWORD."<br />";
				break;
			case "email_already_used":
				echo ADSMANAGER_EMAIL_ALREADY_USED."<br />";
				break;
			case "file_too_big":
				echo ADSMANAGER_FILE_TOO_BIG."<br />";
		}
			
		$ad_id = $row->id;	
		
		echo ADSMANAGER_RULESREAD;
		
		?>
		<script  type="text/javascript" src="<?php echo $mosConfig_live_site;?>/includes/js/overlib_mini.js"></script>
		<script language="JavaScript" type="text/JavaScript">
		<!--
		function jumpmenu(target,obj,restore){
		  eval(target+".location='"+obj.options[obj.selectedIndex].value+"'");	
		  obj.options[obj.selectedIndex].innerHTML="<?php echo ADSMANAGER_WAIT;?>";	
		}		
		//-->
		</script>
		<script language="JavaScript" type="text/javascript">
		//*** Paramètres
		//*** texte : objet représentant le textarea
		//*** max : nombre de caractères maximum
		function CaracMax(texte, max)
		{
			if (texte.value.length >= max)
			{
				texte.value = texte.value.substr(0, max - 1) ;
			}
		}
		</script>

		<script type="text/javascript"><!--//--><![CDATA[//><!--
		function submitbutton(mfrm) {
			var me = mfrm.elements;
			var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&|\+|\-]", "i");
			var r_num = new RegExp("[^0-9\.,]", "i");
			var r_email = new RegExp("^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]{2,}[.][a-zA-Z]{2,3}$" ,"i");

			var errorMSG = '';
			var iserror=0;
			
			if (mfrm.username && (r.exec(mfrm.username.value) || mfrm.username.value.length < 3)) {
				errorMSG += mfrm.username.getAttribute('mosLabel').replace('&nbsp;',' ') + ' : <?php echo addslashes(html_entity_decode(sprintf( ADSMANAGER_VALID_AZ09, ADSMANAGER_PROMPT_UNAME, 4 ),ENT_QUOTES)); ?>\n';
				mfrm.username.style.background = "red";
				iserror=1;
			} 
			if (mfrm.password && r.exec(mfrm.password.value)) {
				errorMSG += mfrm.password.getAttribute('mosLabel').replace('&nbsp;',' ') + ' : <?php echo addslashes(html_entity_decode(sprintf( ADSMANAGER_VALID_AZ09, ADSMANAGER_REGISTER_PASS, 6 ),ENT_QUOTES)); ?>\n';
				mfrm.password.style.background = "red";
				iserror=1;
			}
			
			if (mfrm.email && !r_email.exec(mfrm.email.value) && mfrm.email.getAttribute('mosReq')) {
				errorMSG += mfrm.email.getAttribute('mosLabel').replace('&nbsp;',' ') + ' : <?php echo html_entity_decode(addslashes(ADSMANAGER_REGWARN_MAIL),ENT_QUOTES); ?>\n';
				mfrm.email.style.background = "red";
				iserror=1;
			}
						
			// loop through all input elements in form
			for (var i=0; i < me.length; i++) {
			
				if ((me[i].getAttribute('test') == 'number' ) && (r_num.exec(me[i].value))) {
					errorMSG += me[i].getAttribute('mosLabel').replace('&nbsp;',' ') + ' : <?php echo html_entity_decode(addslashes(ADSMANAGER_REGWARN_NUMBER),ENT_QUOTES); ?>\n';
					iserror=1;
				}
				
				// check if element is mandatory; here mosReq="1"
				if (me[i].getAttribute('mosReq') == 1) {
					if (me[i].type == 'radio' || me[i].type == 'checkbox') {
						var rOptions = me[me[i].getAttribute('name')];
						var rChecked = 0;
						if(rOptions.length > 1) {
							for (var r=0; r < rOptions.length; r++) {
								if (rOptions[r].checked) {
									rChecked=1;
								}
							}
						} else {
							if (me[i].checked) {
								rChecked=1;
							}
						}
						if(rChecked==0) {
							// add up all error messages
							errorMSG += me[i].getAttribute('mosLabel').replace('&nbsp;',' ') + ' : <?php echo html_entity_decode(addslashes(ADSMANAGER_REGWARN_ERROR),ENT_QUOTES); ?>\n';
							// notify user by changing background color, in this case to red
							me[i].style.background = "red";
							iserror=1;
						} 
					}
					if (me[i].value == '') {
						// add up all error messages
						errorMSG += me[i].getAttribute('mosLabel').replace('&nbsp;',' ') + ' : <?php echo html_entity_decode(addslashes(ADSMANAGER_REGWARN_ERROR),ENT_QUOTES); ?>\n';
						// notify user by changing background color, in this case to red
						me[i].style.background = "red";
						iserror=1;
					} 
				}
			}
			
			if(iserror==1) {
				alert(errorMSG);
				return false;
			} else {
				return true;
			}
		}
		//--><!]]></script>
		<div id="adsmanager_writead_header">
			<div id="writead_header1"><?php echo ADSMANAGER_HEADER1; ?></div>
			<div id="writead_header2"><?php echo ADSMANAGER_HEADER2; ?></div>
		</div>
		<fieldset id="adsmanager_fieldset">
			<!-- titel -->
			<legend>
			<?php
			 if( $isUpdateMode) {
			   echo ADSMANAGER_AD_EDIT;
			 }
			 else {
			   echo ADSMANAGER_AD_WRITE;
			 }
			 ?>
			</legend>
			<!-- titel -->
		  <!-- form -->
		  <label for="ad_kindof"><?php echo ADSMANAGER_FORM_CATEGORY; ?></label>
			<select class='adsmanager_required' name='category_choose' onchange="jumpmenu('parent',this)">
			<?php
				
			 if ((@$ad_id)&&($ad_id != ""))
				$linkoption = "&amp;page=write_ad&amp;adid=$ad_id";
			 else
				$linkoption = "&amp;page=write_ad";
		     if ($catid == 0)
				echo "<option value='#' selected=selected>".ADSMANAGER_SELECT_CATEGORY."</option>";		
			 adsmanager_html::selectCategories(0,"",$cats,$catid,$conf->root_allowed,$option,$itemid,$linkoption); 
			?>
			</select>
		  <?php $target = sefRelToAbs("index.php?option=$option&amp;page=save_ad&amp;Itemid=$itemid");?>
		  <form action="<?php echo $target;?>" method="post" name="saveForm" enctype="multipart/form-data" onsubmit="return submitbutton(this)">
			<!-- category -->
			
			<input type='hidden' name='category' value='<?php echo $catid; ?>' />
			<!-- category -->	
			<br />
			
			<!-- fields -->
			<?php
			if ((!isset($catid))||($catid != 0))
			{
				/* Submission_type == 0 -> Account Creation with ad posting */
				if (($conf->submission_type == 0)&&($my->id == 0))
				{
					echo ADSMANAGER_AUTOMATIC_ACCOUNT."<br />";
					echo "<label>".ADSMANAGER_UNAME."</label>\n";
					if (isset($row->username))
					{
						$username = $row->username;
						$password = $row->password;
						$email = $row->email;
						$name = $row->name;
						$style = 'style="background-color:#ff0000"';
					}
					else
					{
						$username = "";
						$password = "";
						$email = "";
						$name =  "";
						$style = "";
					}
					
										
					if (isset($row->firstname))
						$firstname = $row->firstname;
					else
						$firstname = "";
					
					if (isset($row->middlename))
						$middlename = $row->middlename;
					else
						$middlename = "";
					
					if ($conf->comprofiler > 0)
					{
						include_once( $mosConfig_absolute_path .'/administrator/components/com_comprofiler/ue_config.php' );
						$namestyle = $ueConfig['name_style'];
					}
					else
						$namestyle = 1;
						
					echo "<input $style class='adsmanager_required' mosReq='1' id='username' type='text' mosLabel='".htmlspecialchars(ADSMANAGER_UNAME,ENT_QUOTES)."' name='username' size='20' maxlength='20' value='$username' /><br />\n"; 
					echo "<label>".ADSMANAGER_PASS."</label>\n";
					echo "<input $style class='adsmanager_required' mosReq='1' id='password' type='password' mosLabel='".htmlspecialchars(ADSMANAGER_PASS,ENT_QUOTES)."' name='password' size='20' maxlength='20' value='$password' />\n<br />"; 
					$emailField = false;
					$nameField = false;
					for($i = 0,$total = count($fields);$i < $total;$i++)
					{
						if (($fields[$i]->name == "email")&&((strpos($fields[$i]->catsid, ",$catid,") !== false)||(strpos($fields[$i]->catsid, ",-1,") !== false)))
						{
							$emailField = true;
							/* Force required */
							$fields[$i]->required = 1;
						}
						else if (($fields[$i]->name == "name")&&((strpos($fields[$i]->catsid, ",$catid,") !== false)||(strpos($fields[$i]->catsid, ",-1,") !== false)))
						{
							$nameField = true;
							/* Force required */
							$fields[$i]->required = 1;
						}
						else if (($namestyle >= 2)&&($fields[$i]->name == "firstname")&&((strpos($fields[$i]->catsid, ",$catid,") !== false)||(strpos($fields[$i]->catsid, ",-1,") !== false)))
						{
							$firstnameField = true;
							/* Force required */
							$fields[$i]->required = 1;
						}
						else if( ($namestyle == 3)&&($fields[$i]->name == "middlename")&&((strpos($fields[$i]->catsid, ",$catid,") !== false)||(strpos($fields[$i]->catsid, ",-1,") !== false)))
						{
							$middlenameField = true;
							/* Force required */
							$fields[$i]->required = 1;
						}			
					}
					echo "<br />";
					if (($namestyle >= 2)&&($firstnameField == false))
					{
						echo "<label>".ADSMANAGER_FNAME."</label>\n";
						echo "<input $style class='adsmanager_required' mosReq='1' id='firstname' type='text' mosLabel='".htmlspecialchars(ADSMANAGER_FNAME,ENT_QUOTES)."' name='firstname' size='20' maxlength='20' value='$firstname' /><br />\n"; 
					}
					if ( ($namestyle == 3)&&($middlenameField == false))
					{
						echo "<label>".ADSMANAGER_MNAME."</label>\n";
						echo "<input $style class='adsmanager_required' mosReq='1' id='middlename' type='text' mosLabel='".htmlspecialchars(ADSMANAGER_MNAME,ENT_QUOTES)."' name='middlename' size='20' maxlength='20' value='$middlename' /><br />\n"; 
					}
					if ($nameField == false)
					{
						echo "<label>"._NAME."</label>\n";
						echo "<input $style class='adsmanager_required' mosReq='1' id='name' type='text' mosLabel='".htmlspecialchars(_NAME,ENT_QUOTES)."' name='name' size='20' maxlength='20' value='$name' /><br />\n"; 
					}
					if ($emailField == false)
					{
						echo "<label>"._EMAIL."</label>\n";
						echo "<input $style class='adsmanager_required' mosReq='1' id='email' type='text' mosLabel='".htmlspecialchars(_EMAIL,ENT_QUOTES)."' name='email' size='20' maxlength='20' value='$email' /><br />\n"; 
					}
					
				}
				
				/* Display Fields */
				adsmanager_html::displayFields($row,$default,$fields,$field_values,$catid);	
				?>
				<!-- fields -->
				<!-- image -->
				<?php	
				if ($conf->nb_images > 0)
				{
					echo ADSMANAGER_FORM_AD_IMAGE_TEXT; 
					echo "<br />";
				}
	
				for($i = 1; $i < $conf->nb_images + 1; $i++)
				{
					$ext_name = chr(ord('a')+$i-1);
					?>
					<label for="ad_picture<?php echo $i;?>"><?php echo ADSMANAGER_FORM_AD_PICTURE." ".$i; ?></label>
					<input id="ad_picture<?php echo $i;?>" type="file" name="ad_picture<?php echo $i;?>" />
					<?php
					if ($isUpdateMode) {
						$pic = $mosConfig_absolute_path."/images/$option/ads/".$ad_id.$ext_name."_t.jpg";
						if ( file_exists( $pic)) {
							echo "<img src='".$mosConfig_live_site."/images/$option/ads/".$ad_id.$ext_name."_t.jpg' align='top' border='0' alt='image$ad_id' />";
							echo "<input type='checkbox' name='cb_image$i' value='delete' />".ADSMANAGER_AD_DELETE_IMAGE;
						}
					}
					echo "<br />";
				}
				?>
				<!-- buttons -->
				<label for="ad_dummy"> </label>
				<input type="hidden" name="gflag" value="0" />
				<?php
				if (isset($row->date_created))
					echo "<input type='hidden' name='date_created' value='".$row->date_created."' />";	
					
				echo "<input type='hidden' name='isUpdateMode' value='$isUpdateMode' />";
				echo "<input type='hidden' name='id' value='$ad_id' />";
				?>
				<input type="submit" value="<?php echo ADSMANAGER_FORM_SUBMIT_TEXT; ?>" />
				<!-- buttons -->
			<?php
			}
			?>
		  </form>
		  <!-- form -->
	
		</fieldset>
	
	<?php
	
	}
	
	
	function show_confirmation($name,$adid,$adname,$option,$itemid)
	{
		global $mosConfig_live_site;
	?>
		<br />
		<font color='#990000'>
		<?php echo ADSMANAGER_CAUTION." <b>".$name."</b> ".ADSMANAGER_CAUTION_DELETE1."<b>".$adname."</b>".ADSMANAGER_CAUTION_DELETE2; ?>
		</font>
		<table class="adsmanager_header">
		   <tr>
			  <td><?php echo "&nbsp;"; ?></td>
			  <td>
				<?php 
				   $target = sefRelToAbs("index.php?option=$option&amp;page=delete_ad&amp;adid=$adid&amp;mode=confirm&amp;Itemid=$itemid");
				   echo "<a href='".$target."'>".ADSMANAGER_YES_DELETE."</a>"; ?>
			  </td>
			  <td><?php echo "&nbsp;"; ?></td>
			  <td>
			  
				<?php 
					$target = sefRelToAbs("index.php?option=$option&amp;Itemid=$itemid");
					echo "<a href='".$target."'>".ADSMANAGER_NO_DELETE."</a>"; ?>
			  </td>
		   </tr>
	   </table>
	<?php
	}	
	
	function showProfile($user,$fields,$option,$itemid) {	
		global $mosConfig_live_site;
		?>
		<br />
		<script language="javascript" type="text/javascript">
		function submitbutton() {
			var form = document.mosUserForm;
			var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&|\+|\-]", "i");

			// do field validation
			if (form.name.value == "") {
				alert( "<?php echo ADSMANAGER_REGWARN_NAME;?>" );
			} else if (form.username.value == "") {
				alert( "<?php echo ADSMANAGER_REGWARN_UNAME;?>" );
			} else if (r.exec(form.username.value) || form.username.value.length < 3) {
				alert( "<?php printf( ADSMANAGER_VALID_AZ09, ADSMANAGER_PROMPT_UNAME, 4 );?>" );
			} else if (form.email.value == "") {
				alert( "<?php echo ADSMANAGER_REGWARN_MAIL;?>" );
			} else if ((form.password.value != "") && (form.password.value != form.verifyPass.value)){
				alert( "<?php echo ADSMANAGER_REGWARN_VPASS2;?>" );
			} else if (r.exec(form.password.value)) {
				alert( "<?php printf( ADSMANAGER_VALID_AZ09, ADSMANAGER_REGISTER_PASS, 6 );?>" );
			} else {
				form.submit();
			}
		}
		</script>
		<?php $target = sefRelToAbs("index.php?option=$option&amp;page=save_profile&amp;Itemid=$itemid"); ?>
		<form action="<?php echo $target; ?>" method="post" name="mosUserForm">
		<div class="componentheading">
		<?php echo "<div class=\"adsmanager_list_title\" width=\"100%\">".ADSMANAGER_EDIT_PROFILE."</div>"; ?>
		</div>
		<br />
		<table cellpadding="5" cellspacing="0" border="0" width="100%">
		<tr>
			<td>
				<?php echo ADSMANAGER_UNAME; ?>
			</td>
			<td>
				<input class="inputbox" type="text" name="username" value="<?php echo $user->username;?>" size="40" />
			</td>
	    </tr>
		<tr>
			<td colspan="2">
				<?php echo ADSMANAGER_PROFILE_PASSWORD; ?>
			</td>
		</tr>
		</tr>
				<tr>
			<td>
				<?php echo ADSMANAGER_PASS; ?>
			</td>
			<td>
				<input class="inputbox" type="password" name="password" value="" size="40" />
			</td>
		</tr>
		<tr>
			<td>
				<?php echo ADSMANAGER_VPASS; ?>
			</td>
			<td>
				<input class="inputbox" type="password" name="verifyPass" size="40" />
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<?php echo ADSMANAGER_PROFILE_CONTACT; ?>
			</td>
		</tr>
		<tr>
			<td width=85>
				<?php echo ADSMANAGER_PROFILE_NAME; ?>
			</td>
			<td>
				<input class="inputbox" type="text" name="name" value="<?php echo $user->name;?>" size="40" />
			</td>
		</tr>
		<tr>
			<td>
				<?php echo ADSMANAGER_EMAIL; ?>
			</td>
			<td>
				<input class="inputbox" type="text" name="email" value="<?php echo $user->email;?>" size="40" />
			</td>
		</tr>
		<?php
		if (isset($fields)) {
		foreach($fields as $f)
		{
			if (($f->name != "name")&&($f->name != "email")){
				$value = "\$user->".$f->name;
				eval("\$value = \"$value\";");
				$value = adsmanager_html::getLangDefinition($value);
			?>
			<tr>
				<td>
					<?php 
						echo adsmanager_html::getLangDefinition($f->title). "\n";
					 ?>
				</td>
				<td>
					<input class="inputbox" type="text" name="<?php echo $f->name;?>" value="<?php echo $value;?>" size="40" />
				</td>
			</tr>
			<?php }
		}
		}
		?>
		<tr>
			<td colspan="2">
				<input class="button" type="button" value="<?php echo ADSMANAGER_FORM_SUBMIT_TEXT; ?>" onclick="submitbutton()" />
			</td>
		</tr>
		</table>
		<input type="hidden" name="id" value="<?php echo $user->id;?>" />
		</form>
		<?php
	}
	
	function recurseCategories( $id, $level, &$children,$itemid,$option) {
		global $mosConfig_absolute_path,$mosConfig_live_site;
		if (@$children[$id]) {
			$i=0;$first=true;
			foreach ($children[$id] as $row) {
				$link = sefRelToAbs("index.php?option=$option&amp;page=show_category&amp;catid=".$row->id."&amp;order=0&amp;expand=0&amp;Itemid=".$itemid);
				if ($level == 0)
				{
					if ($i==0)
					{
						echo '<tr align="center">';
					}
					?>
					<td width="33%">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr> 
					  <td  width="80"><div align="center">
					  <?php
						if (file_exists($mosConfig_absolute_path."/images/$option/categories/".$row->id."cat.jpg"))
							echo '<a href="'.$link.'"><img width="64" class="imgcat" src="'.$mosConfig_live_site.'/images/'.$option.'/categories/'.$row->id.'cat.jpg" alt="'.$row->name.'" /></a>';
						else
							echo '<a href="'.$link.'"><img width="64" class="imgcat" src="'.$mosConfig_live_site.'/components/'.$option.'/images/default.gif" alt="'.$row->name.'" /></a>';
					  ?>
					  </div></td>
					  </tr><tr>
					  <td align="center"> 
						<h2 class="adsmanager_main_cat"><a href="<?php echo $link; ?>"  ><?php echo $row->name; ?></a></h2>
					  </td>
					</tr>
					<tr>
					<td> 
					<h3 class="adsmanager_sub_cat">
					<?php
				}
				else
				{
					if ($first == false)
						echo ' - ';
					echo '<a href="'.$link.'">'.$row->name.'</a>';
					$first = false;
				}
				if ($level == 0)
				{
					adsmanager_html::recurseCategories( $row->id, $level+1, $children,$itemid,$option);
				}
				if ($level == 0)
				{
					?>
					</h3>
					</td>
					</tr>
					</table>
					</td>
					<?php
					if ($i==3)
					{
						echo '</tr>';
					}
				}
				$i++;
				if ($i == 3) $i=0;
			}
		}
	}
	
	function showGeneralLink($option,$itemid,$catid,$comprofiler)
	{
	?>
		<div class="adsmanager_innermenu">
		<?php 
			if ($catid == 0)
				$link_write_ad = sefRelToAbs("index.php?option=$option&amp;page=write_ad&amp;Itemid=$itemid");
			else
				$link_write_ad = sefRelToAbs("index.php?option=$option&amp;page=write_ad&amp;catid=$catid&amp;Itemid=$itemid");
							
			switch($comprofiler)
			{
				case 2: 
					$link_show_profile = sefRelToAbs("index.php?option=com_comprofiler&amp;task=userDetails&amp;Itemid=$itemid");
					$link_show_user = sefRelToAbs("index.php?option=com_comprofiler&amp;task=showProfile&amp;tab=AdsManagerTab&amp;Itemid=$itemid");
					break;
				case 1:
					$link_show_profile = sefRelToAbs("index.php?option=com_comprofiler&amp;task=userDetails&amp;Itemid=$itemid");
					$link_show_user = sefRelToAbs("index.php?option=$option&amp;page=show_user&amp;Itemid=$itemid");
					break;
				default:
					$link_show_profile = sefRelToAbs("index.php?option=com_adsmanager&amp;page=show_profile&amp;Itemid=$itemid");
					$link_show_user = sefRelToAbs("index.php?option=$option&amp;page=show_user&amp;Itemid=$itemid");
					break;
			}
		
			$link_show_rules = sefRelToAbs("index.php?option=$option&amp;page=show_rules&amp;Itemid=$itemid");
			$link_show_all = sefRelToAbs("index.php?option=$option&amp;page=show_all&amp;Itemid=$itemid");
			echo '<a href="'.$link_write_ad.'">'.ADSMANAGER_MENU_WRITE.'</a> | ';
			echo '<a href="'.$link_show_all.'">'.ADSMANAGER_MENU_ALL_ADS.'</a> | ';
			echo '<a href="'.$link_show_profile.'">'.ADSMANAGER_MENU_PROFILE.'</a> | ';
			echo '<a href="'.$link_show_user.'">'.ADSMANAGER_MENU_USER_ADS.'</a> | ';
			echo '<a href="'.$link_show_rules.'">'.ADSMANAGER_MENU_RULES.'</a>';
			
		?>
		</div>
	<?php
	}
	
	function lastAds($ads,$option,$itemid,$nb_images) {
		global $mosConfig_live_site,$mosConfig_absolute_path;
	?>
		<h1 class="contentheading"><?php echo ADSMANAGER_LAST_ADS;?></h1>
		<div class='adsmanager_box_module' align="center">
			<table class='adsmanager_inner_box' width="100%">
			<tr align="center">
			<?php
			foreach($ads as $row) {
			?>
				<td>
				<?php	
				$linkTarget = sefRelToAbs("index.php?option=com_adsmanager&amp;page=show_ad&amp;adid=".$row->id."&amp;catid=".$row->category."&amp;Itemid=".$itemid);			
				$ok = 0;$i=1;
				while(!$ok)
				{
					if ($i < $nb_images + 1)
					{
						$ext_name = chr(ord('a')+$i-1);
						$pic = $mosConfig_absolute_path."/images/$option/ads/".$row->id.$ext_name."_t.jpg";
						if (file_exists( $pic)) 
						{
							echo "<div align='center'><a href='".$linkTarget."'><img src='".$mosConfig_live_site."/images/$option/ads/".$row->id.$ext_name."_t.jpg' alt='".htmlspecialchars(stripslashes($row->ad_headline),ENT_QUOTES)."' border='0' /></a>";
							$ok = 1;
						}
					}
					else if ($nb_images != 0)
					{
						echo "<div align='center'><a href='".$linkTarget."'><img src='".$mosConfig_live_site."/components/$option/images/nopic.gif' alt='nopic' border='0' /></a>"; 
						$ok = 1;
					}
					else
					{
						$ok = 1;
					}   
					$i++;   	
				}
					
				echo "<br /><a href='$linkTarget'>".stripslashes($row->ad_headline)."</a>"; 
				echo "<br /><span class=\"adsmanager_cat\">(".$row->parent." / ".$row->cat.")</span>";
				echo "<br />".adsmanager_html::reorderDate($row->date_created);
				echo "</div>";
				?>
				</td>
			<?php
			}
			?>
			</tr>
			</table>
			</div>
	<br />
	<?php
	}

	function showFront($conf,$tree,$ads,$option,$itemid) {
	
		global $mosConfig_absolute_path, $mosConfig_live_site;
	?>
	<?php
	if ($conf->display_last == 1)
	{
		adsmanager_html::lastAds($ads,$option,$itemid,$conf->nb_images); 
	}
	?>
	<h1 class="contentheading"><?php echo ADSMANAGER_FRONT_TITLE; ?></h1>
	<div class="adsmanager_fronttext"><?php echo stripslashes($conf->fronttext); ?></div>
	<?php adsmanager_html::showGeneralLink($option,$itemid,0,$conf->comprofiler); ?>
	<br />
	
	<div align="center">
	<table width="90%" border="0" cellpadding="0" cellspacing="0">
	<?php
	adsmanager_html::recurseCategories( 0, 0, $tree,$itemid,$option);
	?>
	</table>
	</div>
	<br />
	<?php
	if ($conf->display_last == 2)
	{
		adsmanager_html::lastAds($ads,$option,$itemid,$conf->nb_images); 
	}
	?>
	<?php
	}
	
	function loginpage ($return,$comprofiler) {
		global $mosConfig_lang,$mosConfig_live_site;
		
		$image = $mosConfig_live_site .'/images/stories/key.jpg';
		
		if (checkJoomlaVersion() == 1) /* Joomla 1.5 */
		{
			$validate = JHTML::_( 'form.token' );
			$link_login = sefRelToAbs("index.php?option=com_login");
			$special = '<input type="hidden" name="option" value="com_user" /><input type="hidden" name="task" value="login" />';
			$return = base64_encode( $return );  
		}
		else
		{
			$validate = '<input type="hidden" name="'.josSpoofValue(1).'" value="1" />';
			$link_login = sefRelToAbs("index.php?option=login");
			$return = sefRelToAbs( $return );
		}
		
		if ($comprofiler == 1)
		{
			$link_lostpassword = sefRelToAbs("index.php?option=com_comprofiler&amp;task=lostPassword");
			$link_create = sefRelToAbs("index.php?option=com_comprofiler&amp;task=registers");
		}
		else
		{
			$link_lostpassword = sefRelToAbs("index.php?option=com_registration&amp;task=lostPassword");
			$link_create = sefRelToAbs("index.php?option=com_registration&amp;task=register");
			
		}
		?>
		<form action="<?php echo $link_login; ?>" method="post" name="login" id="login">
		<table width="100%" border="0" align="center" cellpadding="4" cellspacing="0" class="contentpane">
		<tr>
			<td colspan="2">
			<div class="componentheading">
			<?php echo ADSMANAGER_LOGIN; ?>
			</div>
			<div>
			<?php echo '<img src="'. $image  .'" align="right" hspace="10" alt="" />'; ?>
			<?php echo ADSMANAGER_LOGIN_DESCRIPTION; ?>
			<br /><br />
			</div>
			</td>
		</tr>
		<tr>
			<td align="center" width="50%">
				<br />
				<table>
				<tr>
					<td align="center">
					<?php echo ADSMANAGER_USERNAME; ?>
					<br />
					</td>
					<td align="center">
					<?php echo ADSMANAGER_PASSWORD; ?>
					<br />
					</td>
				</tr>
				<tr>
					<td align="center">
					<input name="username" type="text" class="inputbox" size="20" />
					</td>
					<td align="center">
					<input name="passwd" type="password" class="inputbox" size="20" />
					</td>
				</tr>
				<tr>
					<td align="center" colspan="2">
					<br />
					<?php echo ADSMANAGER_REMEMBER_ME; ?>
					<input type="checkbox" name="remember" class="inputbox" value="yes" />
					<br />
					<a href="<?php echo $link_lostpassword; ?>">
					<?php echo ADSMANAGER_LOST_PASSWORD; ?>
					</a>
					<br />
					<?php echo ADSMANAGER_NO_ACCOUNT; ?>
					<a href="<?php echo $link_create; ?>">
					<?php echo ADSMANAGER_CREATE_ACCOUNT;?>
					</a>
					<br /><br /><br />
					</td>
				</tr>
				</table>
			</td>
			<td>
			<div align="center">
			<input type="submit" name="submit" class="button" value="<?php echo ADSMANAGER_BUTTON_LOGIN; ?>" />
			</div>

			</td>
		</tr>
		<tr>
			<td colspan="2">
			<noscript>
			<?php echo ADSMANAGER_CMN_JAVASCRIPT; ?>
			</noscript>
			</td>
		</tr>
		</table>
		<input type="hidden" name="op2" value="login" />
		
		<input type="hidden" name="lang" value="<?php echo $mosConfig_lang; ?>" />
		<?php echo $validate; ?>
		<input type="hidden" name="message" value="0" />
		<input type="hidden" name="force_session" value="1" />
		<input type="hidden" name="return" value="<?php echo $return; ?>" />
		<?php echo $special; ?>
		</form>
		<?php
  	}
	
	function show_footer()
	{
		?>
		
		<?php
	}
}
?>