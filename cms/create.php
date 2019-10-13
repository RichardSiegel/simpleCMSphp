<?php
    include "includes/log.php";
    include "includes/mkfile.php";

    $user = $_POST["user"];
    $user = preg_replace( '/[^a-zA-Z0-9]/', '', $user);
    $pw = $_POST["pw"];
    $code = $_POST["code"];
    $code = preg_replace( '/[^a-zA-Z0-9]/', '', $code);
    
    function credentialsExist($usr,$pass,$code) {
        $existence = false;
        if ((file_exists("login/tmp/".$usr)) && ($usr!="")){
            if (file_get_contents("login/tmp/".$usr) == $code){
                $pwHash = hash("sha256", $pass, false);
                $existence = (file_get_contents("login/users/".$usr) == $pwHash);
            }
            unlink("login/tmp/".$usr);
        }
        return $existence;
    }

    if (!credentialsExist($user,$pw,$code)) {
        echo "Wrong PW! --- TODO nice Error for wrong pw";
    } else {

        $newTitle = $_GET["newTitle"];
        $dirName = preg_replace( '/[^a-zA-Z0-9]/', '', $newTitle);

        if (strpos($dirName, '/')){
            echo "Error trying to change dir";
        } else {
            if (file_exists("../" . $dirName)){
                echo "Error \"".$dirName."\" exists";
            } else {
                $dirName = "../" . $dirName;
                // TODO check if dirName trys to wirte existing dir or contains '/'

                // Setup subdirs
                $dirEN = $dirName . "/en";
                $dirDocs = $dirName . "/doc";
                $dirImg = $dirName . "/img";
                mkdir($dirDocs, 0755, true);
                mkdir($dirImg, 0755, true);

                // save Author
                mkfile($dirName,"author",$user);

                // Create Base-Files
                $file = "index.php";
                mkfile($dirName,$file,'<?php include "../cms-template/index.php"; ?>');
                mkpublic($dirName,$file);
                mkfile($dirName,"date",date("D M d, Y"));
                mkfile($dirName,"bannerFileName","");

                // Create Content-Files
                mkfile($dirEN,"html1","<h2>Coming soon ...</h2><p>This article is currently being created.</p>");
                mkfile($dirEN,"html2","");
                mkfile($dirEN,"title",$newTitle);

                echo "Page \"".$dirName."\" created";
            }
        }
    }
?>
