<?php
require_once 'inc/header.php';
// On se connecte a la base de données
require_once 'inc/connect.php';

// Si tu veux ne selectionner que certaines parties a afficher
$sql = "SELECT a.*, c.`name`, u.`nickname` FROM `articles` a 
        LEFT JOIN `categories` c ON a.`categories_id` = c.`id` 
        LEFT JOIN `users` u ON a.`users_id` = u.`id` ORDER BY a.`created_at` desc;";

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

<h1> <a href="articles.php?id=<?= $article['id'] ?>"><?= $article['title'] ?></a> </h1>
<?php if(!is_null($article['featured_image'])): ?>
    <p><img src="<?= URL . '/uploads/' . $article['featured_image']. "_thump.jpg" ?>" alt="<?= $article['nickname'] ?>"></p>
<?php endif; ?>
<h2> <?= $article['nickname'] ?> </h2>
<h3> <?= "Catégorie ".$article['name']." le ".formatDate($article['created_at']) ?> </h3>
<p> <?= extrait($article['content'], 150) ?> </p>

<?php endforeach; ?>


</body>
</html>
