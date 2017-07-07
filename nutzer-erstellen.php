<?php
include('klassen/DB.php');
if (isset($_POST['nutzer-erstellen'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    DB::query('INSERT INTO nutzer VALUES (\'\', :username, :password, :email)', array(':username'=>$username, ':password'=>$password, ':email'=>$email));
    echo "Hasts geschafft!";
}
?>

<h1>Register</h1>
<form action="nutzer-erstellen.php" method="post">
    <input type="text" name="username" value="" placeholder="Username ..."><p />
    <input type="password" name="password" value="" placeholder="Password ..."><p />
    <input type="email" name="email" value="" placeholder="someone@somesite.com"><p />
    <input type="submit" name="nutzer-erstellen" value="Nutzer Erstellen">
</form>