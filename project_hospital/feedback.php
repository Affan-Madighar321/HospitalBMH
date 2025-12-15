<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Feedback</title>
<link rel="shortcut icon" href="images/medicine.png" type="image/x-icon">
    <style>
        main{
            display: flex;
  align-items: center;
  justify-content: center;
  padding: 5px;
        }
       
        .container{
             
  background: #fff;
  width: 800px;
  padding: 25px 40px 10px 40px;
  box-shadow: 0px 0px 10px rgba(0,0,0,0.1);   
  border-radius: 5px;

        }

        .container h1{
            text-align: center;
            font-size: 35px;
            color: #115484;

        }
        .container form{
            padding: 30px 0 0 0;
        }
        form .id{
            position: relative;
            border-radius: 2px;
            margin: 30px 0;
        }
        .id input{
            width: 100%;
            padding: 0 5px;
            height: 40px;
            font-size: 18px;
            border: 2px solid black;
            border-radius:3px;
  
            background: none;
  
        }
       .id label{
            left: 5px;
            color: #272a2c;
            font-size: 16px;
            pointer-events: none;


        }
       textarea{
            width: 100%;
            padding: 0 5px;
            height: 35%;
            font-size: 20px;
            border: 2px soldi black;
            background: none;
  

        }
       .btn{

           width: 100%;
           height: 50px;
           border: 1px solid;
           background: #2691d9;
           border-radius: 25px;
           font-size: 18px;
           color: #e9f4fb;
           font-weight: 700;
           cursor: pointer;
           outline: none;
           margin-top: 5px;
           margin-bottom: 10px;
        } 
    </style>
</head>
<body>
<?php
	  require_once("inc/header.php");
	?>
    <main>
    <div class="container">
        <form method="POST">
            <h1>Give your Feedback</h1>
            <div class="id">
                <label>Username</label>
                <input type="text" name="feedback_name" required>
            
            </div>
            <div class="id">
              <label>Mobile Number</label>
                <input type="number" name="feedback_mobilenumber" required>
            </div>
            <div>
                 <label>Enter your opinions here...</label>
                    <textarea name="feedback" cols="10" rows="5" style="resize: none;" required></textarea>
            </div>


            <br>
            
            <input type="submit" value="Send" name="send_btn" class="btn">
            
        </form>
        <?php 
                            require_once('inc/connection.php');

                            if(isset($_POST['send_btn'])){

                                $feedback_name = $_POST['feedback_name'];
                                $feedback_mobilenumber = $_POST['feedback_mobilenumber'];
                                $feedback = $_POST['feedback'];

                            $insert_feedback = "INSERT INTO feedback(feedback_name,feedback_mobilenumber,feedback) VALUES('$feedback_name','$feedback_mobilenumber','$feedback')";

                            $run_feedback = mysqli_query($conn,$insert_feedback);

                            if($run_feedback === true){
                                echo "thanks for give feedback";

                            }else{
                                echo "please, try again";
                            }
                            }
                            ?>
    </div>
                        </main>
</body>
</html>