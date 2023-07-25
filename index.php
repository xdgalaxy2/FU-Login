<?php
session_start();
error_reporting(E_ERROR | E_PARSE);
require "sqlconnect.php";

$loginUserId = $_SESSION['login_user'];

/// Fetch first name and last name from the database
$sql = "SELECT firstname, lastname FROM Students WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $loginUserId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $firstName = $row['firstname'];
    $lastName = $row['lastname'];
} else {
    $firstName = "Unknown";
    $lastName = "Unknown";
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Index</title>
</head>
<body>
    <div style="text-align: center;">
        <?php echo "Welcome " . $firstName . " " . $lastName . "<br>"; ?>
    </div>
    <div style="text-align: center;"><a href="logout.php">Log out</a></div>
    <div style="text-align: center;"><a href="Index.php">Dashboard</a></div>

<?php

if ($_GET["page"]) {
$page = $_GET["page"];
} else {
    $page = '';
}

switch ($page) {


    case 'registration':
    include 'registration.php';
        break;


    case 'update-profile':
    include 'update-profile.php';
        break;
    
    case 'change-password':
    include 'change-password.php';
        break;

    default:
    include 'dashboard.php';
        break;
}

?>


</body>
</html>

<?php
$conn->close();
?>