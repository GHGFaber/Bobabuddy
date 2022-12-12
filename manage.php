<?php
require_once("config.php");
?>
<div id = "tester" style="width:600px;height:250px;"></div>

<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $PROJECT_NAME ?></title>
    <link rel="stylesheet" href="manage.css">
	<script src="plot.js"></script>
</head>
<body>
<h1><?= $PROJECT_NAME?></h1>

<?php

if (!empty($_SESSION["affected_rows"])) {
    echo "Deleted " . $_SESSION["affected_rows"] . " rows";
    unset($_SESSION["affected_rows"]);
}
?>

<h2> Here is your drink roster </h2>
<div1>
<?php
$db = get_mysqli_connection();
if(isset($_POST['Categories']))
{
    $varName = $_POST['Categories'];
}
else
{
    $varName = "";
}

if($varName == "")
{
    $query = $db->prepare("SELECT drinkname FROM Drinklist");
    $query->execute();

    $result = $query->get_result();
    while($row = $result->fetch_assoc()){
        echo $row['drinkname']. "</br>";
    }
}
else if($varName == "MilkTea"){
    $sql = "select drinkname from ViewMT";
    $result = $db->query($sql);
    while($row = $result->fetch_assoc()){
        echo $row['drinkname']. "</br>";
    }
}

else if($varName == "TropicalTea"){
        $sql = "select drinkname from ViewTT";
        $result = $db->query($sql);
        while($row = $result->fetch_assoc()){
            echo $row['drinkname']. "</br>";
        }
}
else if($varName == "Blended"){
    $sql = "select drinkname from ViewBlend";
    $result = $db->query($sql);
    while($row = $result->fetch_assoc()){
        echo $row['drinkname']. "</br>";
    }
}


?>

<div> Alternate View </br>
<form method = "post">
<label for="Categories">Choose a category:</label>
<select name="Categories">
  <option value=""> </option>
  <option value="MilkTea">MilkTea</option>
  <option value="TropicalTea">TropicalTea</option>
  <option value="Blended">Blended</option>
</select>
<input type = "submit">
</form>
</div>
</div1>

<h3>Top 5 Drinks Sold <h3>

<div3>
    <?php
    if(isset($_POST['CategoriesV']))
    {
        $varName = $_POST['CategoriesV'];
    }
    else
    {
        $varName = "";
    }
    
    if($varName == "")
    {
        $db = get_mysqli_connection();
        $sql = "select drinkname from ViewTop5";
        $result = $db->query($sql);
        while($row = $result->fetch_assoc()){
            echo $row['drinkname']. "</br>";
        }
    }
    else if($varName == "MilkTea"){
        $sql = "select drinkname from ViewTop5MT";
        $result = $db->query($sql);
        while($row = $result->fetch_assoc()){
            echo $row['drinkname']. "</br>";
        }
    }
    
    else if($varName == "TropicalTea"){
            $sql = "select drinkname from ViewTop5TT";
            $result = $db->query($sql);
            while($row = $result->fetch_assoc()){
                echo $row['drinkname']. "</br>";
            }
    }
    else if($varName == "Blended"){
        $sql = "select drinkname from ViewTop5BL";
        $result = $db->query($sql);
        while($row = $result->fetch_assoc()){
            echo $row['drinkname']. "</br>";
        }
    }
    ?>
    <div> Alternate View </br>
    <form method = "post">
    <label for="CategoryV">Choose a category:</label>
    <select name="CategoriesV">
        <option value=""> </option>
        <option value="MilkTea">MilkTea</option>
        <option value="TropicalTea">TropicalTea</option>
        <option value="Blended">Blended</option>
    </select>
    <input type = "submit">
    </form>
    </div>
</div3>

<div5>
    <h1> All Orders </h1>
    <?php
    $db = get_mysqli_connection();
    $sql = "select indexID, OID, DID, drinksize, quantity, drinkname, timestamp  from Item NATURAL JOIN Drinklist, `Order` where DID = drinkID AND orderID = OID";
    $result = $db->query($sql);
    $row = $result->fetch_all(MYSQLI_ASSOC);
    echo makeTable($row);
    ?>
</div5>

