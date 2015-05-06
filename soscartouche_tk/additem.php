<?php
include '../includes/dbconnect.inc';
include '../includes/queries.inc';
session_start();

if (!isset($_SESSION['clerkID'])) {
    header("Location: /index.php?error=1");
} else if ($_SESSION['clerkType'] != 0) {
    header("Location: /default.php?error=1");
}

$canEditItem = false;
if (isset($_POST['edit'])) {
    $toEdit = getItemByNumber($bdd, $_POST['itemNumber'])[0];
    if ($toEdit != null) {
        $canEditItem = true;
    } else {
        header("Location: /additem.php?error=1");
    }
} else if (isset($_POST['editItem'])) {

    if(!updateItem($bdd, $_POST['code'], $_POST['price'], $_POST['description'], $_POST['compatibility'], $_POST['color'], $_POST['quantity']))
        header("Location: /inventory.php?updatedItem=0");
    else
        header("Location: /inventory.php?updatedItem=1");

} else if (isset($_POST['addItem'])) {

    if(!addItem($bdd, $_POST['code'], $_POST['price'], $_POST['description'], $_POST['compatibility'], $_POST['color'], $_POST['quantity']))
        header("Location: /inventory.php?addedItem=0");
    else
        header("Location: /inventory.php?addedItem=1");
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Item</title>
    <!-- Every page will reference the mainFrame.css which contains the basic layout
     of the page-->
    <link rel="stylesheet" type="text/css" href="css/mainFrame.css"/>
    <link rel="stylesheet" type="text/css" href="css/addItem.css"/>
    <link rel="stylesheet" type="text/css" href="css/fonts.css"/>
    <link rel="icon"
          type="image/png"
          href="/images/favicon.ico" />
    <script type="text/javascript">
        function validateAdd() {

            var colorIn = document.forms['addItem'].color;
            switch (colorIn.value) {
                case "C":
                case "Y":
                case "M":
                case "Bk":
                case "Color":
                    return true;
                    break;
                default:
                    colorIn.style.backgroundColor = "red";
                    return false;
            }
        }
        function validateEdit() {

            var form = document.forms['editItem'];
            var error = false;
            switch (form.color.value) {
                case "C":
                case "Y":
                case "M":
                case "Bk":
                case "Color":
                    break;
                default:
                    form.color.style.backgroundColor = "red";
                    error = true;
            }
        }
    </script>
</head>
<body>
<?php include "header.php"; ?>
<main>
    <h1>Inventory Item Management</h1>

    <table id="forms">
        <tr>
            <th>
                Add New Item
            </th>
            <th>
                <?php if($canEditItem) echo "Edit Existing Item"; ?>
            </th>
        </tr>
        <tr>
            <td>
                <form class="form" id="addItem" action="additem.php" method="post" onsubmit="return validateAdd()">
                    <table>
                        <tr>
                            <td>
                                <label for="code">Code: </label>
                            </td>
                            <td>
                                <input type="text" id="code" name="code" maxlength="15" pattern="([IL]{1}[BCHEDKL]{1}[-])\w+" required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="price">Price: </label>
                            </td>
                            <td>
                                <input type="number" min="0.01" step="any" id="price" name="price" required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="description">Description: </label>
                            </td>
                            <td>
                                <input type="text" id="description" name="description" maxlength="30" required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="compatibility">Compatibility: </label>
                            </td>
                            <td>
                                <input type="text" id="compatibility" maxlength="30" name="compatibility">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="color">Color: </label>
                            </td>
                            <td>
                                <input type="text" id="colorAdd" onblur="validateAdd()" name="color">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="quantity">Quantity: </label>
                            </td>
                            <td>
                                <input type="number" min="0" id="quantity" name="quantity" required>
                            </td>
                        </tr>
                    </table>
                    <input type="submit" id="submit" name="addItem" value="Add Item">
                </form>
            </td>
            <?php if ($canEditItem) { ?>
                <td>
                    <form class="form" id="editItem" action="additem.php" method="post" onsubmit="return validateEdit()">
                        <table>
                            <tr>
                                <td>
                                    <label for="code">Code: </label>
                                </td>
                                <td>
                                    <input type="text" id="code" pattern="([IL]{1}[BCHEDKL]{1}[-])\w+" name="code"
                                           required readonly value='<?php echo $toEdit['code'] ?>'>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="price">Price: </label>
                                </td>
                                <td>
                                    <input type="number" id="price" min="0.01" step="any" name="price" required
                                           value='<?php echo $toEdit['price'] ?>'>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="description">Description: </label>
                                </td>
                                <td>
                                    <input type="text" id="description" name="description" maxlength="30" required
                                           value='<?php echo $toEdit['description'] ?>'>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="compatibility">Compatibility: </label>
                                </td>
                                <td>
                                    <input type="text" id="compatibility" name="compatibility" maxlength="30"
                                           value='<?php echo $toEdit['compatibility'] ?>'>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="color">Color: </label>
                                </td>

                                <td>
                                    <input type="text" id="colorEdit" name="color" onblur="validateEdit()"
                                           value='<?php echo $toEdit['color'] ?>'>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="quantity">Quantity: </label>
                                </td>
                                <td>
                                    <input type="number" id="quantity" min="0" name="quantity" required
                                           value='<?php echo $toEdit['quantity'] ?>'>
                                </td>
                            </tr>
                        </table>
                        <input type="submit" id="submit" name="editItem" value="Edit Item">
                    </form>
                </td>
            <?php } ?>
        </tr>
    </table>

</main>
</body>

</html>
