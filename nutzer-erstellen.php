<?php
include('klassen/DB.php');

if (isset($_POST['nutzer-erstellen'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    if (!DB::query('SELECT username FROM nutzer WHERE username=:username', array(':username'=>$username))) {

        if (strlen($username) >= 3 && strlen($username) <= 32) {

            if (preg_match('/[a-zA-Z0-9_]+/', $username)) {

                if (strlen($password) >= 6 && strlen($password) <= 60) {

                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        if (!DB::query('SELECT email FROM nutzer WHERE email=:email', array(':email'=>$email))) {
                            DB::query('INSERT INTO nutzer VALUES (\'\', :username, :password, :email)', array(':username'=>$username, ':password'=>password_hash($password, PASSWORD_BCRYPT), ':email'=>$email));

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
    <input type="text" name="username" value="" placeholder="Benutzername ..."><p />
    <input type="password" name="password" value="" placeholder="Passwort ..."><p />
    <input type="email" name="email" value="" placeholder="email@mailanbieter.de"><p />
    <input type="submit" name="nutzer-erstellen" value="Nutzer Erstellen">
</form>
