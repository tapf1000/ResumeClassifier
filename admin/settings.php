<?php
	session_start();
	require_once '../includes/functions.php';

	if ( !isset( $_SESSION['logged_user_id'] ) ) {
		redirect( 'sign_in.php' );
	}

	$page_title = 'Settings';
	$js_file = 'settings.js';
	$data_tables = false;

	require_once '../templates/admin_header.php';
?>

	<div class="row">
		<span class="page_title">Contact Details</span>

		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12" id="error_message">
					
				</div>
			</div>

			<form action="" method="post" id="settings_form">

				<div class="row">
					
					<div class="col-md-5">
						<div class="form-group" id="email_grp">
							<label for="email">Email Address</label>
							<input type="email" id="email" name="email" class="form-control" placeholder="Email Address" />
						</div>
					</div>

					<div class="col-md-5">
						<div class="form-group" id="mobile_grp">
							<label for="mobile">Mobile Number</label>
							<input type="text" id="mobile" name="mobile" class="form-control" placeholder="Mobile Phone Number" />
						</div>
					</div>

				</div>

				<div class="row">
					
					<div class="col-md-10">
						<div class="form-group" id="address_grp">
							<label for="address">Address</label>
							<textarea id="address" name="address" class="form-control" placeholder="Business Address" rows="5"></textarea>
						</div>
					</div>

				</div>
				
				<button type="submit" id="btnSettings" class="btn btn-primary">Save</button><br /><br />

			</form>
		</div>

	</div>

	<div class="row">
		<div class="col-lg-6">
			<button type="submit" id="btnBackup" class="btn btn-primary">Backup Database</button>
		</div>
	</div>
<?php 
	require_once '../templates/admin_footer.php';