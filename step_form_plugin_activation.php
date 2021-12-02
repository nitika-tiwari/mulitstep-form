<?php
global $wpdb;
$charset_collate = $wpdb->get_charset_collate();
$formdata_tbl = $wpdb->prefix .'sf_form_entries';
$formentries_tbl = $wpdb->prefix .'sf_form_entries_meta';
$form_tbl = $wpdb->prefix .'sf_form';
$sf_tempentries = $wpdb->prefix .'sf_tempentries';
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
$sql = "CREATE TABLE $formdata_tbl (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    form_id varchar(55) NOT NULL,
    datetime datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
    UNIQUE KEY id (id)
) $charset_collate;";
dbDelta( $sql );
$form_query = "CREATE TABLE $form_tbl (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    datetime datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
    form_title varchar(55) NOT NULL,
    field_name text(255) NOT NULL,
    UNIQUE KEY id (id)
) $charset_collate;";
dbDelta( $form_query );
$entry_meta = "CREATE TABLE $formentries_tbl (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    entry_id varchar(55) NOT NULL,
    meta_key varchar(255) NOT NULL,
    meta_value varchar(255) NOT NULL,
    datetime datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
    UNIQUE KEY id (id)
) $charset_collate;";
dbDelta( $entry_meta );
$temp_query = "CREATE TABLE $sf_tempentries (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    form_id int(11) NOT NULL,
    datetime datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
    form_title varchar(55) NOT NULL,
    field_temp text(255) NOT NULL,
    UNIQUE KEY id (id)
) $charset_collate;";
dbDelta( $temp_query ); 
?>
