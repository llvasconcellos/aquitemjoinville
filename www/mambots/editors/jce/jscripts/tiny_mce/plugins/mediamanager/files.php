<?php
/**
 * Show a list of files.
 * @author $Author: Ryan Demmer $
 * @version $Id: files.php 27 2006-03-06 10:25:57Z Ryan Demmer $
 * @package FileManager
 */
defined( '_VALID_MOS' ) or die( 'Restricted Access.' );

$version = "1.1.5";

require_once( $mainframe->getCfg('absolute_path') . '/mambots/editors/jce/jscripts/tiny_mce/libraries/classes/jce.class.php' );
require_once( $mainframe->getCfg('absolute_path') . '/mambots/editors/jce/jscripts/tiny_mce/libraries/classes/jce.utils.class.php' );

$jce = new JCE();
$jce->setPlugin('mediamanager');

require_once( $jce->getPluginPath() . '/classes/manager.class.php' );

//Setup languages
$lang = $jce->getLanguage();
$plang = $jce->getPluginLanguage();
include_once( $jce->getLibPath() . '/langs/' . $lang . '.php' );
include_once(  $jce->getPluginPath() . '/langs/' . $plang . '.php' );

//Load Plugin Parameters
$params = $jce->getPluginParams();

/*Get variables
 *param $curr_dir The relative path passed
 *param $ret_file The relative file returned from the editor
*/
$curr_dir = rawurldecode( mosGetParam( $_REQUEST, 'dir', '/' ) );
$ret_file = mosGetParam( $_REQUEST, 'ret_file', false );

//User Directory Restrictions
//Get base directory and base url from config setings
$base_dir = $jce->getBaseDir( false );
$base_url = $base_dir;

//Check to see if the returned file is within the users allowed directory tree
if( !JFolder::exists( JPath::makePath( JPath::makePath( $mainframe->getCfg('absolute_path'), $base_dir ), $curr_dir ) ) && $ret_file ){
	//If not, set $ret_file to false (even if there is one) and reset $curr_dir.
     $ret_file = false;
     $curr_dir = '/';
}
//End User Directory Restrictions
$manager = new mediaManager( $base_dir, $base_url );

//If a returned file exists, create the path to the current dir
if( $ret_file ){
    $ret_file = JPath::makePath( $curr_dir, $ret_file );
}
//Setup allowed extensions and file size settings
$ext_list = 'swf,flv,dcr,mov,qt,mpg,mp3,mp4,mpeg,avi,wmv,wm,asf,asx,wmx,wvx,rm,ra,ram';
$filter = '\.('.str_replace( ',', '|', $ext_list ).')$';
$max_size = intval( $params->get( 'max_size', '2048' ) )*1024;

//process file actions
$opt = mosGetParam( $_REQUEST, 'opt' );
switch( $opt ){
    case 'new_folder':
        $new_dir = mosGetParam( $_REQUEST, 'newd' );
        $error = $manager->newFolder( $curr_dir, $new_dir );
    break;
    case 'del_folder':
        $folder = mosGetParam( $_REQUEST, 'deld' );
        $error = $manager->deleteFolder( $folder );
    break;
    case 'del_file':
        $files = mosGetParam( $_REQUEST, 'delf' );
        $error = $manager->deleteFiles( $files );
    break;
    case 'copy_file':
        $copy_file = mosGetParam( $_REQUEST, 'copyf' );
        $dest = mosGetParam( $_REQUEST, 'dest' );
        $error = $manager->copy( $copy_file, $dest );
    break;
    case 'move_file':
        $move_file = mosGetParam( $_REQUEST, 'movef' );
        $dest = mosGetParam( $_REQUEST, 'dest' );
        $error = $manager->move( $move_file, $dest );
    break;
    case 'rename_file':
        $ren_file = mosGetParam( $_REQUEST, 'renf' );
        $new_file = mosGetParam( $_REQUEST, 'newf' );
        $error = $manager->renameFile( $ren_file, $new_file );
    break;
    case 'rename_folder':
        $ren_dir = mosGetParam( $_REQUEST, 'rend' );
        $new_dir = mosGetParam( $_REQUEST, 'newd' );
        $error = $manager->renameDir( $ren_dir, $new_dir );
    break;
    default:
        $error = false;
    break;
}
//Process uploads
$upload_file = mosGetParam( $_FILES, 'upload', false );
if( $upload_file ){
	$curr_dir = rawurldecode( mosGetParam( $_POST, 'dirPath' ) );
	$name = mosGetParam( $_POST, 'upload_name' );
    $overwrite = mosGetParam( $_POST, 'overwrite' );
    $curr_dir = rawurldecode( mosGetParam( $_POST, 'dirPath' ) );
    $error = $manager->doUpload( $curr_dir, $upload_file, $name, $ext_list, $max_size, $overwrite );
}
//Get the files and directories
$file_list = $manager->getFiles( $curr_dir, $filter );
$dir_list = $manager->getFolders( $curr_dir );

