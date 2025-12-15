<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="shortcut icon" href="images/medicine.png" type="image/x-icon">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        main {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            height: 50vh;
            background-size: cover;
            background-position: center;
        }

        .box {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.3);
            padding: 2rem;
            margin: 2rem;
            flex: 1 0 300px;
            text-align: center;
        }

        h1, h2 {
            margin: 0 0 1rem 0;
        }

        p {
            margin: 1rem 0;
        }
    </style>
</head>
<body>
    <?php
    session_start();
    require_once('inc/header.php');
    ?>
    <main>
    <div class="box">
        <h1>About Us</h1>
        <p>Welcome to Birajdar Multispeciality Hospital, where patient care and satisfaction are our top priorities. Founded in 2013, we have been dedicated to providing high-quality healthcare services to our community.</p>
    </div>
    
    <div class="box">
        <h2>Our Mission</h2>
        <p>Our mission is to deliver compassionate, personalized, and comprehensive medical care to every patient who walks through our doors. We strive to ensure that each patient receives the best possible treatment and attention.</p>
    </div>
    
    <div class="box">
        <h2>Our Team</h2>
        <p>Our team of experienced medical professionals, specialists, and support staff work collaboratively to provide a range of medical services and treatments. We are committed to staying up-to-date with the latest medical advancements.</p>
    </div>
    </main>
    <?php
    require_once('inc/footer.php');
    ?>

</body>
</html>