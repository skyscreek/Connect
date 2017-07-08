<?php
include('./klassen/DB.php');
include('./klassen/anmeldung_klasse.php');
if (anmeldung_klasse::isLoggedIn()) {
    if (isset($_POST['passwort_aendern'])) {
        $oldpassword = $_POST['altes_passwort'];
        $newpassword = $_POST['neues_passwort'];
        $newpasswordrepeat = $_POST['neues_passwort_wiederholen'];
        $userid = anmeldung_klasse::isLoggedIn();
        if (password_verify($oldpassword, DB::query('SELECT password FROM nutzer WHERE id=:userid', array(':userid'=>$userid))[0]['password'])) {
            if ($newpassword == $newpasswordrepeat) {
                if (strlen($newpassword) >= 6 && strlen($newpassword) <= 60) {
                    DB::query('UPDATE nutzer SET password=:neues_passwort WHERE id=:userid', array(':newpassword'=>password_hash($newpassword, PASSWORD_BCRYPT), ':userid'=>$userid));
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
