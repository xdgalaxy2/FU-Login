<?php
session_start();
require "sqlconnect.php";
error_reporting(E_ALL);

// ... (your existing code for validation and registration)

// Function to sanitize and validate user input
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Change password code
if (isset($_POST["change-password"])) {
    if (!empty($_POST["password"]) && !empty($_POST["new-password"]) && !empty($_POST["confirm-password"])) {
        $password = $_POST["password"];
        $new_password = $_POST["new-password"];
        $confirm_password = $_POST["confirm-password"];

        // Get user's current password from the database
        $stmt = $conn->prepare("SELECT * FROM Students WHERE id = ?");
        $stmt->bind_param("s", $_SESSION['login_user']);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $verify = password_verify($password, $row["password"]);

            if ($verify) {
                if ($new_password === $confirm_password) {
                    // Update the password in the database
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("UPDATE Students SET password = ? WHERE id = ?");
                    $stmt->bind_param("ss", $hashed_password, $_SESSION['login_user']);

                    if ($stmt->execute()) {
                        echo "<div class='float-success'><p>Password successfully changed</p></div>";
                    } else {
                        echo "<div class='float-error'><p>Error updating password</p></div>";
                    }
                } else {
                    echo "<div class='float-error'><p>New password and confirm password do not match</p></div>";
                }
            } else {
                echo "<div class='float-error'><p>Incorrect current password</p></div>";
            }
        }
    } else {
        echo "<div class='float-error'><p>All fields are required</p></div>";
    }
}
?>

<!-- Your HTML form goes here -->
<html>
<body>

<form action="" method="post">
Old Password: <input type="password" name="password"><br><br>
New Password: <input type="password" name="new-password"><br><br>
Confirm Password: <input type="password" name="confirm-password"><br><br>
<input type="submit" value="Change Password" name="change-password">
</form>
<a href="login_and_register.php">Login</a>

</body>
</html>
