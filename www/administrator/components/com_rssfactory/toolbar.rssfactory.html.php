<?php
/**
* @package rssFactory
* @version 1.0
* @copyright www.thefactory.ro
*/ 
/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

class TOOLBAR_RSSReader {
	function _EDIT() {
		mosMenuBar::startTable();
		mosMenuBar::save();
		mosMenuBar::cancel();
		mosMenuBar::endTable();
	}
	function _DEFAULT() {
		mosMenuBar::startTable();
		mosMenuBar::publishList();
		mosMenuBar::unpublishList();
        mosMenuBar::custom( 'importcsv', '../../components/com_rssfactory/images/import.png', '../../components/com_rssfactory/images/import.png', 'Import CSV', false );		
        mosMenuBar::custom( 'backup', '../../components/com_rssfactory/images/backup.png', '../../components/com_rssfactory/images/backup_f2.png', 'Backup', false );		
        mosMenuBar::custom( 'restore', '../../components/com_rssfactory/images/repository.png', '../../components/com_rssfactory/images/repository_f2.png', 'Restore', false );		
		mosMenuBar::addNew();
		mosMenuBar::editList();
		mosMenuBar::deleteList();
		mosMenuBar::endTable();
	}
	function _EDITADS() {
		mosMenuBar::startTable();
		mosMenuBar::save('saveads');
		mosMenuBar::cancel();
		mosMenuBar::endTable();
	}
	function _EDITCONFIG() {
		mosMenuBar::startTable();
		mosMenuBar::save('saveconfig');
		mosMenuBar::cancel();
		mosMenuBar::endTable();
	}
	function _ADLIST() {
		mosMenuBar::startTable();
		mosMenuBar::publishList('publishads');
		mosMenuBar::unpublishList('unpublishads');
		mosMenuBar::addNew('newads');
		mosMenuBar::editList('editads');
		mosMenuBar::deleteList('','removeads');
		mosMenuBar::endTable();
	}
	function _IMPORTCSV(){
		mosMenuBar::startTable();
		mosMenuBar::save('savecsv');
		mosMenuBar::cancel();
		mosMenuBar::endTable();
        
    }
    function _BACKUP(){
    	mosMenuBar::startTable();
		mosMenuBar::save('backup');
		mosMenuBar::cancel();
		mosMenuBar::endTable();
    }
	function _RESTOREBACKUP(){
		mosMenuBar::startTable();
		mosMenuBar::save('restorebackup');
		mosMenuBar::cancel();
		mosMenuBar::endTable();
        
    }
	function _CATMAN(){
		mosMenuBar::startTable();
		mosMenuBar::save('savecats');
		mosMenuBar::cancel();
		mosMenuBar::endTable();
    }
	
}
?>
