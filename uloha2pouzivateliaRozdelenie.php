<?php
    
    session_start();  
    if( isset($_SESSION['user'])){
    $prihlaseny = $_SESSION['user'];
    //echo $prihlaseny;
        
 require_once 'config.php';
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    mysqli_set_charset($conn,"utf8");
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
        
        
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
    $koncovka = "@is.stuba.sk";
    $prihl =$prihlaseny.$koncovka; 
       if(isset($_POST['rozdel'])){
           
           
          $predmetRokPrihlaseneho=  $_GET['id'] ;
           
           $pieces = explode("-", $predmetRokPrihlaseneho);
           $rokPrihlaseneho = $pieces[0]; 
           $predmetPrihlaseneho = $pieces[1];
           
           
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
           $kontrola = 0;
           
            $user_inputs=array();
               foreach(array_keys($menaPodlaTimu) as $i){
            
            
             $e=  $emailPodlaTimu[$i];
                   $kontrola+= $_POST['body'][$e]; 
             //echo  $_POST['body'][$e]; 
              
           } 
           
           if($kontrola != $body){
               echo "Zle si rozdelil body, skus este raz";
               //echo '<a href="http://www.someotherwebsit">spat</a>';
           }
           else{
            foreach(array_keys($menaPodlaTimu) as $i){
             $e=  $emailPodlaTimu[$i];
             //echo  $_POST['body'][$e]; 
                echo "<br>";
                $SQLvlozRozdelenie = "UPDATE uloha2admin
                                SET rozdelenie = '".$_POST['body'][$e]."'
                                WHERE '".$e."' = email and '".$rokPrihlaseneho."' = rok and '".$predmetPrihlaseneho."'=predmet";
            echo $sql;
            $result = $conn->query($SQLvlozRozdelenie); 
           }
               
             header('Location: /zaver/uloha2pouzivateliaSuhlas.php?id='.$predmetRokPrihlaseneho.'');  
               
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