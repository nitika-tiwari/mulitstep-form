<?php
global $wpdb;
$entry_id = $_GET['entry_id'];
$getentries= $wpdb->get_results("SELECT * FROM wp_sf_form_entries_meta WHERE entry_id = $entry_id");
  echo '<table><tbody>';
foreach($getentries as $entrykey => $entryValue){
  $metaval = json_decode($entryValue->meta_value);
  $metakey = $entryValue->meta_key;
  $getname = str_replace("-"," ",$metakey);
  $getvalue = str_replace("-"," ", explode(',', $entryValue->meta_value));
  $name =  substr($getname, strrpos($getname, '_' )+1)."\n";
  if($metakey != 'submit_btn'){
    if(strpos($metakey, 'file_') !== false) {
  echo '<tr><td><strong>'.$name .'</strong></td><td><a href="'.wp_get_attachment_url($metaval).'">'.wp_get_attachment_url($metaval).'</a></td></tr>';
} elseif(strpos($metakey, 'checkbox_') !== false || strpos($metakey, 'radio_') !== false) {
  echo '<tr><td><strong>'.$name .'</strong></td><td>';

  foreach($getvalue as $fvalue) {
  echo $fvalue.'<br />';
    }
  echo '</td></tr>';
  }
    else {
      echo '<tr><td><strong>'.$name .'</strong></td><td>'.$metaval.'</td></tr>';
    }

  }

}
  echo '</tbody</table>';
