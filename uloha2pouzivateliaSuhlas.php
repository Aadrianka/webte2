<?php

session_start();
if (isset($_SESSION['user'])){
$prihlaseny = $_SESSION['user'];
//echo $prihlaseny;

?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

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
<script src="mainscript.js"></script>
<div id="header-wrapper">


    <div id="header" class="container">
        <div id="logo">
            <img src="images/stu.png" width="330" height="120" alt="logo"/>
        </div>
        <div id="menu">
            <ul>

                <?php if (!isset($_SESSION['lang']) || $_SESSION['lang'] == 'sk') : ?>

                <li ><a href="index.php" accesskey="1" title="">Domov</a></li>
                <li><a href="uloha1.php" accesskey="2" title="">Uloha1</a></li>
                <li class="active"><a href="uloha2.php" accesskey="3" title="">Uloha2</a></li>
                <li><a href="uloha3/index.php" accesskey="4" title="">Uloha3</a></li>
                <li><a href="rozdel.php" accesskey="5" title="">Rozdelenie �loh</a></li>
                <?php elseif ($_SESSION['lang'] == 'en') : ?>
                    <li><a href="index.php" accesskey="1" title="">Home</a></li>
                    <li><a href="uloha1.php" accesskey="2" title="">Task 1</a></li>
                    <li class="active"><a href="uloha2.php" accesskey="3" title="">Task 2</a></li>
                    <li><a href="uloha3/index.php" accesskey="4" title="">Task 3</a></li>
                    <li><a href="rozdel.php" accesskey="5" title="">Divisions task</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>
<div class="wrapper">
<div class="container">
<div class="row">
    <?php

    if (isset($_GET["id"])) {
        $predmetRokPrihlaseneho = $_GET["id"];
    }
    if (isset($_GET["rok"])) {
        $predmetRokPrihlaseneho = $_GET["rok"];
    }


    require_once 'config.php';
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    mysqli_set_charset($conn, "utf8");
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $koncovka = "@is.stuba.sk";
    $prihl = $prihlaseny.$koncovka;
    //echo $prihl;

    $pieces = explode("-", $predmetRokPrihlaseneho);
    $rokPrihlaseneho = $pieces[0];
    $predmetPrihlaseneho = $pieces[1];
    //echo "hahaha".$rokPrihlaseneho;
    //echo $prihl."prihlaseny";
    

    $SQLtim = "SELECT tim, body FROM uloha2admin WHERE '" . $prihl . "' = email and '" . $rokPrihlaseneho . "' = rok and '" . $predmetPrihlaseneho . "'=predmet";

    $result = $conn->query($SQLtim);

    $SQLtim = array();
    $SQLbody = array();

    if ($result->num_rows > 0) {
        // output data of each row
        while ($res = $result->fetch_assoc()) {
            array_push($SQLtim, $res[tim]);
            array_push($SQLbody, $res[body]);
        }
    } else {
        echo "0 results";
    }
    echo "<br>";
    $tim = $SQLtim[0];
    $body = $SQLbody[0];


    $SQLjeRozdelene = "SELECT rozdelenie FROM uloha2admin WHERE '" . $tim . "' = tim and '" . $rokPrihlaseneho . "' = rok and '" . $predmetPrihlaseneho . "'=predmet";

    $result = $conn->query($SQLjeRozdelene);

    $jeRozdelene = array();

    if ($result->num_rows > 0) {
        // output data of each row
        while ($res = $result->fetch_assoc()) {
            array_push($jeRozdelene, $res[rozdelenie]);
        }
    } else {
        echo "0 results";
    }


    $SQLmenaPodlaTimu = "SELECT meno, email FROM uloha2admin WHERE '" . $tim . "' = tim  and '" . $rokPrihlaseneho . "' = rok and '" . $predmetPrihlaseneho . "'=predmet";
    $result = $conn->query($SQLmenaPodlaTimu);

    $menaPodlaTimu = array();
    $emailPodlaTimu = array();

    if ($result->num_rows > 0) {
        // output data of each row
        while ($res = $result->fetch_assoc()) {
            array_push($menaPodlaTimu, $res[meno]);
            array_push($emailPodlaTimu, $res[email]);
        }
    } else {
        echo "0 results";
    }

    if (!isset($_SESSION['lang']) || $_SESSION['lang'] == 'sk') :
    echo '<p>Si tím ' . $tim . ' </p>';
    echo '<p>Vybraný rok - predmet: ' . $predmetRokPrihlaseneho . ' </p>';
    echo '<p>Body máte rozdelené, prosím daj súhlas (ak si súhlasil, a nezobrazuje sa tvoj stav, refreshni stránku)</p>';
    elseif ($_SESSION['lang'] == 'en') :
    echo '<p>You are team ' . $tim . ' </p>';
    echo '<p>Chosen year-subject: ' . $predmetRokPrihlaseneho . ' </p>';
    echo '<p>Your points are devided, please confirm (if you have cofnrimed and your state is not showing, refresh page)</p>';
    endif;

    $SQLsuhlasAdmin = "SELECT suhlasAdmin FROM uloha2admin WHERE '" . $prihl . "' = email and '" . $rokPrihlaseneho . "' = rok and '" . $predmetPrihlaseneho . "'=predmet";
    $result = $conn->query($SQLsuhlasAdmin);

    $suhlasAdmin = array();

    if ($result->num_rows > 0) {
        // output data of each row
        while ($res = $result->fetch_assoc()) {
            array_push($suhlasAdmin, $res[suhlasAdmin]);
        }
    } else {
        echo "0 results";
    }

    if ($suhlasAdmin[0] == null) {
        if (!isset($_SESSION['lang']) || $_SESSION['lang'] == 'sk') :
        echo '<p>Admin sa ešte neodsúhlasil rozdelenie bodov.</p>';
        elseif ($_SESSION['lang'] == 'en') :
            echo '<p>Admin has not confirmed your point dividing.</p>';
        endif;
    } else if ($suhlasAdmin[0] == 0) {
        if (!isset($_SESSION['lang']) || $_SESSION['lang'] == 'sk') :
        echo '<p>Admin zamietol vaše rozdelenie bodov.</p>';
        elseif ($_SESSION['lang'] == 'en') :
            echo '<p>Admin has declined your point dividing.</p>';
        endif;
    } else if ($suhlasAdmin[0] == 1) {
        if (!isset($_SESSION['lang']) || $_SESSION['lang'] == 'sk') :
        echo '<p>Admin odsúhlasil vaše rozdelenie bodov.</p>';
        elseif ($_SESSION['lang'] == 'en') :
            echo '<p>Admin has approved your point dividing.</p>';
        endif;
    }


    //echo " <form method='post' action = 'uloha2pouzivateliaSuhlas.php?rok=".$predmetRokPrihlaseneho."'>";
    echo "<form class=\"form-horizontal\" action='uloha2pouzivateliaSuhlas.php?rok=" . $predmetRokPrihlaseneho . "' method='post' name=\"upload_excel\"
                        enctype=\"multipart/form-data\"'>";
    //echo '<div class="table-responsive"><tableid="myTable" class="table table-striped table-bordered">';
    echo '<div class="table-responsive"><table id="myTable" class="table table-striped table-bordered">';
    //        echo '<table>';
    //echo '<tr><thead>
    if (!isset($_SESSION['lang']) || $_SESSION['lang'] == 'sk') :
    echo '<tr>
    <th>Meno</th>
    <th>Email</th> 
    <th>Rozdelenie</th>
    <th>Súhlasim</th>
  </tr>';
    elseif ($_SESSION['lang'] == 'en') :
    echo '<tr>
    <th>Name</th>
    <th>Email</th> 
    <th>Points</th>
    <th>Confirmation</th>
  </tr>';
    endif;
    //</tr></thead><tbody>';
    foreach (array_keys($menaPodlaTimu) as $i) {

        echo '<tr>';
        echo '<td>' . $menaPodlaTimu[$i] . '</td>';
        echo '<td>' . $emailPodlaTimu[$i] . '</td>';
        echo '<td>' . $jeRozdelene[$i] . '</td>';


        $SQLsuhlas = "SELECT suhlas FROM uloha2admin WHERE '" . $emailPodlaTimu[$i] . "' = email  and '" . $tim . "' = tim and '" . $rokPrihlaseneho . "' = rok and '" . $predmetPrihlaseneho . "'=predmet";
        $result = $conn->query($SQLsuhlas);
        $suhlasMeno = array();
        if ($result->num_rows > 0) {
            while ($res = $result->fetch_assoc()) {
                array_push($suhlasMeno, $res[suhlas]);
            }
        }

        if (!isset($_SESSION['lang']) || $_SESSION['lang'] == 'sk') :
        if ($prihl == $emailPodlaTimu[$i]) {
            if ($suhlasMeno[0] == null) {
                echo '<td><select name ="Suhlas" width = "auto"><option value="ano">Potvrdzujem</option><option value="nie">Nepotrdzujem</option></select></td>';
            } else if ($suhlasMeno[0] == "ano")
                echo '<td>Suhlasi</td>';
            else if ($suhlasMeno[0] == "nie")
                echo '<td>Nesuhlasi</td>';
        } else {

            if ($suhlasMeno[0] == null)
                echo '<td>Caka sa na odpoved</td>';
            else if ($suhlasMeno[0] == "ano")
                echo '<td>Suhlasi</td>';
            else if ($suhlasMeno[0] == "nie")
                echo '<td>Nesuhlasi</td>';
        }
        echo '</tr>';
        elseif ($_SESSION['lang'] == 'en') :
            if ($prihl == $emailPodlaTimu[$i]) {
                if ($suhlasMeno[0] == null) {
                    echo '<td><select name ="Suhlas" width = "auto"><option value="ano">Approve</option><option value="nie">Decline</option></select></td>';
                } else if ($suhlasMeno[0] == "ano")
                    echo '<td>Approved</td>';
                else if ($suhlasMeno[0] == "nie")
                    echo '<td>Declined</td>';
            } else {

                if ($suhlasMeno[0] == null)
                    echo '<td>Waiting for confirmation</td>';
                else if ($suhlasMeno[0] == "ano")
                    echo '<td>approved</td>';
                else if ($suhlasMeno[0] == "nie")
                    echo '<td>Declined</td>';
            }
            endif;
    }

    echo '</table></div>';
    //echo '</tbody></table></div>';
    echo "<input type='submit' name='suhlas' value='Potvrď'>";
    echo "</form>";
    echo "<br>";
    echo '<a href="uloha2.php">spät</a>';
    echo "<br>";

    if (isset($_POST['suhlas'])) {
        $suhlas = $_POST['Suhlas'];
        if (isset($_GET['rok'])) {
            $predmetRok = $_GET['rok'];
            $pieces = explode("-", $predmetRok);
            $rokPrihlaseneho = $pieces[0];
            $predmetPrihlaseneho = $pieces[1];
            //echo"<br>";

            $SQLupdateSuhlas = "UPDATE uloha2admin SET suhlas = '" . $suhlas . "' WHERE '" . $prihl . "' = email and '" . $rokPrihlaseneho . "' = rok and '" . $predmetPrihlaseneho . "'=predmet ";
            $result = $conn->query($SQLupdateSuhlas);
            //echo $_POST['Suhlas'];
            //header("Location: /test/uloha2pouzivatelia.php");

        }
    }
    
    
    
     echo "<br>";
    if (!isset($_SESSION['lang']) || $_SESSION['lang'] == 'sk') :
        echo '<h2>Štatistika z roku ' . $rokPrihlaseneho . ' na predmete ' . $predmetPrihlaseneho . '</h2>';
    elseif ($_SESSION['lang'] == 'en') :
    echo '<h2>Statistics from year ' . $rokPrihlaseneho . ' of subject ' . $predmetPrihlaseneho . '</h2>';
    endif;
        echo "<br>";
    
    $SQLpocetStudentovPredmet = "SELECT count(meno) FROM uloha2admin WHERE '" . $rokPrihlaseneho . "' = rok and '" . $predmetPrihlaseneho. "'=predmet ";
        $result = $conn->query($SQLpocetStudentovPredmet);

        $pocetStudentovPredmet = array();

        if ($result->num_rows > 0) {
            // output data of each row
            while ($res = $result->fetch_assoc()) {
                array_push($pocetStudentovPredmet, $res['count(meno)']);
            }
        } else {
            echo "0 results";
        }
       // echo '<p>       Počet prihlásených študentov:  ' . $pocetStudentovPredmet[0] . '</p>';
    
      $SQLpocetSuhlasStudentovNaPredmete = "SELECT count(meno) FROM uloha2admin WHERE '" . $rokPrihlaseneho . "' = rok and '" . $predmetPrihlaseneho . "'=predmet and 'ano' = suhlas  ";
        $result = $conn->query($SQLpocetSuhlasStudentovNaPredmete);

        $pocetSuhlasStudentovNaPredmete = array();

        if ($result->num_rows > 0) {
            // output data of each row
            while ($res = $result->fetch_assoc()) {
                array_push($pocetSuhlasStudentovNaPredmete, $res['count(meno)']);
            }
        } else {
            echo "1 results";
        }
        //echo '<p>       Počet študentov, ktorí súhlasia so svojimi bodmi: ' . $pocetSuhlasStudentovNaPredmete[0] . '</p>';

        $SQLpocetNesuhlasStudentovNaPredmete = "SELECT count(meno) FROM uloha2admin WHERE '" . $rokPrihlaseneho . "' = rok and '" . $predmetPrihlaseneho . "'=predmet and 'nie' = suhlas  ";
        $result = $conn->query($SQLpocetNesuhlasStudentovNaPredmete);

        $pocetNesuhlasStudentovNaPredmete = array();

        if ($result->num_rows > 0) {
            // output data of each row
            while ($res = $result->fetch_assoc()) {
                array_push($pocetNesuhlasStudentovNaPredmete, $res['count(meno)']);
            }
        } else {
            echo "2 results";
        }
        //echo '<p>       Počet študentov, ktorí nesúhlasia so svojimi bodmi: ' . $pocetNesuhlasStudentovNaPredmete[0] . '</p>';

        $null = null;

        $SQLpocetNevyjStudentovNaPredmete = "SELECT count(meno) FROM uloha2admin WHERE '" . $rokPrihlaseneho . "' = rok and '" . $predmetPrihlaseneho . "'=predmet and suhlas is null ";
        $result = $conn->query($SQLpocetNevyjStudentovNaPredmete);

        $pocetNevyjStudentovNaPredmete = array();

        if ($result->num_rows > 0) {
            // output data of each row
            while ($res = $result->fetch_assoc()) {
                array_push($pocetNevyjStudentovNaPredmete, $res['count(meno)']);
            }
        } else {
            echo "3 results";
        }
        //echo '<p>       Počet študentov, ktorí sa nevyjadrili ku svojim bodom: ' . $pocetNevyjStudentovNaPredmete[0] . '</p>';


        $SQLpocetTimov = "SELECT COUNT(DISTINCT tim) FROM uloha2admin WHERE '" . $rokPrihlaseneho . "' = rok and '" . $predmetPrihlaseneho . "'=predmet ";
        $result = $conn->query($SQLpocetTimov);

        $pocetTimov = array();

        if ($result->num_rows > 0) {
            // output data of each row
            while ($res = $result->fetch_assoc()) {
                array_push($pocetTimov, $res['COUNT(DISTINCT tim)']);
            }
        } else {
            echo "4 results";
        }
        //echo '<p>Počet tímov: ' . $pocetTimov[0] . '</p>';

        $SQLtimy = "SELECT DISTINCT tim FROM uloha2admin WHERE '" . $rokPrihlaseneho . "' = rok and '" . $predmetPrihlaseneho . "'=predmet";
        $result = $conn->query($SQLtimy);

        $timy = array();

        if ($result->num_rows > 0) {
            // output data of each row
            while ($res = $result->fetch_assoc()) {
                array_push($timy, $res[tim]);
            }
        } else {
            echo "5 results";
        }
   // echo $timy[0];
//    echo $timy[1];
        $uzavrete = 0;
        $neuzavrete = 0;

        foreach (array_keys($timy) as $i) {
           //  echo $timy[$i];
            $SQLpocetUzavretychTimov = "Select suhlasAdmin FROM uloha2admin WHERE '" . $timy[$i] . "' = tim ";
            $result = $conn->query($SQLpocetUzavretychTimov);

            $pocetUz = array();

            if ($result->num_rows > 0) {
                // output data of each row
                while ($res = $result->fetch_assoc()) {
                    array_push($pocetUz, $res[suhlasAdmin]);
                }
            } else {
                echo "6 results";
            }
            if ($pocetUz[0] == null) {
                $neuzavrete = $neuzavrete + 1;
            } else if ($pocetUz[0] == 0 || $pocetUz[0] == 1) {
                $uzavrete = $uzavrete + 1;
            }

        }
       // echo '<p>       Počet uzavretých tímov: ' . $uzavrete . '</p>';
       // echo '<p>       Počet neuzavretých tímov: ' . $neuzavrete . '</p>';
    
    $SQLpocetNeuzStudentmi = "SELECT count(distinct (tim)) FROM uloha2admin WHERE suhlas is null and '" . $rokPrihlaseneho . "' = rok and '" . $predmetPrihlaseneho . "'=predmet";
            $result = $conn->query($SQLpocetNeuzStudentmi);

            $pocetNeuzStudentmi = array();

            if ($result->num_rows > 0) {
                // output data of each row
                while ($res = $result->fetch_assoc()) {
                    array_push($pocetNeuzStudentmi, $res['count(distinct (tim))']);
                }
            } else {
                echo "7 results";
            }

         //echo '<p>      Pocet timov s nevyjarenymi studentmi: '.$pocetNeuzStudentmi[0].'</p>';
    
        $dataPoints = array(
            array("label" => "Študenti v predmete", "y" => $pocetStudentovPredmet[0]),
            array("label" => "Súhlasiaci študenti", "y" => $pocetSuhlasStudentovNaPredmete[0]),
            array("label" => "Nesúhlasiaci študenti", "y" => $pocetNesuhlasStudentovNaPredmete[0]),
            array("label" => "Nevyjadrení študenti", "y" => $pocetNevyjStudentovNaPredmete[0])
        );
        $dataPoints2 = array(
            array("label" => "Počet tímov", "y" => $pocetTimov[0]),
            array("label" => "Uzavreté tímy", "y" => $uzavrete),
            array("label" => "Neuzavreté tímy", "y" => $neuzavrete),
            array("label" => "Nevyjadrené tímy", "y" => $pocetNeuzStudentmi[0])
        );
    
    
    
    echo '<div class="table-responsive"><table id="myTable" class="table table-striped table-bordered">';
    if (!isset($_SESSION['lang']) || $_SESSION['lang'] == 'sk') :
    echo '<tr>
    <th>Študenti v predmete</th>
    <th>Súhlasiaci študenti</th> 
    <th>Nesúhlasiaci študenti</th>
    <th>Nevyjadrení študenti</th>
  </tr>';
    elseif ($_SESSION['lang'] == 'en') :
    echo '<tr>
    <th>Students on subject</th>
    <th>Students approved</th> 
    <th>Students declined</th>
    <th>Students not confirmed</th>
  </tr>';
    endif;
    
     echo '<tr>';
        echo '<td>' .$pocetStudentovPredmet[0]. '</td>';
        echo '<td>' .$pocetSuhlasStudentovNaPredmete[0]. '</td>';
        echo '<td>' . $pocetNesuhlasStudentovNaPredmete[0]. '</td>';
        echo '<td>' .$pocetNevyjStudentovNaPredmete[0]. '</td>';
    echo "</tr>";
    
    echo '</table></div>';
    
    echo '<div class="table-responsive"><table id="myTable" class="table table-striped table-bordered">';
    if (!isset($_SESSION['lang']) || $_SESSION['lang'] == 'sk') :
    echo '<tr>
    <th>Počet tímov</th>
    <th>Uzavreté tímy</th> 
    <th>Neuzavreté tímy</th>
    <th>Nevyjadrené tímy</th>
  </tr>';
    elseif ($_SESSION['lang'] == 'en') :
    echo '<tr>
    <th>Number of teams</th>
    <th>Enclosed teams</th> 
    <th>Unclosed teams</th>
    <th>Not decided</th>
  </tr>';
    endif;
    
     echo '<tr>';
        echo '<td>' .$pocetTimov[0]. '</td>';
        echo '<td>' .$uzavrete. '</td>';
        echo '<td>' . $neuzavrete. '</td>';
        echo '<td>' .$pocetNeuzStudentmi[0]. '</td>';
    echo "</tr>";
    
    echo '</table></div>';
        
        
    
  ?>
    <div>
        <div id="chartContainer" style="height: 370px; width: 100%;" float ="left" ></div>
        <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
        <div id="chartContainer2" style="height: 370px; width: 100%;" float ="right"></div>
        <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    </div>
       
 <script>
            window.onload = function () {


                var chart = new CanvasJS.Chart("chartContainer", {
                    animationEnabled: true,
                    title: {
                        text: "Štatistika"
                    },
                    data: [{
                        type: "pie",
                        yValueFormatString: "#,##0\"\"",
                        indexLabel: "{label} ({y})",
                        dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                    }]
                });
                chart.render();

                var chart2 = new CanvasJS.Chart("chartContainer2", {
                    animationEnabled: true,
                    title: {
                        text: "Štatistika"
                    },
                    data: [{
                        type: "pie",
                        yValueFormatString: "#,##0\"\"",
                        indexLabel: "{label} ({y})",
                        dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
                    }]
                });
                chart2.render();


            }
            <?php
    

    }
    else echo "nie si prihlásený";


    ?>
    </script>

</div>
</div>
</div>
<div class="sticky-footer">
    <img id="sk" style="width: 50px" alt="SK" src="images/sk.png">
    <img id="en" style="width: 50px" alt="EN" src="images/gb.jpg">
</div>
<script>setListeners();</script>
</body>
</html>