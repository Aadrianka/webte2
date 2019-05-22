<?php

function databaseConnect() {
    try {
        require 'config.php';
        $conn = new PDO("".$dbType.":host=$servername; dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $conn->exec("set names utf8");
        return $conn;
    }
    catch (PDOException $e) {
        $e->getMessage();
    }
}

function ldapLoginCheck($name, $password)
{
    $ldapStuSrv = 'ldap.stuba.sk';
    $ldapStuPort = '389';

    $ldapCon = ldap_connect($ldapStuSrv, $ldapStuPort);
    $ldapFrm = 'uid=' . strval($name) . ',ou=People,DC=stuba,DC=sk';
    ldap_set_option($ldapCon, LDAP_OPT_PROTOCOL_VERSION, 3);
    $auth = ldap_bind($ldapCon, $ldapFrm, $password);

    $ldapCon2 = ldap_connect($ldapStuSrv, $ldapStuPort);
    $sr = ldap_search($ldapCon2, "dc=stuba, dc =sk", "uid=" . $name);
    $info = ldap_get_entries($ldapCon2, $sr);

    if ($auth) {
        return $info[0]['uisid'][0];
    }
    else {
        return false;
    }
}

function logout($admin) {
    if(!$admin) {
        ldap_close();
    }
    unset($_SESSION['admin']);
    unset($_SESSION['user']);
}

function welcome($login) {
    echo '<div id="welcome">';
    if(!isset($_SESSION['lang']) || $_SESSION['lang'] == 'sk') {
        echo '<h3 class="display-3"> Vitajte <b>' . $login . '</b>, ste prihlásený!!</h3><script>showNothing();</script>';
        echo '<button name="logoutButt" id="logoutButt" class="btn btn-primary">Odhlásenie</button>';
    }
    else if ($_SESSION['lang'] == 'en') {
        echo '<h3 class="display-3">Welcome <b>' . $login . '</b>, you\'re logged in!!</h3><script>showNothing();</script>';
        echo '<button name="logoutButt" id="logoutButt" class="btn btn-primary">Log out</button>';
    }
    echo '</div>';
}

