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

  $stmt = $db->prepare("SELECT * FROM thread WHERE thread_id = ? AND username = ?");
  $stmt->execute( [$_GET['id'], $_SESSION['uname']] );
  $thread = $stmt->fetch();
  
  if (!$thread)
  { // If no data (no thread with that ID in the database)
    echo 'Invalid thread ID.';
    header('Location: list_threads.php');
    exit;
  }

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Edit Thread</title>
    <meta name="author" content="Greg Baatard" />
    <meta name="description" content="New thread form of forum scenario" />
    <link rel="stylesheet" type="text/css" href="forum_stylesheet.css" />
	  <script>
      function validateForm() {
        
        // Create a variable to refer to the form
        var form = document.edit_thread;
      
        // Tests if the title is empty
        if (form.title.value.trim() == '') {
          alert('Title not specified.');
          return false;
        }
      
        // Tests if the content is empty
        if (form.content.value.trim() == '') {
          alert('Content not specified.');
          return false;
        }
      
        // Tests if a forum has not been selected
        if (form.forum_id.value == '') {
          alert('Forum not selected.');
          return false;
        }
      }
    </script>
  </head>

  <body>
    <h3>Edit Thread</h3>
    <p><a href="list_threads.php">List</a> | <a href="search_threads.php">Search</a></p>
    <form name="edit_thread" method="post" action="edit_thread.php" onsubmit="return validateForm()">
      <input type="hidden" name="thread_id" value="<?php echo $_GET['id']; ?>"/>
      <p><strong>Title:</strong><br />
        <input type="text" name="title" style="width: 398px;" value=<?php echo '"'.nl2br(htmlentities($thread['title'])).'"';?>/>
      </p>

      <p><strong>Content:</strong><br />
        <textarea name="content" style="width: 400px; height: 150px"><?php echo nl2br(htmlentities($thread['content']));?></textarea>
      </p>

      <p><strong>Select Forum:</strong>
        <select name="forum_id" style="width: 295px;">
          <option value="" selected disabled>Select a Forum</option>
          <?php  
            // Select details of all forums
            $result = $db->query("SELECT * FROM forum ORDER BY forum_id");
      
            // Loop through each forum to generate an option of the drop-down list
            foreach($result as $row)
            {
              echo '<option value="'.$row['forum_id'].'">'.$row['forum_name'].'</option>';
            }
          ?>
        </select>
      </p>
	
      <p>
        <input type="submit" name="submit" value="Submit" />
      </p>
    </form>
  </body>
</html>