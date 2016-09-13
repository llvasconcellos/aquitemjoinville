<?php

/**
* @version 1.1.3
* @package hwdRecommend
* @copyright (C) 2007 Highwood Design
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*    This program is free software: you can redistribute it and/or modify
*    it under the terms of the GNU General Public License as published by
*    the Free Software Foundation, either version 3 of the License, or
*    (at your option) any later version.
*
*    This program is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*    GNU General Public License for more details.
*
*    You should have received a copy of the GNU General Public License
*    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
**/

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

global $my, $database, $mosConfig_sitename, $mosConfig_live_site, $mosConfig_fromname, $mosConfig_mailfrom;

/* Load Language File */
if (file_exists("modules/mod_hwdrecommend/lang/".$mosConfig_lang.".php")) {
	include_once("modules/mod_hwdrecommend/lang/".$mosConfig_lang.".php");
} else {
	include_once("modules/mod_hwdrecommend/lang/english.php");
}

/* Security Note: These values are auto-sanitized by mosGetParam() */
$recommend_params['mod_width'] 			= $params->get( 'mod_width', '100%');
//$recommend_params['mod_bgcolor'] 		= $params->get( 'mod_bgcolor', '333333');
//$recommend_params['mod_fontcolor'] 		= $params->get( 'mod_fontcolor', 'ffffff');
$recommend_params['mod_fonttitlesize'] 	= $params->get( 'mod_fonttitlesize', '100%');
$recommend_params['mod_fontbodysize'] 	= $params->get( 'mod_fontbodysize', '85%');
$recommend_params['roundradius'] 		= $params->get( 'roundradius', '6');
$recommend_params['toogle_text'] 		= $params->get( 'toogle_text', ''._RMC_TITLE.'');
$recommend_params['show_form'] 			= $params->get( 'show_form', 'none');
$recommend_params['version'] 			= $params->get( 'version', '1.1.3');
$recommend_params['from_address'] 		= $params->get( 'from_address', 'user');
$recommend_params['form_orientation'] 	= $params->get( 'form_orientation', 'vertical');
$recommend_params['personal_message'] 	= $params->get( 'personal_message', '0');
$recommend_params['show_copyright'] 	= $params->get( 'show_copyright', '0');
$recommend_params['moduleclass_sfx'] 	= $params->get( 'moduleclass_sfx', '');

$username = ( !empty( $my->name ) ) ? $my->name : $my->username;
$base_url = "index.php?modules/mod_recommend/mod_recommend.php";	// Base URL string

