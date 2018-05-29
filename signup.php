<?php include 'nav_home.php';?>
<form action="" method = "POST">
  <div class="container">
    <h1>Sign Up</h1>
    <p>Please fill in this form to create an account.</p>
    <hr>

    <label for="Fullname"><b>Fullname</b></label>
    <input type="text" placeholder="Enter Fullname" name="name" required></br>

    <label for="email"><b>Email</b></label>
    <input type="text" placeholder="Enter Email" name="email" required></br>

    <label for="username"><b>Username</b></label>
    <input type="text" placeholder="Enter username" name="username" required></br>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required></br>

    <label for="num"><b>Phone Number</b></label>
    <input type="text" placeholder="Enter Number" name="num" required></br>

    <p>By creating an account you agree to our <a href="#" style="color:dodgerblue">Terms & Privacy</a></p>

    <div class="clearfix">
      <button type="submit" name="signup" >Sign Up</button>
    </div>
  </div>
</form>

<?php
  if (isset($_POST['signup'])) {
  $username = $_POST['username'];
  $password = $_POST['psw'];
  $email    = $_POST['email'];
  $phonenum = $_POST['num'];
  $name     = $_POST['name'];
  if(!empty($username) && !empty($password) && !empty($email)) {
  $conn = new mysqli('localhost','root','root','onlinebookstore');
  require('db.php');
  $sql = "INSERT INTO user(username,email,password,phonenum,rid,name) VALUES('$username','$email','$password',$phonenum,2,'$name')";
  $result = $conn->query($sql);
  #print_r($sql);
  }

  $to      = $email;
  $subject = "Registration Email";
  $message = "Hello '.$name.', You Registered succesfully on buybook.com, your username is '.$username.' And Password is '.$password.'";
  $headers = 'From: saurabh.kanva@webaccessglobal.com' . "\r\n" .
      'Reply-To: saurabh.kanva@webaccessglobal.com' . "\r\n" .
      'X-Mailer: PHP/' . phpversion();

  mail($to, $subject, $message, $headers);
}
?>
<?php include 'footer.php';?>