<div6>
<?php
    $db = get_mysqli_connection();
    $sql = "select * from ViewDrinksSold";
    $result = $db->query($sql);
    $row = $result->fetch_all(MYSQLI_ASSOC);
    ?>
    <script>
	TESTER = document.getElementById('tester');
	Plotly.newPlot( TESTER, [{
	x: [$row[0], 2, 3, 4, 5],
	y: [1, 2, 4, 8, 12] }], {
	margin: { t: 0 } } );
    </script>
</div6>


<?php /*
$select_form = new PhpFormBuilder();
$select_form->set_att("method", "POST");
$select_form->add_input("id to search for", array(
    "type" => "number"
), "search_id");
$select_form->add_input("data to search for", array(
    "type" => "text"
), "search_data");
$select_form->add_input("Submit", array(
    "type" => "submit",
    "value" => "Search"
), "search");
$select_form->build_form();

if (isset($_POST["search"])) {
    echo "searching...<br>";

    $db = get_mysqli_connection();
    $query = false;

    if (!empty($_POST["search_id"])) {
        echo "searching by id...";
        $query = $db->prepare("select * from hello where id = ?");
        $query->bind_param("i", $_POST["search_id"]);
    }
    else if (!empty($_POST["search_data"])) {
        echo "searching by data...";
        $query = $db->prepare("select * from hello where data = ?");
        $query->bind_param("s", $_POST["search_data"]);
    }
    if ($query) {
        $query->execute();
        $result = $query->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        echo makeTable($rows);
    }
    else{
        echo "Error executing query: " . mysqli_error();
    }
}*/

?>


<?php
$db = get_mysqli_connection();
$query = $db->prepare("SELECT DISTINCT categoryName from Drinklist WHERE categoryName = 'MilkTea' ");
if (!$query) {
  echo mysqli_error($db);
}
if (!$query->execute())
{
  echo mysqli_error($db);
}

// Getting the results will bring the results from the database into PHP.
// This lets you view each row as an associative array
$result0 = $query->get_result();
?>

<?php
$db = get_mysqli_connection();
$query = $db->prepare("SELECT DISTINCT categoryName from Drinklist WHERE categoryName = 'TropicalTea' ");
if (!$query) {
  echo mysqli_error($db);
}
if (!$query->execute())
{
  echo mysqli_error($db);
}

// Getting the results will bring the results from the database into PHP.
// This lets you view each row as an associative array
$result1 = $query->get_result();
?>
<?php
$db = get_mysqli_connection();
$query = $db->prepare("SELECT DISTINCT categoryName from Drinklist WHERE categoryName = 'Blended' ");
if (!$query) {
  echo mysqli_error($db);
}
if (!$query->execute())
{
  echo mysqli_error($db);
}


$result2 = $query->get_result();

?>

<h2>Add a drink</h2>

<?php

$insert_form = new PhpFormBuilder();
$insert_form->set_att("method", "POST");
$rows = [];

while ($row = $result0->fetch_assoc()) {
    // Do something with each row: add it to an array, render HTML, etc.
    $rows []= $row;

    // This example just iterates over the columns of the rows and builds a string
    $rowtext = "";

    foreach($row as $column) {
        $rowtext = $rowtext . "$column ";
    }

    //echo "$rowtext <br>";
}

foreach($rows as $row) {
    $rowid0 = $row["categoryName"];
    $rowdata0 = $row['categoryName'];

}
while ($row = $result1->fetch_assoc()) {
    // Do something with each row: add it to an array, render HTML, etc.
    $rows []= $row;

    // This example just iterates over the columns of the rows and builds a string
    $rowtext = "";

    foreach($row as $column) {
        $rowtext = $rowtext . "$column ";
    }

    //echo "$rowtext <br>";
}

foreach($rows as $row) {
    $rowid1 = $row["categoryName"];
    $rowdata1 = $row['categoryName'];

}
while ($row = $result2->fetch_assoc()) {
    // Do something with each row: add it to an array, render HTML, etc.
    $rows []= $row;

    // This example just iterates over the columns of the rows and builds a string
    $rowtext = "";

    foreach($row as $column) {
        $rowtext = $rowtext . "$column ";
    }

    //echo "$rowtext <br>";
}

