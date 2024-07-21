<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="profile.css" rel="stylesheet" >
    <title>Profile</title>
</head>
<body>
    <?php 
    session_start();
    
    

    $fileName=$_SESSION['fName'];

    if(!empty($fileName)){
        $filePath='files/' . $fileName;
        if(file_exists($filePath)){
            echo "<div class='profile-picture-container bg-dark text-white' >";
            echo "<h1 class='text-center'>"."Profile"."<h1>";
            echo "<div >";
            echo "<img src='$filePath' class='profile-picture' width='40' height='40'/>";
            echo "</div>";
            echo "</div>";
        }
        
    }
    ?>

</body>
</html>