<?php
include('./includes/database.inc.php');
//le submit
//les message d'erreur dans des variables
require_once('init.php');

if (isset($_SESSION['id'])){
    header ('Location: index.php');
    exit;
}
if(!empty($_POST)){
    extract($_POST);
    $valid = true;
    $erreur = true;
    $user_last_connection = date('Y-m-d H:i:s');
        
    if (isset($_POST['login'])){
        $r_email= trim($email);
        $r_pass =trim($password);      
        
        //verif email
        if (empty($r_email)){
            $valid=false;
            $error= "L'email ne peut pas etre vide";
        }elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
        {   $valid= false;
            $error="L'email est invalide";
        }

        if (empty($r_pass)){
            $valid=false;
            $error="Saisissez votre mots de passe";
        }

        if ($valid){
            
            $req_pass = $dbh->prepare("SELECT user_password, user_id FROM Utilisateurs WHERE user_email =?");
            $req_pass->bindParam(1, $r_email);
            $req_pass->execute();
            $row = $req_pass->fetch();
            if ($req_pass->rowCount()==0) {
                $error = "l'email ou le mots de passe est incorrect";
            } else {
                $password = $row['user_password'];
            }
            if(password_verify($r_pass, $password)) {
                $req = $dbh->prepare("SELECT * FROM Utilisateurs WHERE user_id =?");
            
                $req->bindParam(1, $row['user_id']);
                $req->execute();

                $row = $req->fetch();
                echo $row;

                $_SESSION['user_id'] =$row['user_id'];
                $_SESSION['user_pseudo'] =$row['user_pseudo'];
                header ('Location: index.php');   
            } else {
                $error = "l'email ou le mots de passe est incorrect";
            }                              
        }
    }
}
?>

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
            <form class="login" method="post" action="">
                <input type="text" id="r_email" placeholder="Email" name="email"  >
                <input id="r_pass" type="password" placeholder="Mot de passe" name="password">
                <?php if(isset($error)) {?><p id="error-msg"><?= $error ?></p> <?php } ?>
                <a id="login-to-register" href="./register.php">Créer un compte</a>
                <input class= "button" type="submit" name="login" value="Connexion">
            </form>
        </div>
        <?php
            include('./view/footer.inc.php');
        ?>
    </body>     
</html>  