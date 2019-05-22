<?php
session_start();


include_once("config.php");

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST["Import"])) {

    $filename = $_FILES["file"]["tmp_name"];
    $separator = $_POST['separator'];
    $year = $_POST['year'];
    $predmet = $_POST['predmet'];

    if ($_FILES["file"]["size"] > 0) {
        $file = fopen($filename, "r");
        while (($getData = fgetcsv($file, 10000, $separator)) !== FALSE) {
            $sql = "INSERT INTO `uloha2admin` (`ID`, `meno`, `email`, `tim`, `rok`, `predmet`) VALUES
                    ('$getData[0]','" . $getData[1] . "','" . $getData[2] . "','" . $getData[3] . "', '$year', '$predmet')";
            echo $sql;
            $result = $conn->query($sql);
            if (!isset($result)) {
                echo "<script type=\"text/javascript\">
                  alert(\"Invalid File:Please Upload CSV File.\");
                  window.location = \"uloha2.php\"
                  </script>";
            } else {
                echo "<script type=\"text/javascript\">
                alert(\"CSV File has been successfully Imported.\");
                window.location = \"uloha2.php\"
              </script>";
            }


        }
        fclose($file);
    } else echo "Please upload file with data";
}
if (isset($_POST["Submit"])) {
    $team = $_POST['team'];
    $_SESSION['timik'] = $_POST['team'];
    $_SESSION['rocik'] = $_POST['rok'];
    $_SESSION['predmet'] = $_POST['predmet'];

}


if (isset($_POST["Update"])) {
    $team = $_SESSION['timik'];
    $rok = $_SESSION['rocik'];
    $predmet = $_SESSION['predmet'];
    global $conn;
    $teambody = $_POST['body'];
    $_SESSION['bodiky'] = $teambody;
    $sql3 = "UPDATE uloha2admin SET body='" . $teambody . "' WHERE tim='" . $team . "' and rok='" . $rok . "' and predmet='" . $predmet . "'";
    echo $sql3;
    $result = $conn->query($sql3);
}

if (isset($_POST["Suhlas"])) {
    $team = $_SESSION['timik'];
    $rok = $_SESSION['rocik'];
    $predmet = $_SESSION['predmet'];
    $radio = $_POST["radio"];
    global $conn;
    $sql4 = "UPDATE uloha2admin SET suhlasAdmin='" . $radio . "' WHERE tim='" . $team . "' and rok='" . $rok . "' and predmet='" . $predmet . "'";
    $result = $conn->query($sql4);
    if ($radio == 1) {
        echo "<div class='container'><h1> Schválili ste bodovanie tímu: " . $team . " </h1>";
    }
    if ($radio == 0) {
        echo "<div class='container'><h1> Neschválili ste bodovanie tímu: " . $team . " </h1>";
    }


}

function get_all_records()
{
    $max = 30;

    if (isset($_POST["Submit"]) || !isset($_POST["Submit"])) {
        $team = $_POST['team'];
        $rok = $_POST['rok'];
        $predmet = $_POST['predmet'];


        global $conn;
        $Sql = "SELECT * FROM uloha2admin where tim='" . $team . "' and rok='" . $rok . "' and predmet='" . $predmet . "'";
        $result = mysqli_query($conn, $Sql);
        if (mysqli_num_rows($result) > 0) {
            echo "<div id='wrap'><div class='container'><div class='row'>";

            if (!isset($_SESSION['lang']) || $_SESSION['lang'] == 'sk') :
                echo "<div class='table-responsive'><table id='myTable' class='table table-striped table-bordered'>
             <thead><tr>  <th>Meno</th>
                          <th>Email</th>
                          <th>Tím</th>
                          <th>Body Študent</th>
                          <th>Potvrdenie</th>
                        </tr></thead><tbody>";
            elseif ($_SESSION['lang'] == 'en') :
                echo "<div class='table-responsive'><table id='myTable' class='table table-striped table-bordered'>
             <thead><tr>  <th>Name</th>
                          <th>Email</th>
                          <th>Team</th>
                          <th>Points student</th>
                          <th>Confirmation</th>
                        </tr></thead><tbody>";
            endif;

            while ($row = mysqli_fetch_assoc($result)) {
                if ($row['suhlas'] == "ano") {
                    $suhlas = "Akceptuje";
                }
                if ($row['suhlas'] == "nie") {
                    $suhlas = "Neakceptuje";
                }
                if ($row['suhlas'] === NULL) {
                    $showsuhlas = false;
                }
                echo "<tr><td>" . $row['meno'] . "</td>
                   <td>" . $row['email'] . "</td>
                   <td>" . $row['tim'] . "</td>
                   <td>" . $row['rozdelenie'] . "</td>
                   <td>$suhlas</td></tr>";

                if ($row['body'] === NULL) {
                    $arebody = 0;

                } else {
                    $arebody = 1;
                    $bodiky = $row['body'];
                }
                if ($row['suhlasAdmin'] === NULL) {
                    $suhlasAdmin = 0;
                } else {
                    $suhlasAdmin = 1;
                    if ($row['suhlasAdmin'] == 1) {
                        $adminResp = "Akceptované";
                    } else {
                        $adminResp = "Neakceptované";
                    }

                }


            }
            if (!isset($_SESSION['lang']) || $_SESSION['lang'] == 'sk') :
                echo "<div class='container'><h1> Číslo tímu: " . $team . "  <br>Počet bodov: " . $bodiky . "</h1>";
            elseif ($_SESSION['lang'] == 'en') :
                echo "<div class='container'><h1> Team Number: " . $team . "  <br>Points: " . $bodiky . "</h1>";
            endif;
            echo "</tbody></table></div></div></div></div>";
            echo $arebody;
            $Sql2 = "SELECT COUNT(*) as total FROM uloha2admin where tim='" . $team . "'";
            $resBody = mysqli_query($conn, $Sql2);
            if (mysqli_num_rows($resBody) > 0) {
                $data = mysqli_fetch_assoc($resBody);
                $count = $data['total'];
            }
            $maxx = $count * $max;
            if ($suhlasAdmin == 0 && !isset($showsuhlas)) {
                if (!isset($_SESSION['lang']) || $_SESSION['lang'] == 'sk') :
                    echo "<div id='wrap'><div class='container'><div class='row'>
                <form class='form-horizontal' method='post' name='upload_excel'
                      enctype='multipart/form-data'><fieldset><div class=\"form-group\">
                  <label class=\"col-md-4 control-label\" for=\"radios\"></label>
                  <div class=\"col-md-4\"> 
                    <label class=\"radio-inline\" for=\"radios-0\">
                      <input type=\"radio\" name=\"radio\" id=\"radios-0\" value=\"1\">
                      Suhlas
                    </label> 
                    <label class=\"radio-inline\" for=\"radios-1\">
                      <input type=\"radio\" name=\"radio\" id=\"radios-1\" value=\"0\">
                      Nesúhlas
                    </label>
                  </div>
                </div>";
                    echo "<div class=\"form-group\">
                            <label class=\"col-md-4 control-label\" for=\"singlebutton\"></label>
                            <div class=\"col-md-4\">
                                <button type='submit' id='submit'  name='Suhlas'
                                        class='btn btn-primary button-loading'
                                        data-loading-text=\"Loading...\">Potvrď
                                </button>
                            </div>
                        </div>

                    </fieldset>
                </form>
            </div>
        </div>";
                elseif ($_SESSION['lang'] == 'en') :
                    echo "<div id='wrap'><div class='container'><div class='row'>
                <form class='form-horizontal' method='post' name='upload_excel'
                      enctype='multipart/form-data'><fieldset><div class=\"form-group\">
                  <label class=\"col-md-4 control-label\" for=\"radios\"></label>
                  <div class=\"col-md-4\"> 
                    <label class=\"radio-inline\" for=\"radios-0\">
                      <input type=\"radio\" name=\"radio\" id=\"radios-0\" value=\"1\">
                      Confirm
                    </label> 
                    <label class=\"radio-inline\" for=\"radios-1\">
                      <input type=\"radio\" name=\"radio\" id=\"radios-1\" value=\"0\">
                      Decline
                    </label>
                  </div>
                </div>";
                    echo "<div class=\"form-group\">
                            <label class=\"col-md-4 control-label\" for=\"singlebutton\"></label>
                            <div class=\"col-md-4\">
                                <button type='submit' id='submit'  name='Suhlas'
                                        class='btn btn-primary button-loading'
                                        data-loading-text=\"Loading...\">Confirm
                                </button>
                            </div>
                        </div>

                    </fieldset>
                </form>
            </div>
        </div>";
                endif;

            } else {
                if (!isset($_SESSION['lang']) || $_SESSION['lang'] == 'sk') :
                    echo "<div class='container'><h1> Stav akceptovania bodovania: " . $adminResp . "</h1>";
                elseif ($_SESSION['lang'] == 'en') :
                    echo "<div class='container'><h1> State of points confirming: " . $adminResp . "</h1>";
                endif;
            }
            if ($arebody == 0) {
                if (!isset($_SESSION['lang']) || $_SESSION['lang'] == 'sk') :
                echo "<div id='wrap'><div class='container'><div class='row'>
                <form class='form-horizontal' method='post' name='upload_excel'
                      enctype='multipart/form-data'>
                      <fieldset><div class='form-group'><label class='col-md-4 control-label' for='predmet'>Body:</label>
                      <div class='col-md-2'><input id='body' name='body' type='number' min='0' max='$maxx' class='form-control input-md' required=''></div></div>";
                echo "<div class=\"form-group\">
                            <label class=\"col-md-4 control-label\" for=\"singlebutton\"></label>
                            <div class=\"col-md-4\">
                                <button type='submit' id='submit'  name='Update'
                                        class='btn btn-primary button-loading'
                                        data-loading-text=\"Loading...\">Udeľ
                                </button>
                            </div>
                        </div>

                    </fieldset>
                </form>
            </div>
        </div>";
                elseif ($_SESSION['lang'] == 'en') :
                    echo "<div id='wrap'><div class='container'><div class='row'>
                <form class='form-horizontal' method='post' name='upload_excel'
                      enctype='multipart/form-data'>
                      <fieldset><div class='form-group'><label class='col-md-4 control-label' for='predmet'>Points:</label>
                      <div class='col-md-2'><input id='body' name='body' type='number' min='0' max='$maxx' class='form-control input-md' required=''></div></div>";
                    echo "<div class=\"form-group\">
                            <label class=\"col-md-4 control-label\" for=\"singlebutton\"></label>
                            <div class=\"col-md-4\">
                                <button type='submit' id='submit'  name='Update'
                                        class='btn btn-primary button-loading'
                                        data-loading-text=\"Loading...\">Give
                                </button>
                            </div>
                        </div>

                    </fieldset>
                </form>
            </div>
        </div>";
                    endif;


            }
        }
    }

}

if (isset($_POST["Export"])) {

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=data.csv');
    $output = fopen("php://output", "w");
    fputcsv($output, array('ID', 'meno', 'body'));
    global $conn;
    $query = "SELECT ID, meno, rozdelenie from uloha2admin ";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($output, $row);
    }
    fclose($output);
}
?>

