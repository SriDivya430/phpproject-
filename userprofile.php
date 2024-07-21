<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="profile.css" rel="stylesheet" >
    
</head>
<body>

    <?php
    session_start();
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "userimages";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if(isset($_POST['submit'])){
        $file=$_FILES['file'];
        $fileName=$_FILES['file']['name'];
        $fileTmpName=$_FILES['file']['tmp_name'];
        $fileSize=$_FILES['file']['size'];
        $fileError=$_FILES['file']['error'];

        $fileExt=explode(".",$fileName);
        $fileActualExt=strtolower(end($fileExt));
        $allowed=array('jpg','png','jpeg','pdf','jfif');

        $target_dir='files/';
        $_SESSION['fName']=$fileName;
        
        if(!is_dir($target_dir)){
            mkdir($target_dir,0755,true);
        }

        $filePath=$target_dir . $fileName;

        if(in_array($fileActualExt,$allowed)){
            if ($fileError === 0){
                if($fileSize<100000000){
                    $sql="INSERT INTO download (filename) VALUES('$fileName')";
                    $query=mysqli_query($conn,$sql);
                    move_uploaded_file($fileTmpName,$filePath);
                    header('Location:download.php');
                } else{
                    echo "Your file is too big.";
                }
            }else{
                echo "There was an error uploading your file.";
            }
        }else{
            echo "You cannot upload files of this type";
        }
    }
    ?>

    <form action="userprofile.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="file" id="file"/>
        <button type="submit" name="submit" value="upload">Upload</button>
    </form>
</body>
</html>

        