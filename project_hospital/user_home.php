<?php
session_start();
if(isset($_SESSION['ulogged_in']) && $_SESSION['ulogged_in']==true){
    echo  "welcome $_SESSION[email]";
}else{
    header("location:login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biradar Multispeciality Hospital</title>
    <link rel="shortcut icon" href="images/medicine.png" type="image/x-icon">
    <style>
        .center-text {
            text-align: center;
            margin-top: 220px;
        }
    </style>
</head>
<body>
    <?php
    include 'inc/header.php';
    ?>
    <main>
    <h1 class="center-text">Hello <b><?php echo $_SESSION['name']; ?></b> Welcome to our Hospital Website</h1>
    </main>
    <?php
    require_once('inc/footer.php');
    ?>
</body>
</html>