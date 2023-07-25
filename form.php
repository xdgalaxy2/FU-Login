<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!empty($_POST['firstname']) && !empty($_POST['lastname'])) {

    $_SESSION['firstname'] = $_POST['firstname'];
    $_SESSION['lastname'] = $_POST['lastname'];
  }
}

if (isset($_SESSION['firstname']) && isset($_SESSION['lastname'])) {
  echo "First Name: " . $_SESSION['firstname'] . "<br>";
  echo "Last Name: " . $_SESSION['lastname'];
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Midterm Exam</title>
</head>
<body>
  <form method="POST" action="">
    <label for="firstname">First Name:</label>
    <input type="text" name="firstname" required><br><br>
    
    <label for="lastname">Last Name:</label>
    <input type="text" name="lastname" required><br><br>
    
    <input type="submit" value="Submit">
  </form>
</body>
</html>
