<!DOCTYPE html>   
<html>   
    <head>  
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title> INSCRIPTION </title> 
        <link rel="stylesheet" href="assets/css/login-register.css"> 
        <link rel="stylesheet" href="assets/css/maPage.css">
    </head>    
    <body>  
        <?php
            $file_name = "INSCRIPTION";
            include('./view/header.inc.php'); 
        ?>
        <div id="container-inscription"> 
            <form class="login">
                    <div class="input">
                    <input type="text" id="email" placeholder="Email" >
                    </div>

                    <div class="input">
                    <input type="text" id="utlisateur" placeholder="Pseudo" >
                    </div>

                
                    <div class="input">
                    <input id="mot de passe" type="password" placeholder="mot de passe" >
                    </div>

                    <div class="input">
                        <input id="mot de passe" type="password" placeholder="confirmez mot de passe" >
                    </div>
                    <input style="color: rgb(255, 255, 255); " class= "button" type="submit" value="Inscription">
            </form>
        </div>
        <?php 
            include('./view/footer.inc.php');
        ?>
    </body>     
</html>  