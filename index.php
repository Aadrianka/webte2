<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html lang="sk" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title></title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900|Quicksand:400,700|Questrial" rel="stylesheet" />
    <link href="default.css" rel="stylesheet" type="text/css" media="all" />
    <link href="fonts.css" rel="stylesheet" type="text/css" media="all" />

</head>
<body>
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'ldapfunctions.php';
require_once 'LocalUser.php';
require_once 'config.php';

$conn = databaseConnect();
session_start();
if (isset($_POST['action']) && !empty($_POST['action'])) {
    echo "aj tu";
    $action = $_POST['action'];
    switch ($action) {
        case 'logout' : logout(); echo 'Helo'; break;
    }
}
?>
<script src="mainscript.js"></script>

<div id="header-wrapper">
    <div id="header" class="container">
        <div id="logo">
            <img src="images/stu.png" width="330" height="120" alt="logo" />
        </div>
        <div id="menu">
            <ul>
                <li class="active"><a href="index.php" accesskey="1" title="">Domov</a></li>
                <li><a href="uloha1.php" accesskey="2" title="">Uloha1</a></li>
                <li><a href="uloha2.php" accesskey="3" title="">Uloha2</a></li>
                <li><a href="uloha3/" accesskey="4" title="">Uloha3</a></li>
                <li><a href="rozdel.php" accesskey="5" title="">Rozdelenie úloh</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="container">
    <div class="well bs-component col-lg-12" id="choice">
        <form class="form-horizontal" action="index.php" method="post">
            <fieldset>
                <h3>Výberte typ prihlásenia</h3>
                <input type="button" class="loginBtn loginBtn--local fa fa-input" value="&#xf0c0 Admin" name="01" >
                <input type="button" class="loginBtn loginBtn--LLDAP fa fa-input" value="&#xf2c2 LDAP Loogin" name="02" >

            </fieldset>
        </form>
    </div>
<div class="well bs-component col-lg-12" id="login">
    <form class="form-horizontal" action="index.php" method="post">
        <fieldset>
            <h3>Lokálne Prihlásenie</h3>
            <div class="form-group">
                <label class="col-lg-2 control-label" for="loginLogin">Login: </label>
                <div class="col-lg-10"><input class="form-control" type="text" id="loginLogin" name="loginLogin"> </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label" for="passLogin">Heslo: </label>
                <div class="col-lg-10"><input class="form-control" type="password" id="passLogin" name="passLogin"></div>
            </div>
            <div class="form-group"><div class="col-lg-10 col-lg-offset-2">
                    <input type="reset" class=" btn btn-default" value="Späť" name="backButton" id="backButtonLogin">
                    <input type="submit" class="btn btn-primary" value="Odoslat" name="sendLogin" id="sendLogin"></div>
            </div>
        </fieldset>
    </form>
</div>
<div class="well bs-component col-lg-12" id="LDAP">
    <form class="form-horizontal" action="index.php" method="post">
        <fieldset>
            <h3>LDAP Prihlásenie</h3>
            <div class="form-group">
                <label class="col-lg-2 control-label" for="loginLDAP">Login: </label>
                <div class="col-lg-10"><input class="form-control" type="text" id="loginLDAP" name="loginLDAP"> </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label" for="passLDAP">Heslo: </label>
                <div class="col-lg-10"><input class="form-control" type="password" id="passLDAP" name="passLDAP"></div>
            </div>
            <div class="form-group"><div class="col-lg-10 col-lg-offset-2">
                    <input type="reset" class="btn btn-default" value="Späť" name="backButton" id="backButtonLDAP">
                    <input type="submit" class="btn btn-primary" value="Odoslat" name="sendLDAP" id="sendLDAP"></div>
            </div>
        </fieldset>
    </form>
</div>
<?php
if (isset($_POST['loginLDAP']) && isset($_POST['passLDAP'])) {

    $login = $_POST['loginLDAP'];
    $password = $_POST['passLDAP'];
    if (ldapLoginCheck($login, $password)) {
        if (!isset($_SESSION['user'])) {
            $_SESSION['user'] = $login;
            $_SESSION['admin'] = false;

        }
        welcome($conn, $login);
    }
}
else if (isset($_POST['loginLogin']) && isset($_POST['passLogin'])) {
    $login = $_POST['loginLogin'];
    $password = $_POST['passLogin'];
    $users = LocalUser::fetchByLogin($conn, $login);
    if ($users && sizeof($users) == 1) {
        $user = $users[0];
        if ($user->checkPassword($password)) {
            if (!isset($_SESSION['user'])) {
                $_SESSION['user'] = $login;
                $_SESSION['admin'] = true;               //info o tom ze je prihlaseny admin , kontrolovat to ak chcem zobrazovat stranky ktore su len pre admina
            }
            welcome($conn, $login);
        } else
            echo '<h4>Zadali ste nesprávne heslo, prosím, skúste to znova.</h4><script>showLogin();</script>';
    } else
        echo '<h4>Používateľ s týmto menom neexistuje.</h4><script>showLogin();</script>';
}
else
    echo '<script>showChoice();</script>';

echo '<script>setListeners();</script>';

?>
</div>
</body>
</html>