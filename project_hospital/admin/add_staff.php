<?php
session_start();
if(isset($_SESSION['alogged_in']) && $_SESSION['alogged_in'] == true){
    // Continue running
} else {
    header("location:../login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biradar Multispeciality Hospital</title>
    <link rel="shortcut icon" href="images/medicine.png" type="image/x-icon">
    <style>
		table {
			margin: 0 auto;
			font-size: large;
			border: 1px solid black;
			width:95%;
			border-collapse:collapse;
            
		}

		h1 {
            margin-left:35px;
			color: #006600;
            display:inline;
		}

		td {
			background-color: #E4F5D4;
			border: 1px solid black;
		}

		th,
		td {
			font-weight: bold;
			border: 1px solid black;
			text-align: center;
		}

		td {
			font-weight: lighter;
		}
        .red{ background-color:red;
            border-radius:4px;
            padding:5px 15px;
        }
        .add{background-color:azure;
            border-radius:4px;
            padding:5px 15px;
            float:right;
            margin-right:5%;
            


        }
        
	</style>
</head>
<body>
<?php
include 'sidebar.php';
?>

<main>
<?php

require_once('../inc/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userName = $_POST['user_name'];
    $userAge = $_POST['user_age'];
    $userGender = $_POST['user_gender'];
    $userMobilenumber = $_POST['user_mobilenumber'];
    $userEmail = $_POST['user_email'];
    $userPassword = md5($_POST['user_password']);
    $userType = $_POST['user_type'];
    $userDOB = md5($_POST['user_dob']);
    $doctorId = ($userType === 'doctor') ? $_POST['doctor_id'] : null;

    $check_email = "SELECT * FROM user WHERE user_email='$userEmail'";
    $run_check_email = mysqli_query($conn, $check_email);

    if(mysqli_num_rows($run_check_email) > 0) {
        echo "Email Already Exists";
    } else {
        $sqlInsert = "INSERT INTO user (user_name, user_age, user_gender, user_mobilenumber, user_email, user_password, user_type, user_dob, doctor_id)
                      VALUES ('$userName', '$userAge', '$userGender', '$userMobilenumber', '$userEmail', '$userPassword', '$userType', '$userDOB', '$doctorId')";
        $resultInsert = mysqli_query($conn, $sqlInsert);

        if ($resultInsert) {
            echo "User added successfully!";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>

    <h2>Add User</h2>
    <form method="POST" action="">
        <div class>
        <label for="user_name">Name:</label>
        <input type="text"  name="user_name" required>
        </div>

        <div>
        <label for="user_age">Age:</label>
        <input type="number"  name="user_age" required>
        </div>

        <div>
        <label for="user_gender">Gender:</label>
    <select  name="user_gender">
        <option value="male">Male</option>
        <option value="female">Female</option>
        <option value="other">Other</option>
    </select>
        </div>

        <div>
        <label for="user_mobilenumber">Mobile No. :</label>
        <input type="tel"  name="user_mobilenumber" required>
        </div>

        <div>
        <label for="user_dob">Date of Birth:</label>
        <input type="date"  name="user_dob" required>
        </div>

        <div>
        <label for="user_name">Email:</label>
        <input type="email"  name="user_email" required>
        </div>

        <div>
        <label for="user_password">Password:</label>
        <input type="password"  name="user_password" required>
        </div>

        <div>
        <label for="user_type">User Type:</label>
        <select name="user_type" id="user_type">
        <option value="receptionist">Receptionist</option>
        <option value="doctor">Doctor</option>
        </select>
        </div>

        <div id="doctor_select" style="display: none;">
        <label for="doctor_id">Select Doctor:</label>
        <select name="doctor_id">
        <?php
        $sqlDoctors = "SELECT doctor_id, doctor_name FROM doctor";
        $resultDoctors = mysqli_query($conn, $sqlDoctors);

        while ($rowDoctor = mysqli_fetch_assoc($resultDoctors)) {
            echo '<option value="' . $rowDoctor['doctor_id'] . '">' . $rowDoctor['doctor_name'] . '</option>';
        }
        ?>
    </select>
</div>

        

        <div>
        <input type="submit" value="Add User">
        </div>
    </form>
</main>

<script>
document.getElementById('user_type').addEventListener('change', function() {
    var doctorSelectDiv = document.getElementById('doctor_select');
    
    if (this.value === 'doctor') {
        doctorSelectDiv.style.display = 'block';
    } else {
        doctorSelectDiv.style.display = 'none';
    }
});
</script>

</body>
</html>


