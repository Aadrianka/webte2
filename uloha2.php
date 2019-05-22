<?php
include_once("config.php");

$conn = new mysqli($servername, $username, $password, $dbname);

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
    <link
            media="screen" href="style.css" rel="stylesheet" type="text/css" media="all"/>
    <link href="fonts.css" rel="stylesheet" type="text/css" media="all"/>

    <!--[if IE 6]>
    <link href="default_ie6.css" rel="stylesheet" type="text/css"/><![endif]-->
    <link href="default.css" rel="stylesheet" type="text/css" media="all"/>
    <link media="print" href="print.css"/>

</head>
<body>
<?php

    session_start();
?>
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
                    <li><a href="rozdel.php" accesskey="5" title="">Divisions tasks</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>

<div class="wrapper">
    <?php
    if (isset($_SESSION['admin']) && $_SESSION['admin']) {
        ?>

        <div id="wrap">
            <div class="container">
                <div class="row">
                    <form class="form-horizontal" action="uloha2functions.php" method="post" name="upload_excel"
                          enctype="multipart/form-data">
                        <?php if (!isset($_SESSION['lang']) || $_SESSION['lang'] == 'sk') : ?>
                            <fieldset>

                                <!-- Form Name -->
                                <legend>Admin pridávanie</legend>

                                <!-- Select Basic -->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="year">Šk. rok</label>
                                    <div class="col-md-2">
                                        <select id="year" name="year" class="form-control">
                                            <option value="1819">2018/2019</option>
                                            <option value="1718">2017/2018</option>
                                            <option value="1617">2016/2017</option>
                                            <option value="1516">2015/2016</option>
                                            <option value="1415">2014/2015</option>
                                            <option value="1314">2013/2014</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Text input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="predmet">Názov predmetu</label>
                                    <div class="col-md-2">
                                        <input id="predmet" name="predmet" type="text" placeholder="napr. webte2"
                                               class="form-control input-md" required="">

                                    </div>
                                </div>

                                <!-- File Button -->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="filebutton">CSV import</label>
                                    <div class="col-md-4">
                                        <input type="file" name="file" id="file" class="input-large">
                                    </div>
                                </div>

                                <!-- Text input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="separator">Použitý separátor</label>
                                    <div class="col-md-1">
                                        <input id="separator" name="separator" type="text" placeholder=", ; "
                                               class="form-control input-md" required="">

                                    </div>
                                </div>

                                <!-- Button -->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="singlebutton">Import data</label>
                                    <div class="col-md-4">
                                        <button type="submit" id="submit" name="Import"
                                                class="btn btn-primary button-loading"
                                                data-loading-text="Loading...">Import
                                        </button>
                                    </div>
                                </div>

                            </fieldset>
                        <?php elseif ($_SESSION['lang'] == 'en') : ?>
                            <fieldset>

                                <!-- Form Name -->
                                <legend>Admin import</legend>

                                <!-- Select Basic -->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="year">School year</label>
                                    <div class="col-md-2">
                                        <select id="year" name="year" class="form-control">
                                            <option value="1819">2018/2019</option>
                                            <option value="1718">2017/2018</option>
                                            <option value="1617">2016/2017</option>
                                            <option value="1516">2015/2016</option>
                                            <option value="1415">2014/2015</option>
                                            <option value="1314">2013/2014</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Text input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="predmet">Subject name</label>
                                    <div class="col-md-2">
                                        <input id="predmet" name="predmet" type="text" placeholder="napr. webte2"
                                               class="form-control input-md" required="">

                                    </div>
                                </div>

                                <!-- File Button -->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="filebutton">CSV import</label>
                                    <div class="col-md-4">
                                        <input type="file" name="file" id="file" class="input-large">
                                    </div>
                                </div>

                                <!-- Text input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="separator">Separator</label>
                                    <div class="col-md-1">
                                        <input id="separator" name="separator" type="text" placeholder=", ; "
                                               class="form-control input-md" required="">

                                    </div>
                                </div>

                                <!-- Button -->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="singlebutton">Import data</label>
                                    <div class="col-md-4">
                                        <button type="submit" id="submit" name="Import"
                                                class="btn btn-primary button-loading"
                                                data-loading-text="Loading...">Import
                                        </button>
                                    </div>
                                </div>

                            </fieldset>
                        <?php endif; ?>
                    </form>
                </div>

                <!-- Pouzivatelia -->


            </div>
        </div>
        <br>
        <br>

        <div id="wrap">
            <div class="container">
                <div class="row">
                    <form class="form-horizontal" action="uloha2functions.php" method="post" name="upload_excel"
                          enctype="multipart/form-data">
                        <?php if (!isset($_SESSION['lang']) || $_SESSION['lang'] == 'sk') : ?>
                            <div class="form-group">
                                <div class="col-md-4 col-md-offset-4">
                                    <input type="submit" name="Export" class="btn btn-success" value="Exportovať CSV"/>
                                </div>
                            </div>
                        <?php elseif ($_SESSION['lang'] == 'en') : ?>
                            <div class="form-group">
                                <div class="col-md-4 col-md-offset-4">
                                    <input type="submit" name="Export" class="btn btn-success" value="Export CSV"/>
                                </div>
                            </div>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>

        <div id="wrap">
            <div class="container">
                <div class="row">
                    <form class="form-horizontal" method="post" name="upload_excel"
                          enctype="multipart/form-data">
                        <?php if (!isset($_SESSION['lang']) || $_SESSION['lang'] == 'sk') : ?>
                            <fieldset>

                                <!-- Form Name -->
                                <legend>Prehľad tímov:</legend>


                                <!-- Select Basic -->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="year">Tím č.:</label>
                                    <div class="col-md-2">
                                        <select name="team" id="team" class="form-control">
                                            <option value="">Select</option>
                                            <?php
                                            include_once("config.php");
                                            $conn = new mysqli($servername, $username, $password, $dbname);
                                            if ($conn->connect_error) {
                                                die("Connection failed: " . $conn->connect_error);
                                            }
                                            $Sql = "SELECT DISTINCT tim FROM uloha2admin";
                                            $result = mysqli_query($conn, $Sql);
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                //echo '<option value="' . $row['tim'] . '">' . $row['tim'] . '</option>';
                                                echo "<option value=\"" . $row["tim"] . "\"";
                                                if ($_POST['team'] == $row['tim'])
                                                    echo 'selected';
                                                echo ">" . $row["tim"] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- Select Basic -->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="year">Rok:</label>
                                    <div class="col-md-2">
                                        <select name="rok" id="rok" class="form-control">
                                            <option value="">Select</option>
                                            <?php
                                            include_once("config.php");
                                            $conn = new mysqli($servername, $username, $password, $dbname);
                                            if ($conn->connect_error) {
                                                die("Connection failed: " . $conn->connect_error);
                                            }
                                            $Sql = "SELECT DISTINCT rok FROM uloha2admin";
                                            $result = mysqli_query($conn, $Sql);
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                //echo '<option value="' . $row['rok'] . '">' . $row['rok'] . '</option>';
                                                echo "<option value=\"" . $row["rok"] . "\"";
                                                if ($_POST['rok'] == $row['rok'])
                                                    echo 'selected';
                                                echo ">" . $row["rok"] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- Select Basic -->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="year">Predmet:</label>
                                    <div class="col-md-2">
                                        <select name="predmet" id="predmet" class="form-control">
                                            <option value="">Select</option>
                                            <?php
                                            include_once("config.php");
                                            $conn = new mysqli($servername, $username, $password, $dbname);
                                            if ($conn->connect_error) {
                                                die("Connection failed: " . $conn->connect_error);
                                            }
                                            $Sql = "SELECT DISTINCT predmet FROM uloha2admin";
                                            $result = mysqli_query($conn, $Sql);
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                // echo '<option value="' . $row['predmet'] . '">' . $row['predmet'] . '</option>';
                                                echo "<option value=\"" . $row["predmet"] . "\"";
                                                if ($_POST['predmet'] == $row['predmet'])
                                                    echo 'selected';
                                                echo ">" . $row["predmet"] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- Button -->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="singlebutton"></label>
                                    <div class="col-md-4">
                                        <button type="submit" id="submit" name="Submit"
                                                class="btn btn-primary button-loading"
                                                data-loading-text="Loading...">Zmeň
                                        </button>
                                    </div>
                                </div>

                            </fieldset>
                        <?php elseif ($_SESSION['lang'] == 'en') : ?>
                            <fieldset>

                                <!-- Form Name -->
                                <legend>Teams overview:</legend>


                                <!-- Select Basic -->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="year">Team num.:</label>
                                    <div class="col-md-2">
                                        <select name="team" id="team" class="form-control">
                                            <option value="">Select</option>
                                            <?php
                                            include_once("config.php");
                                            $conn = new mysqli($servername, $username, $password, $dbname);
                                            if ($conn->connect_error) {
                                                die("Connection failed: " . $conn->connect_error);
                                            }
                                            $Sql = "SELECT DISTINCT tim FROM uloha2admin";
                                            $result = mysqli_query($conn, $Sql);
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                //echo '<option value="' . $row['tim'] . '">' . $row['tim'] . '</option>';
                                                echo "<option value=\"" . $row["tim"] . "\"";
                                                if ($_POST['team'] == $row['tim'])
                                                    echo 'selected';
                                                echo ">" . $row["tim"] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- Select Basic -->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="year">Year:</label>
                                    <div class="col-md-2">
                                        <select name="rok" id="rok" class="form-control">
                                            <option value="">Select</option>
                                            <?php
                                            include_once("config.php");
                                            $conn = new mysqli($servername, $username, $password, $dbname);
                                            if ($conn->connect_error) {
                                                die("Connection failed: " . $conn->connect_error);
                                            }
                                            $Sql = "SELECT DISTINCT rok FROM uloha2admin";
                                            $result = mysqli_query($conn, $Sql);
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                //echo '<option value="' . $row['rok'] . '">' . $row['rok'] . '</option>';
                                                echo "<option value=\"" . $row["rok"] . "\"";
                                                if ($_POST['rok'] == $row['rok'])
                                                    echo 'selected';
                                                echo ">" . $row["rok"] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- Select Basic -->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="year">Subject:</label>
                                    <div class="col-md-2">
                                        <select name="predmet" id="predmet" class="form-control">
                                            <option value="">Select</option>
                                            <?php
                                            include_once("config.php");
                                            $conn = new mysqli($servername, $username, $password, $dbname);
                                            if ($conn->connect_error) {
                                                die("Connection failed: " . $conn->connect_error);
                                            }
                                            $Sql = "SELECT DISTINCT predmet FROM uloha2admin";
                                            $result = mysqli_query($conn, $Sql);
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                // echo '<option value="' . $row['predmet'] . '">' . $row['predmet'] . '</option>';
                                                echo "<option value=\"" . $row["predmet"] . "\"";
                                                if ($_POST['predmet'] == $row['predmet'])
                                                    echo 'selected';
                                                echo ">" . $row["predmet"] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- Button -->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="singlebutton"></label>
                                    <div class="col-md-4">
                                        <button type="submit" id="submit" name="Submit"
                                                class="btn btn-primary button-loading"
                                                data-loading-text="Loading...">Change
                                        </button>
                                    </div>
                                </div>

                            </fieldset>
                        <?php endif; ?>
                    </form>
                </div>

                <!-- Pouzivatelia -->


            </div>
        </div>
        <?php
        include 'uloha2functions.php';
        get_all_records();
    }
    ?>

    <!-- Zuzna -->
    <div id="wrap">
        <div class="container">
            <div class="row">
                <?php
                session_start();
                if (isset($_SESSION['admin']) && !$_SESSION['admin']) {
                    $prihlaseny = $_SESSION['user'];
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

                    if (!isset($_SESSION['lang']) || $_SESSION['lang'] == 'sk') :
                        echo '<form method="post">';
                        echo '<select name ="rokPredmet">';
                        echo '<option value="">--Vyber rok-predmet--</option>';
                        foreach ($rokPredmet as $val) {
                            echo '<option value="' . $val . '">' . $val . '</option>';
                        }
                        echo '</select>';
                        echo '<input type="submit" name="submit" value="Vyber rok-predmet" />';
                        echo '</form>';
                elseif ($_SESSION['lang'] == 'en') :
                    echo '<form method="post">';
                    echo '<select name ="rokPredmet">';
                    echo '<option value="">--choose year-subject--</option>';
                    foreach ($rokPredmet as $val) {
                        echo '<option value="' . $val . '">' . $val . '</option>';
                    }
                    echo '</select>';
                    echo '<input type="submit" name="submit" value="Choose year-subject" />';
                    echo '</form>';
                endif;



                    $pieces = explode("-", $rokPredmet[0]);
                    $rok = $pieces[0];
                    $predmet = $pieces[1];


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

                        $SQLmenaPodlaTimu = "SELECT meno, email FROM uloha2admin WHERE '" . $tim . "' = tim and '" . $rokPrihlaseneho . "' = rok and '" . $predmetPrihlaseneho . "' = predmet ";
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





                        if (!isset($_SESSION['lang']) || $_SESSION['lang'] == 'sk') :
                        echo "Si tím  " . $tim . " a máte   <div id='bodyTimu'>" . $body . "</div>";
                        elseif ($_SESSION['lang'] == 'en') :
                            echo "You are in team  " . $tim . " and you have   <div id='bodyTimu'>" . $body . "</div>";
                        endif;
                        if (!isset($_SESSION['lang']) || $_SESSION['lang'] == 'sk') :
                        echo " bodov. ";
                        elseif ($_SESSION['lang'] == 'en') :
                            echo " points. ";
                        endif;
                        echo "<br>";
                        echo "<br>";
                        //echo $jeRozdelene[0]."aaa";

                        if ($jeRozdelene[0] == null) {
                            if (!isset($_SESSION['lang']) || $_SESSION['lang'] == 'sk') :
                            echo "Body ešte nemáte rozdelené, prosím rozdel ich.";
                            elseif ($_SESSION['lang'] == 'en') :
                                echo "Points not given yet, please divide them.";
                            endif;

                            ?>

                            <script>
                                function validateForm() {
                                    //alert("Name out");
                                    var re = new RegExp('^\\d+$');

                                    suma = 0;
                                    var x = document.forms["rozdel"];//["bodyxchalupkova@is.stuba.sk"].value;
                                    //alert(x.length);
                                    for (i = 0; i < x.length - 2; i++) {
                                        // alert(x[i].value);
                                        if (x[i].value < 0 || x[i].value.length == 0) {//(!re.test(x[i])) {
                                            alert("Nerozdelil si všetkým body.");
                                            return false;
                                        }
                                        suma = suma + parseInt(x[i].value, 10);
                                    }
                                    //alert(parseInt(document.getElementById("bodyTimu").innerHTML, 10));
                                    //alert(suma);
                                    if (suma == parseInt(document.getElementById("bodyTimu").innerHTML, 10)) {
                                        return true;
                                    } else {
                                        alert("Suma rozdelených bodov nesedí s počtom vašich bodov.");

                                    }


                                    return false;
                                }
                            </script>
                            <?php
// action="uloha2pouzivateliaRozdelenie.php?id=' . $predmetRokPrihlaseneho . '"
//echo " <form method='post' action = 'test/uloha2pouzivateliaRozdelenie.php'>";
                            echo '<form onsubmit="return validateForm()" class=\"form-horizontal\" action="uloha2pouzivateliaRozdelenie.php" method="post" name="rozdel" enctype=\"multipart/form-data\">';
                            if (!isset($_SESSION['lang']) || $_SESSION['lang'] == 'sk') :
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
                            echo "<input type ='text' name='rok-predmet'  value=$predmetRokPrihlaseneho>";
                            echo "<input type='submit' name='rozdel' value='rozdel'>";
                            echo "</form>";
                            elseif ($_SESSION['lang'] == 'en') :
                                echo "<div class='table-responsive'><table id='myTable' class='table table-striped table-bordered'>
             <thead><tr>  <th>Name</th>
                          <th>Email</th>
                          <th>Points</th>
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
                                echo "<input type ='text' name='rok-predmet'  value=$predmetRokPrihlaseneho>";
                                echo "<input type='submit' name='rozdel' value='divide'>";
                                echo "</form>";
                                endif;

                        } else {
                            //echo "somtu";
                            header("Location: uloha2pouzivateliaSuhlas.php?id=" . $predmetRokPrihlaseneho);

                        }
                    }


                } else if ($_SESSION['user'] == null) echo "nie si prihlásený";
                ?>

            </div>
        </div>
    </div>
</div>
<script>
    /* $(document).ready(function() {
         $("#wrap").load("uloha2functions.php");
         var refreshId = setInterval(function() {
             $("#wrap").load('uloha2functions.php');
         }, 3000);
         $.ajaxSetup({ cache: false });
     });*/
</script>
<div class="sticky-footer">
    <img id="sk" style="width: 50px" alt="SK" src="images/sk.png">
    <img id="en" style="width: 50px" alt="EN" src="images/gb.jpg">
</div>
<script>setListeners();</script>
</body>
</html>