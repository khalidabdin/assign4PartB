<?php

  require_once 'login.php';
  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die($conn->connect_error);

$stmt = $conn->prepare("INSERT INTO user_profiles (fname, lname, email, password) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $fname, $lname,$user_code1, $email,$password);

echo '<form method = "post" action = "sectiona.php">First Name:<input type ="text" maxlength = "30" name = "fname"><br/>
Last Name:<input type ="text" maxlength = "30" name = "lname"> <br /> ';

echo 'User type:<select name = "user_code1">';
$get_codes = 'SELECT * FROM user_codes';
$result = $conn->query($get_codes) or die(mysql_error());
while($row = mysqli_fetch_assoc($result)){
echo '<option value = "'.$row['user_code'].'">'.$row['user_description'].'</option>';
}
echo '</select><br/>';

echo 'E-mail:<input type = "text" maxlength = "100" name = "email"><br />
Password:<input type = "password" name = "password"><br />
<input type = "submit" value = "Submit">';
 
  if (isset($_POST['fname']) &&
      isset($_POST['lname']) &&
      isset($_POST['email']) && 
      isset($_POST['password']))
  {
    $fname = get_post($conn, 'fname');
    $lname = get_post($conn, 'lname');
    $email = get_post($conn, 'email');
    $password = get_post($conn, 'password');
$get_codes = get_post($conn, 'user_code1');
    $query = "INSERT INTO user_profiles (fname,lname, usercode, email, password) VALUES ('$fname','$lname','$get_codes','$email','$password')";
    $result2 = $conn->query($query);
    $stmt->execute();

 if (!$result2) die ("<br />Database access failed: " . $conn->error);
else 
   {
  echo "<br /> Your data has been inserted successfully";

     }
  }
$result->close();
$conn->close();

  function get_post($conn, $var)
  {
    return $conn->real_escape_string($_POST[$var]);
  }
?>