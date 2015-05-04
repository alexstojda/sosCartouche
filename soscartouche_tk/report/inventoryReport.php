<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 03/05/2015
 * Time: 8:18 PM
 */
session_start();

if(!isset($_SESSION['clerkID'])){
    header("Location: http://soscartouche.tk?error=1");
}

$result = $_SESSION['result'];

?>
<script type="text/javascript">
    window.onload = function() {
        window.print();
    };
</script>
<style type="text/css">
    table {
        border-collapse: collapse;
        width: 800px;
        text-align: center;
    }
    td {
        border-top: dotted 1px black;
        border-bottom: dotted 1px black;
    }
</style>
<?php echo "Report generated " . date("m/d/y  h:i:sa") . " By ".$_SESSION['firstName']." (ID: ".$_SESSION['clerkID'].")"; ?>
<br>
<br>
<h1>Inventory query report</h1>
<br>
<br>
<table id="inventoryList">
    <tr>
        <th>Item Number</th>
        <th>Item Code</th>
        <th>Price</th>
        <th>Description</th>
        <th>Compatibility</th>
        <th>Color</th>
        <th>Quantity</th>
    </tr>
    <?php
        foreach ($result as $item) {
            print "<tr><td>" . $item['itemNumber'] . "</td><td>" . $item['code'] . "</td><td>" .'$'. number_format ($item['price'], 2 ) . "</td><td>" . $item['description'] . "</td><td>" . $item['compatibility'] . "</td><td>" . $item['color'] . "</td><td>" . $item['quantity'] . "</td></tr>";
            //print "<tr><td colspan='7'>--------------------------------------------------------------------------------------------------------------------------------------------------------</td></tr>";
        }
    ?>
</table>