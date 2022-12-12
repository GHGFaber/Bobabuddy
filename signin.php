<?php
// Name:    Angel Cazares
// course:  CMPS 3420
// @source: signin.php

require_once("config.php");
date_default_timezone_set('America/Los_Angeles');
error_reporting(E_ALL);
ini_set("log_errors", 1);
ini_set("display_errors", 1);

function get_connection() {
    static $connection;
    
    if (!isset($connection)) {
        $connection = mysqli_connect(
            'localhost', // the server address (don't change)
            'bobabuddy', // the MariaDB username
            'yddubabob3420F22', // the MariaDB username's password
            'bobabuddy' // the MariaDB database name
        ) or die(mysqli_connect_error());
    }
    if ($connection === false) {
        echo "Unable to connect to database<br/>";
        echo mysqli_connect_error();
    }
  
    return $connection;
}
?>
<?php
if (isset($_POST['SUBMIT'])) {
	//header('Content-type: application/json');
	unset($_POST['SUBMIT']);
	
	$db = get_connection();	

	$usr = $_POST['USERNAME'];
	$pwd = $_POST['PASSWORD'];
    $perms = NULL;

	if (strlen($usr) == 0 || strlen($pwd) == 0) {
		echo "Fields cannot be empty!";
		//header("Location: form.php");
		die();
	}

	$validation = $db->prepare("SELECT `username`, `password`, `Permissions` FROM `accounts` WHERE `username` = ?");
	$validation->bind_param('s', $usr);
	$validation->execute();
	
	mysqli_stmt_bind_result($validation, $res_user, $res_password, $perms);	

	if ($validation->fetch() && password_verify($pwd, $res_password)) {
		$_SESSION["logged_in"] = true;
		$_SESSION["USERNAME"] = $usr;
		if ($perms != 'N') {	
			header("Location: https://artemis.cs.csub.edu/~acazares/employee_index.php");
		} else {
			header("Location: https://artemis.cs.csub.edu/~acazares/guest_index.php");	
		}
	} 
	else {
		echo "<h3 style=\"text-align:center;color:#ff0000;\">Incorrect Username or Password!</h3>";
	}
}

?>

<html lang="en">
<head>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <script src="//code.jquery.com/jquery-2.2.0.min.js"></script>
    <script src="//code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
    <!-- <script type="text/javascript" src="{{url_for('static', filename='login.js')}}"></script> -->

    <style media="screen">
      *,
*:before,
*:after{
    padding: 0;
    box-sizing: border-box;
}
body{
    background-color: #080710;
}
.background{
    width: 430px;
    height: 520px;
    position: absolute;
    transform: translate(-50%,-50%);
    left: 50%;
    top: 50%;
}
form{
    width: 400px;
    background-color: rgba(255,255,255,0.13);
    position: absolute;
    transform: translate(-50%,-50%);
    top: 50%;
    left: 50%;
    border-radius: 10px;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255,255,255,0.1);
    box-shadow: 0 0 40px rgba(8,7,16,0.6);
    padding: 50px 35px;
}
form *{
    font-family: 'Poppins',sans-serif;
    color: #ffffff;
    letter-spacing: 0.5px;
    outline: none;
    border: none;
}
form h3{
    font-size: 32px;
    color: #ffffff;
    font-weight: 500;
    line-height: 42px;
    text-align: center;
}

label{
    display: block;
    margin-top: 30px;
    font-size: 16px;
    font-weight: 500;
}
input{
    display: block;
    height: 50px;
    width: 100%;
    background-color: rgba(255,255,255,0.07);
    border-radius: 3px;
    padding: 0 10px;
    margin-top: 8px;
    font-size: 14px;
    font-weight: 300;
}
::placeholder{
    color: #e5e5e5;
}
button{
    margin-top: 50px;
    width: 100%;
    background-color: #ffffff;
    color: #080710;
    padding: 15px 0;
    font-size: 18px;
    font-weight: 600;
    border-radius: 5px;
    cursor: pointer;
}
nav ul {
    list-style: none;
    width: 100%;
    border: 1px solid red;
    text-align: right;
}
</style>
</head>
    <body>
        <div class="div-container">
            <form class="login-form" action="signin.php" method="POST">
                <div>
                    <!-- <div class="img-container">
                        <img src="boba.png" alt="picture" class="pic">
                    </div> -->
		    
                    <div class="form-container">
                        USERNAME:
                        <input type="text" placeholder="Enter Username" name="USERNAME" required>
                        
                        PASSWORD:
                        <input type="password" placeholder="Enter Password" name="PASSWORD" required>

			<button type="submit" name="SUBMIT" class="login-btn">LOGIN</button>
                    </div>
                    <div class="create-container">
                        <a href="createaccount.php" id="create-link">Create Account</a>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>

