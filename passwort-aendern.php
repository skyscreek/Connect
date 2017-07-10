<?php
include('./klassen/DB.php');
include('./klassen/anmeldung_klasse.php');
if (anmeldung_klasse::isLoggedIn()) {
    if (isset($_POST['passwortaendern'])) {
        $altespasswort = $_POST['altespasswort'];
        $neuespasswort = $_POST['neuespasswort'];
        $neuespasswortwiederholen = $_POST['neuespasswortwiederholen'];
        $nutzerid = anmeldung_klasse::isLoggedIn();
        if (password_verify($altespasswort, DB::query('SELECT passwort FROM nutzer WHERE id=:nutzerid', array(':nutzerid'=>$nutzerid))[0]['passwort'])) {
            if ($neuespasswort == $neuespasswortwiederholen) {
                if (strlen($neuespasswort) >= 6 && strlen($neuespasswort) <= 60) {
                    DB::query('UPDATE nutzer SET passwort=:neuespasswort WHERE id=:nutzerid', array(':neuespasswort'=>password_hash($neuespasswort, PASSWORD_BCRYPT), ':nutzerid'=>$nutzerid));
                    echo 'Dein Passwort wurde erfolgreich geändert';
                }
            } else {
                echo 'Passwörter stimmen nicht überein!';
            }
        } else {
            echo 'altes Passwort falsch!';
        }
    }
} else {
    die('Du bist nicht eingeloggt');
}
?>
<h1>Ändere dein Passwort</h1>
<form action="passwort-aendern.php" method="post">
    <input type="password" name="altespasswort" value="" placeholder="Aktuelles Passwort ..."><p />
    <input type="password" name="neuespasswort" value="" placeholder="Neues Passwort ..."><p />
    <input type="password" name="neuespasswortwiederholen" value="" placeholder="Passwort wiederholen ..."><p />
    <input type="submit" name="passwortaendern" value="Passwort ändern">
</form>
