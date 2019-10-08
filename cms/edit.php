<?php
    session_start();
    include "includes/log.php";
    $_SESSION["tempLonginCheck"] = "loggedIn";
?>

<html>
<head>
    <title>CMS</title>
    <style>
    body {
        margin: 0px;
    }

    .container {
      overflow: scroll;
      width: 30%;
      height: 100%;
      border-radius: 5px;
      background-color: #f2f2f2;
      padding: 20px;
      float: left;
    }

    .view {
        float: left;
        width: 70%;
        height: 100%;
    }

    * {
      box-sizing: border-box;
    }

    input[type=text], select, textarea {
      width: 100%;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 4px;
      resize: vertical;
    }

    label {
      padding: 12px 12px 12px 0;
      display: inline-block;
    }

    input[type=submit] {
      background-color: #4CAF50;
      color: white;
      padding: 12px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      float: right;
    }

    input[type=submit]:hover {
      background-color: #45a049;
    }

    .col-25, .col-75, input[type=submit] {
        width: 100%;
        margin-top: 0;
    }

    /* Clear floats after the columns */
    .row:after {
      content: "";
      display: table;
      clear: both;
    }
    #viewFrame {
        width: 100%;
        height: 100%;
        border: 0px;
    }
    table {
        padding: 5px;
    }
    </style>

<script>
    var pageNameSelect;
    var pageTitleEdit;
    var uploadImg;
    var pageHtml1Edit;
    var pageHtml2Edit;
    var viewFrame;
    var pageName = "404";

    function loadPage(){
        pageNameSelect = document.getElementById("pageName");
        pageTitleEdit = document.getElementById("pageTitle");
        uploadImg = document.getElementById("uploadImg");
        pageHtml1Edit = document.getElementById("html1");
        pageHtml2Edit = document.getElementById("html2");
        viewFrame = document.getElementById("viewFrame");

        uploadImg.value = "";
        pageName = pageNameSelect.options[pageNameSelect.selectedIndex].value;
        viewFrame.src="../"+pageName;

        //make edits visible
        Array.from(document.getElementById("form").getElementsByTagName("div")).forEach(function (row){
	        row.style.display = "block" ;
        });
    }

    function updateEdits(){
        var innerDoc = (viewFrame.contentDocument) ? viewFrame.contentDocument : viewFrame.contentWindow.document;
        pageTitleEdit.value = innerDoc.getElementsByClassName("parallax")[0].getElementsByTagName("h1")[0].innerHTML;
        pageHtml1Edit.value = innerDoc.getElementsByClassName("content")[0].getElementsByClassName("cmsContent")[0].innerHTML.trim();
        pageHtml2Edit.value = innerDoc.getElementsByClassName("content")[1].getElementsByClassName("container")[0].innerHTML.trim();
        allLinksNewTab();
    }

    function updateTitle(){
        var innerDoc = (viewFrame.contentDocument) ? viewFrame.contentDocument : viewFrame.contentWindow.document;
        setTimeout(
            function(){
                innerDoc.getElementsByClassName("parallax")[0].getElementsByTagName("h1")[0].innerHTML = pageTitleEdit.value;
                allLinksNewTab();
            }, 10);
    }

    function updateHtml1(){
        var innerDoc = (viewFrame.contentDocument) ? viewFrame.contentDocument : viewFrame.contentWindow.document;
        setTimeout(
            function(){
                innerDoc.getElementsByClassName("content")[0].getElementsByClassName("cmsContent")[0].innerHTML = pageHtml1Edit.value;
                allLinksNewTab();
            }, 10);
    }

    function updateHtml2(){
        var innerDoc = (viewFrame.contentDocument) ? viewFrame.contentDocument : viewFrame.contentWindow.document;
        setTimeout(
            function(){
                if (pageHtml2Edit.value == ""){
                    innerDoc.getElementsByClassName("content")[1].style.display = "none";
                } else {
                    innerDoc.getElementsByClassName("content")[1].style.display = "block";
                    innerDoc.getElementsByClassName("content")[1].getElementsByClassName("container")[0].innerHTML = pageHtml2Edit.value;
                }
                allLinksNewTab();
            }, 10);
    }

    var styleBackup = ["",""];
    function setBackground(){
        var innerDoc = (viewFrame.contentDocument) ? viewFrame.contentDocument : viewFrame.contentWindow.document;
        var img = uploadImg.value;
        console.log(uploadImg.files);
        var tmpURL = URL.createObjectURL(uploadImg.files[uploadImg.files.length-1]);
        var i = 0;
        Array.from(innerDoc.getElementsByClassName("parallax")).forEach(function(e) {
            if (styleBackup[i] == "") styleBackup[i] = e.getAttribute("style");
            e.setAttribute("style","background: url(\'" + tmpURL  + "\') 0px 0px!important;" + styleBackup[i]);
            i=i+1;
        });
    }

    imgCnt=-1;
    function incrementImgCnt(){
        imgCnt=imgCnt+1;
        document.cookie = "imgCnt="+imgCnt;
    }
    incrementImgCnt();

    function addImgLoader(obj){
        // add img to HTML
        var imgName = obj.value.replace(/^.*[\\\/]/, "").split(".")[0];
        var tmpURL = URL.createObjectURL(obj.files[obj.files.length-1]);
        var imgTag = "<img src=\'"+tmpURL+"\' alt=\'"+imgName+"\' class=\'center-block\' cmsID=\'"+obj.name+"\'>";
        var query = new RegExp("<[ ]*img[^>]*cmsid[ ]*=[ ]*['|\"]" + obj.name + "['|\"][^>]*>", "gi");
        if (pageHtml2Edit.value.search(query)>=0){
	        pageHtml2Edit.value = pageHtml2Edit.value.replace(query,imgTag);
        }else{
	        pageHtml2Edit.value = pageHtml2Edit.value + "\n" + imgTag;
        }
		// add new img-loader
        incrementImgCnt();  
        var node = document.createElement("input");
		node.name = "img"+imgCnt;
        node.type = "file";
        node.setAttribute("onchange", "addImgLoader(this)");
		var lable = document.createElement("b");
		lable.innerHTML = "<br>" + node.name + ": ";
		document.getElementById("imgLinks").appendChild(lable);
        document.getElementById("imgLinks").appendChild(node);
		updateHtml2();
    }

    function allLinksNewTab(){
        var innerDoc = (viewFrame.contentDocument) ? viewFrame.contentDocument : viewFrame.contentWindow.document;
        setTimeout(
            function(){
                Array.from(innerDoc.getElementsByTagName("a")).forEach(function(a){
                    if (!a.getAttribute("href").startsWith("#")){
                        a.setAttribute("target","_blank");
                    }
                });
            }, 100);
    }
    window.onbeforeunload = function() {
       return "Unpublished data will be lost if you leave!";
    };
