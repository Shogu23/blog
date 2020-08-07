<?php
session_start(); // ON DEMARRE TOUJOURS LA SESSION EN PREMIER

// On vérifie le cookie remember et on restaure la session si besoin
if(isset($_COOKIE['remember']) && !empty($_COOKIE['remember'])){
    // On récupère et on nettoie le token
    $token = strip_tags($_COOKIE['remember']);
    
    // On se connecte a la base
    require_once 'connect.php';

    // On écrit la requête
    $sql = "SELECT * FROM `users` WHERE `remember_token` = :token;";

    // On prépare la requête
    $query = $db->prepare($sql);

    // On inject le token
    $query->bindValue(':token', $token, PDO::PARAM_STR);

    // On execute la requête
    $query->execute();

    // On va chercher les données
    $user = $query->fetch(PDO::FETCH_ASSOC);

    // Si un utilisateur existe (qui a le token qu'on a dans le cookie)
    if($user){
        // On restaure la session
            $_SESSION['user'] = [
            'id' => $user['id'],
            'nickname' => $user['nickname'],
            'email' => $user['email'],
            'roles' => $user['roles'],
            ];
    }else{
        // On supprime le cookie
        setcookie('remember', '', 
        [
            'path' => '/blog',
            'expires' => 1
        ]);
    }

    
}

require_once 'functions.php';

define('URL', 'http://localhost/blog');


