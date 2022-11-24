<?php
include('./includes/database.inc.php');
include('./init.php');

$stmt = $dbh->query('SELECT DISTINCT image_theme FROM Images');
$themes = $stmt->fetchAll();
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
                <div id="chat-body"></div>
                <div id="input-container">
                    <textarea type="text" id="input" placeholder="Votre message..." ></textarea>
                    <button id="submit" onClick="sendMessage()">Envoyer</button>
                </form>
            </article>
                
                <?php

                // precaution de securité 
                $user_message_date = date('Y-m-d H:i:s');
                $error=false;
                    // l'envoie d'un message au chat 
                    if(!empty($_POST)){
                        echo $_POST['submit'];
                        if (isset($_POST['submit'])){
                            $input = htmlentities(trim($_POST['message']));
                            // si le message ne fait plus de 200 caractère 
                            if (!preg_match("`^([a-zA-Z0-9-_]{1,200})$`", $input)){
                                $error = "message trop lent";
                                

                            }
                            if(!$error){
                                echo "send";
                                $sql = "SELECT game_id FROM Jeux WHERE game_name = 'The Power Of Memory'";
                                $gameid = $dbh->query($sql);
                                $game_id = $gameid->fetch();
                                $input = $_POST['message'];
                                $sql = "INSERT INTO Messages (message_id, message_game_id, message_user_id, message_value, message_datetime)
                                VALUES (NULL, :message_game_id , :message_user_id, :message_value, :message_datetime)";
                                $send_message = $dbh->prepare($sql);
                                $send_message->bindParam(':message_game_id',$game_id['game_id']);
                                $send_message->bindParam(':message_user_id',$_SESSION['user_id']);
                                $send_message->bindParam(':message_value',$input);
                                $send_message->bindParam(':message_datetime',$user_message_date);
                                $send_message->execute();
                            }
                            
                        }
                    }
                } else {
                    include('./view/disconnected.inc.php');
                }
                include('./view/footer.inc.php');
            ?>
        </div>    
    </body>
</html>
<script src="./assets/js/memory.js"></script>