<?php
session_start();
include("connection.php"); //Establishing connection with our database

$msg = ""; //Variable for storing our errors.
if(isset($_POST["submit"]))
{


    $desc = $_POST["desc"];
    $photoID = $_POST["photoID"];
    $name = $_SESSION["username"];

    //clean input description
    $desc = stripslashes( $desc );
    $desc=mysqli_real_escape_string($db,$desc);
    $desc = htmlspecialchars($desc);

    //clean input photo id
    $photoID = stripslashes( $photoID );
    $photoID=mysqli_real_escape_string($db,$photoID);
    $photoID = htmlspecialchars($photoID);

    //declare instance of connection
    $sqlcon=new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

    if (!($sqlcon->connect_errno)){
        echo"connection Failed";
    }
    //prepare statem
    if($stmt=$sqlcon->prepare("SELECT userID FROM users WHERE username=?")){
        //bind parameter
        $stmt->bind_param('s',$name);
        $stmt->execute();
        //get result
        $result = $stmt->get_result();
    }

    if( ($row=$result->fetch_row()))
    { 
        
        {
        //echo $name." ".$email." ".$password;
        $id = $row[0];
        $addsql = "INSERT INTO commentsSecure (description, postDate,photoID,userID) VALUES ('$desc',now(),'$photoID','$id')";
        $query = mysqli_query($db, $addsql) or die(mysqli_error($db));
        if ($query) {
            $msg = "Thank You! comment added. click <a href='photo.php?id=".$photoID."'>here</a> to go back";
        }
    }
    else{
        $msg = "You need to login first";
    }
}

?>
