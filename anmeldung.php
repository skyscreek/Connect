
<!DOCTYPE html>
<html>
<head>
    <title>Wilkommen bei Connect</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">


    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <link href="gestaltung/hintergrund.css" rel="stylesheet" />


</head>
<body>
<?php
include('klassen/DB.php');

if (isset($_POST['anmeldung'])) {

    $nutzername = $_POST['nutzername'];
    $passwort = $_POST['passwort'];

    if (DB::query('SELECT nutzername FROM nutzer WHERE nutzername=:nutzername', array(':nutzername'=>$nutzername))) {

        if (password_verify($passwort, DB::query('SELECT passwort FROM nutzer WHERE nutzername=:nutzername', array(':nutzername'=>$nutzername))[0]['passwort'])) {
            header ("Location: profil.php?nutzername=$nutzername");

            $cstrong = True;
            $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
            $nutzerid = DB::query('SELECT id FROM nutzer WHERE nutzername=:nutzername', array(':nutzername'=>$nutzername))[0]['id'];
            DB::query('INSERT INTO login_tokens VALUES (\'\', :token, :nutzer_id)', array(':token'=>sha1($token), ':nutzer_id'=>$nutzerid));

            setcookie("CID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
            setcookie("CID_", '1', time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);

        } else {

            echo '<h1>Dein Nutzername oder Passwort ist falsch!</h1>';
        }

    } else {
        echo '<h1>Dieser Nutzer existiert nicht!</h1>';
    }
}
?>
<div class="container connect">
    <div class="row">
        <div class="col-md-offset-4 col-md-4 col-sm-offset-3 col-sm-6">
            <div class="panel" style="padding: 20px">
                <h1>– Connect –</h1>
                </br>
                <h4>Deine Microblogging Plattform</h4>
                </br>

                <form action="anmeldung.php" method="post">

                    <div class="form-group">
                        <input type="text" name="nutzername" class="form-control" value="" placeholder="Nutzername ..."><p />
                    </div>
                    <div class="form-group">
                        <input type="password" name="passwort" class="form-control" value="" placeholder="Passwort ..."><p />
                    </div>
                    <div class="form-group">
                        <input type="submit" name="anmeldung" class="form-control" value="Anmelden!"><p />
                    </div>
                </form>
                <div class="form-group">
                    <button type="link" class="form-control"  onclick="location='nutzer-erstellen.php'">Jetzt registrieren</button>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>


