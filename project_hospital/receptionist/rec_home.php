<?php
session_start();
if (isset($_SESSION['rlogged_in']) && $_SESSION['rlogged_in'] == true) {
    $userId = $_SESSION['user_id'];
} else {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rec Home</title>
    <link rel="shortcut icon" href="images/medicine.png" type="image/png">
    <style>
        table {
            margin: 0 auto;
            font-size: large;
            border: 1px solid black;
            width: 95%;
            border-collapse: collapse;
        }
        td {
            background-color: #E4F5D4;
            border: 1px solid black;
        }
        th, td {
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
    <?php include 'topnav.php'; ?>
    <main>
    <?php
    require_once('../inc/connection.php');

    // Check database connection
    if (mysqli_connect_error()) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $currentDate = date("Y-m-d");
    $doctorFilter = isset($_GET['doctor']) ? $_GET['doctor'] : 'all';

    // Validate doctorFilter
    if ($doctorFilter !== 'all' && !is_numeric($doctorFilter)) {
        die("Invalid doctor filter value.");
    }

    // Fetch doctors for the filter dropdown
    $sqlDoctors = "SELECT doctor_id, doctor_name FROM doctor";
    $resultDoctors = mysqli_query($conn, $sqlDoctors);
    if ($resultDoctors === false) {
        die("Doctors query failed: " . mysqli_error($conn));
    }

    // Fetch appointments with doctor names using a JOIN
    $sqlAppointments = "SELECT a.*, d.doctor_name 
                       FROM appointments a 
                       LEFT JOIN doctor d ON a.doctor_id = d.doctor_id 
                       WHERE a.appointment_date = ?";
    if ($doctorFilter !== 'all') {
        $sqlAppointments .= " AND a.doctor_id = ?";
    }
    $sqlAppointments .= " ORDER BY a.appointment_time";

    $stmt = mysqli_prepare($conn, $sqlAppointments);
    if ($stmt === false) {
        die("Prepare failed: " . mysqli_error($conn));
    }

    if ($doctorFilter !== 'all') {
        mysqli_stmt_bind_param($stmt, "si", $currentDate, $doctorFilter);
    } else {
        mysqli_stmt_bind_param($stmt, "s", $currentDate);
    }
    mysqli_stmt_execute($stmt);
    $resultAppointments = mysqli_stmt_get_result($stmt);
    if ($resultAppointments === false) {
        die("Appointments query failed: " . mysqli_error($conn));
    }
    ?>

    <h1>Appointments</h1>
    <form method="GET" action="">
        <label for="doctor">Filter by Doctor:</label>
        <select id="doctor" name="doctor">
            <option value="all">All Doctors</option>
            <?php
            while ($rowDoctor = mysqli_fetch_assoc($resultDoctors)) {
                $selected = ($doctorFilter == $rowDoctor['doctor_id']) ? 'selected' : '';
                echo "<option value=\"{$rowDoctor['doctor_id']}\" $selected>" . htmlspecialchars($rowDoctor['doctor_name']) . "</option>";
            }
            mysqli_free_result($resultDoctors);
            ?>
        </select>
        <input type="submit" value="Filter">
    </form>

    <table>
        <thead>
            <tr>
                <th>Token Number</th>
                <th>Appointment ID</th>
                <th>Doctor Name</th>
                <th>Patient Name</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Date of Birth</th>
                <th>Address</th>
                <th>Note</th>
                <th>Date</th>
                <th>Time</th>
                <th>Weight</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        while ($row = mysqli_fetch_assoc($resultAppointments)) {
            $doctorName = $row['doctor_name'] ?? 'Unknown Doctor';
            $appointmentTime12Hour = date("h:i A", strtotime($row['appointment_time']));

            echo "<tr>";
            echo "<td>" . (isset($row['token_number']) && $row['token_number'] !== NULL ? $row['token_number'] : 'Not Assigned') . "</td>";
            echo "<td>" . htmlspecialchars($row['appointment_id']) . "</td>";
            echo "<td>" . htmlspecialchars($doctorName) . "</td>";
            echo "<td>" . htmlspecialchars($row['patient_name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['patient_age']) . "</td>";
            echo "<td>" . htmlspecialchars($row['patient_gender']) . "</td>";
            echo "<td>" . htmlspecialchars($row['date_of_birth']) . "</td>";
            echo "<td>" . htmlspecialchars($row['patient_address']) . "</td>";
            echo "<td>" . htmlspecialchars($row['note']) . "</td>";
            echo "<td>" . htmlspecialchars($row['appointment_date']) . "</td>";
            echo "<td>" . htmlspecialchars($appointmentTime12Hour) . "</td>";
            echo "<td>";
            echo "<form method='POST' action=''>";
            echo "<input type='hidden' name='appointment_id' value='" . htmlspecialchars($row['appointment_id']) . "'>";
            echo "<input type='hidden' name='weight' value='" . htmlspecialchars($row['patient_weight'] ?? '') . "'>";
            if (empty($row['patient_weight'])) {
                echo "<input type='number' name='patient_weight' placeholder='Enter weight' required>";
            } else {
                echo htmlspecialchars($row['patient_weight']);
            }
            echo "</td>";
            echo "<td>" . htmlspecialchars($row['appointment_status']) . "</td>";
            echo "<td>";
            if (empty($row['patient_weight'])) {
                echo "<input type='submit' name='mark_arrived' value='Mark Arrived'>";
            }
            echo "</form>";
            echo "</tr>";
        }
        mysqli_free_result($resultAppointments);
        ?>
        </tbody>
    </table>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mark_arrived'])) {
        $appointmentId = $_POST['appointment_id'];
        $newWeight = $_POST['patient_weight'];

        // Validate inputs
        if (!is_numeric($appointmentId) || !is_numeric($newWeight)) {
            echo "Invalid input.";
            exit();
        }

        // Get doctor_id for the appointment
        $doctorIdQuery = "SELECT doctor_id FROM appointments WHERE appointment_id = ?";
        $stmt = mysqli_prepare($conn, $doctorIdQuery);
        if ($stmt === false) {
            echo "Prepare failed for doctor ID query: " . mysqli_error($conn);
            exit();
        }
        mysqli_stmt_bind_param($stmt, "i", $appointmentId);
        mysqli_stmt_execute($stmt);
        $doctorIdResult = mysqli_stmt_get_result($stmt);
        if ($doctorIdResult === false) {
            echo "Error fetching doctor ID: " . mysqli_error($conn);
            exit();
        }
        $doctorIdRow = mysqli_fetch_assoc($doctorIdResult);
        if (!$doctorIdRow) {
            echo "Appointment not found.";
            exit();
        }
        $doctorId = $doctorIdRow['doctor_id'];

        // Get max token number for the doctor on the current date
        $maxTokenQuery = "SELECT MAX(token_number) AS max_token FROM appointments WHERE appointment_date = ? AND doctor_id = ?";
        $stmt = mysqli_prepare($conn, $maxTokenQuery);
        if ($stmt === false) {
            echo "Prepare failed for max token query: " . mysqli_error($conn);
            exit();
        }
        mysqli_stmt_bind_param($stmt, "si", $currentDate, $doctorId);
        mysqli_stmt_execute($stmt);
        $maxTokenResult = mysqli_stmt_get_result($stmt);
        if ($maxTokenResult === false) {
            echo "Error fetching max token: " . mysqli_error($conn);
            exit();
        }
        $maxTokenRow = mysqli_fetch_assoc($maxTokenResult);
        $maxTokenNumber = $maxTokenRow['max_token'] ?? 0;
        $newTokenNumber = $maxTokenNumber + 1;

        // Update appointment with weight, status, and token number
        $updateStatusQuery = "UPDATE appointments SET patient_weight = ?, appointment_status = 'Arrived', token_number = ? WHERE appointment_id = ?";
        $stmt = mysqli_prepare($conn, $updateStatusQuery);
        if ($stmt === false) {
            echo "Prepare failed for update query: " . mysqli_error($conn);
            exit();
        }
        mysqli_stmt_bind_param($stmt, "dii", $newWeight, $newTokenNumber, $appointmentId);
        $updateStatusResult = mysqli_stmt_execute($stmt);

        if ($updateStatusResult) {
            echo "Token generated successfully. New Token Number: $newTokenNumber";
            echo "<meta http-equiv='refresh' content='2;url=rec_home.php'>";
        } else {
            echo "Error updating appointment status: " . mysqli_error($conn);
        }
        exit();
    }

    mysqli_close($conn);
    ?>
    </main>
</body>
</html>