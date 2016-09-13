<?php
/**
* @version 1.0.4
* @package RSform! 1.0.4
* @copyright (C) 2007 www.rsjoomla.com
* @license Commercial License, http://www.rsjoomla.com/license/forme.html
*/

ini_set('max_execution_time','300');
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

define( 'EL_ADMIN_PATH', dirname(__FILE__) );

// Access
if (!($acl->acl_check( 'administration', 'edit', 'users', $my->usertype, 'components', 'all' )
	| $acl->acl_check( 'administration', 'edit', 'users', $my->usertype, 'components', 'com_forme' ))) {

mosRedirect( 'index2.php', _NOT_AUTH );
}
global $mainframe;
require_once( $mainframe->getPath( 'admin_html' ) );
require_once( $mainframe->getPath( 'class' ) );

require_once(EL_ADMIN_PATH.'/../../includes/pageNavigation.php');

$cid 	= mosGetParam($_REQUEST, 'cid', array());
$rcid 	= mosGetParam($_REQUEST, 'rcid', array());

$limit = intval( mosGetParam( $_REQUEST, 'limit', 15 ) );
$limitstart = intval( mosGetParam( $_REQUEST, 'limitstart', 0 ) );
$formeConfig = buildFormeConfig();

$task 	= mosGetParam( $_REQUEST, 'task' );

switch($task){
	case "update":
	updateCheck($option);
	break;

	case "forms":
	listforms($option);
	break;

	case "info":
	showInformation($option);
	break;

	case "publishfield":
	publishfield( $cid, 1, $option );
	break;

	case "unpublishfield":
	publishfield( $cid, 0, $option );
	break;

	case "orderupfield":
	orderfield( $cid[0], -1, $option );
	break;

	case "orderdownfield":
	orderfield( $cid[0], 1, $option );
	break;

	case "publishform":
	publishforms( $cid, 1, $option );
	break;

	case "unpublishform":
	publishforms( $cid, 0, $option );
	break;

	case "newform":
	editforms($option, 0);
	break;

	case "newfield":
	editfield($option, 0);
	break;

	case "editfield":
	editfield($option, $cid);
	break;

	case "deletefield":
	deletefield($option, $cid);
	break;

	case "editform":
	editforms($option, $cid);
	break;

	case "deleteform":
	deleteforms($option, $cid);
	break;

	case "saveform":
	saveforms($option);
	break;

	case "applyform":
	saveforms($option,1);
	break;

	case "savefield":
	savefield($option);
	break;

	case "applyfield":
	savefield($option,true);
	break;

	case "cancelform":
	cancelform($option);
	break;

	case "cancelfield":
	cancelfield($option);
	break;

	case 'listdata':
	listdata($option, $cid);
	break;

	case 'exportdata':
	exportdata($option, $rcid);
	break;

	case 'exportalldata':
	exportdata($option, -1);
	break;

	case 'deldata':
	deletedata($option, $rcid);
	break;

	case 'sample':
	addSampleData($option);
	break;

	case 'saveorder':
	saveOrder( $cid );
	break;

	case 'support':
	supportDesk($option);
	break;

	case 'saveRegistration':
	saveRegistration($option);
	break;

	case 'backup':
	backup();
	break;

	case 'restore':
	restore($option);
	break;

	case 'restoreprocess':
	restoreProcess($option);
	break;

	case 'forms.copy':
		formsCopy($option, $cid);
	break;

	case 'fields.copy.screen':
		fieldsCopyScreen($option, $cid);
	break;

	case 'fields.copy.cancel':
		fieldsCopyCancel($option);
	break;

	case 'fields.copy':
		fieldsCopy($option, $cid);
	break;

	default:
	forme_HTML::controlPanel($option);
	break;
}

function fieldsCopy($option, $cid){
	global $database;

	$form_id = mosGetParam($_REQUEST,'form_id',0);
	$copy_form_id = mosGetParam($_REQUEST,'copy_form_id',0);

	if(!empty($cid)){
		foreach($cid as $field_id){
			$field = new forme_fields($database);
			$field->load($field_id);
			$field->form_id = $copy_form_id;
			$field->id = null;
			$field->store();
			$field->updateOrder('form_id='.$copy_form_id);
		}

		$form1 = new forme_forms($database);
		$form1->load($form_id);
		$form1->checkin();

		$msg = _FORME_BACKEND_FIELDSCOPY_DONE;
		mosRedirect('index2.php?option='.$option.'&task=editform&hidemainmenu=1&cid='.$copy_form_id,$msg);
	}else{
		$msg = _FORME_BACKEND_FIELDSCOPY_NONE;
		mosRedirect('index2.php?option='.$option.'&task=editform&hidemainmenu=1&cid='.$form_id,$msg);
	}
}


