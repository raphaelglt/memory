<?php
session_start();
include('includes/database.inc.php');

if (isset($_SESSION['user_id'])) {
    $sql = "UPDATE Utilisateurs SET user_last_connection = NOW() WHERE user_id = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(1, $_SESSION['user_id']);
    $stmt->execute();
}
?>