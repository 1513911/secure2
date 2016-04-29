<?php
$msg = "";
if(isset($_POST["submit"]))
{
    $name = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    
    //clean input photo user name
		$name = stripslashes( $name );
		$name=mysqli_real_escape_string($db,$name);
		$name = htmlspecialchars($name);
		//encrypt password with md5
		$password=md5($password);
		
		//clean input photo email
		$email = stripslashes( $email );
		$email=mysqli_real_escape_string($db,$email);
		$email = htmlspecialchars($email);
		
		
		




    $sql="SELECT email FROM users WHERE email='$email'";
    $result=mysqli_query($db,$sql);
    $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
    if(mysqli_num_rows($result) == 1)
    {
        $msg = "Sorry...This email already exists...";
    }
    else
    {
        //echo $name." ".$email." ".$password;
        $query = mysqli_query($db, "INSERT INTO users (username, email, password) VALUES ('$name', '$email', '$password')")or die(mysqli_error($db));
        if($query)
        {
            $msg = "Thank You! you are now registered. click <a href='index.php'>here</a> to login";
        }

    }
}
?>
