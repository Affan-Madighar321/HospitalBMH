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
    <h1>Facility Details </h1><button class="add"><a href="add_facility.php">add facility</a></button>
        
        <?php
        require_once('../inc/connection.php');

        if(isset($_GET['del'])){
            $del_id=$_GET['del'];
        $delete = "DELETE FROM facility WHERE facility_id='$del_id' ";
        $run_delete = mysqli_query($conn,$delete);

        if($run_delete === true){
            echo"record has been deleted";
        }else{
            echo "Failed , try again";
        }
        }
        ?>
                <table >
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Logo</th>
                            <th>Delete</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        require_once('../inc/connection.php');
                        $select_facility = "SELECT * FROM facility";
                        $run_facility = mysqli_query($conn,$select_facility);

                        while ($row_facility = mysqli_fetch_array($run_facility)){

                         $facility_id = $row_facility['facility_id'];
                         $facility_name = $row_facility['facility_name'];
                         $facility_logo = $row_facility['facility_logo'];

                        ?>
                       <tr>
                        <td><?php echo $facility_id;?></td>
                        <td><?php echo $facility_name;?></td>
                        <td><img src="upload/<?php echo $facility_logo;?>"height="50px"></td>
                        <td ><button class="red"><a href="facilitys.php?del=<?php echo $facility_id ;?>" onclick="return confirm('Are you sure you want to delete this facility?')" >delete</a></button></td>
                        <td ><button class="green"><a href="edit_facility.php?edit=<?php echo $facility_id?>">edit</a></button></td>
                       </tr>
                       <?php }?>
                    </tbody>
                </table>
    </main>
</body>
</html>