<?php include 'nav_home.php';?>

<form action="" method="post"> 
  <div class="container">
    <label for="uname"><b>Username</b></label>
    <input type="text" placeholder="Enter username" name="user" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter password" name="pass" required>

    <button type="submit">Login</button>
  </div>
</form>

<?php
	if(!empty($_POST['user'])) {
		$username = $_POST['user'];
		$password = $_POST['pass'];
		$temp_password=md5($password);  
	    require('db.php');
		$sql = "SELECT user_id,rid FROM user WHERE username='$username' and password='$temp_password'";
		$result = $conn->query($sql);
		if($result->num_rows > 0) {
			$row = $result->fetch_assoc();
				if($row['rid']==1) {
					session_start();
					$_SESSION['user_id'] =  $username;
					header("Location: admin.php");   
				} 
				else { 	
					session_start();
					$_SESSION['user_id'] =  $row['user_id'];
					header("Location: index.php");
				} 			
		}
		else {
			?>
				<html>
				<head>
				<meta name="viewport" content="width=device-width, initial-scale=1">
				<style>
				.alert {
						padding: 2px;
						background-color: red;
						color: white;
				}
				</style>
				</head>
				<body>
				<div class="alert">
					<span class="closebtn" onclick="this.parentElement.style.display='none';"></span> 
					Invalid username or password
				</div>
				</body>
				</html> <?php			
		}
			
	}
?>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<?php include 'footer.php'?>
