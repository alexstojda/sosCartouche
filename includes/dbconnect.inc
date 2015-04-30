<?php

    $dsn = 'mysql:dbname=yellow_sysdev;host=localhost';
    $dbuser = 'yellow';
    $password = 'sysdev';
    $bdd = null;

    try
    {
        $bdd = new PDO($dsn,$dbuser,$password);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e)
    {
        echo 'Could not connect to db: ' . $e->getMessage();
        exit;
    }