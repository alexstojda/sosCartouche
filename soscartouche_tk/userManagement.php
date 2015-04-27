<!DOCTYPE html>
<html>

    <head>
        <!-- Name: Melanie Damilig
        	 Date: 2015/04/26
             Time: 12:10 AM -->    
        <title>PAGE TITLE GOES HERE</title>
        <!-- Every page will reference the mainFrame.css which contains the basic layout
         of the page-->
        <link rel="stylesheet" type="text/css" href="css/mainFrame.css" />
        <link rel="stylesheet" type="text/css" href="css/userManagement.css" />
        <link rel="stylesheet" type="text/css" href="css/fonts.css" />

    </head>
    <body>
    <?php include "header.php"; ?>
        <main>
	        <h1>Users</h1>
            <form action="addUser.php">
            	<input type="submit" name="add" id="add" value="Add User">
            </form>
            <table name="users" id="users">
            	<tr>
                	<th>Order</th>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Last Login Time</th>
                    <th></th>
                </tr>
                <tr>
                </tr>
            </table>
        </main>
    </body>

</html>
