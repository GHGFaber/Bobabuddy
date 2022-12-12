<?php
require_once("config.php");
?>

<h2>Place an Order<br></h2>


<?php
//DrinkType Dropdown Menu//
echo "<form method = 'post'>";
echo "<label for='DrinkType'>Drink Type: </label>";

$db = get_mysqli_connection();
$query0 = $db->prepare("SELECT DISTINCT categoryID, categoryName FROM Drinklist");
$query0->execute();
$result0 = $query0->get_result();

echo "<select id=DrinkType name=DrinkT onChange='reloadc()' class='form-control' style='width:100px;'>";

$cat=$_GET["cat"];

echo "<option value='' selected>----Select----</option>";
while ($category = $result0->fetch_assoc())
    if($category['categoryID'] == $cat['categoryID'])
        echo "<option value=$category[categoryID] selected> $category[categoryName]</option>";
    else
        echo "<option value=$category[categoryID]> $category[categoryName]</option>";
echo "</select>";
echo "</form>";

echo $cat[0];

//echo $cat[0];

//Drink Dropdown Menu//
echo "<br>Drink: ";
echo "<form method = 'post'>";
$query1 = $db->prepare("SELECT drinkID, drinkName FROM Drinklist WHERE categoryID=?");
$query1->bind_param('i', $cat);
$query1->execute();
$result1 = $query1->get_result();

echo "<select id=DrinkID name=DrinkID  onChange='reloadd()' class='form-control' style='width:150px;'>";

$dog=$_GET['dog'];

echo "<option value='' selected>---------Select--------</option>";
while ($drinks = $result1->fetch_assoc())
    echo "<option value=$drinks[drinkID] selected> $drinks[drinkName]</option>";
echo "</select>";
echo "</form>";

echo $dog[0];

//Drink Size Dropdown Menu//
echo "<br>Drink Size: ";
echo "<select id=DrinkSize name=DrinkSize onChange='reloads()' class='form-control' style='width:80px;'>";
$rat=$_GET["rat"];
echo "<option value='L' selected>L</option>";
echo "<option value='M' selected>M</option>";
echo "<option value='S' selected>S</option>";
echo "<option value='' selected>--Select--</option>";
echo "</select>";

echo $rat[0];

//Drink Size Dropdown Menu//
echo "<br>QTY.: ";
echo "<select id=qty name=qty onChange='reloadp()' class='form-control' style='width:80px;'>";
$rat=$_GET["pat"];
for($counter = 1; $counter <= 10; $counter++)
    echo "<option value=$counter selected>$counter</option>";
echo "<option value='' selected>--Select--</option>";
echo "</select>";
echo "</form>";
echo $rat[0];
//Button//

if(isset($_POST['Order']) && isset($_POST['DrinkT']))
{
    $store = $_POST['DrinkT'];
    var_dump($store);
}
function placeOrder()
{
    //$db = get_mysqli_connection();
    //$queryOrder = $db->prepare("INSERT INTO `Order`(orderID) VALUE (NULL)");
    //$queryOrder->execute();
    echo "This will place an order";
}
?>

<form method = "post">
    <input type = "submit" name="Order" class="button" value = "Order" />
</form>


<script>
function reloadc()
{
    var v1=document.getElementById('DrinkType').value;
    self.location='dropdown.php?cat=' + v1;

}
function reloadd()
{
    var v2=document.getElementById('DrinkID').value;
    self.location='dropdown.php?dog=' + v2;

}
function reloads()
{
    var v3=document.getElementById('DrinkSize').value;
    self.location='dropdown.php?rat=' + v3;

}
function reloadp()
{
    var v4=document.getElementById('qty').value;
    self.location='dropdown.php?pat=' + v4;

}
</script>
</body>
</html>