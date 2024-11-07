<?php
// on simule une base de données
$users = array(
// login => password
'guilhem' => 'fifi',
'yoda' => 'maitrejedi' );
$login = "anonymous";
$errorText = "";
$successfullyLogged = false;
if(isset($_POST['login']) && isset($_POST['password'])) {
    $tryLogin=$_POST['login'];
$tryPwd=$_POST['password'];
// si login existe et password correspond
if( array_key_exists($tryLogin,$users) && $users[$tryLogin]==$tryPwd ) {
$successfullyLogged = true;

$login = $tryLogin;
} else
$errorText = "Erreur de login/password";
} else
$errorText = "Merci d'utiliser le formulaire de login";

if(!$successfullyLogged) {
echo $errorText;
} else {

session_start();
$_SESSION['user'] = $login;
echo "<h1>Bienvenue ".$login."</h1>";
echo "<a href=\"index.php\">Page principale</a><br>";

echo "<a href=\"logout.php\">Se déconnecter</a>";

}
?>