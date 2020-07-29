<?php
// On vérifie si on a un id dans l'URL
if(isset($_GET['id']) && !empty($_GET['id'])){

    // On a un id, on va chercher la category dans la base
    // On se connecte
    require_once '../inc/connect.php';
    $sql = "SELECT * FROM `users` WHERE `id` = :id";

    // On prepare la requete
    $query = $db->prepare($sql);

    //On accroche les valeurs aux parametres
    $query->bindValue(':id', $_GET['id'], PDO::PARAM_INT);

    //On exécute la requete
    $query->execute();

    //On récupère les données
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if(!$user){
        // category est vide (false)
        header('Location: index.php');
    }

    // Ici $user contient un enregistrement de la base de données
    // On vérifie que POST contient des données


//On ajoute le nouveau client, AVANT d'aller chercher la liste ( le $sql = SELECT.... juste apres)
if(!empty($_POST)){
    // POST n'est pas vide, on vérifie TOUS les champs obligatoires
    if(
        isset($_POST['formnom']) && !empty($_POST['formnom'])
        && isset($_POST['formmail']) && !empty($_POST['formmail'])
        && isset($_POST['formpass']) && !empty($_POST['formpass'])
    ){
        //TOUS les champs sont valides (strip_tags() = No balises, htmlspechar = no <>, htmlentities = no <> no "" )
        $nomusers = strip_tags($_POST['formnom']);
        $mailusers = strip_tags($_POST['formmail']);
        $passusers = ($_POST['formpass']);

        // On ecrit la requete
        $sql = "UPDATE `users` SET `email` = :mailusers, `password` = :password, `nickname` = :nomusers WHERE `users`.`id` = {$user['id']}; ";
                
        // On prépare la requête
        $query = $db->prepare($sql);

        // On injecte les valeurs dans les paramètres
        $query->bindValue(':nomusers', $nomusers, PDO::PARAM_STR);;
        $query->bindValue(':mailusers', $mailusers, PDO::PARAM_STR);;
        $query->bindValue(':password', password_hash($passusers, PASSWORD_DEFAULT), PDO::PARAM_STR);;

        // On execute la requête
        $query->execute();
        header('Location: index.php');
    }else{
        // Au moins 1 champs est invalide
        $erreur = "Le formulaire est incomplet";
    }
 
}


}else{
    // Pas d'id ou id vide, on retourne à la page index
    header('Location: index.php');
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier</title>
</head>

<body>
    <h1>Modifier l'utilisateur</h1>
    <form method="post">
        <div>
            <label for="Name">Pseudo</label>
            <input type="text" id="Name" name="formnom" value="<?= $user['nickname'] ?>">
        </div>
        <div>
            <label for="Mail">eMail</label>
            <input type="email" id="Mail" name="formmail" value="<?= $user['email'] ?>">
        </div>
        <div>
            <label for="Passwrd">Mot de pass</label>
            <input type="password" id="Passwrd" name="formpass" value="<?= $user['password'] ?>">
        </div>
        <div>
            <button>Modifier</button>
        </div>
    </form>

</body>

</html>