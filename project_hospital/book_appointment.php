<?php
    require_once('inc/connection.php');
    session_start();
    if(isset($_SESSION['ulogged_in']) && $_SESSION['ulogged_in']==true){
      $userId = $_SESSION['user_id'];
  }else{
      header("location:login.php");
  }
?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  if (isset($_GET['doctor_id']) && isset($_GET['date']) && isset($_GET['time_slot'])) {

    include 'inc/connection.php';

    $doctorId = $_GET['doctor_id'];
    $date = $_GET['date'];
    $timeSlot = $_GET['time_slot'];

    $sqlCheckBooking = "SELECT * FROM appointments WHERE doctor_id = $doctorId AND appointment_date = '$date' AND appointment_time = '$timeSlot'";
    $resultBooking = mysqli_query($conn, $sqlCheckBooking);
    if (mysqli_num_rows($resultBooking) > 0) {
      echo "Sorry, the selected slot is already booked.";
    } else {
?>
<!DOCTYPE html>
<html>
<head>
  <title>Biradar Multispeciality Hospital</title>
  <link rel="shortcut icon" href="images/medicine.png" type="image/x-icon">
  <style>
    body {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 125vh;
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    .container {
      width: 400px;
      padding: 20px;
      background-color: #fff;
      box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.1);
      border-radius: 5px;
    }

    h2 {
      font-size: 24px;
      margin-bottom: 10px;
      color: darkred;
	  text-align: center;
	  padding: 10px 0;
	  border-bottom: 1px solid silver;
    }

    form {
      display: flex;
      flex-direction: column;
    }

    label {
      font-weight: bold;
      margin-bottom: 5px;
    }

    input[type="text"],
    input[type="number"],
    input[type="tel"],
    select,
    textarea {
      padding: 10px;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 16px;
    }

    select {
      height: 38px;
    }

    textarea {
      height: 100px;
      resize: vertical;
    }
    input[type="submit"] {
  background-color: #2196F3;
  color: #fff;
  border: none;
  border-radius: 4px;
  padding: 10px 20px;
  cursor: pointer;
  font-size: 16px;
  margin-top: 20px;
}

input[type="submit"]:hover {
  background-color: #1565C0;
}
  </style>
</head>
<body>
<?php
    require_once("inc/header.php");
    ?>
    <main class="container">
  <h2>Book Appointment</h2>
  <form method="POST" action="">
    <input type="hidden" name="doctor_id" value="<?php echo $doctorId; ?>">
    <input type="hidden" name="date" value="<?php echo $date; ?>">
    <input type="hidden" name="time_slot" value="<?php echo $timeSlot; ?>">
    <input type="hidden" name="user_id" value="<?php echo $userId; ?>">

    <label for="patient_name">Your Name:</label>
    <input type="text" id="patient_name" name="patient_name" required>

    <label for="patient_gender">Gender:</label>
    <select id="patient_gender" name="patient_gender" required>
      <option value="Male">Male</option>
      <option value="Female">Female</option>
      <option value="Other">Other</option>
    </select>

    <label for="date_of_birth">Date of Birth:</label>
    <input type="date" id="date_of_birth" name="date_of_birth" required>

    <input type="hidden" id="patient_age" name="patient_age" value="<?php echo $age; ?>">

    <label for="patient_address">Address:</label>
    <textarea id="patient_address" name="patient_address" required></textarea>

    <label for="patient_mobilenumber">Mobile Number:</label>
    <input type="number" id="patient_mobilenumber" name="patient_mobilenumber" required>

    <label for="note">Note:</label>
    <textarea id="note" name="note"></textarea>

    <input type="submit" name="submit_booking" value="Book Appointment">
  </form>
    </main>
    
</body>
</html>
<?php
    }
  } else {
    header('Location: bookapp.php');
    exit;
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['submit_booking'])) {

    include 'inc/connection.php';

    $doctorId = $_POST['doctor_id'];
    $date = $_POST['date'];
    $timeSlot = $_POST['time_slot'];
    $patientName = $_POST['patient_name'];
    $patientGender = $_POST['patient_gender'];
    $dateOfBirth = $_POST['date_of_birth'];
    $today = new DateTime();
    $patientAge = $today->diff(new DateTime($dateOfBirth))->y;
    $patientAddress = $_POST['patient_address'];
    $patientMobileNumber = $_POST['patient_mobilenumber'];
    $note = $_POST['note'];

    $sqlInsertBooking = "INSERT INTO appointments (user_id, doctor_id, appointment_date, appointment_time, patient_name, patient_age, patient_gender, date_of_birth, patient_address, patient_mobilenumber, note) VALUES ('$userId', '$doctorId', '$date','$timeSlot', '$patientName', '$patientAge', '$patientGender', '$dateOfBirth', '$patientAddress', '$patientMobileNumber', '$note')";
    mysqli_query($conn, $sqlInsertBooking);

    header('Location: cancelapp.php');
    exit;
  }
}
?>
