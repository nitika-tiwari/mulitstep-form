<?php
add_action('fluentform_submission_inserted', 'your_custom_after_submission_function', 20, 3);

function your_custom_after_submission_function()
{
  if($form->id != 5) {
      return;
   }

   global $wpdb;

	if (isset($_POST['submit_btn'])) {
		global $wpdb;
		$GText = $_POST['input_text'];
		$wpdb->insert('sg_AdminPage',array('GymName'=>$Gtext));
        echo "record inserted";
	}

}
