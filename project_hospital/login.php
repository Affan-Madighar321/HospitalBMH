<!DOCTYPE html>
<html lang="en">
<head>
  <title>Log in</title>
  <link rel="shortcut icon" href="images/medicine.png" type="image/x-icon">
  <style>
	.center {
	  position: absolute;
	  top: 57%;
	  left: 50%;
	  transform: translate(-50%, -50%);
	  width: 400px;
	  background: white;
	  border-radius: 10px;
	  box-shadow: 10px 10px 15px rgba(0,0,0,0.05);
	}
	.center h1 {
	  color: darkred;
	  text-align: center;
	  padding: 20px 0;
	  border-bottom: 1px solid silver;
	}
	.center form {
	  padding: 0 40px;
	  box-sizing: border-box;
	}
	form .txt_field {
	  position: relative;
	  border-bottom: 2px solid  #2691d9;
	  margin: 30px 0;
	}
	.txt_field input {
	  width: 100%;
	  padding: 0 5px;
	  height: 40px;
	  font-size: 20px;
	  border: none;
	  background: none;
	  outline: none;
	}
	.txt_field label {
	  left: 5px;
	  color: #272a2c;
	  font-size: 16px;
	  pointer-events: none;
	}
	.pass {
	  margin: -5px 0 20px 5px;
	  color: #a6a6a6;
	  cursor: pointer;
	}
	.pass:hover {
	  text-decoration: underline;
	}
	input[type="submit"] {
	  width: 100%;
	  height: 50px;
	  border: 1px solid;
	  background: #2691d9;
	  border-radius: 25px;
	  font-size: 18px;
	  color: #e9f4fb;
	  font-weight: 700;
	  cursor: pointer;
	  outline: none;
	}
	input[type="submit"]:hover {
	  border-color: #2691d9;
	  transition: .5s;
	}
	.signup_link {
	  margin: 30px 0;
	  text-align: center;
	  font-size: 16px;
	  color: #666666;
	}
	.signup_link a {
	  color: #2691d9;
	  text-decoration: none;
	}
	.signup_link a:hover {
	  text-decoration: underline;
	}
  </style>
</head>
<body>
<?php
require_once("inc/header.php");
?>
<main>
  <div class="center">
    <h1>Log in</h1>
    <form method="post">
      <div class="txt_field">
        <label>Email Id</label>
        <input type="text" required name="email">
      </div>
      <div class="txt_field">
        <label>Password</label>
        <input type="password" required name="password">
      </div>
      <div class="pass"><a href="reset_pass.php">Forgot Password?</a></div>
      <input type="submit" value="Login" name="login-btn">
      <div class="signup_link">
        Not a member? <a href="signup.php">Signup</a>
      </div>
    </form>

    <?php
    require_once('inc/connection.php');

    if (isset($_POST['login-btn'])) {
      $email =  $_POST['email'];
      $password =  $_POST['password'];

    
      $hashed_password = md5($password);

      $check_email =  "SELECT * FROM user WHERE user_email='$email'";
      $run_email =  mysqli_query($conn, $check_email);

      if (mysqli_num_rows($run_email) == 1) {
        
        $row_email = mysqli_fetch_array($run_email);
        $db_hashed_password = $row_email['user_password'];

        
        if ($hashed_password === $db_hashed_password) {
          
          $db_user_id = $row_email['user_id'];
          $db_doctor_id = $row_email['doctor_id'];
          $db_name =  $row_email['user_name'];
          $db_type =  $row_email['user_type'];
          $db_email =  $row_email['user_email'];

          
          if ($db_type == 'user') {
            $_SESSION['user_id'] = $db_user_id;
            $_SESSION['email'] = $db_email;
            $_SESSION['name'] = $db_name;
            $_SESSION['type'] = $db_type;
            $_SESSION['ulogged_in'] = true;
            echo "<script>window.open('user_home.php','_self');</script>";
            exit();
          } elseif ($db_type == 'admin') {
            $_SESSION['email'] = $db_email;
            $_SESSION['name'] = $db_name;
            $_SESSION['type'] = $db_type;
            $_SESSION['alogged_in'] = true;
            echo "<script>window.open('admin/admin_home.php','_self');</script>";
            exit();
          } elseif ($db_type == 'receptionist') {
            $_SESSION['user_id'] = $db_user_id;
            $_SESSION['email'] = $db_email;
            $_SESSION['name'] = $db_name;
            $_SESSION['type'] = $db_type;
            $_SESSION['rlogged_in'] = true;
            echo "<script>window.open('receptionist/rec_home.php','_self');</script>";
            exit();
          } elseif ($db_type == 'doctor') {
            $_SESSION['doctor_id'] = $db_doctor_id;
            $_SESSION['email'] = $db_email;
            $_SESSION['name'] = $db_name;
            $_SESSION['type'] = $db_type;
            $_SESSION['dlogged_in'] = true;
            echo "<script>window.open('doctor/dr_home.php','_self');</script>";  
            exit();
          }
        } else {
          
          echo "Password is incorrect.";
        }
      } else {
        
        echo "Email not found.";
      }
    }
    ?>
  </div>
</main>
</body>
</html>
