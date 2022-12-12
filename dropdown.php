<?php
require_once("config.php");
?>

<h2>Place an Order<br></h2>

<head>
<body>
<?php
$db = get_mysqli_connection();
$query0 = $db->prepare("SELECT DISTINCT categoryID, categoryName FROM Drinklist");
$query0->execute();
$result0 = $query0->get_result();
$category = $result0->fetch_assoc();
?>
<h2>Place an Order<br></h2>
<div> Alternate View </br>
<form method = "post">
<label for="DrinkT">Choose a category:</label>
<select name="DrinkT">
    <option value="DrinkT"><?php foreach($category['categoryName']?></option>
</select>
<input type = "submit">
</form>
</div>
</body>
</html>