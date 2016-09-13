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

// Include supporting libraries
jpimport('classes.core.utility.altinstaller');
jpimport('helpers.logger');

/**
 * The revamped JoomlaPack configuration class.
 * Highlights: it is based on JObject, saves and loads serialized data to an XML file
 */
class JoomlapackConfiguration
{
	// @todo Make JoomlapackConfiguration a descendant of JObject in JP1.3

	/* ----------------------------------------------------------------------
	 * JObject code, copied from Joomla! 1.5.3 implementation 
	 * ----------------------------------------------------------------------
	 */
	
	/**
	 * A hack to support __construct() on PHP 4.
	 *
	 * @access	public
	 * @return	JoomlapackConfiguration
	 */
	function JoomlapackConfiguration()
	{
		$args = func_get_args();
		call_user_func_array(array(&$this, '__construct'), $args);
	}
	
	/**
	 * Returns a property of the object or the default value if the property is not set.
	 *
	 * @access	public
	 * @param	string $property The name of the property
	 * @param	mixed  $default The default value
	 * @return	mixed The value of the property
	 * @see		getProperties()
 	 */
	function get($property, $default=null)
	{
		if(isset($this->$property)) {
			return $this->$property;
		}
		return $default;
	}

	/**
	 * Returns an associative array of object properties
	 *
	 * @access	public
	 * @param	boolean $public If true, returns only the public properties
	 * @return	array
	 * @see		get()
 	 */
	function getProperties( $public = true )
	{
		$vars  = get_object_vars($this);

        if($public)
		{
			foreach ($vars as $key => $value)
			{
				if ('_' == substr($key, 0, 1)) {
					unset($vars[$key]);
				}
			}
		}

        return $vars;
	}
	
	/**
	 * Modifies a property of the object, creating it if it does not already exist.
	 *
	 * @access	public
	 * @param	string $property The name of the property
	 * @param	mixed  $value The value of the property to set
	 * @return	mixed Previous value of the property
	 * @see		setProperties()
	 */
	function set( $property, $value = null )
	{
		$previous = isset($this->$property) ? $this->$property : null;
		$this->$property = $value;
		return $previous;
	}

	/**
	* Set the object properties based on a named array/hash
	*
	* @access	protected
	* @param	$array  mixed Either and associative array or another object
	* @return	boolean
	* @see		set()
	*/
	function setProperties( $properties )
	{
		$properties = (array) $properties; //cast to an array

		if (is_array($properties))
		{
			foreach ($properties as $k => $v) {
				$this->$k = $v;
			}

			return true;
		}

		return false;
	}

	/**
	 * Object-to-string conversion.
	 * Each class can override it as necessary.
	 *
	 * @access	public
	 * @return	string This name of this class
 	 */
	function toString()
	{
		return get_class($this);
	}
	
	/* ----------------------------------------------------------------------
	 * The actual JoomlapackConfiguration implementation
	 * ----------------------------------------------------------------------
	 */
	
	/**
	 * The instance of JoomlapackAltInstaller, holding the selected alternative installer selection
	 *
	 * @var JoomlapackAltInstaller
	 */
	var $AltInstaller = null;
	
	/**
	 * Singleton implementation
	 *
	 * @return JoomlapackConfiguration
	 */
	function &getInstance()
	{
		static $instance;

		if( !is_object($instance) )
		{
			$instance = new JoomlapackConfiguration();
		}
		
		return $instance;
	}

	/**
	 * Class constructor
	 * @access private
	 * @return JoomlapackConfiguration
	 */
	function __construct()
	{
		$this->LoadConfiguration();
	}
	
	/**
	 * Tries to load config xml and return a DOMIT Lite object to the caller. If the file is unreadable,
	 * or it doesn't exist, it returns null
	 *
	 * @return DOMIT_Lite_Document The DOMIT Lite document object representing config xml
	 */
	function _getDOMObject()
	{
		static $domObject;
		static $isReadable;
		
		if( !$this->hasConfiguration() )
		{
			$isReadable = false;
		}
		
		if( isset($isReadable) )
		{
			if(!$isReadable)
			{
				$domObject = null;
			}
			return $domObject;
		}
		
		require_once( JPATH_SITE.DS.'includes'.DS.'domit'.DS.'xml_domit_lite_include.php' );
		$domObject = new DOMIT_Lite_Document();
		$domObject->resolveErrors( true );
		
		if ( $domObject->loadXML( $this->getConfigFilename(), false, true ) ) {
			$isReadable = true;
			return $domObject;
		} else {
			$isReadable = false;
			$domObject = null;
			return $domObject;
		}
	}

