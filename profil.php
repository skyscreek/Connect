<?php
include('./klassen/DB.php');
include('./klassen/anmeldung_klasse.php');
$nutzername = "";
$folgtgerade = False;
if (isset($_GET['nutzername'])) {
    if (DB::query('SELECT nutzername FROM nutzer WHERE nutzername=:nutzername', array(':nutzername'=>$_GET['nutzername']))) {
        $nutzername = DB::query('SELECT nutzername FROM nutzer WHERE nutzername=:nutzername', array(':nutzername'=>$_GET['nutzername']))[0]['nutzername'];
        $nutzerid = DB::query('SELECT id FROM nutzer WHERE nutzername=:nutzername', array(':nutzername'=>$_GET['nutzername']))[0]['id'];
        $folgerid = anmeldung_klasse::isLoggedIn();
        if (isset($_POST['folgt'])) {
            if ($nutzerid != $folgerid) {
                if (!DB::query('SELECT folger_id FROM folger WHERE nutzer_id=:nutzerid', array(':nutzerid'=>$nutzerid))) {
                    DB::query('INSERT INTO folger VALUES (\'\', :nutzerid, :folgerid)', array(':nutzerid'=>$nutzerid, ':folgerid'=>$folgerid));
                } else {
                    echo 'Du folgst diesem Nutzer bereits!';
                }
                $folgtgerade = True;
            }
        }
        if (isset($_POST['entfolgen'])) {
            if ($nutzerid != $folgerid) {
                if (DB::query('SELECT folger_id FROM folger WHERE nutzer_id=:nutzerid', array(':nutzerid'=>$nutzerid))) {
                    DB::query('DELETE FROM folger WHERE nutzer_id=:nutzerid AND folger_id=:folgerid', array(':nutzerid'=>$nutzerid, ':folgerid'=>$folgerid));
                }
                $folgtgerade = False;
            }
        }
        if (DB::query('SELECT folger_id FROM folger WHERE nutzer_id=:nutzerid', array(':nutzerid'=>$nutzerid))) {
            //echo 'Already following!';
            $folgtgerade = True;
        }
        if (isset($_POST['inhalt'])) {
            $inhalt = $_POST['inhalt'];
            $aktivenutzerid = anmeldung_klasse::isLoggedIn();
            if (strlen($inhalt) > 160 || strlen($inhalt) < 1) {
                die('Der Beitrag hat nicht die passende Länge!');
            }
            if ($aktivenutzerid == $nutzerid) {
                DB::query('INSERT INTO posts VALUES (\'\', :inhalt, NOW(), :nutzerid)', array(':inhalt'=>$inhalt, ':nutzerid'=>$nutzerid));
            } else {
                die('Falscher user!');
            }
        }
    } else {
        die('Nutzer wurde nicht gefunden!');
    }
}
?>
<h1><?php echo $nutzername; ?>'s Profil</h1>
<form action="profil.php?nutzername=<?php echo $nutzername; ?>" method="post">
    <?php
    if ($nutzerid != $folgerid) {
        if ($folgtgerade) {
            echo '<input type="submit" name="entfolgen" value="entfolgen">';
        } else {
            echo '<input type="submit" name="folgt" value="folgen">';
        }
    }
    ?>
</form>

<form action="profil.php?nutzername=<?php echo $nutzername; ?>" method="post">
    <textarea name="inhalt" rows="8" cols="80"></textarea>
    <input type="submit" name="inhalt" value="Post">
</form>
