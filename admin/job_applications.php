<?php 
	session_start();
	require_once '../includes/functions.php';

	if ( !isset( $_SESSION['logged_user_id'] ) ) {
		redirect( 'sign_in.php' );
	}

	$page_title = 'Job Applications';
	$js_file = 'job_applications.js';
	$data_table_css = 'dataTables.bootstrap.min.css';
	$data_tables = true;

	require_once '../templates/admin_header.php';
?>	
	<div class="row">
		<div class="col-sm-12">
			<table id="applications" class="table table-hover table-striped">
				<thead>
					<tr>
						<td>Applicant</td>
						<td>Job Code</td>
						<td>Job Description</td>
						<td>Date Applied</td>
					</tr>
				</thead>
			</table>
		</div>
	</div>
<?php 
	require_once '../templates/admin_footer.php';