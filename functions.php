<?php
	function redirect( $page = null ) {
		if ( $page !== null ) {
			header( "Location: {$page}" );
			exit;
		}
	}

	/**
     * Generate a random string, using a cryptographically secure pseudo-random random number generator( random_int )
     *
     * for PHP 7, random_int is a core function
     * for PHP 5.0 depends on https://github.com/paragonie/random_compat
     *
     * @param $length number of characters in random string
     * @param string $key_space A string of all possible characters to choose from
     * @return string $string
     */
    function random_string( $length, $key_space = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ' ) {

        $string = "";
        if ( function_exists( "random_int" ) ) { // PHP version >= 7, use random_int to generate the random string
            $max = mb_strlen( $key_space, '8bit' ) - 1;
            for( $i = 0; $i < $length; $i++ ) {
                $string .= $key_space[random_int( 0, $max)];
            }
        } else { // PHP version <= 7, use random_compat to create the random string
            $length = $length / 2;
            $random_string = random_bytes( $length );

            $string = bin2hex( $random_string );
        }

        return $string;
    }

    function extract_resume_text( $filename ) {
        $files = explode( '.', $filename );
        $extension = end( $files );

        /** check if its docx file */
        if ( $extension === "docx" )
            $datafile = 'word/document.xml';
        else
            $datafile = 'content.xml'; /** odt file */

        $zip = new ZipArchive; /** create a new Zip object */

        /** open the archive file */
        if ( true === $zip->open( $filename ) ) {
            /** search for data file in the archive */
            if ( ( $index = $zip->locateName( $datafile ) ) !== false ) {
                $text = $zip->getFromIndex( $index ); /** read index to text */
                /** load XML from a string */
                /** igonore errors and warning */
                $xml = new DOMDocument();

                $xml->loadXML( $text, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING );

                return strip_tags( $xml->saveXML() ); /** remove XML formatting tags and return the text */
            }

            $zip->close(); /** close the archive file */
        }

        /** In case of failure return a message */
        return "File not found";
    }

    function doc_to_text( $filename ) {
        $file_handle = fopen( $filename, "r" );
        $line = @fread( $file_handle, filesize( $filename ) );
        $lines = explode( chr( 0x0D), $line );
        $out_text = '';

        foreach( $lines as $this_line ) {
            $pos = strpos( $this_line, chr( 0x00) );
            if ( ( $pos !== false ) || ( strlen( $this_line ) === 0 ) ) {

            } else {
                $out_text .= $this_line . " ";
            }
        }
        $out_text = preg_replace( "/[^a-zA-Z0-9\s\,\.\-\n\r\t@\/\_\(\)]/","",$out_text );
        return $out_text;
    }

    function stop_words( $text, $stop_words ) {
        /**
         * remove line breaks and commas from stop words
         */

        $stopwords = array_map( function( $x ){ return trim( strtolower( $x ) ); }, $stop_words );

        // Replace all non-word chars with comma
        $pattern = '/[0-9\W]/';
        $text = preg_replace($pattern, ',', $text);

        // Create an array from $text
        $text_array = explode(",", $text );

        // remove whitespace and lowercase words in $text
        $text_array = array_map(function($x){return trim(strtolower($x));}, $text_array);

        foreach ($text_array as $term) {
            if (!in_array($term, $stopwords)) {
                $keywords[] = $term;
            }
        };

        return json_encode( array_filter( $keywords ) );
    }