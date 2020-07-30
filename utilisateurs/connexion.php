<?php
// On se connecte a la base de données
require_once '../inc/connect.php';

//On ajoute le nouveau client, AVANT d'aller chercher la liste ( le $sql = SELECT.... juste apres)
if(!empty($_POST)){
    // POST n'est pas vide, on vérifie TOUS les champs obligatoires
    if(
        isset($_POST['formmail']) && !empty($_POST['formmail'])
        && isset($_POST['formpass']) && !empty($_POST['formpass'])
    ){
        // On vérifie la validité de l'email
        if(!filter_var($_POST['formmail'], FILTER_VALIDATE_EMAIL)){
            die('email invalide');
            header ('Location: index.php');
        }else{
            $mailusers = $_POST['formmail'];
        }

        // On écrit la requete ( on va chercher dans la table users les infos)
        $sql = 'SELECT * FROM `users` WHERE `email` = :mailusers;';
      
        // On prépare la requête
        $query = $db->prepare($sql);

        // On injecte les valeurs dans les paramètres
        $query->bindValue(':mailusers', $mailusers, PDO::PARAM_STR);;

        // On execute la requête
        $query->execute();

        // On récupere les données
        $liste = $query->fetch(PDO::FETCH_ASSOC);
        
        if(!$liste){
            die('Email et/ou mdp incorrect');
        } 

        if(password_verify(($_POST['formpass']), ($liste['password']))){
            echo "Vous etes connecté";
        }else{
            echo "Email et / ou mdp incorrect";
        }
    }else{
        $erreur = "Formulaire incomplet";
        echo $erreur;
    }
    
 
}





?>










<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>Connexion</title>
  </head>
  <body>
    <h1>Veuillez vous connecter?</h1>

    <form class="dropdown-menu p-4">
  <div class="form-group">
    <label for="formmail">Email</label>
    <input type="email" id="Mail" name="formmail" class="form-control">
  </div>
  <div class="form-group">
    <label for="Passwrd">Mot de passe?</label>
    <input type="password" id="Passwrd" name="formpass" class="form-control">
  </div>
  <button type="submit" class="btn btn-primary">Sign in</button>
</form>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
</html>

