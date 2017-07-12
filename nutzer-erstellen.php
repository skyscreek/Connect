
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
include('klassen/DB.php');

if (isset($_POST['nutzer-erstellen'])) {
    $nutzername = $_POST['nutzername'];
    $passwort = $_POST['passwort'];
    $email = $_POST['email'];

    if (!DB::query('SELECT nutzername FROM nutzer WHERE nutzername=:nutzername', array(':nutzername'=>$nutzername))) {

        if (strlen($nutzername) >= 3 && strlen($nutzername) <= 32) {

            if (preg_match('/[a-zA-Z0-9_]+/', $nutzername)) {

                if (strlen($passwort) >= 6 && strlen($passwort) <= 60) {

                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        if (!DB::query('SELECT email FROM nutzer WHERE email=:email', array(':email'=>$email))) {
                            DB::query('INSERT INTO nutzer VALUES (\'\', :nutzername, :passwort, :email)', array(':nutzername'=>$nutzername, ':passwort'=>password_hash($passwort, PASSWORD_BCRYPT), ':email'=>$email));

                            echo "<h1>Deine Registrierung war erfolgreich!</h1></br><h1>du wirst in 5 Sekunden weitergeleitet...</h1>";
                            header( "refresh:5;url=anmeldung.php" );


                        } else {
                            echo "<h1>Die Email existiert bereits!</h1>";
                        }

                    } else {
                        echo '<h1>Deine Email Adresse ist falsch!</h1>';
                    }

                } else {
                    echo '<h1>Dein Passwort ist zu lang oder zu kurz!</h1>';
                }

            } else {
                echo '<h1>Dein Benutzername ist falsch</h1>';
            }

        } else {
            echo '<h1>Dein Benutzername ist falsch</h1>';

        }
    } else {
        echo '<h1>Dieser Benutzer existiert schon!</h1>';
    }
}
?>
<div class="container connect">
    <div class="row">
        <div class="col-md-offset-4 col-md-4 col-sm-offset-3 col-sm-6">
            <div class="panel" style="padding: 20px">

                <h1>Jetzt registrieren</h1>
                </br>
                </br>
                <form action="nutzer-erstellen.php" method="post">
                    <div class="form-group">
                        <input type="text" name="nutzername" class="form-control" value="" placeholder="Benutzername ..."><p />
                    </div>
                    <div class="form-group">
                        <input type="password" name="passwort" class="form-control" value="" placeholder="Passwort ..."><p />
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" value="" placeholder="email@mailanbieter.de"><p />
                    </div>

                    <button type="submit" name="nutzer-erstellen" class="form-control" value="Nutzer Erstellen">Jetzt registrieren!</button>
                </form>

            </div>
        </div>
    </div>
</div>
</body>
</html>



