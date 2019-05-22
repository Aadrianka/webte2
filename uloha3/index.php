<?php
session_start();
if (isset($_SESSION['lang']) && !empty($_SESSION['lang'])) {
    if ($_SESSION['lang'] === 'en')
        include 'lang/en.php';
    else
        include 'lang/sk.php';
} else
    include 'lang/sk.php';
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <?php
    if (!isset($_SESSION['admin']) || !$_SESSION['admin']) {
        echo "<meta http-equiv='refresh' content='2;url=../' />";
        echo "<div style='margin: 0 auto; background-color: white; padding:50px; text-align: center;'><p>Je potrebné prihlásenie <b>ako admin</b>, budete presmerovaný</p></div>";
    }
    else {
    ?>
    <title>Administrácia virtuálneho stroja</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
          integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
</head>
<body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
<script src="../vendor/application/scripts/jquery.min.js"></script>
<script src="js/scripts.js"></script>
<script src="../vendor/application/scripts/jquery.sortElements.js"></script>

<!--<ul>-->
<!--    <li><a href="../">Domov</a></li>-->
<!--    <li><a href="../uloha1">Úloha1</a></li>-->
<!--    <li><a href="../uloha2">Úloha2</a></li>-->
<!--    <li><a class="active" href="#">Úloha3</a></li>-->
<!--    <li style="float: right"><a href="../uloha2">Odhlasiť sa</a></li>-->
<!--    <li style="float: right"><a href="#">EN</a></li>-->
<!--    <li style="float: right"><a class="active" href="#">SK</a></li>-->
<!--</ul>-->
<!--<br>-->

<div id="header-wrapper">
    <div id="header" class="container">
        <div id="logo">
            <img src="../images/stu.png" width="330" height="120" alt="logo"/>
        </div>
        <div id="menu">
            <ul>
                <li><a href="../index.php" accesskey="1" title=""><?= $T['Domov'] ?></a></li>
                <li><a href="../uloha1.php" accesskey="2" title=""><?= $T['Uloha1'] ?></a></li>
                <li><a href="../uloha2.php" accesskey="3" title=""><?= $T['Uloha2'] ?></a></li>
                <li class="active"><a href="#" accesskey="4" title=""><?= $T['Uloha3'] ?></a></li>
                <li><a href="../rozdel.php" accesskey="5" title=""><?= $T['Rozdelenie úloh'] ?></a></li>
            </ul>
        </div>
    </div>
</div>
<div style="background-color: white; padding-bottom: 200px">
    <div style="padding: 10px; max-width: 1300px; margin: 0 auto;">
        <div class="row" style="padding: 20px;">
            <div class="column" style="padding-right: 50px">
                <h2><?= $T['Generovanie hesiel'] ?></h2>
                <hr>
                <div class="column-body">
                    <form id="first-upload" method="post">
                        <div class="row" style="width: 100%;">
                            <div style="width: auto;">
                                <div class="custom-file">
                                    <input name="csv-first" type="file" class="custom-file-input" id="csv-first"
                                           required>
                                    <label class="custom-file-label" for="csv-first">CSV <?= $T['súbor']?>: </label>
                                    <div class="invalid-feedback">Povolené sú len .csv súbory!</div>
                                </div>
                            </div>
                            <div style="width: 70px; margin-left: 20px">
                                <div class="form-group">
                                    <input name="first-delimiter" id="first-delimiter" type="text"
                                           style="display: none;">
                                    <button id="b-del1" type="button" class="delimiter floated"
                                            onclick="setDelimiter(1, 1, ',')">,
                                    </button>
                                    <button id="b-del2" type="button" class="delimiter floated"
                                            onclick="setDelimiter(2, 1, ';')">;
                                    </button>
                                </div>
                            </div>
                            <div style="width: 20%; margin-left: 1px">
                                <button class="btn btn-primary" type="submit"
                                        name="submit"><?= $T['Odoslať'] ?></button>
                            </div>
                        </div>
                    </form>
                    <div style="margin: 50px 0;">
                        <table class="table table-bordered" id="first-file-table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col"><?= $T['Názov súboru'] ?></th>
                                <th scope="col"><?= $T['Čas nahratia'] ?></th>
                                <th scope="col"><?= $T['Stiahnúť'] ?></th>
                            </tr>
                            <tr>
                                <td colspan="4" style="text-align: center">Žiadné výsledky</td>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <div class="column">
                <h2><?= $T['Rozposlanie mailov'] ?></h2>
                <hr>
                <div class="column-body">
                    <form id="second-upload" method="POST">
                        <div class="row" style="width: 100%;">
                            <div style="width: auto;">
                                <div class="custom-file">
                                    <input name="csv-second" type="file" class="custom-file-input" id="csv-second"
                                           required>
                                    <label class="custom-file-label" for="csv-first">CSV <?= $T['súbor']?>: </label>
                                    <div class="invalid-feedback">Povolené sú len .csv súbory!</div>
                                </div>
                            </div>
                            <div style="width: 70px; margin-left: 20px">
                                <div class="form-group">
                                    <input name="second-delimiter" id="second-delimiter" type="text"
                                           style="display: none;">
                                    <button id="b-del3" type="button" class="delimiter floated"
                                            onclick="setDelimiter(3, 2, ',')">,
                                    </button>
                                    <button id="b-del4" type="button" class="delimiter floated"
                                            onclick="setDelimiter(4, 2, ';')">;
                                    </button>
                                </div>
                            </div>
                            <div style="width: 20%; margin-left: 1px">
                                <button class="btn btn-primary" type="submit" name="submit" data-toggle="modal"
                                        data-target="#myModal"><?= $T['Odoslať'] ?>
                                </button>
                            </div>
                        </div>
                    </form>
                    <div style="margin: 50px 0;">
                        <table class="table table-bordered" id="second-file-table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col"><?= $T['Názov súboru'] ?></th>
                                <th scope="col"><?= $T['Čas nahratia'] ?></th>
                                <th scope="col"><?= $T['Stiahnúť'] ?></th>
                            </tr>
                            <tr>
                                <td colspan="4" style="text-align: center">Žiadné výsledky</td>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top: 200px; padding: 20px">
            <div class="column" style="padding-right: 80px">
                <h2><?= $T['Šablóny mailu'] ?>
                    <button class="btn fas fa-plus-square fa-1x" style="margin-left: 20px" data-toggle="modal"
                            data-target="#template-modal"></button>
                </h2>
                <hr>
                <div class="column-body">
                    <table class="table table-bordered" id="template-table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col"><?= $T['Názov'] ?></th>
                            <th scope="col"><?= $T['Typ'] ?></th>
                            <th scope="col"><?= $T['Vytvorená'] ?></th>
                            <th scope="col"><?= $T['Akcia'] ?></th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="column">
                <h2><?= $T['Odoslané maily'] ?><button class="btn fas fa-eye fa-1x" style="margin-left: 20px" data-toggle="modal"
                                                       data-target="#log-mail-all-modal"></button></h2>
                <hr>
                <div class="column-body">
                    <table class="table table-bordered" id="log-file-table" style="padding-bottom: 200px">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Email</th>
                            <th scope="col"><?= $T['Predmet'] ?></th>
                            <th scope="col"><?= $T['ID šablóny'] ?></th>
                            <th scope="col"><?= $T['Čas odoslania'] ?></th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- The Modal -->
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title"><?= $T['Odoslanie mailov'] ?></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div>
                        <form id="send-message">
                            <div class="form-group">
                                <select class="form-control" id="template-select" name="template-select">
                                    <!--                                <option class="loading-select" value="#">Vyberte šablónu..</option>-->
                                </select>
                            </div>
                            <div class="form-group">
                                <select class="form-control" id="files-select" name="files-select">
                                    <!--                                <option class="loading-select" value="#">Vyberte súbor..</option>-->
                                </select>
                            </div>
                            <br>
                            <div class="input-group mb-3">
                                <input class="form-control" type="text" name="sender-name" id="sender-name"
                                       placeholder="<?= $T['Meno odosielateľa'] ?>" required>
                                <div class="input-group-append">
                                    <span class="input-group-text fas fa-id-card"></span>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input class="form-control" type="text" name="sender-mail" id="sender-mail"
                                       placeholder="<?= $T['Email odosielateľa'] ?>" required>
                                <div class="input-group-append">
                                    <span class="input-group-text fas fa-at"></span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <div class="input-group mb-3">
                                        <input class="form-control" type="text" name="user" id="user"
                                               placeholder="Login"
                                               required>
                                        <div class="input-group-append">
                                            <span class="input-group-text fas fa-user"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="input-group mb-3">
                                        <input class="form-control" type="password" name="password" id="password"
                                               placeholder="<?= $T['Heslo'] ?>" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text fas fa-lock"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="input-group mb-3">
                                <input class="form-control" type="text" name="subject" id="subject"
                                       placeholder="<?= $T['Predmet správy'] ?>" required>
                                <div class="input-group-append">
                                    <span class="input-group-text fas fa-paper-plane"></span>
                                </div>
                            </div>
                            <div class="custom-file mb-3">
                                <input name="attachment" type="file" class="custom-file-input" id="attachment">
                                <label class="custom-file-label" for="attachment"><?= $T['Súbor v prílohe:'] ?> </label>
                                <div class="invalid-feedback">Chyba pri nahravaní súboru</div>
                            </div>
                            <button id="send-messages" type="button" class="btn btn-primary" data-dismiss="modal"
                                    style="display: none;"><?= $T['Zavrieť'] ?>
                            </button>
                            <button class="btn btn-primary float-right" type="submit"
                                    id="template-submit"><?= $T['Odoslať'] ?>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">

                </div>

            </div>
        </div>
    </div>

    <div class="modal" id="template-modal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title"><?= $T['Vytvoriť šablónu'] ?></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div>
                        <form name="template-modal-form" id="template-modal-form" method="post">
                            <div class="input-group mb-3">
                                <input class="form-control" type="text" name="template-name" id="template-name"
                                       placeholder="<?= $T['Názov šablóny'] ?>" required>
                                <div class="input-group-append">
                                    <span class="input-group-text fas fa-file-alt"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <select class="form-control" id="template-type" name="template-type">
                                    <option value="1">text/plain</option>
                                    <option value="2">text/html</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="template-text"><?= $T['Šablóna:'] ?></label>
                                <textarea class="form-control" name="template-text" id="template-text"
                                          required></textarea>
                            </div>
                            <button id="template-add-close" type="button" class="btn btn-primary" data-dismiss="modal"
                                    style="display: none;"><?= $T['Zavrieť'] ?>
                            </button>
                            <button class="btn btn-primary float-right" type="submit"
                                    id="template-add-submit"><?= $T['Vytvoriť'] ?>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">

                </div>

            </div>
        </div>
    </div>


    <!-- Show all -->
    <div class="modal" id="log-mail-all-modal">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title"><?= $T['Odoslané maily'] ?></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div>
                        <table class="table table-bordered" id="log-mail-all-table">
                            <thead>
                            <tr>
                                <th scope="col" class="sortable">#</th>
                                <th scope="col" class="sortable">Email</th>
                                <th scope="col" class="sortable"><?= $T['Predmet'] ?></th>
                                <th scope="col" class="sortable"><?= $T['ID šablóny'] ?></th>
                                <th scope="col" class="sortable"><?= $T['Čas odoslania'] ?></th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">

                </div>

            </div>
        </div>
    </div>
</div>
<div class="sticky-footer">
    <img id="sk" style="width: 50px" alt="SK" src="../images/sk.png">
    <img id="en" style="width: 50px" alt="EN" src="../images/gb.jpg">
</div>
<!--<script src="../vendor/application/scripts/jquery.min.js"></script>-->
</body>
</html>
<?php } ?>