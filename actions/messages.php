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