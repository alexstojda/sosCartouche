<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 22/04/2015
 * Time: 10:58 AM
 */
include "../includes/dbconnect.php";

if($db_found) {
    $SQL = "SELECT * FROM item";
    $result = mysql_query($SQL);

    while ($db_field = mysql_fetch_assoc($result)) {
        print $db_field['itemNumber']." ";
        print $db_field['code']." ";
        print $db_field['description']." ";
        print $db_field['compatibility']." ";
        print $db_field['color']." ";
        print $db_field['quantity']."<BR>";
    }
    mysql_close($db_handle);

}
else {
    print "Database NOT found";
    mysql_close($db_handle);
}