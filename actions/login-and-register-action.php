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