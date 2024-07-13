<?php
session_start();
require "config.php";

if ($_SERVER['REQUEST_METHOD']=='POST'){
    $currentpassword=htmlspecialchars(trim($_POST['current_password']));
    $newpassword=htmlspecialchars(trim($_POST['new_password']));
    

    if (!empty($currentpassword) && !empty($newpassword)){
        $user_id=$_SESSION['user_id'];
        $stmt=$conn->prepare("SELECT password FROM userinfo WHERE id=?");
        $stmt->bind_param("i",$user_id);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows()>0){
            $stmt->bind_result($passwordHash);
            $stmt->fetch();
            
            if (password_verify($currentpassword,$passwordHash)){
                $hashednewpassword=password_hash($newpassword,PASSWORD_BCRYPT);
                $stmt=$conn->prepare("UPDATE userinfo SET password=? WHERE id=?");
                $stmt->bind_param("ss",$hashednewpassword,$user_id);
                if($stmt->execute()){

                    header("Location:userifo.php");
                }else{
                    echo "Error updating password";
                }
            } else{
                echo "<script>alert('Current password is invalid.'); window.location.href='changepassword.html';</script>";
            }
        } else{
            echo "User not registered";
        }
    }
    $stmt->close();
}