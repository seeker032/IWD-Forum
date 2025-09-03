<?php

require 'db_connect.php';
// If the request includes form data...
if (isset($_POST['submit']))
{ // Validate and process the form

  // This array will be used to store validation error messages
  // When an error is detected, the relevant message is added to the array
  $errors = [];
  
  
  // The following "if" statements validate the form data
  // By using separate "if" statements, we always check all of the fields,
  // rather than stopping after finding a single error
   
  // Tests if the username field is less than 6 characters long or more than 20 characters long
  if (strlen($_POST['uname']) < 6 || strlen($_POST['uname']) > 20)
  {
    $errors[] = 'Username must be between 6 and 20 characters long.';
  }
  
  // Tests if the username contains invalid characters
  if (!ctype_alnum($_POST['uname']))
  {
    $errors[] = 'Username contains invalid characters.';
  }
  
  // Tests if the password field is less than 8 characters long
  if (strlen($_POST['pword']) < 8)
  {
    $errors[] = 'Password must be at least 8 characters long.';
  }
  
  // Tests if the password and password confirmation fields do not match
  if ($_POST['pword'] != $_POST['pword_conf'])
  {
    $errors[] = 'Password does not match confirmation.';
  }

  // Tests if the date of birth field is not a valid date
  if (strtotime($_POST['dob']) === false)
  {
    $errors[] = 'Invalid date of birth.';
  }
	
  // Tests if the date of birth is not at least 14 years ago
  if (strtotime($_POST['dob']) > strtotime('-14 years'))
  {
    $errors[] = 'You must be at least 14 to register.';
  }

  // Tests if the "I Agree..." checkbox is unchecked (and hence not available)
  if (!isset($_POST['agree'])) 
  {
    $errors[] = 'You must agree to the terms and conditions.';
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
  else
  { // Validation successful 

    $stmt = $db->prepare("INSERT INTO user (username, password, real_name, dob) VALUES (?, ?, ?, ?)");
    $result = $stmt->execute( [$_POST['uname'], password_hash($_POST['pword'], PASSWORD_DEFAULT), $_POST['rname'], $_POST['dob']] );

    if ($result) {
      //INSERT was successful

      echo '<p>Registration complete!</p>'; 
      echo '<p><a href="login.php">Log in</a></p>';
      addLog('Registration', NULL, 'username ' . $_POST['uname']);
    }
    
    else if ($stmt->errorCode() == '23000') {
        //username already exists
        echo '<p>Username of "'.$_POST['uname'].'" already exists. </p>';
        echo '<a href ="javascript: history.back()">Return to form. </a>';

    }
  }
}
else
{ // Show message if the form has not been submitted
  echo 'Please submit the <a href="register_form.php">form</a>.';
}
?>