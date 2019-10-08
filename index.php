<?php
$includesPath = "cms/includes";
include "$includesPath/setupvars.php";
setupvars($includesPath);
?>
<html lang="en">
<head>
    <?php print($GLOBALHEADTAGS); ?>
    <title><?php print($PAGETITLE); ?> - blog</title>
    <link rel="shortcut icon" href="<?php echo($ICONFILE); ?>">
</head>

<body>
<div class="jumbotron text-center">
  <h1><?php print($PAGETITLE); ?> - blog</h1>
  <p>Take a look at our latest articles</p> 
</div>
  
<div class="container">
    <div class='row'>
    <?php
        function isCMSpage($dir){
            $page = preg_replace('/\./','',$dir);
            return ((is_dir($page)) && ($page!="cms-template") && ($page!="cms"));
        }
        
        $dirs = scandir(".");

        $cnt = 0;
        $itemCntCol = intdiv(sizeof($dirs)-6,3);
        echo "<script>console.log('$itemCntCol');</script>";
        foreach ($dirs as $page)
            if (isCMSpage($page)){
                if ($cnt == 0) print("<div class='col-sm-4'>"); 
 
                $bannerFileName = mb_convert_encoding(file_get_contents($page."/bannerFileName"), 'HTML-ENTITIES', "UTF-8");
                if (strlen($bannerFileName) < 3){
                    $backgroundImg = $DEFAULTBANNER;
                } else {
                    $backgroundImg = "$page/$bannerFileName";
                }

                print("<div class='thumbnail'><a style='text-decoration:none;' href='".$page."'>");
                print('<img src="'.$backgroundImg.'" alt="thumbnail" style="width:100%;">');
                print("<div class='caption'>");
                print("<h2><b>".file_get_contents($page."/en/title",false)."</b></h2>");
                $txt = file_get_contents($page."/en/html1",false);
                $txt = preg_replace('/<[h][1-5][^>]*>/i','<h4>',$txt);
                $txt = preg_replace('/<\/[h][1-5]>/i','</h4>',$txt);
                $txt = preg_replace('/<[a][^[<]*<\/[a][ ]*>/i','',$txt);
                print("<p>".$txt."</p>");
                print("</div>");
                print("</a></div>");

                $cnt = $cnt + 1;
                if ($cnt == $itemCntCol) {
                    print("</div>"); 
                    $cnt = 0;
                }
            }
    ?>
    </div>
</div>

<div class="text-center" style="padding: 20px; color:#555753;">
    <p><?php print($FOOTERTEXT); ?></p>
</div>

</body>
</html>