function formsCopy($option, $cid){
	global $database;

	if(!empty($cid)){
		//first duplicate fields
		foreach($cid as $form_id){

			//add new form
			$new_form = new forme_forms($database);
			$new_form->load($form_id);
			$new_form->id = null;
			$new_form->store();

			$database->setQuery("SELECT id FROM #__forme_fields WHERE form_id = '$form_id'");
			$fields = $database->loadObjectList();
			if(!empty($fields)){

				foreach($fields as $field_id){
					$field = new forme_fields($database);
					$field->load($field_id->id);

					$field->id = null;
					$field->form_id = $new_form->id;
					$field->store();
				}
			}
		}

		$msg = _FORME_BACKEND_FORMSSCOPY_DONE;
	}else{
		$msg = _FORME_BACKEND_FORMSSCOPY_NONE;
	}
	mosRedirect('index2.php?option='.$option.'&task=forms',$msg);
}

function fieldsCopyCancel($option){
	global $database;

	$form_id = mosGetParam($_REQUEST,'form_id',0);

	mosRedirect('index2.php?option='.$option.'&task=editform&hidemainmenu=1&cid='.$form_id);
}


function fieldsCopyScreen($option, $cid){
	global $database;

	$form_id = mosGetParam($_REQUEST,'form_id',0);


	if(!empty($cid)){
		$database->setQuery("SELECT id as value, title as text FROM #__forme_forms WHERE published>=0");
		$forms = $database->loadObjectList();

		$forms = mosHTML::selectList($forms,'copy_form_id','','value','text');

		$field_ids = join(',',$cid);
		$database->setQuery("SELECT * FROM #__forme_fields WHERE id IN ($field_ids)");
		$fields = $database->loadObjectList();

		forme_HTML::fieldsCopyScreen($option, $fields, $forms);
	}else{
		$msg = _FORME_BACKEND_FIELDSCOPY_NONE;
		mosRedirect('index2.php?option='.$option.'&task=editform&hidemainmenu=1&cid='.$form_id,$msg);
	}
}

function supportDesk($option){
	forme_HTML::supportDesk($option);
}

function saveRegistration($option){
	global $database;


	$formeConfigPost = mosGetParam($_POST,'formeConfig',array());

	if(!isset($formeConfigPost['global.register.code']))$formeConfigPost['global.register.code']='';

	if($formeConfigPost['global.register.code']=='') mosRedirect('index2.php?option='.$option,_FORME_BACKEND_SAVEREG_CODE);

	$database->setQuery("UPDATE #__forme_config SET setting_value = '".trim($formeConfigPost['global.register.code'])."' WHERE setting_name = 'global.register.code'");
	$database->query();

	mosRedirect('index2.php?option='.$option,_FORME_BACKEND_SAVEREG_SAVED);
}

function addSampleData($option){
	global $database;

	$query = "INSERT INTO `#__forme_forms` VALUES ('', 'contactForm', 'My First Contact Form', '<div align=\"left\" style=\"width:100%\" class=\"componentheading\">{formtitle}</div>\r\n<form name=\"{formname}\" id=\"{formname}\" method=\"post\" action=\"{action}\" {enctype}>\r\n	<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"forme\">\r\n	{formfields}\r\n	</table>\r\n</form>', '<tr>\r\n	<td align=\"right\" valign=\"top\" width=\"33%\">{fieldtitle}{validationsign}</td>\r\n	<td valign=\"top\" width=\"34%\">{field}</td>\r\n	<td valign=\"top\" width=\"33%\">{fielddesc}</td>\r\n</tr>\r\n', '', '<p>Dear {fullname},</p><p>We received your  contact enquiry which contains the following message:</p><p>{message}</p><p>We will contact you shortly at {email}. </p>', 'me@domain.com,{email}', '', '', 'Contact Enquiry Received', 1, '', 1, 0, '0000-00-00 00:00:00','','','');";
	$database->setQuery($query);
	$database->query();

	$form_id = mysql_insert_id();

	$query = "INSERT INTO `#__forme_fields` VALUES ('', '$form_id', 'fullname', 'Full Name', '<tr>\r\n	<td align=\"right\" valign=\"top\">{fieldtitle}{validationsign}</td>\r\n	<td valign=\"top\">{field}</td>\r\n	<td valign=\"top\">{fielddesc}</td>\r\n</tr>\r\n', '', 'text', '', '', 'alpha', 'Fullname must contain only a-z,A-Z characters', 1, 1, 0, '0000-00-00 00:00:00');";
	$database->setQuery($query);
	$database->query();

	$query = "INSERT INTO `#__forme_fields` VALUES ('', '$form_id', 'email', 'Email Address', '<tr>\r\n	<td align=\"right\" valign=\"top\">{fieldtitle}{validationsign}</td>\r\n	<td valign=\"top\">{field}</td>\r\n	<td valign=\"top\">{fielddesc}</td>\r\n</tr>\r\n', '', 'text', '', '', 'email', 'Please add a valid e-mail address.', 2, 1, 0, '0000-00-00 00:00:00');";
	$database->setQuery($query);
	$database->query();

	$query = "INSERT INTO `#__forme_fields` VALUES ('', '$form_id', 'message', 'Message:', '<tr>\r\n	<td align=\"right\" valign=\"top\">{fieldtitle}{validationsign}</td>\r\n	<td valign=\"top\">{field}</td>\r\n	<td valign=\"top\">{fielddesc}</td>\r\n</tr>\r\n', '', 'textarea', '', '', 'mandatory', 'Please add a message.', 3, 1, 0, '0000-00-00 00:00:00');";
	$database->setQuery($query);
	$database->query();

	$query = "INSERT INTO `#__forme_fields` VALUES ('', '$form_id', 'submit', '', '<tr>\r\n	<td align=\"right\" valign=\"top\">{fieldtitle}{validationsign}</td>\r\n	<td valign=\"top\">{field}</td>\r\n	<td valign=\"top\">{fielddesc}</td>\r\n</tr>\r\n', '', 'submit button', 'Submit', '', '', '', 4, 1, 0, '0000-00-00 00:00:00');";
	$database->setQuery($query);
	$database->query();

	 mosRedirect( "index2.php?option=$option", "Sample data added" );
}




