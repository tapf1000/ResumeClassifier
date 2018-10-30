<?php 
	session_start();

	if ( isset( $_SESSION['logged_user_id'] ) ) {
		redirect( 'index.php' );
	}

	$page_title = 'Admin Login';
	$js_file = 'users.js';

	require_once '../templates/admin_login_header.php';
?>	

	<div class="row">
		
		<div class="col-lg-6 login_box">

			<span class="page_title"><?php echo $page_title; ?></span>
			<div class="row">
                <div class="col-lg-12" id="message">

                </div>
            </div>

            <form action="" method="post" id="login_form">

				<div class="row">
            		
            		<div class="col-lg-8">
            			<div class="form-group" id="email_grp">
            				<label for="email">Email Address</label>
            				<input id="email" type="text" class="form-control" name="email" placeholder="Email address" />
            			</div>
            		</div>

            	</div>

            	<div class="row">
            		
            		<div class="col-lg-8">
            			<div class="form-group" id="password_grp">
            				<label for="password">Password</label>
            				<input type="password" id="password" name="password" class="form-control" placeholder="Password" />
            			</div>
            		</div>

            	</div>
            	<button type="submit" class="btn btn-primary" id="btnLogin"><i class="fa fa-sign-in"></i> Sign In</button>

            	<br /><br />
            </form>
		</div>
	</div>
<?php
	require_once '../templates/blank_footer.php';