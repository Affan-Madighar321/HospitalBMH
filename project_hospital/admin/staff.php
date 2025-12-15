<?php
session_start();
if(isset($_SESSION['alogged_in']) && $_SESSION['alogged_in'] == true){
    // Continue running
} else {
    header("location:../login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Birajdar Multispeciality Hospital</title>
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

    if(isset($_GET['del'])){
    $del_id=$_GET['del'];
    $delete = "DELETE FROM user WHERE user_id='$del_id' ";
    $run_delete = mysqli_query($conn,$delete);

    if($run_delete === true){
        echo"record has been deleted";
    }else{
        echo "Failed , try again";
    }
    }
    ?>
    <h1>Staff Details</h1><button class="add"><a href="add_staff.php">add staff</a></button>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Age</th>
                <th>Mobile Number</th>
                <th>Gender</th>
                <th>Type</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
        <?php 
            require_once('../inc/connection.php');

            $select_user = "SELECT * FROM user WHERE user_type IN ('doctor', 'receptionist')";
            $run_user = mysqli_query($conn, $select_user);

            while ($row_user = mysqli_fetch_array($run_user)){

            $user_id = $row_user['user_id'];
            $user_name = $row_user['user_name'];
            $user_age =  $row_user['user_age'];
            $user_mobilenumber = $row_user['user_mobilenumber'];
            $user_gender =  $row_user['user_gender'];
            $user_type = $row_user['user_type'];

            ?>
             <tr>
                <td><?php echo $user_id;?></td>
                <td><?php echo $user_name;?></td>
                <td><?php echo $user_age;?></td>
                <td><?php echo $user_mobilenumber;?></td>
                <td><?php echo $user_gender;?></td>
                <td><?php echo $user_type;?></td>
                <td ><button class="red"><a href="staff.php?del=<?php echo $user_id ;?>" onclick="return confirm('Are you sure you want to delete this user?')">delete</a></button></td>
            </tr>
            <?php }?>
</tbody>
    </table>
</main>
</body>
</html>
