<?php
session_start();
require "sqlconnect.php";
error_reporting(E_ALL);
?>
<!DOCTYPE HTML>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>
<?php
// define variables and set to empty values
$nameErr = $lastnameErr = $emailErr = $idNumberErr = $passwordErr = $confirmPasswordErr = "";
$name = $lastname = $email = $idNumber = $password = $confirmPassword = "";

if (isset($_POST["register"])) {
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = test_input($_POST["name"]);

        if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
            $nameErr = "Only letters and white space are allowed";
        } else {
            // Check if firstname already exists in the database
            $stmt = $conn->prepare("SELECT * FROM Students WHERE firstname = ?");
            $stmt->bind_param("s", $name);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $nameErr = "Firstname already exists";
            }
            $stmt->close();
        }
    }

    if (empty($_POST["lastname"])) {
        $lastnameErr = "Lastname is required";
    } else {
        $lastname = test_input($_POST["lastname"]);

        if (!preg_match("/^[a-zA-Z-' ]*$/", $lastname)) {
            $lastnameErr = "Only letters and white space are allowed";
        } else {
            // Check if lastname already exists in the database
            $stmt = $conn->prepare("SELECT * FROM Students WHERE lastname = ?");
            $stmt->bind_param("s", $lastname);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $lastnameErr = "Lastname already exists";
            }
            $stmt->close();
        }
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        } else {
            // Check if email already exists in the database
            $stmt = $conn->prepare("SELECT * FROM Students WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $emailErr = "Email already exists";
            }
            $stmt->close();
        }
    }

    if (empty($_POST["id_number"])) {
        $idNumberErr = "ID number is required";
    } else {
        $idNumber = test_input($_POST["id_number"]);

        if (!preg_match("/^[a-zA-Z0-9]*$/", $idNumber)) {
            $idNumberErr = "Only alphanumeric characters are allowed";
        } else {
            // Check if id_number already exists in the database
            $stmt = $conn->prepare("SELECT * FROM Students WHERE id_number = ?");
            $stmt->bind_param("s", $idNumber);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $idNumberErr = "ID number already exists";
            }
            $stmt->close();
        }
    }

    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = test_input($_POST["password"]);
    }

    if (empty($_POST["confirm_password"])) {
        $confirmPasswordErr = "Confirm password is required";
    } else {
        $confirmPassword = test_input($_POST["confirm_password"]);
    }

    if ($password !== $confirmPassword) {
        $passwordErr = "Passwords do not match";
    }

}
    if (isset($_POST["login"])) {
    $id_number = $_POST["id_number"];
    $password = $_POST["password"];

    // Check if both ID number and password are provided
    if (!empty($id_number) && !empty($password)) {
        $stmt = $conn->prepare("SELECT * FROM students WHERE id_number = ?");
        $stmt->bind_param("s", $id_number);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if the user exists in the database
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $verify = password_verify($password, $row['password']);

            // Verify the password
            if ($verify) {
                $_SESSION['login_user'] = $row['id'];
                 $_SESSION['admin'] = $row["admin"];
                header("Location: index.php");
                exit();
            } else {
                echo "<div class='float-error-login'><p>Incorrect password</p></div>";
            }
        } else {
            echo "<div class='float-error-login'><p>ID number not found</p></div>";
        }
    }
}
// Function to sanitize and validate user input
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>              


<div class="login-box">
    <img src="image/FU_logo.png" class="avatar">
    <div class="wrapper">
         <div class="title-text">
            <div class="title login">
               Login
            </div>
            <div class="title signup">
               Signup
            </div>
         </div>
         <div class="form-container">
            <div class="slide-controls">
               <input type="radio" name="slide" id="login" checked>
               <input type="radio" name="slide" id="signup">
               <label for="login" class="slide login">Login</label>
               <label for="signup" class="slide signup">Signup</label>
               <div class="slider-tab"></div>
            </div>
            <div class="form-inner">
                <form class="login" method="post" action="login_and_register.php">
                  <div class="field">
                     <input type="text" name="id_number" placeholder="ID number" required>
                  </div>
                  <div class="field">
                     <input type="password" name="password" placeholder="Password" required>
                  </div>
                  <div class="pass-link">
                     <a href="#">Forgot password?</a>
                  </div>
                  <div class="field btn">
                    <div class="btn-layer"></div>
                     <input type="submit" name="login" value="Login">
                  </div>
                   <?php if (isset($loginError) && !empty($loginError)): ?>
                  <div>
                     <?php echo $loginError; ?>
                  </div>
                  <?php endif; ?>
                  <div class="signup-link">
                     Not a member? <a href="">Signup now</a>
                  </div>
               </form>
               <form class ="signup" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <div class="field">
                        <input type="text" name="name" placeholder="First name" required>
                        <span class="error"><?php echo $nameErr; ?></span>
                    </div>
                    <div class="field">
                        <input type="text" name="lastname" placeholder="Last name" required>
                        <span class="error"><?php echo $lastnameErr; ?></span>
                    </div>
                    <div class="field">
                        <input type="text" name="email" placeholder="Email" required>
                        <span class="error"><?php echo $emailErr; ?></span>
                    </div>
                    <div class="field">
                        <input type="text" name="id_number" placeholder="ID number" required>
                        <span class="error"><?php echo $idNumberErr; ?></span>
                    </div>
                    <div class="field">
                        <input type="password" name="password" placeholder="Password" required>
                        <span class="error"><?php echo $passwordErr; ?></span>
                    </div>
                    <div class="field">
                        <input type="password" name="confirm_password" placeholder="Confirm password" required>
                        <span class="error"><?php echo $confirmPasswordErr; ?></span>
                    </div>
                    <div class="field btn">
                        <div class="btn-layer"></div>
                        <input type="submit" name="register" value="Create Account">
                    </div>
                </form>
            </div>
         </div>
      </div>
<?php
if (isset($_POST["register"])) {
    if ($nameErr === "" && $lastnameErr === "" && $emailErr === "" && $idNumberErr === "" && $passwordErr === "" && $confirmPasswordErr === "") {
        // All fields are valid, proceed with creating the account

        // Hash the password
        $hash = password_hash($password, PASSWORD_DEFAULT);

        // Prepare and bind the statement
        $stmt = $conn->prepare("INSERT INTO Students (firstname, lastname, email, id_number, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $lastname, $email, $idNumber, $hash);

        // Execute the statement
        if ($stmt->execute()) {
            echo "<div class='float-success'><p>Create Account Successful</p></div>";
        }

        $stmt->close();
    } else {
        echo "<div class='float-error'><p>Error creating account<br>Please fix the errors in the form.</p></div>";
    }
}
?>

<script src="error.js"></script>
<script src="transition.js"></script>
</body>
</html>