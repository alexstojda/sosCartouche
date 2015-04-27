<?php
    include $_SERVER['DOCUMENT_ROOT'].'/../includes/dbconnect.php';
    include $_SERVER['DOCUMENT_ROOT'].'/../includes/queries.php';
    session_start();
    if (isset($_SESSION['clerkID']) && !empty($_SESSION['clerkID'])) {
        print "THERE IS A SESSION";
        session_unset();
        session_destroy();
    }
    if(isset($_POST['submit'])){
        $id = $_POST['userName'];
        $password = $_POST['password'];

        $loginResult = login($bdd, $id, $password);

        if ($loginResult == null) {
            include "loginerror.html";
        }
        else {
            $_SESSION['clerkID'] = $loginResult['clerkID'];
            $_SESSION['clerkType'] = $loginResult['clerkType'];
            $_SESSION['firstName'] = $loginResult['firstName'];

            print $_SESSION['clerkID']." ".$_SESSION['clerkType']." ".$_SESSION['firstName'];
        }
    }

?>

<!DOCTYPE html>
<html>

    <head>
	<!--
	 * Arunraj Adlee
	 * Date: 24/04/2015
	 * Time: 3:30 PM
	/-->
        <title>Login Page</title>
        <!-- Every page will reference the mainFrame.css which contains the basic layout
         of the page-->
        <link rel="stylesheet" type="text/css" href="css/mainFrame.css" />
        <link rel="stylesheet" type="text/css" href="css/fonts.css" />
		<!-- CSS FOR LOGIN PAGE-->
		<link href="css/login.css" rel="stylesheet" type="text/css" />
        <!-- This checks if the user leaves empty fields. Not sure if its really necessary
				 -->
        <script type="text/javascript">
            function length(field)
            {
                if (field.value.length == 0 || field.value == 'Please fill out all fields')
                {
                    field.style.backgroundColor = 'red';
                    field.value = "Please fill out all fields";
                }
                else
                {
                    field.style.backgroundColor = 'white';
                    return true;
                }
            }
            function validateForm()
            {
                var isValid = true;
                if(!length(document.forms[0].userName))
                    isValid = false;
                if(!length(document.forms[0].password))
                    isValid = false;

                return isValid;
            }
            function loading() {
                document.getElementById("loginForm").style.display = "none";
                document.getElementById("loading").style.display = "block";
            }
        </script>
    </head>
 
<body>

	<?php include "header.php"; ?>
<main>

    <div id="mainContent" align="center">
        <form id="loginForm" action="login.php" onsubmit="return validateForm()" method="POST">
            <table class="Content" >
                <tr>
                    <td>
                        <label for="userName">Username</label>
                        <input id="userName" class="input" name="userName" type="text" value="" size="20"
                            onfocus="(this.value == 'Please fill out all fields') && (this.value = '')"
                            />
                        <br />
                            <label for="password">Password</label>
                            <input id="password" class="input" name="password" type="text" value="" size="20"
                            onfocus="(this.value == 'Please fill out all fields') && (this.value = '')"
                                />
                        <br />
                    </td>
                </tr>


                <tr>
                    <td id = "submitrow">
                            <input type="submit" name="submit" value="Submit"  />
                    </td>
                </tr>


                <tr>
                    <td>
                        <div class="row">
                            <!-- Link to forgot password page? Not sure if we are gonna code this-->
                            <a href="#">Forgot Your Password</a><br />
                        </div>
                    </td>
                </tr>
            </table>
        </form>
        <div id="loading">
            <img src="images/loading.GIF" alt="LOADING"/>
            <h2>We are logging you in, please wait...</h2>
        </div>
    </div>
</main>
</body>

</html>
