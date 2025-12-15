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

                      $select_facility ="SELECT * FROM facility WHERE facility_id ='$edit_id'";
                      $run_facility = mysqli_query($conn,$select_facility);
                            $row_facility = mysqli_fetch_array($run_facility);

                            $dbfacility_name = $row_facility['facility_name'];
                            $dbfacility_id = $row_facility['facility_id'];
                            $dbfacility_logo = $row_facility['facility_logo'];
                    }
                    ?>
                   <div class="new">
                            <form action="" method="post" enctype="multipart/form-data">
                            <h1>EDIT FACILITY</h1>
                                <div class="nm">
                                  <label>NAME</label>
                                    <input type="text" name="facility_name" value="<?php echo $dbfacility_name;?>" required>
                                </div>
                                        <div class="nm">
                                            <label>LOGO</label>
                                            <input type="file" name="facility_logo">
                                        </div>
                                <div>
                                   <input type="submit" value="Edit Facility"  name ="insert_btn" class="btn">
                                </div>
                            </form>
                            </div>
                            <?php
                            require_once('../inc/connection.php');

                            if(isset($_POST['insert_btn'])){
                                $facility_name = $_POST['facility_name'];
                                $facility_logo_name = $_FILES['facility_logo']['name'];
                                $facility_logo_tmp_name = $_FILES['facility_logo']['tmp_name'];

                                if(empty($facility_logo_name)){
                                    $facility_logo_name = $dbfacility_logo;
                                }
                                

                                $update_facility = "UPDATE facility SET facility_name='$facility_name',facility_logo='$facility_logo_name' WHERE facility_id='$edit_id'";

                                    $run_update = mysqli_query($conn,$update_facility);

                                    if($run_update === true){
                                        echo "data has been updated";
                                        move_uploaded_file($facility_logo_tmp_name,"upload/$facility_logo_name");
                                        echo  "<script>window.open('facilitys.php','_self');</script>";
        
                                    }else{
                                        echo "failed , try again";

                                    }
                            }
                            ?>
                    </main>
</body>
</html>