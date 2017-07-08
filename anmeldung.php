<?php
include('klassen/DB.php');

if (isset($_POST['login'])) {

    $nutzername = $_POST['nutzername'];
    $passwort = $_POST['passwort'];

    if (DB::query('SELECT nutzername FROM nutzer WHERE nutzername=:nutzername', array(':nutzername'=>$nutzername))) {

        if (password_verify($passwort, DB::query('SELECT passwort FROM nutzer WHERE nutzername=:nutzername', array(':nutzername'=>$nutzername))[0]['passwort'])) {
            echo 'Willkommen bei Connect!';
            }
        else {

            echo 'Dein Passwort ist falsch!';
        }

    } else {
        echo 'Dieser Benutzer existiert nicht!';
    }
}
?>
<h1>Bei Connect anmelden</h1>
<form action="anmeldung.php" method="post">
    <input type="text" name="nutzername" value="" placeholder="Benutzername ..."><p />
    <input type="password" name="passwort" value="" placeholder="Passwort ..."><p />
    <input type="submit" name="login" value="Anmelden">
</form>


