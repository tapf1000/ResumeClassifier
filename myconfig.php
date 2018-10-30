<?php

    /**
     * Created by PhpStorm.
     * User: dinhunzvi
     * Date: 3/28/2017
     * Time: 09:56
     * myconfig.php - class to read and write to configuration settings file
     */
    class MyConfig {

        public static function read ( $filename ) {
            $config = include_once $filename;
            return $config;
        }

        public static function write( $filename, array $config ) {
            $config = var_export( $config, true );
            file_put_contents( $filename, "<?php return $config;" );
        }
    }