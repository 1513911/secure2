<?php
	session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
	include("connection.php"); //Establishing connection with our database
//define sql connection
$sqliconn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
	$error = ""; //Variable for storing our errors.
	if(isset($_POST["submit"])) {
		if (empty($_POST["username"]) || empty($_POST["password"])) {
			$error = "Both fields are required.";
		} else {
			// Define $username and $password
			$username = $_POST['username'];
			$password = $_POST['password'];



			if($sqliconn->connect_errno){
				echo "connection failed";
			}

			$photosql = 'SELECT userID FROM users WHERE username=? and password= ?';

			//inititalilised the statement
			if(!($stm = $sqliconn->init())){
				echo "init failed";
			}

			//prepare statement
			if (!($stm->prepare($photosql))) {
				echo "prepared statement failed";

				//bind parameter

			}
			$stm->bind_param('ss', $username, $password);
				if($stm->execute()) {
					$result = $stm->get_result();
					$row = $result->fetch_assoc();


					//Check username and password from database
					//	$sql="SELECT userID FROM users WHERE username='$username' and password='$password'";
					//$result = mysqli_query($db, $sql);
					//$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

					//If username and password exist in our database then create a session.
					//Otherwise echo error.

					//if (mysqli_num_rows($result) == 1) {
					$_SESSION['username'] = $username; // Initializing Session
					header("location: photos.php"); // Redirecting To Other Page

				}
				 else {
					$error = "Incorrect username or password.";
				}


		}
	}
?>