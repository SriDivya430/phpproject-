<?php 
session_start();
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));

    $stmt=$conn->prepare("SELECT id,password FROM userinfo WHERE username= ?");
    $stmt->bind_param('s',$username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows>0){
        echo "User already exist,Try again.";
    }
    else{
        if(!empty($username) && !empty($email) && !empty($password)) {
            $passwordHash = password_hash($password, PASSWORD_BCRYPT);
            
            $stmt = $conn->prepare("INSERT INTO userinfo (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $passwordHash);

            if ($stmt->execute()) {
                echo "Registration successful!";
                header("Location: login.html");
            } else {
                echo "Error Occured";
            }
            
            $stmt->close();
        }
        else{
            echo "Please Enter the Values";
        }
    }
}
?>
