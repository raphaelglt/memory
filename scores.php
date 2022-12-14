<?php 
//select all the scores from the db
include('./includes/database.inc.php');
include('./init.php');
$sql = file_get_contents('./sql/scoreall.sql');
$stmt = $dbh->query($sql);

$levels = $dbh->query('SELECT DISTINCT score_level FROM Scores');
$game_levels = $levels->fetchAll();

$users = $dbh->query('SELECT DISTINCT score_user_id, user_pseudo FROM Scores INNER JOIN Utilisateurs ON score_user_id = user_id ');
$game_users = $users->fetchAll();

$games = $dbh->query('SELECT game_id, game_name FROM Jeux');
$game_names = $games->fetchAll(); 
?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="assets/css/maPage.css">
        <link rel="stylesheet" href="assets/css/scores.css">
    </head>
    <body>
        <div id="page-container">
            <?php 
                $file_name = "SCORES";
                include('./view/header.inc.php'); 
            ?>
            <main>
                <div id="select-container">
                    <div id="select-content">
                        <select id="select-difficulty">
                            <option value="" selected>--DifficultÃ©--</option>
                            <?php
                                if (!empty($game_levels)) {
                                    foreach ($game_levels as $elt) {
                                        ?><option value=<?= $elt['score_level'] ?>><?= ucfirst($elt['score_level']) ?></option><?php
                                    }
                                }    
                            ?>
                        </select>
                        <select id="select-player">
                            <option selected value="">--Joueur--</option>
                            <?php
                                if (!empty($game_users)) {
                                    foreach ($game_users as $elt) {
                                        ?><option value=<?= $elt['score_user_id'] ?>><?= ucfirst($elt['user_pseudo']) ?></option><?php
                                    }
                                }    
                            ?>
                        </select>
                        <select id="select-game">
                            <option selected value="">--Jeux--</option>
                            <?php
                                if (!empty($game_names)) {
                                    foreach ($game_names as $elt) {
                                        ?><option value=<?= $elt['game_id'] ?>><?= ucfirst($elt['game_name']) ?></option><?php
                                    }
                                }    
                            ?>
                        </select>
                    </div>
                </div>  
                <?php 
                if (isset($_SESSION['user_id'])) { ?>
                    <div id="table-container">
                    <?php
                        //display scores if here's scores
                        if (isset($stmt) && $stmt->rowCount()>0) {?>
                        <table>        
                            <thead>
                                <tr>
                                    <th>Jeu</th>
                                    <th>Pseudo</th>
                                    <th>DifficultÃ©</th>
                                    <th>Scores</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <?php 
                            } else {
                                ?><p id="no-score-text">Aucun score n'a Ã©tÃ© enregistrÃ©</p><?php
                            }
                        ?>
                    </div>
                <?php 
                } else {
                    include('./view/disconnected.inc.php');
                }
                ?>
            </main>
            <?php
                include('./view/footer.inc.php');
            ?>
        </div>    
    </body>
</html>
<script src="./assets/js/scores.js"></script>