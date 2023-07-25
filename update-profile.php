<?php

echo "<h2>Edit Profile:</h2>";
if (isset($_POST["profile"])) {
    if (!empty($_POST["firstname"]) && !empty($_POST["lastname"]) && !empty($_POST["email"])){    
        if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {    
            $stmt = $conn->prepare("UPDATE Students SET firstname = ?, lastname = ?, email = ? WHERE id = ?");
            $stmt->bind_param("sssi", $first_name, $last_name, $email, $_SESSION['login_user']);
            $first_name = $_POST["firstname"];
            $last_name = $_POST["lastname"];
            $email = $_POST["email"];
            $stmt->execute();
            echo "Successful";
        } else {
            $emailErr = "Invalid email format";
        }
    }
}
?>

<?php
$sql = "SELECT * FROM Students WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['login_user']);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
?>
<form action="" method="post">
    First Name: <input type="text" name="firstname" value="<?php echo $row['firstname']; ?>"><br><br>
    Last Name: <input type="text" name="lastname" value="<?php echo $row['lastname']; ?>"><br><br>
    E-mail: <input type="text" name="email" value="<?php echo $row['email']; ?>"><br><br>
    <input type="submit" value="Update Profile" name="profile">
</form>

<?php } ?>