//Information

function showInformation($option)

{

	forme_HTML::showInformation($option);

}



function cancelform($option){
	global $database;
	$row = new forme_forms( $database );
	$row->bind( $_POST );
	$row->checkin();

	mosRedirect( "index2.php?option=$option&task=forms" );
}



function cancelfield($option){
	global $database;
	$row = new forme_fields( $database );
	$row->bind( $_POST );
	$row->checkin();

	if(!$row->form_id){
		$task = '&task=forms';
		$cid = '';
	}else{
		$task = '&task=editform';
		$cid = '&cid='.$row->form_id;
	}

	mosRedirect( "index2.php?option=$option".$task.$cid );
}



//List Forms
function listforms($option){
	global $database, $mainframe, $limit, $limitstart;

	$search 		= $mainframe->getUserStateFromRequest( "search{$option}", 'search', '' );
	$search 		= $database->getEscaped( trim( strtolower( $search ) ) );
	$filter 		= $mainframe->getUserStateFromRequest( "filter{$option}", 'filter', '' );
	$filter 		= intval( $filter );

	$database->SetQuery( "SELECT count(*)"
						. "\nFROM #__forme_forms AS a"
						. "\nWHERE a.published 	>= 0"
						);
  	$total = $database->loadResult();
	echo $database->getErrorMsg();

	$where = array(
	"a.published 	>= 0",
	);

	if ($search && $filter == 1) {
		$where[] = "LOWER(a.title) LIKE '%$search%'";
		$where[] = "LOWER(a.name) LIKE '%$search%'";

	$database->SetQuery( "SELECT count(*)"
						. "\nFROM #__forme_forms AS a"
						. (count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "")
						);
  	$total = $database->loadResult();
	echo $database->getErrorMsg();

	}

	$pageNav = new mosPageNav( $total, $limitstart, $limit );
	$query = "SELECT a.*"
			. "\nFROM #__forme_forms AS a"
			. ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "")
			;
	$database->SetQuery( $query, $pageNav->limitstart, $pageNav->limit );
	$rows = $database->loadObjectList();

	//foreach form, get number of posts
	foreach($rows as $i=>$row){
		$database->setQuery("SELECT count(*) cnt FROM #__forme_data WHERE date_format(date_added,'%Y-%m-%d') = '".date('Y-m-d')."' AND form_id='{$row->id}'");
		$cnt_today = $database->loadResult();

		$database->setQuery("SELECT count(*) cnt FROM #__forme_data WHERE date_format(date_added,'%Y-%m') = '".date('Y-m')."' AND form_id='{$row->id}'");
		$cnt_month = $database->loadResult();

		$database->setQuery("SELECT count(*) cnt FROM #__forme_data WHERE form_id='{$row->id}'");
		$cnt_all = $database->loadResult();

		$rows[$i]->cnt_today = $cnt_today;
		$rows[$i]->cnt_month = $cnt_month;
		$rows[$i]->cnt_all = $cnt_all;
	}


	//Display
	forme_HTML::listforms($option, $rows, $pageNav, $search, $filter);
}

function deletedata($option, $rcid){
	global $database, $mosConfig_absolute_path;


	$total = count( $rcid );
	$data_id = join(",", $rcid);

	//get form id
	$database->setQuery("SELECT form_id FROM #__forme_data WHERE id = '{$rcid[0]}'");
	$form_id = $database->loadResult();

	//check for files
	$database->setQuery("SELECT * FROM #__forme_data WHERE id IN ($data_id)");
	$data = $database->loadObjectList();
	foreach($data as $d){
		$fields = explode("||\n",$d->params);
		if(!empty($fields)){
			foreach($fields as $field){
				$field = explode('=',$field);
				if(!isset($field[1]))$field[1] = '';

				$database->setQuery("SELECT inputtype FROM #__forme_fields WHERE name='{$field[0]}'");
				$inputtype = $database->loadResult();

				if($inputtype == 'file upload'){
					unlink($mosConfig_absolute_path.'/components/com_forme/uploads/'.$field[1]);
				}
			}
		}
	}


	$database->SetQuery("DELETE FROM #__forme_data WHERE id IN ($data_id)");
	$database->Query();

	if ( !$database->query() ) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}

	$msg = $total ._FORME_BACKEND_DATA_DEL." ";
	mosRedirect( 'index2.php?option='. $option .'&task=listdata&cid='.$form_id, $msg );
}

