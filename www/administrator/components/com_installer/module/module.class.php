<?php
/**
* @version $Id: module.class.php 10002 2008-02-08 10:56:57Z willebil $
* @package Joomla
* @subpackage Installer
* @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
* */

// no direct access
defined( '_VALID_MOS' ) or die( 'Restricted access' );

/**
* Module installer
* @package Joomla
*/
class mosInstallerModule extends mosInstaller {
	/**
	* Custom install method
	* @param boolean True if installing from directory
	*/
	function install( $p_fromdir = null ) {
		
		josSpoofCheck();
	
		global $mosConfig_absolute_path, $database;

		if (!$this->preInstallCheck( $p_fromdir, 'module' )) {
			return false;
		}

		$xmlDoc 	= $this->xmlDoc();
		$mosinstall =& $xmlDoc->documentElement;

		$client = '';
		if ($mosinstall->getAttribute( 'client' )) {
			$validClients = array( 'administrator' );
			if (!in_array( $mosinstall->getAttribute( 'client' ), $validClients )) {
				$this->setError( 1, 'Unknown client type ['.$mosinstall->getAttribute( 'client' ).']' );
				return false;
			}
			$client = 'admin';
		}

		// Set some vars
		$e = &$mosinstall->getElementsByPath( 'name', 1 );
		$this->elementName($e->getText());
		$this->elementDir( mosPathName( $mosConfig_absolute_path
			. ($client == 'admin' ? '/administrator' : '')
			. '/modules/' )
		);
		
		$e = &$mosinstall->getElementsByPath( 'position', 1 );
		if (!is_null($e)) {
			$position = $e->getText();
			
			if ($e->getAttribute( 'published' ) == '1') {
				$published = 1;
			} else {
				$published = 0;
			}
		} else {
			$position 	= 'left';
			$published 	= 0;
		}
		
		if ($this->parseFiles( 'files', 'module', 'Não existem arquivos identificados como Módulos' ) === false) {
			return false;
		}
		$this->parseFiles( 'images' );

		$client_id = intval( $client == 'admin' );
		// Insert in module in DB
		$query = "SELECT id FROM #__modules"
		. "\n WHERE module = " . $database->Quote( $this->elementSpecial() )
		. "\n AND client_id = " . (int) $client_id
		;
		$database->setQuery( $query );
		if (!$database->query()) {
			$this->setError( 1, 'SQL error: ' . $database->stderr( true ) );
			return false;
		}

		$id = $database->loadResult();

		if (!$id) {
			$row = new mosModule( $database );
			$row->title 		= $this->elementName();
			$row->ordering 		= 99;
			$row->published		= $published;
			$row->position 		= $position;
			$row->showtitle 	= 1;
			$row->iscore 		= 0;
			$row->access 		= $client == 'admin' ? 99 : 0;
			$row->client_id 	= $client_id;
			$row->module 		= $this->elementSpecial();

			$row->store();

			$query = "INSERT INTO #__modules_menu"
			. "\n VALUES ( " . (int) $row->id . ", 0 )"
			;
			$database->setQuery( $query );
			if(!$database->query()) {
				$this->setError( 1, 'Erro SQL : ' . $database->stderr( true ) );
				return false;
			}
		} else {
			$this->setError( 1, 'O módulo "' . $this->elementName() . '" já existe!' );
			return false;
		}
		if ($e = &$mosinstall->getElementsByPath( 'description', 1 )) {
			$this->setError( 0, $this->elementName() . '<p>' . $e->getText() . '</p>' );
		}

		return $this->copySetupFile('front');
	}
	/**
	* Custom install method
	* @param int The id of the module
	* @param string The URL option
	* @param int The client id
	*/
	function uninstall( $id, $option, $client=0 ) {
		global $database, $mosConfig_absolute_path;

		josSpoofCheck();

		$id = intval( $id );

		$query = "SELECT module, iscore, client_id"
		. "\n FROM #__modules WHERE id = " . (int) $id
		;
		$database->setQuery( $query );
		$row = null;
		$database->loadObject( $row );

		if ($row->iscore) {
			HTML_installer::showInstallMessage( $row->title .'é um elemento do sistema e não pode ser desinstalado.<br />Caso não o pretenda continuar a utilizar será necessário retirar de publicação', 'Desinstalar -  erro', $this->returnTo( $option, 'module', $row->client_id ? '' : 'admin' ) );
			exit();
		}

		$query = "SELECT id"
		. "\n FROM #__modules"
		. "\n WHERE module = " . $database->Quote( $row->module ) . " AND client_id = " . (int) $row->client_id
		;
		$database->setQuery( $query );
		$modules = $database->loadResultArray();

		if (count( $modules )) {
			mosArrayToInts( $modules );
			$modID = 'moduleid=' . implode( ' OR moduleid=', $modules );

			$query = "DELETE FROM #__modules_menu"
			. "\n WHERE ( $modID )"
			;
			$database->setQuery( $query );
			if (!$database->query()) {
				$msg = $database->stderr;
				die( $msg );
			}

    		$query = "DELETE FROM #__modules"
    		. "\n WHERE module = " . $database->Quote( $row->module ) . " AND client_id = " . (int) $row->client_id
    		;
    		$database->setQuery( $query );
    		if (!$database->query()) {
    			$msg = $database->stderr;
    			die( $msg );
    		}

    		if ( !$row->client_id ) {
    			$basepath = $mosConfig_absolute_path . '/modules/';
    		} else {
    			$basepath = $mosConfig_absolute_path . '/administrator/modules/';
    		}

      		$xmlfile = $basepath . $row->module . '.xml';

    			// see if there is an xml install file, must be same name as element
    		if (file_exists( $xmlfile )) {
    			$this->i_xmldoc = new DOMIT_Lite_Document();
    			$this->i_xmldoc->resolveErrors( true );

    			if ($this->i_xmldoc->loadXML( $xmlfile, false, true )) {
    				$mosinstall =& $this->i_xmldoc->documentElement;
    				// get the files element
    				$files_element =& $mosinstall->getElementsByPath( 'files', 1 );
    				if (!is_null( $files_element )) {
    					$files = $files_element->childNodes;
    					foreach ($files as $file) {
    						// delete the files
    						$filename = $file->getText();
    						if (file_exists( $basepath . $filename )) {
    							$parts = pathinfo( $filename );
    							$subpath = $parts['dirname'];
    							if ($subpath != '' && $subpath != '.' && $subpath != '..') {
    								echo '<br />Deletado: '. $basepath . $subpath;
    								$result = deldir(mosPathName( $basepath . $subpath . '/' ));
    							} else {
    								echo '<br />Deletado: '. $basepath . $filename;
    								$result = unlink( mosPathName ($basepath . $filename, false));
    							}
    							echo intval( $result );
    						}
    					}

    					// remove XML file from front
    					echo "Deletando arquivo XML: $xmlfile";
    					@unlink(  mosPathName ($xmlfile, false ) );
    					return true;
    				}
    			}
    		}
		}

	}
}
?>
