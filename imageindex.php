<?php

//This code shows how to save image im mysql database using php, sql and html.
//The image is uploaded using php and sql.
//It's a web-based application that can be accessed by using a browser.
//This is for educational purposes only, Use it at your own risk.

//Connect to server
$servername = "localhost";
$username = "bobabuddy";
$password = "yddubabob3420F22";
$conn = mysqli_connect($servername, $username, $password);
if ($conn) {
echo "Connected to server successfully";
} else {
die( "Failed To Connect to server ". mysqli_connect_error() );
}

$selectalreadycreateddatabase = mysqli_select_db($conn, "bobabuddy"); 
if ($selectalreadycreateddatabase) {
echo "<br /> Exixting database selected successfully";
} 

$sqlcreatetable = "
CREATE TABLE IF NOT EXISTS `images` (
    `indexID` int(11) NOT NULL AUTO_INCREMENT,
    `drinkid` int(11) NOT NULL,
    `catid` int(11) NOT NULL,
    `name` varchar(255) NOT NULL,
    `img_dir` blob,
    PRIMARY KEY (`indexID`),
    KEY `Item_ibfk_1` (`drinkid`),
    KEY `Item_ibfk_2` (`catid`),
    CONSTRAINT `images_ibfk_1` FOREIGN KEY (`drinkid`) REFERENCES `Drinklist` (`drinkID`),
    CONSTRAINT `images_ibfk_2` FOREIGN KEY (`catid`) REFERENCES `Drinklist` (`categoryID`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if (mysqli_query($conn, $sqlcreatetable)) {
echo "<br />New table Created";
} else {
echo "<br /> Unable to create new table.";
}


if (isset($_POST['submit'])) {
if (getimagesize($_FILES['imagefile']['tmp_name']) == false) {
echo "<br />Please Select An Image.";
} else {

//declare variables
$image = $_FILES['imagefile']['tmp_name'];
$name = $_FILES['imagefile']['name'];
$image = base64_encode(file_get_contents(addslashes($image)));
if ($_FILES['imagefile']['name'] == 'strawberryTT.jpg') {
    $drinkid = 10;
    $catid = 2;
}
if ($_FILES['imagefile']['name'] == 'honeyTT.jpg') {
    $drinkid = 14;
    $catid = 2;
}
if ($_FILES['imagefile']['name'] == 'pineappleTT.jpg') {
    $drinkid = 11;
    $catid = 2;
}
if ($_FILES['imagefile']['name'] == 'mangoTT.jpg') {
    $drinkid = 8;
    $catid = 2;
}
if ($_FILES['imagefile']['name'] == 'peachTT.jpg') {
    $drinkid = 9;
    $catid = 2;
}
if ($_FILES['imagefile']['name'] == 'aloegrapefruitTT.jpg') {
    $drinkid = 12;
    $catid = 2;
}
if ($_FILES['imagefile']['name'] == 'passionfruitTT.jpg') {
    $drinkid = 13;
    $catid = 2;
}


$sqlInsertimageintodb = "INSERT INTO `images`(`indexID`, `drinkid` , `catid` , `name` ,`img_dir`) VALUES (NULL , '$drinkid', '$catid', '$name','$image')";

if (mysqli_query($conn, $sqlInsertimageintodb)) {
echo "<br />Image uploaded successfully.";
} else {
echo "<br />Image Failed to upload.";
}

}

} else {
# code...
}

//Retrieve image from database and display it on html webpage
function displayImageFromDatabase(){
//use global keyword to declare conn inside a function
global $conn;
$sqlselectimageFromDb = "SELECT * FROM `images`";
$dataFromDb = mysqli_query($conn, $sqlselectimageFromDb);
while ($row = mysqli_fetch_assoc($dataFromDb)) {
    echo '<img src="data:image/jpg;base64, '.$row['img_dir'].'"/>'; //this it to get top 10 or 5. use this echo
}


}
//calling the function to display image
displayImageFromDatabase();

//Finnaly close connection
if (mysqli_close($conn)) {
    echo "<br />Connection Closed.......";
}


?>
<!DOCTYPE html>
<html>
<head>
<title>How To upload BLOB Image To Mysql Database Using PHP,SQL And HTML.</title>
</head>
<body>
<form action="" method="post" enctype="multipart/form-data">
<input type="file" name="imagefile">
<br />
<input type="submit" name="submit" value="Upload">

</form>
</body>
</html>