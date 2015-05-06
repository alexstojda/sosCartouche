<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 29/04/2015
 * Time: 8:24 PM
 */
$loadItems = false;
$result = null;
$errorMsg = null;
$perPage = 25;
$page = 1;

if(isset($_SESSION['result']) && isset($_GET['page'])) {
    $result = $_SESSION['result'];
    $page = $_GET['page'];
    $loadItems = true;
}

if(isset($_GET['updatedItem'])) {
    switch($_GET['updatedItem']){
        case 0:
            $errorMsg = "Could not update the item. Please verify that all input is valid. Contact technical support should this error persist.";
            break;
        case 1:
            $errorMsg = "Item updated in database.";
            break;
        default:
            $errorMsg = "Undefined updateItem error. Contact technical support for more information.";
    }
}

if(isset($_GET['addedItem'])) {
    switch($_GET['addedItem']) {
        case 0:
            $errorMsg = "Could not add item. Please verify that the given itemCode does not already exist in the database.";
            break;
        case 1:
            $errorMsg = "Item added";
            break;
        default:
            $errorMsg = "Undefined addItem error. Contact technical support for more information.";
    }
}

if(isset($_GET['error'])){
    switch($_GET['error']) {
        case 0:
            $errorMsg = "Item Deleted";
            break;
        case 1:
            $errorMsg = "Search returned 0 results";
            break;
        case 2:
            $errorMsg = "Delete failed. Ensure that none of the item is left in stock before attempting to delete it.";
            break;
    }
}

if(isset($_POST['delete'])) {

    if (deleteItem($bdd, $_POST['itemNumber']))
        header("Location: /inventory.php?delete=0");
    else
        header("Location: /inventory.php?error=2");

}

if(isset($_POST['submit'])) {
    if ($_POST['formType'] == 0) {

        $type = $_POST['type'];
        $company = $_POST['printCompany'];
        $color = $_POST['color'];


        if ($type == "all" && $company == "all" && $color == "all") {
            $result = getAllItems($bdd);
            if ($result != null) {
                $loadItems = true;
            }
            else
                header("Location: /inventory.php?error=1");
        }
        else {
            $result = getItems($bdd, $type, $company, $color);
            if ($result != null) {
                $loadItems = true;
            }
            else
                header("Location: /inventory.php?error=1");
        }
    }

    if ($_POST['formType'] == 1) {
        $code = $_POST['itemCode'];

        $result = getItemByCode($bdd, $code);
        if ($result == null) {
            header("Location: /inventory.php?error=1");
        }
        else {
            $loadItems = true;
        }
    }

    if ($_POST['formType'] == 2) {
        $compat = $_POST['compat'];

        $result = getItemByCode($bdd, $compat);
        if ($result == null) {
            header("Location: /inventory.php?error=1");
        }
        else {
            $loadItems = true;
        }
    }
    $_SESSION['result'] = $result;
}
