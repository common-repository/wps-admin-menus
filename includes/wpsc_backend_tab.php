<?php

/*
File: Setup plugin WPS Admin Menus
Author: Leigh Gregg (wpscomplete.com)
Author URI: https://wpscomplete.com
Copyright 2019 wpscomplete.com. All rights reserved.
*/

if ( ! defined( 'ABSPATH' ) ) { exit; }


if( ! get_option( 'wpsc_backend_user_restrict', false ) ){
	wpsc_update_available_roles_backend_access();
}


?>

<h3>Resrict backend access</h3>
<h4>Select user roles you wish to restrict from the backend administration area.</h4>
<form action="" method="post">
<?php


$current_user_settings = get_option( 'wpsc_backend_user_restrict', false);

echo "<ul>";
foreach($current_user_settings as $key => $value ){

	$checked = $value['backend'] == 1 ? 'checked' : ''; 

	//admin or super admin cannot be restricted
	if($key == 'administrator' || $key == 'super_admin'){
		$disbabled = 'disabled';	
	} else {
		$disbabled = '';	
	}
	
	echo "<li>";
		echo 	'<label >'.
					'<input ' . $checked . " " . $disbabled .' type="checkbox" name="backend_access[]" value="'.$value['role'].'" >'. $value['name'] 
				.'</label>';
	echo "</li>";
}
echo "</ul>";

?>


	<input type="hidden" name="WPS-action" value="update-selected-roles-backend"/>
	<?php wp_nonce_field( 'wpsc_update_backend_access', 'wpsc_update_backend_access' ); ?>
	<?php submit_button("Update backend access"); ?>
</form>



<hr/>
<h4>Modified user roles on your site?</h4>
<p>If you have changed the user roles available on your website you will need to run this updater. New user roles will have backend access as default until you run the updater.</p>
<form action="" method="post">
	<input type="hidden" name="WPS-action" value="update-available-roles-backend"/>
	<?php wp_nonce_field( 'wpsc_update_backend_access_roles', 'wpsc_update_backend_access_roles' ); ?>
	<?php submit_button("Update user roles"); ?>
</form>