//Delete Forms
function deleteforms($option, $cid){
	global $database;

	$total = count( $cid );
	$forms = join(",", $cid);

	//Delete form
	$database->setQuery("DELETE FROM #__forme_forms WHERE id IN ($forms)");
	if ( !$database->query() ) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}else{
		$database->setQuery("DELETE FROM #__forme_fields WHERE form_id IN ($forms)");
		$database->query();

		$database->setQuery("DELETE FROM #__forme_data WHERE form_id IN ($forms)");
		$database->query();
	}

	$msg = $total ._FORME_BACKEND_FORMS_DEL." ";
	mosRedirect( 'index2.php?option='. $option .'&task=forms', $msg );
}

//Delete Fields
function deletefield($option, $cid){
	global $database;
	$total = count( $cid );
	$fields = join(",", $cid);

	//get form_id
	$database->setQuery("SELECT form_id FROM #__forme_fields WHERE id = '{$cid[0]}'");
	$form_id = $database->loadResult();

	//Delete field

	$database->SetQuery("DELETE FROM #__forme_fields WHERE id IN ($fields)");
	$database->Query();

	if ( !$database->query() ) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}

	$msg = $total ._FORME_BACKEND_FIELDS_DEL." ";
	mosRedirect( 'index2.php?option='. $option .'&task=editform&cid='.$form_id, $msg );
}

//Save Forms
function saveforms($option,$apply=0){
	global $database;
	$row = new forme_forms($database);

	$_POST['name'] = mosGetParam($_POST, 'name');
	$_POST['title'] = mosGetParam($_POST, 'title');

	if($_POST['formstyle']=='')$_POST['formstyle'] = _FORME_BACKEND_EDITFORMS_STYLE_DEFAULT;
	if($_POST['fieldstyle']=='')$_POST['fieldstyle'] = _FORME_BACKEND_EDITFORMS_FIELDSTYLE_DEFAULT;

	// bind it to the table
	if (!$row -> bind($_POST)) {
		echo "<script> alert('"
			.$row -> getError()
			."'); window.history.go(-1); </script>\n";
		exit();
	}

	$row->name = preg_replace("/[^a-zA-Z0-9s]/", "", $row->name);

	if(empty($row->name)||empty($row->title)) {
        mosRedirect("index2.php?option=$option&task=forms", _FORME_BACKEND_FORM_NAME_EMPTY." "); }

	// store it in the db
	if (!$row -> store()) {
		echo "<script> alert('"
			.$row -> getError()
			."'); window.history.go(-1); </script>\n";
		exit();
	}else{
		if(!$row->id) $row->id = mysql_insert_id();
	}

	$row->checkin();
	if(!$apply)	mosRedirect("index2.php?option=$option&task=forms", _FORME_BACKEND_FORMS_SAVE." ");
	else mosRedirect("index2.php?option=$option&task=editform&cid=".$row->id, _FORME_BACKEND_FORMS_SAVE." ");
}

//Save Fields
function savefield($option,$apply = false){
	global $database;

	$row = new forme_fields($database);
	if(!isset($_POST['published']))$_POST['published'] = '1';
	$row->default_value = html_entity_decode($row->default_value);
	$row->params = html_entity_decode($row->params);

	// bind it to the table
	if (!$row -> bind($_POST)) {
		echo "<script> alert('"
			.$row -> getError()
			."'); window.history.go(-1); </script>\n";
		exit();
	}
	if(!$row->ordering){
		$database->setQuery("SELECT ordering FROM #__forme_fields WHERE form_id = '$row->form_id' ORDER BY ordering DESC");
		$row->ordering = (int)$database->loadResult() + 1;
	}
	$row->name = preg_replace("/[^a-zA-Z0-9s]/", "", $row->name);

	if(empty($row->name)) {
        mosRedirect("index2.php?option=$option&task=editfield&cid=$row->id", _FORME_BACKEND_FIELDS_NAME_EMPTY." "); }
	// store it in the db
	if (!$row -> store()) {
		echo "<script> alert('"
			.$row -> getError()
			."'); window.history.go(-1); </script>\n";
		exit();
	}

	$row->checkin();
	//$row->updateOrder(" form_id = '{$row->form_id}'");

	if($apply)mosRedirect("index2.php?option=$option&task=editfield&hidemainmenu=1&cid=$row->id", _FORME_BACKEND_FIELDS_SAVE." ");
	else mosRedirect("index2.php?option=$option&task=editform&cid=$row->form_id", _FORME_BACKEND_FIELDS_SAVE." ");
}

//Order Fields
function orderfield( $id, $inc, $option ) {
	global $database;

	$row = new forme_fields( $database );
	$row->load( $id );
	$row->move( $inc, " form_id = '{$row->form_id}'" );

	mosRedirect( "index2.php?option=$option&task=editform&cid=".$row->form_id);
}

