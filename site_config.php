<?php
	$database_configuration = array(
		'database_server'		=> 'localhost',
		'database_name'			=> 'it_jobs',
		'database_user'			=> 'skill_finder',
		'database_password'		=> 'my_Pswd00'
	);

	$salt_options = array(
		'cost'	=> 10
	);

	$params['sendmail_path'] = 'C:/usr/lib/sendmail';

	// array for upload errors
    $upload_errors = array (
        // http://www.php.net/manual/en/features.file-upload.errors.php
        UPLOAD_ERR_OK               => "No errors",
        UPLOAD_ERR_INI_SIZE         => "Image file must not be larger than 2MB",
        UPLOAD_ERR_FORM_SIZE        => "Image file must not be larger than 2MB",
        UPLOAD_ERR_PARTIAL          => "File has been partially uploaded",
        UPLOAD_ERR_NO_FILE          => "No file was uploaded",
        UPLOAD_ERR_NO_TMP_DIR       => "Temporary directory not set",
        UPLOAD_ERR_CANT_WRITE       => "Can't write to disk, check permission",
        UPLOAD_ERR_EXTENSION        => "File upload stopped by extension"
    );

    // set the max file size for uploads
    defined( 'MAX_FILE_SIZE' ) ? null : define( 'MAX_FILE_SIZE', 1048576 ); // set size limit of uploaded files to 2MB
    // DIRECTORY_SEPARATOR is a PHP pre-defined constant
    // ( \ for Windows, / ) for Unix
    defined( 'DS' ) ? null : define(  'DS', DIRECTORY_SEPARATOR );
    /** define the project's root path */
    defined( 'SITE_ROOT' ) ? null : define( 'SITE_ROOT', 'C:' . DS . 'Apache24' . DS . 'htdocs' . DS . 'skill-finder' );
    /** define the folder for uploaded resumes/cvs */
    defined( 'DOCS_DIR' ) ? null : define( 'DOCS_DIR', SITE_ROOT . DS . 'documents' );
    /** define the folder for database backups **/
    defined( 'BACKUP_DIR' ) ? null : define( 'BACKUP_DIR', SITE_ROOT . DS . 'database_backups' );

    /** set the default timezone to Africa, Harare **/
    ini_set( "date.timezone", "Africa/Harare" );
    