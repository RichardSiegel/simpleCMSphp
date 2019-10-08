<?php
$includesPath = "cms/includes";
include "$includesPath/setupvars.php";
setupvars($includesPath);
?>
<html lang="en">
<head>
  <title><?php print($PAGETITLE); ?> - Error</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>

<div class="jumbotron text-center">
  <h1>Sorry, something went wrong :(</h1>
  <p>The page you were trying to reach could not be loaded.</p>
  <h2><a href="javascript:window.history.back();">Go back one page</a></h2> 
</div>
  
<div class="text-center" style="padding-top: 30px; color:#555753;">
    <p><?php print($FOOTERTEXT); ?></p>
</div>
</body>
</html>
