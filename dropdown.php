<?php
require_once("config.php");
?>

<h2>Place an Order<br></h2>

<head>
<body>

<h2>Place an Order<br></h2>
<div> Alternate View </br>
<?php
$db = get_mysqli_connection();
$sql = "select distinct categoryID, categoryName from Drinklist";
$result0 = $db->query($sql);
$category = $result0->fetch_assoc();
?>
<form method = "post">
<label for="DrinkT">Choose a category:</label>
<select name="DrinkT">
    <option value=<?php foreach(echo $category['categoryname'])?>><?php foreach(echo $category['categoryName']?></option>
</select>
<input type = "submit">
</form>
</div>
</body>
</html>