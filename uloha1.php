<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title></title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link href="style.css" rel="stylesheet" type="text/css" media="all" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>

    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900|Quicksand:400,700|Questrial" rel="stylesheet" />
    <link href="default.css" rel="stylesheet" type="text/css" media="all" />
    <link href="fonts.css" rel="stylesheet" type="text/css" media="all" />

    <!--[if IE 6]><link href="default_ie6.css" rel="stylesheet" type="text/css" /><![endif]-->

</head>
<body>

<?php
session_start();
?>
<script src="mainscript.js"></script>

<div id="header-wrapper">
    <div id="header" class="container">
        <div id="logo">
            <img src="images/stu.png" width="330" height="120" alt="logo" />
        </div>
        <div id="menu">
            <ul>
                <?php if (!isset($_SESSION['lang']) || $_SESSION['lang'] == 'sk') : ?>

                    <li ><a href="index.php" accesskey="1" title="">Domov</a></li>
                    <li class="active"><a href="uloha1.php" accesskey="2" title="">Uloha1</a></li>
                    <li><a href="uloha2.php" accesskey="3" title="">Uloha2</a></li>
                    <li><a href="uloha3/index.php" accesskey="4" title="">Uloha3</a></li>
                    <li><a href="rozdel.php" accesskey="5" title="">Rozdelenie úloh</a></li>
                <?php elseif ($_SESSION['lang'] == 'en') : ?>
                    <li ><a href="index.php" accesskey="1" title="">Home</a></li>
                    <li class="active"><a href="uloha1.php" accesskey="2" title="">Task 1</a></li>
                    <li><a href="uloha2.php" accesskey="3" title="">Task 2</a></li>
                    <li><a href="uloha3/index.php" accesskey="4" title="">Task 3</a></li>
                    <li><a href="rozdel.php" accesskey="5" title="">Divisions tasks</a></li>
                <?php endif; ?>

            </ul>
        </div>
    </div>
</div>
<div class="wrapper">
    <div id="wrap">
        <div class="container" style="padding-top:3%;">


            <?php
                if(isset($_SESSION['admin']) && $_SESSION['admin']) {
                    require 'Uloha1/u1functions.php';
                }
                else if(isset($_SESSION['admin']) && !$_SESSION['admin']){
                    require 'Uloha1/u1studentfunctions.php';
                }

                ?>
                <script src="Uloha1/u1script.js"></script>

        </div>
    </div>
</div>
<div class="sticky-footer">
    <img id="sk" style="width: 50px" alt="SK" src="images/sk.png">
    <img id="en" style="width: 50px" alt="EN" src="images/gb.jpg">
</div>
<script>setListeners();</script>
</body>

</html>