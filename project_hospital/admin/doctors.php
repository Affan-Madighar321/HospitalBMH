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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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

<body>
    <?php
    include 'sidebar.php';
    ?>
    <main>
                    <h1>Doctor Details </h1><button class="add"><a href="add_doctor.php">add doctor</a></button>
        
                        <?php
                        require_once('../inc/connection.php');

                        if(isset($_GET['del'])){
                            $del_id=$_GET['del'];
                        $delete = "DELETE FROM doctor WHERE doctor_id='$del_id' ";
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
                                            <th>Age</th>
                                            <th>Sex</th>
                                            <th>Degree</th>
                                            <th>Specialization</th>
                                            <th>Experience</th>
                                            <th>Department</th>
                                            <th>Image</th>
                                            <th>Delete</th>
                                            <th>Edit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        require_once('../inc/connection.php');
                                        $select_doctor = "SELECT * FROM doctor";
                                        $run_doctor = mysqli_query($conn,$select_doctor);

                                        while ($row_doctor = mysqli_fetch_array($run_doctor)){

                                         $doctor_id = $row_doctor['doctor_id'];
                                         $doctor_age =  $row_doctor['doctor_age'];
                                         $doctor_gender =  $row_doctor['doctor_gender'];
                                         $doctor_degree =  $row_doctor['doctor_degree'];
                                         $doctor_specialities =  $row_doctor['doctor_specialities'];
                                         $doctor_experience =  $row_doctor['doctor_experience'];
                                         $department_id = $row_doctor['department_id'];
                                         $doctor_name = $row_doctor['doctor_name'];
                                         $doctor_image = $row_doctor['doctor_image'];

                                         $select_department = "SELECT * FROM department WHERE department_id='$department_id'";
                                         $run_department = mysqli_query($conn,$select_department);
                                                $row_department = mysqli_fetch_array($run_department);
                                                $department_name = $row_department['department_name'];
                                        ?>
                                       <tr>
                                        <td><?php echo $doctor_id;?></td>
                                        <td><?php echo $doctor_name;?></td>
                                        <td><?php echo $doctor_age;?></td>
                                        <td><?php echo $doctor_gender;?></td>
                                        <td><?php echo $doctor_degree;?></td>
                                        <td><?php echo $doctor_specialities;?></td>
                                        <td><?php echo $doctor_experience;?></td>
                                        <td><?php echo $department_name;?></td>
                                        <td><img src="upload/<?php echo $doctor_image;?>"height="50px"></td>
                                        <td ><button class="red"><a href="doctors.php?del=<?php echo $doctor_id ;?>" onclick="return confirm('Are you sure you want to delete this doctor?')" >delete</a></button></td>
                                        <td ><button class="green"><a href="edit_doctor.php?edit=<?php echo $doctor_id?>">edit</a></button></td>
                                       </tr>
                                       <?php }?>
                                    </tbody>
                                </table>
               

    
    </main>
</body>
</html>