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

function addItem($bdd, $code, $price, $description, $compatibility, $color, $quantity){
    $query = $bdd->prepare("INSERT INTO item (code, price, description, compatibility, color, quantity) VALUES(:code, :price, :description, :compatibility, :color, :quantity)");
    return $query->execute(array('code' => $code, 'price' => $price, 'description' => $description, 'compatibility' => $compatibility, 'color' => $color, 'quantity' => $quantity) );
}

function updateItem($bdd, $code, $price, $description, $compatibility, $color, $quantity){
    $query = $bdd->prepare("UPDATE item SET price=:price, description=:description, compatibility=:compatibility, color=:color, quantity=:quantity WHERE code=:code");
    return $query->execute(array('code' => $code, 'price' => $price, 'description' => $description, 'compatibility' => $compatibility, 'color' => $color, 'quantity' => $quantity) );
}