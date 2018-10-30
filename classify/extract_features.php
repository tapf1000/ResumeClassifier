
<!DOCTYPE html>
<html>
<head>
<title>C.V Ranking</title>
<head>
<body>
<?php
			session_start();
			require_once 'templates/header.php';
			require_once ("classify_nn_train.php");
			function match_pattern($fname, $preg){
				$value ="";
				if((empty($fname))){
					echo "<h2> No C.V File Picked Up</h2>";
				}else{
					if(preg_match_all($preg,$fname, $match)){
						foreach($match as $subArr){
							foreach($subArr as $val){
								$value =$val;
							}
						}
					}
				}
				return $value;
			}
						
$servername = "localhost";
$username = "root";
$password = "tapf1000";
$dbname = "it_jobs";

// Create connection
$conn = new mysqli($servername,$username, $password,$dbname);

if($conn->connect_error){
	echo "error connectiing to DB ".$conn->connect_error;
}


$CVs = array();
$k = 0;
$i = 0;
$j = 0;
$l = 0;
$deets = array();
$IDs = array();
$result = $conn->query("SELECT * FROM tbljobs");

if($result->num_rows>0){
	echo "<table>";
	echo "<th>TITLE</th><th>CODE</th><th>STATUS</th><th>QUALIFICATIONS</th><th>OTHER SKILLS</th><th>POSTED DATE</th>";
	while( $row = $result->fetch_assoc()){
	$skillz = $row['job_skills'];
		echo "<tr><td><a href='extract_features.php?skillz={$row['job_skills']}'>{$row['job_description']}</a></td><td>{$row['job_code']}</td><td>{$row['job_status']}</td><td>{$row['job_qualifications']}</td><td>$skillz</td><td>{$row['job_creation_date']}</td></tr>";			
	}	
	echo "</table>";
}

function job_seeker_details($id, $con){
			$details = array();
			$result = $con->query("SELECT * FROM `tbljob_seekers` WHERE `tbljob_seekers`.`job_seeker_id` = $id");
			if($result->num_rows>0){
				$row = $result->fetch_assoc();
				$details[0] = $row['first_name'];
				$details[1] = $row['last_name'];
				$details[2] = $row['email'];
			}
			return $details;
}

if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['skillz'])){
		
		$result = $conn->query("SELECT resume_text, job_seeker FROM tblresumes");
		 if($result->num_rows>0){
		 	while( $row = $result->fetch_assoc()){
		 		$CVs[$k] = strtolower($row['resume_text']);
		 		$k++;
		 		$IDs[$l] =  job_seeker_details($row['job_seeker'], $conn);
		 		$l++;
		 	}
		 }
		 $skills = explode(",",strtolower($_GET["skillz"]));
		 $reg = array("phd"=>"/phd\s?\w*\(?\w+\)?\s?\w+\s?\w+\s?\w+|doctorate\s?\w*\(?\w+\)?\s?\w+\s?\w+\s?\w+|doctor\s?\w*\(?\w+\)?\s?\w+\s?\w+\s?\w+|philosophy\s?\w*\(?\w+\)?\s?\w+\s?\w+\s?\w+|mph\.d\s?\w*\(?\w+\)?\s?\w+\s?\w+\s?\w+/","masters"=>"/msc\s?\w*\(?\w+\)?\s?\w+\s?\w+\s?\w+|m\.a\s?\w*\(?\w+\)?\s?\w+\s?\w+\s?\w+|master\s?\w*\(?\w+\)?\s?\w+\s?\w+\s?\w+|m\.com\s?\w*\(?\w+\)?\s?\w+\s?\w+\s?\w+|m\.eng\s?\w*\(?\w+\)?\s?\w+\s?\w+\s?\w+|m\.tech\s?\w*\(?\w+\)?\s?\w+\s?\w+\s?\w+/","bachelors"=>"/bsc\s?\w*\(?\w+\)?\s?\w+\s?\w+\s?\w+|b\.a\s?\w*\(?\w+\)?\s?\w+\s?\w+\s?\w+|bachelor\s?\w*\(?\w+\)?\s?\w+\s?\w+\s?\w+|b\.com\s?\w*\(?\w+\)?\s?\w+\s?\w+\s?\w+|b\.eng\s?\w*\(?\w+\)?\s?\w+\s?\w+\s?\w+|b\.tech\s?\w*\(?\w+\)?\s?\w+\s?\w+\s?\w+/");
		 foreach($CVs as $cv){
		 	$deets[$i][$j] = $IDs[$i]; 
		 	$j++;
		 	foreach($reg as $k => $v){
		 		 $deets[$i][$j] = match_pattern(strtolower($cv), $v);
		 		 $j++;
		 	}
		 	foreach($skills as $skill){
		 		$deets[$i][$j] = match_pattern(strtolower($cv), "/\s*?".$skill.",?\s?/");
		 		$j++;
		 	} 	
		 	$i++;
		 	$j = 0;
		 }
		 $result_array = array();
		 $nn = new Classify();
		 foreach($deets as $subdeets){
		 	$contact = "";
		 	$qualifications = "";
		 	$input = array();
		 	$subinput = array();
		 	$a = 0;
		 	$b = 0;
		 	foreach($subdeets as $details){
		 		if(gettype($details) === "array"){
		 			foreach($details as $subdetails){
		 				$contact .= "    ".$subdetails ;
		 			}
		 		}else{
		 			if($details  && $a < 3){
		 				$qualifications .= $details."    ";
		 				$input[$a] = 0;
		 				$a++;
		 			}elseif(!$details && $a < 3){
		 				$input[$a] = 1;
		 				$a++;
		 			}elseif(!$details && $a >= 3){
		 				$subinput[$b] = 0;
		 				$b++;
		 			}elseif($details && $a >= 3){
		 				$qualifications .= $details."    ";
		 				$subinput[$b] = 1;
		 				$b++;
		 			}
		 		}
		 	}
		 		if(in_array(1,$subinput)){
		 			$input[count($input)] = 1;
		 		}else{
		 			$input[count($input)] = 0;
		 		}
		 		$value = $nn->calc($input);
		 		$result_array["$value"] = $contact.":".$qualifications;
		 }
		 	if(krsort($result_array)){
		 		foreach($result_array as $k=>$v){
		 		echo "<div class = 'result'><div class = 'score'>".$k."</div>       ".$v."</div>";
		 	}
		 	}
		 
}
require_once 'templates/footer.php';
?>
</body>
</head>
</html>
