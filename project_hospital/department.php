<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Departments</title>
    <link rel="shortcut icon" href="images/medicine.png" type="image/x-icon">
    <style>
        main {
            margin-top: 5%;
        }

        h1 {
            margin-left: 30px;
        }

        .department-container {
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

        .department-name {
            margin-top: 10px;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            color: #333;
        }
    </style>
</head>
<body>
    <?php
    require_once('inc/header.php');
    ?>

    <main>
        <h1>Departments</h1>
        <div class="department-container">
            <?php
            require_once('inc/connection.php');
            $select_department = "SELECT * FROM department";
            $run_department = mysqli_query($conn, $select_department);

            while ($row_department = mysqli_fetch_assoc($run_department)) {
                $department_id = $row_department['department_id'];
                $department_logo = $row_department['department_logo'];
                $department_name = $row_department['department_name'];
            ?>
            <a href="doctor.php?department_id=<?php echo $department_id; ?>" class="box">
                <div class="content">
                    <div class="img">
                        <img src="admin/upload/<?php echo $department_logo; ?>" alt="<?php echo $department_name; ?> Logo">
                    </div>
                    <h3 class="department-name"><?php echo $department_name; ?></h3>
                </div>
            </a>
            <?php } ?>
        </div>
    </main>
</body>
</html>
