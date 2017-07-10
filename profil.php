<?php
include('./klassen/DB.php');
include('./klassen/anmeldung_klasse.php');
$nutzername = "";
$folgt = False;
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
                $folgt = True;
            }
        }
        if (isset($_POST['entfolgen'])) {
            if ($nutzerid != $folgerid) {
                if (DB::query('SELECT folger_id FROM folger WHERE nutzer_id=:nutzerid', array(':nutzerid'=>$nutzerid))) {
                    DB::query('DELETE FROM folger WHERE nutzer_id=:nutzerid AND folger_id=:folgerid', array(':nutzerid'=>$nutzerid, ':folgerid'=>$folgerid));
                }
                $folgt = False;
            }
        }
        if (DB::query('SELECT folger_id FROM folger WHERE nutzer_id=:nutzerid', array(':nutzerid'=>$nutzerid))) {
            //echo 'Already following!';
            $folgt = True;
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
        if ($folgt) {
            echo '<input type="submit" name="entfolgen" value="Entfolgen">';
        } else {
            echo '<input type="submit" name="folgen" value="Folgen">';
        }
    }
    ?>
</form>
