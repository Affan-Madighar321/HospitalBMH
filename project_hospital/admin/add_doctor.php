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
        width: 80%;
        
        
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
                    <div class="new">
                    <h1>ADD DOCTOR</h1>
                            <form action="" method="post" enctype="multipart/form-data">
                            
                            <div class="nm">
                                <label> Doctor name</label>
                                <input type="text" name="doctor_name" required>
                            </div>

                                <div class="nm">
                                    <label>Age</label>
                                    <input type="number" name="doctor_age" required>
                                </div>

                                <div class="nm">
			                        <label >Gender</label>
			                        <select name="doctor_gender">
				                    <option >Male</option>
				                    <option>Female</option>
				                    <option>Other</option>
			                        </select>
			                    </div>
                                <div class="nm">
                                    <label>Degree</label>
                                    <input type="text" name="doctor_degree" required>
                                </div>
                                <div class="nm">
                                    <label > Specialities</label>
                                    <input type="text" name="doctor_specialities" required>
                                </div>
                                <div class="nm">
                                    <label>Experience</label>
                                    <input type="text" name="doctor_experience" required>
                                </div>


                                        <div class="nm">
                                             <label>Department</label>
                                            <select name="department_id" required>
                                                <option disabled>--select department--</option>
                                                <?php 
                                                require_once('../inc/connection.php');

                                                $select_department="Select * FROM department";
                                                $run_department = mysqli_query($conn,$select_department);

                                                while($row_department = mysqli_fetch_array($run_department)){

                                                    $department_id = $row_department['department_id'];
                                                    $department_name = $row_department['department_name'];
                                                
                                                ?>
                                                <option value="<?php echo $department_id; ?>"><?php echo $department_name; ?></option>
                                                <?php } ?>

                                            </select>
                                        </div>
                                        <div class="nm">
                                            <label>Doctor image</label>
                                            <input type="file" name="doctor_image" class="form-control">
                                        </div>
                                <div>
                                <input type="submit" value="Add doctor"  name ="insert_btn" class="btn">
                                </div>
                            </form>
                            </div>
                            <?php
                            require_once('../inc/connection.php');

                            if(isset($_POST['insert_btn'])){
                                $doctor_name = $_POST['doctor_name'];
                                $doctor_age = $_POST['doctor_age'];
                                $doctor_gender = $_POST['doctor_gender'];
                                $doctor_degree = $_POST['doctor_degree'];
                                $doctor_specialities = $_POST['doctor_specialities'];
                                $doctor_experience = $_POST['doctor_experience'];
                                $department_id = $_POST['department_id'];
                                $doctor_image_name = $_FILES['doctor_image']['name'];
                                $doctor_image_tmp_name = $_FILES['doctor_image']['tmp_name'];

                                $insert_doctor = "INSERT INTO doctor(doctor_name,doctor_age,doctor_gender,doctor_degree,doctor_specialities,doctor_experience,department_id,doctor_image)
                                 VALUES('$doctor_name','$doctor_age','$doctor_gender','$doctor_degree','$doctor_specialities','$doctor_experience','$department_id','$doctor_image_name')";

                                    $run_doctor = mysqli_query($conn,$insert_doctor);

                                    if($run_doctor === true){
                                        echo "data has been inserted";
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