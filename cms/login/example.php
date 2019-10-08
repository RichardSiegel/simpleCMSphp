<?php include "../includes/log.php"; ?>
<?php
    $user = $_POST["user"];
    $user = preg_replace( '/[^a-zA-Z0-9]/', '', $user);
    $pw = $_POST["pw"];
    $code = $_POST["code"];
    $code = preg_replace( '/[^a-zA-Z0-9]/', '', $code);
    
    function credentialsExist($usr,$pass,$code) {
        $existence = false;
        if ((file_exists("tmp/".$usr)) && ($usr!="")){
            if (file_get_contents("tmp/".$usr) == $code){
                $pwHash = hash("sha256", $pass, false);
                $existence = (file_get_contents("users/".$usr) == $pwHash);
            }
            unlink("tmp/".$usr);
        }
        return $existence;
    }

    if (!credentialsExist($user,$pw,$code)) {
        echo "Wrong PW! --- TODO nice Error for wrong pw";
    } else {
        echo "You're now logged in";
    }
?>
