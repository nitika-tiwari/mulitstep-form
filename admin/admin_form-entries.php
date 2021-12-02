<?php
if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class formEntry_List extends WP_List_Table {

	/** Class constructor */
	public function __construct() {

		parent::__construct( [
			'singular' => __( 'Form', 'sp' ), //singular name of the listed records
			'plural'   => __( 'Forms', 'sp' ), //plural name of the listed records
			'ajax'     => false //should this table support ajax?

		] );

    }
		function get_items(){
			global $wpdb;
			$form_id = $_GET['form_id'];
			$getforms= $wpdb->get_results("SELECT * FROM `wp_sf_form` WHERE id = $form_id");

	/* 	$data = array(
		  array('ID' => 1,'booktitle' => 'Quarter Share', 'author' => 'Nathan Lowell',
		        'isbn' => '978-0982514542'),
		  array('ID' => 2, 'booktitle' => '7th Son: Descent','author' => 'J. C. Hutchins',
		        'isbn' => '0312384378'),
		  array('ID' => 3, 'booktitle' => 'Shadowmagic', 'author' => 'John Lenahan',
		        'isbn' => '978-1905548927'),
		  array('ID' => 4, 'booktitle' => 'The Crown Conspiracy', 'author' => 'Michael J. Sullivan',
		        'isbn' => '978-0979621130'),
		  array('ID' => 5, 'booktitle'     => 'Max Quick: The Pocket and the Pendant', 'author'    => 'Mark Jeffrey',
		        'isbn' => '978-0061988929'),
		  array('ID' => 6, 'booktitle' => 'Jack Wakes Up: A Novel', 'author' => 'Seth Harwood',
		        'isbn' => '978-0307454355')
		);*/
		$data = array();
    $entries = array();
		foreach($getforms as $datakey => $value){
      $getentries= $wpdb->get_results("SELECT * FROM wp_sf_form_entries INNER JOIN wp_sf_form_entries_meta ON(wp_sf_form_entries.id = wp_sf_form_entries_meta.entry_id)  WHERE wp_sf_form_entries.form_id = $value->id GROUP BY wp_sf_form_entries_meta.entry_id");
      foreach($getentries as $entrykey => $entryValue){
        $entries = $entryValue->datetime;

				$data[] =array('entry_id' => '<a href="?page=form-entries&action=view&entry_id='.$entryValue->entry_id.'">'.$entryValue->entry_id .'</a>', 'title' => $value->form_title,'created_date' => $value->datetime );

			}


		}
		return $data;
	 }
    function get_columns(){
        $columns = array(
          'entry_id' => 'entry_id',
          'title' => 'Form Title',
          'created_date'      => 'Date'
        );
        return $columns;
      }

    function prepare_items() {
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = array();
        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = $this->get_items();;
      }

      function column_default( $item, $column_name ) {
        switch( $column_name ) {
          case 'entry_id':
          case 'title':
          case 'created_date':
            return $item[ $column_name ];
          default:
            return print_r( $item, true ) ; //Show the whole array for troubleshooting purposes
        }
      }
		/*	function column_title($item) {
			  $actions = array(
			            'edit'      => sprintf('<a href="?page=multistep-form&action=%s&form=%s">Edit</a>',$_REQUEST['page'],'edit',$item['title']),
			            'delete'    => sprintf('<a href="?page=multistep-form&action=%s&form=%s">Delete</a>',$_REQUEST['page'],'delete',$item['title']),
			        );

			  return sprintf('%1$s %2$s', $item['title'], $this->row_actions($actions) );
			} */
}
