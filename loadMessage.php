<?php
include('./includes/database.inc.php');
$sql = file_get_contents('./sql/select_chat.sql');
$messages = $dbh->query($sql);

?>