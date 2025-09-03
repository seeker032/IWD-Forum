<?php
    //End session and redirect to index/home page
    require 'db_connect.php';
    addLog('Logout', $_SESSION['uname'], NULL);
    session_start();
    session_destroy();
    header('Location: list_threads.php');
?>