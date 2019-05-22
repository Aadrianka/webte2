<?php
require_once '../ldapfunctions.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conn = databaseConnect();

if (isset($_POST['action']) && !empty($_POST['action']) && $_POST['action'] == 'delete') {
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

if (isset($_POST['action']) && !empty($_POST['action']) && $_POST['action'] == 'show') {
    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sqlselect = "SELECT zahlavie FROM infohodnotenie WHERE idzahlavia=" . $_POST['id'];
        $result = $conn->prepare($sqlselect);
        $result->execute();
        $row = $result->fetch();
        $rowArray = explode(";", $row->zahlavie);
        echo '<div id="tableofcontentfile">';

        echo '<table class="table">   <thead class="thead-light">';
        echo '<tr>';
        foreach ($rowArray as $tablehead) {
            echo '<th scope="col">' . $tablehead . '</th>';
        }
        echo '</tr> </thead>';

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sqlselect = "SELECT id, menostudenta, poznamka FROM hodnotenie WHERE id_infohodnotenie=" . $_POST['id'];
        $result = $conn->prepare($sqlselect);
        $result->execute();

        while ($row = $result->fetch()) {
            echo '<tr>';
            echo '<td>' . $row->id . '</td>
                <td>' . $row->menostudenta . '</td>';
            $arrayPoznamka = explode(";", $row->poznamka);
            foreach($arrayPoznamka as $poznamka) {
                echo '<td>' . $poznamka . '</td>';
            }
            echo '</tr>';
        }
        echo '</table>';
        echo '</div>';
    } catch (PDOException $e) {
        echo $e->getMessage();
        return $e->getMessage();
    }
}