<?php
session_start();
require '../mysql-connect.php';



if($_POST['ID_number'] && $_POST['password']){

    $sql = "SELECT * FROM students WHERE ID_number='".$_POST['ID_number']."'";
    $result = mysqli_query($conn,$sql) or die(mysqli_error($conn));
    if($row = mysqli_fetch_assoc($result))
    {
       

        $verify = password_verify($_POST['password'], $row['password']);
  
        if ($verify) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['fullname'] = $row['firstname'].' '.$row['lastname'];
            $response['message'] = 'Password Verified!';
        } else {
            $response['message'] = 'Incorrect Password!';
        }
      

    }else{
        $response['message'] = 'Invalid ID number!';
    }

}else{
    $response['message'] = 'ID number and Password are required.';
}

$conn->close();

$json_response = json_encode($response);
echo $json_response;
?>