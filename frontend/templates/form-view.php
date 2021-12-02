<?php
 global $wpdb;
 $fields = $wpdb->get_results("SELECT * FROM `wp_sf_form` WHERE id = 1");
function stepform_func( $atts ){
 global $wpdb;
 $a = shortcode_atts( array(
 'id' => 'id'
 ), $atts );
 if (isset($_POST['submit_btn'])) {
	 $wpdb->insert('wp_sf_form_entries',array('form_id'=>esc_attr($a['id'])));
	 $lastid = $wpdb->insert_id;

	 foreach($_POST as $key => $value) {
	 $field_name = json_decode($val->name);
     $datavalue = json_encode($value);
  
	 $entry_meta_id = $wpdb->insert('wp_sf_form_entries_meta',array('form_id'=>esc_attr($a['id']), 'entry_id'=>$lastid, 'meta_key'=>$key, 'meta_value'=>$datavalue));

   }

	 foreach ($_FILES as $filekey => $filevalue) {
	 if($filevalue['name'] !== ''){

	require_once(ABSPATH . "wp-admin" . '/includes/image.php');
	require_once(ABSPATH . "wp-admin" . '/includes/file.php');
	require_once(ABSPATH . "wp-admin" . '/includes/media.php');

	$attach_id = media_handle_upload( $filekey, '' );
 $entry_meta_id = $wpdb->insert('wp_sf_form_entries_meta',array('form_id'=>esc_attr($a['id']), 'entry_id'=>$lastid, 'meta_key'=>$filekey, 'meta_value'=>$attach_id));
		//var_dump(wp_get_attachment_image_src($attach_id));
		}
	}
	 echo "record inserted";
	}
	
 if(!isset($_COOKIE['token'])) {
   // echo "The cookie is not set.";
    } else {
   // echo "The cookie is set.";
   // echo "Value of cookie: " . $_COOKIE['token'];
	$cookies =  $_COOKIE['token'];
    }
$current_user = wp_get_current_user();
$current_userid = $current_user->ID;
//var_dump($current_user->ID);

 $getformfields= $wpdb->get_results("SELECT * FROM `wp_sf_form` WHERE id = ".esc_attr($a['id'])."");
 $tmp_data = $wpdb->get_results("SELECT * FROM `wp_sf_tempentries` WHERE `form_id` = ".esc_attr($a['id'])." AND `form_title` = '$current_userid'");
 	$form = '<div class="stepform">';
	// $form .= wp_nonce_field( 'session_token', 'session_token' );
 	
	 $form .= '<form action="" class="regform" method="post" enctype="multipart/form-data">';
	 $form .= '<input type="hidden" id="session_token" name="session_token" value="'.$current_userid.'" >
<!-- Progress Bar -->
<ul id="progressbar">';
$stepCount = array();
$Count= array();
foreach($getformfields as $fieldkey => $fieldvalue) {
 $steps = json_decode($fieldvalue->field_name);
//	var_dump($steps);
 $progress = 1;
 $percount = 0;
 foreach ($steps as $stepIndex) {
 if (strpos($stepIndex->type, '_step') !== false) {
	 $Count[] = array_push($stepCount,strpos($stepIndex->type, '_step'));
 $form .= '<li class="steps"><span class="step-index">'.$progress++.'</span><span class="step-info">'.$stepIndex->name.'</span></li>';
 }
 }
 $form .= '</ul>';
 for($i=1; $i <= count($Count); $i++) {
$form .= '<fieldset class="stepfield">';
 foreach ($steps as $fields) {
	 if($fields->type != "form_title" && $fields->type != "addForm") {
	 //	$form .= '<div class="fieldset-input">';
	 $fieldsname = $fields->name;
	 if (is_array($fieldsname ) || is_object($fieldsname )) {

	 foreach ($fieldsname as $fieldgroupkey => $fieldgroupval) {

		 if($fieldgroupkey == 'step_'. $i) {
			 if($fieldgroupval->wrapper_class !== '') {
				 $form .= '<div class="fieldset-input '.$fieldgroupval->wrapper_class.'">';
				 $form .= '<div class="input">';
//$form .= '<div class="field-text" >';
			 }
			 if($fieldgroupval->fieldheading !== '') {
			 $form .= '<h3>'. $fieldgroupval->fieldheading .'</h3>';
			 }// code...
			 if ($fieldgroupval->field_label !== '' && $fieldgroupval->fieldtype !== 'button' ) {
			 $form .= '<label class="label_style">'. $fieldgroupval->field_label .'</label>';
		 		}
			 $fieldnames = str_replace(" ","_", sanitize_text_field($fieldgroupval->name));

	if($tmp_data[0] != "") {
		foreach($tmp_data[0] as $key=>$value) {
			if($key == "field_temp" ){
			$tempfields = json_decode($value);
			$groupcheckbox = array();
			$groupcheckboxvalue = array();
			$checkarray = array();
			$index = 0;
			//	print_r(end($tempfields)->name);
				foreach($tempfields as $setdata) {
			//	$optionfield = str_replace(  $setdata->name);
		
				if(strpos($setdata->name, 'select_') !== false ) {
					$selectname = $setdata->name;	
				}
				if( strpos($setdata->name, 'select_') == false && strpos($setdata->name, 'radio_') == false && strpos($setdata->name, 'checkbox_') == false ) {
			 //$fieldnames = str_replace(" ","_", sanitize_text_field($fieldgroupval->name));
			 if($setdata->name ==  $fieldnames ){						
						if($fieldgroupval->fieldtype !== 'form-heading') {
					
						if(strpos($fieldgroupval->name, 'textarea_') !== false) {

								$form .= '<textarea class="input_field" name="'. $fieldnames.'" rows="4" cols="50" value="'.$setdata->value.'">'.$setdata->value.'</textarea>';
							
							} elseif ($fieldgroupval->field_label == 'Porcentaje' && $fieldgroupval->fieldtype == 'number') {
								$form .= '<div class="percentage_val per_'.$percount++.'">';
								$form .= '<input class="input_field" type="'.$fieldgroupval->fieldtype .'" name="'. $fieldnames .'" value="'.$setdata->value.'" >';
								$form .= '<span >%</span></div>';
						
						} elseif ($fieldgroupval->fieldtype == 'button') {
							$form .= '<div id="results"></div><p class="tab-4-plus"><span class="button-icon" id="showprofile">+</span><span>'. $fieldgroupval->field_label .'</span>';
						} else {
						   $form .= '<input class="input_field" type="'.$fieldgroupval->fieldtype .'" name="'. $fieldnames .'" value="'.$setdata->value.'" >';
						}
					  } 
					  } else {
						if(strpos($setdata->name, 'radio_') !== false && strpos($fieldgroupval->name, 'radio_') !== false ) {
							$fieldgroupname = $fieldgroupval->name.'[]';
							//print_r($fieldgroupname);
							
							if($setdata->name == $fieldgroupname) {
								//print_r($fieldgroupname);
							$options = explode(',', $fieldgroupval->options);
							foreach($options as $option) {
							$string = sanitize_text_field($option);
							$optionVal = str_replace(" ","-",$string);
						//	print_r($optionVal);
								if($setdata->value == $optionVal) {
								$form .= '<div class="'.$fieldgroupval->fieldtype .'-input"><input id="'.$optionVal.'" class="" type="'.$fieldgroupval->fieldtype .'" name="'. $fieldgroupval->name .'[]" value="'.$optionVal.'" checked=checked><label for="'.$optionVal.'" class="label_style">'.$option.'</label></div>';
								} else {
								$form .= '<div class="'.$fieldgroupval->fieldtype .'-input"><input id="'.$optionVal.'" class="" type="'.$fieldgroupval->fieldtype .'" name="'. $fieldgroupval->name .'[]" value="'.$optionVal.'" ><label for="'.$optionVal.'" class="label_style">'.$option.'</label></div>';
								}
							}
							}
						}
						if( strpos($fieldgroupval->name, 'checkbox_') !== false ) {
							$fieldgroupname = explode('[]',end($tempfields)->name); 
							array_push($groupcheckbox, $fieldgroupname[0]);
							array_push($groupcheckboxvalue, end($tempfields)->value);
							 if (is_array(end($tempfields)->value ) || is_object(end($tempfields)->value)) {
							$countvalues = count(end($tempfields)->value);
							 
							
							if(in_array($setdata->value, end($tempfields)->value) ) {							 
							$index++;
							//var_dump($index);							
							//} 
							if($countvalues == $index) {
							$options = explode(',', $fieldgroupval->options);
							foreach($options as $option) {
							$string = sanitize_text_field($option);
							$optionVal = str_replace(" ","-",$string);
							
							
								if(in_array($optionVal, end($tempfields)->value)) {
								$form .= '<div class="'.$fieldgroupval->fieldtype .'-input"><input id="'.$optionVal.'" class="" type="'.$fieldgroupval->fieldtype .'" name="'. $fieldgroupval->name .'[]" value="'.$optionVal.'" checked=checked><label for="'.$optionVal.'" class="label_style">'.$option.'</label></div>';
								}
								 else {
								$form .= '<div class="'.$fieldgroupval->fieldtype .'-input"><input id="'.$optionVal.'" class="" type="'.$fieldgroupval->fieldtype .'" name="'. $fieldgroupval->name .'[]" value="'.$optionVal.'" ><label for="'.$optionVal.'" class="label_style">'.$option.'</label></div>';
								}
							}
							}	
							}
							}
						}
						
						if(strpos($setdata->name, 'select_') !== false && strpos($fieldgroupval->name, 'select_') !== false ) {
							$options = explode(',', $fieldgroupval->options);
						//	var_dump($fieldgroupval);
							$form .= '<select class="input_field" name='.str_replace(" ","_", sanitize_text_field($fieldgroupval->name)).'>';
							//$form .= '<option value="" selected="selected">'.$fieldgroupval->field_label.'</option>';
							foreach($options as $option) {
								if($setdata->value == $option) {
									$form .= '<option value="'.$option.'" selected="selected">'.$option.'</option>';
									} else {
									$form .= '<option value="'.$option.'">'.$option.'</option>';
									}						
							}
							$form .= '</select>';
						}
					
					  }
					  
					}
				}
			}
			
		}
		if ($fieldgroupval->fieldtype == 'file' && strpos($fieldgroupval->name, 'file_') !== false) {
			$form .= '<div class="upload_file_field"><input type="text"><label for="'. $fieldnames.'"><span>Adjuntar</span><span class="upload-icon"><i class="fas fa-upload"></i></span></label></div><input class="input_field" id="'. $fieldnames .'" type="'.$fieldgroupval->fieldtype .'" name="'. $fieldnames .'" value="'.$setdata->value.'">';
			}	
	} else {
		if($fieldgroupval->fieldtype !== 'form-heading') {
			if(strpos($fieldgroupval->name, 'select_') !== false ) {
				$options = explode(',', $fieldgroupval->options);
			//	var_dump($fieldgroupval);
				$form .= '<select class="input_field" name='.str_replace(" ","_", sanitize_text_field($fieldgroupval->name)).'>';
			 //  $form .= '<option value="" selected="selected">'.$fieldgroupval->field_label.'</option>';
				foreach($options as $option) {
					if($options[0] == $option) {
					$form .= '<option value="'.$option.'" selected="selected">'.$option.'</option>';
					} else {
					$form .= '<option value="'.$option.'">'.$option.'</option>';
					}
				}
				$form .= '</select>';
			} elseif(strpos($fieldgroupval->name, 'textarea_') !== false) {
				$form .= '<textarea class="input_field" name="'. $fieldnames .'" rows="4" cols="50"></textarea>';
			} elseif(strpos($fieldgroupval->name, 'radio_') !== false) {
				//array_push($checkarray, $fieldgroupval->name);
				//print_r($checkarray);
					$options = explode(',', $fieldgroupval->options);
					foreach($options as $option) {
			$string = sanitize_text_field($option);
			$optionVal = str_replace(" ","-",$string);
						if($options[0] == $optionVal) {
						$form .= '<div class="'.$fieldgroupval->fieldtype .'-input"><input id="'.$optionVal.'" class="" type="'.$fieldgroupval->fieldtype .'" name="'. $fieldgroupval->name .'[]" value="'.$optionVal.'" checked=checked ><label for="'.$optionVal.'" class="label_style">'.$option.'</label></div>';
						} else {
						$form .= '<div class="'.$fieldgroupval->fieldtype .'-input"><input id="'.$optionVal.'" class="" type="'.$fieldgroupval->fieldtype .'" name="'. $fieldgroupval->name .'[]" value="'.$optionVal.'" ><label for="'.$optionVal.'" class="label_style">'.$option.'</label></div>';
						}
					}
			} elseif(strpos($fieldgroupval->name, 'checkbox_') !== false) {
				$options = explode(',', $fieldgroupval->options);
				foreach($options as $option) {
		$string = sanitize_text_field($option);
		$optionVal = str_replace(" ","-",$string);
					if($options[0] == $option) {
					
					$form .= '<div class="'.$fieldgroupval->fieldtype .'-input"><input id="'.$optionVal.'" class="" type="'.$fieldgroupval->fieldtype .'" name="'. $fieldgroupval->name .'[]" value="'.$optionVal.'" checked=checked ><label for="'.$optionVal.'" class="label_style">'.$option.'</label></div>';
					} else {
					$form .= '<div class="'.$fieldgroupval->fieldtype .'-input"><input id="'.$optionVal.'" class="" type="'.$fieldgroupval->fieldtype .'" name="'. $fieldgroupval->name .'[]" value="'.$optionVal.'" ><label for="'.$optionVal.'" class="label_style">'.$option.'</label></div>';
					}
				}
			} elseif ($fieldgroupval->field_label == 'Porcentaje' && $fieldgroupval->fieldtype == 'number') {
				$form .= '<div class="percentage_val per_'.$percount++.'">';
				$form .= '<input class="input_field" type="'.$fieldgroupval->fieldtype .'" name="'. $fieldnames .'" value="" >';
				$form .= '<span >%</span></div>';
	  } elseif ($fieldgroupval->fieldtype == 'file') {
		$form .= '<div class="upload_file_field"><input type="text"><label for="'. $fieldnames .'"><span>Adjuntar</span><span class="upload-icon"><i class="fas fa-upload"></i></span></label></div><input class="input_field" id="'. $fieldnames .'" type="'.$fieldgroupval->fieldtype .'" name="'. $fieldnames .'" value="">';
	  } elseif ($fieldgroupval->fieldtype == 'button') {
		$form .= '<div id="results"></div><p class="tab-4-plus"><span class="button-icon" id="showprofile">+</span><span>'. $fieldgroupval->field_label .'</span>';
	  } else {
		   $form .= '<input class="input_field" type="'.$fieldgroupval->fieldtype .'" name="'.$fieldnames.'" value="" >';
			}
	  } 	
	}

			if($fieldgroupval->below_description !== '') {
				$form .= '<p>'.$fieldgroupval->below_description.'</p>';
			}
			 if($fieldgroupval->wrapper_class !== '') {
				 $form .= '</div></div>';
			 }

		 }
		 }
		 }
	 //	$form .= '</div>';
	 }

	 //}
	 }
	 $form .= '<div class="form_footer-buttons">';
	 if($i == count($Count)) {
	 $form .= '<input class="pre_btn" type="button" value="< Anterior"><input class="next_btn save_btn" name="save" type="button" value="Guardar">
	 <input class="submit_btn final_submit" name="submit_btn" type="submit" value="Enviar">';
 	} else {
	 $form .= '<input class="pre_btn" type="button" value="< Anterior"><input class="next_btn save_btn" name="save" type="button" value="Guardar"><input class="next_btn submit_btn" name="next" type="button" value="Siguiente">';
	 }
	 $form .= '<input type="hidden" id="form_id" name="form_id" value="'.esc_attr($a['id']).'"/>';

	 $form .= '</div></fieldset>';
	 }
 }
	 $form .= '</form>
 </div>';
	 return $form;
}
add_shortcode( 'stepform', 'stepform_func' );

?>