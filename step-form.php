<?php
/* Plugin Name: Multistep form
Description: It contains various kind of form fields with multiple step in single form
Version: 1.0
Author: expert Dev
Author URI:
*/

/**
 * Activation hook
 **/
function step_form_plugin_activation() {
  ob_start();
require_once('step_form_plugin_activation.php');
ob_end_clean();
}
register_activation_hook(__FILE__, 'step_form_plugin_activation');

/**
 *  Deactivation hook
 **/
function step_form_plugin_deactivation() {
}
register_deactivation_hook(__FILE__, 'step_form_plugin_deactivation');

/**
 * Plugin scripts and styles
 */
add_action('admin_enqueue_scripts', 'stepform_plugin_scripts');
function stepform_plugin_scripts() {

wp_enqueue_script('jquery');
wp_enqueue_script( 'jquery-ui-sortable');
wp_enqueue_script( 'jquery-ui-droppable');
wp_enqueue_script( 'stepform_js', plugin_dir_url( __FILE__ ) . 'assets/js/stepform.js' );
wp_enqueue_script( 'custom-jquery', 'https://code.jquery.com/jquery-1.12.4.js' );
wp_enqueue_script( 'custom-tweenmax', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/1.13.1/TweenMax.min.js' );
wp_enqueue_script( 'jquery-ui_draggable', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/1.13.1/utils/Draggable.min.js' );
wp_enqueue_style( 'stepform_css', plugin_dir_url( __FILE__ ) . 'assets/css/stepform.css' );
wp_enqueue_style( 'form-fontawesome', 'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
  wp_enqueue_style( 'jqueryui_css', 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css' );
}

function stepform_frontend_script_func() {
   // wp_enqueue_script("jquery");
    wp_enqueue_script( 'stepform_frontend', plugin_dir_url( __FILE__ ) . 'assets/js/frontend.js' );
    wp_enqueue_script( 'jquery-validate', 'http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js' );
   wp_localize_script( 
    'stepform_frontend', 
    'ajax_object', 
    array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) 
  ); 
  wp_enqueue_style( 'stepform_frontend', plugin_dir_url( __FILE__ ) . 'assets/css/frontend.css' );

}
add_action('wp_enqueue_scripts', 'stepform_frontend_script_func');
/**
 * Register a custom menu page.
 */
function stepform_admin_menu_page() {
    add_menu_page(
        __( 'Multistep forms', 'textdomain' ),
        'Multistep form',
        'manage_options',
        'multistep-form',
        'admin_forms_view'
    );
    add_submenu_page(
        'multistep-form',
        'Add New',
        'Add New',
        'manage_options',
        'add-stepform',
        'add_stepform'
    );
    add_submenu_page(
        '',
        '',
        '',
        'manage_options',
        'form-entries',
        'form_entries'
    );
    add_submenu_page(
        'multistep-form',
        'Setting',
        'Setting',
        'manage_options',
        'form_settings',
        'form_settings'
    );
}
add_action( 'admin_menu', 'stepform_admin_menu_page' );

function admin_forms_view(){
    require_once( 'admin/admin-pages.php');
    $myListTable = new form_List();
    echo '<div class="wrap"><h1 class="wp-heading-inline"> Forms</h1>';
    echo '<a href="admin.php?page=add-stepform" class="page-title-action">Add New Form</a>';
    $myListTable->prepare_items();
    $myListTable->display();
    echo '</div>';

    if(isset($_GET['id']) && $_GET['action'] = 'delete') {
      global $wpdb;
  //    $wpdb->query("DELETE FROM `wp_sf_form` WHERE 'id'= ");
      $id = $_GET['id'];
      $table = 'wp_sf_form';
      $delete = $wpdb->delete( $table, array( 'id' => $id ) );
      if($delete) {
          echo "Form deleted successfully";
      }
    }

    /*=============================*/

}

function add_stepform(){

  if(!isset($_GET['id']) && $_GET['action'] != 'edit') {
    require_once('admin/admin_add-form.php');
  } else {
    require_once('admin/edit-form.php');
  }

}

function form_settings() {
  echo "test";
}
function form_entries(){
//  echo 'test';
        if(isset($_GET['form_id'])) {
      require_once('admin/admin_form-entries.php');
      $myListTable = new formEntry_List();
      echo '<div class="wrap"><h1 class="wp-heading-inline">Entries</h1>';
      $myListTable->prepare_items();
      $myListTable->display();
      echo '</div>';
      } else {
        echo '<div class="wrap">';
        if(isset($_GET['entry_id'])) {
          require_once('admin/view-entries.php');
        } else {
          echo "No entries found in form.";
        }
        echo '<div>';
      }
}

/*=============Form submit ajax=============*/

add_action( "wp_ajax_myaction", "so_wp_ajax_function" );
add_action( "wp_ajax_nopriv_myaction", "so_wp_ajax_function" );
function so_wp_ajax_function(){
  global $wpdb;
  $token = $_POST['token'];
  $form_id = $_POST['form_id'];
  $fname = json_encode($_POST['fields']);
  $params = add_query_arg( $_POST['fields'], '');

  setcookie('token', $_POST['token'], time()+62208000, '/', $_SERVER['HTTP_HOST']);
  $tmp_data = $wpdb->get_results("SELECT * FROM `wp_sf_tempentries` WHERE `form_id` = '$form_id' AND `form_title` = '$token'");
  //var_dump($tmp_data[0]);
  if($tmp_data[0] == '') {
   // var_dump($fname);
  $insert = $wpdb->insert($wpdb->prefix .'sf_tempentries',array('form_id'=>$form_id, 'form_title'=>$token, 'field_temp'=>json_encode($_POST['fields'])));
  } else {
    $tbl_name = $wpdb->prefix .'sf_tempentries';
	$id = $tmp_data[0]->id;
	
	$wpdb->delete( $tbl_name, array( 'id' => $id ) );
	  $insert = $wpdb->insert($wpdb->prefix .'sf_tempentries',array('form_id'=>$form_id, 'form_title'=>$token, 'field_temp'=>json_encode($_POST['fields'])));

   /* $updatedata = array('field_temp'=>json_encode($_POST['fields']));
    $where = array('form_id'=> $form_id, 'form_title'=> $token); 
  $wpdb->update( $tbl_name, $updatedata, $where );
    /* $sql ="UPDATE $tbl_name
    SET `field_temp`= '".$updatedata."'
WHERE  `form_id` = '".$form_id."' AND `form_title` = '".$token."'";
 
$rez = $wpdb->query($sql); */
//var_dump($fname);
  }
  wp_die(); // ajax call must die to avoid trailing 0 in your response
}

require_once( 'frontend/frontend-forms.php');
require_once( 'frontend/templates/form-view.php');

/*========================*/
/*function set_new_cookie() {
  //setting your cookies there
  setcookie("TestCookie", $value, time()+3600); 
  
}
add_action( 'init', 'set_new_cookie'); */
?>
