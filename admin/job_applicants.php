<?php
	session_start();
	require_once '../includes/functions.php';
	if ( !isset( $_SESSION['logged_user_id'] ) ) {
		redirect( 'sign_in.php' );
	}

	$page_title = 'Job Applicants';
	$js_file = 'job_seekers.js';
	$data_table_css = 'dataTables.bootstrap.min.css';
	$data_tables = true;

	require_once '../templates/admin_header.php';
?>	
	<div class="row">
		<div class="col-lg-12">
			<table class="table table-striped table-hover" id="applicants">
				<thead>
					<tr>
						<td>Name</td>
						<td>Email Address</td>
						<td>Gender</td>
						<td>Date of Birth</td>
						<td>Date Registered</td>
					</tr>
				</thead>
			</table>
		</div>
	</div>
<?php 
	require_once '../templates/admin_footer.php';