<?php
include('./klassen/DB.php');
if (isset($_POST['passwort_zuruecksetzen'])) {
    $cstrong = True;
    $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
    $email = $_POST['email'];
    $user_id = DB::query('SELECT id FROM nutzer WHERE email=:email', array(':email'=>$email))[0]['id'];
    DB::query('INSERT INTO passwort_tokens VALUES (\'\', :token, :nutzer_id)', array(':token'=>sha1($token), ':nutzer_id'=>$user_id));
    echo 'Email wurde gesendet!';
    echo '<br />';
    echo $token;
}
?>
<h1>Passwort vergessen</h1>
<form action="passwort-vergessen.php" method="post">
    <input type="text" name="email" value="" placeholder="Email ..."><p />
    <input type="submit" name="passwort_zuruecksetzen" value="Password zurücksetzen!">
</form>
