<!DOCTYPE html>
<html>

    <head>
        <!-- Name: Melanie Damilig
        	 Date: 2015/04/25
             Time: 11:57 PM -->
        <title>Manager Inventory List</title>
        <!-- Every page will reference the mainFrame.css which contains the basic layout
         of the page-->
        <link rel="stylesheet" type="text/css" href="css/mainFrame.css" />
                <link rel="stylesheet" type="text/css" href="css/managerInventoryList.css" />
        <link rel="stylesheet" type="text/css" href="css/fonts.css" />

    </head>
    <body>
    <?php include "header.php"; ?>
        <main>
            <div>
            <h1>Inventory List</h1>
            <h2>Filter: </h2>
            <!-- TODO Add filter selection box -->
            <form action="addItem.php">
                <input type="submit" name="add" id="add" value="Add Item">
            </form>
                <table id="inventoryList">
                    <tr >
                        <th>Description</th>
                        <th>Item Number</th>
                        <th>Quantity</th>
                        <th>Supplier</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
	                </tr>
                </table>
            </div>
        </main>
        <footer>
        	<div>Contact Us</div>
            <div>FAQ</div>
            <div>Report a Problem</div>
            <div>Log Out</div>
        </footer>
    </body>

</html>
