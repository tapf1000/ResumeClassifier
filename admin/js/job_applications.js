$( document ).ready( function() {

	get_job_applications();

	function get_job_applications() {
		$.ajax({
			url			: '../api/index.php/job_applications',
			method		: 'GET',
			dataType 	: 'json',
			success		: function( data ) {

					var table_element = $( '#applications' );

                    table_element.DataTable().clear();

                    table_element.DataTable( {
                        "destroy" : true,
                        data: data,
                        columns: [
                            { title: "Applicant" },
                            { title: "Job Code" },
                            { title: "Job Description" },
                            { title: "Date Applied"},
                        ], columns: [
                            { "data": "applicant" },
                            { "data": "job_code" },
                            { "data": "job_description" },
                            { "data": "date_applied" },
                        ]

                    } );

			}, error 	: function( xhr, type ) {
				console.log( xhr, type );
			}
		});
	}

});