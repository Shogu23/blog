<?php

use PHPMailer\PHPMailer\Exception;

require_once '../inc/header.php';
// On se connecte a la base de données
require_once '../inc/connect.php';
// On ajoute la nav
require_once '../inc/nav.php';

//On ajoute le nouveau client, AVANT d'aller chercher la liste ( le $sql = SELECT.... juste apres)
if(!empty($_POST)){
    // POST n'est pas vide, on vérifie TOUS les champs obligatoires
    if(
        isset($_POST['formnom']) && !empty($_POST['formnom'])
        && isset($_POST['formmail']) && !empty($_POST['formmail'])
        && isset($_POST['formpass']) && !empty($_POST['formpass'])
        && isset($_POST['formpassverif']) && !empty($_POST['formpassverif'])
    ){
        // strip_tags pour empecher les injections de JS
        $nomusers = strip_tags($_POST['formnom']);
        if(!filter_var($_POST['formmail'], FILTER_VALIDATE_EMAIL)){
            die('email invalide');
            header ('Location: index.php');
        }else{
            $mailusers = $_POST['formmail'];
        }
        //On verifie que les mots de pass sont identiques
        if($_POST['formpass'] != $_POST['formpassverif']){
            die('Mots de pass différents');
            header('Location: index.php');
        }else{
            // On chiffre le mdp
            $passusers = password_hash($_POST['formpass'], PASSWORD_ARGON2ID);
        }
        
        // On ecrit la requete
        $sql = "INSERT INTO `users` (`email`, `password`, `nickname`) VALUES (:mailusers, :password, :nomusers); ";
        
        // On prépare la requête
        $query = $db->prepare($sql);

        // On injecte les valeurs dans les paramètres
        $query->bindValue(':nomusers', $nomusers, PDO::PARAM_STR);;
        $query->bindValue(':mailusers', $mailusers, PDO::PARAM_STR);;
        $query->bindValue(':password', $passusers, PDO::PARAM_STR);;



        // On execute la requête
        $query->execute();

        require_once '../inc/config-mail.php';
        
        // Ce fichier enverra un mail dès son chargement
        try{
            // On définit l'expéditeur du mail
            $sendmail->setFrom('no-reply@mondommaine.fr', 'Blog');

            // On définit le/les destinataire(s)
            $sendmail->addAddress($mailusers, $nomusers);

            // On définit le sujet du mail
            $sendmail->Subject = 'Confirmation d\'inscription';

            // On active le HTML
            $sendmail->isHTML();

            // On écrit le contenu du mail
            // En HTML
            $sendmail->Body = "<h1>Message de Blog</h1>
                               <p>Félicitation $nomusers, vous êtes désormais inscrit.</p>";

            // En texte brut
            $sendmail->AltBody = "L'user \"$nomusers\" viens d'être inscrit";

            // On envoie le mail
            $sendmail->send();
            // echo "Mail envoyé";

        }catch(Exception $e){
            // Ici le mail n'est pas parti
            echo 'Erreur : ' . $e->errorMessage();
        }

    }else{
        // Au moins 1 champs est invalide
        $erreur = 'Le formulaire est incomplet';
        echo "<p>$erreur</p>";
    }
    
 
}


$sql = 'SELECT * FROM `users`;';

// On exécute notre requête
$query = $db->query($sql);

// On récupere les données
$liste = $query->fetchall(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Utilisateurs</title>
</head>

<body>
    <table>
        <h1>Liste des utilisateurs</h1>
        <thead>
            <tr>
                <th>Id</th>
                <th>Pseudo</th>
                <th>eMail</th>
                <th>Pass</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($liste as $user):
        ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td style="text-align: center;"><?= $user['nickname'] ?></td>
                <td style="text-align: center;"><?= $user['email'] ?></td>
                <td><?= $user['password'] ?></td>
                <td style="text-align: center;"><?= $user['roles'] ?></td>
                <td><a href="modifier.php?id=<?= $user['id'] ?>">Modifier</a><a href="delete.php?id=<?= $user['id'] ?>">Delete</a></td>
            </tr>
            <?php
            endforeach;
        ?>
        </tbody>
    </table>
    <form method="post">
        <h2>Inscription</h2>
        <div>
            <label for="Name">Pseudo</label>
            <input type="text" id="Name" name="formnom">
        </div>
        <div>
            <label for="Mail">eMail</label>
            <input type="email" id="Mail" name="formmail">
        </div>
        <div>
            <label for="Passwrd">Mot de pass</label>
            <input type="password" id="Passwrd" name="formpass">
        </div>
        <div>
            <label for="VerifPasswrd">Mot de pass</label>
            <input type="password" id="VerifPasswrd" name="formpassverif">
        </div>
        <div>
            <button>Ajouter</button>
        </div>
    </form>

</body>

</html>