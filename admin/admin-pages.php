<?php
if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class form_List extends WP_List_Table {

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
			$getforms= $wpdb->get_results("SELECT * FROM `wp_sf_form`");

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
		foreach($getforms as $datakey => $value){
			$data[] =array('id' => $value->id ,'title' => $value->form_title,'created_date' => $value->datetime, 'shortcode' => '[stepform id='. $value->id .']', 'action' => '<a href="?page=form-entries&action=view&form_id='.$value->id.'">View Entries</a>' );
		}
		return $data;
	 }
    function get_columns(){
        $columns = array(
					'id'		=> 'ID',
          'title' => 'Title',
          'shortcode'    => 'Shortcode',
          'created_date'   => 'Date',
					'action'	=> 'Actions'
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
					case 'id':
          case 'title':
          case 'shortcode':
          case 'created_date':
					case 'action':
            return $item[ $column_name ];
          default:
            return print_r( $item, true ) ; //Show the whole array for troubleshooting purposes
        }
      }
			function column_title($item) {
			  $actions = array(
			            'edit'      => sprintf('<a href="?page=add-stepform&action=edit&id='.$item['id'].'">Edit</a>',$_REQUEST['page'],'edit',$item['title']),
			            'delete'    => sprintf('<a href="?page=multistep-form&action=delete&id='.$item['id'].'">Delete</a>',$_REQUEST['page'],'delete',$item['title']),
			        );

			  return sprintf('%1$s %2$s', $item['title'], $this->row_actions($actions) );
			}
}

?>
