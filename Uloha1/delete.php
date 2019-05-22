<?php
require_once '../ldapfunctions.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conn = databaseConnect();

if (isset($_POST['action']) && !empty($_POST['action'])) {
    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sqldelete = "DELETE FROM hodnotenie WHERE id_infohodnotenie=" . $_POST['id'];
        $result = $conn->prepare($sqldelete);
        $result->execute();
        $sqldelete = "DELETE FROM infohodnotenie WHERE idzahlavia=" . $_POST['id'];
        $result = $conn->prepare($sqldelete);
        $result->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
        return $e->getMessage();
    }
}