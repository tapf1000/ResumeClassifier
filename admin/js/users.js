$( document ).ready( function() {

	var root_url = '../api/index.php';

	var current_user;

	get_users();

	function get_users() {
		$.ajax({
			url 		: root_url + '/users',
			method		: 'GET',
			dataType	: 'json',
			success		: function( data ) {
					
					var table_element = $( '#users_details' );

                    table_element.DataTable().clear();

                    table_element.DataTable( {
                        "destroy" : true,
                        data: data,
                        columns: [
                            { title: "First Name(s)" },
                            { title: "Surname" },
                            { title: "Email Address" },
                            { title: "&nbsp;"}
                        ], columns: [
                            { "data": "first_name" },
                            { "data": "last_name" },
                            { "data": "email" },
                            {
                                "mRender": function( data, type, row ) {
                                    return '<button class=".btn btn-info" id="' + row.user_id + '"><i class="fa fa-edit"></i>Edit</a>';
                                }
                            }
                        ]

                    } );
			}, error 	: function( xhr, type ) {
				console.log( xhr, type );
			}
		})
	}

	function render_user_details( user ) {
		if ( $.isEmptyObject( user ) ) {
			$( '#user_id' ).val( '' );
            $( '#first_name' ).val( '' );
            $( '#last_name' ).val( '' );
            $( '#email' ).val( '' );
            $( '#password' ).val( '' );
            $( '#password' ).prop( 'disabled', false );
		} else {
			$( '#user_id' ).val( user.user_id );
            $( '#first_name' ).val( user.first_name );
            $( '#last_name' ).val( user.last_name );
            $( '#email' ).val( user.email );
            $( '#password' ).val( '' );
            $( '#password' ).prop( 'disabled', true );
		}
	}

	$( document ).on( 'click', '.btn-info', function() {
		var user_id = $( this ).attr( "id" );
		get_user_details( user_id );
	});

	function get_user_details( user_id ) {
		$.ajax({
			url 		: root_url + '/users/' + user_id,
			method		: 'GET',
			dataType 	: 'json',
			success 	: function( data ) {

				current_user = data;
				render_user_details( current_user );
			}, error 	: function( xhr, type ) {
				console.log( xhr, type );
			}
		});
	}

	function add_user() {
		var form_data = $( '#user_details' ).serializeArray();

		$.ajax({
			method		: 'POST',
			dataType	: 'json',
			url 		: root_url + '/user',
			data 		: form_data,
			success		: function( data ) {

				if ( !data.success ) {

					$( '#password' ).val( '' );

					if ( data.errors.email ) {
						$( '#email_grp' ).addClass( 'has-danger' );
                        $( '#email_grp' ).append( '<div class="form-control form-control-danger">' + data.errors.email + '</div>' );
					}

					if ( data.errors.first_name ) {
						$( '#first_name_grp' ).addClass( 'has-danger' );
                        $( '#first_name_grp' ).append( '<div class="form-control form-control-danger">' + data.errors.first_name + '</div>' );
					}

					if ( data.errors.last_name ) {
						$( '#last_name_grp' ).addClass( 'has-danger' );
                        $( '#last_name_grp' ).append( '<div class="form-control form-control-danger">' + data.errors.last_name + '</div>' );
					}

					if ( data.errors.password ) {
						$( '#password_grp' ).addClass( 'has-danger' );
                        $( '#password_grp' ).append( '<div class="form-control form-control-danger">' + data.errors.password + '</div>' );
					}

					if ( data.errors.database ) {
                        $( '#error_message' ).append( '<div class="alert alert-danger">' + data.errors.database + '</div>' );
                    }
				} else {
					$( '#error_message' ).append( '<div class="alert alert-success">' + data.message + '</div>' );
                    current_user = {};
                    render_user_details( current_user );
                    get_users();
				}
				$( '#btnSave' ).prop( 'disabled', false );
			}, error 	: function( xhr, type ) {
				console.log( xhr, type );
			}
		});
	}

	function update_user( $user_id ) {
		var form_data = $( '#user_details' ).serializeArray();

		$.ajax({
			url 		: root_url + '/user/' + $( '#user_id' ).val(),
			method		: 'PUT',
			data 		: form_data,
			dataType	: 'json',
			success 	: function( data ) {

				if ( !data.success ) {

					if ( data.errors.email ) {
						$( '#email_grp' ).addClass( 'has-danger' );
                        $( '#email_grp' ).append( '<div class="form-control form-control-danger">' + data.errors.email + '</div>' );
					}

					if ( data.errors.first_name ) {
						$( '#first_name_grp' ).addClass( 'has-danger' );
                        $( '#first_name_grp' ).append( '<div class="form-control form-control-danger">' + data.errors.first_name + '</div>' );
					}

					if ( data.errors.last_name ) {
						$( '#last_name_grp' ).addClass( 'has-danger' );
                        $( '#last_name_grp' ).append( '<div class="form-control form-control-danger">' + data.errors.last_name + '</div>' );
					}

					if ( data.errors.database ) {
                        $( '#error_message' ).append( '<div class="alert alert-danger">' + data.errors.database + '</div>' );
                    }
				} else {
					$( '#error_message' ).append( '<div class="alert alert-success">' + data.message + '</div>' );
                    current_user = {};
                    render_user_details( current_user );
                    get_users();
				}
				$( '#btnSave' ).prop( 'disabled', false );
			}, error 	: function( xhr, type ) {
				console.log( xhr, type );
			}
		});
	}

	$( '#btnSave' ).click( function() {
		$( '.form-group' ).removeClass( 'has-danger' ); // remove the error class
        $( '.form-control-danger' ).remove(); // remove the error text
        $( '#error_message' ).children().remove();

        $( '#btnSave' ).prop( 'disabled', true );

        if ( $( '#user_id' ).val() == "" ) {
            add_user();
        } else {
            update_user();
        }

        return false;
	});

	$( '#login_form' ).submit( function() {
		$( '.form-group' ).removeClass( 'has-danger' ); // remove the error class
        $( '.form-control-danger' ).remove(); // remove the error text
        $( '#message' ).children().remove();

        $( '#btnLogin' ).prop( 'disabled', true );

        var form_data = $( '#login_form' ).serializeArray();

        $.ajax({
        	url 		: root_url + '/user_login',
        	method 		: 'POST',
        	dataType 	: 'json',
        	data 		: form_data,
        	success 	: function( data ) {

        		console.log( data );

        		if ( !data.success ) {

        			if ( data.errors.email ) {
        				$( '#email_grp' ).addClass( 'has-danger' );
        				$( '#email_grp' ).append( '<div class="form-control form-control-danger">' + data.errors.email + '</div>' );
        			}

        			if ( data.errors.password ) {
						$( '#password_grp' ).addClass( 'has-danger' );
                        $( '#password_grp' ).append( '<div class="form-control form-control-danger">' + data.errors.password + '</div>' );
					}

					if ( data.errors.database ) {
                        $( '#message' ).append( '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + data.errors.database + 
							'</div>' );
                    }

                    if ( data.errors.combination ) {
                        $( '#message' ).append( '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + data.errors.combination + 
							'</div>' );
                    }
        		} else {
        			$( '#message' ).append( '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + data.message + 
						'</div>' );
        			window.location.href = 'jobs.php';
        		}
        		$( '#btnLogin' ).prop( 'disabled', false );
        	}, error 	: function( xhr, type ) {
        		console.log( xhr, type );
        	}
        });
		return false;
	});
});