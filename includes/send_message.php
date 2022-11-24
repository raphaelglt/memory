<?php
var_dump($_POST);
include('./database.inc.php');
include('../init.php');

$sql = include('../sql/send_chat.sql');

$sql = "SELECT game_id FROM Jeux WHERE game_name = 'The Power Of Memory'";
$gameid = $dbh->query($sql);
$game_id = $gameid->fetch();

$sql = "INSERT INTO `Messages` (`message_id`, `message_game_id`, `message_user_id`, `message_value`, `message_datetime`)
 VALUES (NULL, :message_game_id, :message_user_id, :message_value, NOW());";

$stmt = $dbh->prepare($sql);
$stmt->bindParam('message_game_id', $game_id['game_id']);
$stmt->bindParam('message_user_id', $_SESSION['user_id']);
$stmt->bindParam('message_value', $_POST['input']);
$stmt->execute();


echo 'good;';
?>