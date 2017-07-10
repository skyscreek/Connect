<?php
include('klassen/DB.php');

if (isset($_POST['anmeldung'])) {

    $nutzername = $_POST['nutzername'];
    $passwort = $_POST['passwort'];

    if (DB::query('SELECT nutzername FROM nutzer WHERE nutzername=:nutzername', array(':nutzername'=>$nutzername))) {

        if (password_verify($passwort, DB::query('SELECT passwort FROM nutzer WHERE nutzername=:nutzername', array(':nutzername'=>$nutzername))[0]['passwort'])) {
            echo 'Willkommen bei Connect!';

            $cstrong = True;
            $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
            $nutzerid = DB::query('SELECT id FROM nutzer WHERE nutzername=:nutzername', array(':nutzername'=>$nutzername))[0]['id'];
            DB::query('INSERT INTO login_tokens VALUES (\'\', :token, :nutzer_id)', array(':token'=>sha1($token), ':nutzer_id'=>$nutzerid));

            setcookie("CID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
            setcookie("CID_", '1', time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);

        } else {

            echo 'Dein Nutzername oder Passwort ist falsch!';
        }

    } else {
        echo 'Dieser Nutzer existiert nicht!';
    }
}
?>
<h1>Bei Connect anmelden</h1>
<form action="anmeldung.php" method="post">
    <input type="text" name="nutzername" value="" placeholder="Nutzername ..."><p />
    <input type="password" name="passwort" value="" placeholder="Passwort ..."><p />
    <input type="submit" name="anmeldung" value="anmeldung">
</form>


