<?php
    require_once('inc/connection.php');
    session_start();
        echo  "<script>window.open('index.php','_self');</script>";

        session_destroy();