/* Set form element widths from form orientation */
if ($recommend_params['form_orientation'] == 'horizontal') {
	$formelementwidth = '50%';
} else if ($recommend_params['form_orientation'] == 'vertical') {
	$formelementwidth = '100%';
}
/* Call CSS & Javascripts */
echo "<script language=\"javascript\" type=\"text/javascript\" src=\"".$mosConfig_live_site."/modules/mod_hwdrecommend/mod_hwdrecommend.js\" ></script>";
echo "<script language=\"javascript\" type=\"text/javascript\" src=\"".$mosConfig_live_site."/modules/mod_hwdrecommend/rounded.js\"></script>";
echo "<link href=\"".$mosConfig_live_site."/modules/mod_hwdrecommend/mod_hwdrecommend.css\" rel=\"stylesheet\" type=\"text/css\" />";
echo "<style type=\"text/css\">.submenu{display: ".$recommend_params['show_form'].";}</style>";
?>
<!-- hwdRecommend Joomla! Module by Highwood Design, http://www.highwooddesign.co.uk -->
<script type="text/javascript">
<!--
function recommendvalidate(){
	if ((document.recommend.recommend_from_email.value=='') || (document.recommend.recommend_to_email.value=='')){
		alert('<?php echo _RMC_ALERT_FIELDS; ?>');
		return false;
	} else {
		return true;
	}
}
//-->
</script>
<style type="text/css">
/**
 * Text passed with mosmsg url parameter,
 * If your template does not have this class
 * defined you should uncomment this definition
**/
/*
.message {
	width: *;
	border: 1px solid #c30;
	padding-top: 5px;
	padding-bottom: 5px;
	margin-top: 3px;
	margin-bottom: 3px;
	font-size : 100%;
	color : #c30;
	background: #fbece7;
	text-align: center;
}
*/
#masterdiv {
	width: <?php echo $recommend_params['mod_width']; ?>;
}
#masterdiv .mod_reco_rounded {
	margin: 0pt auto;
	padding: 0px;
	margin-bottom: 2px;
	background-color: #<?php echo $recommend_params['mod_bgcolor'] ?>;
	color: #<?php echo $recommend_params['mod_fontcolor'] ?>;
}
#masterdiv .mod_reco_rounded .padding {
	padding-left: 5px;
	padding-right: 5px;
	padding-top: 4px;
	padding-bottom: 0;
}
#masterdiv .mod_reco_rounded .padding .menutitle{
	cursor:pointer;
	margin-bottom: 5px;
	width:*;
	color: #<?php echo $recommend_params['mod_fontcolor'] ?>;
	font-size: <?php echo $recommend_params['mod_fonttitlesize'] ?>;
	text-align:left;
	font-weight:bold;
}
#masterdiv .mod_reco_rounded .padding .submenu{
	/*margin-bottom: 5px;*/
	width:*;
	color: #<?php echo $recommend_params['mod_fontcolor'] ?>;
	font-size: <?php echo $recommend_params['mod_fontbodysize'] ?>;
	text-align:left;
	font-weight:normal;
}
#masterdiv .clear {
 clear:both;
}
</style>
<?php
/* Main DIV */
echo "<div id=\"masterdiv\">";
echo "<div class=\"mod_reco_rounded\">";
echo "<div class=\"padding\">";
//echo "<div class=\"menutitle\" onclick=\"SwitchMenu('recommend')\">".$recommend_params['toogle_text']."</div>";
echo "<span class=\"submenu\" id=\"recommend\">";

		$recommend_option = mosGetParam( $_REQUEST, 'recommend_option', '' );

		switch($recommend_option) {
			case "send":
				$recommend_to_email = mosGetParam( $_REQUEST, 'recommend_to_email', '' );
				$recommend_from_name = mosGetParam( $_REQUEST, 'recommend_from_name', '' );
				$recommend_from_email = mosGetParam( $_REQUEST, 'recommend_from_email', '' );
				$recommend_message = mosGetParam( $_REQUEST, 'recommend_message', '' );
				$recommend_url = mosGetParam( $_REQUEST, 'recommend_url', '' );
					if (NotValidEmail($recommend_to_email)) {
							echo "<script> alert('" . _RMC_ALERT_EMAIL . "'); window.history.go(-1); </script>\n";
							exit;
					} else {
							recommendsendmail($recommend_from_name, $recommend_from_email, $recommend_to_email, $recommend_message, $recommend_url);
					}
			break;
			default:
				echo "<form name=\"recommend\" method=\"post\" action=\"".$base_url."\" onsubmit=\"return recommendvalidate()\">";
				// find out the domain:
				$domain = $_SERVER['HTTP_HOST'];
				// find out the path to the current file:
				$path = $_SERVER['SCRIPT_NAME'];
				// find out the QueryString:
				$queryString = $_SERVER['QUERY_STRING'];
				// put it all together:
				$recommend_url = "http://" . $domain . $path . "?" . $queryString;
				echo "<input name=\"recommend_option\" type=\"hidden\" id=\"recommend_option\" value=\"send\" />";
				echo "<input name=\"recommend_url\" type=\"hidden\" value=\"".$recommend_url."\" />";
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"100%\">";
				if($recommend_params['from_address'] == 'webmaster'){
					echo "<input name=\"recommend_from_name\" type=\"hidden\" value=\"".$mosConfig_fromname."\" />";
					echo "<input name=\"recommend_from_email\" type=\"hidden\" value=\"".$mosConfig_mailfrom."\" />";
				} else if($recommend_params['from_address'] == 'user') {
					echo "<tr>";
					echo "<td valign=\"top\"><span style=\"width:".$formelementwidth.";\">"._RMC_YOUR_NAME."<br /><input name=\"recommend_from_name\" type=\"text\" style=\"width: 90%;\" value=\"";
					if ($username) {
						echo $username;
					}
					echo "\" class=\"inputbox\" /></span></td>";
					if($recommend_params['form_orientation'] == 'vertical'){
						echo "</tr><tr>";
					}
					echo "<td valign=\"top\"><span style=\"width:".$formelementwidth.";\"><br /><input name=\"recommend_from_email\" type=\"text\" style=\"width: 90%;\" value=\""._RMC_YOUR_EMAIL;
					if ($my->email) {
						echo $my->email;
					}
					echo "\" class=\"inputbox\" /></span></td>";
					if($recommend_params['form_orientation'] == 'vertical'){
						echo "</tr>";
					}
				}
				echo "<tr><td valign=\"top\"><span style=\"width:".$formelementwidth.";\"><input name=\"recommend_to_email\" type=\"text\" style=\"width: 90%;\" value=\""._RMC_FRIENDS_EMAIL."\" class=\"inputbox\" /></td>";
				if($recommend_params['form_orientation'] == 'horizontal'){
					echo "<td valign=\"top\"><span style=\"width:".$formelementwidth.";\"><input type=\"submit\" name=\"Submit\" value=\""._RMC_SEND."\" style=\"width: auto;\" class=\"button\" /></span></td>";
					echo "</tr>";
					if($recommend_params['personal_message'] == '1'){
						echo "<tr><td valign=\"top\" colspan=\"4\"><div>"._RMC_PERSONAL_MESSAGE."<br /><textarea name=\"recommend_message\" style=\"width: 90%;\" class=\"inputbox\"></textarea></td>";
					}
				} else if($recommend_params['form_orientation'] == 'vertical') {
					//echo "</tr>";
					if($recommend_params['personal_message'] == '1'){
						echo "<tr><td valign=\"top\" colspan=\"4\"><div>"._RMC_PERSONAL_MESSAGE."<br /><textarea name=\"recommend_message\" style=\"width: 90%;\" class=\"inputbox\"></textarea></td></tr>";
					}
				//echo "<tr>";
				echo "<td valign=\"top\"><span style=\"width:".$formelementwidth.";\"><input type=\"submit\" name=\"Submit\" value=\""._RMC_SEND."\" style=\"width: auto;\" class=\"button\" /></span></td>";
				echo "</tr>";
				}
				echo "</table>";
				echo "</form>";
			break;
		}
