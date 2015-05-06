<?php
session_start();
if (!isset($_SESSION['clerkID'])) {
    header("Location: /index.php?error=1");
}
else if($_SESSION['clerkID'] != 0){
    header("Location: /default.php?error=1");
}
include '../includes/dbconnect.inc';
include '../includes/queries.inc';
include '../includes/users.inc';

?>
<!DOCTYPE html>
<html>

<head>
    <!-- Name: Melanie Damilig
         Date: 2015/04/26
         Time: 12:10 AM -->
    <title>Clerks - SOS Cartouche</title>
    <!-- Every page will reference the mainFrame.css which contains the basic layout
     of the page-->
    <link rel="stylesheet" type="text/css" href="css/mainFrame.css"/>
    <link rel="stylesheet" type="text/css" href="css/users.css"/>
    <link rel="stylesheet" type="text/css" href="css/fonts.css"/>
    <link rel="icon"
          type="image/png"
          href="/images/favicon.ico" />
    <script type="text/javascript">
        function checkPassword() {
            var form = document.getElementById("modifyUser")
            if(form.password.value != form.confirmPassword.value) {
                form.password.style.backgroundColor = "red";
                form.confirmPassword.style.backgroundColor = "red";
            }
            else {
                form.password.style.backgroundColor = "white";
                form.confirmPassword.style.backgroundColor = "white";
            }
        }
    </script>

