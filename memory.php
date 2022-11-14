<?php
include('./includes/database.inc.php');
$sql = file_get_contents('./sql/select_chat.sql');
$stmt = $dbh->query($sql);
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Memory</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="assets/css/maPage.css">
        <link rel="stylesheet" href="assets/css/memory.css">
    </head>
    <body>
        <div id="page-container">
            <?php 
                $file_name = "JEU";
                include('./view/header.inc.php'); 
            ?>
            <main>
                <div id="table-container">
                    <div id="table">
                        <?php 
                            $case = 4;
                            for ($x = 0; $x<$case; $x++) {
                                ?><div class="row"><?php
                                for ($y = 0; $y<$case; $y++) {
                                    ?><div class="cell"></div><?php
                                }
                                ?></div><?php
                            }
                        ?>
                    </div>
                </div>
            </main>
            <article id="chat">
                <div id="chat-head">
                    <div id="bot-img-container">
                        <img src="assets/images/elgato.jpeg" alt="Bot profil picture" id="bot-img-head" />
                        <div id="connect-indicator"></div>
                    </div>
                    <p id="chat-title">Chat général</p>
                </div>
                <div id="chat-body">
                    <?php if(isset($stmt) && $stmt->rowCount()>0) {
                            list($day, $month, $year, $hour, $min, $sec) = explode("/", date('d/m/Y/h/i/s'));
                            foreach ($stmt as $row) {
                                if ($row['message_user_id'] == 1) {
                                    ?><div class="my-message">
                                        <div class="message">
                                            <p class="message-detail">Moi</p>
                                            <p class="message-content my-text"><?= $row['message_value'] ?></p>
                                            <p class="message-detail"><?= "Le $day-$month-$year à  $hour:$min:$sec" ?></p>
                                        </div>
                                    </div><?php
                                } else {
                                    ?><div class="bot-message">
                                        <img src="assets/images/elgato.jpeg" alt="Bot profil picture" id="bot-img-body" />
                                        <div class="message">
                                            <p class="message-detail"><?= $row['user_pseudo'] ?></p>
                                            <p class="message-content bot-text"><?= $row['message_value'] ?></p>
                                            <p class="message-detail"><?= "Le $day-$month-$year à  $hour:$min:$sec" ?></p>
                                        </div>
                                    </div><?php
                                }
                            }
                        ?>
                    <?php 
                        } else {
                            ?><div id="no-message-container">
                                <p id="no-message-text">Aucun messages ces dernières 24 heures</p>
                            </div><?php
                        }
                    ?>
                </div>
                <form id="input-container">
                    <textarea type="text" id="input" placeholder="Votre message..." ></textarea>
                    <input type="submit" id="submit" />
                </form>
            </article>
            <?php
                include('./view/footer.inc.php');
            ?>
        </div>    
    </body>
</html>