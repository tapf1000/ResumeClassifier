<?php
	session_start();
	require_once '../includes/functions.php';

	if ( !isset( $_SESSION['logged_user_id'] ) ) {
		redirect( 'sign_in.php' );
	}

	$page_title = 'Users';
	$js_file = 'users.js';
    $data_table_css = 'dataTables.bootstrap.min.css';
    $data_tables = true;
    
	require_once '../templates/admin_header.php';
?>
	<div class="row">
		<span class="page_title">User Details</span>
		<div class="col-lg-12">
			<div class="row">
                <div class="col-lg-12" id="error_message">

                </div>
            </div>

            <form action="" method="post" id="user_details">
            	
            	<div class="row">
            		<div class="col-sm-3">
                        <div id="first_name_group" class="form-group">
                            <input type="hidden" id="user_id" name="user_id" />
                            <label for="first_name">First Name</label>
                            <input id="first_name" type="text" name="first_name" class="form-control" placeholder="Enter user first name" />
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div id="last_name_group" class="form-group">
                            <label for="last_name">Surname</label>
                            <input id="last_name" type="text" name="last_name" class="form-control" placeholder="Enter user surname" />
                        </div>
                    </div>
            	</div>

				<div class="row">
            		<div class="col-sm-4">
            			<div class="form-group" id="email_grp">
            				<label for="email">Email Address</label>
            				<input id="email" type="email" class="form-control" name="email" placeholder="Email address" />
            			</div>
            		</div>

            		<div class="col-sm-4">
            			<div class="form-group" id="password_grp">
            				<label for="password">Password</label>
            				<input type="password" id="password" name="password" class="form-control" placeholder="Password" />
            			</div>
            		</div>
            	</div>

            	<button type="submit" class="btn btn-primary" id="btnSave">Save</button>

            	<br /><br />
            </form>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12">
			<table class="table table-striped table-hover" id="users_details">
				<thead>
					<tr>
						<th>First Name(s)</th>
						<th>Surname</th>
						<th>Email Address</th>
						<th>&nbsp;</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
<?php 
	require_once '../templates/admin_footer.php';