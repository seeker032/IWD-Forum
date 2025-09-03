<?php
    require 'db_connect.php';

    if (!isset($_GET['username']))
  { // If there is no "id" URL data
    echo 'Invalid user ID.';
    header('Location: list_threads.php');
    exit;
  }

  $stmt = $db->prepare("SELECT u.username, COUNT(t.thread_id) AS count, u.real_name, u.dob FROM thread AS t 
                        RIGHT JOIN user AS u ON u.username = t.username 
                        WHERE u.username = ?");
  $stmt->execute( [$_GET['username']] );
  $user = $stmt->fetch();
 
  
  if (!$user)
  { // If no data (no username with that ID in the database)
    echo 'Invalid user ID.';
    header('Location: list_threads.php');
    exit;
  }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>View Profile</title>
        <link rel="stylesheet" type="text/css" href="forum_stylesheet.css" />
    </head>
    <body>
      <h3>Viewing Profile of "<?php
                              //displays username
                                echo nl2br(htmlentities($user['username']));
                              ?>"</h3>
      <a href="javascript:history.back()">Back</a><br><br>

      <?php 
      //displays user data

      echo '<b>Real Name:</b> '.$user['real_name'].'<br>';
      echo '<b>Born in:</b> '.date('o', strtotime($user['dob'])).'<br>';

      //determines if the user has posts or not
      if ($user['count'] >= 1) {
        
        echo '<b>Post Count:</b> '.$user['count'].'<br>';
      }

      else if ($user['count'] < 1) {

        echo '<b>Post Count:</b> '.$user['count'].'<br>';
      }
      ?>
    </body>
</html


