<?php
  require 'db_connect.php';

  if (!isset($_GET['id']) || !ctype_digit($_GET['id']))
  { // If there is no "id" URL data or it isn't a number
    echo 'Invalid thread ID.';
    header('Location: list_threads.php');
    exit;
  }

  if (!isset($_SESSION['level'])){

    $_SESSION['level'] = '';
  }

  // Select details of specified thread
  // Since the user could tamper with the URL data, a prepared statement is used
  $stmt = $db->prepare("SELECT * FROM thread 
                        AS t JOIN forum as f ON t.forum_id = f.forum_id
                        WHERE thread_id = ?");
  $stmt->execute( [$_GET['id']] );
  $thread = $stmt->fetch();
  
  if (!$thread)
  { // If no data (no thread with that ID in the database)
    echo 'Invalid thread ID.';
    header('Location: list_threads.php');
    exit;
  }

  if (isset($_SESSION['uname'])) { // Welcome user and show log out link

    echo '<p>Welcome, '.$_SESSION['uname'].' ('.$_SESSION['level'].').';
    echo '<br /><small><a href="logout.php">Log out</a></small></p>';
  }

  else { //show login link

    echo '<p>You are not logged in.';
    echo '<br /><small><a href="login.php">Log in</a></small></p>';
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <title><?php 
              echo nl2br(htmlentities($thread['title'])); //names the title of the webpage to the thread title
            ?>
    </title>
    <meta name="author" content="Greg Baatard" />
    <meta name="description" content="View thread page of forum scenario" />
    <link rel="stylesheet" type="text/css" href="forum_stylesheet.css" />
    <script>
      function validateForm() {
        
        // Create a variable to refer to the form
        var form = document.reply_form;
    
        // Tests if the reply textbox is empty
        if (form.reply_textarea.value.trim() == '') {
          alert('Content not specified.');
          return false;
        }
      
      }
    </script>
  </head>

  <body>
    <h3>View Thread</h3>
    <p><a href="list_threads.php">List</a> | <a href="search_threads.php">Search</a> 
    <?php if ($_SESSION['level'] == 'admin') {
      echo '| <a href="event_log.php">Event Log</a>';
    }
    ?>
    </p>
		<?php
      // Display the thread's details
      echo '<h4>'.nl2br(htmlentities($thread['title'])).'</h4>'; //nl2br and htmlentities doesn't allow code to be executed by a potential attacker
      echo '<p><small><em>Posted by <a href="view_profile.php?username='.$thread['username'].'">'.$thread['username'].'</a>';
      echo ' in <a href="list_threads.php?forum='.$thread['forum_id'].'">'.$thread['forum_name'].'</a>';
      echo ' on '.date('F j o\, g:ia', strtotime($thread['post_date'])).'</em></small>';

      if (isset($_SESSION['uname'])){ //if a user is logged in

        if ($_SESSION['uname'] == $thread['username']) { //Show edit link if logged in as author of thread

          echo '<br> <small>[<a href="edit_thread_form.php?id='.$thread['thread_id'].'">Edit</a>&#x2022';
        }
        
        if ($_SESSION['uname'] == $thread['username'] || $_SESSION['level'] == 'admin') {

          echo '<a onclick="return confirm(\'Are you sure you want to delete this thread?\')" href="delete_thread.php?id='.$thread['thread_id'].'">Delete]</a></small>';
        }
      }

      echo '</small></p>';

      echo '<p>'.nl2br(htmlentities($thread['content'])).'<br>___________________________________</p>'; //nl2br and htmlentities doesn't allow code to be executed by a potential attacker
      
      $stmt = $db->prepare("SELECT * FROM reply WHERE thread_id = ?");
      $stmt->execute([$_GET['id']]);

      // Fetch all of the results as an array
      $result_data = $stmt->fetchAll();
      $thread_count = $stmt->rowCount();
      
      // Display results or a "no threads" message as appropriate
      if (count($result_data) > 0) {      
        // Loop through results to display links to threads
        foreach($result_data as $row) {

          echo '<div><small>Reply by <a href="view_profile.php?username='.$row['username'].'">'.nl2br(htmlentities($row['username'])).'</a>';
          echo '<em> '.date('F j o\, g:ia', strtotime($row['post_date'])).'</em></small>';
          echo '<p>'.nl2br(htmlentities($row['content'])).'</p><br>';
        }
      }

      if (isset($_SESSION['uname'])){
        echo '<br><form name="reply_form" method="post" action="reply.php" onsubmit="return validateForm()">';
        echo '<textarea name="reply_textarea" style="width: 300px; height: 50px"></textarea>';
        echo '<input type="hidden" name="thread_id" value="'.$_GET['id'].'"/>';
        echo '<br><input type="submit" name="reply_button" value="Reply" />';
        echo '</form> </div>';
      }
    ?>

   


  </body>
</html>
