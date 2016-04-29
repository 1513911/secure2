<?php
session_start();
include("connection.php"); //Establishing connection with our database
//declare instance of connection
$sqlcon=new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
if (!($sqlcon->connect_errno)){
    echo"connection Failed";
}

$msg = ""; //Variable for storing our errors.
if(isset($_POST["submit"]))
{

    $desc = $_POST["desc"];
    $photoID = $_POST["photoID"];
    $name = $_SESSION["username"];


    //prepare statem
    if($stmt=$sqlcon->prepare("SELECT userID FROM users WHERE username=?")){
        //bind parameter
        $stmt->bind_param('s',$_POST["username"]);
        $stmt->execute();
        //get result
        $result = $stmt->get_result();
    }

   // $sql="SELECT userID FROM users WHERE username='$name'";
   // $result=mysqli_query($db,$sql);
    //$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
    //if(mysqli_num_rows($result) == 1)
    if( ($row=$result->fetch_row())) {
        //echo $name." ".$email." ".$password;
        $id = $row[0];
        
        //prepare statement
        
        //$stmt=$sqlcon->prepare("SELECT userID FROM users WHERE username=?");
           $stmt=$sqlcon->prepare("INSERT INTO comments (description,photoID,userID) VALUES (?,?,?)");
           //bind parameter
           
			$stmt->bind_param('sii',$desc,$photoID, $id);
			
			//get result
        //$query = mysqli_query($db, $addsql) or die(mysqli_error($db));
        if $stmt->execute();
        {
            $msg = "Thank You! comment added. click <a href='photo.php?id=".$photoID."'>here</a> to go back";
        }
    }
    else{
        $msg = "You need to login first";
    }
}

?>
