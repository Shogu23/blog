<?php
require_once 'inc/header.php';
// On se connecte a la base de données
require_once 'inc/connect.php';

// Si tu veux ne selectionner que certaines parties a afficher
$sql = "SELECT a.*, c.`name`, u.`nickname` FROM `articles` a 
        LEFT JOIN `categories` c ON a.`categories_id` = c.`id` 
        LEFT JOIN `users` u ON a.`users_id` = u.`id`";

$query = $db->query($sql);

$articles = $query->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Blog</title>
</head>
<body>
    
<?php foreach($articles as $article): ?>

<h1> <?= $article['title'] ?> </h1>
<h2> <?= $article['nickname'] ?> </h2>
<h3> <?= $article['created_at'] ?> </h3>
<p> <?= $article['content'] ?> </p>

<?php endforeach; ?>



</body>
</html>
