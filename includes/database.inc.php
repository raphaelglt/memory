<?php
/* Connect to a MySQL database using driver invocation */
$dsn = 'mysql:dbname=memory;host=localhost';
$user = 'root';
$password = 'root';

$dbh = new PDO($dsn, $user, $password);
//$stmt = $dbh->query("SELECT * FROM Utilisateurs WHERE user_id=1");
?>