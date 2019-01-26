<?php 
$link = mysqli_connect("localhost", "root", "","project01");
if(mysqli_connect_errno()){
	echo "Failed to connect<br>";
}
else {
 echo "<h1>Connected to Database</h1>";
 
}
$em ="";
$password="";
$password2="";
$pin="";
$error=array();
if(isset($_POST['forget_btn'])){
	$em = strip_tags($_POST['forget_em']);
	$pin = strip_tags($_POST['forget_pin']);
	$password = strip_tags($_POST['new_password']);
	$password2 = strip_tags($_POST['new_password2']);

if($password!=$password2){
		array_push($error, "password do not match");
	}
	
	$f_check = mysqli_query($link, "SELECT * FROM users WHERE email= '$em' AND pin='$pin'");
	$f_row = mysqli_num_rows($f_check);
	if(empty($error)){
	if($f_row==1){
		$query = mysqli_query($link, "UPDATE users SET password='$password' WHERE email='$em' AND pin='$pin'");
		echo "Password updated successfully";
	}
	else{
		echo "Email and pin do not match";
	}

}

}

 ?>
 <!DOCTYPE html>
 <html>
 <head>
 	<title>Do you forgot your password?
 	</title>
 </head>
 <body>
 	<form action="forget.php" method="POST">
 		<input type="email" name="forget_em" placeholder="Email">
 		<input type="text" name="forget_pin" placeholder="Personal pin"><br><br>
 		<input type="password" name="new_password" placeholder="New Password"><br>
 		<input type="password" name="new_password2" placeholder="Confirm Password"><br>
 		<input type="submit" name="forget_btn" value="Submit"><br><br>
 		<?php 

	if(in_array("password do not match", $error)){
		echo "password do not match";
	}
 		 ?>
 	</form>
 <a href="index.php"> Sign in</a>
 </body>
 </html>