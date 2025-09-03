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
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Search Threads</title>
    <meta name="author" content="Greg Baatard" />
    <meta name="description" content="Search threads page of forum scenario" />
    <link rel="stylesheet" type="text/css" href="forum_stylesheet.css" />
  </head>

  <body>
    <h3>Search Threads</h3>
    <p><a href="list_threads.php">List</a> | 

    <?php
    if (isset($_SESSION['uname'])) { // Shows New Thread link if user is logged in

    echo '<a href="new_thread_form.php">New Thread</a>';
    }

    if ($_SESSION['level'] == 'admin') {
      echo '| <a href="event_log.php">Event Log</a>';
    }

    ?>
    </p>
    <form name="search_threads" method="get" action="search_threads.php" >
      <p>Search: <input type="text" name="search_term" placeholder="Enter search term..." autofocus /> <input type="submit" value="Submit" /></p>
    </form>
    
    <?php

      // Execute a query if there's a search term in the URL data
      if (isset($_GET['search_term']))
      {
        echo '<h4>Search results for "'.$_GET['search_term'].'"</h4>';
        
        // Put wildcard characters on each end of the search term
        $search_term = '%'.$_GET['search_term'].'%';
        
        $stmt = $db->prepare("SELECT thread_id, username, title, post_date, f.forum_id, forum_name 
                              FROM thread AS t JOIN forum as f ON t.forum_id = f.forum_id
                              WHERE title LIKE ? OR content LIKE ? ORDER BY post_date DESC");
        
        // Provide the same value for both placeholders to search the title and content columns
        $stmt->execute( [$search_term, $search_term] );
        
        // Fetch all of the results as an array
        $result_data = $stmt->fetchAll();
        $thread_count = $stmt->rowCount();
        
        // Display results or a "no results" message as appropriate
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
              }
              
              if ($_SESSION['uname'] == $row['username'] || $_SESSION['level'] == 'admin') {
  
                echo '<a onclick="return confirm(\'Are you sure you want to delete this thread?\')" href="delete_thread.php?id='.$row['thread_id'].'">Delete]</a></small>';
              }
            }
  
            echo '</small></p>';
          }

          //determines how many threads show up
          if ($thread_count > 1){

            echo '<br><br><small>Found '.$thread_count.' results.</small></p>';
          }
  
          else {
  
            echo '<br><br><small>Found '.$thread_count.' result.</small></p>';
          }
        }
        else
        {
          echo '<p>No results found.</p>';
        }
      }
    ?>
  </body>
</html>