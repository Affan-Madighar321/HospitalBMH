<?php
session_start();
require_once('../inc/connection.php');

// Check if user is logged in
if (!isset($_SESSION['rlogged_in']) || $_SESSION['rlogged_in'] !== true || !isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Verify database connection
if (!$conn || mysqli_connect_error()) {
    error_log("Connection failed: " . mysqli_connect_error());
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch user name
$sqlUserName = "SELECT user_name FROM user WHERE user_id = ?";
$stmtUserName = mysqli_prepare($conn, $sqlUserName);
if (!$stmtUserName) {
    error_log("Prepare failed for user name query: " . mysqli_error($conn));
    die("Prepare failed for user name query: " . mysqli_error($conn));
}
mysqli_stmt_bind_param($stmtUserName, "i", $userId);
mysqli_stmt_execute($stmtUserName);
$resultUserName = mysqli_stmt_get_result($stmtUserName);
if ($resultUserName === false) {
    error_log("User name query failed: " . mysqli_error($conn));
    die("User name query failed: " . mysqli_error($conn));
}
$rowUserName = mysqli_fetch_assoc($resultUserName);
$userName = $rowUserName ? htmlspecialchars($rowUserName['user_name']) : 'Unknown User';
mysqli_stmt_close($stmtUserName);

// Handle deletion
if (isset($_GET['del']) && is_numeric($_GET['del'])) {
    $del_id = (int)$_GET['del'];

    // Debug: Log deletion attempt
    error_log("Attempting to delete appointment ID: $del_id for user ID: $userId");

    // Verify the appointment belongs to the user and is not Arrived or Visited
    $checkQuery = "SELECT appointment_status FROM appointments WHERE appointment_id = ? AND user_id = ?";
    $checkStmt = mysqli_prepare($conn, $checkQuery);
    if (!$checkStmt) {
        error_log("Prepare failed for check query: " . mysqli_error($conn));
        $_SESSION['error'] = "Failed to verify appointment: " . mysqli_error($conn);
        header("Location: /project_hospital/cancelapp.php");
        exit();
    }
    mysqli_stmt_bind_param($checkStmt, "ii", $del_id, $userId);
    if (!mysqli_stmt_execute($checkStmt)) {
        error_log("Execute failed for check query: " . mysqli_error($conn));
        $_SESSION['error'] = "Failed to verify appointment: " . mysqli_error($conn);
        mysqli_stmt_close($checkStmt);
        header("Location: /project_hospital/cancelapp.php");
        exit();
    }
    $checkResult = mysqli_stmt_get_result($checkStmt);
    $checkRow = mysqli_fetch_assoc($checkResult);
    mysqli_stmt_close($checkStmt);

    if ($checkRow) {
        $status = strtoupper(trim($checkRow['appointment_status'])); // Normalize status
        if ($status === 'ARRIVED' || $status === 'VISITED') {
            $_SESSION['error'] = "Cannot delete appointment with status '$status'.";
        } else {
            $deleteQuery = "DELETE FROM appointments WHERE appointment_id = ? AND user_id = ?";
            $deleteStmt = mysqli_prepare($conn, $deleteQuery);
            if (!$deleteStmt) {
                error_log("Prepare failed for delete query: " . mysqli_error($conn));
                $_SESSION['error'] = "Failed to prepare delete query: " . mysqli_error($conn);
                header("Location: /project_hospital/cancelapp.php");
                exit();
            }
            mysqli_stmt_bind_param($deleteStmt, "ii", $del_id, $userId);
            $deleteResult = mysqli_stmt_execute($deleteStmt);

            if ($deleteResult) {
                $_SESSION['success'] = "Appointment deleted successfully.";
                error_log("Successfully deleted appointment ID: $del_id for user ID: $userId");
            } else {
                error_log("Delete failed: " . mysqli_error($conn));
                $_SESSION['error'] = "Failed to delete appointment: " . mysqli_error($conn);
            }
            mysqli_stmt_close($deleteStmt);
        }
    } else {
        error_log("No appointment found for ID: $del_id, user ID: $userId");
        $_SESSION['error'] = "Appointment not found or you do not have permission to delete it.";
    }
    header("Location: /project_hospital/cancelapp.php");
    exit();
}

// Fetch appointments with doctor names
$sqlAppointments = "SELECT a.*, d.doctor_name 
                   FROM appointments a 
                   LEFT JOIN doctor d ON a.doctor_id = d.doctor_id 
                   WHERE a.user_id = ? 
                   ORDER BY a.appointment_date, a.appointment_time";
$stmtAppointments = mysqli_prepare($conn, $sqlAppointments);
if (!$stmtAppointments) {
    error_log("Prepare failed for appointments query: " . mysqli_error($conn));
    die("Prepare failed for appointments query: " . mysqli_error($conn));
}
mysqli_stmt_bind_param($stmtAppointments, "i", $userId);
mysqli_stmt_execute($stmtAppointments);
$resultAppointments = mysqli_stmt_get_result($stmtAppointments);
if ($resultAppointments === false) {
    error_log("Appointments query failed: " . mysqli_error($conn));
    die("Appointments query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biradar Multispeciality Hospital - Cancel Appointments</title>
    <link rel="shortcut icon" href="images/medicine.png" type="image/x-icon">
    <style>
        table {
            margin: 0 auto;
            font-size: large;
            border: 1px solid black;
            width: 95%;
            border-collapse: collapse;
        }
        h2 {
            margin-left: 35px;
            color: #006600;
            display: inline;
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
        .red {
            background-color: red;
            border-radius: 4px;
            padding: 5px 15px;
            color: white;
            text-decoration: none;
        }
        .red a {
            color: white;
            text-decoration: none;
        }
        .message {
            margin-left: 35px;
            color: #006600;
        }
        .error {
            margin-left: 35px;
            color: red;
        }
    </style>
</head>
<body>
    <?php
    if (file_exists("topnav.php")) {
        require_once("topnav.php");
    } else {
        echo "<p class='error'>Error: topnav.php not found.</p>";
    }
    ?>
    <main>
        <h2>View Appointments</h2>
        <p>Welcome, User ID: <?php echo htmlspecialchars($userId); ?>, Name: <?php echo $userName; ?></p>

        <?php
        if (isset($_SESSION['success'])) {
            echo "<p class='message'>" . htmlspecialchars($_SESSION['success']) . "</p>";
            unset($_SESSION['success']);
        }
        if (isset($_SESSION['error'])) {
            echo "<p class='error'>" . htmlspecialchars($_SESSION['error']) . "</p>";
            unset($_SESSION['error']);
        }
        ?>

        <table>
            <thead>
                <tr>
                    <th>Appointment ID</th>
                    <th>Doctor Name</th>
                    <th>Patient Name</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Patient Number</th>
                    <th>Date of Birth</th>
                    <th>Patient Address</th>
                    <th>Note</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Token No.</th>
                    <th>Weight</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($resultAppointments) > 0) {
                    while ($rowAppointment = mysqli_fetch_assoc($resultAppointments)) {
                        $appointmentId = htmlspecialchars($rowAppointment['appointment_id']);
                        $doctorName = htmlspecialchars($rowAppointment['doctor_name'] ?? 'Unknown Doctor');
                        $patientName = htmlspecialchars($rowAppointment['patient_name']);
                        $patientAge = !empty($rowAppointment['patient_age']) ? htmlspecialchars($rowAppointment['patient_age']) : 'N/A';
                        $patientGender = !empty($rowAppointment['patient_gender']) ? htmlspecialchars($rowAppointment['patient_gender']) : 'N/A';
                        $patientNumber = htmlspecialchars($rowAppointment['patient_mobilenumber'] ?? 'N/A');
                        $dateOfBirth = !empty($rowAppointment['date_of_birth']) ? htmlspecialchars($rowAppointment['date_of_birth']) : 'N/A';
                        $patientAddress = !empty($rowAppointment['patient_address']) ? htmlspecialchars($rowAppointment['patient_address']) : 'N/A';
                        $note = !empty($rowAppointment['note']) ? htmlspecialchars($rowAppointment['note']) : 'N/A';
                        $appointmentDate = htmlspecialchars($rowAppointment['appointment_date']);
                        $appointmentTime = date("h:i A", strtotime($rowAppointment['appointment_time']));
                        $tokenNumber = isset($rowAppointment['token_number']) && $rowAppointment['token_number'] !== null ? htmlspecialchars($rowAppointment['token_number']) : 'Not Assigned';
                        $patientWeight = !empty($rowAppointment['patient_weight']) ? htmlspecialchars($rowAppointment['patient_weight']) : 'N/A';
                        $appointmentStatus = htmlspecialchars($rowAppointment['appointment_status']);
                ?>
                <tr>
                    <td><?php echo $appointmentId; ?></td>
                    <td><?php echo $doctorName; ?></td>
                    <td><?php echo $patientName; ?></td>
                    <td><?php echo $patientAge; ?></td>
                    <td><?php echo $patientGender; ?></td>
                    <td><?php echo $patientNumber; ?></td>
                    <td><?php echo $dateOfBirth; ?></td>
                    <td><?php echo $patientAddress; ?></td>
                    <td><?php echo $note; ?></td>
                    <td><?php echo $appointmentDate; ?></td>
                    <td><?php echo $appointmentTime; ?></td>
                    <td><?php echo $tokenNumber; ?></td>
                    <td><?php echo $patientWeight; ?></td>
                    <td>
                        <?php if (strtoupper($appointmentStatus) === 'ARRIVED') : ?>
                            <span>Arrived, cannot delete</span>
                        <?php elseif (strtoupper($appointmentStatus) === 'VISITED') : ?>
                            <span>Visited</span>
                        <?php else : ?>
                            <button class="red"><a href="/project_hospital/cancelapp.php?del=<?php echo $appointmentId; ?>" onclick="return confirm('Are you sure you want to delete this appointment?')">Delete</a></button>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='14'>No appointments found for User ID: $userId.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </main>
</body>
</html>
<?php
mysqli_free_result($resultAppointments);
mysqli_stmt_close($stmtAppointments);
mysqli_close($conn);
?>