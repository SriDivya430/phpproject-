<?php
// login.php
session_start();
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars(trim($_POST['password']));

    if (!empty($username) && !empty($password)) {
        $stmt = $conn->prepare("SELECT id, password FROM userinfo WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $passwordHash);
            $stmt->fetch();

            if (password_verify($password, $passwordHash)) {
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $username;
                echo "Login Successful";
                header("Location: welcome.html");
            } else {
                echo "<script>alert('Incorrect Login Details.'); window.location.href='login.html';</script>";
            }
        } else {
            echo "User Is Not Registered.";
        }
        
        $stmt->close();
    }
}
?>