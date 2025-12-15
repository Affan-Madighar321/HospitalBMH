
  <style>
    body {
  margin: 0;
  padding: 0;
}

header {
  background: linear-gradient( to right ,#207bcf,#bfe9ff);
  color: #fff;
  padding: 10px 20px;
}

.top-nav {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.logo {
  font-size: 24px;
}

.login {
  cursor: pointer;
  padding: 8px 12px;
  border-radius: 5px;
  background-color: #111;
  color: #818181;
  font-size: 16px;
}

.login:hover {
  color: #f1f1f1;
  
}

.sidebar {
  background-color: #111;
  width: 150px;
  height: 100%;
  padding: 20px;
  position: fixed;
  top: 54px;
  left: 0;
}

 .sidebar ul {
  list-style-type: none;
  padding: 0;
}

.sidebar li {
  margin-bottom: 10px;
}

.sidebar a {
  color: #818181;
  text-decoration: none;
  font-size: 25px;
}

.sidebar a:hover {
  color: #f1f1f1;
}

main{
  margin-left: 190px;
 top:0;
}

  </style>
  <header>
    <nav class="top-nav">
      <div class="logo"><?php echo  "welcome $_SESSION[email]";?></div>
      <a href="logout.php" class="login">Logout</a>
    </nav>
  </header>

  <div class="sidebar">
    <ul>
      <li><a href="admin_home.php">Home</a></li>
      <li><a href="facilitys.php">Facility</a></li>
      <li><a href="departments.php">Departments</a></li>
      <li><a href="doctors.php">Doctors</a></li>
      <li><a href="availability.php">Availability</a></li>
      <li><a href="appointments.php">Appointments</a></li>
      <li><a href="feedbacks.php">Feedback</a></li>
      <li><a href="staff.php">Staff</a></li>
      
    </ul>
</div>