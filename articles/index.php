<?php
require_once '../inc/header.php';

require_once '../inc/connect.php';

// j'ajoute la nav
require_once '../inc/nav.php';

$_SESSION['msgUpload'] = "Erreur lors de l'upload..";

$_SESSION['msgSize'] = "Fichier trop volumineux.";

$_SESSION['msgExt'] = "Désolé, only JPG, JPEG, PNG le reste c'est mort.";

$_SESSION['msgError'] = "Erreur lors du transfert vers le dossier de destination";






// Transforme une STRING ( chaine de carac "json" en tableau PHP )

if(!isset($_SESSION['user'])){
    header('Location:'.URL.'/utilisateurs/connexion.php');
}
$roles = json_decode($_SESSION['user']['roles']);
if(!in_array("ROLE_ADMIN", $roles)){
        header('Location:'.URL);
}


$sql = "SELECT * FROM `categories` ORDER BY `name` ASC";

$query = $db->query($sql);

$categories = $query->fetchAll(PDO::FETCH_ASSOC);


// POST n'est pas vide, on vérifie TOUS les champs obligatoires
if(!empty($_POST)){
    if(
        isset($_POST['formtitre']) && !empty($_POST['formtitre'])
        && isset($_POST['formcontent']) && !empty($_POST['formcontent']
        && isset($_POST['formcat']) && !empty($_POST['formcat'])
        )        
    ){
        // On récupere et on nettoie les données
        $arttitre = strip_tags($_POST['formtitre']);
        $artcontent = htmlspecialchars($_POST['formcontent']);
        $nomImage = null;

        // On récupère et on stocke l'image si elle existe
        if(
            isset($_FILES['image']) && !empty($_FILES['image']) && $_FILES['image']['error'] != UPLOAD_ERR_NO_FILE)
            {
            // On vérifie qu'on n'a pas d'erreur
            if($_FILES['image']['error'] != UPLOAD_ERR_OK){
                echo $_SESSION['msgUpload'];
            }

            // On génère un nouveau nom de fichier
            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $nomImage = md5(uniqid()).'.'.$extension;
            
            $goodExtensions = ['jpg', 'jpeg', 'jif', 'jfif', 'pjpeg', 'pjp', 'png'];
            $typemime = ['image/jpeg', 'image/png'];
            $type_file = $_FILES['image']['type'];

            // Je vérifie la taille de l'image ( limite a 1Mo ( 1024x1024))
            if ($_FILES['image']['size'] > 1048576){
                echo $_SESSION['msgSize'];
            }
            
            // Vérif extension!            
            if (!in_array(strtolower($extension), $goodExtensions) || !in_array($type_file, $typemime))
            {
                echo $_SESSION['msgExt'];
            }
                    
            // On transfère le fichier (le moveupload ( fichier source, fichier destination))
            if (!move_uploaded_file($_FILES['image']['tmp_name'], __DIR__.'/../uploads/'.$nomImage))
            {
                // Transfert échoué
                echo $_SESSION['msgError'];
            }
            
            mini(__DIR__.'/../uploads/'.$nomImage, 200);
            mini(__DIR__.'/../uploads/'.$nomImage, 300);    
        }
           

        // On ecrit la requete
        $sql = "INSERT INTO `articles` (`title`, `content`, `users_id`, `categories_id`, `featured_image`) 
                VALUES (:arttitre, :artcontent, :user, :artcat, :nomimage);";
        
        // On prépare la requête
        $query = $db->prepare($sql);

        // On injecte les valeurs dans les paramètres
        $query->bindValue(':arttitre', $arttitre, PDO::PARAM_STR);
        $query->bindValue(':artcontent', $artcontent, PDO::PARAM_STR);
        $query->bindValue(':artcat', $_POST['formcat'], PDO::PARAM_INT);
        $query->bindValue(':user', $_SESSION['user']['id'], PDO::PARAM_INT);
        $query->bindValue(':nomimage', $nomImage, PDO::PARAM_STR);
        
        // On execute la requête
        $query->execute();


        header('Location:'.URL);
        exit;
    }else{
        // Au moins 1 champs est invalide
        $erreur = "Le formulaire est incomplet";
    }

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form style="justify-content: center;" enctype="multipart/form-data" method="post">
        <h2>Ajouter un article</h2>
        <div>
            <label for="Title">Titre</label>
            <input type="text" id="Title" name="formtitre">
        </div>
        <div>
            <label for="Content">Contenu</label>
            <textarea id="Content" name="formcontent" style="resize: none;" rows="10" cols="30">

            </textarea> 
        </div>
        <div>
            <label for="Categorie">Catégorie</label>
            <select id="Categorie" name="formcat" required>
            
                <option selected="selected" disabled="disabled">Choisir une catégorie</option>
                <?php foreach($categories as $categorie): ?>
                <option value="<?= $categorie['id'] ?>"><?= $categorie['name'] ?></option>
            <?php endforeach; ?>  
            </select>
        </div>
        <div>
            <label for="image">Image : </label>
            <input type="file" name="image" id="image" accept="image/png, image/jpeg">
        </div>
        <div>
            <button>Ajouter</button>
        </div>
    </form>
</body>
</html>