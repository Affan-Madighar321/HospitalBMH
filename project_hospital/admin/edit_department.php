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
          main{
            display: flex;
            padding: 5px;
            width: 80%;
        }
       
        .new{
            width: 360px;
        }

        .new h1{
            font-size: 35px;
            color: red;
        }
        .new form{
            padding: 10px 0 0 0;
            
        }
        form .nm{
            margin: 30px 0;
        }
                 
        .nm label{
            
            font-weight: bold;
        margin-bottom: 5px;
        display: block;
        }
        
        .btn {
        display: inline-block;
        padding: 10px 20px;
        background-color: blue;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 20px;
        
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

                      $select_department ="SELECT * FROM department WHERE department_id ='$edit_id'";
                      $run_department = mysqli_query($conn,$select_department);
                            $row_department = mysqli_fetch_array($run_department);

                            $dbdepartment_name = $row_department['department_name'];
                            $dbdepartment_id = $row_department['department_id'];
                            $dbdepartment_logo = $row_department['department_logo'];
                    }
                    ?>

                    <div class="new">
                            <form action="" method="post" enctype="multipart/form-data">
                            <h1>edit department</h1>

                                <div class="nm">
                                    <lable>name</lable>
                                    <input type="text" name="department_name" value="<?php echo $dbdepartment_name;?>" required>
                                </div>
                                        <div class="nm">
                                            <label>logo</label>
                                            <input type="file" name="department_logo">
                                        </div>
                                <div>
                                   <input type="submit" value="Edit Department"  name ="insert_btn" class="btn">
                                </div>
                            </form>
                            </div>
                            <?php
                            require_once('../inc/connection.php');

                            if(isset($_POST['insert_btn'])){
                                $department_name = $_POST['department_name'];
                                $department_logo_name = $_FILES['department_logo']['name'];
                                $department_logo_tmp_name = $_FILES['department_logo']['tmp_name'];

                                if(empty($department_logo_name)){
                                    $department_logo_name = $dbdepartment_logo;
                                }
                                

                                $update_department = "UPDATE department SET department_name='$department_name',department_logo='$department_logo_name' WHERE department_id='$edit_id'";

                                    $run_update = mysqli_query($conn,$update_department);

                                    if($run_update === true){
                                        echo "data has been updated";
                                        move_uploaded_file($department_logo_tmp_name,"upload/$department_logo_name");
                                        echo  "<script>window.open('departments.php','_self');</script>";
        
                                    }else{
                                        echo "failed , try again";

                                    }
                            }
                            ?>
                    </main>
</body>
</html>