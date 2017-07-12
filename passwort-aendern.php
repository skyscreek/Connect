<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Connect – DAS Netzwerk</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">


    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <link href="gestaltung/hintergrund.css" rel="stylesheet" />

</head>
<body>
<?php
include('./klassen/DB.php');
include('./klassen/anmeldung_klasse.php');
$nutzername1 = anmeldung_klasse::isLoggedIn();
$nutzername1 = DB::query('SELECT nutzername FROM nutzer WHERE id=:nutzername', array(':nutzername'=>$nutzername1));
foreach ($nutzername1 as $nutzername2) {
    $nutzername=$nutzername2['nutzername'];
}
if (anmeldung_klasse::isLoggedIn()) {
    if (isset($_POST['passwortaendern'])) {
        $altespasswort = $_POST['altespasswort'];
        $neuespasswort = $_POST['neuespasswort'];
        $neuespasswortwiederholen = $_POST['neuespasswortwiederholen'];
        $nutzerid = anmeldung_klasse::isLoggedIn();
        if (password_verify($altespasswort, DB::query('SELECT passwort FROM nutzer WHERE id=:nutzerid', array(':nutzerid'=>$nutzerid))[0]['passwort'])) {
            if ($neuespasswort == $neuespasswortwiederholen) {
                if (strlen($neuespasswort) >= 6 && strlen($neuespasswort) <= 60) {
                    DB::query('UPDATE nutzer SET passwort=:neuespasswort WHERE id=:nutzerid', array(':neuespasswort'=>password_hash($neuespasswort, PASSWORD_BCRYPT), ':nutzerid'=>$nutzerid));
                    echo '<h1>Dein Passwort wurde erfolgreich geändert</h1>';
                }
            } else {
                echo '<h1>Passwörter stimmen nicht überein!</h1>';
            }
        } else {
            echo '<h1>altes Passwort falsch!</h1>';
        }
    }
} else {
    die('Du bist nicht eingeloggt');
}
?>
<div class="container connect">
    <div class="row">
        <div class="col-md-offset-4 col-md-4 col-sm-offset-3 col-sm-6">
            <div class="panel" style="padding: 20px">

                <h1>Ändere dein Passwort</h1>
                </br>
                </br>
                <form action="passwort-aendern.php" method="post">
                    <div class="form-group">
                        <input type="password" name="altespasswort" class="form-control" value="" placeholder="Aktuelles Passwort ..."><p />
                    </div>
                    <div class="form-group">
                        <input type="password" name="neuespasswort" class="form-control" value="" placeholder="Neues Passwort ..."><p />
                    </div>
                    <div class="form-group">
                        <input type="password" name="neuespasswortwiederholen" class="form-control" value="" placeholder="Passwort wiederholen"><p />
                    </div>

                    <button type="submit" name="passwortaendern" class="form-control" value="Passwort ändern">Passwort ändern!</button>
                </form>
                <h5>oder...</h5>
                </br>
                <div class="form-group">
                    <button type="link" class="form-control"  onclick="location='profil.php?nutzername=<?php echo $nutzername; ?>'">Zurück zum Profil</button>
                </div>

            </div>
        </div>
    </div>
</div>
</body>
</html>
