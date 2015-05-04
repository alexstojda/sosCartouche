<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 01/05/2015
 * Time: 9:48 AM
 */
$loadUsers = false;
$result = null;
$page = 1;
$perPage = 25;
$errorMsg = null;
$editUser = false;
$addUser = false;
$user = null;

if(isset($_GET['error'])){
    switch($_GET['error']){
        case 1:
            $errorMsg = "NO users match your search. Check your spelling and try again.";
            break;
        case 2:
            $errorMsg = "No users match the selected type.";
            break;
        default:
            $errorMsg = "Something went wrong (Undefined error)";
    }
}
if(isset($_SESSION['result']) && isset($_GET['page'])) {
    $result = $_SESSION['usersResult'];
    $page = $_GET['page'];
    $loadUsers = true;
}
if(isset($_POST['getByType'])){
    if($_POST['type'] == "all") {
        $result = getAllUsers($bdd);
    }
    else {
        $result = getUserByType($bdd, $_POST['type']);
    }
    if($result != null) {
        $loadUsers = true;
        $_SESSION['usersResult'] = $result;
    }
    else
        header("Location: /users.php?error=2");
}
if(isset($_POST['getByLName'])){
    $result = getUserByLastName($bdd, $_POST['lastName']);
    if($result != null) {
        $loadUsers = true;
        $_SESSION['usersResult'] = $result;
    }
    else
        header("Location: /users.php?error=1");
}
if(isset($_POST['edit'])) {
    $editUser = true;
    $user = getUserByType($bdd, $_POST['clerkID'])[0];
}
else if(isset($_POST['add'])) {
    $addUser = true;
}
if(isset($_POST['toAddUser'])) {
    $addResult = addUser($bdd, $_POST['clerkID'], $_POST['password'], $_POST['clerkType'], $_POST['firstName'], $_POST['lastName'], $_POST['hireDate']);
    switch($addResult) {
        case 0:
            $errorMsg = "Clerk has been added.";
            break;
        case 1:
            $errorMsg = "ClerkID already exists. Try again.";
            break;
        case 2:
            $errorMsg = "User add failed. Check your values and try again.";
            break;
        default:
            $errorMsg = "Undefined userAdd error";
    }
}
else if(isset($_POST['toEditUser'])) {
    if(updateUser($bdd, $_POST['clerkID'], $_POST['password'], $_POST['clerkType'], $_POST['firstName'], $_POST['lastName'])) {
        $errorMsg = "User modified";
    }
    else {
        $errorMsg = "Clerk edit failed";
    }
}
else if(isset($_POST['delete'])) {
    if($_POST['clerkID'] == $_SESSION['clerkID'])
        $errorMsg = "You can't delete yourself. If you need help call, the suicide hotline: 1-800-273-8255";
    else if(deleteUser($bdd, $_POST['clerkID']))
        $errorMsg = "User deleted";
    else
        $errorMsg = "User could not be deleted";
}


