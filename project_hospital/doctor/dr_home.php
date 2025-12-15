<?php
session_start();
if (isset($_SESSION['dlogged_in']) && $_SESSION['dlogged_in'] == true && isset($_SESSION['doctor_id'])) {
    $doctorId = $_SESSION['doctor_id'];
} else {
    header("Location: login.php");
    exit();
}

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Home</title>
    <link rel="icon" href="images/medicine.png" type="image/png">
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
    <?php include 'navbar.php'; ?>
    <main>
        <h1>Your Appointments</h1>
        
        <?php
        require_once('../inc/connection.php');
        
        // Verify database connection
        if (mysqli_connect_error()) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Debug: Display the doctor_id being used
        echo "<p>Logged-in Doctor ID: $doctorId</p>";

        // Fetch appointments for the logged-in doctor for the current date
        $currentDate = date("Y-m-d");
        $sqlAppointments = "SELECT * FROM appointments WHERE doctor_id = ? AND appointment_date = ? ORDER BY appointment_time";
        $stmt = mysqli_prepare($conn, $sqlAppointments);
        if ($stmt === false) {
            die("Prepare failed: " . mysqli_error($conn));
        }
        mysqli_stmt_bind_param($stmt, "is", $doctorId, $currentDate);
        mysqli_stmt_execute($stmt);
        $resultAppointments = mysqli_stmt_get_result($stmt);
        if ($resultAppointments === false) {
            die("Query failed: " . mysqli_error($conn));
        }
        ?>

        <table>
            <thead>
                <tr>
                    <th>Token Number</th>
                    <th>Appointment ID</th>
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
                if (mysqli_num_rows($resultAppointments) > 0) {
                    while ($row = mysqli_fetch_assoc($resultAppointments)) {
                        $appointmentTime12Hour = date("h:i A", strtotime($row['appointment_time']));
                        echo "<tr>";
                        echo "<td>" . (isset($row['token_number']) && $row['token_number'] !== NULL ? htmlspecialchars($row['token_number']) : 'Not Assigned') . "</td>";
                        echo "<td>" . htmlspecialchars($row['appointment_id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['patient_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['patient_age']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['patient_gender']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['date_of_birth']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['patient_address']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['note'] ?? '') . "</td>";
                        echo "<td>" . htmlspecialchars($row['appointment_date']) . "</td>";
                        echo "<td>" . htmlspecialchars($appointmentTime12Hour) . "</td>";
                        echo "<td>" . htmlspecialchars($row['patient_weight'] ?? '') . "</td>";
                        echo "<td>" . htmlspecialchars($row['appointment_status']) . "</td>";
                        echo "<td>";
                        if ($row['appointment_status'] === 'Arrived') {
                            echo "<form method='POST' action=''>";
                            echo "<input type='hidden' name='appointment_id' value='" . htmlspecialchars($row['appointment_id']) . "'>";
                            echo "<input type='submit' name='mark_visited' value='Mark Visited'>";
                            echo "</form>";
                        }
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='13'>No appointments found for today (Doctor ID: $doctorId).</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <?php
        // Free the result
        mysqli_free_result($resultAppointments);
        mysqli_stmt_close($stmt);

        // Handle form submission for marking appointment as Visited
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mark_visited'])) {
            $appointmentId = $_POST['appointment_id'];

            // Validate input
            if (!is_numeric($appointmentId)) {
                echo "<p>Invalid appointment ID.</p>";
                exit();
            }

            // Use prepared statement for update query
            $updateStatusQuery = "UPDATE appointments SET appointment_status = 'Visited' WHERE appointment_id = ? AND doctor_id = ?";
            $updateStmt = mysqli_prepare($conn, $updateStatusQuery);
            if ($updateStmt === false) {
                echo "<p>Prepare failed for update query: " . mysqli_error($conn) . "</p>";
                exit();
            }
            mysqli_stmt_bind_param($updateStmt, "ii", $appointmentId, $doctorId);
            $updateStatusResult = mysqli_stmt_execute($updateStmt);

            if ($updateStatusResult) {
                echo "<p>Appointment status updated to 'Visited'.</p>";
                echo "<meta http-equiv='refresh' content='2;url=doc_home.php'>";
            } else {
                echo "<p>Error updating appointment status: " . mysqli_error($conn) . "</p>";
            }
            mysqli_stmt_close($updateStmt);
        }

        // Close database connection
        mysqli_close($conn);
        ?>
    </main>
</body>
</html>