<?php 
	session_start();
	require_once '../includes/functions.php';

	if ( !isset( $_SESSION['logged_user_id'] ) ) {
		redirect( 'sign_in.php' );
	}

	$page_title = 'Jobs';
	$js_file = 'jobs.js';
	$data_table_css = 'dataTables.bootstrap.min.css';
	$data_tables = true;

	require_once '../templates/admin_header.php';
?>	
	<div class="row">
		<span class="page_title">Job Details</span>

		<div class="col-lg-12">
			
			<div class="row">
				<div class="col-lg-12" id="error_message">
					
				</div>
			</div>

			<form action="" method="post" id="job_details">
				
				<div class="row">

					<div class="col-md-5">
						<input type="hidden" id="job_id" name="job_id" />
						<div class="form-group" id="description_grp">
							<label for="description">Job Title</label>
							<textarea id="description" name="description" rows="2" class="form-control" placeholder="Job Title"></textarea>
						</div>
					</div>

					<div class="col-md-5">
						<div class="form-group" id="summary_grp">
							<label for="summary">Qualifications</label>
							<textarea id="summary" name="summary" rows="6" class="form-control" placeholder="Qualifications separated by commas"></textarea>
						</div>
					</div>

				</div>

				<div class="row">
					
					<div class="col-md-5">
						<div class="form-group" id="skills_grp">
							<label for="skills">Required Skills</label>
							<textarea id="skills" name="skills" rows="8" class="form-control" placeholder="Key Skills, separated by commas"></textarea>
						</div>
					</div>

					<div class="col-sm-2">
						<div class="form-group" id="salary_grp">
							<label for="salary">Salary</label>
							<input id="salary" name="salary" type="text" class="form-control" placeholder="Salary" />
						</div>
					</div>

				</div>

				<div class="row">

					<div class="col-md-4">
						<div class="form-group">
							<label for="job_code">Job Code</label>
							<input type="text" id="job_code" name="jb_code" readonly class="form-control" />
						</div>
					</div>

					<div class="col-md-4">
						<div class="form-group">
							<label for="job_status">Status</label>
							<input type="text" id="job_status" readonly class="form-control" name="job_status" />
						</div>
					</div>

					<div class="col-md-4">
						<div class="form-group">
							<label for="date_created">Date Created</label>
							<input type="text" id="date_created" name="date_created" readonly class="form-control" />
						</div>
					</div>

				</div>
				<button id="btnSave" type="submit" class="btn btn-primary">Save</button>
				<br /><br />

			</form>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<table class="table table-hover table-striped" cellspacing="0" id="jobs_detail" width="100%">
				<thead>
					<tr>
						<td>Job Code</td>
						<td>Job Title</td>
						<td>Salary</td>
						<td>Job Status</td>
						<td>Date Created</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</thead>
			</table>
		</div>
	</div>
<?php
	require_once '../templates/admin_footer.php';