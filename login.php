<?php
require "sqlconnect.php";
?>
<?php
$userinvalid = "";
$passwordinvalid = "";
$id_number = false;
$password = false;

if (isset($_POST["login"])) {
    if ($_POST['id_number'] && $_POST['password']) {
        $id_number = $_POST["id_number"];
        $sql = "SELECT * FROM students WHERE id_number='$id_number'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $verify = password_verify($_POST['password'], $row['password']);
            if ($verify) {
                $_SESSION['login_user'] = $row['id'];
                header("Location: index.php", true, 301);
                exit();
            } else {
                $passwordinvalid = "Incorrect password";
            }
        } else {
            $userinvalid = "User not found";
        }
    }
}
?>

