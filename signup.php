<?php include 'nav_home.php';?>
<?php
	$errors = array();
	$username = $email = $password = $phonenum =$name ="";
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		function test_input($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}

     //validating name
    if (empty($_POST["name"])) {
           $errors['nameErr']= "Name is required";
    } else {
        $name = test_input($_POST["name"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
					$errors['nameErr']= "Only letters and white space allowed";
        }
      }
   // validating email
    if (empty($_POST["email"])) {
             $errors['emailErr']   = "Email is required";
    } else {
             $email = test_input($_POST["email"]);
             // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['emailErr'] = "Invalid email format";
        }
      }
        // checking existing email
    if (!empty($_POST["email"])) {
			require('db.php');
			$tmp = $_POST['email'];
			$sql = "select user_id from user where email='".$tmp."'";
			$result = mysqli_query($conn,$sql);
			$rows = mysqli_fetch_array($result);
			  if($rows[0]>0) {
					$errors['emailErr']   = "Email already exists, please signup by another email";
			  }
    }
        
        // validating username
		if (empty($_POST["username"])) {
				 $errors['usernameErr']   = "Username is required";
			 }
		// checking existing username
		if (!empty($_POST["username"])) {
			 require('db.php');
			 $tmp = $_POST['username'];
			 $sql1 = "select user_id from user where username='".$tmp."'";
			 $result1 = mysqli_query($conn,$sql);
			 $rows = mysqli_fetch_array($result1);
			 if($rows[0]>0){
					$errors['usernameErr']   = "Username already exists, please choose another username";
			 }
		}
		        
        // validating password
		if (empty($_POST["password"])){
			$errors['passwordErr'] = "Password is required";
		} else {
				$password = test_input($_POST["password"]);
				if(strlen($password)<8){
					$errors['passwordErr'] = "password must be at least 8 character long";
				}
				if (!preg_match("#[a-zA-Z]+#", $password)) {
				 $errors['passwordErr'] = "Password must include at least one letter!";
				}
				if (!preg_match("#[0-9]+#", $password)) {
			 $errors['passwordErr'] = "Password must include at least one number!";
				}
			}	
		if (empty($_POST["cnfpassword"])) {
        $errors['repeat_passwordErr'] = "Password is required";
    }
    if(strcmp($_POST["password"],$_POST["cnfpassword"])!=0){
        $errors['repeat_passwordErr'] = "password and repeat password doesn't match";
    }
    
			 // validating phone number
		if  (empty($_POST['num'])) {
				 $errors['numErr']   = "phone number is required";
		}
		if (!empty($_POST['num']) && mb_strlen($_POST['num'])!=10) {
				$errors['numErr']   = "Invalid Phone Number";
		}
		// checking existing number
		if (!empty($_POST['num'])) {			
			require('db.php');
			$tmp = $_POST['num'];
			$sql2 = "select user_id from user where phonenum= $tmp";
			$result2 = mysqli_query($conn,$sql2);
			$rows = mysqli_fetch_array($result2);
			if ($rows[0]>0) {
				$errors['numErr']   = "Number already exist , please enter another number";
			}
		}
		
		
     ///-------------------------------------------------

  if (empty($errors)) {
		$username = $_POST['username'];
		$temp_password = $_POST['password'];
		$password = md5($temp_password);
		$email    = $_POST['email'];
		$phonenum = $_POST['num'];
		$name     = $_POST['name'];
		$conn = new mysqli('localhost','root','root','onlinebookstore');
		require('db.php');
		$sql3 = "INSERT INTO user(username,email,password,phonenum,rid,name,address) VALUES('$username','$email','$password',$phonenum,2,'$name','')";
		$result3 = $conn->query($sql3);
		$user_id = $conn->insert_id;
		$to      = $email;
		$subject = "Registration Email";
		$message = "<html>
								<head>
								<title>HTML email</title>
								</head>
								<body>
								<p> Hello $name, </p>
								<p>You Registered succesfully on BookStore.com,</p>
								<p>your username is $username</p>
								<br>
								<br>
								<p>Regards,</p>
								<p>TheBookStore.com</p>
								</body>
								</html>";
		$headers = 'From: TheBookStore.com' . "\r\n" .
								'Reply-To: No Reply' . "\r\n" .
								'X-Mailer: PHP/' . phpversion();

		mail($to, $subject, $message, $headers);
		
		session_start();
    $_SESSION["user_id"] = $user_id;
    header("Location: index.php");
	}
}
?>
<form action="" method = "POST">
  <div class="container">
    <h1>Signup</h1>
    <p>Please fill in this form to create an account.</p>
    <hr>

    <label for="Fullname"><b>Fullname</b></label>
    <input type="text" placeholder="Enter fullname" name="name" ></br>
    <span class = "error">*<?php  if(isset($errors['nameErr'])) echo $errors['nameErr'] ?></span></br>

    <label for="email"><b>Email</b></label>
    <input type="text" placeholder="Enter email" name="email" ></br>
    <span class = "error">*<?php  if(isset($errors['emailErr'])) echo $errors['emailErr'] ?></span></br>

    <label for="username"><b>Username</b></label>
    <input type="text" placeholder="Enter username" name="username" </br>
    <span class = "error">*<?php  if(isset($errors['usernameErr'])) echo $errors['usernameErr'] ?></span></br>
	
    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter password" name="password" ></br>
    <span class = "error">*<?php  if(isset($errors['passwordErr'])) echo $errors['passwordErr'] ?></span></br>
		
		<label for="psw"><b>Confirm password</b></label>
    <input type="password" placeholder="Confirm password" name="cnfpassword" ></br>
    <span class = "error">* <?php  if(isset($errors['repeat_passwordErr'])) echo $errors['repeat_passwordErr'] ?></span></br>
    
    <label for="num"><b>Phone number</b></label>
    <input type="text" placeholder="Enter number" name="num"></br>
    <span class = "error">*<?php  if(isset($errors['numErr'])) echo $errors['numErr'] ?></span></br>

    <p>By creating an account you agree to our <a href="#" style="color:dodgerblue">Terms & Privacy</a></p>

    <div class="clearfix">
      <button type="submit" name="signup" >Signup</button>
    </div>
  </div>
</form>


<?php include 'footer.php';?>
