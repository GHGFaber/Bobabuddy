<?php
// Name:    Angel Cazares
// course:  CMPS 3420
// @source: createaccount.php

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
                unset($_POST['SUBMIT']);
                
                $db = get_connection();
                
                $usr = $_POST['username'];
                $pwd = $_POST['password'];
                $ref = $_POST['referral'];
                // $name1 = $_POST['first_name'];
                // $name2 = $_POST['last_name'];
                // $phone = $_POST['phone_number'];
		        $id    = $_POST['EmployeeID'];

                if (strlen($usr) == 0 || strlen($pwd) == 0) {
                        echo "Cannot leave these fields empty!";
                        header("Location: createaccount.php");
		}

		if ($usr == $pwd) {
			echo "<h3 style=\"color: red; text-align: center;\">PASSWORD AND USERNAME CANNOT BE THE SAME!</h3>";
		}
		else {	
			if (strlen($id) == 0) {
				$id = NULL;
            if (strlen($ref) == 0)
                $ref = NULL;
			}

			$hash = password_hash($pwd, PASSWORD_DEFAULT);
            $def = NULL;
            
            if ($ref == 'bobabuddyF22') {
                $def = htmlspecialchars("Y");
            } else {
                $def = htmlspecialchars("N");
            }

            
			$query = $db->prepare("INSERT INTO accounts VALUES (?, ?, ?, ?, ?)");
			$query->bind_param("ssiss", $usr, $hash, $id, $def, $ref);
		
			if (!$query->execute()) {
				echo mysqli_error($db);
			} else {
				header("Location: signin.php");
			}

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
        <form action="createaccount.php" class="login-form" method="POST">
            <h1>CREATE NEW ACCOUNT</h1>
    
            <label for="User-Name">USERNAME</label>
            <input type="text" name="username" id="username" placeholder="Enter a username" required>
            
            <label for="text">PASSWORD</label>
            <input type="password" name="password"  id="password" placeholder="Enter Password" required>
    
            <!-- <label for="First-Name">FIRST NAME</label>
            <input type="text" name="first_name" id="Fname" placeholder="Enter First Name" required>
    
            <label for="Last-Name">LAST NAME</label>
            <input type="text" name="last_name" id="Lname" placeholder="Enter Last Name" required>
    
            <label for="Phone-Number">PHONE NUMBER</label>
            <input type="number" name="phone_number" id="phonenumber" placeholder="##########" required> -->
           
	        <label for="Employee-status">ENTER EMPLOYEE ID # (EMPLOYEES ONLY)</label>
            <input type="number" name="EmployeeID" placeholder="00000000">

            <label for="Referral">ENTER REFERRAL</label>
            <input type="text" name="referral" placeholder="referral"> 
	    
	    <input type="submit" name="SUBMIT" class="submit-btn" value="CREATE ACCOUNT">


        </form>
    </div>
</body>
</html>