//Publish Form
function publishforms( $cid=null, $publishform=1,  $option ) {
  global $database;
  if (!is_array( $cid ) || count( $cid ) < 1) {
    $action = $publishcat ? 'publish' : 'unpublish';
    echo "<script> alert('Select an item to $action'); window.history.go(-1);</script>\n";
    exit;
  }
  $total = count ( $cid );
  $cids = implode( ',', $cid );

  $database->setQuery( "UPDATE #__forme_forms"
  					. "\nSET published =". intval( $publishform )
					. "\nWHERE id IN ( $cids )"
					);

  if (!$database->query()) {
    echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
    exit();
  }

    switch ( $publishform ) {
		case 1:
			$msg = $total ._FORME_BACKEND_SUC_PUBL_FORM." ";
		break;
		case 0:
		default:
			$msg = $total ._FORME_BACKEND_SUC_UNPUBL_FORM." ";
		break;
	}

	if (count( $cid ) == 1) {
		$row = new forme_forms( $database );
		$row->checkin( $cid[0] );
	}

	mosRedirect( 'index2.php?option='.$option.'&task=forms&mosmsg='. $msg );

}

//Publish Field
function publishfield( $cid=null, $publishfield=1,  $option ) {
  global $database;

  if (!is_array( $cid ) || count( $cid ) < 1) {
    $action = $publishcat ? 'publish' : 'unpublish';
    echo "<script> alert('Select an item to $action'); window.history.go(-1);</script>\n";
    exit;
  }
  $total = count ( $cid );
  $cids = implode( ',', $cid );

  $database->setQuery( "UPDATE #__forme_fields"
  					. "\nSET published =". intval( $publishfield )
					. "\nWHERE id IN ( $cids )"
					);

  if (!$database->query()) {
    echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
    exit();
  }

   	switch ( $publishfield ) {
		case 1:
			$msg = $total ._FORME_BACKEND_SUC_PUBL_FIELD." ";
		break;

		case 0:
		default:
			$msg = $total ._FORME_BACKEND_SUC_UNPUBL_FIELD." ";
		break;
	}

	if (count( $cid ) == 1) {
		$row = new forme_fields( $database );
		$row->checkin( $cid[0] );
	}

	//get form_id
	$database->setQuery("SELECT form_id FROM #__forme_fields WHERE id = '{$cid[0]}'");
	$form_id = $database->loadResult();


	mosRedirect( 'index2.php?option='.$option.'&task=editform&cid='.$form_id.'&mosmsg='. $msg );

}



//Edit Forms

function editforms($option, $cid){
	global $database, $my, $mosConfig_absolute_path;

	$row = new forme_forms( $database );
	$row->load( $cid );

	// fail if checked out not by 'me'
	if ($row->isCheckedOut( $my->id )) {
		//BUMP needs change for multilanguage support
		mosRedirect( 'index2.php?option='.$option.'&task=forms', 'The form '.$row->title.' is currently being edited by another administrator.' );
	}
	$database->SetQuery("SELECT * FROM #__forme_forms"
						. "\nWHERE id = $cid");
	$database->loadObject($row);

	//if $cid, check fields
	$field_rows = array();
	if($cid){
		$database->setQuery("SELECT * FROM #__forme_fields WHERE form_id = '$cid' ORDER BY ordering");
		$field_rows = $database->loadObjectList();
	}

	if ($cid) {
		$row->checkout( $my->id );
	} else {
		$row->published	 = 1;
	}


	forme_HTML::editforms($option, $row, $field_rows);
}


function getLanguages() {
	global $mosConfig_absolute_path, $database;

	$lang = array();

	// Read the language dir to find languages
	$languageBaseDir = mosPathName(mosPathName($mosConfig_absolute_path) . "language");
	$dirName = $languageBaseDir;

	$xmlFilesInDir = mosReadDirectory($languageBaseDir,".xml");

	// XML library
	require_once( $mosConfig_absolute_path . "/includes/domit/xml_domit_lite_include.php" );

	$xmlDoc =& new DOMIT_Lite_Document();
	$xmlDoc->resolveErrors( true );
	foreach($xmlFilesInDir as $xmlfile){
		if ($xmlDoc->loadXML( $dirName . $xmlfile, false, true )) {
			$lang[] = substr($xmlfile,0,-4);
		}

	}
	return $lang;
}









//Edit Fields
function editfield($option, $cid){
	global $database, $my;

	$row = new forme_fields( $database );
	$row->load( $cid );

	// fail if checked out not by 'me'
	if ($row->isCheckedOut( $my->id )) {
		//BUMP needs change for multilanguage support
		mosRedirect( 'index2.php?option='.$option.'&task=forms', 'The field '.$row->title.' is currently being edited by another administrator.' );
	}
	$database->SetQuery("SELECT * FROM #__forme_fields"
						. "\nWHERE id = {$cid}");
	$database->loadObject($row);
	if ($cid) {
		$row->checkout( $my->id );
	} else {
		$row->published	 = 1;
	}

	$post_form = mosGetParam($_POST,'form_id',0);
	if(!$row->form_id){
		$row->form_id = $post_form;
	}

	$form = new forme_forms( $database );
	$form->load($row->form_id);

	if($form->fieldstyle == '') $form->fieldstyle = _FORME_BACKEND_EDITFORMS_FIELDSTYLE_DEFAULT;
	if($row->fieldstyle == '') $row->fieldstyle = $form->fieldstyle;


	forme_HTML::editfield($option, $row);
}

