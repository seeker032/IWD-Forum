<?php
  require 'db_connect.php';

  if (!isset($_GET['id']) || !ctype_digit($_GET['id']))
  { // If there is no "id" URL data or it isn't a number
    echo 'Invalid thread ID.';
    header('Location: list_threads.php');
    exit;
  }

  if (!isset($_SESSION['uname'])) {
    header('Location: login.php');
    exit;
  }

  if (!isset($_SESSION['level'])){ //if session level doesn't exist, code is executed below to prevent an error message

    $_SESSION['level'] = 'none';
  }

  $stmt = $db->prepare("SELECT * FROM thread WHERE username = ?");
  $stmt->execute( [$_SESSION['uname']] );
  $check = $stmt->fetch();

  if ($_SESSION['uname'] == $check['username'] || $_SESSION['level'] == 'admin'){ //checks if the user is authorised to delete the time slot
    
    // Select details of specified thread
    // Since the user could tamper with the URL data, a prepared statement is used
    $stmt = $db->prepare("DELETE FROM thread WHERE thread_id = ?");
    $result = $stmt->execute( [$_GET['id']] );

    if ($result) {

      echo '<script>alert("Thread removed!");window.location.href="list_threads.php"</script>';
      addLog('Thread deletion', $_SESSION['uname'], 'thread_id: ' . $_GET['id']);
    }

    else {

      echo '<p>Something went wrong.</p>';
    }
  } else {
    //when there's an error with the query
    header('Location: list_threads.php');
  }

?>