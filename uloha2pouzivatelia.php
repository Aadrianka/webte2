<?php

session_start();
if (isset($_SESSION['user'])){
$prihlaseny = $_SESSION['user'];
//echo $prihlaseny;
require_once 'config.php';


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

mysqli_set_charset($conn, "utf8");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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
                <li><a href="rozdel.php" accesskey="5" title="">Rozdelenie úloh</a></li>
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
    <div id="wrap">
        <div class="container">
            <?php

            $koncovka = "@is.stuba.sk";
            $prihl = $prihlaseny . $koncovka;
            // echo $prihl;
            $SQLpredmetRok = "SELECT predmet,rok FROM uloha2admin WHERE '" . $prihl . "' = email";

            $result = $conn->query($SQLpredmetRok);

            $rokPredmet = array();


            if ($result->num_rows > 0) {
                // output data of each row
                while ($res = $result->fetch_assoc()) {
                    array_push($rokPredmet, $res[rok] . '-' . $res[predmet]);
                }
            } else {
                echo "0 results";
            }


            echo '<form method="post">';
            echo '<select name ="rokPredmet">';
            echo '<option value="">--Please choose an option--</option>';
            foreach ($rokPredmet as $val) {
                echo '<option value="' . $val . '">' . $val . '</option>';
            }
            echo '</select>';
            echo '<input type="submit" name="submit" value="Vyber rok-predmet" />';
            echo '</form>';


            $pieces = explode("-", $rokPredmet[0]);
            $rok = $pieces[0];
            $predmet = $pieces[1];


            echo "<br>";
            echo '<h2>Statistika z roku ' . $rok . ' na predmete ' . $predmet . '</h2>';
            echo "<br>";

            $SQLpocetStudentovPredmet = "SELECT count(meno) FROM uloha2admin WHERE '" . $rok . "' = rok and '" . $predmet . "'=predmet ";
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
            echo '<p>Prihlasenych studentov:  ' . $pocetStudentovPredmet[0] . '</p>';

            $SQLpocetSuhlasStudentovNaPredmete = "SELECT count(meno) FROM uloha2admin WHERE '" . $rok . "' = rok and '" . $predmet . "'=predmet and 'ano' = suhlas  ";
            $result = $conn->query($SQLpocetSuhlasStudentovNaPredmete);

            $pocetSuhlasStudentovNaPredmete = array();

            if ($result->num_rows > 0) {
                // output data of each row
                while ($res = $result->fetch_assoc()) {
                    array_push($pocetSuhlasStudentovNaPredmete, $res['count(meno)']);
                }
            } else {
                echo "0 results";
            }
            echo '<p>Pocet studentov, ktory suhlasia so svojimi bodmi: ' . $pocetSuhlasStudentovNaPredmete[0] . '</p>';

            $SQLpocetNesuhlasStudentovNaPredmete = "SELECT count(meno) FROM uloha2admin WHERE '" . $rok . "' = rok and '" . $predmet . "'=predmet and 'nie' = suhlas  ";
            $result = $conn->query($SQLpocetNesuhlasStudentovNaPredmete);

            $pocetNesuhlasStudentovNaPredmete = array();

            if ($result->num_rows > 0) {
                // output data of each row
                while ($res = $result->fetch_assoc()) {
                    array_push($pocetNesuhlasStudentovNaPredmete, $res['count(meno)']);
                }
            } else {
                echo "0 results";
            }
            echo '<p>Pocet studentov, ktory nesuhlasia so svojimi bodmi: ' . $pocetNesuhlasStudentovNaPredmete[0] . '</p>';

            $null = null;

            $SQLpocetNevyjStudentovNaPredmete = "SELECT count(meno) FROM uloha2admin WHERE '" . $rok . "' = rok and '" . $predmet . "'=predmet and suhlas is null ";
            $result = $conn->query($SQLpocetNevyjStudentovNaPredmete);

            $pocetNevyjStudentovNaPredmete = array();

            if ($result->num_rows > 0) {
                // output data of each row
                while ($res = $result->fetch_assoc()) {
                    array_push($pocetNevyjStudentovNaPredmete, $res['count(meno)']);
                }
            } else {
                echo "0 results";
            }
            echo '<p>Pocet studentov, ktory sa nevyjadrili ku svojim bodom: ' . $pocetNevyjStudentovNaPredmete[0] . '</p>';

            $SQLpocetTimov = "SELECT COUNT(DISTINCT tim) FROM uloha2admin";
            $result = $conn->query($SQLpocetTimov);

            $pocetTimov = array();

            if ($result->num_rows > 0) {
                // output data of each row
                while ($res = $result->fetch_assoc()) {
                    array_push($pocetTimov, $res['COUNT(DISTINCT tim)']);
                }
            } else {
                echo "0 results";
            }
            echo '<p>Pocet timov: ' . $pocetTimov[0] . '</p>';

            $SQLtimy = "SELECT DISTINCT tim FROM uloha2admin";
            $result = $conn->query($SQLtimy);

            $timy = array();

            if ($result->num_rows > 0) {
                // output data of each row
                while ($res = $result->fetch_assoc()) {
                    array_push($timy, $res[tim]);
                }
            } else {
                echo "0 results";
            }
            $uzavrete = 0;
            $neuzavrete = 0;

            foreach (array_keys($timy) as $i) {
                // echo $timy[$i];
                $SQLpocetUzavretychTimov = "Select suhlasAdmin FROM uloha2admin WHERE '" . $rok . "' = rok and '" . $predmet . "'=predmet and '" . $timy[$i] . "' = tim ";
                $result = $conn->query($SQLpocetUzavretychTimov);

                $pocetUz = array();

                if ($result->num_rows > 0) {
                    // output data of each row
                    while ($res = $result->fetch_assoc()) {
                        array_push($pocetUz, $res[suhlasAdmin]);
                    }
                } else {
                    echo "0 results";
                }
                if ($pocetUz[0] == null) {
                    $neuzavrete = $neuzavrete + 1;
                } else if ($pocetUz[0] == 0 || $pocetUz[0] == 1) {
                    $uzavrete = $uzavrete + 1;
                }

            }
            echo '<p>Pocet uzavretych: ' . $uzavrete . '</p>';
            echo '<p>Pocet neuzavretych: ' . $neuzavrete . '</p>';


            if (isset($_POST['submit'])) {

                $predmetRokPrihlaseneho = $_POST['rokPredmet'];

                $pieces = explode("-", $predmetRokPrihlaseneho);
                $rokPrihlaseneho = $pieces[0];
                $predmetPrihlaseneho = $pieces[1];


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


                $SQLjeRozdelene = "SELECT rozdelenie FROM uloha2admin WHERE '" . $prihl . "' = email and '" . $rokPrihlaseneho . "' = rok and '" . $predmetPrihlaseneho . "'=predmet";

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

                echo "<br>";

                $SQLmenaPodlaTimu = "SELECT meno, email FROM uloha2admin WHERE '" . $tim . "' = tim";
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

                echo "<br>";
                echo "Si tim  " . $tim . " a mate   <div id='bodyTimu'>" . $body . "</div>";
                echo " bodov. ";
                echo "<br>";
                echo "<br>";

                if ($jeRozdelene[0] == null) {

                    echo "Body este nemate rozdelene, prosim rozdel ich.";

                    ?>

                    <script>
                        function validateForm() {
                            alert("Name out");
                            var re = new RegExp('^\\d+$');

                            suma = 0;
                            var x = document.forms["rozdel"];//["bodyxchalupkova@is.stuba.sk"].value;
                            alert(x.length);
                            for (i = 0; i < x.length - 1; i++) {
                                alert(x[i].value);
                                if (x[i].value < 0 || x[i].value.length == 0) {//(!re.test(x[i])) {
                                    alert("nerozdelil si vsetkym body([0-9]+)");
                                    return false;
                                }
                                suma = suma + parseInt(x[i].value, 10);
                            }
                            alert(parseInt(document.getElementById("bodyTimu").innerHTML, 10));
                            alert(suma);
                            if (suma == parseInt(document.getElementById("bodyTimu").innerHTML, 10)) {
                                return true;
                            } else {
                                alert("Suma rozdelenych bodov nesedi s poctom vasich bodov");

                            }


                            return false;
                        }
                    </script>
                    <?php

//echo " <form method='post' action = 'test/uloha2pouzivateliaRozdelenie.php'>";
                    echo '<form onsubmit="return validateForm()" class=\"form-horizontal\" action="uloha2pouzivateliaRozdelenie.php?id=' . $predmetRokPrihlaseneho . '" method="post" name="rozdel" enctype=\"multipart/form-data\">';
                    echo "<div class='table-responsive'><table id='myTable' class='table table-striped table-bordered'>
             <thead><tr>  <th>Meno</th>
                          <th>Email</th>
                          <th>Rozdelenie</th>
                        </tr></thead><tbody>";
                    foreach (array_keys($menaPodlaTimu) as $i) {

                        echo '<tr>';
                        echo '<td>' . $menaPodlaTimu[$i] . '</td>';
                        echo '<td>' . $emailPodlaTimu[$i] . '</td>';
                        echo "<td> <input type ='number' id = " . $emailPodlaTimu[$i] . " name='body[" . $emailPodlaTimu[$i] . "]'>  </td>";
                        // echo 'body'.$emailPodlaTimu[$i];
                        //echo "<td>'body".$emailPodlaTimu[$i]."'</td>";
                        echo '</tr>';
                    }

                    echo '</tbody></div></table>';
//echo "<input type ='text' name='rok-predmet'  value=$predmetRokPrihlaseneho>";
                    echo "<input type='submit' name='rozdel' value='rozdel'>";
                    echo "</form>";
                } else {
                    header("Location: /zaver/uloha2pouzivateliaSuhlas.php?id=" . $predmetRokPrihlaseneho);
                }
            }

            $dataPoints = array(
                array("label" => "Studenti v predmete", "y" => $pocetStudentovPredmet[0]),
                array("label" => "suhlasiaci studenti", "y" => $pocetSuhlasStudentovNaPredmete[0]),
                array("label" => "nesuhlasiaci studenti", "y" => $pocetNesuhlasStudentovNaPredmete[0]),
                array("label" => "nevyjadreny studenti", "y" => $pocetNevyjStudentovNaPredmete[0])
            );
            $dataPoints2 = array(
                array("label" => "Pocet timov", "y" => $pocetTimov[0]),
                array("label" => "Uzavrete timy", "y" => $uzavrete),
                array("label" => "Neuzavrete timy", "y" => $neuzavrete)
            );


            ?>


            <div id="chartContainer" style="height: 370px; width: 100%;"></div>
            <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

            <div id="chartContainer2" style="height: 370px; width: 100%;"></div>

            <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
            <script>
                window.onload = function () {


                    var chart = new CanvasJS.Chart("chartContainer", {
                        animationEnabled: true,
                        title: {
                            text: "Statistika"
                        },
                        data: [{
                            type: "pie",
                            yValueFormatString: "#,##0.00\"\"",
                            indexLabel: "{label} ({y})",
                            dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                        }]
                    });
                    chart.render();

                    var chart2 = new CanvasJS.Chart("chartContainer2", {
                        animationEnabled: true,
                        title: {
                            text: "Statistika"
                        },
                        data: [{
                            type: "pie",
                            yValueFormatString: "#,##0.00\"\"",
                            indexLabel: "{label} ({y})",
                            dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
                        }]
                    });
                    chart2.render();


                }

            </script>


            <?php
            }
            else echo "nie si prihlaseny";
            ?>
        </div>

    </div>
</div>
</body>
</html>