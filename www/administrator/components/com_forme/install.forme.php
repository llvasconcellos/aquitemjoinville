<?php
/**
* @version 1.0.4
* @package RSform! 1.0.4
* @copyright (C) 2007 www.rsjoomla.com
* @license Commercial License, http://www.rsjoomla.com/license/forme.html
*/
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
function com_install() {
	global $database, $mosConfig_absolute_path;
  ?>
  <center>
  <table width="100%" border="0">
   <tr>
      <td>
        <strong>RSform!</strong><br/>
        Released under the terms and conditions of the License</a>.<br>
		<br/>
      </td>
    </tr>
    <tr>
      <td background="E0E0E0" style="border:1px solid #999;" colspan="2">
        <code>Installation Process:<br />
        <?php
          # Set up new icons for admin menu
          $database->setQuery("UPDATE #__components SET admin_menu_img='../administrator/components/com_forme/images/logo.gif' WHERE admin_menu_link='option=com_forme'");
          $iconresult[0] = $database->query();
            if ($iconresult[0]) {
              echo "<font color='green'>FINISHED:</font> Image of menu entry has been corrected.<br />";
            } else {
              echo "<font color='red'>ERROR:</font> Image of menu entry $i could not be corrected.<br />";
            }



         if ($makedir = @mkdir("$mosConfig_absolute_path/components/com_forme/uploads/", 0777)) {
			echo "<font color='green'>FINISHED:</font> Directory /components/com_forme/uploads created. Write permissions have been set<br />";
		 } else {
		 	echo "<font color='red'><strong>Attention: Please set permissions to 0777 (write) to /components/com_forme/uploads</strong></font><br />";
		 }
        ?>
		<br><br>
   		<font color="green"><b>Joomla! RSform! 1.0.4 Installed Successfully!</b></font><br />
		Ensure that RSform! have write access in the above shown directories! Have Fun.<br />
		</code>
      </td>
    </tr>
  </table>
  <p style="text-align:left;">
  	<img src="../components/com_forme/images/rsform.gif"/><br/><br/>
		<b>RSform! Component for Joomla! CMS</b><br/>
© 2007 by <a href="http://www.rsjoomla.com" target="_blank">http://www.rsjoomla.com</a><br/>
All rights reserved.
<br/><br/>
This Joomla! Component has been released under a <a href="http://www.rsjoomla.com/license/forme.html" target="_blank">Commercial License</a>.<br/>
<em>Note: The Mambo CMS is not supported anymore starting with this release. This package works only on Joomla! 1.0.x</em>
<br/><br/>
<b>Load Sample Data</b><br/>
If you don't know how to start, be sure to check out the "Add Sample Data" menu option or <a href="index2.php?option=com_forme&task=sample">click here</a>
<br/><br/>
Thank you for using RSform!!
<br/><br/>
The rsjoomla.com team.
<br/><br/>
<a href="index2.php?option=com_forme"><big><strong>Continue</strong></big></a>
</p>
  </center>
  <?php
}
?>