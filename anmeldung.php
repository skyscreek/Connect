<?php
include('Klassen/DB.php');
if (isset($_POST['anmeldung'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (DB::query('SELECT username FROM nutzer WHERE username=:username', array(':username'=>$username))) {
        if (password_verify($password, DB::query('SELECT password FROM nutzer WHERE username=:username', array(':username'=>$username))[0]['password'])) {
            echo 'Willkommen!';
        } else {
            echo 'Falsches Passwort!';
        }
    } else {
        echo 'Nutzer existiert nicht!';
    }
}
?>
<h1>Login to your account</h1>
<form action="anmeldung.php" method="post">
    <input type="text" name="username" value="" placeholder="Nutzername ..."><p />
    <input type="password" name="password" value="" placeholder="Passwort ..."><p />
    <input type="submit" name="login" value="Anmelden">
</form>
/**
 * Created by PhpStorm.
 * User: Noa
 * Date: 07.07.17
 * Time: 18:54
 */