
<?php
$link = mysqli_connect("localhost", "root", "","project01");
if(mysqli_connect_errno()){
	echo "Failed to connect<br>";
}
else {
 echo "<h1>Connected to Database</h1>";
 
}

$fname="";
$lname="";
$em="";
$em2="";
$password="";
$password2="";
$date="";
$error_msg=array();
$username="";

if(isset($_POST['reg_btn'])) {
$fname = strip_tags($_POST['reg_fname']);
$lname = strip_tags($_POST['reg_lname']);
$em = strip_tags($_POST['reg_email']);
$em2 = strip_tags($_POST['reg_email2']);
$password = strip_tags($_POST['reg_password']);
$password2 = strip_tags($_POST['reg_password2']);
$date = date('Y-m-d');
$username = $fname."_". $lname;

if(strlen($fname)<5 || strlen($fname)>25){
	array_push($error_msg,"first name should be between 5 and 25<br>");
	}
if(strlen($lname)<5 || strlen($lname)>25){
	array_push($error_msg,"last name should be between 5 and 25<br>");
	}
if($em!=$em2){
		array_push($error_msg, "email do not match<br>");

	}
if($password!=$password2){
		array_push($error_msg, "password do not match<br>");
	}
if(strlen($password)<5 || strlen($password)>25){
	array_push($error_msg,"password should be between 5 and 25<br>");
	}

$e_check = mysqli_query($link, "SELECT * FROM users WHERE email= '$em'");
$e_row = mysqli_num_rows($e_check);
if($e_row ==1){
	array_push($error_msg, "Email already exists<br>");
}
	
if(empty($error_msg)){
	$rand = mt_rand(100000,999999);
	$query = mysqli_query($link, "INSERT INTO users VALUES ('','$fname', '$lname', '$username','$em', '$password','$date','$rand')");
	echo "<h2>Registration Successful</h2>";
	echo " your personal pin is $rand (note it in a safe place)";

}
}

if(isset($_POST['log_btn'])){

	$em = strip_tags($_POST['log_em']);
	$password = strip_tags($_POST['log_pass']);

	$check = mysqli_query($link, "SELECT * FROM users WHERE email='$em' AND password='$password'");
	$row = mysqli_num_rows($check);

	if($row == 1) {
		header ("Location: loggedin.php");
	}
	else {
		echo "Email and Password does not match";
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Registration</title>
	<link rel="icon" href="assets/logo.png">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="bootstrap/bootstrap.css">
</head>
<body class="body2">
<div style="margin-top: 7%">
<form class="forms1 form-group" action="index.php" method="POST">
	
	<input type="text" name="reg_fname" placeholder="First name"><br>
	<input type="text" name="reg_lname" placeholder="Last name"><br>
	<input type="email" name="reg_email" placeholder="Email"><br>
	<input type="email" name="reg_email2" placeholder="Confirm Email"><br>
	<input type="password" name="reg_password" placeholder="Password"><br>
	<input type="password" name="reg_password2" placeholder="Confirm Password"><br>
	<input type="submit" name="reg_btn" value="Register"><br>
	<div style="color: #283747; font-size: 20px; background-color: #CACFD2;text-align: center;">
		<?php

	if(in_array("first name should be between 5 and 25<br>", $error_msg)){
		echo "First name should be between 5 and 25<br>";
	}
	if(in_array("last name should be between 5 and 25<br>", $error_msg)){
		echo "Last name should be between 5 and 25<br>";
	}
	if(in_array("email do not match<br>", $error_msg)){
		echo "Email do not match<br>";
	}
	if(in_array("password do not match<br>", $error_msg)){
		echo "Password do not match<br>";
	}
	if(in_array("password should be between 5 and 25<br>", $error_msg)){
		echo "Password should be between 5 and 25<br>";
	}
	if(in_array("Email already exists<br>", $error_msg)){
		echo "Email already exists<br>";
	}
	?>
</div>
</form>


<form action="index.php" method="POST">
	<input type="email" name="log_em" placeholder="Email">
	<input type="password" name="log_pass" placeholder="Password">
	<input type="submit" name="log_btn" value="login">
</form>

<a href="forget.php">Forgot password?</a>
</div>
</body>
</html>


