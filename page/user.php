<?php
	//loon andmebaasi ühenduse
	require_once("../../config.php");
	$database = "if15_kar1ns";
	$mysqli = new mysqli($servername, $username, $password, $database);

	//login.php
	$email_error = "";
	$password_error ="";
	$name_error ="";
	$birthday_error="";
	$gender_error="";
	
	//muutujad andmepaasi väärtuste jaoks
	$name = "";
	$email = "";
	$password = "";
	$gender = "";
	$birthday = "";
	
	//echo $_POST["email"];  //ANNAB MUUTUJA MIS AADRESSIREAL ON
	// kontrollime et keeegi vajutas input nuppu
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		//echo "keegi vajutas nuppu";
		//vajutas great user nuppu
		if(isset($_POST["creat"])){
			//kontrollin et e-mail ei ole tühi
			if( empty($_POST["email"])){
				$email_error = "See väli on kohustuslik";
			} else {
				$email = test_input($_POST["email"]);
			}
			//kontrollin, et parool ei ole tühi
			
			if( empty($_POST["password"])){
				$password_error = "See väli on kohustuslik";
			} else {
				$password = test_input($_POST["password"]);
			}
			if(strlen ($_POST["password"]) < 8){
				$password_error = "Peab olema vähemalt 8 tähemärki pikk!";
				}
			}
		
			
			if( empty($_POST["name"])){
			$name_error = "See väli on kohustuslik";
			}else{
				$name = test_input($_POST["name"]);
			}
			if( empty($_POST["birthday"])){
				$birthday_error = "See väli on kohustuslik";
			}else{
				$birthday = test_input($_POST["birthday"]);
			}
			if( empty($_POST["gender"])){
				$gender_error = "See väli on kohustuslik";
			}else{
				$gender = test_input($_POST["gender"]);
			}
			

			if(	$name_error == "" && $email_error == "" && $password_error == "" && $gender_error == "" && $birthday_error == ""){
				
				//räsi paroolist, mille salvestame ab'i
				$hash = hash("sha512", $password);
				
				echo "Võib kasutajat luua! Kasutajanimi on ".$email." ja parool on ".$password."ja räsi on ".$hash;
				
				$stmt = $mysqli->prepare("INSERT INTO user(name, email, password, birthday, gender)VALUES(?, ?, ?, ?, ?)");
				$stmt->bind_param("sssss", $name, $email, $hash, $birthday, $gender); //ss - s on string email, s on string password
				$stmt->execute();
				$stmt->close();
	  }
			
	}

	function test_input($data) {
	  $data = trim($data); //võtav ära tühikud eneteri tabid
	  $data = stripslashes($data); //tagurpidi kaldkriipsud
	  $data = htmlspecialchars($data); 
	  return $data;
	}	
	
?>
<html>
<head>
	<title>Signup page</title>
</head>
<body>
	<h2>Creat account</h2>
	
		<form action="user.php" method="post">
			<p>Name</p>
			<input name="name" type="name" placeholder="Eesnimi Perenimi" value="<?php echo $name;?>"> <?php echo $name_error; ?><br><br>
			<p>Email</p>
			<input name="email" type="email" placeholder="something@something.stng"> <?php echo $email_error; ?><br><br>
			<p>Password</p>
			<input name="password"type="password" placeholder="********"> <?php echo $password_error; ?> <br><br>
			<p>Birthday</p>
			<input name="birthday" type="birthday" placeholder="day/month/year"> <?php echo $birthday_error; ?><br><br>
			<p>Gender</p>
			<input name="gender" type="gender" placeholder="male/female"> <?php echo $gender_error; ?><br><br>
			<input name="creat" type="submit" value="Creat user">
		</form>
	
</body>


</html>