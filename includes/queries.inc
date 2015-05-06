<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 27/04/2015
 * Time: 8:17 AM
 */


/**
 * Attempts a login with the given clerkID and password
 * @param $bdd PDO Database object to be searched through
 * @param $id int clerkID to be logged in
 * @param $password string password attempt
 * @return null if the login is invalid, user info otherwise
 */
function login($bdd, $id, $password) {
    $query = $bdd->prepare("SELECT password FROM clerk WHERE clerkID=:id");
    $query->execute(array('id' => $id));



    if($query->rowCount() == 0){
        return null;
    }

    $userData = $query->fetch(PDO::FETCH_ASSOC);

    if(strcmp($userData['password'],$password) != 0) {
        return null;
    }
    else {
        $query = $bdd->prepare("SELECT clerkID, clerkType, firstName FROM clerk WHERE clerkID=:id");
        $query->execute(array('id' => $id));
        $user = $query->fetch(PDO::FETCH_ASSOC);
        return $user;
    }
}

/**
 * Returns all items from the database
 * @param $bdd PDO object to get all items from.
 * @return array of all items from PDO, null if no rows found
 */
function getAllItems($bdd) {
    $query = $bdd->prepare("SELECT * FROM item");
    $query->execute();

    if($query->rowCount() == 0){
        return null;
    }

    return $query->fetchAll();
}

/**
 * Returns items that satisfy the given flags
 * @param $bdd PDO object to be searched through
 * @param $type string type of ink cartridge to be returned
 * @param $company string company of ink cartridges to be returned
 * @param $color string color of ink cartridges to be returned
 * @return array of all items collected in the query
 */
function getItems($bdd, $type, $company, $color) {

    if($color == "all") {
        $item = null;
        if($type != "all" && $company != "all") {
            $item = $type.$company.'%';
        }
        else if($type == "all" && $company != "all") {
            $item = '_'.$company.'%';
        }
        else
            $item = $type.'%';
        $query = $bdd->prepare("SELECT * FROM item WHERE code LIKE :item");
        $query->execute(array('item' => $item));
        return $query->fetchAll();
    }
    else {
        $item = null;
        if ($type == "all" && $company == "all") {
            $item = '%';
        }
        else if($type != "all" && $company != "all") {
            $item = $type.$company.'%';
        }
        else if($type == "all" && $company != "all") {
            $item = '_'.$company.'%';
        }
        else
            $item = $type.'%';
        $query = $bdd->prepare("SELECT * FROM item WHERE code LIKE :item AND color=:color");
        $query->execute(array('item' => $item, 'color' => $color));
        return $query->fetchAll();
    }
}

/**
 * Get item that matches the given item number
 * @param $bdd
 * @param $number
 * @return null
 */
function getItemByNumber($bdd, $number) {
    if ($number == null) {
        return null;
    }
    $query = $bdd->prepare("SELECT * FROM item WHERE itemNumber = :itemNumber");
    $query->execute(array('itemNumber' => $number));
    return $query->fetchAll();
}

/**
 * Get items that match the given code or part of a code
 * @param $bdd PDO object to be searched through
 * @param $code string Code, or part of code, of item to be returned
 * @return array of items satisfying conditions, null if 0 rows are returned from query
 */
function getItemByCode($bdd, $code) {
    if ($code == null) {
        return null;
    }
    $code = '%'.$code.'%';
    $query = $bdd->prepare("SELECT * FROM item WHERE UPPER(code) LIKE UPPER(:code)");
    $query->execute(array('code' => $code));
    return $query->fetchAll();
}

/**
 * Returns an item with compatibility code matching the given code, or part of a code
 * @param $bdd PDO object to be searched through
 * @param $compat string Compatible cartridge, or part of a code, of item to be returned
 * @return array of items satisfying conditions, null if 0 rows are returned from query
 */
function getItemByCompat($bdd, $compat) {
    if ($compat == null) {
        return null;
    }
    $compat = '%'.$compat.'%';
    $query = $bdd->prepare("SELECT * FROM item WHERE UPPER(compatibility) LIKE UPPER(:compat)");
    $query->execute(array('compat' => $compat));
    return $query->fetchAll();
}

/**
 * Deletes given item from database
 * @param $bdd PDO object to be searched through
 * @param $itemNumber int number of item to be deleted
 * @return true if the delete was successful, null otherwise
 */
