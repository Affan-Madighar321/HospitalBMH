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
			margin-left:15%;
			font-size: large;
			border: 1px solid black;
			width:80%;
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
        </style>
</head>
<body>
<?php
    include 'sidebar.php';
    ?>
                    <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Mobile No</th>
                            <th>Feedback</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
        <main>
        <h1>Feedback</h1>
        <?php 
                        require_once('../inc/connection.php');
                        
                        if(isset($_GET['del'])) {
                            $del_id = $_GET['del'];
                            $delete = "DELETE FROM feedback WHERE feedback_id='$del_id'";
                            $run_delete = mysqli_query($conn, $delete);
                        
                            if($run_delete === true) {
                                echo "Record has been deleted";
                            } else {
                                echo "Failed to delete the record, please try again";
                            }
                        }


                        $select_feedback = "SELECT * FROM feedback";
                        $run_feedback = mysqli_query($conn,$select_feedback);

                        while ($row_feedback = mysqli_fetch_assoc($run_feedback)){

                         $feedback_id = $row_feedback['feedback_id'];
                         $feedback_name = $row_feedback['feedback_name'];
                         $feedback_mobilenumber = $row_feedback['feedback_mobilenumber'];
                         $feedback = $row_feedback['feedback'];

                        ?>
                    <tr>
                        <td><?php echo $feedback_id;?></td>
                        <td><?php echo $feedback_name;?></td>
                        <td><?php echo $feedback_mobilenumber;?></td>
                        <td><?php echo $feedback;?></td>
                        <td><a class='red' href='?del=<?php echo $feedback_id; ?>' onclick='return confirm("Are you sure you want to delete this feedback?")'>delete</a></td>
                        <?php }?>
    </main>
</body>
</html>