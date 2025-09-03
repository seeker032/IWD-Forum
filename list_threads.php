<?php
  
  require 'db_connect.php';

  if (isset($_SESSION['uname'])) { // Welcome user and show log out link

    echo '<p>Welcome, '.$_SESSION['uname'].' ('.$_SESSION['level'].').';
    echo '<br /><small><a href="logout.php">Log out</a></small></p>';
  }

  else { //show login link

    echo '<p>You are not logged in.';
    echo '<br /><small><a href="login.php">Log in</a></small></p>';
  }

  if (!isset($_SESSION['level'])){

    $_SESSION['level'] = '';
  }

?>
<!DOCTYPE html>
<html>
  <head>
    <title>List Threads</title>
    <meta name="author" content="Greg Baatard" />
    <meta name="description" content="List threads page of forum scenario" />
    <link rel="stylesheet" type="text/css" href="forum_stylesheet.css" />
  </head>

  <body>
    <h3>List Threads</h3>
    <p><a href="search_threads.php">Search</a> | 

    <?php
    if (isset($_SESSION['uname'])) { // Shows New Thread link if user is logged in

      echo '<a href="new_thread_form.php"> New Thread </a>';
    }

    if ($_SESSION['level'] == 'admin') {
      echo '| <a href="event_log.php">Event Log</a>';
    }

    ?>
    </p>
    <form name="list_threads" method="get" action="list_threads.php" >
      <p><input type="button" value="Show All Threads" onclick="window.location.href = 'list_threads.php'" /> or filter to
        <select name="forum_id">
          <option value="" selected disabled>Select a forum</option>
          
          <?php  
            // Select details of all forums
            $result = $db->query("SELECT * FROM forum ORDER BY forum_id");
      
            // Loop through each forum to generate an option of the drop-down list
            foreach($result as $row)
            {
              echo '<option value="'.$row['forum_id'].'">'.$row['forum_name'].'</option>';
        
              // If there is a forum_id in the URL data, assign the current forum's name to a variable to display later
              // (this simply saves us having to use a separate query to get the name of the selected forum)
              if (isset($_GET['forum_id']) && $_GET['forum_id'] == $row['forum_id'])
              {
                $current_forum_name = $row['forum_name'];
              }
            }
          ?>
        </select> <input type="submit" value="Filter" />
      </p>
    </form>
    
    <?php
      // Execute a query with or without a WHERE clause depending on whether there's a forum_id in the URL data
      if (isset($_GET['forum_id']))
      {
        echo '<h4>'.$current_forum_name.' Threads</h4>';
        
        $stmt = $db->prepare("SELECT thread_id, username, title, post_date, f.forum_id, forum_name 
                              FROM thread AS t JOIN forum as f ON t.forum_id = f.forum_id
                              WHERE t.forum_id = ? ORDER BY post_date DESC");

        $stmt->execute( [$_GET['forum_id']] );
      }
      else
      {
        echo '<h4>All Threads</h4>';
        
        $stmt = $db->prepare("SELECT thread_id, username, title, post_date, f.forum_id, forum_name 
                              FROM thread AS t JOIN forum as f ON t.forum_id = f.forum_id
                              ORDER BY post_date DESC");
                              
        $stmt->execute();
      }
      
      // Fetch all of the results as an array
      $result_data = $stmt->fetchAll();
      $thread_count = $stmt->rowCount();
      
      // Display results or a "no threads" message as appropriate
      if (count($result_data) > 0)
      {      
        // Loop through results to display links to threads
        foreach($result_data as $row)
        {
          echo '<p><a href="view_thread.php?id='.$row['thread_id'].'">'.$row['title'].'</a><br />';
          echo '<small>Posted by <a href="view_profile.php?username='.$row['username'].'">'.$row['username'].'</a>';
          echo ' in <a href="list_threads.php?forum='.$row['forum_id'].'">'.$row['forum_name'].'</a>';
          echo ' on '.date('F j o\, g:ia', strtotime($row['post_date'])).'</em></small>';


          if (isset($_SESSION['uname'])){ //if a user is logged in

            if ($_SESSION['uname'] == $row['username']) { //Show edit link if logged in as author of thread
 
              echo '<br> <small>[<a href="edit_thread_form.php?id='.$row['thread_id'].'">Edit</a>&#x2022';
              echo '<a onclick="return confirm(\'Are you sure you want to delete this thread?\')" href="delete_thread.php?id='.$row['thread_id'].'">Delete]</a></small>';
            }
            
            else if ($_SESSION['level'] == 'admin') {

              echo '<br><small><a onclick="return confirm(\'Are you sure you want to delete this thread?\')" href="delete_thread.php?id='.$row['thread_id'].'">[Delete]</a></small>';
            }
          }

          echo '</small></p>';
        }

        //determines how many threads show up

        if ($thread_count > 1){

          echo '<br><br><small>There are '.$thread_count.' threads.</small></p>';
        }

        else {

          echo '<br><br><small>There is only '.$thread_count.' thread.</small></p>';
        }
        
      }
      else
      {
        echo '<p><small>No threads posted.</small></p>';
      }
    ?>
  </body>
</html>