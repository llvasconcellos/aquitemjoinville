<?php
defined( '_VALID_MOS' ) or die( 'Restricted Access.' );

$version = "1.1.5";

require_once( $mainframe->getCfg('absolute_path') . '/mambots/editors/jce/jscripts/tiny_mce/libraries/classes/jce.class.php' );
require_once( $mainframe->getCfg('absolute_path') . '/mambots/editors/jce/jscripts/tiny_mce/libraries/classes/jce.utils.class.php' );

$jce = new JCE();
$jce->setPlugin('mediamanager');

require_once( $jce->getPluginPath() . '/classes/manager.class.php' );

//Setup languages
include_once( $jce->getLibPath() . '/langs/' . $jce->getLanguage() . '.php' );
include_once(  $jce->getPluginPath() . '/langs/' . $jce->getPluginLanguage() . '.php' );

//Load Plugin Parameters
$params = $jce->getPluginParams();

$base_dir = $jce->getBaseDir( true );
$base_url = $base_dir;

$manager = new mediaManager( $base_dir, $base_url );

$jce->setAjax( array( 'getProperties', &$manager, 'getProperties' ) );
$jce->setAjax( array( 'getDimensions', &$manager, 'getDimensions' ) );

$jce->processAjax();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo $jce->translate('desc') . " - " . $version;?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $jce->translate('iso');?>" />
	<?php 
	echo $jce->printLibJs( 'tiny_mce_utils' );
	echo $jce->printLibJs( 'mootools' );
	echo $jce->printLibJs( 'utils' );
	echo $jce->printLibJs( 'manager' );
	echo $jce->printPluginJs( 'functions' );
	echo $jce->printLibJs( 'window' );
	echo $jce->printLibJs( 'dtree' );
	echo $jce->printLibCss( 'common', true );
	echo $jce->printPluginCss( 'manager' );
	echo $jce->printLibCss( 'dtree' );
	?>
	<script type="text/javascript">
		jce.setPlugin('mediamanager');
		jce.set("base_url", "<?php echo $base_url; ?>");
		jce.set("flv_player_path", "<?php echo $params->get('flv_player_path', 'mambots/editors/jce/jscripts/tiny_mce/plugins/mediamanager');?>");
		jce.set("flv_player", "<?php echo $params->get('flv_player', 'flvplayer.swf');?>");
	</script>
