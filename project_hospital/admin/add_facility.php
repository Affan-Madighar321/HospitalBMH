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
                        <div class="new">
                            <form action="" method="post"  enctype="multipart/form-data">
                            <h1>ADD FACILITY</h1>


                                <div class="nm">
                                    <label>Facility name</label>
                                    <input type="text"  name="facility_name"  required>
                                </div>
                                <div class="nm">
                                    <label>facility logo</label>
                                    <input type="file" name="facility_logo"   required>
                                <div >
                                    <input type="submit" value="Add" name="insert-btn"  class="btn">
                                </div>
                            </form>
    </div>
                            <?php 
                            require_once('../inc/connection.php');

                            if(isset($_POST['insert-btn'])){

                                $facility_name = $_POST['facility_name'];
                                $facility_logo_name = $_FILES['facility_logo']['name'];
                                $facility_logo_tmp_name = $_FILES['facility_logo']['tmp_name'];

                            $insert_facility = "INSERT INTO facility(facility_name,facility_logo) VALUES('$facility_name','$facility_logo_name')";

                            $run_facility = mysqli_query($conn,$insert_facility);

                            if($run_facility === true){
                                echo "data has been inserted";
                                move_uploaded_file($facility_logo_tmp_name,"upload/$facility_logo_name");
                                echo  "<script>window.open('facilitys.php','_self');</script>";

                            }else{
                                echo "failsed , try again";
                            }
                            }
                            ?>
                    


</main>
</body>
</html>