<?php
require_once '../inc/header.php';

require_once '../inc/connect.php';

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
        //TOUS les champs sont valides (strip_tags() = No balises, htmlspechar = no <>, htmlentities = no <> no "" )
        $arttitre = strip_tags($_POST['formtitre']);
        $artcontent = htmlspecialchars($_POST['formcontent']);
        

        // On ecrit la requete
        $sql = "INSERT INTO `articles` (`title`, `content`, `users_id`, `categories_id`) VALUES (:arttitre, :artcontent, :user, :artcat);";
        
        // On prépare la requête
        $query = $db->prepare($sql);

        // On injecte les valeurs dans les paramètres
        $query->bindValue(':arttitre', $arttitre, PDO::PARAM_STR);
        $query->bindValue(':artcontent', $artcontent, PDO::PARAM_STR);
        $query->bindValue(':artcat', $_POST['formcat'], PDO::PARAM_INT);
        $query->bindValue(':user', $_SESSION['user']['id'], PDO::PARAM_INT);
        
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
<form style="justify-content: center;" method="post">
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
            <button>Ajouter</button>
        </div>
    </form>
</body>
</html>