</head>
<body lang="<?php echo $jce->getPluginLanguage(); ?>" id="mediamanager" onLoad="init();" style="display: none">
    <form name="uploadForm" id="uploadForm" action="<?php echo $jce->getPluginFile('files.php');?>" target="manager" enctype="multipart/form-data" method="post">
    <input type="hidden" name="itemsList" id="itemsList" />
    <input type="hidden" name="clipboard" id="clipboard" />
		<div class="tabs">
			<ul>
				<li id="general_tab" class="current"><span><a href="javascript:mcTabs.displayTab('general_tab','general_panel');" onMouseDown="return false;"><?php echo $jce->translate('general');?></a></span></li>
				<li id="advanced_tab"><span><a href="javascript:mcTabs.displayTab('advanced_tab','advanced_panel');" onMouseDown="return false;"><?php echo $jce->translate('advanced');?></a></span></li>
			</ul>
		</div>

		<div class="panel_wrapper">
			<div id="general_panel" class="panel current">
				<fieldset>
					<legend><?php echo $jce->translate('general');?></legend>

					<table border="0" cellpadding="4" cellspacing="0">
							<tr>
								<td><label for="media_type"><?php echo $jce->translate('media_type');?></label></td>
								<td><select id="media_type" name="media_type" onChange="changedType(this.value);">
										<option value="flash">Flash</option>
										<option value="qt">Quicktime</option>
										<option value="shockwave">Shockware</option>
										<option value="wmp">Windows Media</option>
										<option value="rmp">Real Media</option>
									</select>
								</td>
							</tr>
							<tr>
							<td><label for="src"><?php echo $jce->translate('file');?></label></td>
							  <td>
									<table border="0" cellspacing="0" cellpadding="0">
									  <tr>
										<td><input id="src" name="src" type="text" value="" onChange="getType(getExtension(this.value));"/></td>
									  </tr>
									</table>
								</td>
							</tr>
							<tr>
								<td><label for="width"><?php echo $jce->translate('size');?></label></td>
								<td>
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="text" id="width" name="width" value="" onChange="changeHeight();" /> x <input type="text" id="height" name="height" value="" onChange="changeWidth();" /></td>
										<input name="tmp_width" type="hidden" id="tmp_width" value=""  />
										<input name="tmp_height" type="hidden" id="tmp_height" value="" />
										<td>&nbsp;&nbsp;<input id="constrain" type="checkbox" name="constrain" class="checkbox" checked="checked" /></td>
										<td><label id="constrainlabel" for="constrain"><?php echo $jce->translate('constrain');?></label></td>
										<td><div id="dim_loader"></div></td>
									</tr>
								</table>
							</tr>
					</table>
					<table border="0" cellpadding="4" cellspacing="0" width="100%">
						<tr>
							<td><label for="id"><?php echo $jce->translate('id');?></label></td>
							<td><input type="text" id="id" name="id" /></td>
							<td><label for="name"><?php echo $jce->translate('name');?></label></td>
							<td><input type="text" id="name" name="name" /></td>
						</tr>

						<tr>
							<td><label for="align"><?php echo $jce->translate('align');?></label></td>
							<td>
								<select id="align" name="align">
									<option value="">{$lang_not_set}</option> 
									<option>top</option>
									<option>right</option>
									<option>bottom</option>
									<option>left</option>
								</select>
							</td>
							<td><label for="bgcolor"><?php echo $jce->translate('bgcolor');?></label></td>
							<td>
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input id="bgcolor" name="bgcolor" type="text" value="#ffffff" size="9" onChange="updateColor('bgcolor_pick','bgcolor');" /></td>
										<td id="bgcolor_pickcontainer">&nbsp;</td>
									</tr>
								</table>
							</td>
						</tr>

						<tr>
							<td><label for="vspace"><?php echo $jce->translate('vspace');?></label></td>
							<td><input type="text" id="vspace" name="vspace" /></td>
							<td><label for="hspace"><?php echo $jce->translate('hspace');?></label></td>
							<td><input type="text" id="hspace" name="hspace" /></td>
						</tr>
					</table>
				</fieldset>
			</div>

			<div id="advanced_panel" class="panel">
				<fieldset id="flash_options">
					<legend><?php echo $jce->translate('flash_options');?></legend>

					<table border="0" cellpadding="4" cellspacing="0">
						<tr>
							<td><label for="flash_quality"><?php echo $jce->translate('quality');?></label></td>
							<td>
								<select id="flash_quality" name="flash_quality">
									<option value="">{$lang_not_set}</option> 
									<option value="high">high</option>
									<option value="low">low</option>
									<option value="autolow">autolow</option>
									<option value="autohigh">autohigh</option>
									<option value="best">best</option>
								</select>
							</td>

							<td><label for="flash_scale"><?php echo $jce->translate('scale');?></label></td>
							<td>
								<select id="flash_scale" name="flash_scale">
									<option value="">{$lang_not_set}</option> 
									<option value="showall">showall</option>
									<option value="noborder">noborder</option>
									<option value="exactfit">exactfit</option>
								</select>
							</td>
						</tr>

						<tr>
							<td><label for="flash_wmode"><?php echo $jce->translate('wmode');?></label></td>
							<td>
								<select id="flash_wmode" name="flash_wmode">
									<option value="">{$lang_not_set}</option> 
									<option value="window">window</option>
									<option value="opaque">opaque</option>
									<option value="transparent">transparent</option>
								</select>
							</td>

							<td><label for="flash_salign"><?php echo $jce->translate('salign');?></label></td>
							<td>
								<select id="flash_salign" name="flash_salign">
									<option value="">{$lang_not_set}</option> 
									<option value="l">left</option>
									<option value="t">top</option>
									<option value="r">right</option>
									<option value="b">bottom</option>
									<option value="tl">top-left</option>
									<option value="tr">top_right</option>
									<option value="bl">bottom-left</option>
									<option value="br">bottom-right</option>
								</select>
							</td>
						</tr>

						<tr>
							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="flash_play" name="flash_play" checked="checked" /></td>
										<td><label for="flash_play"><?php echo $jce->translate('play');?></label></td>
									</tr>
								</table>
							</td>

							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="flash_loop" name="flash_loop" checked="checked" /></td>
										<td><label for="flash_loop"><?php echo $jce->translate('loop');?></label></td>
									</tr>
								</table>
							</td>
						</tr>

						<tr>
							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="flash_menu" name="flash_menu" checked="checked" /></td>
										<td><label for="flash_menu"><?php echo $jce->translate('menu');?></label></td>
									</tr>
								</table>
							</td>

							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="flash_swliveconnect" name="flash_swliveconnect" /></td>
										<td><label for="flash_swliveconnect"><?php echo $jce->translate('liveconnect');?></label></td>
									</tr>
								</table>
							</td>
						</tr>
					</table>

					<table>
						<tr>
							<td><label for="flash_base"><?php echo $jce->translate('base');?></label></td>
							<td><input type="text" id="flash_base" name="flash_base" /></td>
						</tr>

						<tr>
							<td><label for="flash_flashVars"><?php echo $jce->translate('flashvars');?></label></td>
							<td><input type="text" id="flash_flashvars" name="flash_flashvars" size="200" /></td>
						</tr>
					</table>
				</fieldset>
				<fieldset id="flv_options">
					<legend><?php echo $jce->translate('flv_title');?></legend>
					<table border="0" cellpadding="4" cellspacing="0">
						<tr>
							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="flash_flv_autostart" name="flash_flv_autostart" /></td>
										<td><label for="flash_flv_autostart"><?php echo $jce->translate('flv_auto');?></label></td>
									</tr>
								</table>
							</td>
							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="flash_flv_repeat" name="flash_flv_repeat" /></td>
										<td><label for="flash_flv_repeat"><?php echo $jce->translate('flv_loop');?></label></td>
									</tr>
								</table>
							</td>				
						</tr>
					</table>
					<table>
						<tr>
							<td><label for="flash_flv_bufferlength"><?php echo $jce->translate('flv_buffer');?></label></td>
							<td><input type="text" size="3" id="flash_flv_bufferlength" name="flash_flv_bufferlength" value="5" /></td>
						</tr>
						<tr>
							<td colspan="2" id="flv_preview_container">&nbsp;</td>
						</tr>
						<tr>
							<td><label for="flash_flv_frontcolor1"><?php echo $jce->translate('flv_color_dark');?></label></td>
							<td>
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input id="flash_flv_frontcolor" name="flash_flv_frontcolor" type="text" value="#333333" size="9" onChange="updateColor('flash_flv_frontcolor_pick','flash_flv_frontcolor');setFlvPreview();" /></td>
										<td id="flash_flv_frontcolor_pickcontainer">&nbsp;</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td><label for="flash_flv_lightcolor"><?php echo $jce->translate('flv_color_light');?></label></td>
							<td>
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input id="flash_flv_lightcolor" name="flash_flv_lightcolor" type="text" value="#999999" size="9" onChange="updateColor('flash_flv_lightcolor_pick','flash_flv_lightcolor');setFlvPreview();" /></td>
										<td id="flash_flv_lightcolor_pickcontainer">&nbsp;</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</fieldset>
				<fieldset id="qt_options">
					<legend><?php echo $jce->translate('qt_options');?></legend>

					<table border="0" cellpadding="4" cellspacing="0">
						<tr>
							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="qt_loop" name="qt_loop" /></td>
										<td><label for="qt_loop"><?php echo $jce->translate('loop');?></label></td>
									</tr>
								</table>
							</td>

							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="qt_autoplay" name="qt_autoplay" /></td>
										<td><label for="qt_autoplay"><?php echo $jce->translate('play');?></label></td>
									</tr>
								</table>
							</td>
						</tr>

						<tr>
							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="qt_cache" name="qt_cache" /></td>
										<td><label for="qt_cache"><?php echo $jce->translate('cache');?></label></td>
									</tr>
								</table>
							</td>

							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="qt_controller" name="qt_controller" checked="checked" /></td>
										<td><label for="qt_controller"><?php echo $jce->translate('controller');?></label></td>
									</tr>
								</table>
							</td>
						</tr>

						<tr>
							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="qt_correction" name="qt_correction" /></td>
										<td><label for="qt_correction"><?php echo $jce->translate('correction');?></label></td>
									</tr>
								</table>
							</td>

							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="qt_enablejavascript" name="qt_enablejavascript" /></td>
										<td><label for="qt_enablejavascript"><?php echo $jce->translate('enablejavascript');?></label></td>
									</tr>
								</table>
							</td>
						</tr>

						<tr>
							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="qt_kioskmode" name="qt_kioskmode" /></td>
										<td><label for="qt_kioskmode"><?php echo $jce->translate('kioskmode');?></label></td>
									</tr>
								</table>
							</td>

							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="qt_autohref" name="qt_autohref" /></td>
										<td><label for="qt_autohref"><?php echo $jce->translate('autohref');?></label></td>
									</tr>
								</table>
							</td>
						</tr>

						<tr>
							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="qt_playeveryframe" name="qt_playeveryframe" /></td>
										<td><label for="qt_playeveryframe"><?php echo $jce->translate('playeveryframe');?></label></td>
									</tr>
								</table>
							</td>

							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="qt_targetcache" name="qt_targetcache" /></td>
										<td><label for="qt_targetcache"><?php echo $jce->translate('targetcache');?></label></td>
									</tr>
								</table>
							</td>
						</tr>

						<tr>
							<td><label for="qt_scale"><?php echo $jce->translate('scale');?></label></td>
							<td><select id="qt_scale" name="qt_scale" class="mceEditableSelect">
									<option value="">{$lang_not_set}</option> 
									<option value="tofit">tofit</option>
									<option value="aspect">aspect</option>
								</select>
							</td>

							<td colspan="2">&nbsp;</td>
						</tr>

						<tr>
							<td><label for="qt_starttime"><?php echo $jce->translate('starttime');?></label></td>
							<td><input type="text" id="qt_starttime" name="qt_starttime" /></td>

							<td><label for="qt_endtime"><?php echo $jce->translate('endtime');?></label></td>
							<td><input type="text" id="qt_endtime" name="qt_endtime" /></td>
						</tr>

						<tr>
							<td><label for="qt_target"><?php echo $jce->translate('target');?></label></td>
							<td><input type="text" id="qt_target" name="qt_target" /></td>

							<td><label for="qt_href"><?php echo $jce->translate('href');?></label></td>
							<td><input type="text" id="qt_href" name="qt_href" /></td>
						</tr>

						<tr>
							<td><label for="qt_qtsrcchokespeed"><?php echo $jce->translate('qtsrcchokespeed');?></label></td>
							<td><input type="text" id="qt_qtsrcchokespeed" name="qt_qtsrcchokespeed" /></td>

							<td><label for="qt_volume"><?php echo $jce->translate('volume');?></label></td>
							<td><input type="text" id="qt_volume" name="qt_volume" /></td>
						</tr>

						<tr>
							<td><label for="qt_qtsrc"><?php echo $jce->translate('qtsrc');?></label></td>
							<td colspan="4">
							<table border="0" cellspacing="0" cellpadding="0">
								  <tr>
									<td><input type="text" id="qt_qtsrc" name="qt_qtsrc" /></td>
									<td id="qtsrcfilebrowsercontainer">&nbsp;</td>
								  </tr>
							</table>
							</td>
						</tr>
					</table>
				</fieldset>

				<fieldset id="wmp_options">
					<legend><?php echo $jce->translate('wmp_options');?></legend>

					<table border="0" cellpadding="4" cellspacing="0">
						<tr>
							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="wmp_autostart" name="wmp_autostart" checked="checked" /></td>
										<td><label for="wmp_autostart"><?php echo $jce->translate('autostart');?></label></td>
									</tr>
								</table>
							</td>

							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="wmp_enabled" name="wmp_enabled" /></td>
										<td><label for="wmp_enabled"><?php echo $jce->translate('enabled');?></label></td>
									</tr>
								</table>
							</td>
						</tr>

						<tr>
							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="wmp_enablecontextmenu" name="wmp_enablecontextmenu" checked="checked" /></td>
										<td><label for="wmp_enablecontextmenu"><?php echo $jce->translate('menu');?></label></td>
									</tr>
								</table>
							</td>

							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="wmp_fullscreen" name="wmp_fullscreen" /></td>
										<td><label for="wmp_fullscreen"><?php echo $jce->translate('fullscreen');?></label></td>
									</tr>
								</table>
							</td>
						</tr>

						<tr>
							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="wmp_invokeurls" name="wmp_invokeurls" checked="checked" /></td>
										<td><label for="wmp_invokeurls"><?php echo $jce->translate('invokeurls');?></label></td>
									</tr>
								</table>
							</td>

							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="wmp_mute" name="wmp_mute" /></td>
										<td><label for="wmp_mute"><?php echo $jce->translate('mute');?></label></td>
									</tr>
								</table>
							</td>
						</tr>

						<tr>
							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="wmp_stretchtofit" name="wmp_stretchtofit" /></td>
										<td><label for="wmp_stretchtofit"><?php echo $jce->translate('stretchtofit');?></label></td>
									</tr>
								</table>
							</td>

							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="wmp_windowlessvideo" name="wmp_windowlessvideo" /></td>
										<td><label for="wmp_windowlessvideo"><?php echo $jce->translate('windowlessvideo');?></label></td>
									</tr>
								</table>
							</td>
						</tr>

						<tr>
							<td><label for="wmp_balance"><?php echo $jce->translate('balance');?></label></td>
							<td><input type="text" id="wmp_balance" name="wmp_balance" /></td>

							<td><label for="wmp_baseurl"><?php echo $jce->translate('baseurl');?></label></td>
							<td><input type="text" id="wmp_baseurl" name="wmp_baseurl" /></td>
						</tr>

						<tr>
							<td><label for="wmp_captioningid"><?php echo $jce->translate('captioningid');?></label></td>
							<td><input type="text" id="wmp_captioningid" name="wmp_captioningid" /></td>

							<td><label for="wmp_currentmarker"><?php echo $jce->translate('currentmarker');?></label></td>
							<td><input type="text" id="wmp_currentmarker" name="wmp_currentmarker" /></td>
						</tr>

						<tr>
							<td><label for="wmp_currentposition"><?php echo $jce->translate('currentposition');?></label></td>
							<td><input type="text" id="wmp_currentposition" name="wmp_currentposition" /></td>

							<td><label for="wmp_defaultframe"><?php echo $jce->translate('defaultframe');?></label></td>
							<td><input type="text" id="wmp_defaultframe" name="wmp_defaultframe" /></td>
						</tr>

						<tr>
							<td><label for="wmp_playcount"><?php echo $jce->translate('playcount');?></label></td>
							<td><input type="text" id="wmp_playcount" name="wmp_playcount" /></td>

							<td><label for="wmp_rate"><?php echo $jce->translate('rate');?></label></td>
							<td><input type="text" id="wmp_rate" name="wmp_rate" /></td>
						</tr>

						<tr>
							<td><label for="wmp_uimode"><?php echo $jce->translate('uimode');?></label></td>
							<td><input type="text" id="wmp_uimode" name="wmp_uimode" /></td>

							<td><label for="wmp_volume"><?php echo $jce->translate('volume');?></label></td>
							<td><input type="text" id="wmp_volume" name="wmp_volume" /></td>
						</tr>

					</table>
				</fieldset>

				<fieldset id="rmp_options">
					<legend><?php echo $jce->translate('rmp_options');?></legend>

					<table border="0" cellpadding="4" cellspacing="0">
						<tr>
							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="rmp_autostart" name="rmp_autostart" /></td>
										<td><label for="rmp_autostart"><?php echo $jce->translate('autostart');?></label></td>
									</tr>
								</table>
							</td>

							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="rmp_loop" name="rmp_loop" /></td>
										<td><label for="rmp_loop"><?php echo $jce->translate('loop');?></label></td>
									</tr>
								</table>
							</td>
						</tr>

						<tr>
							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="rmp_autogotourl" name="rmp_autogotourl" checked="checked" /></td>
										<td><label for="rmp_autogotourl"><?php echo $jce->translate('autogotourl');?></label></td>
									</tr>
								</table>
							</td>

							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="rmp_center" name="rmp_center" /></td>
										<td><label for="rmp_center"><?php echo $jce->translate('center');?></label></td>
									</tr>
								</table>
							</td>
						</tr>

						<tr>
							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="rmp_imagestatus" name="rmp_imagestatus" checked="checked" /></td>
										<td><label for="rmp_imagestatus"><?php echo $jce->translate('imagestatus');?></label></td>
									</tr>
								</table>
							</td>

							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="rmp_maintainaspect" name="rmp_maintainaspect" /></td>
										<td><label for="rmp_maintainaspect"><?php echo $jce->translate('maintainaspect');?></label></td>
									</tr>
								</table>
							</td>
						</tr>

						<tr>
							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="rmp_nojava" name="rmp_nojava" /></td>
										<td><label for="rmp_nojava"><?php echo $jce->translate('nojava');?></label></td>
									</tr>
								</table>
							</td>

							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="rmp_prefetch" name="rmp_prefetch" /></td>
										<td><label for="rmp_prefetch"><?php echo $jce->translate('prefetch');?></label></td>
									</tr>
								</table>
							</td>
						</tr>

						<tr>
							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="rmp_shuffle" name="rmp_shuffle" /></td>
										<td><label for="rmp_shuffle"><?php echo $jce->translate('shuffle');?></label></td>
									</tr>
								</table>
							</td>

							<td colspan="2">&nbsp;
								
							</td>
						</tr>

						<tr>
							<td><label for="rmp_console"><?php echo $jce->translate('console');?></label></td>
							<td><input type="text" id="rmp_console" name="rmp_console" /></td>

							<td><label for="rmp_controls"><?php echo $jce->translate('controls');?></label></td>
							<td><input type="text" id="rmp_controls" name="rmp_controls" /></td>
						</tr>

						<tr>
							<td><label for="rmp_numloop"><?php echo $jce->translate('numloop');?></label></td>
							<td><input type="text" id="rmp_numloop" name="rmp_numloop" /></td>

							<td><label for="rmp_scriptcallbacks"><?php echo $jce->translate('scriptcallbacks');?></label></td>
							<td><input type="text" id="rmp_scriptcallbacks" name="rmp_scriptcallbacks" /></td>
						</tr>
					</table>
				</fieldset>

				<fieldset id="shockwave_options">
					<legend><?php echo $jce->translate('shockwave_options');?></legend>

					<table border="0" cellpadding="4" cellspacing="0">
						<tr>
							<td><label for="shockwave_swstretchstyle"><?php echo $jce->translate('swstretchstyle');?></label></td>
							<td>
								<select id="shockwave_swstretchstyle" name="shockwave_swstretchstyle">
									<option value="none">None</option>
									<option value="meet">Meet</option>
									<option value="fill">Fill</option>
									<option value="stage">Stage</option>
								</select>
							</td>

							<td><label for="shockwave_swvolume"><?php echo $jce->translate('volume');?></label></td>
							<td><input type="text" id="shockwave_swvolume" name="shockwave_swvolume" /></td>
						</tr>

						<tr>
							<td><label for="shockwave_swstretchhalign"><?php echo $jce->translate('swstretchhalign');?></label></td>
							<td>
								<select id="shockwave_swstretchhalign" name="shockwave_swstretchhalign">
									<option value="none">None</option>
									<option value="left">left</option>
									<option value="center">center</option>
									<option value="right">right</option>
								</select>
							</td>

							<td><label for="shockwave_swstretchvalign"><?php echo $jce->translate('swstretchvalign');?></label></td>
							<td>
								<select id="shockwave_swstretchvalign" name="shockwave_swstretchvalign">
									<option value="none">None</option>
									<option value="meet">Top</option>
									<option value="fill">Center</option>
									<option value="stage">Bottom</option>
								</select>
							</td>
						</tr>

						<tr>
							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="shockwave_autostart" name="shockwave_autostart" checked="checked" /></td>
										<td><label for="shockwave_autostart"><?php echo $jce->translate('autostart');?></label></td>
									</tr>
								</table>
							</td>

							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="shockwave_sound" name="shockwave_sound" checked="checked" /></td>
										<td><label for="shockwave_sound"><?php echo $jce->translate('sound');?></label></td>
									</tr>
								</table>
							</td>
						</tr>


						<tr>
							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="shockwave_swliveconnect" name="shockwave_swliveconnect" /></td>
										<td><label for="shockwave_swliveconnect"><?php echo $jce->translate('liveconnect');?></label></td>
									</tr>
								</table>
							</td>

							<td colspan="2">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><input type="checkbox" class="checkbox" id="shockwave_progress" name="shockwave_progress" checked="checked" /></td>
										<td><label for="shockwave_progress"><?php echo $jce->translate('progress');?></label></td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</fieldset>
			</div>
		</div>
		<fieldset>
	<legend><?php echo $jce->translate('browse');?></legend>
    <table class="properties" cellpadding="0" cellspacing="0">
		<tr>
			<td colspan="5" style="vertical-align:top">
				<div id="msgIcon">
        			<img id="imgMsgContainer" src="<?php echo  $jce->getLibImg('spacer.gif');?>" width="16" height="16" border="0" alt="Message" title="Message" />
   				 </div>
    			<div id="msgDiv">
        			<span id="msgContainer" style="vertical-align:top;"></span>
    			</div>
			</td>
		</tr>
		<tr>
			<td colspan="5" style="vertical-align:top">
				 <div id="dirListBlock">
        			<label for="dirlistcontainer" style="vertical-align:middle;"><?php echo $jce->translate('dir');?></label>&nbsp;<div id="dirlistcontainer" style="vertical-align:middle;"></div>
    			</div>
    			<div id="dirImg" style="display: inline;"><a href="javascript:void(0)" onClick="goUpDir();" title="<?php echo $jce->translate('dir_up');?>" class="toolbar"><img src="<?php echo $jce->getLibImg('dir_up.gif');?>" width="20" height="20" border="0" alt="<?php echo $jce->translate('dir_up');?>" /></a></div>
				<?php if( $jce->getAuthOption( 'folder_new', '18' ) ){?>
					<div id="folderImg" style="display: inline;"><a href="javascript:void(0)" class="toolbar" onClick="newFolder();" title="<?php echo $jce->translate('new_dir');?>"><img src="<?php echo $jce->getLibImg('new_folder.gif');?>" width="20" height="20" alt="<?php echo $jce->translate('new_dir');?>" /></a></div>
				<?php }?>
			
				<?php if( $jce->getAuthOption( 'upload', '18' ) ){?>
					<div id="upImg" style="display: inline;"><a href="javascript:void(0)" onClick="uploadFile();" class="toolbar"><img src="<?php echo $jce->getLibImg('upload.gif');?>" border="0" alt="<?php echo $jce->translate('upload');?>" width="20" height="20" title="<?php echo $jce->translate('upload');?>" /></a></div>
				<?php }?>
				<div id="hlpIcon" style="display: inline;"><a href="javascript:void(0)" onClick="openHelp('mediamanager');" class="toolbar"><img src="<?php echo  $jce->getLibImg('help.gif');?>" border="0" alt="<?php echo $jce->translate('help');?>" width="20" height="20" title="<?php echo $jce->translate('help');?>" /></a></div>
			</td>
		</tr>
		<tr>
			<td style="vertical-align:top"><div id="spacerDiv"></div></td>
			<td style="vertical-align:top"><?php echo $jce->sortType();?></td>
			<td style="vertical-align:top"><?php echo $jce->sortName();?></td>
			<td colspan="2" style="vertical-align:top"><?php echo $jce->searchDiv();?></td>
		</tr>
		<tr>
			<td style="vertical-align:top">
				<div id="treeBlock">
					<div id="treeTitle">
						<?php echo $jce->translate('folders');?>
					</div>
					<div id="treeDetails"></div>
				</div>
			</td>
    		<td colspan="2" style="vertical-align:top"><div id="fileContainer"></div></td>
    		<td style="vertical-align:top">
				<div id="infoBlock">
					<div id="infoTitle">
						<?php echo $jce->translate('details');?>
					</div>
					<div id="fileDetails"></div>
				</div>
			</td>
    		<td style="vertical-align:top">
				<div id="toolsList">
				   <?php echo $jce->editTools();?>
				   <div id="viewIcon" class="editIcon"><a href="javascript:void(0)" id="viewLink" title="<?php echo $jce->translate('view') ?>" onClick="viewMedia();" class="tools"><img src="<?php echo $jce->getLibImg('view.gif');?>" id="viewIcon" height="20" width="20" border="0" alt="<?php echo $jce->translate('view');?>" /></a> </div>
				</div>
			</td>
		</tr>
	</table>
	</fieldset>
    <!--//Tools-->
		<div class="mceActionPanel">
			<div style="float: right">
				<input type="button" class="button" id="refresh" name="refresh" value="<?php echo $jce->translate('refresh');?>" onClick="refreshAction();" />
				<input type="button" class="button" id="insert" name="insert" value="{$lang_insert}" onClick="insertMedia();" />
				<input type="button" class="button" id="cancel" name="cancel" value="{$lang_cancel}" onClick="tinyMCEPopup.close();" />
			</div>
		</div>
	</form>
</body>
</html>
