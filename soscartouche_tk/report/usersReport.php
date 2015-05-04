<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 03/05/2015
 * Time: 8:18 PM
 */
session_start();

if(!isset($_SESSION['clerkID'])){
    header("Location: http://soscartouche.tk?error=1");
}

$result = $_SESSION['usersResult'];

?>
<script type="text/javascript">
    window.onload = function() {
        window.print();
    };
</script>
<style type="text/css">
    table {
        border-collapse: collapse;
        width: 800px;
        text-align: center;
    }
    td {
        border-top: dotted 1px black;
        border-bottom: dotted 1px black;
    }
</style>
<?php echo "Report generated " . date("m/d/y  h:i:sa") . " By ".$_SESSION['firstName']." (ID: ".$_SESSION['clerkID'].")"; ?>
<br>
<br>
<h1>User query report</h1>
<br>
<br>
<table id="users">
    <tr>
        <th>Clerk ID</th>
        <th>Name</th>
        <th>Type</th>
        <th>Hire Date</th>
    </tr>
    <?php
        foreach($result as $user) { ?>
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
            </tr>
        <?php
        }
    ?>
</table>