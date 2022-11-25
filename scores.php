<?php 
//select all the scores from the db
include('./includes/database.inc.php');
include('./init.php');
$sql = file_get_contents('./sql/scoreall.sql');
$stmt = $dbh->query($sql);
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
                                    <th>Difficulté</th>
                                    <th>Scores</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach ($stmt as $row) {
                                        ?><tr>
                                            <td><a href='memory.php' class='memory-link'><?=$row['game_name']?></a></td>
                                            <td><?=$row['user_pseudo']?></td>
                                            <?php //set the first letter as an upper ?>
                                            <td><?=ucfirst($row['score_level'])?></td>
                                            <td><?=$row['score_stopwatch']?></td>
                                            <td><?=$row['score_datetime']?></td>
                                        </tr><?php
                                    }
                                ?>
                            </tbody>
                        </table>
                        <?php 
                            } else {
                                ?><p id="no-score-text">Aucun score n'a été enregistré</p><?php
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