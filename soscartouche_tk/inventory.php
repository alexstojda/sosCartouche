<?php
    session_start();
    if(!isset($_SESSION['clerkID'])){
        header("Location: /index.php?error=1");
    }
    include '../includes/dbconnect.inc';
    include '../includes/queries.inc';


    include '../includes/inventory.inc';

?>

<!DOCTYPE html>
<html>

    <head>
        <!-- Name: Melanie Damilig
        	 Date: 2015/04/25
             Time: 11:57 PM -->
        <title>Manager Inventory List</title>
        <link rel="stylesheet" type="text/css" href="css/mainFrame.css" />
        <link rel="stylesheet" type="text/css" href="css/inventory.css" />
        <link rel="stylesheet" type="text/css" href="css/fonts.css" />
        <link rel="icon"
              type="image/png"
              href="/images/favicon.ico" />


    </head>
    <body>
    <?php include "header.php"; ?>
        <main id="results">
            <h1>Inventory List</h1>
            <form id="filters" action="inventory.php#results" method="post">
                <input type="hidden" name="formType" value="0" />
                <label for="type">Type: </label>
                <select id="type" name="type">
                    <option value="all" selected>ALL</option>
                    <option value="I">Ink</option>
                    <option value="L">Laser</option>
                </select>
                <label for="printCompany">Printer company: </label>
                <select id="printCompany" name="printCompany">
                    <option value="all" selected>ALL</option>
                    <option value="B">Brother</option>
                    <option value="C">Canon</option>
                    <option value="H">HP</option>
                    <option value="E">Epson</option>
                    <option value="D">Dell</option>
                    <option value="K">Kodak</option>
                    <option value="L">Lexmark</option>
                </select>
                <label for="color">Color: </label>
                <select id="color" name="color">
                    <option value="all" selected>ALL</option>
                    <option value="Bk">Black</option>
                    <option value="C">Cyan</option>
                    <option value="Y">Yellow</option>
                    <option value="M">Magenta</option>
                    <option value="Color">Color</option>
                </select>
                <input name="submit" type="submit" value="GO"/>
            </form>

            <form id="code" action="inventory.php#results" method="post">
                <input type="hidden" name="formType" value="1" />
                <label for="itemCode">Item Code: </label>
                <input type="text" id="itemCode" name="itemCode" />
                <input name="submit" type="submit" value="GO"/>
            </form>

            <form id="compatibility" action="inventory.php#results" method="post">
                <input type="hidden" name="formType" value="2" />
                <label for="compat">Compatiblity: </label>
                <input type="text" id="compat" name="compat" />
                <input name="submit" type="submit" value="GO"/>
            </form>

            <?php if($loadItems) { ?>
                <div id="pages">
                    <?php if($page != 1) { ?>
                        <a href="inventory.php?page=1#results"><<</a>
                        <a href="inventory.php?page=<?php echo ($page-1); ?>#results"><</a>
                    <?php  }
                    echo $page.'/'.ceil(count($result)/$perPage);
                    if($page != ceil(count($result)/$perPage) ){?>
                        <a href="inventory.php?page=<?php echo ($page+1); ?>#results">></a>
                        <a href="inventory.php?page=<?php echo ceil(count($result)/$perPage); ?>#results">>></a>
                    <?php } ?>
                </div>
            <?php } ?>
            <table id="inventoryList">
                <tr>
                    <th>Item Number</th>
                    <th>Item Code</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Compatibility</th>
                    <th>Color</th>
                    <th>Quantity</th>
                    <?php if ($_SESSION['clerkID'] == 0) print "<th>Action</th>" ?>
                </tr>
                <?php
                    if($loadItems) {
                        foreach (array_slice($result, ($page-1)*$perPage, $perPage) as $item) {
                            print "<tr><td>" . $item['itemNumber'] . "</td><td>" . $item['code'] . "</td><td>" .'$'. number_format ($item['price'], 2 ) . "</td><td>" . $item['description'] . "</td><td>" . $item['compatibility'] . "</td><td>" . $item['color'] . "</td><td>" . $item['quantity'] . "</td>";
                            if ($_SESSION['clerkID'] == 0) {
                                ?>
                                    <td>
                                        <form id='modify' method='post'>
                                            <input type='hidden' name='itemNumber' value='<?php print $item['itemNumber']; ?>' />
                                            <input type='submit' name='delete' value='Delete' formaction="inventory.php" onclick="return confirm('You are about delete item <?php echo $item['code'] ?> \n Are you sure you want to do this?')"/>
                                            <input type='submit' name='edit' value="Edit" formaction="additem.php" onclick="return confirm('You are about modify item <?php echo $item['code'] ?> \n Are you sure you want to do this?')"/>
                                        </form>
                                    </td></tr>
                                <?php
                            } else
                                print "</tr>";
                        }
                    }
                ?>
            </table>
            <?php if($loadItems) { ?>
                <div id="pages">
                    <?php if($page != 1) { ?>
                        <a href="inventory.php?page=1#results"><<</a>
                        <a href="inventory.php?page=<?php echo ($page-1); ?>#results"><</a>
                    <?php  }
                    echo $page.'/'.ceil(count($result)/$perPage);
                    if($page != ceil(count($result)/$perPage) ){?>
                        <a href="inventory.php?page=<?php echo ($page+1); ?>#results">></a>
                        <a href="inventory.php?page=<?php echo ceil(count($result)/$perPage); ?>#results">>></a>
                    <?php } ?>
                </div>
            <?php }
            if($_SESSION['clerkType'] == 0) { ?>
                <form method="post">
                    <input type="submit" formaction="additem.php" value="Add New Item">
                    <?php
                        if($loadItems) {
                            echo "<input type='submit' formaction='/report/inventoryReport.php'  value='Print Report of this query' formtarget='_blank'>";
                        }
                    ?>
                </form>
            <?php } ?>

            <h4><?php print $errorMsg; ?></h4>
            <?php if(!$loadItems) print "<h3 id='noItems'>No query has been executed, use the above options to execute a search.</h3>"; ?>
        </main>
    </body>

</html>
