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
    main {
        width: 50%;
        
        
        padding: 20px;
        
    }

    h1 {
        color: red;
        
        margin-bottom: 20px;
    }

    form {
        display: grid;
        
        gap: 30px;
    }

    label {
        font-weight: bold;
        margin-bottom: 5px;
        display: block;
    }

    input[type="text"],
    input[type="number"],
    input[type="tel"],
    select,
    input[type="file"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    select {
        
        padding: 10px;
        
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .btn {
        display: inline-block;
        padding: 10px 20px;
        background-color: blue;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        
    }
    </style>
    
</head>
<body>
<?php
    include 'sidebar.php';
    ?>
    <main>
        <div class="new">
    <?php
    require_once('../inc/connection.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $doctorId = $_POST['doctor_id'];
        $availableDate = $_POST['available_date'];
        $startTime = $_POST['start_time'];
        $endTime = $_POST['end_time'];
        

        $sql = "INSERT INTO availability (doctor_id, available_date, start_time, end_time) VALUES ('$doctorId', '$availableDate', '$startTime', '$endTime')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo "Availability added successfully!";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
    ?>

    <h2>Add Doctor Availability</h2>
    <form method="POST" action="">
        <div class="id">
        <label for="doctor_id">Select Doctor:</label>
        <select id="doctor_id" name="doctor_id" required>
            <option value="">Select a doctor</option>
            <?php
            $sqlDoctors = "SELECT doctor_id, doctor_name FROM doctor";
            $resultDoctors = mysqli_query($conn, $sqlDoctors);
            while ($rowDoctor = mysqli_fetch_assoc($resultDoctors)) {
                echo "<option value=\"{$rowDoctor['doctor_id']}\">{$rowDoctor['doctor_name']}</option>";
            }
            ?>
        </select>
        </div>
        <br>
        <div class="id">
        <label for="available_date">Available Date:</label>
        <input type="date" id="available_date" name="available_date" required>
        </div>
        <br>
        <div class="id">
        <label for="start_time">Start Time:</label>
        <input type="time" id="start_time" name="start_time" required>
        </div>
        <br>
        <div class="id">
        <label for="end_time">End Time:</label>
        <input type="time" id="end_time" name="end_time" required>
        </div>
        <br>
        <div class="id">
        <input type="submit" value="Add Availability">
        </div>
    </form>
    </div>
    </main>
</body>
</html>