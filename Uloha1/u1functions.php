<?php
require_once 'ldapfunctions.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conn = databaseConnect();
if(!isset($_SESSION['lang']) || $_SESSION['lang'] == 'sk') {

    echo "
<div class=\"row\">
    <div class=\"col-sm-6\">
        <form action=\"Uloha1/u1loadfile.php\" method=\"post\" enctype=\"multipart/form-data\">
            <div class=\"form-group row\">
              <label for=\"inputState\">Rok</label>
              <select id=\"year\" class=\"form-control\"  name=\"year\">
                <option selected>Vyber...</option>
                <option>...</option>
              </select>
            </div>
    
             <div class=\"form-group row\">
                <label for=\"inputpredmet\">Názov predmetu</label>
                <input type=\"text\" class=\"form-control\" id=\"inputpredmet\" placeholder=\"napr. Webové technológie\"  name=\"predmet\">
             </div>    
               
              <div class=\"form-group row\">
                 <label for=\"formfile\">Vložte svoj .csv súbor</label>
                 <input type=\"file\" class=\"form-control-file\" id=\"formfile\" name=\"formfile\">
              </div> 
               
              <div class=\"form-group row\">
              <label for=\"inputState\">Separator</label>
              <select id=\"delimeter\" class=\"form-control\"  name=\"delimeter\">
                <option selected>Vyber...</option>
                <option value=';'>Bodkočiarka - \";\"</option>
                <option value=','>Čiarka - \",\"</option>
    
              </select>
            </div>
            
            <button type=\"submit\" class=\"btn btn-primary my-1\" name=\"Import\">Vloženie dát</button>
    
        </form>
    </div>
    ";
}else if ($_SESSION['lang'] == 'en') {
    echo "
<div class=\"row\">
    <div class=\"col-sm-6\">
        <form action=\"Uloha1/u1loadfile.php\" method=\"post\" enctype=\"multipart/form-data\">
            <div class=\"form-group row\">
              <label for=\"inputState\">Year</label>
              <select id=\"year\" class=\"form-control\"  name=\"year\">
                <option selected>Choose...</option>
                <option>...</option>
              </select>
            </div>
    
             <div class=\"form-group row\">
                <label for=\"inputpredmet\">Subject name</label>
                <input type=\"text\" class=\"form-control\" id=\"inputpredmet\" placeholder=\"for example. Web technologies\"  name=\"predmet\">
             </div>    
               
              <div class=\"form-group row\">
                 <label for=\"formfile\">Upload your .csv file</label>
                 <input type=\"file\" class=\"form-control-file\" id=\"formfile\" name=\"formfile\">
              </div> 
               
              <div class=\"form-group row\">
              <label for=\"inputState\">Delimeter</label>
              <select id=\"delimeter\" class=\"form-control\"  name=\"delimeter\">
                <option selected>Choose...</option>
                <option value=';'>Semicolon - \";\"</option>
                <option value=','>Comma - \",\"</option>
    
              </select>
            </div>
            
            <button type=\"submit\" class=\"btn btn-primary my-1\" name=\"Import\">Update your file data</button>
    
        </form>
    </div>
    ";
}
try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sqlselect = "SELECT DISTINCT ho.rok, ho.predmet, ih.idzahlavia FROM hodnotenie as ho JOIN infohodnotenie as ih ON ih.idzahlavia = ho.id_infohodnotenie";
    $result = $conn->prepare($sqlselect);
    $result->execute();
    if(!isset($_SESSION['lang']) || $_SESSION['lang'] == 'sk') {

        echo '<div class="col-sm-6">';
        echo '<table class="table">  
    <thead class="thead-light">';
        echo '<tr>';
        echo '<th scope="col">Názov predmetu</th><th scope="col">Rok</th><th scope="col">Vymazať</th>';
        echo '</tr>   </thead>   <tbody>';
        while ($row = $result->fetch()) {
            echo '<tr class="showInfo">';
            echo '<td>' . $row->predmet . '</td>
                <td>' . $row->rok . '</td>
                <td style="text-align: center;" id="' . $row->idzahlavia . '" class="deleteData">
                    <i style="cursor: pointer" class="deleteInfo fas fa-trash-alt"></i>
                </td>';
            echo '</tr>';
        }
        echo '  </tbody></table></div>';
        echo '<div class="row">';

        echo '<div id="infoTable">';
        echo '</div>';
        echo '</div>';
    } else if ($_SESSION['lang'] == 'en') {
        echo '<div class="col-sm-6">';
        echo '<table class="table">  
    <thead class="thead-light">';
        echo '<tr>';
        echo '<th scope="col">Subject </th><th scope="col">Year</th><th scope="col">Delete</th>';
        echo '</tr>   </thead>   <tbody>';
        while ($row = $result->fetch()) {
            echo '<tr class="showInfo">';
            echo '<td>' . $row->predmet . '</td>
                <td>' . $row->rok . '</td>
                <td style="text-align: center;" id="' . $row->idzahlavia . '" class="deleteData">
                    <i style="cursor: pointer" class="deleteInfo fas fa-trash-alt"></i>
                </td>';
            echo '</tr>';
        }
        echo '  </tbody></table></div>';
        echo '<div class="row">';

        echo '<div id="infoTable">';
        echo '</div>';
        echo '</div>';


        }
    } catch (PDOException $e) {
    echo $e->getMessage();
    return false;
}

?>