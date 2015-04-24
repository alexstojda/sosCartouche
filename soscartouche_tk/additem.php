<!DOCTYPE HTML>
<html>
<head>
    <title>Add item</title>
</head>
<body>
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

        <br>
        <br>
        <input type="submit" id="submit" name="submit">


    </form>
<?php
if(isset($_POST['submit'])){
    print 'hello';
}

?>
</body>
</html>