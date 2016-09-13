<?php
/**
* @version 1.0.4
* @package RSform! 1.0.4
* @copyright (C) 2007 www.rsjoomla.com
* @license Commercial License, http://www.rsjoomla.com/license/forme.html
*/
session_start();
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
	global $mosConfig_lang, $mosConfig_sitename;

	define( 'ELPATH', dirname(__FILE__) );

	//check language
	//first check global joomfish
	$check = false;
	if(isset($_COOKIE['mbfcookie']['lang'])) $check = $_COOKIE['mbfcookie']['lang'];
	if(isset($_REQUEST['lang'])) $check = mosGetParam($_REQUEST,'lang',false);
	if($check){
		require_once(ELPATH.'/languages/'.$check.'.php');
	}else{
		require_once(ELPATH.'/languages/en.php');
	}


	require_once( $mainframe->getPath( 'class' ) );
	require_once( $mainframe->getPath( 'front_html' ) );
	require_once(ELPATH.'/../../includes/pageNavigation.php');

	$limitstart 	= intval( mosGetParam( $_REQUEST, 'limitstart', 0 ) );
	$pop 			= intval( mosGetParam( $_REQUEST, 'pop', 0 ) );
	$func 			= mosGetParam( $_REQUEST, 'func' );
	$fid			= intval( mosGetParam( $_REQUEST,'fid',0));
	$did			= intval( mosGetParam( $_REQUEST,'did',0));
	$processform	= mosGetParam( $_POST, 'form', array());

	$GLOBALS['formeConfig'] = buildFormeConfig();

	switch ($func) {
	case 'thankyou':
		thankyou($option, $did);
	break;
	case 'test':
		test();
		break;
	default:
		showForm($option,$fid);
	break;
	}
	function test(){

		forme_HTML::test();
	}

	function populateGlobal($fields){
		$fields[]->name = 'jos_sitename';
		$fields[]->name = 'jos_siteurl';
		$fields[]->name = 'jos_userip';
		$fields[]->name = 'jos_user_id';
		$fields[]->name = 'jos_username';
		$fields[]->name = 'jos_email';

		return $fields;
	}

	function prepareParams($did){
		global $mosConfig_live_site, $mosConfig_sitename, $database, $my;

		$database->setQuery("SELECT * FROM #__forme_data WHERE id = '$did'");
		$database->loadObject($data_row);
		$params = $data_row->params;

		$user = new mosUser($database);
		$user->load($data_row->uid);


		$result['jos_sitename'] = $mosConfig_sitename;
		$result['jos_siteurl'] = $mosConfig_live_site;
		$result['jos_userip'] = $data_row->uip;
		$result['jos_user_id'] = $data_row->uid;
		$result['jos_username'] = $user->username;
		$result['jos_email'] = $user->email;

		$result_explode = explode("||\n",$params);
		foreach($result_explode as $param_row){
			$param_row = explode('=',$param_row,2);
			if(isset($param_row[1])){
				$result[$param_row[0]] = $param_row[1];
			}else{
				$result[$param_row[0]] = '';
			}
		}
		return $result;
	}

	function thankyou($option, $did){
		global $database, $mainframe, $limitstart, $my, $mosConfig_sitename, $mosConfig_live_site, $Itemid;

		//get form_id
		$database->setQuery("SELECT * FROM #__forme_data WHERE id = '$did'");
		$database->loadObject($formdata);

		//check if form has a thank you message
		$database->setQuery("SELECT * FROM #__forme_forms WHERE id = '$formdata->form_id'");
		$database->loadObject($form);

		$params = prepareParams($formdata->id);

		//load fields
		$database->setQuery("SELECT * FROM #__forme_fields WHERE form_id = '$formdata->form_id' AND published = 1");
		$fields = $database->loadObjectList();

		$fields = populateGlobal($fields);

		foreach($fields as $field){
			if(!isset($params[$field->name])) $params[$field->name] = '';
			$form->thankyou = str_replace('{'.$field->name.'}',$params[$field->name],$form->thankyou);
			$form->return_url = str_replace('{'.$field->name.'}',$params[$field->name],$form->return_url);

		}

		if($form->thankyou!='') {
			forme_HTML::thankyou($form, $Itemid, $did, $formdata->form_id);
		}else{
			//if there is a return url
			if($form->return_url!=''){
				mosRedirect(sefRelToAbs($form->return_url), _FORME_FRONTEND_REGISTRA_SUCCESS." ");
			}else{
				mosRedirect(sefRelToAbs("index.php?option=com_forme&Itemid=$Itemid&func=details&fid=$formdata->form_id"), _FORME_FRONTEND_REGISTRA_SUCCESS." ");
			}
		}
	}

	function processForm($fid, $processform){
		global $database, $Itemid, $mosConfig_absolute_path,$mosConfig_sitename,$mosConfig_mailfrom,$my;

		$row = new forme_data($database);
		$row->form_id = $fid;
		$data_id = 0;

		$form = new forme_forms($database);
		$form->load($fid);



		eval($form->script_process);

		if(!empty($processform)){
			$errors = false;
			$form_data = mosGetParam($_POST,'form',array());

			$row->uip = $_SERVER['REMOTE_ADDR'];
			$row->date_added = date('Y-m-d H:i');
			$_SESSION['formmsg'] = array();

			//check captcha if any
			$database->setQuery("SELECT * FROM #__forme_fields WHERE form_id = '$fid' AND published = 1");
			$fields = $database->loadObjectList();


			//load input data
			foreach($fields as $field){
				if(isset($form_data[$field->name])){
					$_SESSION['formdata'][$field->name] = $form_data[$field->name];
				}else{
					$_SESSION['formdata'][$field->name] = array();
				}
			}

			foreach($fields as $i=>$field){
				//check captcha
				if($field->inputtype == 'captcha'){
					//check session
					if(isset($_SESSION['CAPTCHA'])){
						if(isset($form_data[$field->name])){
							if(strtoupper($form_data[$field->name])!=$_SESSION['CAPTCHA']){
								$_SESSION['formmsg'][$field->name][] = ($field->validation_message == '') ? _FORME_FRONTEND_REGISTRA_CAPTCHA : $field->validation_message;
							}
						}
					}
				}


				//check mandatory
				if($field->validation_rule == 'mandatory'){
					if($field->inputtype!='file upload'){
						if(isset($form_data[$field->name])){
							if(is_array($form_data[$field->name])){
								if(empty($form_data[$field->name])||(count($form_data[$field->name])==1&&$form_data[$field->name][0]=='')) $_SESSION['formmsg'][$field->name][] = ($field->validation_message == '') ?  sprintf(_FORME_FRONTEND_REGISTRA_CANNOT_EMPTY,$field->title) : $field->validation_message;
							}else{
								if($form_data[$field->name]=='')  $_SESSION['formmsg'][$field->name][] = ($field->validation_message == '') ?  sprintf(_FORME_FRONTEND_REGISTRA_CANNOT_EMPTY,$field->title) : $field->validation_message;
							}
						}else{
							$_SESSION['formmsg'][$field->name][] =  $_SESSION['formmsg'][$field->name][] = ($field->validation_message == '') ?  sprintf(_FORME_FRONTEND_REGISTRA_CANNOT_EMPTY,$field->title) : $field->validation_message;
						}
					}else{
						$field_exists = false;
						foreach($_FILES['form']['name'] as $field_name=>$field_value){
							if($field_name==$field->name){
								if($_FILES['form']['tmp_name'][$field_name]!='')	$field_exists = true;
							}
						}
						if(!$field_exists){
							$_SESSION['formmsg'][$field->name][] =  $_SESSION['formmsg'][$field->name][] = ($field->validation_message == '') ?  sprintf(_FORME_FRONTEND_REGISTRA_FILE_CANNOT_EMPTY) : $field->validation_message;
						}
					}

				}
				//check alphanum
				if($field->validation_rule == 'alphanum'){
					if(eregi('[^a-zA-Z0-9 ]', $form_data[$field->name] )|| $form_data[$field->name] == ''){
						$_SESSION['formmsg'][$field->name][] = sprintf(_FORME_FRONTEND_REGISTRA_ALPHANUMERIC,$field->title);
					}
				}

				//check alpha
				if($field->validation_rule == 'alpha'){
					if(eregi('[^a-zA-Z ]', $form_data[$field->name] )|| $form_data[$field->name] == ''){
						$_SESSION['formmsg'][$field->name][] = sprintf(_FORME_FRONTEND_REGISTRA_ALPHA,$field->title);
					}
				}

				//check email
				if($field->validation_rule == 'email'){
					if(!eregi ("^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,6}$", stripslashes(trim($form_data[$field->name]))) || $form_data[$field->name] == ''){
						$_SESSION['formmsg'][$field->name][] = _FORME_FRONTEND_REGISTRA_EMAIL;
					}
				}

				//check number
				if($field->validation_rule == 'number'){
					if(!is_numeric($form_data[$field->name] )|| $form_data[$field->name] == ''){
						$_SESSION['formmsg'][$field->name][] = sprintf(_FORME_FRONTEND_REGISTRA_NUMERIC,$field->title);
					}
				}

				//check file type compatibility
				if($field->inputtype== 'file upload'){
					foreach($_FILES['form']['name'] as $field_name=>$field_value){
						if($field_name == $field->name){
							$field_rules = explode(',',$field->default_value);
							if( $field_rules[0] != '' || $field->default_value!=''){
								$type_match = false;
								foreach($field_rules as $rule){
									//check for size
									$size = explode('/',$rule);
									if($size[0]=='size'){
										if(!isset($size[1])) $size[1] = 0;
										if($size[1]){
											if($_FILES['form']['size'][$field->name] > (int)$size[1]*1024){
												$_SESSION['formmsg'][$field->name][] = sprintf(_FORME_FRONTEND_REGISTRA_SIZE,$size[1]);
											}
										}
									}

									//check for file type
									if($rule==$_FILES['form']['type'][$field->name]){
										$type_match = true;
									}
								}
								if($_FILES['form']['type'][$field->name]=='') $type_match = true;
								if(!$type_match){
									$_SESSION['formmsg'][$field->name][] = _FORME_FRONTEND_REGISTRA_NOT_ALLOWED;
								}
							}
						}
					}
				}

			}
			if(!empty($_SESSION['formmsg'])){
				mosRedirect(sefRelToAbs('index.php?option=com_forme&Itemid='.$Itemid.'&fid='.$fid));
			}


			//build params
			$params_field = '';
			foreach($form_data as $key=>$value){
				if(is_array($value)) $value = implode(',',$value);
				$params_field .= $key.'='.$value."||\n";
			}

			//files
			foreach($fields as $field){
				if($field->inputtype=='file upload'){

						$target_file = time().'_'.$_FILES['form']['name'][$field->name];

						if(!move_uploaded_file($_FILES['form']['tmp_name'][$field->name],$mosConfig_absolute_path.'/components/com_forme/uploads/'.$target_file)){

						}else{
							$params_field .= $field->name . '=' . $target_file ."||\n";
						}
				}
			}




			// bind it to the table
			if (!$row -> bind($form_data)) {
				echo "<script> alert('"
				.$row -> getError()
					."'); window.history.go(-1); </script>\n";
				exit();
			}else{
				$row->params = $params_field;
			}
			if($my->id) $row->uid = $my->id;

			// store it in the db
			if (!$row -> store()) {
				echo "<script> alert('"
					.$row -> getError()
					."'); window.history.go(-1); </script>\n";
				exit();
			}else{
				//$data_id = mysql_insert_id();
				$data_id = $row->id;
				if($form->emailto!=''&&$form->email!=''){
					$emailto = explode(',',str_replace(' ','',$form->emailto));

					$fields = populateGlobal($fields);

					$params = prepareParams($data_id);
					foreach($fields as $field){
						if(!isset($params[$field->name])) $params[$field->name] = '';
						$form->email = str_replace('{'.$field->name.'}',$params[$field->name],$form->email);
						$form->emailsubject = str_replace('{'.$field->name.'}',$params[$field->name],$form->emailsubject);
						$form->emailfrom = str_replace('{'.$field->name.'}',$params[$field->name],$form->emailfrom);
						$form->emailfromname = str_replace('{'.$field->name.'}',$params[$field->name],$form->emailfromname);
						foreach($emailto as $i=>$to){
							$emailto[$i] = str_replace('{'.$field->name.'}',$params[$field->name],$emailto[$i]);
						}
					}

					if($form->emailfrom=='')$form->emailfrom = $mosConfig_mailfrom;
					if($form->emailfromname=='')$form->emailfromname = $mosConfig_sitename;


					foreach($emailto as $to){
						mosMail($form->emailfrom,$form->emailfromname,$to,$form->emailsubject,$form->email,$form->emailmode);
					}
				}
			}

			//check if there is a thank you message
			if(strlen($form->thankyou)!=0){
				if(isset($_SESSION['formdata'])){
					unset($_SESSION['formdata']);
				}
				mosRedirect(sefRelToAbs("index.php?option=com_forme&Itemid=$Itemid&func=thankyou&did=$data_id"));
			}else {
				if(isset($_SESSION['formdata'])){
					unset($_SESSION['formdata']);
				}
				//if there is a return url
				if($form->return_url!=''){

					$params = prepareParams($data_id);
					$fields = populateGlobal($fields);
					foreach($fields as $field){
						if(!isset($params[$field->name])) $params[$field->name] = '';
						$form->return_url = str_replace('{'.$field->name.'}',$params[$field->name],$form->return_url);
					}
					mosRedirect(sefRelToAbs($form->return_url), _FORME_FRONTEND_REGISTRA_SUCCESS." ");
				}else{
					if(isset($_SESSION['formdata'])){
						unset($_SESSION['formdata']);
					}
					mosRedirect(sefRelToAbs("index.php?option=com_forme&Itemid=$Itemid&func=details&fid=$fid"), _FORME_FRONTEND_REGISTRA_SUCCESS." ");
				}
			}
		}

	}

	function showForm($option, $fid){
		global $database, $mainframe, $limitstart, $my, $acl, $processform, $formeConfig, $mosConfig_live_site;

		if(!$fid){
			//get first cid
			$database->setQuery("SELECT id FROM #__forme_forms WHERE published = 1 LIMIT 1");
			$fid = (int)$database->loadResult();
		}

		//check language
		//first check global joomfish
		$check = false;
		if(isset($_COOKIE['mbfcookie']['lang'])) $check = $_COOKIE['mbfcookie']['lang'];
		if(isset($_REQUEST['lang'])) $check = mosGetParam($_REQUEST,'lang',false);
		if($check){
			$oldform = new forme_forms($database);
			$oldform->load($fid);

			//check if we find something similar
			$database->setQuery("SELECT id FROM #__forme_forms WHERE lang='$check' AND name='$oldform->name' ");
			$newfid = $database->loadResult();
			if($newfid) $fid = $newfid;
		}


		processForm($fid, $processform);

		$query = "SELECT * FROM #__forme_forms WHERE id = '{$fid}' AND published = '1'";
		$database->setQuery($query);

		$form = $database->loadObjectList();

		//load fields
		$query = "SELECT * FROM #__forme_fields WHERE form_id = '{$fid}' AND published = '1' ORDER BY ordering";
		$database->setQuery($query);

		$fields = $database->loadObjectList();

		$form = $form[0];

		if(!$form->published) mosRedirect($mosConfig_live_site,_NOT_EXIST);

		//Output
		forme_HTML::showForm($option, $form, $fields);
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