<?php
/**
 * mediaManager Class.
 * @author $Author: Ryan Demmer $
 * @version $Id: common.class.php 27 2005-09-14 17:51:00 Ryan Demmer $
 */
class mediaManager extends Manager
{
        /**
         * Constructor. Create a new Manager instance.
         * @param array $config configuration array, see config.inc.php
         * @param array $lang language array, see langs/en.php;
         * @param string $$mosConfig_live_site Joomla/Mambo configuration variable
         * @param string $$mosConfig_absolute_path Joomla/Mambo configuration variable
         */
        function mediaManager( $base_dir, $base_url )
        {
                $this->base_dir = $base_dir;
                $this->base_url = $base_url;
        }
		function id3Data( $path )
        {
            global $jce;
			require_once( $jce->getPluginPath() . '/classes/getid3/getid3.php' );
            clearstatcache();
            
            $dim = array('x'=>'', 'y'=>'', 'time'=>'');

            // Initialize getID3 engine
            $getID3 = new getID3();
            // Get information from the file
            $fileinfo = $getID3->analyze( $path );
            getid3_lib::CopyTagsToComments( $fileinfo );

            // Output results
            if ( !empty($fileinfo['video']['resolution_x'] ) ) {
                $dim['x'] = round( $fileinfo['video']['resolution_x'] );
            }
            if ( !empty( $fileinfo['video']['resolution_y'] ) ) {
                $dim['y'] = round( $fileinfo['video']['resolution_y'] );
            }
            if ( !empty( $fileinfo['playtime_string'] ) ) {
                $dim['time'] = $fileinfo['playtime_string'];
            }
            if( JFile::getExt( $path ) == 'swf' && $dim['x'] == '' ){
                $size = @getimagesize( $path );
                $dim['x'] = round( $size[0] );
                $dim['y'] = round( $size[1] );
            }
            return $dim;
        }
		function getProperties( $file )
		{
			global $jce;
			clearstatcache();
			
			$path = JPath::makePath( $this->getBaseDir(), urldecode( $file ) );
			$ext = JFile::getExt( $path );
			$dim = $this->id3Data( $path );
			
			$date = JCEUtils::formatDate( @filemtime( $path ) );
            $size = JCEUtils::formatSize( @filesize( $path ) );
			$width = ( !$dim['x'] ) ? '100' : $dim['x'];
            $height = ( !$dim['y'] ) ? '100' : $dim['y'];
            $time = ( !$dim['time'] ) ? '--:--' : $dim['time'];
						
			$html = '<div>' . $jce->translate('dimensions') . ': <span id="file_width">' . $width . '</span> x <span id="file_height">' . $height . '</span></div>';
			$html .= '<div>' . $jce->translate('duration') . ': ' . $time . '</div>';
			$html .= '<div>' . $jce->translate('size') . ': ' . $size . '</div>';
			$html .= '<div>' . $jce->translate('modified') . ': ' . $date . '</div>';
			
			return "<script>showProperties('" . $jce->ajaxHTML( $html ) . "','" . $width . "','" . $height . "');</script>";
		}
		function getDimensions( $file )
		{		
			$path = JPath::makePath( $this->getBaseDir(), urldecode( $file ) );
			$ext = JFile::getExt( $path );
			$dim = $this->id3Data( $path );
			
			$width = ( !$dim['x'] ) ? '100' : $dim['x'];
            $height = ( !$dim['y'] ) ? '100' : $dim['y'];
			
			return "<script>getDimensions('" . $ext . "','" . $width . "','" . $height . "');</script>";
		}
}
?>
