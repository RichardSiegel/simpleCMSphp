<?php include "../includes/log.php"; ?>
<html>
    <head>
        <title>Login Page</title>
	<style>
    body {
        /*background-repeat: no-repeat;
        background-size: cover;
        background-image: url('background.jpg');
        background-position: center;*/
    }
	.center {
        width: 320px;
        height: 150px;
        position: absolute;
        top:0;
        bottom: 0;
        left: 0;
        right: 0;
        margin: auto;
	}
    table {
        background:rgba(255,255,255,0.7);
        border-radius: 15px;
        padding: 20px;
    }
	</style>
    </head>
    <body> 
        <div class="center">
	  <center>
            <h1>Create New Account</h1>
            <form action="checkNew.php" method="POST">
                <table>
                    <tr>
                        <td>
                            Email:
                        </td>
                        <td>
                            <input type="text" name="mail"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            User:
                        </td>
                        <td>
                            <input type="text" name="user"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Full-Name:
                        </td>
                        <td>
                            <input type="text" name="displayName"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Passwort:
                        </td>
                        <td>
                            <input type="password" name="pw"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php
                            if ($_GET['FAIL']) {
                                echo "<center><i>Credentials incorrect!</i></center>";
                            }
                            ?>
                        </td>
                        <td style="position:relative; float:right;">
                            <input type="submit" value="login"/>
                        </td>
                    </tr>
                </table>
            </form>
          </center>
        </div>
    </body>
</html>
