<?php
session_start();
include('includes/database.inc.php');

if (isset($_SESSION['user_id'])) {
    $sql = "UPDATE Utilisateurs SET user_last_connection = NOW()";
    $stmt = $dbh->query($sql);
}
?>