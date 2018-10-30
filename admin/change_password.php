<?php
	session_start();
	require_once '../includes/functions.php';

	if ( !isset( $_SESSION['logged_user_id'] ) ) {
		redirect( 'sign_in.php' );
	}

	$page_title = 'Change Password';
	$data_tables = false;
	$js_file = 'users.js';

	require_once '../templates/admin_header.php';
?>	

<?php
	require_once '../templates/admin_footer.php';