function deleteItem($bdd, $itemNumber) {
    $query = $bdd->prepare("SELECT quantity FROM item WHERE itemNumber=:itemNumber");
    $query->execute(array('itemNumber' => $itemNumber));
    $item = $query->fetch(PDO::FETCH_ASSOC);

    if($item['quantity'] == 0) {
        $query = $bdd->prepare("DELETE FROM item WHERE itemNumber=:itemNumber");
        return $query->execute(array('itemNumber' => $itemNumber));
    }
    else {
        return null;
    }
}

/**
 * Adds new item to database
 * @param $bdd PDO database to add item to
 * @param $code string the new item's code
 * @param $price float the new item's price
 * @param $description string the new item's description
 * @param $compatibility string the new item's compatible equivalent
 * @param $color string the new item's color
 * @param $quantity int the new item's quantity
 * @return boolean True if successful, False otherwise
 */
function addItem($bdd, $code, $price, $description, $compatibility, $color, $quantity){

    $query = $bdd->prepare("INSERT INTO item (code, price, description, compatibility, color, quantity) VALUES(:code, :price, :description, :compatibility, :color, :quantity)");
    try {
        return $query->execute(array('code' => $code, 'price' => $price, 'description' => $description, 'compatibility' => $compatibility, 'color' => $color, 'quantity' => $quantity));
    }
    catch (PDOException $e) {
        return false;
    }
}

/**
 * Adds new item to database
 * @param $bdd PDO database to update the item in
 * @param $code string the item's code
 * @param $price float the updated item's price
 * @param $description string the updated item's description
 * @param $compatibility string the updated item's compatible equivalent
 * @param $color string the updated item's color
 * @param $quantity int the updated item's quantity
 * @return boolean True if successful, False otherwise
 */
function updateItem($bdd, $code, $price, $description, $compatibility, $color, $quantity){
    $query = $bdd->prepare("UPDATE item SET price=:price, description=:description, compatibility=:compatibility, color=:color, quantity=:quantity WHERE code=:code");
    try {
        return $query->execute(array('code' => $code, 'price' => $price, 'description' => $description, 'compatibility' => $compatibility, 'color' => $color, 'quantity' => $quantity));
    }
    catch (PDOException $e) {
        return false;
    }
}

function getAllUsers($bdd) {
    $query = $bdd->prepare("SELECT * FROM clerk");
    $query->execute();

    if($query->rowCount() == 0){
        return null;
    }
    else
        return $query->fetchAll();
}

function getUserByLastName($bdd, $lName){
    $query = $bdd->prepare("SELECT * FROM clerk WHERE UPPER(lastName)=UPPER(:lName)");
    $query->execute(array('lName' => $lName));

    if($query->rowCount() == 0){
        return null;
    }
    else
        return $query->fetchAll();
}

function getUserByID($bdd, $id) {
    $query = $bdd->prepare("SELECT * FROM clerk WHERE clerkID=:ID");
    $query->execute(array('ID' => $id));

    if($query->rowCount() == 0 || $query->fetch(PDO::FETCH_ASSOC)['clerkID'] != $id ){
        return null;
    }
    else
        return $query->fetch(PDO::FETCH_ASSOC);
}

function getUserByType($bdd, $type){
    $query = $bdd->prepare("SELECT * FROM clerk WHERE clerkType=:clerkType");
    $query->execute(array('clerkType' => $type));

    if($query->rowCount() == 0){
        return null;
    }
    else
        return $query->fetchAll();
}

function addUser($bdd, $clerkID, $password, $clerkType, $firstName, $lastName, $hireDate){
    if(getUserByID($bdd, 0) != null)
        return 1;
    $query = $bdd->prepare("INSERT INTO clerk (clerkID, password, clerkType, firstName, lastName, hireDate) VALUES (:clerkID, :password, :clerkType, :firstName, :lastName, :hireDate)");
    if($query->execute(array('clerkID' => $clerkID, 'password' => $password, 'clerkType' => $clerkType, 'firstName' => $firstName, 'lastName' => $lastName, 'hireDate' => $hireDate)))
        return 0;
    else
        return 2;
}

function updateUser($bdd, $ID, $password, $clerkType, $firstName, $lastName){
    $query = $bdd->prepare("UPDATE clerk SET password=:password, clerkType=:clerkType, firstName=:firstName, lastName=:lastName WHERE clerkID=:ID");
    try {
        return $query->execute(array('ID' => $ID, 'password' => $password, 'clerkType' => $clerkType, 'firstName' => $firstName, 'lastName' => $lastName));
    }
    catch (PDOException $e) {
        return false;
    }
}

function deleteUser($bdd, $ID) {
    $query = $bdd->prepare("DELETE FROM clerk WHERE clerkID=:id");
    return $query->execute(array('id' => $ID));
}
