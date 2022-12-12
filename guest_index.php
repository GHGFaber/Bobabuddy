
<?php
// Name:    Angel Cazares
// course:  CMPS 3420
// @source: signin.php


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

$db = get_connection();	
$prod = NULL;

$query = $db->prepare("create table temp1 as SELECT * FROM Item a INNER JOIN Drinklist b ON a.DID = b.drinkID");
$query->execute();
$result = $query->get_result();
// $img = $result->fetch_all(MYSQLI_ASSOC);

$query2 = $db->prepare("create table temp2 as select drinkname, DID, SUM(quantity) from temp1 natural join Drinklist group by DID order by SUM(quantity) desc limit 5");
$query2->execute();
$result2 = $query2->get_result();

$query3 =$db->prepare("drop table temp1");
$query3->execute();
$result3 = $query3->get_result();

$query4 = $db->prepare("select * from temp2 c INNER JOIN images d ON c.DID = d.drinkid");
$query4->execute();
$result4 = $query4->get_result();


$query = $db->prepare("SELECT * FROM Drinklist");
$query->execute();

$result = $query->get_result();
$rows = $result->fetch_all();


?>

<form align="right" name="form1" method="post" action="signin.php">
  <label class="signinLblPos">
  <input name="submit2" type="submit" id="submit2" value="Sign In">
  </label>
</form>

<?php
echo '<div style=font-size:100;text-align:center;top:100px;><u>BOBA BUDDY</u></div>';
echo '<h1 style=text-align:center;>Top 5 Drinks</h1>';
function displayImageFromDatabase(){
    //use global keyword to declare conn inside a function
    $db = get_connection();	

    $sqlselectimageFromDb = $db->prepare("SELECT `img_dir`, `drinkname` from `temp2` c INNER JOIN `images` d ON c.DID = d.drinkid");
    $sqlselectimageFromDb->execute();
    $result = $sqlselectimageFromDb->get_result();
    // foreach ($result) {
    //     echo '<div class="column1"> <img src="data:image/jpg;base64,' .$result["img_dir"]. '"</>';
    // }
    $top = [];
    foreach($result as $key => $value) {
            
            $top['image'][$key] = '<img src="data:image/jpg;base64,' .$value["img_dir"]. '"</>';
            $topname['name'][$key] = $value["drinkname"];
        
        // echo '<p>' .$value["drinkname"]. '</>';
        
        // echo '<div class="column"> <img src="data:image/jpg;base64,' .$value["img_dir"]. '"</>';
    }
    // while ($row = $result->fetch_all(MYSQLI_ASSOC)) {
    //     echo '<img src="data:image/jpg;base64, '.$row["img_dir"].'"/>'; //this it to get top 10 or 5. use this echo
    // }
?>

<style>
.center {
display: block;
margin-left: auto;
margin-right: auto;
width: 18%;
padding: 20;

}
{
box-sizing: border-box;
}
/* Set additional styling options for the columns */
.column {

padding: 0 4px;
}
/* Set width length for the left, right and middle columns */
.left {
vertical-align:center;
margin-left: 20;
margin-right: 20;
width: 10%;
}


.right {
vertical-align:center;
margin-left: 20;
margin-right: 20;
width: 10%;
}

.row:after {
content: "";
clear: both;
}
.text {
text-align:center;
font-size: 20;
margin-left:auto;
margin-right:auto;
}

.text2 {
text-align:auto;
font-size: 15;
}

.gfg {
margin: 3%;
position: relative;
}

.first-txt {
position: absolute;
top: 50px;
left: 50px;
}

.centered {
  position: relative;
  text-align:center;
  font-size:15;
  left: 50%;
  transform: translate(-49%, -48%);
}
</style>
<?php

    echo '<div class="text">1). '.$topname['name'][0];
    echo '<img class="center" ' .$top['image'][0]; // stored array of all top 5

    echo '<div class = "text2"> 2). '.$topname['name'][1]. '</div>';
    echo '<img class="column left" ' .$top['image'][1];
    echo '<div class = "text2"> 3). ' .$topname['name'][2]. '</div>';
    echo '<img class="column right" '.$top['image'][2];
    echo '<div class = "text2"> 4). ' .$topname['name'][3]. '</div>';
    echo '<img class="column left"' .$top['image'][3];
    echo '<div class = "text2"> 5). ' .$topname['name'][4]. '</div>';
    echo '<img class="column right" ' .$top['image'][4];
}
displayImageFromDatabase();



$query5 = $db->prepare("drop table temp2");
$query5->execute();
$result5 = $query5->get_result();
// foreach($img as $value) {
//     echo $value['img_dir']. "<h1>";
//     echo '<img src="data:image/jpg;base64, '.$row['img_dir'].'"/>'
// }
// mysqli_stmt_bind_result($validation, $res_user, $res_password, $perms);	

// if ($validation->fetch() && password_verify($pwd, $res_password)) {
//     if ($perms != 'N') {
//         header("Location: employee_index.php");
//     } else {
//         header("Location: https://artemis.cs.csub.edu/~acazares/guest_index.php");	
//     }
// } 
    
//     //calling the function to display image
    
    
//     //Finnaly close connection
//     if (mysqli_close($conn)) {
//     echo "<br />Connection Closed.......";
//     }
    
// while ($row = mysqli_fetch_assoc($dataFromDb)) {
//     echo '<h2><img src="data:image/jpg;base64, '.$row['img_dir'].'"/></h2>'; //this it to get top 10 or 5. use this echo
//     }

// select DID, quantity, count(*) as count
// from Item
// group by DID 
// order by count desc
// limit 5;



// if (isset($_POST['SUBMIT'])) {
// 	//header('Content-type: application/json');
// 	unset($_POST['SUBMIT']);
	
// 	$db = get_connection();	

// 	$usr = $_POST['USERNAME'];
// 	$pwd = $_POST['PASSWORD'];
//     $perms = NULL;

// 	if (strlen($usr) == 0 || strlen($pwd) == 0) {
// 		echo "Fields cannot be empty!";
// 		//header("Location: form.php");
// 		die();
// 	}

// 	$validation = $db->prepare("SELECT `username`, `password`, `Permissions` FROM `accounts` WHERE `username` = ?");
// 	$validation->bind_param('s', $usr);
// 	$validation->execute();
	
// 	mysqli_stmt_bind_result($validation, $res_user, $res_password, $perms);	

// 	if ($validation->fetch() && password_verify($pwd, $res_password)) {
// 		if ($perms != 'N') {
// 			header("Location: employee_index.php");
// 		} else {
// 			header("Location: https://artemis.cs.csub.edu/~acazares/guest_index.php");	
// 		}
// 	} 
// 	else {
// 		echo "<h3 style=\"text-align:center;color:#ff0000;\">Incorrect Username or Password!</h3>";
// 	}
// }

?>

<!DOCTYPE html>
<html>
<head>
<title>BobaBuddy</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> -->
<style>
/* body {font-family: "Times New Roman", Georgia, Serif;}
h1, h2, h3, h4, h5, h6 {
  font-family: "Playfair Display";
  letter-spacing: 5px;
}
.row {
  display: flex;
  flex-wrap: wrap;
  padding: 0 4px;
} */

/* Create two equal columns that sits next to each other */
/* .column {
  flex: 50%;
  padding: 0 4px;
}

.column img {
  margin-top: 8px;
  vertical-align: middle;
} */

<li><a href="dropdown.php">Order Now</a></li></style>
</head>


</html>