	/**
	 * Retrieves a setting from the XML file and stores it in the object's public properties
	 *
	 * @param string $name The key to retreive
	 * @param mixed $default Default value, to be returned if there's no config xml, it is unreadable
	 * or the key doesn't exist
	 */
	function _getSetting($name, $default)
	{
		// Try to get a DOM document instance
		$domDoc = $this->_getDOMObject();

		// If the file was unreadable, return the default value
		if( is_null($domDoc) )
		{
			$this->set($name, $default);
			return; 
		}
		
		// Try navigating to selected item
		$root = &$domDoc->documentElement;
		$e = &$root->getElementsByPath($name, 1);
		
		// If the element doesn't exist, return the default
		if( is_null($e) )
		{
			$this->set($name, $default);
		} else {
			$this->set($name, unserialize($e->getText()) );
		}
	}
	
	/**
	 * Loads the configuration off the disk, populating missing values with defaults
	 */
	function LoadConfiguration()
	{
		// Load the configuration from disk (or populate with default values)
		$this->_getSetting('OutputDirectory',	JPATH_COMPONENT_ADMINISTRATOR.DS.'backup');
		$this->_getSetting('TempDirectory',		JPATH_COMPONENT_ADMINISTRATOR.DS.'backup');
		$this->_getSetting('MySQLCompat',		'default');
		$this->_getSetting('listerengine',		'default');
		$this->_getSetting('dbdumpengine',		'default');
		$this->_getSetting('packerengine',		'zip');
		$this->_getSetting('TarNameTemplate',	'site-[HOST]-[DATE]-[TIME]');
		$this->_getSetting('dbAlgorithm',		'smart');
		$this->_getSetting('packAlgorithm',		'smart');
		if(defined('_JEXEC'))
		{
			// Use JPI3 by default on Joomla! 1.5.x installations
			$this->_getSetting('InstallerPackage',	'jpi3.xml');			
		}
		else
		{
			// Use JPI2 by default on Joomla! 1.0.x installations
			$this->_getSetting('InstallerPackage',	'jpi2.xml');
		}
		
		$this->_getSetting('logLevel',			_JP_LOG_WARNING);
		$this->_getSetting('backupMethod',		'ajax');
		$this->_getSetting('enableFrontend',	false);
		$this->_getSetting('secretWord',		'');
		$this->_getSetting('enableMySQLKeepalive', false);
		// MAGIC NUMBERS section
		// -- Default lister
		$this->_getSetting('mnRowsPerStep',		100);
		$this->_getSetting('mnMaxFragmentSize', 1048756);
		$this->_getSetting('mnMaxFragmentFiles', 50);
		// -- Archivers ZIP and JPA
		$this->_getSetting('mnZIPForceOpen', false); // If true, don't use file_get_contents
		$this->_getSetting('mnZIPCompressionThreshold', 1024768);
		$this->_getSetting('mnZIPDirReadChunk', 1024768);
		// -- Smart algorithm
		$this->_getSetting('mnMaxExecTimeAllowed', 14);
		$this->_getSetting('mnMinimumExectime', 2);
		$this->_getSetting('mnExectimeBiasPercent', 75);
		// mysqldump db dumper
		$this->_getSetting('mysqldumpPath', '/usr/bin/mysqldump');
		$this->_getSetting('mnMSDDataChunk', 16384);
		$this->_getSetting('mnMSDMaxQueryLines', 300);
		$this->_getSetting('mnMSDLinesPerSession', 100);
		
		// For site root change detection
		$this->_getSetting('siteRoot', JPATH_SITE);
		
		// Post-processing
		$this->set('OutputDirectory', JoomlapackAbstraction::TranslateWinPath( $this->get('OutputDirectory') ) );
		$this->set('TempDirectory', JoomlapackAbstraction::TranslateWinPath( $this->get('TempDirectory') ) );
		$this->AltInstaller = new JoomlapackAltInstaller();
		$this->AltInstaller->loadDefinition( $this->get('InstallerPackage') );
	}
	
	/**
	 * Saves the configuration to disk
	 *
	 * @return boolean True, if the file was written successfully
	 */
	function SaveConfiguration()
	{
		if( !$this->isConfigurationWriteable() ) { return false; }
		
		$xml = '<?xml version="1.0" encoding="utf-8"?>' . "\n" . '<config>' . "\n";
		
		$props = $this->getProperties(true);
		foreach($props as $key => $value)
		{
			if( $key == 'AltInstaller' ) continue;
			$xml .= "\t<$key><![CDATA[" . serialize($value) . "]]></$key>\n";
		}
		
		$xml .= "</config>\n";
		
		$fp = @fopen($this->getConfigFilename(), "w");
		if ($fp === false) { return false; }
		fputs($fp, $xml);
		fclose($fp);
		return true;
	}
	
