<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . "/include/mainMenu.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/moduls/viewMenu.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/moduls/viewTitle.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/moduls/showContent.php";

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href="/styles.css" rel="stylesheet">
    <title>Project - ведение списков</title>
</head>

<body>

    <div class="header">
    	<div class="logo"><img src="/i/logo.png" width="68" height="23" alt="Project"></div>
        <div class="clearfix"></div>
    </div>

    <div class="clear">
        <?php viewMenu ($menuItems, 'Increase', 'main-menu');?>
    </div>