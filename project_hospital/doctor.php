<?php
require_once('inc/connection.php');


if (isset($_GET['department_id'])) {
    $department_id = $_GET['department_id'];

    
    $select_department = "SELECT * FROM department WHERE department_id = $department_id";
    $run_department = mysqli_query($conn, $select_department);
    $department = mysqli_fetch_assoc($run_department);

    
    $select_doctors = "SELECT * FROM doctor WHERE department_id = $department_id";
    $run_doctors = mysqli_query($conn, $select_doctors);

    
    $num_doctors = mysqli_num_rows($run_doctors);
} else {
    
    echo "Department not specified.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biradar Multispeciality Hospital - Doctors in <?php echo $department['department_name']; ?></title>
    <link rel="shortcut icon" href="images/medicine.png" type="image/x-icon">
    <style>
        main {
            margin-top: 5%;
        }

        h1 {
            margin-left: 30px;
        }

        .doctor-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            padding: 20px;
        }

        .box {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            flex: 0 1 calc(25% - 20px);
            overflow: hidden;
            text-decoration: none;
            transition: transform 0.3s;
        }

        .box:hover {
            transform: scale(1.05);
        }

        .content {
            padding: 20px;
        }

        .img img {
            max-width: 100px;
            max-height: 100px;
            display: block;
            margin: 0 auto;
        }

        .doctor-name {
            margin-top: 10px;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            color: #333;
        }
    </style>
</head>
<body>
    <?php require_once('inc/header.php'); ?>

    <main>
        <h1>Doctors in <?php echo $department['department_name']; ?> Department</h1>

        <?php
        if ($num_doctors > 0) {
        
            echo '<div class="doctor-container">';
            while ($row_doctor = mysqli_fetch_assoc($run_doctors)) {
                $doctor_name = $row_doctor['doctor_name'];
                $doctor_image = $row_doctor['doctor_image'];
                $doctor_degree = $row_doctor['doctor_degree'];
        ?>
            <a href="#" class="box">
                <div class="content">
                    <div class="img">
                        <img src="admin/upload/<?php echo $doctor_image; ?>" alt="<?php echo $doctor_name; ?> Photo">
                    </div>
                    <h3 class="doctor-name"><?php echo $doctor_name; ?></h3>
                    <h3 class="doctor-name"><?php echo $doctor_degree; ?></h3>
                </div>
            </a>
        <?php
            }
            echo '</div>';
        } else {
            
            echo '<p>No doctors available in this department.</p>';
        }
        ?>

    </main>
</body>
</html>
