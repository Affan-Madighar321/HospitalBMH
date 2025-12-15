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
    <h1>Department Details </h1><button class="add"><a href="add_department.php">add department</a></button>
        
        <?php
        require_once('../inc/connection.php');

        if(isset($_GET['del'])){
            $del_id=$_GET['del'];
        $delete = "DELETE FROM department WHERE department_id='$del_id' ";
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
                        $select_department = "SELECT * FROM department";
                        $run_department = mysqli_query($conn,$select_department);

                        while ($row_department = mysqli_fetch_array($run_department)){

                         $department_id = $row_department['department_id'];
                         $department_name = $row_department['department_name'];
                         $department_logo = $row_department['department_logo'];

                        ?>
                       <tr>
                        <td><?php echo $department_id;?></td>
                        <td><?php echo $department_name;?></td>
                        <td><img src="upload/<?php echo $department_logo;?>"height="50px"></td>
                        <td ><button class="red"><a href="departments.php?del=<?php echo $department_id ;?>" onclick="return confirm('Are you sure you want to delete this department?')" >delete</a></button></td>
                        <td ><button class="green"><a href="edit_department.php?edit=<?php echo $department_id?> ">edit</a></button></td>
                       </tr>
                       <?php }?>
                    </tbody>
                </table>
    </main>
</body>
</html>