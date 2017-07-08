<?php
include('./klassen/DB.php');
include('./klassen/anmeldung_klasse.php');
if (!anmeldung_klasse::isLoggedIn()) {
    die("Nicht angemeldet!");
}
if (isset($_POST['confirm'])) {
    if (isset($_POST['alldevices'])) {
        DB::query('DELETE FROM login_tokens WHERE user_id=:userid', array(':userid'=>anmeldung_klasse::isLoggedIn()));
    } else {
        if (isset($_COOKIE['CID'])) {
            DB::query('DELETE FROM login_tokens WHERE token=:token', array(':token'=>sha1($_COOKIE['CID'])));
        }
        setcookie('CID', '1', time()-3600);
        setcookie('CID_', '1', time()-3600);
    }
}
?>
<h1>Bist du sicher, dass du dich abmelden willst?</h1>
<form action="abmeldung.php" method="post">
    <input type="checkbox" name="alldevices" value="alldevices"> Auf allen Geräten abmelden?<br />
    <input type="submit" name="confirm" value="Bestätigen">
</form>


/**
 * Created by PhpStorm.
 * User: Noa
 * Date: 08.07.17
 * Time: 13:45
 */