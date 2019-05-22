<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title></title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900|Quicksand:400,700|Questrial" rel="stylesheet" />
    <link href="default.css" rel="stylesheet" type="text/css" media="all" />
    <link href="fonts.css" rel="stylesheet" type="text/css" media="all" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
          crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900|Quicksand:400,700|Questrial"
          rel="stylesheet"/>

    <!--[if IE 6]><link href="default_ie6.css" rel="stylesheet" type="text/css" /><![endif]-->

</head>
<body>
<?php
session_start();
?>
<div id="header-wrapper">
    <div id="header" class="container">
        <div id="logo">
            <img src="images/stu.png" width="330" height="120" alt="logo" />
        </div>
        <div id="menu">
            <ul>
                <?php if (!isset($_SESSION['lang']) || $_SESSION['lang'] == 'sk') : ?>

                    <li ><a href="index.php" accesskey="1" title="">Domov</a></li>
                    <li ><a href="uloha1.php" accesskey="2" title="">Uloha1</a></li>
                    <li><a href="uloha2.php" accesskey="3" title="">Uloha2</a></li>
                    <li><a href="uloha3/index.php" accesskey="4" title="">Uloha3</a></li>
                    <li class="active"><a href="rozdel.php" accesskey="5" title="">Rozdelenie �loh</a></li>
                <?php elseif ($_SESSION['lang'] == 'en') : ?>
                    <li ><a href="index.php" accesskey="1" title="">Home</a></li>
                    <li><a href="uloha1.php" accesskey="2" title="">Task 1</a></li>
                    <li><a href="uloha2.php" accesskey="3" title="">Task 2</a></li>
                    <li><a href="uloha3/index.php" accesskey="4" title="">Task 3</a></li>
                    <li class="active"><a href="rozdel.php" accesskey="5" title="">Divisions tasks</a></li>
                <?php endif; ?>            </ul>
        </div>
    </div>
</div>

<div class="wrapper">
    <h1>Rozdelenie úloh</h1>
    
    
<div class="table-responsive"><table id="myTable" class="table table-striped table-bordered">;
<tr>
    <th colspan="2">Úloha 1 + úvodná stránka + preklad + prihlasovanie</th>
    <th colspan="2">Úloha 2 - Používatelia + štatistika + rozdelenie úloh</th> 
    <th colspan="2">Úloha 2 - Admin + dizajn stránky</th>
    <th colspan="2">Úloha 3</th>
  </tr>
    
<tr>
<td colspan="2">Adriana Selepová</td>
<td colspan="2">Zuzana Chalupková</td>
<td colspan="2">Martin Hrebeňák</td>
<td colspan="2">Daniel Marinič</td>
</tr>
    
<tr>
<td align="center"><img src="foto4.jpg" alt="Adriana" width = "100" > </td>
<td>email: xselepova@is.stuba.sk</td>
<td align="center"><img src="foto1.jpg" alt="Zuzana" width = "100" > </td>
<td>email: xchalupkovaz@is.stuba.sk</td>
<td align="center"><img src="foto2.jpg" alt="Martin" width = "100" > </td>
<td>email: xhrebenak@is.stuba.sk</td>
<td align="center"><img src="foto3.jpg" alt="Daniel" width = "100" > </td>
<td>email: xmarinic@is.stuba.sk</td>
</tr>    
    
</table></div>
    
    <a HREF="Dokumentacia_tim22.pdf"> Technická dokumentácia</a>
    
    <div id="cookieConsent">
    <div id="closeCookieConsent">x</div>
    This website is using cookies. <a href="#" target="_blank">More info</a>. <a class="cookieConsentOK">That's Fine</a>
</div>
    
    <script>
        $(document).ready(function(){   
    setTimeout(function () {
        $("#cookieConsent").fadeIn(200);
     }, 4000);
    $("#closeCookieConsent, .cookieConsentOK").click(function() {
        $("#cookieConsent").fadeOut(200);
    }); 
});
    
    </script>
    
</div>

</body>
</html>