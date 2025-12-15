

<style>
html, body {
    font-family: sans-serif;
background-image: linear-gradient( 109.6deg,  rgba(254,253,205,1) 11.2%, rgba(163,230,255,1) 91.1% );
    margin: 0;
  padding: 0;
}

header {
  position:fixed;
  top:0;
  width:100%;
  display: flex;
  justify-content: space-between;
  align-items: center;

  background-color:#2196F3;


  padding: 10px;
  color: azure;
}

.left-side {
  display: flex;
  align-items: center;
}

.left-side img {
  width: 80px;
  margin-right: 10px;
}

.text-content {
    font-family:cursive;
  display: flex;
  flex-direction: column;
}

.text-content h1 {
  font-size: 28px;
  margin: 0;
  padding: 0;
  color:darkred;
}

.text-content p {
  font-size: 18px;
  margin:  0;
  padding: 0;
}


.right-side ul {
  list-style: none;
  margin: 0;
  padding: 0;
  margin-right: 20px;
}

.right-side li {
  display: inline-block;
  margin-left: 10px;
}

.right-side li:first-child {
  margin-left: 0;
}

.right-side a {
  color: #fff;
  text-decoration: none;
  font-weight: bold;
  padding: 12px;

}

.right-side a:hover {
    background-color:white;
    border-radius:10px;
    color:black;
    box-shadow: 0 8px 8px rgba(71, 58, 58, 0.5);

    

}
main{
  margin-top:8%;
}
<?php
	session_start();
?>

</style>
  <header>
    <div class="left-side">
      <img src="images/pulmonologyPNG.png" alt="Logo">
      <div class="text-content">
        <h1>Biradar</h1>
        <p>Multispeciality Hospital</p>
      </div>
    </div>
    <?php 

if(isset($_SESSION['ulogged_in']) && $_SESSION['ulogged_in']==true){?>
    <nav class="right-side">
        <ul >
        <li><a href='user_home.php'>Home</a></li>
        <li><a href='department.php'>Department</a></li>
        <li><a href='facility.php'>Facility</a></li>
        <li><a href='aboutus.php'>About us</a></li>
        <li><a href='feedback.php'>Feedback</a></li>
        <li><a href='bookapp.php'>Book Appointment</a></li>
        <li><a href='cancelapp.php'>My Appointments</a></li>
        <li><a href='logout.php'>Log out</a></li>
        </ul>
</nav>

<?php } else { ?>
  <nav class="right-side">
        <ul>
        <li><a href='index.php'>Home</a></li>
        <li><a href='department.php'>Department</a></li>
        <li><a href='facility.php'>Facility</a></li>
        <li><a href='aboutus.php'>About us</a></li>
        <li><a href='feedback.php'>Feedback</a></li>
        <li><a href='bookapp.php'>Book Appointment</a></li>
        <li><a href='login.php'>Log in</a></li>  
        </ul>
</nav> 
<?php } ?>
  </header>