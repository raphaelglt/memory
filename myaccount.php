<?php 
include('./init.php');
echo $_SESSION["user_id"];
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
                            <input class="button1" type="submit" name="submitmail" value="Modifier">
                        </form>
                    </div>                    
                </div>

                <div id="modif-password">
                    <h1>Modifier le mot de passe</h1>
                    <div class="input1">
                        <form method="post">
                            <input id="mot de passe" type="password" name="oldpassw" placeholder="Ancien mot de passe" >
                            <input id="mot de passe" type="password" name="newpassw1" placeholder="Nouveau mot de passe" >
                            <input id="mot de passe" type="password" name="newpassw2" placeholder="Confirmez mot de passe">
                            <input class="button1" href="#" type="submit" name="submitpassw" value="Modifier">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <p>
            <?php
                include('./includes/database.inc.php'); 

                var_dump($_POST);
                if(isset($_POST['submitmail'])){

                    if(empty($_POST['oldemail'])){
                        echo '<p style ="color:white">Veuillez vérifier le formulaire - veuillez entrer votre email.</p>';
                    }
                    else if (!empty($_POST["newemail"])){
                        $point = strpos($_POST['newemail'], ".");
                        $arobase = strpos($_POST['newemail'], "@");
                        if ($point === false){
                            echo '<p style ="color:white">Veuillez vérifier le formulaire - votre email doit comporter un point.</p>';
                        }else if ($arobase === false){
                            echo '<p style ="color:white">Veuillez vérifier le formulaire - votre email doit comporter un arobase.</p>';
                        }
                    }else{
                        $req1 = $dbh->prepare('SELECT user_email FROM Utilisateurs WHERE user_id=?');
                        $req1->bindParam(1, $_SESSION['user_id']);
                        $req1->execute();
                        $user1 = $req1->fetch();

                        $email = test_input($_POST["oldemail"]);
                        if ($email == $user1) {
                            echo '<p style ="color:white">Ancien mail correct.</p>';
                        }
                        else {  
                            echo '<p style ="color:white">Veuillez vérifier le formulaire - votre email est incorrect.</p>';
                        } 
                    }
                }
                if(isset($_POST["submitpassw"])){
                    if(empty($_POST['oldpassw'])){ 
                        echo '<p style ="color:white">Veuillez vérifier le formulaire - veuillez entrer votre mot de passe.</p>';
                    }else if(isset($_POST['newpassw1'])){
                        if(!preg_match("`^([a-zA-Z0-9-_]{8,})$`", $_POST['newpassw1'])){
                            echo '<p style ="color:white">Veuillez vérifier le formulaire - veuillez confirmer votre nouveau mot de passe.</p>';
                        }else if($_POST['newpass1'] != $_POST['newpass2']){
                            echo '<p style ="color:white">Veuillez vérifier le formulaire - votre confirmation de mot passe est incorrect.</p>';
                        }else{
                            echo '<p style ="color:white"> Nouveau mot de passe créé avec succès.</p>';

                            $sql="UPDATE Utilisateurs (user_email, user_pseudo, user_password, user_register_date, user_last_connection) VALUES (:user_email, :user_pseudo, :user_password, :user_register_date, :user_last_connection)";
                            $stmt = $dbh->prepare($sql);
                            $stmt->bindParam (':user_password',$_POST['user_password']);
                            $stmt->execute();
                        }
                            
                        
                    
                    }else { 
                        $req2 = $dbh->prepare('SELECT user_password FROM Utilisateurs WHERE user_id =?');
                        $req2->bindParam(1, $_SESSION['user_id']);
                        $req2->execute();  
                        $user2 = $req2->fetch();

                        if(password_verify($_POST['oldpassw'], $user2['user_password'])){
                            echo '<p style ="color:white">Ancien mot de passe correct.</p>';
                        }  
                        else {  
                            echo '<p style ="color:white">Veuillez vérifier le formulaire - votre mot de passe est incorrect.</p>';
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