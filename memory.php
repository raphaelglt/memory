<?php
include('./includes/database.inc.php');
include('./init.php');

$stmt = $dbh->query('SELECT DISTINCT image_theme FROM Images');
$themes = $stmt->fetchAll();

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
        <script src="https://cdn.jsdelivr.net/npm/js-confetti@latest/dist/js-confetti.browser.js"></script>
    </head>
    <body>
        <div id="page-container">
            <?php
                $file_name = "JEU";
                include('./view/header.inc.php'); 
                if (isset($_SESSION['user_id'])) {
            ?>
            <main>
                <div>
                    <div id="timer-container">
                        <p id="timer">00:00:00</p>
                    </div>
                    <div id="table-container">
                        <div id="select-container">
                            <div id="select-content">
                                <select id="select-difficulty">
                                    <option selected value="">--Choisissez la difficulté--</option>
                                    <option value="2">Facile</option>
                                    <option value="4">Normale</option>
                                    <option value="10">Difficile</option>
                                    <option value="20">Impossible</option>
                                </select>
                                <select id="select-theme">
                                    <option selected value="">--Choisissez le thème--</option>
                                    <?php
                                        if (!empty($themes)) {
                                            foreach ($themes as $elt) {
                                                ?><option value=<?= $elt['image_theme'] ?>><?= ucfirst($elt['image_theme']) ?></option><?php
                                            }
                                        }    
                                    ?>
                                </select>
                            </div>    
                            <button onclick='onButton()'>Commencer</button>
                            <p id="error-message"></p>
                        </div>    
                        <div id="table"></div>
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
                <div id="chat-body" >
                    <?php if(isset($messages) && $messages->rowCount()>0) {
                            list($day, $month, $year, $hour, $min, $sec) = explode("/", date('d/m/Y/h/i/s'));
                            foreach ($messages as $row) {
                                if ($row['message_user_id'] == $_SESSION['user_id']) {
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
                <form id="input-container" method="post" action="">
                    <textarea type="text" id="message_id" name="message" placeholder="Votre message..." ></textarea>
                    <input type="submit" name="envoyer" id="envoyer" />
                </form>
                    <?php
                     // precaution de securité 
                     $user_message_date = date('Y-m-d H:i:s');
                     $error=false;
                     
                        if(!empty($_POST)){
                            extract($_POST);
                            if (isset($_POST['envoyer'])){
                                $message_id = htmlentities(trim($message));
                               
                                if (preg_match("`^([a-zA-Z0-9-_]{1,200})$`", $message)){
                                    $error=true;
                                    $error = "message trop lent";

                                }elseif(!$error){
                                    $sql = "SELECT game_id FROM Jeux WHERE game_name = 'The Power Of Memory'";
                                    $gameid = $dbh->query($sql);
                                    $game_id = $gameid->fetch();
                                    $message = $_POST['message'];
                                    $sql = "INSERT INTO Messages (message_id, message_game_id, message_user_id, message_value, message_datetime)
                                    VALUES (NULL, :message_game_id , :message_user_id, :message_value, :message_datetime)";
                                    $send_message = $dbh->prepare($sql);
                                    $send_message->bindParam(':message_game_id',$game_id['game_id']);
                                    $send_message->bindParam(':message_user_id',$_SESSION['user_id']);
                                    $send_message->bindParam(':message_value',$message);
                                    $send_message->bindParam(':message_datetime',$user_message_date);
                                    $send_message->execute();
                                }
                                
                            }
                        }
                        
                
                            

                    ?>

            </article>
            <?php
                } else {
                    include('./view/disconnected.inc.php');
                }
                include('./view/footer.inc.php');
            ?>
        </div>
        <div id='pop-up'>
            <div id='pop-up-content'>
                <h2>Félicitations !!</h2>
                <h3 id="result"></h3>
                <div id="pop-up-buttons">
                    <button id="toward-index"><a href="./index.php">Retour à l'accueil</a></button>
                    <button id="toward-memory"><a href="./memory.php">Rejouer une partie</a></button>
                </div>
            </div>
        </div>
    </body>
</html>
<script src="./assets/js/memory.js"></script>