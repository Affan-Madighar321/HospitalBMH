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
        .green{
            background-color:azure;
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

    if(isset($_GET['del'])) {
        $del_id = $_GET['del'];
        $delete = "DELETE FROM availability WHERE availability_id='$del_id'";
        $run_delete = mysqli_query($conn, $delete);
    
        if($run_delete === true) {
            echo "Record has been deleted";
        } else {
            echo "Failed to delete the record, please try again";
        }
    }

    $sqlAvailability = "SELECT * FROM availability";
    $resultAvailability = mysqli_query($conn, $sqlAvailability);

    ?>

    <h1>Doctor Availability</h1><button class="add"><a href="add_availability.php">add availability</a></button><button class="add"><a href="delete_past_availability.php">delete old records</a></button>
    <table>
        <thead>
            <tr>
                <th>Doctor ID</th>
                <th>Doctor Name</th>
                <th>Date</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($resultAvailability)) {
                $doctorId = $row['doctor_id'];
                $sqlDoctor = "SELECT doctor_name FROM doctor WHERE doctor_id = $doctorId";
                $resultDoctor = mysqli_query($conn, $sqlDoctor);
                $doctorName = mysqli_fetch_assoc($resultDoctor)['doctor_name'];

                echo "<tr>";
                echo "<td>{$row['doctor_id']}</td>";
                echo "<td>{$doctorName}</td>";
                echo "<td>{$row['available_date']}</td>";
                echo "<td>" . date('h:i A', strtotime($row['start_time'])) . "</td>";
                echo "<td>" . date('h:i A', strtotime($row['end_time'])) . "</td>";
                echo "<td><a class='red' href='?del={$row['availability_id']}' onclick='return confirm(\"Are you sure you want to delete this record?\")'>delete</a></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    </main>
</body>
</html>