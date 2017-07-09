<?php
include('./klassen/DB.php');
include('./klassen/anmeldung_klasse.php');
$nutzername = "";
$isFollowing = False;
if (isset($_GET['nutzername'])) {
    if (DB::query('SELECT nutzername FROM nutzer WHERE nutzername=:nutzername', array(':nutzername'=>$_GET['nutzername']))) {
        $nutzername = DB::query('SELECT nutzername FROM nutzer WHERE nutzername=:nutzername', array(':nutzername'=>$_GET['nutzername']))[0]['nutzername'];
        $nutzerid = DB::query('SELECT id FROM nutzer WHERE nutzername=:nutzername', array(':nutzername'=>$_GET['nutzername']))[0]['id'];
        $followerid = anmeldung_klasse::isLoggedIn();
        if (isset($_POST['follow'])) {
            if ($nutzerid != $followerid) {
                if (!DB::query('SELECT follower_id FROM follower WHERE nutzer_id=:nutzerid', array(':nutzerid'=>$nutzerid))) {
                    DB::query('INSERT INTO follower VALUES (\'\', :nutzerid, :followerid)', array(':nutzerid'=>$nutzerid, ':followerid'=>$followerid));
                } else {
                    echo 'Du folgst diesem Nutzer bereits!';
                }
                $isFollowing = True;
            }
        }
        if (isset($_POST['unfollow'])) {
            if ($nutzerid != $followerid) {
                if (DB::query('SELECT follower_id FROM follower WHERE nutzer_id=:nutzerid', array(':nutzerid'=>$nutzerid))) {
                    DB::query('DELETE FROM follower WHERE nutzer_id=:nutzerid AND follower_id=:followerid', array(':nutzerid'=>$nutzerid, ':followerid'=>$followerid));
                }
                $isFollowing = False;
            }
        }
        if (DB::query('SELECT follower_id FROM follower WHERE nutzer_id=:nutzerid', array(':nutzerid'=>$nutzerid))) {
            //echo 'Already following!';
            $isFollowing = True;
        }
    } else {
        die('Nutzer wurde nicht gefunden!');
    }
}
?>
<h1><?php echo $nutzername; ?>'s Profil</h1>
<form action="profil.php?nutzername=<?php echo $nutzername; ?>" method="post">
    <?php
    if ($nutzerid != $followerid) {
        if ($isFollowing) {
            echo '<input type="submit" name="unfollow" value="Entfolgen">';
        } else {
            echo '<input type="submit" name="follow" value="Folgen">';
        }
    }
    ?>
</form>
