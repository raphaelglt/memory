<?php
include('./includes/database.inc.php');
include('./init.php');

$sql = file_get_contents('./sql/get_images.sql');
$stmt = $dbh->prepare($sql);
$theme = "capybara";
$stmt->bindParam(':image_theme', $theme);
$stmt->execute();

$memory_size = 10;
$images_needed = intdiv(pow($memory_size, 2),2);

$row_count = $stmt->rowCount();
if ($row_count<$images_needed) {
    $difference = $images_needed-$row_count;
    if ($memory_size>=10) {
        $photo_nb = 50;
        $page_nb = intdiv($difference, $photo_nb);
        if (($difference)%$photo_nb!=0) {
            $page_nb++;
        }
    } else {
        $photo_nb = $difference;
        $page_nb = 1;
    }

    $sql = file_get_contents('./sql/insert_image.sql');
    $stmt = $dbh->prepare($sql);

    $next_link = "https://api.pexels.com/v1/search?query=$theme&page=$page_nb&per_page=$photo_nb";
    for ($page=0; $page<$page_nb; $page++) {
        $curl = curl_init($next_link);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
        'X-RapidAPI-Host: kvstore.p.rapidapi.com',
        'Authorization: 563492ad6f9170000100000193f0dcb4e9494a82b0b266c32b3448e7',
        'Content-Type: application/json'
        ]);

        $response = curl_exec($curl);
        $decode = json_decode($response, true);
        curl_close($curl);
        if (!isset($decode['error'])) {
            foreach ($decode['photos'] as $elt) {
                $stmt->bindParam(':image_id', $elt['id']);
                $stmt->bindParam(':image_theme', $theme);
                $stmt->bindParam(':image_url', $elt['src']['original']);
                $stmt->execute();
            }
            if (!empty($decode['next_page'])) $next_link = $decode['next_page']; 
        } else {
            echo "Error";
        }
    }
}
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