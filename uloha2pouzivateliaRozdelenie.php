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

    <?php
    $koncovka = "@is.stuba.sk";
    $prihl = $prihlaseny . $koncovka;
    if (isset($_POST['rozdel'])) {


        //$predmetRokPrihlaseneho = $_GET['id'];
        $predmetRokPrihlaseneho = $_POST['rok-predmet'];
       // echo $predmetRokPrihlaseneho."plllls";

        $pieces = explode("-", $predmetRokPrihlaseneho);
        $rokPrihlaseneho = $pieces[0];
        $predmetPrihlaseneho = $pieces[1];
        //echo $rokPrihlaseneho;


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
        //echo $body;

        $SQLmenaPodlaTimu = "SELECT meno, email FROM uloha2admin WHERE '" . $tim . "' = tim and '" . $rokPrihlaseneho . "' = rok and '" . $predmetPrihlaseneho . "'=predmet";
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
            echo "1 results";
        }
        $kontrola = 0;
        //echo "prosim".$_POST['body'][$e]

        $user_inputs = array();
        foreach (array_keys($menaPodlaTimu) as $i) {


            $e = $emailPodlaTimu[$i];
            $kontrola += $_POST['body'][$e];
            //echo  $_POST['body'][$e];

        }

      
            foreach (array_keys($menaPodlaTimu) as $i) {
                $e = $emailPodlaTimu[$i];
                //echo  $_POST['body'][$e];
                echo "<br>";
                $SQLvlozRozdelenie = "UPDATE uloha2admin
                                SET rozdelenie = '" . $_POST['body'][$e] . "'
                                WHERE '" . $e . "' = email and '" . $rokPrihlaseneho . "' = rok and '" . $predmetPrihlaseneho . "'=predmet";
                echo $sql;
                $result = $conn->query($SQLvlozRozdelenie);
            }

            header('Location: /zaver/uloha2pouzivateliaSuhlas.php?id=' . $predmetRokPrihlaseneho . '');

        

    }
    }
    else echo "nie si prihlaseny";


    ?>
</div>
<div class="sticky-footer">
    <img id="sk" style="width: 50px" alt="SK" src="images/sk.png">
    <img id="en" style="width: 50px" alt="EN" src="images/gb.jpg">
</div>
<script>setListeners();</script>
</body>
</html>