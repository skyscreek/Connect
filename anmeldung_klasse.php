<?php
class anmeldung_klasse {
    public static function isLoggedIn() {
        if (isset($_COOKIE['CID'])) {
            if (DB::query('SELECT nutzer_id FROM login_tokens WHERE token=:token', array(':token'=>sha1($_COOKIE['CID'])))) {
                $nutzerid = DB::query('SELECT nutzer_id FROM login_tokens WHERE token=:token', array(':token'=>sha1($_COOKIE['CID'])))[0]['nutzer_id'];
                if (isset($_COOKIE['CID_'])) {
                    return $nutzerid;
                } else {
                    $cstrong = True;
                    $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
                    DB::query('INSERT INTO login_tokens VALUES (\'\', :token, :nutzer_id)', array(':token'=>sha1($token), ':nutzer_id'=>$nutzerid));
                    DB::query('DELETE FROM login_tokens WHERE token=:token', array(':token'=>sha1($_COOKIE['CID'])));
                    setcookie("CID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
                    setcookie("CID_", '1', time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);
                    return $nutzerid;
                }
            }
        }
        return false;
    }
}
?>
