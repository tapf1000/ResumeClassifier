$( document ).ready( function() {
	
	var root_url = '../api/index.php';

	load_settings();

	$( '#settings_form' ).submit( function() {
	$( '.form-group' ).removeClass( 'has-danger' ); // remove the error class
        $( '.form-control-danger' ).remove(); // remove the error text
        $( '#error_message' ).children().remove();

        $( 'btnSettings' ).prop( 'disabled', true );

        var form_data = $( '#settings_form' ).serializeArray();

        $.ajax({
        	url 		: root_url + '/settings',
        	method		: 'POST',
        	data 		: form_data,
        	dataType	: 'json',
        	success		: function( data ) {

        		if ( !data.success ) {

        			if ( data.errors.email ) {
        				var element = $( '#email_grp' );
        				element.addClass( 'has-danger' );
                        element.append( '<div class="form-control form-control-danger">' + data.errors.email + '</div>' );
        			}

        			if ( data.errors.mobile ) {
        				var element = $( '#mobile_grp' );
        				element.addClass( 'has-danger' );
                        element.append( '<div class="form-control form-control-danger">' + data.errors.mobile + '</div>' );
        			}

        			if ( data.errors.address ) {
        				var element = $( '#address_grp' );
        				element.addClass( 'has-danger' );
                        element.append( '<div class="form-control form-control-danger">' + data.errors.address + '</div>' );
        			}
        		} else {
        			$( '#error_message' ).append( '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + data.message + 
						'</div>' );
        			load_settings();
        		}
        		$( 'btnSettings' ).prop( 'disabled', false );
        	}, error 	: function( xhr, type ) {
        		console.log( xhr, type );
        	}
        });

		return false;
	});


	function load_settings() {
		$.ajax({
			url 		: root_url + '/config_settings',
			method		: 'GET',
			dataType 	: 'json',
			success 	: function( data ) {
				display_details( data );
			}, error 	: function( xhr, type ) {
				console.log( xhr, type );
			}
		});
	}

	function display_details( details ) {
		$( '#email' ).val( details.email );
		$( '#mobile' ).val( details.mobile );
		$( '#address' ).val( details.address );
	}

        $( '#btnBackup' ).click( function() {
                $( '#error_message' ).children().remove();

                $( '#btnBackup' ).prop( 'disabled', true );
                $( 'btnSettings' ).prop( 'disabled', true );

                $.ajax({
                        url             : root_url + '/backup_database',
                        dataType        : 'json',
                        method          : 'GET',
                        success         : function( data ) {

                                if ( !data.success ) {
                                        $( '#error_message' ).append( '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + data.message + 
                                                '</div>' );
                                } else {
                                      $( '#error_message' ).append( '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + data.message + 
                                                '</div>' );  
                                }

                                $( '#btnBackup' ).prop( 'disabled', false );
                                $( 'btnSettings' ).prop( 'disabled', false );
                        }, error        : function( xhr, type ) {
                                console.log( xhr, type );
                        }
                });

                return false;
        });
});