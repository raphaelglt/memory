<?php 
include('./includes/database.inc.php');

$sql = file_get_contents('./sql/create_game.sql');

$name = "The Power Of Memories";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':game_name', $name);
$stmt->execute()

// $stmt = $dbh->prepare("INSERT INTO REGISTRY (name, value) VALUES (:name, :value)");
// $stmt->bindParam(':name', $name);
// $stmt->bindParam(':value', $value);

// // insert one row
// $name = 'one';
// $value = 1;
// $stmt->execute();
?>