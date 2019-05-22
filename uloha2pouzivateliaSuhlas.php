 <?php
    
    session_start();  
    if( isset($_SESSION['user'])){
    $prihlaseny = $_SESSION['user'];
    //echo $prihlaseny;   
        
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
          crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900|Quicksand:400,700|Questrial"
          rel="stylesheet"/>
    <link href="default.css" rel="stylesheet" type="text/css" media="all"/>
    <link href="fonts.css" rel="stylesheet" type="text/css" media="all"/>

    <!--[if IE 6]>
    <link href="default_ie6.css" rel="stylesheet" type="text/css"/><![endif]-->

</head>
    <body>
        <div class="wrapper">
            <div id="wrap">
            <div class="container">
<?php
        
if (isset($_GET["id"])){
    $predmetRokPrihlaseneho = $_GET["id"];
}
if (isset($_GET["rok"])){
     $predmetRokPrihlaseneho = $_GET["rok"];
}


 require_once 'config.php';
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    mysqli_set_charset($conn,"utf8");
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $koncovka = "@is.stuba.sk";
    $prihl =$prihlaseny.$koncovka;
//echo $prihl;
    
    $pieces = explode("-", $predmetRokPrihlaseneho);
$rokPrihlaseneho = $pieces[0]; 
$predmetPrihlaseneho = $pieces[1];
//echo "hahaha".$rokPrihlaseneho;

$SQLtim = "SELECT tim, body FROM uloha2admin WHERE '".$prihl."' = email and '".$rokPrihlaseneho."' = rok and '".$predmetPrihlaseneho."'=predmet";

    $result = $conn->query($SQLtim);

      $SQLtim = array();
      $SQLbody = array();

    if ($result->num_rows > 0) {
    // output data of each row
    while($res = $result->fetch_assoc()) {
         array_push($SQLtim, $res[tim]);
        array_push($SQLbody, $res[body]);
    }
    } else {
    echo "0 results";
    }  
echo "<br>";
$tim = $SQLtim[0];
$body = $SQLbody[0];
    
    
$SQLjeRozdelene = "SELECT rozdelenie FROM uloha2admin WHERE '".$tim."' = tim and '".$rokPrihlaseneho."' = rok and '".$predmetPrihlaseneho."'=predmet";  

    $result = $conn->query($SQLjeRozdelene);

      $jeRozdelene = array();

    if ($result->num_rows > 0) {
    // output data of each row
    while($res = $result->fetch_assoc()) {
         array_push($jeRozdelene, $res[rozdelenie]);
    }
    } else {
    echo "0 results";
    }  

   
    $SQLmenaPodlaTimu = "SELECT meno, email FROM uloha2admin WHERE '".$tim."' = tim";  
      $result = $conn->query($SQLmenaPodlaTimu);

      $menaPodlaTimu = array();
      $emailPodlaTimu = array();

    if ($result->num_rows > 0) {
    // output data of each row
    while($res = $result->fetch_assoc()) {
         array_push($menaPodlaTimu, $res[meno]);
         array_push($emailPodlaTimu, $res[email]);
    }
    } else {
    echo "0 results";
    }

 
        echo '<p>Sim tim '.$tim.' </p>';
        echo '<p>Vybrany rok - predmet '.$predmetRokPrihlaseneho.' </p>';
        echo '<p>Body mate rozdelene, prosim daj suhlas (ak si suhlasil, a nezobrazuje sa tvoj stav, refreshni stranku)</p>';
        
$SQLsuhlasAdmin = "SELECT suhlasAdmin FROM uloha2admin WHERE '".$prihl."' = email and '".$rokPrihlaseneho."' = rok and '".$predmetPrihlaseneho."'=predmet";  
      $result = $conn->query($SQLsuhlasAdmin);
        
      $suhlasAdmin = array();    

    if ($result->num_rows > 0) {
    // output data of each row
    while($res = $result->fetch_assoc()) {
         array_push($suhlasAdmin, $res[suhlasAdmin]);
    }
    } else {
    echo "0 results";
    }
        if ($suhlasAdmin[0] == null){
            echo '<p>Admin sa este neodsuhlasil rozdelenie bodov.</p>';
        }
        else if($suhlasAdmin[0] == 0){
            echo '<p>Admin zamietol vase rozdelenie bodov.</p>';
        }
        else if ($suhlasAdmin[0] == 1){
            echo '<p>Admin odsuhlasil vase rozdelenie bodov.</p>';
        }
        


//echo " <form method='post' action = 'uloha2pouzivateliaSuhlas.php?rok=".$predmetRokPrihlaseneho."'>";  
 echo "<form class=\"form-horizontal\" action='uloha2pouzivateliaSuhlas.php?rok=".$predmetRokPrihlaseneho."' method='post' name=\"upload_excel\"
                        enctype=\"multipart/form-data\"'>";  
//echo '<div class="table-responsive"><tableid="myTable" class="table table-striped table-bordered">';
echo '<div class="table-responsive"><table id="myTable" class="table table-striped table-bordered">';
//        echo '<table>';
//echo '<tr><thead>        
echo '<tr>
    <th>Meno</th>
    <th>Email</th> 
    <th>Rozdelenie</th>
    <th>Suhlasim</th>
  </tr>';
  //</tr></thead><tbody>';
foreach(array_keys($menaPodlaTimu) as $i) {

     echo '<tr>';
     echo '<td>'.$menaPodlaTimu[$i].'</td>';
     echo'<td>'.$emailPodlaTimu[$i].'</td>';
    echo '<td>'.$jeRozdelene[$i].'</td>';
    
    
     $SQLsuhlas = "SELECT suhlas FROM uloha2admin WHERE '".$emailPodlaTimu[$i]."' = email  and '".$tim."' = tim and '".$rokPrihlaseneho."' = rok and '".$predmetPrihlaseneho."'=predmet"; 
        $result = $conn->query($SQLsuhlas);
        $suhlasMeno = array();
        if ($result->num_rows > 0) {
            while($res = $result->fetch_assoc()) {
                array_push($suhlasMeno, $res[suhlas]);
             }}
    
    
    if($prihl == $emailPodlaTimu[$i]){
        if ($suhlasMeno[0] == null) {
            echo '<td><select name ="Suhlas"><option value="ano">Potvrdzujem</option><option value="nie">Nepotrdzujem</option></select></td>';
        }
        else if ($suhlasMeno[0] == "ano")
             echo '<td>Suhlasi</td>';
        else if ($suhlasMeno[0] == "nie")
             echo '<td>Nesuhlasi</td>';    
    }
    else{
        
        if ($suhlasMeno[0] == null) 
             echo '<td>Caka sa na odpoved</td>';
        else if ($suhlasMeno[0] == "ano") 
             echo '<td>Suhlasi</td>';
        else if ($suhlasMeno[0] == "nie") 
             echo '<td>Nesuhlasi</td>'; 
    }
     echo '</tr>';
}

echo '</table></div>';
//echo '</tbody></table></div>';
echo "<input type='submit' name='suhlas' value='Potvrd'>";
echo "</form>";
echo "<br>";
echo '<a href="uloha2pouzivatelia.php">spat</a>';

if(isset($_POST['suhlas'])){
    $suhlas= $_POST['Suhlas']; 
    if(isset($_GET['rok'])){
        $predmetRok = $_GET['rok'];
        $pieces = explode("-", $predmetRok);
        $rokPrihlaseneho = $pieces[0]; 
        $predmetPrihlaseneho = $pieces[1];
        //echo"<br>";
        
        $SQLupdateSuhlas = "UPDATE uloha2admin SET suhlas = '".$suhlas."' WHERE '".$prihl."' = email and '".$rokPrihlaseneho."' = rok and '".$predmetPrihlaseneho."'=predmet ";
        $result = $conn->query($SQLupdateSuhlas);
        //echo $_POST['Suhlas'];
        //header("Location: /test/uloha2pouzivatelia.php"); 
    
    }
}
  
 
    }
        else echo "nie si prihlaseny";




?>
  

           

            </div>
            </div>
        </div>
</body>
</html>