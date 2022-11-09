<!DOCTYPE html>   
<html>   
    <head>  
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>CONNEXION</title> 
        <link rel="stylesheet" href="assets/css/login-register.css"> 
        <link rel="stylesheet" href="assets/css/maPage.css">
    </head>    
    <body>  
        <?php 
            $file_name = "CONNEXION";
            include('./view/header.inc.php'); 
        ?>
        <div id="container-connexion">
        <form class="login">
            <div class="input" style="color: white;">
            <input type="text" id="utlisateur" placeholder="Email" >
            </div>

            
            <div class="input">
                <input id="mot de passe" type="password" placeholder="mot de passe" >
            </div>

                <input style="color: rgb(255, 255, 255); " class= "button" type="submit" value="Connexion">
        </form>
        <?php
            include('./view/footer.inc.php');
        ?>
    </body>     
</html>  