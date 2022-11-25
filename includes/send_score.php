<?php
include('./database.inc.php');
include('../init.php');

var_dump($_POST);

if (isset($_SESSION['user_id'])) {
    $sql = 'SELECT game_id FROM Jeux WHERE game_name = "The Power Of Memory"';
    $stmt = $dbh->query($sql);
    $game = $stmt->fetch();

    $stmt = $dbh->prepare('INSERT INTO Scores (score_user_id, score_game_id, score_level, score_value, score_stopwatch, score_datetime)
    VALUES (:score_user_id, :score_game_id, :score_level, :score_value, :score_stopwatch, NOW());');
    $stmt->bindParam(':score_user_id', $_SESSION['user_id']);
    $stmt->bindParam(':score_game_id', $game['game_id']);
    $stmt->bindParam(':score_level', $_POST['level']);
    $stmt->bindParam(':score_value', $_POST['value']);
    $stmt->bindParam(':score_stopwatch', $_POST['stopwatch']);
    $stmt->execute();
}    
?>