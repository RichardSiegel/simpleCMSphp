<?php
include "../includes/log.php";
include "../includes/mkfile.php";

echo "File not active";
// do not leaf active for everyone on the internet

 //TODO Make posible only with user login
 //TODO Add Avatar-IMG-Upload
/*
    $mail = $_POST["mail"];
    $user = $_POST["user"];
    $user = preg_replace( '/[^a-zA-Z0-9]/', '', $user);
    $pw = $_POST["pw"];
    $displayName = $_POST["displayName"];

    if (file_exists("users/" . $user)){
        echo "Sorry, username already exists.";
    } else {
        $pwHash = hash("sha256", $pw, false);
        mkfile("users",$user,$pwHash);
        mkfile("mails",$user,$mail);
        mkfile("displayName",$user,$displayName);

        echo "<br>New User Created:<br>login: $user<br>mail: $mail<br>FullName: $displayName";
    }
*/
?>
