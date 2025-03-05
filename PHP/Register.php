<?php

require_once "config.php";
require_once "session.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Submit'])) {

    $FirstName = trim($_POST['firstname']);
    $LastName = trim($_POST['lastname']);
    $Address1 = trim($_POST['addressline1']);
    $Address2 = trim($_POST['addressline2']);
    $PostCode = trim($_POST['postcode']);
    $City = trim($_POST['city']);
    $Email = trim($_POST['email']);
    $Password = trim($_POST['password']);
    $ConfirmPassword = trim($_POST["confirmpassword"]);
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    $ID = $FirstName,$LastName,$Address1

    if($query = $db->prepare("SELECT * FROM users WHERE email = ?")) {
        $error = '';
        // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
	$query->bind_param('s', $email);
	$query->execute();
	// Store the result so we can check if the account exists in the database.
	$query->store_result();
        if ($query->num_rows > 0) {
            $error .= '<p class="error">The email address is already registered!</p>';
        } else {
            // Validate password
            if (strlen($Password ) < 6) {
                $error .= '<p class="error">Password must have atleast 6 characters.</p>';
            }

            // Validate confirm password
            if (empty($ConfirmPassword)) {
                $error .= '<p class="error">Please enter confirm password.</p>';
            } else {
                if (empty($error) && ($password != $ConfirmPassword)) {
                    $error .= '<p class="error">Password did not match.</p>';
                }
            }
            if (empty($error) ) {
                $insertQuery = $db->prepare("INSERT INTO `Accounts` (`ID`, `FirstName`, `LastName`, `Address1`, `Address2`, `PostCode`, `City`, `Email`, `Permissions`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $insertQuery->bind_param("sss", $ID, $FirstName, $LastName, $Address1, $Address2, $PostCod, $City, $email, $password_hash);
                $result = $insertQuery->execute();
                if ($result) {
                    $error .= '<p class="success">Your registration was successful!</p>';
                } else {
                    $error .= '<p class="error">Something went wrong!</p>';
                }
            }
        }
    }
    $query->close();
    $insertQuery->close();
    // Close DB connection
    mysqli_close($db);
}
?>
<html>

<head>
	<title> SignUp </title>
	
	
</head>

<body>

	<!-- write comments when necessary!! -->
	<h1> Please SignUp </h1>
	
	<div class="dropdown">
		<button class="dropbtn">☰</button>
		<div class="dropdown-content">
		  <a href="#">Link 1</a>
		  <a href="#">Link 2</a>
		  <a href="#">Link 3</a>
		</div>
	  </div>
	  
	  

	<ul>
		<li class = "Home"><a href="HomePage.html">🏠</a></li>
		<li class = "Clock"><div id = "Clock"></div></li>
		<li class = "LISU"><a href="Login.html">LOGIN</a></li>
		<li class = "LISU"><a href="Registration.html">SIGNUP</a></li>
	  </ul>

	<h2> To register, fill out the form below and click the Submit button </h2>
    <p> The registration process takes approximately two to three minutes.  </p>
    <p> Thank you for your patience.  </p>
	
	<form action="../PHP/Register.php" method="post">
        <h3 class="txt"> First name: </h3>
		<input class="middle" type="text" name="firstname" required="required"> <br>
		
		<h3 class="txt"> Last name: </h3>
		<input class="middle" type="text" name="lastname" required="required"> <br>
		
		<h3 class="txt"> Address Line 1: </h3>
		<input class="middle" type="text" name="addressline1" required="required"> <br>
		
		<h3 class="txt"> Address Line 2: </h3>
		<input class="middle" type="text" name="addressline2" > <br>
		
		<h3 class="txt"> Post Code: </h3>
		<input class="middle" type="text" name="postcode" required="required"> <br>
		
		<h3 class="txt"> City: </h3>
		<input class="middle" type="text" name="city" required="required"> <br>
		
		<h3 class="txt"> Email: </h3>
		<input class="middle" type="email" name="email" required="required"> <br>
		
		<h3 class="txt"> Password: </h3>
		<input class="middle" type="password" id = "Password" name="password" required="required"> <br>
		
		<h3 class="txt"> Confirm Password: </h3>
		<input class="middle" type="password" id = "ConfirmPassword" name="confirmpassword" required="required"> <br><br>
		
		<input class="middle" type="Submit" value="Submit">
		
	</form> 
	
	<h2> TERMS & CONDITIONS </h2>
	<ol class="bottom">
		<li>	We will use the personal information you provide to us to 
				provide your membership services. 
                <a class="txt" href="../PATH/TO/DETAILS/FILE">
                    Click here for more details
                </a> 
		</li>
		<li>	We will not give your personal data to any third party and you will 
				only receive communications directly from us. 
                <a class="txt" href="../PATH/TO/DETAILS/FILE">
                    Click here for more details
                </a> 
		</li>
	</ol>
</body>
<link href="../CSS/Styles.css" type="text/css" rel = "stylesheet"/>
<script src="../JavaScript/clock.js"></script>
<script src="../JavaScript/DarkMode.js"></script>
</html>