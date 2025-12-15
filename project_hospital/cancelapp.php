<?php
    require_once('inc/connection.php');
    session_start();
    if(isset($_SESSION['ulogged_in']) && $_SESSION['ulogged_in']==true){
      $userId = $_SESSION['user_id'];
  }else{
      header("location:login.php");
  }

$userId = $_SESSION['user_id'];

include 'inc/connection.php';

$sqlUserName = "SELECT user_name FROM user WHERE user_id = $userId";
$resultUserName = mysqli_query($conn, $sqlUserName);
$rowUserName = mysqli_fetch_assoc($resultUserName);
$userName = $rowUserName['user_name'];



$sqlAppointments = "SELECT * FROM appointments WHERE user_id = $userId";
$resultAppointments = mysqli_query($conn, $sqlAppointments);
?>

<!DOCTYPE html>
<html lang="en">
<head>
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
  </style>
</head>
<body>
<?php
    require_once("inc/header.php");
    ?>
    <main>
    <?php
        require_once('inc/connection.php');

        if(isset($_GET['del'])){
            $del_id=$_GET['del'];
        $delete = "DELETE FROM appointments WHERE appointment_id='$del_id' ";
        $run_delete = mysqli_query($conn,$delete);

        if($run_delete === true){
            echo"record has been deleted";
        }else{
            echo "Failed , try again";
        }
        }
        ?>
  <h2>View Appointments</h2>
  <table>
    <thead>
      <tr>
        <th>Appointment Id</th>
        <th>Doctor Name</th>
        <th>Patient Name</th>
        <th>Age</th>
        <th>Gender</th>
        <th>Patient Number</th>
        <th>Date of Birth</th>
        <th>Patient Address
        <th>Note</th>
        
        <th>Date</th>
        <th>Time</th>
        <th>status</th>
      </tr>
    </thead>
    <tbody>
      <?php
      while ($rowAppointment = mysqli_fetch_assoc($resultAppointments)) {
        $appointmentId = $rowAppointment['appointment_id'];
        $doctorId = $rowAppointment['doctor_id'];
        $patientName = $rowAppointment['patient_name'];
        $patientName = $rowAppointment['patient_name'];
        $patientAge = $rowAppointment['patient_age'];
        $patientGender = $rowAppointment['patient_gender'];
        $dateOfBirth = $rowAppointment['date_of_birth'];
        $patientAddress = $rowAppointment['patient_address'];
        $note = $rowAppointment['note'];
        $patientNumber = $rowAppointment['patient_mobilenumber'];
        $appointmentDate = $rowAppointment['appointment_date'];
        $appointmentTime = $rowAppointment['appointment_time'];
        $appointmentStatus = $rowAppointment['appointment_status']; 

        $sqlDoctor = "SELECT doctor_name FROM doctor WHERE doctor_id = $doctorId";
        $resultDoctor = mysqli_query($conn, $sqlDoctor);
        $rowDoctor = mysqli_fetch_assoc($resultDoctor);
        $doctorName = $rowDoctor['doctor_name'];
      ?>
      <tr>
        <td><?php echo $appointmentId; ?></td>
        <td><?php echo $doctorName; ?></td>
        <td><?php echo $patientName; ?></td>
        <td><?php echo !empty($patientAge) ? $patientAge : 'N/A'; ?></td>
        <td><?php echo !empty($patientGender) ? $patientGender : 'N/A'; ?></td>
        <td><?php echo $patientNumber; ?></td>
        <td><?php echo !empty($dateOfBirth) ? $dateOfBirth : 'N/A'; ?></td>
        <td><?php echo !empty($patientAddress) ? $patientAddress : 'N/A'; ?></td>
        <td><?php echo !empty($note) ? $note : 'N/A'; ?></td>
        <td><?php echo $appointmentDate; ?></td>
        <td><?php echo date("h:i A", strtotime($appointmentTime)); ?></td>
        <td>
        <?php if ( !empty($patientWeight)) : ?>
                <?php echo $patientWeight; ?>
            <?php else : ?>
                N/A
            <?php endif; ?>
        </td>
        <td>
    <?php if ($appointmentStatus === 'Arrived') : ?>
        <span>Arrived, cannot delete</span>
    <?php elseif ($appointmentStatus === 'Visited') : ?>
        <span>visited</span>
    <?php else : ?>
        <button class="red"><a href="cancelapp.php?del=<?php echo $appointmentId ;?> " onclick="return confirm('Are you sure you want to delete this appointment?')">Delete</a></button>
    <?php endif; ?>
</td>
      </tr>
      <?php
      }
      ?>
    </tbody>
  </table>
    </main>
  <?php
    require_once('inc/footer.php');
    ?>
</body>
</html>
