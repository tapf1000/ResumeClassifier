<?php
	require_once 'site_config.php';

	$dsn = 'mysql:dbname=' . $database_configuration['database_name'];
    $options = array(
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    );

    /**
     * create a new PDO instance, $pdo using the database credentials contained in config.php
     */
    try {
        $database = new PDO( $dsn, $database_configuration['database_user'], $database_configuration['database_password'], $options );
    } catch ( PDOException $e ) {
        echo $e->getMessage();
    }