<?php
/**
* swmenufree v4.0
* http://swonline.biz
* Copyright 2006 Sean White
**/

function com_uninstall()
{
	global $mosConfig_absolute_path;
      
	$retstr = swmenufreeRemove();
    if(file_exists($mosConfig_absolute_path."/modules/mod_swmenufree.php")){
		unlink($mosConfig_absolute_path."/modules/mod_swmenufree.php");
		sw_deldir($mosConfig_absolute_path."/modules/mod_swmenufree");
	}
	if(file_exists($mosConfig_absolute_path."/modules/mod_swmenufree.xml")){
		unlink($mosConfig_absolute_path."/modules/mod_swmenufree.xml");
	}
        return "swMenuFree uninstalled succesfully<br /> $retstr";
}
      


function swmenufreeRemove () {
        global $database;
        $retstr = '';

        $query = "SELECT id, title, module, params FROM #__modules WHERE module='mod_swmenufree'";

        $database->setQuery( $query );
        $modules = $database->loadObjectList();
        if ($database->getErrorNum()) {
                $retstr .= "MA ".$database->stderr(true);
                return $retstr;
        }
        foreach ($modules as $module) {
               
                $sql = "DELETE FROM #__modules WHERE id='$module->id'";
                $database->setQuery($sql);
                $database->query();
        }
        return $retstr;
}

function sw_deldir( $dir ) {
	$handle = opendir($dir);
  	     while (false!==($item = readdir($handle)))
  	     {
  	         if($item != '.' && $item != '..')
  	         {
  	             if(is_dir($dir.'/'.$item)) 
  	             {
  	                 sw_deldir($dir.'/'.$item);
  	             }else{
  	                 unlink($dir.'/'.$item);
  	             }
  	         }
  	     }
  	     closedir($handle);
  	     if(rmdir($dir))
  	     {
  	         $success = true;
  	     }
  	     return $success;
  	 }

?>

