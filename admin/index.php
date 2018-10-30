<?php 
	session_start();
	require_once '../includes/functions.php';

	if ( !isset( $_SESSION['logged_user_id'] ) ) {
		redirect( 'sign_in.php' );
	}

	$page_title = 'Dashboard';
	$js_file = 'dashboard.js';
	$data_tables = false;

	require_once '../templates/admin_header.php';
?>	

<?php
	require_once '../templates/admin_footer.php';
	