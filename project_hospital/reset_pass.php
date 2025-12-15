<?php
session_start();
include('inc/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset-btn'])) {
    $email = $_POST['email'];
    $birthdate = $_POST['birthdate'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    $check_user = "SELECT * FROM user WHERE user_email='$email' AND user_dob=MD5('$birthdate')";
    $run_check_user = mysqli_query($conn, $check_user);

    if (mysqli_num_rows($run_check_user) > 0) {
        if ($newPassword === $confirmPassword) {
            
            $hashed_password = md5($newPassword);

            
            $update_password = "UPDATE user SET user_password='$hashed_password' WHERE user_email='$email'";
            $run_update_password = mysqli_query($conn, $update_password);

            if ($run_update_password) {
                $reset_success = "Password reset successful. You can now login with your new password.";
                header("location: login.php");
            } else {
                $reset_error = "Password reset failed.";
            }
        } else {
            $reset_error = "Passwords do not match.";
        }
    } else {
        $reset_error = "Invalid email or birthdate.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Biradar Multispeciality Hospital</title>
    <link rel="shortcut icon" href="images/medicine.png" type="image/x-icon">
    <style>
          main{
            display: flex;
            padding: 5px;
            width: 80%;
        }
        .container{
            
           position: absolute;
           top: 30%;
           left: 50%;
           transform: translate(-50%, -50%);
           width: 400px;
           background: azure;
           border-radius: 10px;
           box-shadow: 10px 10px 15px rgba(0,0,0,0.05);
        }
        
       
        .new{
            width: 360px;
        }

         h2{
            font-size: 35px;
            color: red;
        }
         form{
            padding: 10px 0 0 0;
            
        }
        form .nm{
            margin: 30px 0;
        }
                 
        .nm label{
            
            font-weight: bold;
        margin-bottom: 5px;
        display: block;
        }
        
        .btn {
        display: inline-block;
        padding: 10px 20px;
        background-color: blue;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 20px;
        
    }
    </style>
</head>
<body>
<?php
	  require_once("inc/header.php");
	?>

    <main class="container">
        <div class= "new">   
        <form method="post" action="">
             <h2>Forgot Password</h2>

    
    <div class="nm">
          <label for="email">Email:</label>
          <input type="email" name="email" required><br>
        </div>
        <div class="nm">
          <label for="birthdate">Birthdate:</label>
          <input type="date" name="birthdate" required><br>
    </div>
    <div class="nm">
            <label for="new_password">New Password:</label>
            <input type="password" name="new_password" required><br>
        </div>
        <div class="nm">
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" name="confirm_password" required><br>
        </div>
            <input type="submit" value="Reset Password" name="reset-btn">
    </form>
    <?php
    if (isset($reset_success)) {
        echo "<p>$reset_success</p>";
    } elseif (isset($reset_error)) {
        echo "<p>$reset_error</p>";
    }
    ?>
    </div>

</main>
</body>
</html>
