<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page de contact</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/contact.css">
</head>
<body>
    <?php 
        $file_name = "CONTACT";
        include('./view/header.inc.php'); 
    ?>
    <section>
        <div class="infos-container">
            <div class="info1">
                    <div class="type-infos1">
                        <img src="assets/images/telephone.png" alt="icon phone">
                    </div>
                    <p class="gridinfos">06 05 04 03 02</p>
            </div>
            <div class="info2">
                <div class="type-infos2">
                    <img src="assets/images/mail.png" alt="icon mail">
                </div>
                <p class="gridinfos">support@powerofmemory.com</p>
            </div>
            <div class="info3">
                <div class="type-infos3">
                    <img src="assets/images/checkpoint.png" alt="icon checkpoint">
                </div>
                <p class="gridinfos">Paris</p>
            </div>
        </div>

        <div class="form-container">
            <form method ="post">
                <input type="text" name="nom" placeholder="Nom" id="form">
                <input type="text" name="email" placeholder="Email" id="form"></br>
                <input type="text" name="sujet" placeholder="Sujet" id="form"></br>
                <textarea name="comm" placeholder="Message" id="form"></textarea></br>
                <button id="buttonsend"><a href="">Envoyer</a></button>
            </form>
            <p id="message">
                <?php
                if(empty($_POST)){

                    if (empty($_POST["name"])) {

                        echo '<p style = color : white;> Veuillez vérifier le formulaire - veuillez saisir votre nom.';

                    }else if (empty($_POST["email"])){
                        if (!empty($_POST["email"])) {
                            $point = strpos($_POST['nom'], ".");
                            $arobase = strpos($_POST[''], "@");
                            if ($point === false)
                                echo '<p style= color: white;">Veuillez vérifier le formulaire - votre email doit comporter un point.</p>';
                            else if ($arobase === false)
                                echo '<p style= color: white;">Veuillez vérifier le formulaire - votre email doit comporter un arobase.</p>';
                            else
                                echo '<p style= color: white;">Veuillez vérifier le formulaire - votre email est : </p>' . $_POST['email'];
                        } else {
                            echo '<p style= color: white;">Veuillez vérifier le formulaire - veuillez saisir un email.</p>';
                        }
                    }

                }

                ?>
            </p>
        </div>
    </section>
    <?php
        include('./view/footer.inc.php');
    ?>
</body>
</html>