foreach($rows as $row) {
    $rowid2 = $row["categoryName"];
    $rowdata2 = $row['categoryName'];

}


$insert_form->add_input("data to insert: drinkName", array(
    "type" => "text"
), "insert_data");

$insert_form->add_input("data to insert: categoryName", array(
    "type" => "select", 
    "options" => [$rowdata0,$rowdata1,$rowdata2],

    
   ), "dropdown");




$insert_form->add_input("Insert", array(
    "type" => "submit",
    "value" => "Insert"
), "insert");

$insert_form->build_form();

if (isset($_POST["insert"]) && !empty($_POST["insert_data"]) && !empty($_POST["dropdown"])){
    $dataToInsert = htmlspecialchars($_POST["insert_data"]);
    $dataToInsert2 = htmlspecialchars($_POST["dropdown"]);
    if ($dataToInsert2 == 'MilkTea')       
      $dataToInsert3 = htmlspecialchars("1");
    else if ($dataToInsert2 == 'TropicalTea') 
       $dataToInsert3 = htmlspecialchars("2");
    else if ($dataToInsert2 == 'Blended') 
       $dataToInsert3 = htmlspecialchars("3");

    echo "inserting $dataToInsert ... $dataToInsert2 ... $dataToInsert3";

    $db = get_mysqli_connection();
    

    $query = $db->prepare("INSERT INTO Drinklist (drinkname, categoryname, categoryid) VALUES (?, ?, ?)");
    
    $query->bind_param("sss", $dataToInsert, $dataToInsert2, $dataToInsert3);
    if ($query->execute()) {    
        header( "Location: " . $_SERVER['PHP_SELF']);
    }
    else {
        echo "Error inserting: " . mysqli_error();
        print_r($db->errorInfo());
    }
}
?>

<h2>Update a Drink's Name</h2>

<?php
$update_form = new PhpFormBuilder();
$update_form->set_att("method", "POST");
$update_form->add_input("drinkID", array(
    "type" => "number"
), "update_id");
$update_form->add_input("data to update", array(
    "type" => "text"
), "update_data");
$update_form->add_input("Update", array(
    "type" => "submit",
    "value" => "Update"
), "update");
$update_form->build_form();

if (isset($_POST["update"]) 
    && !empty($_POST["update_data"])
    && !empty($_POST["update_id"])) {
    $dataToUpdate = htmlspecialchars($_POST["update_data"]);
    $idToUpdate = htmlspecialchars($_POST["update_id"]);
    echo "updating $dataToUpdate ...";

    $db = get_mysqli_connection();
    $query = $db->prepare("update Drinklist set drinkname= ? where drinkID = ?");
    $query->bind_param("si", $dataToUpdate, $idToUpdate);
    $query->execute();
    /*if ($query->execute()) {    
        header( "Location: " . $_SERVER['PHP_SELF']);
    }
    else {
        echo "Error updating: " . mysqli_error();
    }*/
}

?>

<h2>Remove a Drink from the Menu</h2>

<?php
$delete_form = new PhpFormBuilder();
$delete_form->set_att("method", "POST");
$delete_form->add_input("drinkID to delete for", array(
    "type" => "number"
), "delete_id");
$delete_form->add_input("Delete", array(
    "type" => "submit",
    "value" => "Delete"
), "delete");
$delete_form->build_form();

if (isset($_POST["delete"])) {

    echo "deleting...<br>";

    $db = get_mysqli_connection();
    $query = false;

    if (!empty($_POST["delete_id"])) {
        echo "deleting by id...";
        $query = $db->prepare("call RemoveDrink(?)");
        $query->bind_param("i", $_POST["delete_id"]);
        $query->execute();
    }
    /*else if (!empty($_POST["delete_data"])) {
        echo "deleting by data...";
        $query = $db->prepare("delete from hello where data = ?");
        $query->bind_param("s", $_POST["delete_data"]);
    }
    if ($query) {
        $query->execute();
        $_SESSION["affected_rows"] = $db->affected_rows;
        header("Location: " . $_SERVER["PHP_SELF"]);
    }
    else{
        echo "Error executing delete query: " . mysqli_error();
    }*/
}
?>
</body>