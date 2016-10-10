<?php
include "lib/constants.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Bob's Advising Plan</title>
        <meta charset="utf-8">
        <meta name="author" content="Bob Erickson">
        <meta name="description" content="A system to help with making a four year plan of classes to take.">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!--[if lt IE 9]>
        <script src="//html5shim.googlecode.com/sin/trunk/html5.js"></script>
        <![endif]-->

        <link rel="stylesheet" href="css/base.css" type="text/css" media="screen">
        <link rel="stylesheet" href="css/custom.css" type="text/css" media="screen">

        <?php

        // %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
        //
        // inlcude all libraries. 
        // %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
        print "<!-- require Database.php -->";
        require_once(BIN_PATH . '/Database.php');
        // %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
        //
        // Set up database connection
        //
        // generally you dont need the admin on the web
        print "<!-- make Database connections -->";
        $dbName = DATABASE_NAME;
        
        $dbUserName = get_current_user() . '_reader';
        $whichPass = "r"; //flag for which one to use.
        $thisDatabaseReader = new Database($dbUserName, $whichPass, $dbName);
        
        $dbUserName = get_current_user() . '_writer';
        $whichPass = "w";
        $thisDatabaseWriter = new Database($dbUserName, $whichPass, $dbName);
        
        $dbUserName = get_current_user() . '_admin';
        $whichPass = "a";
        $thisDatabaseAdmin = new Database($dbUserName, $whichPass, $dbName);
        ?>	

    </head>

    <!-- **********************     Body section      ********************** -->
    <?php
    print '<body id="' . $PATH_PARTS['filename'] . '">';
    include "header.php";
    include "nav.php";
    ?>