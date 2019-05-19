<?php

//include "../config.php";

$dbType = 'mysql';
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "team";
$dsn        = "mysql:host=$servername;dbname=$dbname;charset=utf8";
$options    = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
);
$conn = new PDO($dsn, $username, $password, $options);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);