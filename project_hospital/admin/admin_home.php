<?php
session_start();
if(isset($_SESSION['alogged_in']) && $_SESSION['alogged_in']==true){
    //run
}else{
    header("location:../login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin home</title>
    <link rel="shortcut icon" href="images/medicine.png" type="image/x-icon">
    <style>
        
        
        main {
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 20px;
            border-radius: 5px;
        }
        
        h1 {
            color: #4caf50;
            font-size: 2rem;
            margin-bottom: 20px;
        }
        
        p {
            color: #333;
            font-size: 1.2rem;
            line-height: 1.5;
        }
        
        .hospital-info {
            background-color: #4caf50;
            color: #fff;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .hospital-info h2 {
            margin: 0;
            font-size: 1.5rem;
        }
        
        .hospital-info p {
            margin: 0;
            font-size: 1rem;
        }
    </style>
</head>
<body>
<?php
    include 'sidebar.php';
    ?>
    <main>
        <div class="hospital-info">
            <h2>Biradar Multispeciality Hospital</h2>
            <p>Providing quality healthcare services since 2013.</p>
        </div>
        <h1>Welcome, Admin!</h1>
        <p>You are now logged in as an Administrator. You have full access to the system.</p>
    </main>
</body>
</html>