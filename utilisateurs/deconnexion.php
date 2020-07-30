<?php
session_start();// ON DEMARRE TOUJOURS LA SESSION EN PREMIER

define('URL', 'http://localhost/blog');

// On supprime la partie "user" de SESSION
unset($_SESSION['user']);
header('Location:'.URL);
