<?php 
include('./init.php');
?>

<!DOCTYPE html>   
<html>
    <head>  
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="stylesheet" href="assets/css/myaccount.css">
        <link rel="stylesheet" href="assets/css/maPage.css">
        <title> MON ESPACE</title> 
    </head>
    <body>
        <?php 
            $file_name = "MON PROFIL";
            include('./view/header.inc.php'); 
        ?>
        <main>
        <div id="main-container">
            <div id="card">
                <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="avatar" width="250px">
            </div>
            <div id="card2">
                <div id="modif-mail">
                    <h1>Modifier le mail</h1>
                    <div class="input1">
                        <form method="post">
                            <input type="text" id="email" name="oldemail" placeholder="Ancien mail" >
                            <input type="text" id="email" name="newemail" placeholder="Nouveu mail" >
                            <input type="password" id="email" placeholder="Mot de passe" >
                            <input class="button1" type="submit" name="submitmail" value="modifier">
                        </form>
                    </div>                    
                </div>

                <div id="modif-password">
                    <h1>Modifier le mot de passe</h1>
                    <div class="input1">
                        <input id="mot de passe" type="password" placeholder="Ancien mot de passe" >
                        <input id="mot de passe" type="password" placeholder="Nouveau mot de passe" >
                        <input id="mot de passe" type="password" placeholder="Confirmez mot de passe">
                    </div>
                    <input class="button1" href="#" type="submit" value="Modifier">
                </div>
            </div>
        </div>

        <div>
            <p>
            <?php
                var_dump($_POST);
                if(isset($_POST['submitmail'])){

                    if($_SESSION("user_id")){
                        if("Utilisateurs.user_id" != "Utilisateurs.user_email"){
                            echo '<p style ="color:white">Veuillez vérifier le formulaire - votre email est incorrect.</p>';
                        }
                    }
                    else if (!empty($_POST["newemail"])){
                        $point = strpos($_POST['newemail'], ".");
                        $arobase = strpos($_POST['newemail'], "@");
                        if ($point === false){
                            echo '<p style ="color:white">Veuillez vérifier le formulaire - votre email doit comporter un point.</p>';
                        }else if ($arobase === false){
                            echo '<p style ="color:white">Veuillez vérifier le formulaire - votre email doit comporter un arobase.</p>';
                        
                        }else{
                            return true;
                        }
                    }
                }
            ?>
            </p>
        </div>
        </main>

        



        <?php
            include('./view/footer.inc.php');
        ?>
    </body>
</html>