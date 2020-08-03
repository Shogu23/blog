<?php
session_start(); // ON DEMARRE TOUJOURS LA SESSION EN PREMIER

require_once 'functions.php';

define('URL', 'http://localhost/blog');

if(isset($_SESSION['user'])){
    echo "Bonjour".$_SESSION['user']['nickname']."<a href='".URL."/utilisateurs/deconnexion.php'>Déconnexion</a>";
}else{
    echo '<a href="'.URL.'/utilisateurs/connexion.php">Connexion</a> - <a href="'.URL.'/utilisateurs/index.php">Inscription</a>'; 
}


