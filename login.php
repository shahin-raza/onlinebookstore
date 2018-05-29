<?php include 'nav_home.php';?>

<form action="" method="post">
  <div class="imgcontainer">
    <img src="resources/img_avatar2.png" alt="Avatar" class="avatar" height="200px" width="100px">
  </div>
  <div class="container">
    <label for="uname"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="user" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="pass" required>

    <button type="submit">Login</button>
  </div>
</form>

<?php
if(!empty($_POST['user'])) {
  $username = $_POST['user'];
  $password = $_POST['pass'];
	
  if($username=='admin' && $password=='admin') {
    session_start();
    $_SESSION['user_id'] =  $username;
    header("Location: admin.php");
  }
	else { 	
    include 'db.php';
		$sql = "SELECT user_id FROM user WHERE username='$username' and password='$password'";
		$result = $conn->query($sql);
		if($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			 session_start();
			$_SESSION['user_id'] =  $row['user_id'];
			header("Location: index.php");
		} else{			
			 echo "user name or password not valid";
		}
		
	}
}
?>
<?php include 'footer.php'?>
