<?php
    /**
     * Created by PhpStorm.
     * User: Tabie
     * Date: 06-Apr-18
     * Time: 15:55
     */
    session_start();
    require_once '../includes/functions.php';
    require_once '../includes/database.php';

    if ( !isset( $_SESSION['logged_user_id'] ) ) {
        redirect( 'sign_in.php' );
    }

    $page_title = 'Resume ranking';
    $js_file = 'job_results.php';
    /**if ( filter_input( INPUT_GET, 'jobid', FILTER_VALIDATE_INT ) ) {
        $job_id = $_GET['jobid'];

        $sql = 'select job_description, job_code, job_skills, job_qualifications from tbljobs where job_id = job_id';
        $stmt = $database->prepare( $sql );
        $stmt->bindParam( ':job_id', $job_id, PDO::PARAM_INT );
        $stmt->execute();

        $row = $stmt->fetch( PDO::FETCH_ASSOC );

        $job_title = $row['job_description'] . ": " . $row['job_code'];

        $requisites[] = $row['job_qualifications'];

        $skills = explode( ",", $row['job_skills'] );

        foreach( $skills as $skill ) {
            $requisites[] = $skill;
        }

        $query = 'select ja.applicant, r.resume_text from job_applications ja inner join tblresumes r on ja.job_seeker_id ';
        $query .= '= r.job_seeker where ja.job_id = job_id';
        $statement = $database->query( $query );
        $statement->bindParam( ':job_id', $job_id, PDO::PARAM_INT );
        $statement->execute();

        $application_details = array();

        $job_seekers = array();
        while ( $my_row = $statement->fetch( PDO::FETCH_ASSOC ) ) {
            $row_data[] = $my_row['applicant'];
            foreach( $requisites as $requisite ) {
                if ( strpos( strtolower( $my_row['resume_text'] ), strtolower( $requisite ) ) !== false ) {
                    $row_data[] = "yes";
                } else {
                    $row_data[] = "no";
                }
            }

            $job_seekers[] = $row_data;
        }
    } else {
        die( 'not allowed' );
    } **/



    $data_table_css = 'dataTables.bootstrap.min.css';
    $data_tables = false;

    require_once '../templates/admin_header.php';
?>

    <div class="row">
        <div class="col-12">
            <h4><?php echo $page_title; ?></h4>
        </div>
    </div>

    <?php
        if ( isset( $_GET['file'] ) ) {
            $file = $_GET['file'];

            $filename = '../job_files/' . $file;

            $lines =  array();

            $counter = 1;
            if ($file = fopen($filename, "r")) {
                while(!feof($file)) {
                    $line = fgets($file);
                    if ( $counter == 1 ) {
                        $headers = explode( ',', $line );
                    } else {
                        if ( $lines !== "" ) {
                            $contents_row = explode( ',', $line );
                            $lines[] = $contents_row;
                        }
                    }

                    $counter++;
                }
                fclose($file);

            }

            ?>
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <td>&nbsp;</td>
                            <?php
                                foreach ( $headers as $header ) {
                                    ?>
                                    <td><?php echo $header; ?></td>
                                    <?php
                                }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ( $lines as $contents ) {
                                ?>
                                    <tr>
                                        <?php
                                            for ( $i = 0; $i < count( $contents ); $i++ ) {
                                                ?>
                                                <td><?php echo $contents[$i]; ?></td>
                                                <?php
                                            }
                                        ?>
                                    </tr>
                                <?php
                            }
                        ?>
                    </tbody>
                </table>
            <?php
        }
    ?>

<?php
    require_once '../templates/admin_footer.php';
