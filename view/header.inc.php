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
            <?php } else {
                ?> <a href="login.php">SE CONNECTER</a> <?php
            } ?>    
        </div>
    </div>
    <div id="banner">
        <h1><?=$file_name?></h1>
    </div>
</header>