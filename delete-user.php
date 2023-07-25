<?php
session_start();
require "sqlconnect.php";

if ($_SESSION["admin"] == 1 && isset($_GET["id"])) {
    $id = $_GET["id"];
    $stmt = $conn->prepare("DELETE FROM Students WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: index.php"); // Redirect back to the main page after successful deletion
        exit();
    } else {
        echo "Error deleting user: " . $stmt->error;
    }
}
?>
