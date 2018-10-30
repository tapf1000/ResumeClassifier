$( document ).ready( function() {

	get_job_seekers();

	function get_job_seekers() {
		$.ajax({
			url 		: '../api/index.php/job_seekers',
			method		: 'GET',
			dataType	: 'json',
			success		: function( data ) {

					var table_element = $( '#applicants' );

                    table_element.DataTable().clear();

                    table_element.DataTable( {
                        "destroy" : true,
                        data: data,
                        columns: [
                            { title: "Name" },
                            { title: "Email Address" },
                            { title: "Gender" },
                            { title: "Date of Birth;"},
                            { title: "Date Registered" }
                        ], columns: [
                            { "data": "name" },
                            { "data": "email" },
                            { "data": "gender" },
                            { "data": "date_of_birth" },
                            { "data": "date_registered" }
                        ]

                    } );

			}, error 	: function( xhr, type ) {
				console.log( xhr, type );
			}
		});
	}
});