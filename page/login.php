<?php

	//loon andmebaasi ühenduse
	require_once("../../config.php");
	$database = "if15_kar1ns";
	$mysqli = new mysqli($servername, $username, $password, $database);

	//login.php
	$email_error = "";
	$password_error ="";
	
	//echo $_POST["email"];  //ANNAB MUUTUJA MIS AADRESSIREAL ON
	// kontrollime et keeegi vajutas input nuppu
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		//echo "keegi vajutas nuppu";
		
		//kontrollin et e-mail ei ole tühi
		
		if(isset($_POST["login"])){
			
			if( empty($_POST["email"])){
				$email_error = "See väli on kohustuslik";
			}else{
		   // puhastame muutuja võimalikest üleliigsetest sümbolitest
				$email = test_input($_POST["email"]);
			}
				
			//kontrollin, et parool ei ole tühi
			
			if( empty($_POST["password"])){
				$password_error = "See väli on kohustuslik";
			} else {
				$password = test_input($_POST["password"]);
			}
			
			if($password_error == "" && $email_error == "" ){
				$hash = hash("sha512", $password);
					
				$stmt = $mysqli->prepare("SELECT id FROM user WHERE email=? AND password=? ");
				echo $mysqli->error;
				$stmt->bind_param("ss", $email, $hash);
				
				//muutujad tulemustele
				$stmt->bind_result($id_from_db);
				$stmt->execute();
				
				//kontrollin, kas tulemusi leiti
				if($stmt->fetch()){
					echo "Eemail ja parool õiged, kasutaja id=".$id_from_db;
				}else{
				echo "Wrong credentials!";
				
				}
				$stmt->close();
			}
			
			
		
		
			
		}
	} 

	
	function test_input($data) {
	  $data = trim($data); //võtav ära tühikud eneteri tabid
	  $data = stripslashes($data); //tagurpidi kaldkriipsud
	  $data = htmlspecialchars($data); 
	  return $data;
	}	
?>
<?php
	$page_title = "Login page";
	$page_file_name = "login.php";
?>
<?php require_once("../header.php"); ?>

	<h2>Log in</h2>
	
		<form action="login.php" method="post">
			<input name="email" type="email" placeholder="E-mail" value="email"> <?php echo $email_error; ?><br><br>
			<input name="password"type="password" placeholder="Password"> <?php echo $password_error; ?> <br><br>
			<input name="login" type="submit" value="Log in">
		</form>

<?php require_once("../footer.php"); ?>
</body>


</html>