echo "</span>";
echo "</div></div></div>";
?>
<!--<script type="text/javascript">Rounded('mod_reco_rounded', <?php echo $recommend_params['roundradius'] ?>, <?php echo $recommend_params['roundradius'] ?>);</script>-->
<?php

/* Main Sendmail Function */

	function recommendsendmail($recommend_from_name, $recommend_from_email, $recommend_to_email, $recommend_message, $recommend_url){
		global $database, $mosConfig_sitename, $mosConfig_live_site, $mosConfig_fromname, $mosConfig_mailfrom;
		if (isset($recommend_from_email) && $recommend_from_email != "" && isset($recommend_to_email) && $recommend_to_email != ""){
			if (isset($recommend_from_name) && $recommend_from_name != "") {
				$fromaddress = $recommend_from_email;
				$fromname = $recommend_from_name;
			} else {
				$fromaddress = $mosConfig_mailfrom;
				$fromname = $mosConfig_fromname;
			}

			$frname = $recommend_from_name;

			$subject = $frname . " " . _RMC_INVITES_YOU . " " . $mosConfig_sitename;

			$text = _RMC_HELLO . "\n\n";
			$text .= $frname . " (" . $recommend_from_email . ") " . _RMC_INVITES_YOU . " " . $mosConfig_sitename . "\n";
			$text .= _RMC_GO_TO . "\n";
			$text .= $recommend_url . "\n\n";
			if (isset($recommend_message) && $recommend_message != "")
				$text .= _RMC_TELLS_YOU . "\n" . $recommend_message . "\n";

			echo $fromaddress.$fromname.$recommend_to_email.$subject.$text;
			$success = mosMail( $fromaddress, $fromname , $recommend_to_email, $subject, $text );
			if (!$success) {
    	    	mosRedirect($recommend_url, _RMC_FAILURE." ");
			} else {
    	    	mosRedirect($recommend_url, _RMC_SUCCESS." ");
			}
	    }
	}

/* Email Validation */

	function NotValidEmail($email) {
		if (eregi("^([._a-z0-9-]+[._a-z0-9-]*)@(([a-z0-9-]+\.)*([a-z0-9-]+)(\.[a-z]{2,4}))$", $email)) {
			return FALSE;
		} else {
			return TRUE;
		}
	}
?>