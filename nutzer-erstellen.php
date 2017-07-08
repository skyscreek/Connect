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

                        echo "Deine Registrierung war erfolgreich!";

                    } else {
                        echo 'Email existiert bereits!';
                    }

                    } else {
                        echo 'Deine Email Adresse ist falsch!';
                    }

                } else {
                    echo 'Dein Passwort ist falsch!';
                }

            } else {
                echo 'Dein Benutzername ist falsch';
            }

        } else {
            echo 'Dein Benutzername ist falsch';

        }
    } else {
        echo 'Dieser Benutzer existiert schon!';
    }
}
?>


<h1>Jetzt bei Connect registrieren!</h1>
<form action="nutzer-erstellen.php" method="post">
    <input type="text" name="nutzername" value="" placeholder="Benutzername ..."><p />
    <input type="password" name="passwort" value="" placeholder="Passwort ..."><p />
    <input type="email" name="email" value="" placeholder="email@mailanbieter.de"><p />
    <input type="submit" name="nutzer-erstellen" value="Nutzer Erstellen">
</form>
