<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html lang="sk" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title></title>
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>
    <link href="style.css" rel="stylesheet" type="text/css" media="all" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900|Quicksand:400,700|Questrial"
          rel="stylesheet"/>
    <link href="default.css" rel="stylesheet" type="text/css" media="all"/>
    <link href="fonts.css" rel="stylesheet" type="text/css" media="all"/>

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
    $action = $_POST['action'];
    switch ($action) {
        case 'logout' :
            logout($_SESSION['admin']);
            break;
        case 'changeLanguage' :
            $_SESSION['lang'] = $_POST['lang'];
            break;
    }
}
?>
<script src="mainscript.js"></script>


<div id="header-wrapper">
    <div id="header" class="container">
        <div id="logo">
            <img src="images/stu.png" width="330" height="120" alt="logo"/>
        </div>

        <div id="menu">
            <ul>
                <?php if (!isset($_SESSION['lang']) || $_SESSION['lang'] == 'sk') : ?>

                <li class="active"><a href="index.php" accesskey="1" title="">Domov</a></li>
                <li><a href="uloha1.php" accesskey="2" title="">Uloha1</a></li>
                <li><a href="uloha2.php" accesskey="3" title="">Uloha2</a></li>
                <li><a href="uloha3/index.php" accesskey="4" title="">Uloha3</a></li>
                <li><a href="rozdel.php" accesskey="5" title="">Rozdelenie úloh</a></li>
                <?php elseif ($_SESSION['lang'] == 'en') : ?>
                    <li class="active"><a href="index.php" accesskey="1" title="">Home</a></li>
                    <li><a href="uloha1.php" accesskey="2" title="">Task 1</a></li>
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
        <div class="container" height="50px">
            <div class="row">
                <div class="well bs-component col-lg-12" id="choice">
                    <div id="typesignin">

                        <form class="form-horizontal" action="index.php" method="post">
                            <?php if (!isset($_SESSION['lang']) || $_SESSION['lang'] == 'sk') : ?>

                                <fieldset>
                                    <h3 class="display-3">Výberte typ prihlásenia</h3>
                                    <div class="form-group">

                                    <input type="button" class="loginBtn loginBtn--local fa fa-input" value="&#xf0c0 Admin"
                                           name="01">
                                    <input type="button" class="loginBtn loginBtn--LLDAP fa fa-input"
                                           value="&#xf2c2 Univerzitné konto" name="02">
                                    </div>
                                </fieldset>
                            <?php elseif ($_SESSION['lang'] == 'en') : ?>

                                <fieldset>
                                    <h3 class="display-3">Choose type of Sign in</h3>
                                    <input type="button" class="loginBtn loginBtn--local fa fa-input"
                                           value="&#xf0c0 Administrator" name="01">
                                    <input type="button" class="loginBtn loginBtn--LLDAP fa fa-input"
                                           value="&#xf2c2 University account" name="02">

                                </fieldset>
                            <?php endif; ?>

                        </form>
                    </div>
                </div>
                <div class="well bs-component col-lg-12" id="login" style="padding-top: 3% ;margin:5%;">
                    <form class="form-horizontal" action="index.php" method="post">
                        <?php if (!isset($_SESSION['lang']) || $_SESSION['lang'] == 'sk') : ?>

                            <fieldset>
                                <h3>Lokálne Prihlásenie</h3>

                                <div class="form-group">
                                    <label class="col-lg-2 control-label" for="loginLogin">Meno: </label>
                                    <div class="col-lg-10"><input class="form-control" type="text" id="loginLogin"
                                                                  name="loginLogin"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label" for="passLogin">Heslo: </label>
                                    <div class="col-lg-10"><input class="form-control" type="password" id="passLogin"
                                                                  name="passLogin"></div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-10 col-lg-offset-2">
                                        <input type="reset" class=" btn btn-outline-dark" value="Späť" name="backButton"
                                               id="backButtonLogin">
                                        <input type="submit" class="btn btn-primary" value="Odoslat" name="sendLogin"
                                               id="sendLogin"></div>
                                </div>
                            </fieldset>
                        <?php elseif ($_SESSION['lang'] == 'en') : ?>

                        <fieldset>
                            <h3>Local Sign in</h3>
                            <div class="form-group">
                                <label class="col-lg-2 control-label" for="loginLogin">Login: </label>
                                <div class="col-lg-10"><input class="form-control" type="text" id="loginLogin"
                                                              name="loginLogin"></div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label" for="passLogin">Password: </label>
                                <div class="col-lg-10"><input class="form-control" type="password" id="passLogin"
                                                              name="passLogin"></div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-10 col-lg-offset-2">
                                    <input type="reset" class=" btn btn-outline-dark" value="Back" name="backButton"
                                           id="backButtonLogin">
                                    <input type="submit" class="btn btn-primary" value="Sign In" name="sendLogin"
                                           id="sendLogin"></div>
                            </div>

                            <?php endif; ?>

                    </form>
                </div>
                <div class="well bs-component col-lg-12" id="LDAP" style="padding-top: 3% ; margin:5%;">

                    <form class="form-horizontal" action="index.php" method="post">
                        <?php if (!isset($_SESSION['lang']) || $_SESSION['lang'] == 'sk') : ?>
                            <fieldset>
                                <h3>Prihlásenie cez univerzitný účet</h3>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label" for="loginLDAP">Meno: </label>
                                    <div class="col-lg-10"><input class="form-control" type="text" id="loginLDAP"
                                                                  name="loginLDAP"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label" for="passLDAP">Heslo: </label>
                                    <div class="col-lg-10"><input class="form-control" type="password" id="passLDAP"
                                                                  name="passLDAP"></div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-10 col-lg-offset-2">
                                        <input type="reset" class="btn btn-outline-dark" value="Späť" name="backButton"
                                               id="backButtonLDAP">
                                        <input type="submit" class="btn btn-primary" value="Odoslat" name="sendLDAP"
                                               id="sendLDAP"></div>
                                </div>
                            </fieldset>
                        <?php elseif ($_SESSION['lang'] == 'en') : ?>
                            <fieldset>
                                <h3>Sign Up with University account</h3>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label" for="loginLDAP">Login: </label>
                                    <div class="col-lg-10"><input class="form-control" type="text" id="loginLDAP"
                                                                  name="loginLDAP"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label" for="passLDAP">Password: </label>
                                    <div class="col-lg-10"><input class="form-control" type="password" id="passLDAP"
                                                                  name="passLDAP"></div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-10 col-lg-offset-2">
                                        <input type="reset" class="btn btn-outline-dark" value="Back" name="backButton"
                                               id="backButtonLDAP">
                                        <input type="submit" class="btn btn-primary" value="Send" name="sendLDAP"
                                               id="sendLDAP"></div>
                                </div>
                            </fieldset>
                        <?php endif; ?>

                    </form>
                </div>
                <?php
                if (isset($_POST['loginLDAP']) && isset($_POST['passLDAP'])) {
                    $login = $_POST['loginLDAP'];
                    $password = $_POST['passLDAP'];
                    $aisid = ldapLoginCheck($login, $password);
                    if (!isset($_SESSION['user']) && $aisid != false) {
                        $_SESSION['user'] = $login;
                        $_SESSION['admin'] = false;
                        $_SESSION['aisid'] = $aisid;               //info o aisid prihlaseneho pouzivatela

                        welcome($_SESSION['user']);
                    }

                } else if (isset($_POST['loginLogin']) && isset($_POST['passLogin'])) {
                    $login = $_POST['loginLogin'];
                    $password = $_POST['passLogin'];
                    $users = LocalUser::fetchByLogin($conn, $login);
                    if ($users && sizeof($users) == 1) {
                        $user = $users[0];
                        if ($user->checkPassword($password)) {
                            if (!isset($_SESSION['user'])) {
                                $_SESSION['user'] = $login;
                                $_SESSION['admin'] = true;               //info o tom ze je prihlaseny admin , kontrolovat to ak chcem zobrazovat stranky ktore su len pre admina

                                welcome($_SESSION['user']);
                            }
                        } else {
                            if (!isset($_SESSION['lang']) || $_SESSION['lang'] == 'sk') {
                                echo '<h4>Zadali ste nesprávne heslo, prosím, skúste to znova.</h4><script>showLogin();</script>';
                            } else if ($_SESSION['lang'] == 'en') {
                                echo '<h4>Invalid password, try again please.</h4><script>showLogin();</script>';
                            }
                        }
                    } else {
                        if (!isset($_SESSION['lang']) || $_SESSION['lang'] == 'sk') {
                            echo '<h4>Používateľ s týmto menom neexistuje.</h4><script>showLogin();</script>';
                        } else if ($_SESSION['lang'] == 'en') {
                            echo '<h4>User with this name doesn\'t exist </h4><script>showLogin();</script>';

                        }
                    }

                } else if (!isset($_SESSION['user'])) {
                    echo '<script>showChoice();</script>';
                } else {
                    welcome($_SESSION['user']);
                }
                ?>
            </div>
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