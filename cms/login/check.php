<?php
$includesPath = "../includes";
include "$includesPath/log.php";
include "$includesPath/mkfile.php";
include "$includesPath/setupvars.php";
setupvars($includesPath);
?>
<?php
    $user = $_POST["user"];
    $pw = $_POST["pw"];
    
    function credentialsExist($usr,$pass) {
        $existence = false;
        if (file_exists("users/" . $usr)){
            $pwHash = hash("sha256", $pass, false);
            $existence = (file_get_contents("users/".$usr) == $pwHash);
        }
        return $existence;
    }

    if (credentialsExist($user,$pw)) {
        $OneTimeHash = hash("sha256", rand(0,9999999) . time());
        mkfile("tmp",$user,$OneTimeHash);
        mail(file_get_contents("mails/$user"),"One-Time-Code",$OneTimeHash,"From: <$PAGEEMAIL>\r\n");
    } else {
        echo "Wrong PW in check.php!"; //TODO better Error msg for wrong pw
    }
?>
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
            <h3>Check your Emails</h3>
            <form action="<?php
                            $page = $_GET["page"];
                            if ($page=="") {
                                echo "example.php";
                            } else {
                                if ($page=="create"){
                                    echo "../".$page.".php"."?newTitle=".$_GET["newTitle"];
                                } else {
                                    echo "../".$page.".php";
                                }
                            }
                            ?>" method="POST" autocomplete="off">
                <?php // forwarting post data
                    foreach ($_POST as $a => $b) {
                        echo '<input type="hidden" name="'.htmlentities($a).'" value="'.htmlentities($b).'">';
                    }
                ?>
                <!--<input style="display: none;" type="text" name="user" value="<?php echo $user ?>"/>
                <input style="display: none;" type="password" name="pw" value="<?php echo $pw ?>"/>-->
                <table>
                    <tr>
                        <td>
                            Email-Code:
                        </td>
                        <td>
                            <input type="password" name="code"/>
                        </td>
                    </tr>
                    <tr>
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
