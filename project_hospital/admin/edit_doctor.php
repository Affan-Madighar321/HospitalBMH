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
   
    body {
    
        background-color: #f4f4f4;
        
    }

    main {
        width: 80%;
        margin: 50px auto;
        
        padding: 20px;
        
    }

    h1 {
        color: red;
        
        margin-bottom: 20px;
    }

    form {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
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
                    <?php
                    require_once('../inc/connection.php');
                    if(isset($_GET['edit'])){
                        $edit_id = $_GET['edit'];

                      $select_doctor ="SELECT * FROM doctor WHERE doctor_id ='$edit_id'";
                      $run_doctor = mysqli_query($conn,$select_doctor);
                            $row_doctor = mysqli_fetch_array($run_doctor);

                            $dbdoctor_name = $row_doctor['doctor_name'];
                            $dbdoctor_age =  $row_doctor['doctor_age'];
                            $dbdoctor_gender =  $row_doctor['doctor_gender'];
                            $dbdoctor_degree =  $row_doctor['doctor_degree'];
                            $dbdoctor_specialities =  $row_doctor['doctor_specialities'];
                            $dbdoctor_experience =  $row_doctor['doctor_experience'];
                            $dbdepartment_id = $row_doctor['department_id'];
                            $dbdoctor_image = $row_doctor['doctor_image'];
                    }
                    ?>
                    <h1>EDIT DOCTOR</h1>
                            <form action="" method="post" enctype="multipart/form-data">
                                <div>
                                    <lable>name</lable>
                                    <input type="text" name="doctor_name" value="<?php echo $dbdoctor_name;?>" required>
                                </div>
                                <div>
                                    <lable>age</lable>
                                    <input type="number" name="doctor_age" value="<?php echo $dbdoctor_age;?>" required>
                                </div>
                                <div >
			                        Gender
			                        <select name="doctor_gender" value="<?php echo $dbdoctor_gender;?>">
				                    <option>Male</option>
				                    <option>Female</option>
				                    <option>Other</option>
			                        </select>
			                    </div>
                                <div>
                                    <lable>degree</lable>
                                    <input type="text" name="doctor_degree" value="<?php echo $dbdoctor_degree;?>" required>
                                </div>
                                <div>
                                    <lable>specialization</lable>
                                    <input type="text" name="doctor_specialities" value="<?php echo $dbdoctor_specialities;?>" required>
                                </div>
                                <div>
                                    <lable>experience</lable>
                                    <input type="text" name="doctor_experience" value="<?php echo $dbdoctor_experience;?>" required>
                                </div>
                                        <div>
                                            <lable>department</lable>
                                            <select name="department_id" required>
                                                <option disabled>--select department--</option>
                                                <?php 
                                                require_once('../inc/connection.php');

                                                $select_department="Select * FROM department ";
                                                $run_department = mysqli_query($conn,$select_department);

                                                while($row_department = mysqli_fetch_array($run_department)){

                                                    $department_id = $row_department['department_id'];
                                                    $department_name = $row_department['department_name'];
                                                
                                                ?>
                                                <option <?php if($dbdepartment_id == $department_id){echo "selected";}?> value="<?php echo $department_id; ?>"><?php echo $department_name; ?></option>
                                                <?php } ?>

                                            </select>
                                        </div>
                                        <div>
                                            <label>image</label>
                                            <input type="file" name="doctor_image">
                                        </div>
                                <div>
                                   <input type="submit" value="Edit doctor"  name ="insert_btn" class="btn">
                                </div>
                            </form>
                            <?php
                            require_once('../inc/connection.php');

                            if(isset($_POST['insert_btn'])){
                                $doctor_name = $_POST['doctor_name'];
                                $doctor_age = $_POST['doctor_age'];
                                $doctor_gender = $_POST['doctor_gender'];
                                $doctor_degree = $_POST['doctor_degree'];
                                $doctor_specialities = $_POST['doctor_specialities'];
                                $doctor_experience = $_POST['doctor_experience'];
                                $edepartment_id = $_POST['department_id'];
                                $doctor_image_name = $_FILES['doctor_image']['name'];
                                $doctor_image_tmp_name = $_FILES['doctor_image']['tmp_name'];

                                if(empty($doctor_image_name)){
                                    $doctor_image_name = $dbdoctor_image;
                                }
                                

                                $update_doctor = "UPDATE doctor SET doctor_name='$doctor_name',doctor_age='$doctor_age',doctor_gender='$doctor_gender',doctor_degree='$doctor_degree',doctor_specialities='$doctor_specialities',doctor_experience='$doctor_experience',department_id='$edepartment_id',doctor_image='$doctor_image_name' WHERE doctor_id='$edit_id'";

                                    $run_update = mysqli_query($conn,$update_doctor);

                                    if($run_update === true){
                                        echo "data has been updated";
                                        move_uploaded_file($doctor_image_tmp_name,"upload/$doctor_image_name");
                                        echo  "<script>window.open('doctors.php','_self');</script>";
        
                                    }else{
                                        echo "failed , try again";

                                    }
                            }
                            ?>
                        </main>
</body>
</html>