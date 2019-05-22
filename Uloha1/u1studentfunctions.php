<?php
/**
 * Created by PhpStorm.
 * User: Adrianka
 * Date: 20. 5. 2019
 * Time: 14:05
 */
require_once 'ldapfunctions.php';

$conn = databaseConnect();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sqlselect = "SELECT poznamka, id_infohodnotenie, rok, predmet from hodnotenie WHERE id=:id";
    $result = $conn->prepare($sqlselect);
    $result->bindParam(':id', $_SESSION['aisid']);
    $result->execute();
    $poleudajov = [];

    while ($row = $result->fetch()) {
        array_push($poleudajov,(array)$row);

    }
    $polezahlavi = [];
    foreach ($poleudajov as $riadok) {
        $sql = "SELECT zahlavie from infohodnotenie WHERE idzahlavia=:id";
        $result = $conn->prepare($sql);
        $result->bindParam(':id', $riadok['id_infohodnotenie']);
        $result->execute();
        array_push($polezahlavi, (array)$result->fetch());

    }
    $num = count($poleudajov);
    for ($i = 0; $i < $num; $i++) {
        generateTable($poleudajov[$i], $polezahlavi[$i]);
    }
} catch (PDOException $e) {
    echo $e->getMessage();
    return false;

}

function generateTable($udaj, $zahlavie) {
    echo '<div id="studenttable">';
    echo '<div class="well bs-component col-lg-12">';
    echo '<h4>' . $udaj['predmet'] . ' (' . $udaj['rok'] . ')</h4>';
    echo '<table class="table">';
    echo '<thead class="thead-light">';
    $headers = explode(";",$zahlavie['zahlavie']);
    $num = count($headers);
    echo '<tr>';
    for($i=2;$i<$num;$i++){
        echo '<th scope="col">' .$headers[$i]. '</th>';
    }
    echo '</tr>';
    echo '  </thead>   <tbody>';
    $data = explode(";", $udaj['poznamka']);
    echo '<tr>';
    foreach ($data as $dat) {
        echo '<td>' . $dat . '</td>';
    }
    echo '</tr>   </tbody>';
    echo '</table></div></div>';
}
?>