</script>

</head>

<body>

<?php
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
        echo '
    <div class="container">
      <div class="row">
          <input type="text" id="newTitle" placeholder="New Page Title">
          <button onclick="window.location.href=\'login/index.php?page=create&newTitle=\' + document.getElementById(\'newTitle\').value">Create New</button>
      </div>
      <!--<form id="form" action="login/index.php?page=update" method="POST" enctype="multipart/form-data">-->
      <form id="form" action="update.php" method="POST" enctype="multipart/form-data" target="_blank">
      <div class="row">
        <div class="col-25">
          <label for="pageName"><h1>Simple Page-Editor</h1></label>
        </div>
        <div class="col-75">
          <select id="pageName" name="pageName" onchange="loadPage();">
            ';
                $dirs = scandir("..");
                foreach ($dirs as $dir)
                    if ((($dir!="cms") && ($dir!="cms-template")) && (strpos($dir, ".") == false) && (substr($dir, 0, 1)!="."))
                        print("<option value='" . $dir . "'>" . $dir . "</option>");
            echo '
          </select>
        </div>
      </div>
      <div class="row" style="display: none;">
        <div class="col-75">
          <input type="text" id="pageTitle" name="pageTitle" onkeydown="updateTitle()" placeholder="Enter Page-Title here ...">
        </div>
      </div>

      <div class="row" style="display: none;">
        <div class="col-75">
          <table>
            <tr>
                <td width="140px">New Background: </td>
                <td><input type="file" id="uploadImg" name="uploadImg" onchange="setBackground();"></td>
            </tr>
          </table>
        </div>
      </div>

      <div class="row" style="display: none;">
        <div class="col-75">
          <textarea id="html1" name="html1" placeholder="Enter some HTML here ..." onkeydown="updateHtml1()" style="height:200px"></textarea>
        </div>
      </div>
      <div class="row" style="display: none;">
        <div class="col-75">
          <textarea id="html2" name="html2" placeholder="Enter some HTML here ..." onkeydown="updateHtml2()" style="height:200px"></textarea>
        </div>
      </div>

      <div class="row" style="display: none;">
        <div id="imgLinks">
        <b>img0: </b>
        <input type="file" name="img0" onchange="addImgLoader(this)">
        </div>
      </div>

      <div class="row" style="display: none;">
        <input type="submit" value="Publish Changes">
      </div>
      </form>
    </div>

    <div class="view">
        <iframe id="viewFrame" src="../cms-template/" onload="updateEdits()"></iframe>
    </div>
</body>
';
    }
?>
</html>
