<?php
$servername = "localhost";
$username = "root";
$password = "password";
$dbname = 'ITS4';
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
 die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
echo "<br>";


$sql = "SELECT id, firstname, lastname FROM Students ORDER BY
lastname desc" ;
$result = $conn->query($sql);
if ($result->num_rows > 0) {
 // output data of each row
 while($row = $result->fetch_assoc()) {
 echo "id: " . $row["id"]. " - Name: " . $row["firstname" ]. " "
. $row["lastname" ]. "<br>";
 }
} else {
 echo "0 results" ;
}


$conn->close();
echo "<br><br><br>";




?>