</head>
<body>
<?php include "header.php"; ?>
<main id="results">
    <h1>Users</h1>

    <?php if($editUser || $addUser) {?>
        <section>
            <form id="modifyUser" action="users.php" method="post">
                <table>
                    <tr>
                        <td><label for="clerkID">Clerk ID: </label> </td>
                        <td>
                            <?php
                            if($addUser)
                                echo "<input id='clerkID' name='clerkID' type='number' step='1' required>";
                            else if ($editUser)
                                echo "<input id='clerkID' name='clerkID' type='number' step='1' value='".$user['clerkID']."' readonly>";
                            ?>
                        </td>
                        <td>
                            <label for="hireDate">Hire date: </label>
                        </td>
                        <td>
                            <?php
                            if($addUser)
                                echo "<input type='date' id='hireDate' name='hireDate' required>";
                            else if ($editUser)
                                echo "<input type='date' id='hireDate' name='hireDate' value='".$user['hireDate']."' >";
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="type">Clerk type:</label>
                        </td>
                        <td>
                            <select id="type" name="clerkType" required>
                                <?php if($addUser) { echo "fuck";?>
                                    <option value="0">Manager</option>
                                    <option value="1" selected>Clerk</option>
                                <?php } else if ($editUser) {
                                            if($user['clerkType'] == 0) { ?>
                                        <option value="0" selected>Manager</option>
                                        <option value="1" >Clerk</option>
                                    <?php } else { ?>
                                        <option value="0" >Manager</option>
                                        <option value="1" selected>Clerk</option>
                                    <?php }
                                }?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="firstName">First name: </label> </td>
                        <td>
                            <?php
                            if($addUser)
                                echo "<input id='firstName' name='firstName' required>";
                            else if ($editUser)
                                echo "<input id='firstName' name='firstName' value='".$user['firstName']."' required>";
                            ?>
                        </td>
                        <td><label for="lastName">Last name: </label> </td>
                        <td>
                            <?php
                            if($addUser)
                                echo "<input id='lastName' name='lastName' required>";
                            else if ($editUser)
                                echo "<input id='lastName' name='lastName' value='".$user['lastName']."' required>";
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="password">Password: </label> </td>
                        <td>
                            <?php
                            if($addUser)
                                echo "<input type='password'  id='password' name='password' required onblur='checkPassword()'>";
                            else if ($editUser)
                                echo "<input type='password' id='password' name='password' value='".$user['password']."' required onblur='checkPassword()'>";
                            ?>
                        </td>
                        <td><label for="confirmPassword">Confirm Password: </label> </td>
                        <td>
                            <?php
                            if($addUser)
                                echo "<input type='password'  id='confirmPassword' name='password' required onblur='checkPassword()'>";
                            else if ($editUser)
                                echo "<input type='password' id='confirmPassword' name='password' value='".$user['password']."' required onblur='checkPassword()'>";
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <?php
                            if($addUser)
                                echo "<input type='submit' name='toAddUser' value='Add User'>";
                            else if ($editUser)
                                echo "<input type='submit' name='toEditUser' value='Edit User'>";
                            ?>
                        </td>
                    </tr>
                </table>
            </form>
        </section>
    <?php } ?>

    <!--<form action="users.php" method="post">
        <input type="submit" name="add" id="add" value="Add User">
    </form>-->
    <form action="users.php#results" method="post">
        <label for="type">User Type:  </label>
        <select id="type" name="type">
            <option value="all" selected>ALL</option>
            <option value="0">Manager</option>
            <option value="1">Clerk</option>
        </select>
        <input type="submit" name="getByType" value="GO">
    </form>
    <form action="users.php#results" method="post">
        <label for="lastName">Last Name:</label>
        <input type="text" name="lastName" required>
        <input type="submit" name="getByLName" value="GO">
    </form>
    <?php if($loadUsers) { ?>
        <div id="pages">
            <?php if($page != 1) { ?>
                <a href="users.php?page=1#results"><<</a>
                <a href="users.php?page=<?php echo ($page-1); ?>#results"><</a>
            <?php  }
            echo $page.'/'.ceil(count($result)/$perPage);
            if($page != ceil(count($result)/$perPage) ){?>
                <a href="users.php?page=<?php echo ($page+1); ?>#results">></a>
                <a href="users.php?page=<?php echo ceil(count($result)/$perPage); ?>#results">>></a>
            <?php } ?>
        </div>
    <?php } ?>
    <table id="users">
        <tr>
            <th>Clerk ID</th>
            <th>Name</th>
            <th>Type</th>
            <th>Hire Date</th>
            <th>Action</th>
        </tr>
        <?php
            if($loadUsers) {
                foreach(array_slice($result, ($page-1)*$perPage, $perPage) as $user) { ?>
                    <tr>
                        <td>
                            <?php echo $user['clerkID']; ?>
                        </td>
                        <td>
                            <?php echo $user['firstName']." ".$user['lastName']; ?>

                        </td>
                        <td>
                            <?php switch($user['clerkType']){
                                case 0:
                                    echo "Manager";
                                    break;
                                case 1:
                                    echo "Clerk";
                                    break;
                                default:
                                    echo "ClerkType undefined in users.php.";
                            } ?>
                        </td>
                        <td>
                            <?php echo $user['hireDate']; ?>
                        </td>
                        <td>
                            <form id='modify' method='post' action="users.php">
                                <input type='hidden' name='clerkID' value='<?php print $user['clerkID']; ?>' />
                                <input type='submit' name='delete' value='Delete' onclick="return confirm('You are about delete user <?php echo $user['firstName']." ".$user['lastName'] ?> \n Are you sure you want to do this?')"/>
                                <input type='submit' name='edit' value="Edit" onclick="return confirm('You are about modify user <?php echo $user['firstName']." ".$user['lastName'] ?> \n Are you sure you want to do this?')"/>
                            </form>
                        </td>
                    </tr>
                <?php
                }
            }
        ?>
    </table>
    <?php if($loadUsers) { ?>
        <div id="pages">
            <?php if($page != 1) { ?>
                <a href="users.php?page=1#results"><<</a>
                <a href="users.php?page=<?php echo ($page-1); ?>#results"><</a>
            <?php  }
            echo $page.'/'.ceil(count($result)/$perPage);
            if($page != ceil(count($result)/$perPage) ){?>
                <a href="users.php?page=<?php echo ($page+1); ?>#results">></a>
                <a href="users.php?page=<?php echo ceil(count($result)/$perPage); ?>#results">>></a>
            <?php } ?>
        </div>
    <?php } ?>
    <form id="addUser" method="post">
        <input id="addUser" type="submit" name="add" value="Add User" formaction="users.php">
        <?php
            if($loadUsers) {
                echo " <input type='submit' formaction='/report/usersReport.php' value='Print Report of this Query' formtarget='_blank'>";
            }

        ?>

    </form>
    <h4><?php print $errorMsg; ?></h4>
    <?php if(!$loadUsers) print "<h3 id='noItems'>Use the above options to execute a search.</h3>"; ?>
</main>
</body>

</html>
