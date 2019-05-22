<?php
/**
 * Created by PhpStorm.
 * User: Adrianka
 * Date: 19. 5. 2019
 * Time: 17:50
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function databaseConnect() {
    try {
        require('../config.php');
        $conn = new PDO("".$dbType.":host=$servername; dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $conn->exec("set names utf8");
        return $conn;
    } catch (PDOException $e) {
        $e->getMessage();
    }
}
$conn = databaseConnect();


if(isset($_POST["Import"])) {
    $delimeter = $_POST["delimeter"];
    $filename = $_FILES["formfile"]["tmp_name"];
    $rok = $_POST["year"];
    $predmet = $_POST["predmet"];

    if ($_FILES["formfile"]["size"] > 0) {
        $file = fopen($filename, "r");
        $counter = 0;

        while (($getData = fgetcsv($file, 1000, $delimeter)) != FALSE) {
            $num = count($getData);

            if ($counter == 0) {
                $data = implode(";", $getData);

                try {
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sqlselect = "INSERT INTO `infohodnotenie`(`zahlavie`) values  (:zahlavie)";
                    $result = $conn->prepare($sqlselect);
                    $result->bindParam(':zahlavie', $data);
                    $result->execute();
                    $id = $conn->lastInsertId();
                    $counter++;
                } catch (PDOException $e) {
                    echo $e->getMessage();
                    return false;
                }

            } else {
                $poznamka = [];

                for ($i = 2; $i < $num; $i++) {
                    array_push($poznamka, $getData[$i]);
                }
                $datafinal = implode(";", $poznamka);
                echo $datafinal . "\n";
                echo $id . "\n";

                try {
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sqlselect = "INSERT INTO `hodnotenie`(id,menostudenta,poznamka,id_infohodnotenie,rok, predmet) values  (:id,:menostudenta,:poznamka,:idzahlavie,:rok,:predmet)";
                    $result = $conn->prepare($sqlselect);
                    $result->bindParam(':id', $getData[0]);
                    $result->bindParam(':menostudenta', $getData[1]);
                    $result->bindParam(':poznamka', $datafinal);
                    $result->bindParam(':idzahlavie', $id);
                    $result->bindParam(':rok', $rok);
                    $result->bindParam(':predmet', $predmet);
                    $result->execute();
                } catch (PDOException $e) {
                    echo $e->getMessage();
                    return false;
                }
            }
        }
        header("Location: ../uloha1.php");
    }
}
?>