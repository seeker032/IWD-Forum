<?php

require 'db_connect.php';

if (!isset($_SESSION['uname'])) {
  header('Location: login.php');
  exit;
}

// If the request includes form data...
if (isset($_POST['submit']))
{ // Validate and process the form

  // This array will be used to store validation error messages
  // When an error is detected, the relevant message is added to the array
  $errors = [];
  
  
  // The following "if" statements validate the form data
  // By using separate "if" statements, we always check all of the fields,
  // rather than stopping after finding a single error

  // Tests if the title field is empty or entirely whitespace
  if (trim($_POST['title']) == '')
  {
    $errors[] = 'Title not specified.';
  }
  
  // Tests if the content field is empty or entirely whitespace
  if (trim($_POST['content']) == '')
  {
    $errors[] = 'Content not specified.';
  }

  // Tests if a forum has not been selected (and hence not available)
  if (!isset($_POST['forum_id'])) 
  {
    $errors[] = 'Forum not selected.';
  }


  // If the error message array contains any items, it evaluates to True
  if ($errors)
  { // Display all error messages and link back to form
    foreach ($errors as $error)
    {
      echo '<p>'.$error.'</p>';
    }
   
    echo '<a href="javascript: window.history.back()">Return to form</a>';
  }
  else {
     
    $stmt = $db->prepare("UPDATE thread SET title = ?, content = ?, forum_id = ?
                          WHERE thread_id = ? AND username = ?");
    $result = $stmt->execute( [$_POST['title'], $_POST['content'], $_POST['forum_id'], 
                               $_POST['thread_id'], $_SESSION['uname']] );
    
    if ($result) {

      echo '<script>alert("Thread edited!");window.location.href="view_thread.php?id='.$_POST['thread_id'].'"</script>';
      
      addLog('Thread Edit', $_SESSION['uname'], 'thread_id: ' . $_POST['thread_id']);
    }

    else {

      echo '<p>Something went wrong.</p>';
    }

  } 
}
else
{ // Show message if the form has not been submitted
  echo 'Please submit the <a href="new_thread_form.php">form</a>.';
}
?>