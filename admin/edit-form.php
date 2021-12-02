<?php
global $wpdb;

$x = 1;
$field_array =array();
$fieldsinfo = array();
foreach ($_POST as $key => $value) {
//  for ($x = 0; $x <= count($_POST); $x++) {
if($key != 'addForm') {
$field_data = array('id' =>$x++,'type' => $key,'name' => $value );
$fieldsinfo[] = array_merge($field_array,$field_data);
}
}
//print_r(json_encode($fieldsinfo));
if (isset($_POST['addForm'])) {
 $wpdb->insert('wp_sf_form',array('form_title'=>$_POST['form_title'], 'field_name'=>json_encode($fieldsinfo)));
 $lastid = $wpdb->insert_id;
  echo "record inserted";
}
if (isset($_POST['updateForm'])) {
  $table_name = 'wp_sf_form';
  $data = array('form_title'=>$_POST['form_title'], 'field_name'=>json_encode($fieldsinfo));
  $where = array('id'=> $_GET['id']);
  //var_dump( $data);
$wpdb->update( $table_name, $data, $where );
}
$fields = array('text', 'textarea', 'number', 'email', 'tel', 'select', 'checkbox', 'radio', 'date', 'password', 'file', 'step','form-heading', 'html');
?>

<div class="form-sidebar-section">
<?php
foreach($fields as $field) { ?>
    <button class="show" value="<?php echo $field; ?>" ><?php echo $field; ?></button>
<?php }
?>
</div>
<div class="form-section">
<div id="popup">
  <form id="form">
    <button type="button" id="close" onclick="hide()">X</button>
    <br>
    <p1>Stepindex</p1>
    <br>
    <input id="stepIndex_popup" name="stepIndex_popup" type="number" value=""/>
    <br>
    <p1>Heading</p1>
    <br>
    <input id="field_heading" name="field_heading" type="text" value=""/>
    <br>
    <p1>Field label</p1>
    <br>
    <input id="field_label" name="field_label" type="text" value=""/>
    <br>
    <p1>Field Name</p1>
    <br>
    <input id="name" name="name" type="text" value="" />
    <br>
    <p1>Option values</p1>
    <br>
    <textarea id="options" name="options" type="text" value=""></textarea>
    <br>
    <p1>Below description</p1>
    <br>
    <input id="below_description" name="below_description" type="text" value=""/>
    <br>
    <p1>Wrapper class</p1>
    <br>
    <input id="wrapper_class" name="wrapper_class" type="text" value=""/>
    <br>
    <button type="button" id="submit" onclick="add()">Submit</button>
   </form>
</div>
<form action="" method="POST">
  <div id="">
    <?php
    if(isset($_GET['id']) && $_GET['action'] = 'edit') {
      global $wpdb;
      $id = $_GET['id'];
      $getformfields= $wpdb->get_results("SELECT * FROM `wp_sf_form` WHERE id = $id");
      foreach($getformfields as $fieldkey => $fieldvalue) {
      $formfiels = json_decode($fieldvalue->field_name);
		echo '<div class="sortable">';
	$stepCount = array();
      foreach ($formfiels as $fields) {
        if($fields->type == "form_title"){
          echo "<div class=''><label>Form Title</label>
          <input type='text' name='form_title' value='$fields->name'></div>";
          echo '<div class="step_container"><input id="stepIndex" type="hidden" name="step" value=""></div>';
          }
          $progress = 0;
          if (strpos($fields->type, '_step') !== false) {
         	 $Count[] = array_push($stepCount,strpos($stepIndex->type, '_step'));
        echo '<div class="stepbox" id="stepIndex"><p1>Step label</p1>
          <input id="name" name="'.$fields->type.'" type="text" value="'. $fields->name .'" required/></div>';
		  print_r($Count);
          }
        if($fields->type != "form_title" && $fields->type != "addForm" || $fields->type != "updateForm") {
        //  echo '<p>'.$fields->type.'</p>';
        $fieldsname = $fields->name;
        if (is_array($fields->name ) || is_object($fields->name )) {
          foreach ($fields->name as $fieldgroupkey => $fieldgroupval) {
        echo '<div class="editform-fieldsets connected-sortable "><div class="fieldset-group "><div class="fieldgroup-remove"><span><i class="fa fa-trash" aria-hidden="true"></i></span></div>
        <div class="fieldgroup-fields"><p1>Heading</p1>
          <input id="field_heading" name="'.$fields->type.'['.$fieldgroupkey.'][fieldheading]" type="text" value="'. $fieldgroupval->fieldheading .'"/>
          <p1>Field type</p1>
          <input id="field_label" name="'.$fields->type.'['.$fieldgroupkey.'][fieldtype]" type="text" value="'.htmlentities($fieldgroupval->fieldtype).'"/>
          <p1>Field label</p1>
          <input id="field_label" name="'.$fields->type.'['.$fieldgroupkey.'][field_label]" type="text" value="'.htmlentities($fieldgroupval->field_label).'"/>
          <p1>Field Name</p1>
          <input id="name" name="'.$fields->type.'['.$fieldgroupkey.'][name]" type="text" value="'. $fieldgroupval->name .'"/>
          <p1>Option values</p1>
          <textarea id="options" name="'.$fields->type.'['.$fieldgroupkey.'][options]">'. $fieldgroupval->options .'</textarea>
          <p1>Below description</p1>
          <input id="below_description" name="'.$fields->type.'['.$fieldgroupkey.'][below_description]" type="text" value="'. $fieldgroupval->below_description .'"/>
          <p1>Wrapper class</p1>
          <input id="wrapper_class" name="'.$fields->type.'['.$fieldgroupkey.'][wrapper_class]" type="text" value="'. $fieldgroupval->wrapper_class .'"/>
          <br></div></div></div>';
          }
        }
        }
      }
      }
  
      echo '<div id="results"></div>';
	echo '</div>';
      echo '<div class="form-submit"><button type="submit" id="updateForm" name="updateForm">Update</button></div>';
      } else {
     ?>
       <label>Form Title</label>
       <input type="text" name="form_title" value="">
    <div class='step_container'><input id="stepIndex" type="hidden" name="step" value=""></div>
    <div id="results"></div>
    <div class="form-submit">
		<button type="submit" id="addForm" name="addForm">Save</button>
	  </div>
	<?php } ?>
  </div>
</form>

</div>
