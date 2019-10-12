<?php
$includesPath = "../cms/includes";
include "$includesPath/log.php"; // logging page views
include "$includesPath/setupvars.php";
setupvars($includesPath);

// prevent from displaying raw template file page
$urlPage = preg_replace('/.*\//', '', preg_replace('/^(\/)|\/$/', '', $_SERVER['REQUEST_URI']));
if ($urlPage == basename(__DIR__)){
    echo '<script> window.location.href = "../error.php"; </script>';
    include("../error.php");
    die;
}

// loading page content
$lang = "en";
$author = mb_convert_encoding(file_get_contents("author"), 'HTML-ENTITIES', "UTF-8");
$title = mb_convert_encoding(file_get_contents($lang . "/title"), 'HTML-ENTITIES', "UTF-8");
$html1 = mb_convert_encoding(file_get_contents($lang . "/html1"), 'HTML-ENTITIES', "UTF-8");
$html2 = mb_convert_encoding(file_get_contents($lang . "/html2"), 'HTML-ENTITIES', "UTF-8");
$bannerFileName = mb_convert_encoding(file_get_contents("bannerFileName"), 'HTML-ENTITIES', "UTF-8");
    if (strlen($bannerFileName)<4){
        $backgroundImg = "&quot;$DEFAULTBANNER&quot;";
    } else {
        $backgroundImg = "&quot;" . $bannerFileName . "&quot;";
    }
$date = mb_convert_encoding(file_get_contents("date"), 'HTML-ENTITIES', "UTF-8");
    if (!empty($date)){
        $date = "<br>(Published: " . $date . ")";
    }

$ogDescription = preg_replace('/<[^>]*>/i','', preg_replace('/<[a][^[<]*<\/[a][ ]*>/i','',$html1));
$ogUrl = 'https://'.$_SERVER['HTTP_HOST'].preg_replace('/\/[^\/]*$/i','',$_SERVER['PHP_SELF']);
$ogImage = $ogUrl."/".preg_replace('/&quot;/i','',preg_replace('/^[^\/]*\/[^\/]*\//i','',$backgroundImg));
?>

<html class="no-js" lang="en">
    <head prefix="og: http://ogp.me/ns# article: http://ogp.me/ns/article#">      
        <title><?php echo("$PAGETITLE - $title"); ?></title>
        <link rel="shortcut icon" href="<?php echo($ICONFILE); ?>">

        <!-- open graph tags -->
        <meta property="og:title" content="<?php echo($title); ?>" />
        <meta property="og:site_name" content="<?php echo($PAGETITLE); ?>">
        <meta property="og:locale" content="en_US">
        <meta property="og:type" content="article">
        <meta property="article:tag" content="<?php echo($title); ?>">
        <meta property="og:description" content="<?php echo($ogDescription); ?>" />
        <meta property="og:url" content="<?php echo $ogUrl ?>" />
        <meta property="og:image" content="<?php echo $ogImage; ?>" />
        <!--
		    <meta property="og:image:width" content="3200">
		    <meta property="og:image:height" content="2400">
            <meta property="og:image:secure_url" content="<?php echo $ogImage; ?>">
            <meta property="og:image:type" content="image/png">
            <meta property="article:published_time" content="1972-06-18">
            <meta property="article:author" content="http://examples.opengraphprotocol.us/profile.html">
            <meta property="article:section" content="Front page">
        -->

      <!--[if !IE]><!-->
        <link rel="stylesheet" href="../cms-template/base.css">
        <link rel="stylesheet" href="../cms-template/style.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Slab">
        <?php echo($GLOBALHEADTAGS); ?>
      <!--<![endif]-->
      <!--[if IE]>
      <![endif]--> <!-- TODO ADD <link rel="stylesheet" href="ie-basic.css"> -->
    </head>

    <body>
        <!-- Only visible in IE -->
        <div id="ie">
            <div class="container">
                <center>
                    <b>Warning!</b> Your browser does not support this Website:
                    <b>Try <a href="https://www.google.com/chrome/">Google-Chrome</a> or <a href="https://www.mozilla.org">Firefox</a>!</b>
                </center>
            </div>
        </div>

        <!-- Header-Line -->
        <div class="wrapper">
            <div id="header">
                <div class="container">
                    <div id="companyName">
                        <a href="../">
                            <img src="<?php echo $DEFAULTLOGO; ?>" alt="<?php echo($PAGETITLE); ?>">
                        </a>
                    </div>
                    <div id="menu">
                        <a href="../">
                            <img src="../cms-template/img/menu.svg" alt="menu">
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <main>    
            <section class="module parallax" style="background: linear-gradient(rgba(0, 0, 0, 0.1),rgba(0, 0, 0, 0.5)), url(<?php echo $backgroundImg; ?>) 50% 50% no-repeat; background-size: cover;">
                <div class="container">
                    <h1><?php echo $title; ?></h1>
                </div>
            </section>
            <section class="module content" style="background: rgba(200, 200, 255, 1);">
                <div class="container">
                    <div class="subContainer">
                        <div class="author">
	                        <div class="avatar" style="background: url(<?php echo "$includesPath/../login/avatar/$author.jpg"; ?>) 50% 50% no-repeat; background-size: cover;"></div>
	                        <div class="authorText">
                            by <a href="<?php echoAuthorInfo($author,'href'); ?>"><?php echoAuthorInfo($author,"displayName"); ?></a>
                                <small><?php echo $date; ?></small>
                            </div>
                        </div>
                        <div class="cmsContent">
                            <?php echo $html1; ?>
                        </div>
                    </div>
                </div>
            </section>
            <section class="module content" style="display: <?php if (!empty($html2)) echo 'block'; else echo 'none'; ?>">
                <div class='container' style="padding-bottom: 40px;">
                    <?php echo $html2; ?>
                </div>
            </section>




            <section class="module parallax" style="background: url(<?php echo $backgroundImg; ?>) 50% 50% no-repeat; background-size: cover; padding: 0px;">
                <div id="prefootter"></div>
            </section>
        </main>
        <div id="footter" style="padding: 20px;">
            <?php echo($FOOTERTEXT); ?>
        </div>
        <!-- TODO ADD js -->
        <!--[if !IE]><!-->
        <!--<script src="../cms-template/animation.js"></script>-->
        <!--<![endif]-->
    </body>
</html>