	function SaveFromPost()
	{
		$this->_setFromPOST('OutputDirectory',		'outdir',				'');
		$this->_setFromPOST('TempDirectory',		'tempdir',				'');
		$this->_setFromPOST('MySQLCompat',			'sqlcompat',			'');
		$this->_setFromPOST('listerengine',			'listerengine',			'');
		$this->_setFromPOST('dbdumpengine',			'dbdumpengine',			'');
		$this->_setFromPOST('packerengine',			'packerengine',			'');
		$this->_setFromPOST('TarNameTemplate',		'tarname',				'');
		$this->_setFromPOST('dbAlgorithm',			'dbAlgorithm',			'smart');
		$this->_setFromPOST('packAlgorithm',		'packAlgorithm',		'smart');
		$this->_setFromPOST('InstallerPackage',		'altInstaller',			'jpi2.xml');
		$this->_setFromPOST('logLevel',				'logLevel',				'3');
		$this->_setFromPOST('backupMethod',			'backupMethod',			'ajax');
		$this->_setFromPOST('enableMySQLKeepalive',	'enableMySQLKeepalive',	false, true);
		$this->_setFromPOST('enableFrontend',		'enableFrontend',		false, true);
		$this->_setFromPOST('secretWord',			'secretWord',			'');
		// MAGIC NUMBERS section
		$this->_setFromPOST('mnRowsPerStep',		'mnRowsPerStep',		100);
		$this->_setFromPOST('mnMaxFragmentSize',	'mnMaxFragmentSize',	1048756);
		$this->_setFromPOST('mnMaxFragmentFiles',	'mnMaxFragmentFiles',	50);
		$this->_setFromPOST('mnZIPForceOpen',		'mnZIPForceOpen',		false, true);
		$this->_setFromPOST('mnZIPCompressionThreshold', 'mnZIPCompressionThreshold', 1024768);
		$this->_setFromPOST('mnZIPDirReadChunk',	'mnZIPDirReadChunk', 	1024768);
		$this->_setFromPOST('mnMaxExecTimeAllowed',	'mnMaxExecTimeAllowed',	14);
		$this->_setFromPOST('mnMinimumExectime',	'mnMinimumExectime',	2);
		$this->_setFromPOST('mnExectimeBiasPercent','mnExectimeBiasPercent',75);
		// mysqldump db dumper
		$this->_setFromPOST('mysqldumpPath','mysqldumpPath','/usr/bin/mysqldump');
		$this->_setFromPOST('mnMSDDataChunk','mnMSDDataChunk',16384);
		$this->_setFromPOST('mnMSDMaxQueryLines','mnMSDMaxQueryLines',300);
		$this->_setFromPOST('mnMSDLinesPerSession','mnMSDLinesPerSession',100);
		
		// For site root change detection
		$this->set('siteRoot', $this->_getSetting('siteRoot', JPATH_SITE) );
		
		$this->SaveConfiguration(); // This only TRIES to save the configuration
		$this->LoadConfiguration(); // Enforce reloading of configuration upon saving		
	}
	
	function _setFromPOST($name, $postkey, $default, $isCheckbox = false)
	{
		$value = $isCheckbox ? (JoomlapackAbstraction::getParam($postkey, $default) == 'on' ? true : false) : JoomlapackAbstraction::getParam($postkey, $default);
		$this->set($name, $value);
	}
	
	/**
	* Returns true if config xml is present
	* @return boolean
	*/
	function hasConfiguration() {
		return file_exists($this->getConfigFilename());
	}

	/**
	* Returns true if config xml is writable
	* @return boolean
	*/
	function isConfigurationWriteable() {
		if( $this->hasConfiguration() ) {
			return is_writable($this->getConfigFilename());
		} else {
			return is_writable(JPATH_COMPONENT_ADMINISTRATOR);
		}
	}
	
	/**
	* Returns true if the output target directory is writeable by the PHP script
	* @return boolean
	*/
	function isOutputWriteable() {
		return is_writable($this->get('OutputDirectory'));
	}

	/**
	* Returns true if the temporary files directory is writeable by the PHP script
	* @return boolean
	*/
	function isTempWriteable() {
		return is_writable($this->get('TempDirectory'));
	}
	
	function getConfigFilename()
	{
		return JPATH_COMPONENT_ADMINISTRATOR.DS."jpack.config.xml";
	}
}