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
        label {
            margin-left: 33px;
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
    </style>
</head>
<body>
<?php
    include 'sidebar.php';
    ?>
    <main>
    <?php
    require_once('../inc/connection.php');

    if(isset($_GET['del'])) {
        $del_id = $_GET['del'];
        
        
        $sqlDeleteAppointment = "DELETE FROM appointments WHERE appointment_id='$del_id'";
        
    
        $run_delete = mysqli_query($conn, $sqlDeleteAppointment);
    
        if($run_delete === true) {
            echo "Record has been deleted";
        } else {
            echo "Failed to delete the record, please try again";
        }
    }
    

    $sqlDoctors = "SELECT doctor_id, doctor_name FROM doctor";
    $resultDoctors = mysqli_query($conn, $sqlDoctors);


    $doctorFilter = isset($_GET['doctor']) ? $_GET['doctor'] : 'all';
    
    $sqlAppointments = "SELECT * FROM appointments";
    if ($doctorFilter !== 'all') {
        $sqlAppointments .= " WHERE doctor_id = $doctorFilter";
    }
    
    $resultAppointments = mysqli_query($conn, $sqlAppointments);

    ?>

    <h1>Appointments</h1>
    <form method="GET" action="">
        <label for="doctor">Filter by Doctor:</label>
        <select id="doctor" name="doctor">
            <option value="all">All Doctors</option>
            <?php
            while ($rowDoctor = mysqli_fetch_assoc($resultDoctors)) {
                $selected = $doctorFilter == $rowDoctor['doctor_id'] ? 'selected' : '';
                echo "<option value=\"{$rowDoctor['doctor_id']}\" $selected>{$rowDoctor['doctor_name']}</option>";
            }
            ?>
        </select>
        <input type="submit" value="Filter">
    </form>
    
    <table>
        <thead>
            <tr>
                <th>Appointment ID</th>
                <th>Doctor ID</th>
                <th>Patient Name</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Mobile No</th>
                <th>DOB</th>
                <th>Weight</th>
                <th>Addresss</th>
                <th>Note</th>
                <th>Date</th>
                <th>Time</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($resultAppointments)) {
                echo "<tr>";
                echo "<td>{$row['appointment_id']}</td>";
                echo "<td>{$row['doctor_id']}</td>";
                echo "<td>{$row['patient_name']}</td>";
                echo "<td>{$row['patient_age']}</td>";
                echo "<td>{$row['patient_gender']}</td>";
                echo "<td>{$row['patient_mobilenumber']}</td>";
                echo "<td>{$row['date_of_birth']}</td>";
                echo "<td>{$row['patient_weight']}</td>";
                echo "<td>{$row['patient_address']}</td>";
                echo "<td>{$row['note']}</td>";
                echo "<td>{$row['appointment_date']}</td>";
                echo "<td>" . date('h:i A', strtotime($row['appointment_time'])) . "</td>";
                echo "<td><a class='red' href='?del={$row['appointment_id']}' onclick='return confirm(\"Are you sure you want to delete this appointment?\")'>delete</a></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    </main>
</body>
</html>