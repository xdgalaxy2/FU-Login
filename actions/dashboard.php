<?php
// dashboard.php

// Start the session at the beginning of the page
session_start();
require "sqlconnect.php";

// Check if the user is logged in or not
if (!isset($_SESSION['login_user'])) {
    // Redirect to the login page or display an error message
    header("Location: login.php");
    exit;
}
?>

<div style="text-align: center;"><a href="?page=profile">Profile</a></div>
<div style="text-align: center;"><a href="?page=update-profile">Update Profile</a></div>
<div style="text-align: center;"><a href="?page=change-password">Change Password</a></div>
<div><a href="logout.php">Logout</a><br></div>

<?php
if ($_SESSION["admin"] == 1) {
?>

<table>
    <tr>
        <td>ID</td>
        <td>NAME</td>
        <td>ID NUMBER</td>
        <td>EMAIL</td> <!-- Added "EMAIL" header -->
        <td>ACTION</td>
    </tr>

    <?php
    $sql = "SELECT * FROM Students";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            ?>
            <tr>
                <td><?php echo $row["id"]; ?></td>
                <td><?php echo $row["firstname"] . ' ' . $row["lastname"]; ?></td>
                <td><?php echo $row["id_number"]; ?></td>
                <td><?php echo $row["email"]; ?></td> <!-- Display the email alongside the id_number -->
                <td>
                    <a href="edit-profile.php?id=<?php echo $row["id"]; ?>">EDIT</a>
                    <a href="delete-user.php?id=<?php echo $row["id"]; ?>">DELETE</a>
                </td>
            </tr>
            <?php
        }
    } else {
        ?>
        <tr>
            <td colspan="5">NO RESULT</td>
        </tr>
        <?php
    }
    ?>
</table>
<?php
}
?>
