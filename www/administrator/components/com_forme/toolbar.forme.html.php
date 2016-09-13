<?php
/**
* @version 1.0.4
* @package RSform! 1.0.4
* @copyright (C) 2007 www.rsjoomla.com
* @license Commercial License, http://www.rsjoomla.com/license/forme.html
*/

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

class menuforme {


	function _DEFAULT(){
		global $mosConfig_live_site;
		mosMenuBar::startTable();
		mosMenuBar::spacer();
		mosMenuBar::custom( 'support', 'help.png', 'help_f2.png', _FORME_BACKEND_TOOLBAR_SUPPORT, false );
		mosMenuBar::spacer();
		mosMenuBar::custom( '', 'preview.png', 'preview_f2.png', _FORME_BACKEND_TOOLBAR_MAIN, false );
		mosMenuBar::endTable();
	}

	function INFO_MENU()
	{
		mosMenuBar::startTable();
		mosMenuBar::back();
		mosMenuBar::endTable();
	}

	function EDIT_MENU()
	{
		mosMenuBar::startTable();
		mosMenuBar::save();
		mosMenuBar::spacer();
		mosMenuBar::cancel();
		mosMenuBar::spacer();
		mosMenuBar::custom( 'support', 'help.png', 'help_f2.png', _FORME_BACKEND_TOOLBAR_SUPPORT, false );
		mosMenuBar::spacer();
		mosMenuBar::custom( '', 'preview.png', 'preview_f2.png', _FORME_BACKEND_TOOLBAR_MAIN, false );
		mosMenuBar::endTable();
	}

	function SETTINGS_MENU()
	{
		mosMenuBar::startTable();
		mosMenuBar::save('saveset');
		mosMenuBar::spacer();
		mosMenuBar::cancel('cancel');
		mosMenuBar::spacer();
		mosMenuBar::custom( 'support', 'help.png', 'help_f2.png', _FORME_BACKEND_TOOLBAR_SUPPORT, false );
		mosMenuBar::spacer();
		mosMenuBar::custom( '', 'preview.png', 'preview_f2.png', _FORME_BACKEND_TOOLBAR_MAIN, false );
		mosMenuBar::endTable();
	}

	function LISTFORMS_MENU()
	{
		mosMenuBar::startTable();
		mosMenuBar::addNewX('newform');
		mosMenuBar::spacer();
		mosMenuBar::custom( 'forms.copy', 'copy.png', 'copy_f2.png', _FORME_BACKEND_TOOLBAR_DUPLICATE, false );
		mosMenuBar::spacer();
		mosMenuBar::deleteList( ' ', 'deleteform', _FORME_BACKEND_TOOLBAR_REMOVE );
		mosMenuBar::spacer();
		mosMenuBar::publishList('publishform');
		mosMenuBar::spacer();
		mosMenuBar::unpublishList('unpublishform');
		mosMenuBar::spacer();
		mosMenuBar::custom( 'support', 'help.png', 'help_f2.png', _FORME_BACKEND_TOOLBAR_SUPPORT, false );
		mosMenuBar::spacer();
		mosMenuBar::custom( '', 'preview.png', 'preview_f2.png', _FORME_BACKEND_TOOLBAR_MAIN, false );
		mosMenuBar::endTable();
	}

	function EDITFORM_MENU()
	{
		global $cid;

		mosMenuBar::startTable();
		if($cid) mosMenuBar::addNewX('newfield',_FORME_BACKEND_TOOLBAR_NEWFIELD);
		if($cid) mosMenuBar::spacer();
		if($cid) mosMenuBar::custom( 'fields.copy.screen', 'copy.png', 'copy_f2.png', _FORME_BACKEND_TOOLBAR_DUPLICATE, false );
		if($cid) mosMenuBar::spacer();
		if($cid) mosMenuBar::deleteList( ' ', 'deletefield', _FORME_BACKEND_TOOLBAR_REMOVE );
		if($cid) mosMenuBar::spacer();
		mosMenuBar::save('saveform');
		mosMenuBar::apply('applyform');
		mosMenuBar::spacer();
		mosMenuBar::cancel('cancelform',_FORME_BACKEND_TOOLBAR_CLOSE);
		mosMenuBar::spacer();
		mosMenuBar::custom( 'support', 'help.png', 'help_f2.png', _FORME_BACKEND_TOOLBAR_SUPPORT, false );
		mosMenuBar::spacer();
		mosMenuBar::custom( '', 'preview.png', 'preview_f2.png', _FORME_BACKEND_TOOLBAR_MAIN, false );
		mosMenuBar::endTable();
	}
	function EDITFIELD_MENU()
	{
		mosMenuBar::startTable();
		mosMenuBar::save('savefield');
		mosMenuBar::apply('applyfield');
		mosMenuBar::spacer();
		mosMenuBar::cancel('cancelfield',_FORME_BACKEND_TOOLBAR_CLOSE);
		mosMenuBar::spacer();
		mosMenuBar::custom( 'support', 'help.png', 'help_f2.png', _FORME_BACKEND_TOOLBAR_SUPPORT, false );
		mosMenuBar::spacer();
		mosMenuBar::custom( '', 'preview.png', 'preview_f2.png', _FORME_BACKEND_TOOLBAR_MAIN, false );
		mosMenuBar::endTable();
	}

	function LISTDATA_MENU()
	{
		mosMenuBar::startTable();
		mosMenuBar::archiveList('exportdata',_FORME_BACKEND_TOOLBAR_EXPORT);
		mosMenuBar::custom('exportalldata','archive_f2.png','archive_f2.png',_FORME_BACKEND_TOOLBAR_EXPORT_ALL,false);
		mosMenuBar::back('Back','index2.php?option=com_forme&task=forms');
		mosMenuBar::deleteList('','deldata');
		mosMenuBar::spacer();
		mosMenuBar::custom( 'support', 'help.png', 'help_f2.png', _FORME_BACKEND_TOOLBAR_SUPPORT, false );
		mosMenuBar::spacer();
		mosMenuBar::custom( '', 'preview.png', 'preview_f2.png', _FORME_BACKEND_TOOLBAR_MAIN, false );
		mosMenuBar::endTable();
	}
	function UPDATE(){
		mosMenuBar::startTable();
		mosMenuBar::apply('update',_FORME_BACKEND_TOOLBAR_UPDATE);
		mosMenuBar::spacer();
		mosMenuBar::custom( 'support', 'help.png', 'help_f2.png', _FORME_BACKEND_TOOLBAR_SUPPORT, false );
		mosMenuBar::spacer();
		mosMenuBar::custom( '', 'preview.png', 'preview_f2.png', _FORME_BACKEND_TOOLBAR_MAIN, false );
		mosMenuBar::endTable();
	}

	function FIELDS_COPY_SCREEN(){
		mosMenuBar::startTable();
		mosMenuBar::spacer();
		mosMenuBar::custom( 'fields.copy', 'copy.png', 'copy_f2.png', _FORME_BACKEND_TOOLBAR_DUPLICATE, false );
		mosMenuBar::spacer();
		mosMenuBar::cancel('fields.copy.cancel',_FORME_BACKEND_TOOLBAR_CLOSE);
		mosMenuBar::spacer();
		mosMenuBar::custom( 'support', 'help.png', 'help_f2.png', _FORME_BACKEND_TOOLBAR_SUPPORT, false );
		mosMenuBar::spacer();
		mosMenuBar::custom( '', 'preview.png', 'preview_f2.png', _FORME_BACKEND_TOOLBAR_MAIN, false );
		mosMenuBar::endTable();
	}
}

?>