<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facility</title>
    <link rel="shortcut icon" href="images/medicine.png" type="image/x-icon">
    <style>
        main {
            margin-top: 5%;
        }

        h1 {
            margin-left: 30px;
        }

        .facility-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            padding: 20px;
        }

        .box {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin: 0 15px 15px 0;
            width: calc(33.33% - 15px);
            overflow: hidden;
            text-decoration: none;
            transition: transform 0.3s;
        }

        .content {
            padding: 20px;
        }

        .img img {
            max-width: 100%;
            max-height: 100%; 
            display: block;
            margin: 0 auto;
        }

        .facility-name {
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
        <h1>Facilities</h1>
        <div class="facility-container">
            <?php
            require_once('inc/connection.php');
            $select_facility = "SELECT * FROM facility";
            $run_facility = mysqli_query($conn, $select_facility);

            while ($row_facility = mysqli_fetch_assoc($run_facility)) {
                $facility_id = $row_facility['facility_id'];
                $facility_logo = $row_facility['facility_logo'];
                $facility_name = $row_facility['facility_name'];
            ?>
            <div class="box">
                <div class="content">
                    <div class="img">
                        <img src="admin/upload/<?php echo $facility_logo; ?>" alt="<?php echo $facility_name; ?> Logo">
                    </div>
                    <h3 class="facility-name"><?php echo $facility_name; ?></h3>
                </div>
            </div>
            <?php } ?>
        </div>
    </main>
</body>
</html>
