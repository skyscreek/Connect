
<!DOCTYPE html>
<html>
<head>
    <title>Connect– DAS Netzwerk</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link href="gestaltung/hintergrund.css" rel="stylesheet" />
    <link href="gestaltung/profil.css" rel="stylesheet" />

    <!-- Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>



</head>
<body>
<?php
include('./klassen/DB.php');
include('./klassen/anmeldung_klasse.php');
if (!anmeldung_klasse::isLoggedIn()) {
    header ("Location: anmeldung.php");
}
$nutzername1 = anmeldung_klasse::isLoggedIn();
$nutzername1 = DB::query('SELECT nutzername FROM nutzer WHERE id=:nutzername', array(':nutzername'=>$nutzername1));
foreach ($nutzername1 as $nutzername2) {
    $nutzername=$nutzername2['nutzername'];
}
if (isset($_POST['bestaetigen'])) {
    if (isset($_POST['allegeraete'])) {

        DB::query('DELETE FROM login_tokens WHERE nutzer_id=:nutzerid', array(':nutzerid'=>anmeldung_klasse::isLoggedIn()));
        echo "<h1>Du wurdest erfolgreich abgemeldet!</h1></br><h4>du wirst in 5 Sekunden weitergeleitet...</h4>";
        header( "refresh:5;url=anmeldung.php" );
    } else {
        if (isset($_COOKIE['CID'])) {
            DB::query('DELETE FROM login_tokens WHERE token=:token', array(':token'=>sha1($_COOKIE['CID'])));
            echo "<h1>Du wurdest erfolgreich abgemeldet!</h1></br><h4>du wirst in 5 Sekunden weitergeleitet...</h4>";
            header( "refresh:5;url=anmeldung.php" );
        }
        setcookie('CID', '1', time()-3600);
        setcookie('CID_', '1', time()-3600);
    }
}
?>
<div class="container connect">
    <div class="row">
        <div class="col-md-offset-4 col-md-4 col-sm-offset-3 col-sm-6" >
            <div class="panel" style="padding: 20px">
                <h2 class="margin-base-vertical">Bist du dir sicher, dass du dich abmelden willst?</h2>

                <form action="abmeldung.php" method="post">
                    <div>

                        <h4><input type="checkbox" name="allegeraete" value="alle Geräte">&nbsp;&nbsp;Auf allen Geräten abmelden?</></h4>

                        </br>
                        </br>
                        <input class="form-control" type="submit" name="bestaetigen" value="Bestätigen">
                        </label
                        </br>
                    </div>
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

