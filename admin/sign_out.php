<?php 
	session_start();
	require_once '../includes/functions.php';

	unset( $_SESSION['logged_user_id'] ); // log out the user
	redirect( 'sign_in.php' ); // redirect the user to sign_in.php
