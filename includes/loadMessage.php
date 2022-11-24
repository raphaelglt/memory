<?php
include('./database.inc.php');
include('../init.php');
$sql = "SELECT Messages.*, Utilisateurs.user_pseudo FROM `Messages`
INNER JOIN Utilisateurs ON Messages.message_user_id = Utilisateurs.user_id
WHERE message_datetime > DATE_SUB(NOW(),INTERVAL 24 HOUR)";

$messages = $dbh->query($sql);

$result = $messages->fetchAll();
echo json_encode(['messages' => $result, "user_id" => $_SESSION['user_id']]);
?>