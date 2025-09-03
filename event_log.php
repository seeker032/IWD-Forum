<?php

require 'db_connect.php'; //requires database connection, allows calling of function "addLog" for event logging

//redirects user to login form if they're not logged in

if (!isset($_SESSION['uname'])) {
    header('Location: login.php');
    exit;
} else{

    echo '<p>Welcome, '.$_SESSION['uname'].' ('.$_SESSION['level'].').';
    echo '<br /><small><a href="logout.php">Log out</a></small></p>';
}
//redirects user to list_threads page if they're not an admin
if ($_SESSION['level'] != 'admin') {
    header('Location: list_threads.php');
    exit;
}

?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Event Logs</title>
    <link rel="stylesheet" type="text/css" href="forum_stylesheet.css" />
    <style>
      table {border-collapse: collapse;}
      td, th {border: 1px solid black; padding: 5px;}
    </style>
</head>
<body>
<h3>Event Log</h3>
    <p><a href="list_threads.php">List</a> | <a href="search_threads.php">Search</a> 

    <?php
    if (isset($_SESSION['uname'])) { // Shows New Thread link if user is logged in

      echo '| <a href="new_thread_form.php"> New Thread </a>';
    }
    ?>

<h3>Event Log:</h3>

<?php
$stmt = $db->prepare('select * from log order by log_date desc'); //select statement to fill the table with data
$stmt->execute();
$list = $stmt->fetchAll();
?>
<table>
    <tr>
        <th>Date</th>
        <th>Event Type</th>
        <th>IP Address</th>
        <th>Username</th>
        <th>Event Details</th>
    </tr>
    <?php if (!empty($list)) :?>
        <?php foreach ($list as $v):?> <!--loops through array until no data is left-->
            <tr>
                <td><?php echo $v['log_date'];?></td>
                <td><?php echo nl2br(htmlentities($v['event_type']));?></td>
                <td><?php echo nl2br(htmlentities($v['username']));?></td>
                <td><?php echo $v['ip_address'];?></td>
                <td><?php echo nl2br(htmlentities($v['event_details']));?></td>
            </tr>
        <?php endforeach;?>
    <?php else:?>
        <tr>
            <td colspan="4">No data!</td> 
        </tr>
    <?php endif;?>
</table>

</body>
</html>