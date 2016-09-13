<?php
/**
* @package rssFactory
* @version 1.0
* @copyright www.thefactory.ro
*/
function com_install() {
	global $mosConfig_absolute_path, $database;

	$database->setQuery("update #__components set admin_menu_img='../components/com_rssfactory/images/default.ico' where `option`='com_rssfactory' ");
	$database->query();


	$source_file = $mosConfig_absolute_path."/components/com_rssfactory/module/mod_rssfactory.php";
	$destination_file = $mosConfig_absolute_path."/modules/mod_rssfactory.php";
	copy ($source_file, $destination_file);
	$source_file = $mosConfig_absolute_path."/components/com_rssfactory/module/mod_rssfactory.x";
	$destination_file = $mosConfig_absolute_path."/modules/mod_rssfactory.xml";
	copy ($source_file, $destination_file);

	$database->setQuery("
		INSERT INTO `#__modules` VALUES ('', 'RSSFactory MODULE','',0, 'left',0,'0000-00-00 00:00:00',0, 'mod_rssfactory',0,0,1,'moduleclass_sfx=
						sort_order=
						nr_feeds=10
						nrchars=30
						show_Category=
						showfeeddescription=table
						table_view_open=0
						hide_icon=1
						hide_date=0
						hide_bullet=0
						adv_filter=1
						catid1=0
						show_Category1=
						catid2=0
						show_Category2=
						catid3=0
						show_Category3=
						catid4=0
						show_Category4=
						catid5=0
						show_Category5=
						catid6=0
						show_Category6=
						catid7=0
						show_Category7=
						catid8=0
						show_Category8=
						catid9=0
						show_Category9=',
					0,0)
		");
	$database->query();

	$module_id=mysql_insert_id();

	$database->setQuery("INSERT INTO `#__modules_menu` VALUES ($module_id,0)");
	$database->query();

	$source_file = $mosConfig_absolute_path."/components/com_rssfactory/mambot/rssfactory.searchbot.php";
	$destination_file = $mosConfig_absolute_path."/mambots/search/rssfactory.searchbot.php";
	copy ($source_file, $destination_file);
	$source_file = $mosConfig_absolute_path."/components/com_rssfactory/mambot/rssfactory.searchbot.x";
	$destination_file = $mosConfig_absolute_path."/mambots/search/rssfactory.searchbot.xml";
	copy ($source_file, $destination_file);

	$database->setQuery("
		INSERT INTO `#__mambots` VALUES ('', 'RSSfactory searchbot','rssfactory.searchbot',
		'search',0,0,1,0,0,0,'0000-00-00 00:00:00','')
		");
	$database->query();
	$database->setQuery("
			INSERT INTO `#__rssfactory_ads` VALUES (1,'Here comes an AD!','<div><a href=\'http://www.thefactory.ro\'>The Factory - Joomla Components and Custom Joomla Work</a></div>',1)
			");
	$database->query();
	$database->setQuery("
				INSERT INTO `#__rssfactory_config` VALUES (1,3,'rss Factory 1.1.0 &nbsp;<a href=\"http://www.thefactory.ro/shop/joomla-components-and-modules.html\"><sub>powered by The Factory</sub>','pass',1,1,1,'tabbed',1,'overlib',10,1170007857,1,1,'n/j/y',0,0,1,10,'','output_iframe=1\niframe_height=800\ntwidth=130\ntheight=25\nforce_output_charset=');
			");
	$database->query();

	@require_once($GLOBALS['mosConfig_absolute_path']."/administrator/components/com_rssfactory/version_info.php");
    @$version=new component_version_info("com_rssfactory");

		?>
		<table class="adminform">
			<tr>
				<td>
				<p>
				Thank you for using RSSFactory.<br>

				<strong>Please set up your feeds and Ads in the admin panel. <br/>
					The RSS Factory module and search mambot are also installed. If you need them
					Enable The Module and/or Search mambot in your admin panel
				</strong></p>
				<br>
				<br>
				<p> Release Notes:<br>
				 <br>
                <?php echo $version->releasenotes;?>
				</p>
				<p><strong>RSSFactory </strong> Component <em>for Joomla/Mambo CMS</em> <br />
				Visit us at <a target="_blank" href="http://www.thefactory.ro">thefactory.ro</a> to learn  about new versions
				and/or to give us feedback<br>
				(c) 2006-2007 The Factory
				</td>
			</tr>
		<?php
}
?>
