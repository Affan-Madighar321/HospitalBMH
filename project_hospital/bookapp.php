<?php
require_once('inc/connection.php');
session_start();
if(isset($_SESSION['ulogged_in']) && $_SESSION['ulogged_in'] == true){
  echo "Welcome $_SESSION[user_id]";
}else{
  header("location:login.php");
}
date_default_timezone_set('Asia/Kolkata');

function isTimeSlotPassed($date, $timeSlot) {
  $currentTime = time();
  $dateTimeSlot = strtotime("$date $timeSlot");
  return $dateTimeSlot < $currentTime;
}

function convertToUserLocalTime($serverTimestamp, $userTimezoneOffset) {
  $serverTime = strtotime($serverTimestamp);
  $userTime = $serverTime + ($userTimezoneOffset * 60);
  return date('h:i A', $userTime);
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
    h2 {
  font-size: 24px;
  margin-bottom: 20px;
  margin-left: 100px;
  margin-right: 10px;
  display: block;
}

    form {
      display: flex;
      align-items: center;
      margin-bottom: 20px;
      max-width: 800px;
      margin: 20px auto;
      padding: 20px;
      border: 1px solid #ddd;
      border-radius: 5px;
      box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.1);
    }

    select, input[type="submit"] {
      padding: 8px;
      border: 1px solid #ddd;
      border-radius: 4px;
      margin-right: 10px;
      font-size: 14px;
    }

    .appointment-table {
      display: inline-block;
      vertical-align: top;
      margin-right: 20px; 
    }

    .appointment-table {
      width: 300px;
      max-width: 100%; 
    }

    .table-container {
      overflow: auto; 
      white-space: nowrap; 
    }

    .appointment-table th, .appointment-table td {
      padding: 10px;
      text-align: center;
      border: 1px solid #ddd;
    }

    .appointment-table th {
      background-color: #f2f2f2;
      font-weight: bold;
    }

    .appointment-table tr:hover {
      background-color: #f5f5f5;
    }

    .booked {
      color: #e74c3c;
      font-weight: bold;
    }

    .not-available {
      color: #9e9e9e;
      font-weight: bold;
    }

    .book-button {
      padding: 8px 16px;
      background-color: #2196F3;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    .book-button:hover {
      background-color: #1565C0;
    }
  </style>
</head>
<body>
  <?php
  include 'inc/header.php';
  ?>
  <main>
    <form method="POST" action="">
      <h2>Doctor Appointment Booking: </h2>
      <select id="doctor" name="doctor" required>
        <option value="">Select a Doctor</option>
        <?php
        include 'inc/connection.php';
        $sql = "SELECT doctor_id, doctor_name FROM doctor";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
          $doctorId = $row['doctor_id'];
          $doctorName = $row['doctor_name'];

          
          $sqlAvailability = "SELECT * FROM availability WHERE doctor_id = $doctorId";
          $resultAvailability = mysqli_query($conn, $sqlAvailability);

          if (mysqli_num_rows($resultAvailability) > 0) {
            echo "<option value=\"$doctorId\">$doctorName</option>";
          }
        }
        ?>
      </select>
      <input type="submit" name="submit_doctor" value="Submit">
    </form>

    <?php

    if (isset($_POST['submit_doctor']) && isset($_POST['doctor'])) {
        $selectedDoctor = $_POST['doctor'];
        $sqlAvailability = "SELECT available_date, start_time, end_time FROM availability WHERE doctor_id = $selectedDoctor";
        $resultAvailability = mysqli_query($conn, $sqlAvailability);
        $availableSlots = array();
        while ($row = mysqli_fetch_assoc($resultAvailability)) {
            $date = $row['available_date'];
            $startTime = $row['start_time'];
            $endTime = $row['end_time'];
            $timeSlotInterval = 15;
            $currentTime = strtotime($startTime);
            while ($currentTime <= strtotime($endTime)) {
                $timeSlot24Hour = date('H:i', $currentTime);
                $timeSlot12Hour = date('h:i A', strtotime($timeSlot24Hour));
                $availableSlots[$date][] = array('24-hour' => $timeSlot24Hour, '12-hour' => $timeSlot12Hour);
                $currentTime += $timeSlotInterval * 60;
            }
        }
        ?>
        <div class="table-container">
            <?php foreach ($availableSlots as $date => $timeSlots) {?>
                <table class="appointment-table">
                    <thead>
                        <tr>
                            <th colspan="2"><?php echo $date; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="time-label">Time Slot</td>
                            <td class="time-slot">Available Slots</td>
                        </tr>
                        <?php foreach ($timeSlots as $timeSlot) { ?>
                          <tr>
            <td><?php echo $timeSlot['12-hour']; ?></td>
            <td>
                <?php
                $sqlCheckBooking = "SELECT * FROM appointments WHERE doctor_id = $selectedDoctor AND appointment_date = '$date' AND appointment_time = '{$timeSlot['24-hour']}'";
                $resultBooking = mysqli_query($conn, $sqlCheckBooking);
                
                if (isTimeSlotPassed($date, $timeSlot['24-hour'])) {
                    echo "Not available";
                } elseif (mysqli_num_rows($resultBooking) > 0) {
                    echo "Booked";
                } else {
                  $sqlDoctorName = "SELECT doctor_name FROM doctor WHERE doctor_id = $selectedDoctor";
                  $resultDoctorName = mysqli_query($conn, $sqlDoctorName);
                  $doctorName = mysqli_fetch_assoc($resultDoctorName)['doctor_name'];
                  $formattedTimeSlot = date('H:i', strtotime($timeSlot['12-hour']));

                  ?>
                  <button class="book-button" onclick="confirmBooking(<?php echo $selectedDoctor; ?>, '<?php echo $doctorName; ?>', '<?php echo $date; ?>', '<?php echo $formattedTimeSlot; ?>')">Book</button>
                    <?php
                }
                ?>
            </td>
        </tr>
    <?php } ?>
                    </tbody>
                </table>
            <?php } ?>
        </div>
    <?php } ?>

  </main>
  <script>
  function confirmBooking(doctorId, doctorName, date, timeSlot) {
      const confirmationMessage = `Are you sure you want to book an appointment with ${doctorName} on ${date} at ${timeSlot}?`;
      const confirmation = confirm(confirmationMessage);
      
      if (confirmation) {
          window.location.href = `book_appointment.php?doctor_id=${doctorId}&date=${date}&time_slot=${timeSlot}`;
      }
  }
  </script>
</body>
</html>
