<?php
/**
* @package rssFactory
* @version 1.0
* @copyright www.thefactory.ro
* @license: commercial
*/ 
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

define(VERSION_ROOT,'http://thefactory.ro/versions/');

define(DOMIT_INCLUDE_PATH,$GLOBALS['mosConfig_absolute_path'].'/includes/domit/');
define(SITE_SAFE_MODE_ON,false);
if (@ini_get('safe_mode') == 1) define(SITE_SAFE_MODE_ON,true);

class component_version_info {
	var $latestversion=null;
	var $downloadlink=null;
	var $newsletter=null;
	var $announcements=null;
	var $releasenotes=null;
	var $_componentname=null;

	function component_version_info( $componentname ) {
		$this->_componentname=$componentname;
		$this->GetInfo();
	}
    function remote_read_url( $uri ) {

        if ( function_exists('curl_init') ){
            $handle = curl_init();

            curl_setopt ($handle, CURLOPT_URL, $uri);
            curl_setopt ($handle, CURLOPT_MAXREDIRS,5);
            curl_setopt ($handle, CURLOPT_AUTOREFERER, 1);
            curl_setopt ($handle, CURLOPT_FOLLOWLOCATION ,1);
            curl_setopt ($handle, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt ($handle, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt ($handle, CURLOPT_TIMEOUT, 100);
            $buffer = curl_exec($handle);

            curl_close($handle);
            return $buffer;
        } else  if ( ini_get('allow_url_fopen') ) {
            $fp = @fopen( $uri, 'r' );
            if ( !$fp )
                return false;
         	stream_set_timeout($fp, 20);
            $linea = '';
            while( $remote_read = fread($fp, 4096) )
                $linea .= $remote_read;
       		$info = stream_get_meta_data($fp);
            fclose($fp);
        	if ($info['timed_out'])
        	   return false;
            return $linea;
        } else {
           return false;
        }
    }
	function GetInfo() {
		require_once(DOMIT_INCLUDE_PATH . 'xml_domit_lite_parser.php');
		$xmldoc =& new DOMIT_Lite_Document();
		if (! SITE_SAFE_MODE_ON) set_time_limit(60);
		$filename=VERSION_ROOT.$this->_componentname.".xml";
		$fileContents =@$this->remote_read_url($filename);
		if (!$fileContents){
				require_once(DOMIT_INCLUDE_PATH . 'php_file_utilities.php');

				$fileContents =& php_file_utilities::getDataFromFile($filename, 'r');
		}
		$success=$xmldoc->parseXML($fileContents);

		if (!$success){
			return false;
		}
		$element= &$xmldoc->getElementsByPath('/version_info/latestversion', 1);
		$this->latestversion = $element ? $element->getText() : '';
		$element= &$xmldoc->getElementsByPath('/version_info/downloadlink', 1);
		$this->downloadlink =$element ? $element->getText() : '';
		$element= &$xmldoc->getElementsByPath('/version_info/newsletter', 1);
		$this->newsletter = $element ? $element->getText() : '';
		$element= &$xmldoc->getElementsByPath('/version_info/announcements', 1);
		$this->announcements = $element ? $element->getText() : '';
		$element= &$xmldoc->getElementsByPath('/version_info/notes', 1);
		$this->releasenotes = $element ? $element->getText() : '';
		return true;

	}
}
?>