//export data
function exportdata($option, $rcid){
	global $database, $mosConfig_absolute_path, $cid;

	if(is_array($rcid)){
		$total = count( $rcid );
		$data_id = join(",", $rcid);
	}


	//get fields
	$database->setQuery("SELECT * FROM #__forme_fields WHERE published = 1 AND form_id = '$cid'");
	$fields = $database->loadObjectList();

	//get data
	if(!is_array($rcid)){
		$data_id = '1=1';
	}else{
		$data_id = 'id IN ('.$data_id.')';
	}

	$database->setQuery("SELECT * FROM #__forme_data WHERE $data_id");
	$data = $database->loadObjectList();

	$output = '';
	$output .= _FORME_BACKEND_LISTDATA_USERIP . "\t";
	$output .= _FORME_BACKEND_LISTDATA_DADDED . "\t";

	$distinct_fields = array();
	foreach($fields as $field){
		$distinct_fields[$field->name] = $field;
	}
	$fields = $distinct_fields;


	foreach($fields as $field){
		$output .= $field->name . "\t";
	}
	$output .= "\n";

	foreach($data as $data_row){
		$output .= $data_row->uip . "\t";
		$output .= $data_row->date_added . "\t";

		//build params
		$reg_params = explode("||\n",$data_row->params);
		$custom_params = array();
		foreach ($reg_params as $each){
			$each = explode('=',$each,2);
			if(!isset($each[1]))$each[1] = '';
			$custom_params[$each[0]] = $each[1];
		}
		foreach ($fields as $field){
			if(!isset($custom_params[$field->name]))$custom_params[$field->name] = '';
			$custom_params[$field->name] = str_replace('"', '""', $custom_params[$field->name]);
			$output .= str_replace("\r\n","",$custom_params[$field->name]) . "\t";

		}
		$output .= "\n";
	}

	header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
	header ("Cache-Control: no-cache, must-revalidate");
	header ("Pragma: no-cache");
	header ("Content-type: application/csv");
	header ("Content-Disposition: attachment; filename=\"forme.csv\"" );

	if(function_exists('mb_convert_encoding')){
		$unicode_str_for_Excel = chr(255).chr(254).mb_convert_encoding( $output, 'UTF-16LE', 'UTF-8');
    	print $unicode_str_for_Excel;
	}else{
    	print $output;
	}

	exit;


}

//List Data
function listdata($option, $cid){
	global $database, $limit, $limitstart;

	$cid = intval( $cid );

	if(!$cid) {
		//get first cid
		$database->setQuery("SELECT id FROM #__forme_forms LIMIT 1");
		$cid = (int)$database->loadResult();
	}

	//build forms selectlist
	$database->setQuery("SELECT id as value, title as text FROM #__forme_forms");

	$forms = array();
	$forms[] = mosHTML::makeOption( '0', _FORME_BACKEND_LISTDATA_FORMS.' ' );
	$forms = array_merge( $forms, $database->loadObjectList() );

	$database->SetQuery( "SELECT count(*)"
						. "\nFROM #__forme_data AS d"
						. "\nWHERE d.form_id = $cid"
						);
  	$total = $database->loadResult();
	echo $database->getErrorMsg();

	$pageNav = new mosPageNav( $total, $limitstart, $limit );

	$query = "SELECT d.*"
			. "\nFROM #__forme_data AS d"
			. "\nWHERE d.form_id = $cid"
			. "\nORDER BY d.date_added DESC"
			;
	$database->SetQuery($query, $pageNav->limitstart, $pageNav->limit );
	$rows = $database->loadObjectList();

	//load form
	$form = new forme_forms($database);
	$form->load($cid);

	//select fields
	$query = "SELECT * FROM #__forme_fields WHERE form_id = '{$cid}' AND published=1 AND inputtype!='free text' ORDER BY ordering";
	$database->setQuery($query);

	$fields = $database->loadObjectList();
	$distinct_fields = array();
	foreach($fields as $field){
		$distinct_fields[$field->name] = $field;
	}

	$form->fields = $distinct_fields;

	forme_HTML::listdata($option, $rows, $form, $forms, $pageNav);
}

function saveOrder( &$cid ) {
	global $database;

	$total		= count( $cid );
	$redirect 	= mosGetParam( $_POST, 'redirect', 0 );
	$rettask	= strval( mosGetParam( $_POST, 'returntask', '' ) );

	$order 		= mosGetParam($_POST,'order',array());

	$form_id = mosGetParam($_POST,'form_id',0);

	$row = new forme_fields($database);
	// update ordering values
	for( $i=0; $i < $total; $i++ ) {
		$row->load( (int) $cid[$i] );
		if ($row->ordering != $order[$i]) {
			$row->ordering = $order[$i];
			if (!$row->store()) {
				echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
				exit();
			}else{
				$row->updateOrder( 'form_id='.$form_id );
			}
		}
	}
	mosRedirect( 'index2.php?option=com_forme&task=editform&cid='. $row->form_id , $msg );

} // saveOrder


