<?php
/* Connect to a MySQL database using driver invocation */
$dsn = 'mysql:dbname=memory;host=localhost';
$user = 'root';
$password = 'root';

$dbh = new PDO($dsn, $user, $password);
//simple query

//$stmt = $dbh->query("SELECT * FROM Utilisateurs WHERE user_id=1");

//import an sql query

//$sql = file_get_contents('./sql/create_game.sql');
//$stmt = $dbh->prepare($sql)

// bind params

// $stmt = $dbh->prepare($sql);
// $stmt->bindParam(':game_name', $name);
// $stmt->execute()
?>