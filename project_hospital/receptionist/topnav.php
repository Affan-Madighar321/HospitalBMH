    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        header{
            position:fixed;
  top:0;
  width:100%;
        }
        .head { 
            background-color: #1976D2;
            color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
        }
        .head h1 {
            margin: 0;
        }
        .navbar {
            text-align: center;
            background-color: #2196F3;
            padding: 15px 0;
        }
        .navbar ul {
            list-style: none;
            display: inline-block;
            margin: 0;
            padding: 0;
        }
        .navbar li {
            margin: 0 15px;
            display: inline;
        }
        .navbar a {
            color: #fff;
            text-decoration: none;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .navbar a:hover {
            background-color: #1565C0;
        }
        .logout {
            float: right;
            color: #fff;
            border: none;
            padding: 8px 15px;
            cursor: pointer;
            margin-right: 15px;
            background-color: #F5F5F5;
            border-radius: 10px;
            color: black;
            box-shadow: 0 4px 4px rgba(0, 0, 0, 0.1);
        }
        .logout:hover {
            background-color: white;
        }
        main{
            margin-top:9%;
        }
    </style>
    <header>
    <div class="head">
        <h1>Biradar Multispeciality Hospital</h1>
        <button class="logout"><a href="logout.php">logout</a></button>
    </div>

    <nav class="navbar">
        <ul>
            <li><a href="rec_home.php">Home</a></li>
            <li><a href="new_app.php">book appointment</a></li>
            <li><a href="cancel_appo.php">cancel appointment</a></li>
        </ul>
    </nav>
    </header>
