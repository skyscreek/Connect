<?php
include('./klassen/DB.php');
include('./klassen/anmeldung_klasse.php');
$nutzername = "";
$folgtgerade = False;
if (isset($_GET['nutzername'])) {
    if (DB::query('SELECT nutzername FROM nutzer WHERE nutzername=:nutzername', array(':nutzername'=>$_GET['nutzername']))) {
        $nutzername = DB::query('SELECT nutzername FROM nutzer WHERE nutzername=:nutzername', array(':nutzername'=>$_GET['nutzername']))[0]['nutzername'];
        $nutzerid = DB::query('SELECT id FROM nutzer WHERE nutzername=:nutzername', array(':nutzername'=>$_GET['nutzername']))[0]['id'];
        $folgerid = anmeldung_klasse::isLoggedIn();

        if (isset($_POST['folgt'])) {
            if ($nutzerid != $folgerid) {
                if (!DB::query('SELECT folger_id FROM folger WHERE nutzer_id=:nutzerid', array(':nutzerid'=>$nutzerid))) {
                    DB::query('INSERT INTO folger VALUES (\'\', :nutzerid, :folgerid)', array(':nutzerid'=>$nutzerid, ':folgerid'=>$folgerid));
                } else {
                    echo 'Du folgst diesem Nutzer bereits!';
                }
                $folgtgerade = True;
            }
        }
        if (isset($_POST['entfolgen'])) {
            if ($nutzerid != $folgerid) {
                if (DB::query('SELECT folger_id FROM folger WHERE nutzer_id=:nutzerid', array(':nutzerid'=>$nutzerid))) {
                    DB::query('DELETE FROM folger WHERE nutzer_id=:nutzerid AND folger_id=:folgerid', array(':nutzerid'=>$nutzerid, ':folgerid'=>$folgerid));
                }
                $folgtgerade = False;
            }
        }
        if (DB::query('SELECT folger_id FROM folger WHERE nutzer_id=:nutzerid', array(':nutzerid'=>$nutzerid))) {
            //echo 'Already following!';
            $folgtgerade = True;
        }
        if (isset($_POST['absenden'])) {
            $inhalt = $_POST['inhalt'];
            $aktivenutzerid = anmeldung_klasse::isLoggedIn();
            if (strlen($inhalt) > 160 || strlen($inhalt) < 1) {
                die('Der Beitrag hat nicht die passende Länge!');
            }
            if ($aktivenutzerid == $nutzerid) {
                DB::query('INSERT INTO posts VALUES (\'\', :inhalt, NOW(), :nutzerid)', array(':inhalt'=>$inhalt, ':nutzerid'=>$nutzerid));
            } else {
                die('Falscher user!');
            }
        }
    } else {
        die('Nutzer wurde nicht gefunden!');
    }
}
?>
<h1><?php echo $nutzername; ?>'s Profil</h1>
<form action="profil.php?nutzername=<?php echo $nutzername; ?>" method="post">
    <?php
    if ($nutzerid != $folgerid) {
        if ($folgtgerade) {
            echo '<input type="submit" name="entfolgen" value="entfolgen">';
        } else {
            echo '<input type="submit" name="folgt" value="folgen">';
        }
    }
    ?>
</form>

</div>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Connect</title>


    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">


    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <link href="gestaltung/hintergrund.css" rel="stylesheet" />
    <link href="gestaltung/profil.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<div class="container">

    <!-- Static navbar -->
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Connect</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#">Mein Profil</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="active"><a href="abmeldung.php">Abmelden</a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
    </nav>

    <!-- Main component for a primary marketing message or call to action -->
    <div class="jumbotron">
        <h2>Meine Posts</h2>
        </br>
        <form action="profil.php?nutzername=<?php echo $nutzername; ?>" method="post">
            <textarea name="inhalt" rows="8" cols="80"></textarea>
            </br>
            </br>

            <input class="btn btn-lg btn-primary" type="submit" name="absenden" value="Absenden">
        </form>
        <div class="posts">
            <?php echo $posts; ?>

        </div>

    </div> <!-- /container -->



