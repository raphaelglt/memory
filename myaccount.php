<?php 
include('./init.php');
echo $_SESSION['user_id'];
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
                            <input type="password" id="email" name="oldpassw" placeholder="Mot de passe" >
                            <input class="button1" type="submit" name="submitmail" value="Modifier">
                        </form>
                    </div>                    
                </div>

                <div id="modif-password">
                    <h1>Modifier le mot de passe</h1>
                    <div class="input1">
                        <form method="post">
                            <input id="oldpassw1" type="password" name="oldpassw1" placeholder="Ancien mot de passe" >
                            <input id="newpassw1" type="password" name="newpassw1" placeholder="Nouveau mot de passe" oninput='strengthChecker()' >
                            <!--<span class="tooltip" data-tooltip="Pour un mot de passe sécurisé : au moins 8 caractères, un caractère spécial, un chiffre et une majuscule.">?</span>-->
                            <div id="strength-bar" >
                                <p id="weak"></p>
                                <p id="medium"></p>
                                <p id="strong"></p>
                            </div>
                            <p id="level"></p>
                            <input id="mot de passe" type="password" name="newpassw2" placeholder="Confirmez mot de passe">
                            <input class="button1" href="#" type="submit" name="submitpassw" value="Modifier">
                        </form>
                    </div>

        

                </div>
            </div>
        </div>

        
        
        <div class="align-button">
            <button class="button2"><a href="deconnect.php">Se déconnecter</a></button>
        </div>
            
        
            
        <div>
            <p>
            <?php
                include('./includes/database.inc.php');
            
                if(isset($_POST['submitmail'])){
                    
                    $req1 = $dbh->prepare('SELECT user_email FROM Utilisateurs WHERE user_id=?');
                    $req1->bindParam(1, $_SESSION['user_id']);
                    $req1->execute();
                    $email1 = $req1->fetch();

                    if(!empty($_POST["oldemail"])){
                        $email = $_POST['oldemail'];
                        if($email == $email1[0]){
                            if(empty($_POST['newemail'])){
                                echo '<p style ="color:white"> Veuillez vérifier le formulaire - ancien mail correct, veuillez entrer votre nouveau mail.</p>';
                            }
                            else {
                                $point = strpos($_POST['newemail'], ".");
                                $arobase = strpos($_POST['newemail'], "@");
                                if ($point === false){
                                    echo '<p style ="color:white">Veuillez vérifier le formulaire - votre nouveau mail doit comporter un point.</p>';
                                }elseif ($arobase === false){
                                    echo '<p style ="color:white">Veuillez vérifier le formulaire - votre nouveau mail doit comporter un arobase.</p>';
                                }else{
                                    $req2 = $dbh->prepare('SELECT user_password FROM Utilisateurs WHERE user_id =?');
                                    $req2->bindParam(1, $_SESSION['user_id']);
                                    $req2->execute();  
                                    $passw1 = $req2->fetch();

                                    $password = $_POST['oldpassw'];
                                    if(password_verify($password, $passw1[0])){

                                        $sql="UPDATE Utilisateurs SET user_email = :user_email WHERE user_id = :user_id";
                                        $stmt = $dbh->prepare($sql);
                                        $stmt->bindParam (':user_email',$_POST['newemail']);
                                        $stmt->bindParam (':user_id',$_SESSION['user_id']);
                                        $stmt->execute();
                                        echo '<p style ="color:white"> Nouveau mail créé avec succès.</p>';

                                    }else{
                                        echo '<p style ="color:white"> Veuillez vérifier le formulaire - votre mot de passse est incorrect.</p>';
                                    }
                                }
                            }
                        }else{
                            echo '<p style ="color:white">Veuillez vérifier le formulaire - ancien mail incorrect.</p>';
                        }
                    }else{
                        echo '<p style ="color:white">Veuillez vérifier le formulaire - veuillez entrer votre email.</p>';
                    }
                }

                if(isset($_POST["submitpassw"])){

                    $req2 = $dbh->prepare('SELECT user_password FROM Utilisateurs WHERE user_id =?');
                    $req2->bindParam(1, $_SESSION['user_id']);
                    $req2->execute();  
                    $passw1 = $req2->fetch();

                    if(!empty($_POST["oldpassw1"])){
                        $password = $_POST['oldpassw1'];
                        if(password_verify($password, $passw1[0])){
                            if(empty($_POST['newpassw1'])){
                                echo '<p style ="color:white"> Veuillez vérifier le formulaire - ancien mot de passe correct, veuillez entrer votre nouveau mot de passe.</p>';
                            }else{
                                if(!preg_match("`^([a-zA-Z0-9-_]{8,})$`", $_POST['newpassw1'])){
                                    echo '<p style ="color:white">Veuillez vérifier le formulaire - nouveau mot de passe non conforme.</p>';
                                }elseif($_POST['newpassw1'] != $_POST['newpassw2']){
                                    echo '<p style ="color:white">Veuillez vérifier le formulaire - votre confirmation de mot passe est incorrect.</p>';
                                }else{
                                    $crypt_password = password_hash($_POST['newpassw2'], PASSWORD_ARGON2ID);
                                    $sql="UPDATE Utilisateurs SET user_password = :user_password WHERE user_id = :user_id";
                                    $stmt = $dbh->prepare($sql);
                                    $stmt->bindParam (':user_password',$crypt_password);
                                    $stmt->bindParam (':user_id',$_SESSION['user_id']);
                                    $stmt->execute();
                                    echo '<p style ="color:white"> Nouveau mot de passe créé avec succès.</p>';
                                }
                            }
                        }else{
                            echo '<p style ="color:white">Veuillez vérifier le formulaire - ancien mot de passe incorrect.</p>';
                        }
                    }else{
                        echo '<p style ="color:white">Veuillez vérifier le formulaire - veuillez entrer votre mot de passe.</p>';
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
<script src="./assets/js/myaccount.js"></script>