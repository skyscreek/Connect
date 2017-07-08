<?php
include('klassen/DB.php');

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    if (DB::query('SELECT username FROM nutzer WHERE username=:username', array(':username'=>$username))) {

        if (password_verify($password, DB::query('SELECT password FROM nutzer WHERE username=:username', array(':username'=>$username))[0]['password'])) {
            echo 'Willkommen bei connect!';

        } else {

            echo 'Dein Passwort ist falsch!';
        }

    } else {
        echo 'Dieser Benutzer existiert nicht!';
    }
}
?>
<h1>Bei Connect anmelden</h1>
<form action="anmeldung.php" method="post">
    <input type="text" name="username" value="" placeholder="Benutzername ..."><p />
    <input type="password" name="password" value="" placeholder="Passwort ..."><p />
    <input type="submit" name="login" value="Anmelden">
</form>


