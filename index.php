<?php 
include('./init.php');
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
        <title>Page d'accueil</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="assets/css/index.css">
    </head>
    <body>
        <header>
            <div id="head">
                <p>The Power Of Memory</p>
                <div id="links">
                <?php if(!empty($_SESSION['user_id'])) { ?>
                    <a href="index.php">ACCUEIL</a>
                    <a href="memory.php">JEU</a>
                    <a href="scores.php">SCORES</a>
                    <a href="contact.php">NOUS CONTACTER</a>
                    <a href="myaccount.php"><?= $_SESSION['user_pseudo'] ?></a>
                <?php 
                } else {
                ?><a href="login.php">SE CONNECTER</a><?php
            } ?>   
                </div>
            </div>
            <div id="banner">
                <h1>BIENVENUE DANS </br> NOTRE STUDIO !</h1>
                <p>Venez challenger les cerveaux les plus agiles !</p>
                <button id="buttongame"><a href="memory.php">Jouer !</a></button>
            </div>
        </header>

        <section>
            <div class="container1">
                <div class="photo1">
                    <img src="assets/images/arcades.png" class="gridimg1" alt="arcades">
                </div>
                <div class="photo2">
                    <img src="assets/images/scores.jpeg" class="gridimg1" alt="scores">
                </div>
                <div class="photo3">
                    <img src="assets/images/gameover.webp" class="gridimg1" alt="game over">
                </div>
            </div>
            <div class="container2">
                <p id="num">01</p>
                <div class="P1">
                    
                    <div class="paragraphe">
                        <h2>Lorem Ipsum</h2>
                        <p>Quisque commodo facilisis purus</br>
                        interdum volutpat arcu viverra sed.</br>
                        Etiam sodales convallis pretium.</br>
                        Aenean pharetra laoreet lorem. Nunc</br>
                        dapibus tincidunt sem a pharetra.</br>
                        Duis vitae tristique leo, sed faucibus</br>
                        ipsum.</p>
                    </div>
                        
                </div>
                <p id="num">02</p>
                <div class="P2">
                    
                    <div class="paragraphe">
                        <h2>Lorem Ipsum</h2>
                        <p>Quisque commodo facilisis purus</br>
                        interdum volutpat arcu viverra sed.</br>
                        Etiam sodales convallis pretium.</br>
                        Aenean pharetra laoreet lorem. Nunc</br>
                        dapibus tincidunt sem a pharetra.</br>
                        Duis vitae tristique leo, sed faucibus</br>
                        ipsum.</p>
                    </div>
                </div>
                <p id="num">03</p>
                <div class="P3">
                    
                    <div class="paragraphe">
                        <h2>Lorem Ipsum</h2>
                        <p>Quisque commodo facilisis purus</br>
                        interdum volutpat arcu viverra sed.</br>
                        Etiam sodales convallis pretium.</br>
                        Aenean pharetra laoreet lorem. Nunc</br>
                        dapibus tincidunt sem a pharetra.</br>
                        Duis vitae tristique leo, sed faucibus</br>
                        ipsum.</p>
                    </div>
                </div>
            </div>

            <div class="container3">
                <div class="photo4">
                    <img src="assets/images/watchdogs2.png" class="gridimg2" id="border" alt="watchdogs 2">
                </div>
                <div class="rectangle1" id="border">
                    <p id="stats">310</p>
                    <p id="intitule">Parties Jouées</p>
                </div>
                <div class="rectangle2" id="border">
                    <p id="stats">1020</p>
                    <p id="intitule">Joueurs Connectés</p>
                </div>
                <div class="rectangle3" id="border">
                    <p id="stats">10 sec</p>
                    <p id="intitule">Temps Record</p>
                </div>
                <div class="rectangle4" id="border">
                    <p id="stats">21 300</p>
                    <p id="intitule">Joueurs Inscrits</p>
                </div>
            </div>

            <div class="container4">
                <h2>Notre Equipe</h2>
                <p>Quiesque commodo facilisis purus, interdum volutpat arcu viverra sed.</p>
                <p>------- X -------</p>
            </div>

            <div class="container5">
                <div class="rectangle5" id="equipe">
                    <img src="assets/images/ppdiscord.jpeg" id="PP" alt="photo profil">
                    <h3>Mounir</h3>
                    <p id="job">Développeur web</p>
                    <div>
                        <img src="assets/images/facebook-f.svg" alt="Facebook logo" id="facebook"  class="personalRS"/>
                        <img src="assets/images/twitter.svg" alt="Twitter logo"  class="personalRS"/>
                        <img src="assets/images/discord.svg" alt="Discord logo" class="personalRS"/>
                    </div>
                </div>
                <div class="rectangle6" id="equipe">
                    <img src="assets/images/ppdiscord.jpeg" id="PP" alt="photo profil">
                    <h3>Raphaël</h3>
                    <p id="job">Développeur web</p>
                    <div>
                        <img src="assets/images/facebook-f.svg" alt="Facebook logo" id="facebook"  class="personalRS"/>
                        <img src="assets/images/twitter.svg" alt="Twitter logo"  class="personalRS"/>
                        <img src="assets/images/discord.svg" alt="Discord logo" class="personalRS"/>
                    </div>
                </div>
                <div class="rectangle7" id="equipe">
                    <img src="assets/images/ppdiscord.jpeg" id="PP" alt="photo profil">
                    <h3>Fabien</h3>
                    <p id="job">Développeur web</p>
                    <div>
                        <img src="assets/images/facebook-f.svg" alt="Facebook logo" id="facebook" class="personalRS"/>
                        <img src="assets/images/twitter.svg" alt="Twitter logo" class="personalRS"/>
                        <img src="assets/images/discord.svg" alt="Discord logo" class="personalRS"/>
                    </div>
                </div>
            </div>
        </section>
        <?php
            include('./view/footer.inc.php');
        ?>
    </body>
</html>