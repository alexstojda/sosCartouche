<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 24/04/2015
 * Time: 12:46 PM
 */
?>
<head>
    <link rel="stylesheet" type="text/css" href="css/header.css" />
    <link rel="icon"
          type="image/png"
          href="/images/favicon.ico" />
</head>
<header>
    <?php if(isset($_SESSION['clerkID'])) {?>
    <aside id="logout">
        <a href="index.php?logout=1">Log Out</a>
    </aside>
    <?php } ?>
    <img id="logo" alt="Logo" src="images/logo.png" height="200" />
    <nav>
        <?php if (!isset($_SESSION['clerkID']) ) {?>
            <p>Please login to access these features</p>
        <?php } else if ($_SESSION['clerkID'] == 0) {?>
            <ul>
                <li><a href="inventory.php">Inventory</a></li>
                <li><a href="invoice.php">Invoice</a></li>
                <li><a href="users.php">Users</a></li>
                <li><a href="userinfo.php">My Account</a></li>
            </ul>
        <?php } else { ?>
            <ul>
                <li><a href="inventory.php">Inventory</a></li>
                <li><a href="invoice.php">Invoice</a></li>
                <li><a href="userinfo.php">My Account</a></li>
            </ul>
        <?php } ?>
    </nav>
</header>
