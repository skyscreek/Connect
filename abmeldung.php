<?php
include('./klassen/DB.php');
include('./klassen/anmeldung_klasse.php');
if (!anmeldung_klasse::isLoggedIn()) {
    die("Du bist nicht angemeldet.");
}
if (isset($_POST['bestaetigen'])) {
    if (isset($_POST['allegeraete'])) {

        DB::query('DELETE FROM login_tokens WHERE nutzer_id=:nutzerid', array(':nutzerid'=>anmeldung_klasse::isLoggedIn()));
    } else {
        if (isset($_COOKIE['CID'])) {
            DB::query('DELETE FROM login_tokens WHERE token=:token', array(':token'=>sha1($_COOKIE['CID'])));
        }
        setcookie('CID', '1', time()-3600);
        setcookie('CID_', '1', time()-3600);
    }
}
?>
<h1>Bist du dir sicher, dass du dich abmelden willst?</h1>

<form action="abmeldung.php" method="post">
    <input type="checkbox" name="allegeraete" value="alle Geräte"> Auf allen Geräten abmelden?<br />
    <input type="submit" name="bestaetigen" value="Bestätigen">
</form>