function updateCheck($option){
	global $database, $formeConfig, $mosConfig_absolute_path;


	require_once( $mosConfig_absolute_path . '/includes/domit/xml_domit_parser.php' );
	$xml = new stdClass();
	$xmldoc = new DOMIT_Document();
	$xmldoc->expandEmptyElementTags(true);
    $xmldoc->setNamespaceAwareness(true);

    $html = '';
	$update_check = true;
    //check if directories are writable
    if(!is_writable($mosConfig_absolute_path.'/components/com_forme')){
    	$html .= sprintf(_FORME_BACKEND_UPGRADE_ERROR_DIR,$mosConfig_absolute_path.'/components/com_forme');
    	$update_check = false;
    }else{
    	$html .= sprintf(_FORME_BACKEND_UPGRADE_STATUS_DIR,$mosConfig_absolute_path.'/components/com_forme');
    }
     if(!is_writable($mosConfig_absolute_path.'/administrator/components/com_forme')){
    	$html .= sprintf(_FORME_BACKEND_UPGRADE_ERROR_DIR,$mosConfig_absolute_path.'/administrator/components/com_forme');
    	$update_check = false;
    }else{
    	$html .= sprintf(_FORME_BACKEND_UPGRADE_STATUS_DIR,$mosConfig_absolute_path.'/administrator/components/com_forme');
    }
//
    $fp = @fopen('http://www.pimpmyjoomla.com/component/option,com_support/task,files.update/file,_update_rsform.xml/sess,'.forme_HTML::genKeyCode(), "r");
    if($fp){
		if ($xmldoc->loadXML( 'http://www.pimpmyjoomla.com/component/option,com_support/task,files.update/file,_update_rsform.xml/sess,'.forme_HTML::genKeyCode(), false, true )) {
			$html .= sprintf(_FORME_BACKEND_UPGRADE_STATUS_REMOTE,'_update_rsform.xml');

			$total = count($xmldoc->documentElement->childNodes);
	        for ($i = 0; $i < $total; $i++) {
	            $currRotation =& $xmldoc->documentElement->childNodes[$i];
	            $tasks[$i]['type'] = $currRotation->getAttribute('type');
	            $tasks[$i]['dest'] = $currRotation->getAttribute('dest');
	            $tasks[$i]['value'] = $currRotation->firstChild->nodeValue;
	        }
	        if(empty($tasks)){
	        	$html .= _FORME_BACKEND_UPGRADE_STATUS_NOUPDATE;
				$update_check = false;
	        }
		}else{
			$html .= sprintf(_FORME_BACKEND_UPGRADE_ERROR_REMOTE,'_update_rsform.xml');
			$update_check = false;
		}
	}else{
		$html .= sprintf(_FORME_BACKEND_UPGRADE_ERROR_REMOTE,'_update_rsform.xml');
		$update_check = false;
	}

	if($update_check){
		if(!empty($tasks)){
			$accept = mosGetParam($_POST,'accept',0);
			if($accept){
				$update = true;
				foreach($tasks as $task){
					if($task['type']=='check'){
						if(intval(str_replace('-','',$formeConfig['global.update.check'])) >= intval(str_replace('-','',$task['value']))) $update=false;
						else {
							$database->setQuery("SELECT count(*) cnt FROM #__forme_config WHERE setting_name = 'global.update.check'");
							$exists = $database->loadResult();

							if($exists){
								$database->setQuery("UPDATE #__forme_config SET setting_value = '{$task['value']}' WHERE setting_name = 'global.update.check'");
							}else{
								$database->setQuery("INSERT INTO #__forme_config (`setting_name`,`setting_value`) VALUES ('global.update.check','{$task['value']}')");
							}
							$database->query();
						}
					}
					if($update) $html .= parseRow($option,$task['type'],$task['value'],$task['dest']);
				}

				if(!$update) $html .= _FORME_BACKEND_UPGRADE_STATUS_NOUPDATE;

				$html .= '<hr/>';
				$html .= _FORME_BACKEND_UPGRADE_CONTINUE;
			}else{
				$html .= '<hr/>';
				$html .= _FORME_BACKEND_UPGRADE_ACCEPT;
			}
		}
	}

	forme_HTML::updateCheck($option,$html);

}

