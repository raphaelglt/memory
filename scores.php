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
                <div id="table-container">
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
                            <tr>
                                <td><a href="memory.html" class="memory-link">The Power Of Memory</a></td>
                                <td>👑 Moi</td>
                                <td>Simple</td>
                                <td>10</td>
                                <td>31/10/2022 10:53:08</td>
                            </tr>
                            <tr>
                                <td><a href="memory.html" class="memory-link">The Power Of Memory</a></td>
                                <td>ElGato</td>
                                <td>Intermédiaire</td>
                                <td>25</td>
                                <td>12/10/2022 19:27:37</td>
                            </tr>
                            <tr>
                                <td><a href="memory.html" class="memory-link">The Power Of Memory</a></td>
                                <td>Moi</td>
                                <td>Impossible</td>
                                <td>300</td>
                                <td>30/10/2022 23:09:49</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </main>
            <?php
                include('./view/footer.inc.php');
            ?>
        </div>    
    </body>
</html>