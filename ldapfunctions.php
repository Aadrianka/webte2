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
    $ldapFrm = 'uid=' . $name . ',ou=People,DC=stuba,DC=sk';
    ldap_set_option($ldapCon, LDAP_OPT_PROTOCOL_VERSION, 3);
    $auth = ldap_bind($ldapCon, $ldapFrm, $password);
    if ($auth) {
        return true;
    }
    else {
        return false;
    }
}

function logout() {
    ldap_close();
    session_unset();
}

function welcome($conn, $login) {
    echo '<h3>Vitajte <b>'.$login.'</b>, ste prihlásený!!</h3><script>showNothing();</script>';
    echo '<button name="logoutButt" id="logoutButt" class="btn btn-primary">Odhlásenie</button>';
}

