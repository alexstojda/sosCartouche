<!DOCTYPE html>
<html>

    <head>
	<!--
	 * Arunraj Adlee
	 * Date: 24/04/2015
	 * Time: 5:30 PM
	/-->
        <title>Default Page</title>
        <!-- Every page will reference the mainFrame.css which contains the basic layout
         of the page-->
        <link rel="stylesheet" type="text/css" href="css/mainFrame.css" />
        <link rel="stylesheet" type="text/css" href="css/fonts.css" />
		<!-- CSS FOR DEFAULT PAGE-->
		<link href="css/default.css" rel="stylesheet" type="text/css" />
    </head>
 
<body>
	
	<?php include "header.php"; ?>
 <main>

<div id="mainContent" align="center">
<p>
	<table class="Content" >
			<tr>
				<td colspan=2>
				<h2>Welcome, Employee<!-- USERNAME HERE --> <h2>
				</td>
			</tr>
			
			<tr>
				<td id = "submitrow">
					<div class="row">
					<form action="Inventory.php"><!-- Opens inventory page -->
						<input type="submit"   id="inventory" value="Inventory"  />
						</form>
					</div>
				</td>
				<td id = "submitrow">
					<div class="row">
					<form action="Invoice.php"><!-- Opens invoice page -->
						<input type="submit"  id="invoice" value="Invoice"  />
						</form>
					</div>
				</td>
				<td id = "submitrow">
					<div class="row">
					<form action="UserInfo.php"><!-- Opens userinfo page -->
						<input type="submit"  id="userinfo" value="User Info"  />
						</form>
					</div>
				</td>
			</tr>

		</form>
		</table>
		</p>
		</div>
        </main>
    </body>

</html>
