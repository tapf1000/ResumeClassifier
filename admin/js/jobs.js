$( document ).ready( function() {
	var root_url = '../api/index.php/';

	var current_job;

	get_jobs();

	function get_jobs() {
		$.ajax({
			url 		: root_url + 'jobs',
			method		: 'GET',
			dataType	: 'json',
			success		: function( data ) {
		
					
				var table_element = $( '#jobs_detail' );

                table_element.DataTable().clear();

                table_element.DataTable( {
                    "destroy" : true,
                    data: data,
                    columns: [
                        { title: "Job Code" },
                        { title: "Job Title" },
                        { title: "Salary" },
                        { title: "Status" },
                        { title: "Date Created" },
                        { title: "&nbsp;"},
						{}
                    ], columns: [
                        { "data": "job_code" },
                        { "data": "job_description" },
                        { "data": "salary" },
                        { "data": "job_status" },
                        { "data": "job_creation_date"},
                        {
                            "mRender": function( data, type, row ) {
                                return '<button class=".btn btn-info" id="' + row.job_id + '"><i class="fa fa-edit"></i>Edit</a>';
                            }
                        },
						{
							"mRender": function( data, type, row ) {
                                return '<button class=".btn btn-danger" id="' + row.job_id + '"><i class="fa fa-close"></i>Close</a>';
							}
						}
                    ]

                } );
			}, error 	: function( xhr, type ) {
				console.log( xhr, type );
			}	
		});
	}

	function render_job_details( job ) {
		if ( $.isEmptyObject( job ) ) {
			$( '#job_id' ).val( '' );
			$( '#job_code' ).val( '' );
			$( '#summary' ).val( '' );
			$( '#skills' ).val( '' );
			$( '#salary' ).val( '' );
			$( '#description' ).val( '' );
			$( '#job_status' ).val( '' );
			$( '#date_created' ).val( '' );
		} else {
			$( '#job_id' ).val( job.job_code );
			$( '#job_code' ).val( job.job_code );
			$( '#summary' ).val( job.job_summary );
			$( '#skills' ).val( job.skills );
			$( '#salary' ).val( job.salary );
			$( '#description' ).val( job.job_description );
			$( '#job_status' ).val( job.job_status );
			$( '#date_created' ).val( job.job_creation_date );
		}
	}

	$( document ).on( 'click', '.btn-info', function() {
		var job_id = $( this ).attr( "id" );
		get_job_details( job_id );
	});

	$( document ).on( 'click', '.btn-danger', function() {
		var job_id = $( this ).attr( "id" );
		close_job( job_id );
	});

	function get_job_details( job_id ) {
		$.ajax({
			url 		: root_url + 'jobs/' + job_id,
			method		: 'GET',
			dataType	: 'json',
			success 	: function( data ) {
				console.log( data );
				current_job = data;
				render_job_details( current_job );
			}, error 	: function( xhr, type ) {
				console.log( xhr, type );
			}
		});
	}

	function close_job( job_id ) {

		console.log( job_id );

		$.ajax({
			url 		: root_url + 'job/' + job_id,
			method		: 'PUT',
			dataType	: 'json',
			success		: function ( data ) {
				
				if ( !data.success ) {
					$( '#error_message' ).append( '<div class="alert alert-success">' + data.error.database + '</div>' );
				} else {
					$( '#error_message' ).append( '<div class="alert alert-success">' + data.message + '</div>' );
					window.location.href = 'jobs_applications.php?jobid=' + job_id;
				}
			}, error 	: function( xhr, type ) {
				console.log( xhr, type );
			} 
		});
	}

	$( '#job_details' ).submit( function() {
		$( '.form-group' ).removeClass( 'has-danger' ); // remove the error class
        $( '.form-control-danger' ).remove(); // remove the error text
        $( '#error_message' ).children().remove();

        $( '#btnSave' ).prop( 'disabled', true );

        if ( $( '#job_id' ).val() == "" ) {
            add_job();
        } else {
            update_job();
        }

        return false;
	});

	function add_job() {
		var form_data = $( '#job_details' ).serializeArray();

		$.ajax({
			url 		: root_url + 'job',
			method		: 'POST',
			dataType	: 'json',
			data 		: form_data,
			success 	: function( data ) {

				if ( !data.success ) {

					if ( data.errors.description ) {
						var element = $( '#description_grp' );
						element.addClass( 'has-danger' );
						element.append( '<div class="form-control form-control-danger">' + data.errors.description + '</div>' );
					}

					if ( data.errors.skills ) {
						var element = $( '#skills_grp' );
						element.addClass( 'has-danger' );
						element.append( '<div class="form-control form-control-danger">' + data.errors.skills + '</div>' );
					}

					if ( data.errors.summary ) {
						var element = $( '#summary_grp' );
						element.addClass( 'has-danger' );
						element.append( '<div class="form-control form-control-danger">' + data.errors.summary + '</div>' );
					}

					if ( data.errors.salary ) {
						var element = $( '#salary_grp' );
						element.addClass( 'has-danger' );
						element.append( '<div class="form-control form-control-danger">' + data.errors.salary + '</div>' );
					}

					if ( data.errors.database ) {
						$( '#error_message' ).append( '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + data.errors.database + 
							'</div>' );
					}
				} else {
					$( '#error_message' ).append( '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + data.message + 
						'</div>' );
					current_job = {};
					render_job_details( current_job );
					get_jobs();
				}
				$( '#btnSave' ).prop( 'disabled', false );
			}, error 	: function( xhr, type ) {
				console.log( xhr, type );
			}
		});
	}

	function update_job( $job_id ) {
		var form_data = $( '#job_details' ).serializeArray();
	}

});