function parseRow($option,$type,$value,$dest){
	global $database, $mosConfig_absolute_path;

	switch ($type){
		case 'query':
			$database->setQuery($value);
			if($database->query()){
				return sprintf(_FORME_BACKEND_UPGRADE_SUCCESS,$value);
			}else{
				return sprintf(_FORME_BACKEND_UPGRADE_FAIL,$value);
			}

		break;
		case 'copy':
			if($value!=''){

				$rfile = @fopen ('http://www.pimpmyjoomla.com/component/option,com_support/task,files.update/file,'.$value.'/sess,'.forme_HTML::genKeyCode(), "r");
				if (!$rfile) {
					return sprintf(_FORME_BACKEND_UPGRADE_ERROR_REMOTE,$value);
				}else{
					$filecontents = file_get_contents('http://www.pimpmyjoomla.com/component/option,com_support/task,files.update/file,'.$value.'/sess,'.forme_HTML::genKeyCode());
					$filename = $mosConfig_absolute_path.$dest;

					if($filecontents==''){
						return sprintf(_FORME_BACKEND_UPGRADE_ERROR_REMOTE,$value);
					}

					if (!$handle = @fopen($filename, 'w')) {
				         return sprintf(_FORME_BACKEND_UPGRADE_ERROR_LOCAL,$filename);
				         exit;
				    }

				    // Write $filecontents to our opened file.
				    if (fwrite($handle, $filecontents) === FALSE) {
				        return sprintf(_FORME_BACKEND_UPGRADE_ERROR_WRITE,$filename);
				        exit;
				    }

					return sprintf(_FORME_BACKEND_UPGRADE_STATUS_WRITE,$filename);

				    fclose($handle);
				}
			}
		break;
		case 'delete':
			$filename = $mosConfig_absolute_path.$value;
			if(file_exists($filename)){
				unlink($filename);
				return sprintf(_FORME_BACKEND_UPGRADE_STATUS_DELETE,$filename);
			}else{
				return sprintf(_FORME_BACKEND_UPGRADE_ERROR_DELETE,$filename);
			}
		break;
		case 'message':
			return $value;
		break;

	}
}


function backup(){
	global $database;

		$tables = array('#__forme_forms','#__forme_fields','#__forme_data','#__forme_config');
		$output = '<?php'."\r\n";
		$output .= '$database->setQuery("TRUNCATE TABLE `#__forme_forms`");$database->query();'."\r\n";
		$output .= '$database->setQuery("TRUNCATE TABLE `#__forme_fields`");$database->query();'."\r\n";
		$output .= '$database->setQuery("TRUNCATE TABLE `#__forme_data`");$database->query();'."\r\n";
		$output .= '$database->setQuery("TRUNCATE TABLE `#__forme_config`");$database->query();'."\r\n";

		foreach($tables as $table){
			$database->setQuery("SELECT id FROM $table");
			$fids = $database->loadObjectList();
			if(!empty($fids)){
			foreach($fids as $fid){
				switch($table){
					case '#__forme_forms':
						$object = new forme_forms($database);
					break;
					case '#__forme_fields':
						$object = new forme_fields($database);
					break;
					case '#__forme_data':
						$object = new forme_data($database);
					break;
					case '#__forme_config':
						$object = new forme_config($database);
					break;
				}

				$object->load($fid->id);

				$fmtsql = '$database->setQuery("INSERT INTO '.$table.' ( %s ) VALUES ( %s );");$database->query();$i++; '."\r\n";
				$fields = array();
				$values = array();
				foreach (get_object_vars( $object ) as $k => $v) {
					if (is_array($v) or is_object($v) or $v === NULL) {
						continue;
					}
					if ($k[0] == '_') { // internal field
						continue;
					}
					$fields[] = $database->NameQuote( $k );
					$values[] = $database->Quote( $v );
				}
				$output .= sprintf( $fmtsql, implode( ",", $fields ) ,  implode( ",", $values ) );

			}
			}
		}
		$output .= "\r\n?>";
		header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
		header ("Cache-Control: no-cache, must-revalidate");
		header ("Pragma: no-cache");
		header ("Content-type: text/plain");
		header ("Content-Disposition: attachment; filename=\"forme_backup.txt\"" );

		print $output;

		exit;
}


function restore($option){
	forme_HTML::restore($option);
}

function restoreProcess($option){
	global $database, $formeConfig;

	//files
	$file = mosGetParam($_FILES,'backupfile',array('tmp_name'=>''));


	if($file['tmp_name']!=''){
		$i = 0;
		//patch the file
		require_once($file['tmp_name']);
		$database->setQuery("SELECT * FROM #__forme_data");
		$data = $database->loadObjectList();
		if(!empty($data)){
			foreach($data as $data_row){
				$database->setQuery("UPDATE #__forme_data SET params = '".str_replace('¶','||',$data_row->params)."' WHERE id = '{$data_row->id}'");
				$database->query();

			}
		}
		$database->setQuery("SELECT count(*) cnt FROM #__forme_config WHERE setting_name = 'global.register.code'");
		$code_exists = $database->loadResult();

		if(!$code_exists){
			if(!isset($formeConfig['global.register.code'])) $formeConfig['global.register.code'] = '';
			$database->setQuery("INSERT INTO #__forme_config (setting_name,setting_value) VALUES ('global.register.code','{$formeConfig['global.register.code']}')");
			$database->query();
		}
	}

	mosRedirect('index2.php?option=com_forme',sprintf(_FORME_BACKEND_RESTORE_MSG,(int)$i));

}

/**
 * Builds configuration variable
 *
 * @return formeConfig
 */
function buildFormeConfig(){
	global $database;

	$formeConfig = array();
	$database->setQuery("SELECT setting_name, setting_value FROM #__forme_config");
	$formeConfigObj = $database->loadObjectList();

	foreach ($formeConfigObj as $formeConfigRow){
		$formeConfig[$formeConfigRow->setting_name] = $formeConfigRow->setting_value;
	}
	return $formeConfig;
}



?>