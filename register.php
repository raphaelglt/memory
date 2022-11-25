<?php
include('./includes/database.inc.php'); 
//le submit
//les message d'erreur dans des variables

if(!empty($_POST)){
    extract($_POST);
        
       
    if (isset($_POST['inscription'])){
        // precaution de securité 
        $r_email= htmlentities(strtolower(trim($email)));
        $r_pseudo = htmlentities(trim($pseudo));
        $r_pass =htmlentities(trim($password));
        $r_pass2 =htmlentities(trim($password2));
        $er_pseudo = false;
        
        $er_email = false ;
        
        $er_pass= false;
            
        // verif email
        if (empty($r_email)){
            $error= "L'email ne peut pas etre vide";
        }elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
        { 
            $error="L'email est invalide";
        }else{
            $req_email = $dbh->prepare("SELECT user_email FROM Utilisateurs WHERE user_email=?");
            $req_email->bindParam(1, $r_email);
            $req_email->execute();
            if($req_email->rowCount()==0){
                $email=$_POST['email'];
            }else{
                $error = "L'email existe deja";
            }
            
        }
        
        //verif pseudo
        if (empty($r_pseudo)){
            $error = "Le pseudo ne peut pas etre vide";

        }elseif (!preg_match("`^([a-zA-Z0-9-_]{2,12})$`", $r_pseudo)){
            $error="Le pseudo doit etre valide";
        
        }else{
            $req_pseudo = $dbh->prepare("SELECT user_pseudo FROM Utilisateurs WHERE user_pseudo=?");
            $req_pseudo->bindParam(1, $r_pseudo);
            $req_pseudo->execute();
            if($req_pseudo->rowCount()==0){
                $pseudo=$_POST['pseudo'];
            }else{
                $error = "Le pseudo existe deja";
            }
        }
                


        // verif password
        if (empty($r_pass)){
            $error="Saisissez votre mots de passe";
        }elseif (!preg_match("`^([a-zA-Z0-9-_]{2,12})$`", $password)){
            $error= "Mot de passe faible";
        }elseif($r_pass != $r_pass2){
            $error= "Le mot de passe doit etre identique";
        }else{
            $crypt_password = password_hash($password, PASSWORD_ARGON2ID);
            $password=$_POST['password'];
            
        }
        if (!isset($error)){
            $user_register_date = date('Y-m-d H:i:s');
            $sql="INSERT INTO Utilisateurs (user_email, user_pseudo, user_password, user_register_date, user_last_connection) VALUES (:user_email, :user_pseudo, :user_password, :user_register_date, :user_last_connection)";
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam (':user_email',$email);
            $stmt->bindParam (':user_pseudo',$pseudo);
            $stmt->bindParam (':user_password',$crypt_password);
            $stmt->bindParam (':user_register_date',$user_register_date);
            $stmt->bindParam (':user_last_connection',$user_register_date);
            $stmt->execute();

            $req = $dbh->prepare("SELECT * FROM Utilisateurs WHERE user_email=? AND user_pseudo=?");
            
            $req->bindParam(1, $email);
            $req->bindParam(2, $pseudo);
            $req->execute();

            $row = $req->fetch();

            $_SESSION['user_id'] =$row['user_id'];
            $_SESSION['user_pseudo'] =$row['user_pseudo'];

            header('Location: index.php');   
        }
    } 
}
?>
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
        <div id="container-inscription" class="input"> 
            <form class="login" method="post" action="">
                <input type="text" id="r_email" placeholder="Inserez votre email" name="email"  >
                <input type="text" id="r_pseudo" placeholder="Pseudo" name="pseudo" >
                <input id="r_pass" type="password" placeholder="Mot de passe" name="password" >
                <input id="r_pass2" type="password" placeholder="Confirmez mot de passe" name="password2" >
                <?php if(isset($error)) {?><p id="error-msg"><?= $error ?></p> <?php } ?>
                <a id="login-to-register" href="./login.php">Se connecter un compte</a>
                <input class= "button" type="submit" name="inscription" value="Inscription"> 
            </form>
        </div>
        <?php 
            include('./view/footer.inc.php');
        ?>
    </body>     
</html>  