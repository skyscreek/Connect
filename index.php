<?php
include('./klassen/DB.php');
include('./klassen/anmeldung_klasse.php');
if (anmeldung_klasse::isLoggedIn()) {
    echo 'Du bist angemeldet';
    echo anmeldung_klasse::isLoggedIn();
} else {
    echo 'Du bist gerade nicht angemeldet!';
}
?>
