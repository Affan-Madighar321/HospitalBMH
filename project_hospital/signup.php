
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Biradar Multispeciality Hospital</title>
    <link rel="shortcut icon" href="images/medicine.png" type="image/x-icon">
    <style>
	body{
		padding: 5%;
	}
	.container{
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 360;
  padding: 2px;
  margin-top: 3%;
  background: white;
  border-radius: 10px;
  box-shadow: 10px 10px 15px rgba(0,0,0,0.05);
  
}
.container h1{
  color:darkred;
  text-align: center;
  border-bottom: 1px solid silver;
}
.container
 form{
  padding: 0 40px;
  box-sizing: border-box;
}
form .id{
  position: relative;
  border-bottom: 2px solid  #2691d9;
  margin: 20px 0;
}
.id input{
  width: 100%;
  padding: 5px 5px;
  height: 20px;
  font-size: 18px;
  border: none;
  background: none;
  outline: none;
}
.id label{
  left: 5px;
  color: #272a2c;
  font-size: 16px;
  pointer-events: none;

}


button{
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
button:hover{
  border-color: #2691d9;
  transition: .5s;
}
.btn{
  margin: 30px 0;
  text-align: center;
  font-size: 16px;
  color: #666666;
}
.btn a{
  color: #2691d9;
  text-decoration: none;
}
.btn a:hover{
  text-decoration: underline;
}
	</style>
</head>
<body>
<?php
require_once("inc/header.php");
?>

<main>
    <div class="container">
        <form action="" method="post" class="new">
            <h1>CREATE NEW!</h1>
            <div class="id">
                <label>Name</label>
                <input type="text" name="user_name"/>
            </div>
            <div class="btnn">
                Gender
                <select class="btn" name="user_gender">
                    <option>Male</option>
                    <option>Female</option>
                    <option>Other</option>
                </select>
            </div>

            <div>
                <label for="user_dob">Date of Birth:</label>
                <input type="date"  name="user_dob" required>
            </div>

            <div class="id">
                <label>Email</label>
                <input type="email" name="user_email"/>
            </div>

            <div class="id">
                <label>Password</label>
                <input type="password" name="user_password" required  />
            </div>
            <div class="id">
                <label>Confirm Password</label>
                <input type="password" name="user_cpassword" required  />
            </div>

            <div class="btn">
                <button value="submit" name="insert_btn">Submit</button>
            </div>
        </form>
    </div>

    <?php
    require_once('inc/connection.php');

    if(isset($_POST['insert_btn'])){
        $user_name =  $_POST['user_name'];
        $user_age = $_POST['user_age'];
        $user_gender = $_POST['user_gender'];
        
        
        $userDOB = md5($_POST['user_dob']);
        
        $user_email =  $_POST['user_email'];
        $user_password =  $_POST['user_password'];
        $user_cpassword = $_POST['user_cpassword'];

        if ($user_password !== $user_cpassword) {
            echo "Passwords do not match. Please try again.";
        } else {
            $check_email = "SELECT * FROM user WHERE user_email='$user_email'";
            $run_check_email = mysqli_query($conn, $check_email);

            if(mysqli_num_rows($run_check_email) > 0){
                echo "Email Already Exists";
            } else {
                
                $hashed_password = md5($user_password);

                $insert_user = "INSERT INTO user(user_name,user_age,user_gender,user_dob,user_email,user_password) VALUES('$user_name','$user_age','$user_gender','$userDOB','$user_email','$hashed_password')";

                $run_insert =  mysqli_query($conn, $insert_user);

                if($run_insert === true){
                    echo "<script>window.open('login.php','_self');</script>";
                } else {
                    echo "Failed, Try Again";
                }
            }
        }
    }		
    ?>
</main>
</body>
</html>