//Draw the file list
function drawFiles( $file_list, $manager )
{
        global $jce, $ext_list;
        $f = 0;
		foreach( $file_list as $file )
        {              	
			$ext = strtolower( $file['ext'] );
			$name = $file['short_name'];
			$shrtname = substr($name, 0, 50);
			$extlist = explode( ',', $ext_list );
			
			$mov = array('mov','qt','mp3','mp4');
			$wmv = array('mpg','mpeg','avi','wmv','wm','asf','asx','wmx','wvx');
			$rm = array('rm', 'ra', 'ram');
		
			if( in_array( $ext, $mov ) ) $ext = 'mov';
			if( in_array( $ext, $wmv ) ) $ext = 'wmv';
			if( in_array( $ext, $rm ) ) $ext = 'rm';		   
			
			$file_ext = $jce->getFileIcon( $ext );
			$id = "f".$f;
			?>
			<div class="divList" id="<?php echo $id;?>" title="<?php echo $file['name'];?>">
				<img src="<?php echo $file_ext;?>" alt="<?php echo $ext; ?>" height="16" width="16" style="vertical-align:middle;" />
				<a href="javascript:parent.selectFile('<?php echo $id;?>');" title="<?php echo $name;?>"><?php echo $file['name'];?></a>
			</div>
        <?php 
			$f++;
		}
}
//Draw the directory list
function drawDirs( $dir_list, $manager )
{
	global $jce, $filter;
	$d = 0;
    foreach( $dir_list as $dir ) {
    	$fullpath = JPath::makePath( $manager->getBaseDir(), $dir['relative'] );
		$id = "d".$d;
        ?>
        <div class="divList" id="<?php echo $id;?>" title="<?php echo $dir['name'];?>">
			<img src="<?php echo $jce->getLibImg('folder.gif');?>" title="<?php echo $jce->translate('folder'); ?>" alt="<?php echo $jce->translate('folder');?>" height="16" width="16" style="vertical-align:middle;" />
            <a href="javascript:void(0);" onClick="parent.changeDir('<?php echo $dir['relative'];?>');return false;" title="<?php echo $dir['name']; ?>"><?php echo $dir['name']; ?></a>
       </div>
       <?php
	   		$d++;
   } //foreach
}
//No result - no files found
function noFiles()
{
    global $jce;?>
    <div class="noResult">
        <?php echo $jce->translate('no_files'); ?>
    </div>
<?php
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $jce->translate('file_list');?></title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $jce->translate('iso');?>" />
<?php
	echo $jce->printLibJs( 'mootools_basic' );
	echo $jce->printLibJs( 'files' );
	echo $jce->printLibCss( 'files' );
?>
<script type="text/javascript">
/*<![CDATA[*/     
	function init(){
		var p = parent.document;
		parent.resetManager();
        parent.showMessage("<?php echo htmlspecialchars( $jce->translate('select_text') );?>", 'info.gif', 'msg');
		p.getElementById('treeDetails').innerHTML = '';
		//dirlist
		<?php $dirs = $manager->getDirs();?>
		var html = '';
		html += '<select class="dirWidth" name="dirPath" id="dirPath" onchange="updateDir(this)">';
        html += '<option value="/">/</option>';
        <?php foreach( $dirs as $dir ){
        	$sel = ( $curr_dir == $dir ) ? ' selected="selected"' : '';?>
            html += '<option value="<?php echo $dir;?>"<?php echo $sel;?>><?php echo $dir;?></option>';
		<?php }?>
       	html += '</select>';
        p.getElementById('dirlistcontainer').innerHTML = html;
		<?php if( $params->get('use_tree', '1') == '1' ){?>
			//dtree
			parent.jce.tree.add( 'i0', -1, '<?php echo $jce->translate('tree_root');?>', 'javascript:changeDir(\'/\');');	
			<?php echo $manager->dirTree();?>
			p.getElementById('treeDetails').innerHTML = parent.jce.tree;
			setTree("<?php echo $curr_dir;?>");	 
		<?php }else{?>
			p.getElementById('treeDetails').innerHTML = '<div class="noResult"><?php echo $jce->translate('no_tree');?></div>';
		<?php }?>					
		<?php if( $error ){?>
			parent.showMessage('<?php echo $error;?>', 'error.gif', 'error');
		<?php }
		if( $ret_file ){?>
			parent.setReturnFile( '<?php echo $ret_file;?>', false );
		<?php }?>
		parent.iframeInit();
	}
/*]]>*/
</script>
</head>
<body style="background-color:#FFFFFF" onLoad="init();">
<div id="dirList" onselectstart="return false" class="div-list">
        <?php if( count( $dir_list ) > 0 ) drawDirs( $dir_list, $manager ); ?>
</div>
<?php
if( count( $file_list ) > 0 ){?>
	<div id="fileList" onselectstart="return false" class="div-list">
        <?php drawFiles( $file_list, $manager );?>
    </div>
<?php }else{
    noFiles();
}?>
    <script type="text/javascript">
		setSelectables();
		parent.setSortables();
	</script>
</body>
</html>
