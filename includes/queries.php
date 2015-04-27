<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 27/04/2015
 * Time: 8:17 AM
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