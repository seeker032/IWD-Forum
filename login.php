<?php

require 'db_connect.php';

?>

<!DOCTYPE html>
<html>
  <head>
    <title>Login Form</title>
    <link rel="stylesheet" type="text/css" href="register_form_stylesheet.css" />
    <script>
      
      function validate_login_form() {
    
        var form1 = document.login_form;

        if (form1.uname.value == '') {
			
			alert('Please enter your username.');
			return false;
        }

        if (form1.pword.value.length <= 0) {
			
			alert('Please enter your password.');
			return false;
        }
		

      }
	  
    </script>
  </head>
	<body>
		<form name="volunteer_login_form" method="post" action="login.php" onsubmit="return validate_volunteer_form()">

			<fieldset><legend>Log In</legend>
			
				<label><span>Username:</span><input type="text" name="uname" autofocus /></label>
				<label><span>Password:</span><input type="password" name="pword" /></label>
				
				<input type="submit" name="login_button" value="Login" class="left" /> <br /> <br />
				<a href="register_form.php" class="right">Register</a>
			</fieldset>
			
		</form>

        <?php

        if (isset($_POST['login_button'])) {
            
            $errors = [];
            
            //PHP form validation starts here
            
            if (trim($_POST['uname']) == '') {
                
                $errors[] = 'Please enter your username. <br />';
                echo '<br />';
            }
            
            if (trim($_POST['pword']) == '') {
                
                $errors[] = 'Please enter your password. <br />';
            }
            
            //PHP form validation ends here
            
            if ($errors) {
                
                foreach ($errors as $error) {
                    
                    echo '<p>'.$error.'</p';
                }
                echo '<a href="javascript: window.history.back()">Return to form</a>';
            }
            
            else { // checks if the details match
                
                if (isset($_POST['login_button'])) {

                    $stmt = $db->prepare("SELECT * FROM user WHERE username=?");
                    $stmt->execute ([$_POST['uname']]);
                    $user = $stmt->fetch();

                    if ($user) {

                        if (password_verify($_POST['pword'], $user['password'])) {
    
                            $_SESSION['uname'] = $user['username'];
                            $_SESSION['level'] = $user['access_level'];
                            addLog('Successful Login', $_SESSION['uname'], NULL);
                            header('Location: list_threads.php');
                            exit;
                        
                        }  else {

                            addLog('Unsuccessful Login', NULL, 'username ' . $_POST['uname']);
                            echo 'Invalid credentials. Try again.';
                            
                        }
                    }

                } else {
                    echo 'Invalid credentials. Try again.';
                }
            }	
        }
	    ?>
	</body>
</html>