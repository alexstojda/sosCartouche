<!DOCTYPE html>
<html>

    <head>
        <title>Add Item</title>
        <!-- Every page will reference the mainFrame.css which contains the basic layout
         of the page-->
        <link rel="stylesheet" type="text/css" href="css/mainFrame.css" />
        <link rel="stylesheet" type="text/css" href="css/addItem.css" />
        <link rel="stylesheet" type="text/css" href="css/fonts.css" />

    </head>
    <body>
    <?php include "header.php"; ?>
        <main>
          <h1>Inventory Item Add</h1>
       	  <form id="additem" action="" method="post">
                <label for="code">Code: </label>
                <input type="text" id="code" name="code">
                <label for="price">Price: </label>
                <input type="number" id="price" name="price">
                <label for="description">Description: </label>
                <input type="text" id="description" name="description">
                <label for="compatibility">Compatibility: </label>
                <input type="text" id="compatibility" name="compatibility">
                <label for="color">Color: </label>
                <input type="text" id="color" name="color">
                <label for="quantity">Quantity: </label>
                <input type="number" id="quantity" name="quantity">

                <input type="submit" id="submit" name="submit">
            </form>
        </main>
    </body>

</html>
