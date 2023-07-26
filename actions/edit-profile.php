<?php
session_start();
require "sqlconnect.php";

if (!isset($_GET["id"])) {
    // Redirect to the dashboard page if the user ID is not provided
    header("Location: dashboard.php");
    exit;
}

$id = $_GET["id"];
$stmt = $conn->prepare("SELECT * FROM Students WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
} else {
    echo "User not found";
    exit; // Optionally, you can handle the error gracefully or redirect to another page
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["update-profile"])) {
    // Retrieve the form fields using $_POST["fieldname"]
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $id_number = $_POST["id_number"];
    $email = $_POST["email"];

    $profile_updated = false;
    $password_updated = false;

    // Check if profile fields are changed
    if ($row["firstname"] !== $firstname) {
        $profile_updated = true;
        echo "First Name updated successfully<br>";
    }

    if ($row["lastname"] !== $lastname) {
        $profile_updated = true;
        echo "Last Name updated successfully<br>";
    }

    if ($row["id_number"] !== $id_number) {
        $profile_updated = true;
        echo "ID Number updated successfully<br>";
    }

    if ($row["email"] !== $email) {
        $profile_updated = true;
        echo "Email updated successfully<br>";
    }

    // Perform the update query for profile details if any field is changed
    if ($profile_updated) {
        $stmt = $conn->prepare("UPDATE Students SET firstname = ?, lastname = ?, id_number = ?, email = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $firstname, $lastname, $id_number, $email, $id);

        if ($stmt->execute()) {
            // Optionally, you can redirect to another page after successful update
            // header("Location: profile.php?id=" . $id);
            // exit();
        } else {
            echo "Error updating profile: " . $stmt->error;
        }
    }

    // Check if the new password is provided
    if (!empty($_POST["new_password"])) {
        $new_password = $_POST["new_password"];

        // Hash the new password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Perform the update query for the password
        $stmt = $conn->prepare("UPDATE Students SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $hashed_password, $id);

        if ($stmt->execute()) {
            $password_updated = true;
            echo "Password updated successfully";
            // Optionally, you can redirect to another page after successful update
            // header("Location: profile.php?id=" . $id);
            // exit();
        } else {
            echo "Error updating password: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Edit Profile</title>
</head>
<body>
    <!-- Add the dashboard link -->
    <div style="text-align: center;"><a href="dashboard.php">Dashboard</a></div>
  
    <h2>Edit Profile</h2>  
    <!-- Create the HTML form for editing the profile -->
    <form method="post" action="edit-profile.php?id=<?php echo $row["id"]; ?>">
        <!-- Add input fields here with the corresponding values from $row -->
        <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
        First Name: <input type="text" name="firstname" value="<?php echo $row["firstname"]; ?>"><br><br>
        Last Name: <input type="text" name="lastname" value="<?php echo $row["lastname"]; ?>"><br><br>
        ID Number: <input type="text" name="id_number" value="<?php echo $row["id_number"]; ?>"><br><br>
        Email: <input type="text" name="email" value="<?php echo $row["email"]; ?>"><br><br>
        
        <!-- Edit Password Field -->
        New Password: <input type="password" name="new_password"><br><br>
        
        <input type="submit" name="update-profile" value="Update Profile">
    </form>
</body>
</html>
