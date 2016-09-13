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

class menuAdsManager{
	function editMenu() {
		mosMenuBar::startTable();
		mosMenuBar::back();
		mosMenuBar::spacer();
		mosMenuBar::save('save');
		mosMenuBar::endTable();
	}
	
	function listItemMenu() {
		mosMenuBar::startTable();
		mosMenuBar::addNew('new');
		mosMenuBar::editList('edit', 'Edit');
		mosMenuBar::deleteList( ' ', 'delete', 'Remove' );
		mosMenuBar::endTable();
	}
	
	function listMenu() {
		mosMenuBar::startTable();
		mosMenuBar::addNew('new');
		mosMenuBar::editList('edit', 'Edit');
		mosMenuBar::deleteList( ' ', 'delete', 'Remove' );
		mosMenuBar::endTable();
	}	
}

?>