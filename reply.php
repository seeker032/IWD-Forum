<?php
    require 'db_connect.php';

    if (!isset($_SESSION['uname'])) {
        header('Location: login.php');
        exit;
    }

    if (isset($_POST['reply_button'])) { // Validate and process the form

        // This array will be used to store validation error messages
        // When an error is detected, the relevant message is added to the array
        $errors = [];
        
        // The following "if" statements validate the form data
        // By using separate "if" statements, we always check all of the fields,
        // rather than stopping after finding a single error
        
        // Tests if the reply_textarea field is empty or entirely whitespace
        if (trim($_POST['reply_textarea']) == '') {
            $errors[] = 'Content not specified.';
        }

        // If the error message array contains any items, it evaluates to True
        if ($errors) { // Display all error messages and link back to form
            foreach ($errors as $error)
            {
            echo '<p>'.$error.'</p>';
            }
        
            echo '<a href="javascript: window.history.back()">Return to form</a>';
        }
        else { 

            $stmt = $db->prepare("INSERT INTO reply (username, thread_id, content) VALUES (?,?,?)");
            $result = $stmt->execute([$_SESSION['uname'], $_POST['thread_id'], $_POST['reply_textarea']]);

            if ($result){

                addLog('Post Reply', $_SESSION['uname'], 'thread_id: ' . $_POST['thread_id']);
                echo '<script>alert("Reply posted!");window.location.href="view_thread.php?id='.$_POST['thread_id'].'"</script>';
               
                
            }
            else {

                echo '<p>Something went wrong.</p>';
              }
        }
    } else { // Show message if the form has not been submitted
        echo 'Please submit the <a href="view_thread.php">form</a>.';
    }