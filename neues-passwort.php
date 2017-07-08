<?php
include('./klassen/DB.php');
include('./klassen/anmeldung_klasse.php');
if (anmeldung_klasse::isLoggedIn()) {
    if (isset($_POST['passwort_aendern'])) {
        $altespasswort = $_POST['altes_passwort'];
        $neuespasswort = $_POST['neues_passwort'];
        $neuespasswortwiederholen = $_POST['neues_passwort_wiederholen'];
        $nutzerid = anmeldung_klasse::isLoggedIn();
        if (password_verify($altespasswort, DB::query('SELECT passwort FROM nutzer WHERE id=:nutzerid', array(':nutzerid'=>$nutzerid))[0]['passwort'])) {
            if ($neuespasswort == $neuespasswortwiederholen) {
                if (strlen($neuespasswort) >= 6 && strlen($neuespasswort) <= 60) {
                    DB::query('UPDATE nutzer SET passwort=:neues_passwort WHERE id=:nutzerid', array(':neuespasswort'=>password_hash($neuespasswort, PASSWORD_BCRYPT), ':nutzerid'=>$nutzerid));
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
<form action="neues-passwort.php" method="post">
    <input type="password" name="altes_passwort" value="" placeholder="Aktuelles Passwort ..."><p />
    <input type="password" name="neues_passwort" value="" placeholder="Neues Passwort ..."><p />
    <input type="password" name="neues_passwort_wiederholen" value="" placeholder="Passwort wiederholen ..."><p />
    <input type="submit" name="passwort_aendern" value="Passwort ändern">
</form>
