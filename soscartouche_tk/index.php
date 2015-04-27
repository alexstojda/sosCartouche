<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 26/04/2015
 * Time: 5:49 PM
 */
$files = array();
$dir = opendir('.'); // open the cwd..also do an err check.
while(false != ($file = readdir($dir))) {
    if(($file != ".") and ($file != "..") and ($file != "index.php")) {
        $files[] = $file; // put in array.
    }
}

natsort($files); // sort.

// print.
foreach($files as $file) {
    echo("<a href='$file'>$file</a> <br />\n");
}