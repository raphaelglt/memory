<?php
include('./database.inc.php');
include('../init.php');

//isset($_SESSION['user_id'])
if (isset($_GET['theme']) && isset($_GET['size'])) {
    $sql = file_get_contents('../sql/get_images.sql');
    $stmt = $dbh->prepare($sql);
    $theme = $_GET['theme'];
    $stmt->bindParam(':image_theme', $theme);
    $stmt->execute();

    $memory_size = $_GET['size'];
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

        $sql = file_get_contents('../sql/insert_image.sql');
        $stmt = $dbh->prepare($sql);

        $next_link = "https://api.pexels.com/v1/search?query=$theme&page=$page_nb&per_page=$photo_nb&size=small";
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
                    $stmt->bindParam(':image_url', $elt['src']['tiny']);
                    $stmt->execute();
                }
                if (!empty($decode['next_page'])) $next_link = $decode['next_page']; 
            } else {
                echo "Error";
            }
        }
    }    
    $stmt = $dbh->prepare("SELECT * FROM Images WHERE image_theme = :image_theme LIMIT $images_needed");
    $stmt->bindParam(':image_theme', $theme);
    $stmt->execute();
    $rows = $stmt->fetchAll();
    echo json_encode(["images" => $rows]);
} else {
    echo json_encode(["error" => "Missing params"]);
}
?>