<?php

function loadconfigval($configfile){
    if (file_exists(dirname(__FILE__)."/../config/".$configfile)){
        return file_get_contents(dirname(__FILE__)."/../config/".$configfile,false);
    } else {
        return file_get_contents(dirname(__FILE__)."/../defaultconfig/".$configfile,false);
    }
}

function setupvars($includesPath){
    global $PAGETITLE;
    global $GLOBALHEADTAGS;
    global $DEFAULTBANNER;
    global $ICONFILE;
    global $DEFAULTLOGO;
    global $FOOTERTEXT;
    global $PAGEEMAIL;

    $PAGETITLE = loadconfigval("pagetitle");

    $GLOBALHEADTAGS = loadconfigval("globalheadtags");

    $DEFAULTBANNER = "$includesPath/".loadconfigval("defaultbanner");
    $ICONFILE = "$includesPath/".loadconfigval("defaulticon");
    $DEFAULTLOGO = "$includesPath/".loadconfigval("defaultlogo");

        $FOOTERTEXT = loadconfigval("footertext");
        preg_match('/<cmsdate.*format.*\/>/', $FOOTERTEXT, $dateArray);
        $cmsDateFormat = preg_split('/"/', preg_split('/<cmsdate.*format.*=[^"]*"/', $dateArray[0])[1])[0];
    $FOOTERTEXT = preg_replace('/<cmsdate.*format.*\/>/', date($cmsDateFormat), $FOOTERTEXT);

    $PAGEEMAIL = loadconfigval("pageemail");
}

function echoAuthorInfo($author,$info){
    if (!file_exists(dirname(__FILE__)."/../login/$info/$author")){
        echo "Unknown";
    } else {
        echo file_get_contents(dirname(__FILE__)."/../login/$info/$author",false);
    }
}
?>
