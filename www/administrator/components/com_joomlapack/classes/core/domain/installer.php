<?php
/**
* @package		JoomlaPack
* @copyright	Copyright (C) 2006-2008 JoomlaPack Developers. All rights reserved.
* @version		$Id$
* @license 	http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @since		1.2.1
*
* JoomlaPack is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
**/

// ensure this file is being included by a parent file - Joomla! 1.0.x and 1.5 compatible
(defined( '_VALID_MOS' ) || defined('_JEXEC')) or die( 'Direct Access to this location is not allowed.' );

/**
 * Installer deployment engine
 */
class JoomlapackDomainInstaller extends JoomlapackEngineParts
{
	
	var $_offset;
	
	function JoomlapackDomainInstaller()
	{
		$this->_DomainName = "installer";
		JoomlapackLogger::WriteLog(_JP_LOG_DEBUG, __CLASS__ . ":: New instance");		
	}
	
	/**
	 * Implements the _prepare abstract method
	 *
	 */
	function _prepare()
	{
		// Nothing to do
		$this->_currentListIndex = 0;
		$this->_isPrepared = true;
		$this->_hasRan = false;
	}
	
	/**
	 * Implements the _run() abstract method
	 */
	function _run()
	{
		if( $this->_hasRan )
		{
			JoomlapackLogger::WriteLog(_JP_LOG_DEBUG, "JoomlapackDomainDBBackup :: Already finished");
			$this->_isRunning = false;
			$this->_hasRan = true;
			$this->_Step = '';
			$this->_Substep = '';			
		} else {
			$this->_isRunning = true;
			$this->_hasRan = false;			
		}
		
		// Try to step the archiver
		$cube =& JoomlapackCUBE::getInstance();
		$archive =& $cube->getArchiverEngine();
		$ret = $archive->transformJPA($this->_offset);
		// Error propagation
		if(($ret === false) || ($archive->hasError()))
		{
			$this->setError($archive->getError(), true);
		}
		else
		{
			$this->_offset = $ret['offset'];
			$this->_Step = $ret['filename'];
		}
		// Warnings propagation
		if($archive->hasWarning())
		{
			$this->setWarning($archive->getWarning(), true);
		}
		
		// Check for completion
		if($ret['done'])
		{
			JoomlapackLogger::WriteLog(_JP_LOG_DEBUG, __CLASS__.":: archive is initialized");
			$this->_hasRan = true;
			$this->_isRunning = false;
		}
	}
	
	/**
	 * Implements the _finalize() abstract method
	 *
	 */
	function _finalize()
	{
		$this->_isFinished = true;
	}
	
}

?>