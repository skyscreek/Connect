<?php
include('klassen/DB.php');

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    if (DB::query('SELECT username FROM nutzer WHERE username=:username', array(':username'=>$username))) {

        if (password_verify($password, DB::query('SELECT password FROM nutzer WHERE username=:username', array(':username'=>$username))[0]['password'])) {
            echo 'Willkommen bei Connect!';

            $cstrong = True;
            $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
            $user_id = DB::query('SELECT id FROM nutzer WHERE username=:username', array(':username'=>$username))[0]['id'];
            DB::query('INSERT INTO login_tokens VALUES (\'\', :token, :user_id)', array(':token'=>sha1($token), ':user_id'=>$user_id));
            setcookie("CID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);

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


