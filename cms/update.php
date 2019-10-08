<?php
    session_start();
    include "includes/log.php";
    include "includes/mkfile.php";

    $title = $_REQUEST["pageTitle"];
    $html1 = $_REQUEST["html1"];
    $html2 = $_REQUEST["html2"];
	$dirName = $_REQUEST["pageName"];
    if ($dirName == ""){
        echo "Upload not posible!<br>The Images you are trying to upload are to big for your php upload settings.<br><br>";
        exit;
    }
    $dirName = preg_replace( '/[^a-zA-Z0-9]/', '', $dirName);
    $user = $_REQUEST["user"];
    $user = preg_replace( '/[^a-zA-Z0-9]/', '', $user);
    $pw = $_REQUEST["pw"];
    $code = $_REQUEST["code"];
    $code = preg_replace( '/[^a-zA-Z0-9]/', '', $code); 

    function credentialsExist($usr,$pass,$code) {
        /*$existence = false;
        if ((file_exists("login/tmp/".$usr)) && ($usr!="")){
            if (file_get_contents("login/tmp/".$usr) == $code){
                $pwHash = hash("sha256", $pass, false);
                $existence = (file_get_contents("login/users/".$usr) == $pwHash);
            }
            unlink("login/tmp/".$usr);
        }
        return $existence;*/
    
        return ($_SESSION["tempLonginCheck"] == "loggedIn");
    }

    function mkImgWebUrlByCmsID($id,$path){ // aka upload
      echo "trying to upload ".$id."<br>";
      if(!empty($_FILES[$id]))           // More about upload file info https://www.php.net/manual/en/features.file-upload.post-method.php
      {
        $path = $path . "/" . basename( $_FILES[$id]['name']);
        if(move_uploaded_file($_FILES[$id]['tmp_name'], $path)) {
          echo "The file ".basename( $_FILES[$id]['name'])." has been uploaded<br>";
        } else{
	      $path = "";
          echo "There was an error uploading the file ".$_FILES[$id]['name'].", please try again!";
        }
      } else {
        echo "<br>File not found<br>";
      }
      return $path;
    }

    function finalizePage($html,$dirImg){
	    $dom = new DOMDocument();
        $dom->encoding = 'UTF-16LE';
        
        //CmsSyb
        $html = preg_replace('/CmsSybl/i', 'CmsSCmsSCmsS', $html );
        $html = preg_replace('/&#60;|&lt;/i', 'CmsSyblLt', $html );
        $html = preg_replace('/&#62;|&gt;/i', 'CmsSyblGt', $html );
        $html = preg_replace('/&/i', 'CmsSyblAmp', $html );
        $html = preg_replace('/;/i', 'CmsSyblSmc', $html );
        $html = preg_replace('/"/i', 'CmsSyblQt', $html );
        $html = preg_replace('/\'/i', 'CmsSyblSqt', $html );
        $html = preg_replace('/</i', '&#60;', $html );
        $html = preg_replace('/>/i', '&#62;', $html );
        $html = htmlentities($html);
        $html = preg_replace('/&amp;#60;/i', '<', $html );
        $html = preg_replace('/&amp;#62;/i', '>', $html );
        $html = preg_replace('/CmsSyblAmp/i', '&', $html );
        $html = preg_replace('/CmsSyblSmc/i', ';', $html );
        $html = preg_replace('/CmsSyblQt/i', '"', $html );
        $html = preg_replace('/CmsSyblSqt/i', '\'', $html );

        $loadable = "<html><body>$html</body></html>";
        echo "<br><br><br>$loadable<br><br><br>";
	    $dom->loadHTML($loadable);
        echo "html is beeing parsed for img-tags<br>";

	    foreach ($dom->getElementsByTagName('img') as $img) {
		    // Check if image cms-link
		    $cmsID = $img->getAttribute("cmsid");
            echo "<br>checking for cmsID $cmsID ";
		    // if exists value is name of img-resoce in POST
		    if ($cmsID!=""){
                echo " -- found and trying to reset src";
			    $img->setAttribute( "src", mkImgWebUrlByCmsID($cmsID,$dirImg) ); 
		    }
            $img->removeAttribute("cmsid");
            echo "<br>";
	    }

        $newHtml = preg_replace('/<html><body>/i', '', preg_replace('/<\/body><\/html>/i', '', $dom->saveHTML() ) );

        $newHtml = preg_replace('/CmsSyblLt/i', '&lt;', $newHtml );
        $newHtml = preg_replace('/CmsSyblGt/i', '&gt;', $newHtml );
        $newHtml = preg_replace('/CmsSCmsSCmsS/i', 'CmsSybl', $newHtml );

	    return $newHtml;
    }

    echo "checking credentials<br>";
    if (!credentialsExist($user,$pw,$code)) {
        echo "Wrong PW! --- TODO nice Error for wrong pw<br>";
    } else {
        echo "PW OK<br>";
        if (!file_exists("../" . $dirName)){
            echo "Error \"".$dirName."\" dose not exist<br>";
        } else {
            if (($dirName!="cms") && ($dirName!="cms-template")){
                $dirName = "../" . $dirName;
                //check if dirName trys to wirte existing dir or contains '/'

                $dirDocs = $dirName . "/doc";
                $dirEN = $dirName . "/en";
                $dirImg = $dirName . "/img";

                // Update Base-Files
                // mkfile($dirName,"date",date("D M d, Y")); // Keep first date
                $banner = mkImgWebUrlByCmsID("uploadImg",$dirImg);
                if (strlen($banner)>3) mkfile($dirName,"bannerFileName", $banner,false);

                // Create Content-Files
                echo "trying to update files<br>";
                mkfile($dirEN,"html1",finalizePage($html1,$dirImg));
                mkfile($dirEN,"html2",finalizePage($html2,$dirImg));
                mkfile($dirEN,"title",$title);

                echo "Page <a href='$dirName'>$dirName</a> Updated<br>";
                //echo "<script> window.location.href = '$dirName'; </script>";
            } else {
                echo "Forbidden Operation!<br>";
            }
        }
    }
?>
