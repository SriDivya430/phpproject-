<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="userinfo.css">
</head>
<body>
    <div class="username-container">
        <h1 class="username">
            <?php 
            session_start();
            echo $_SESSION['username'];
            ?>
        </h1>
    </div>
</body>
</html>