
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


<?php if(!is_null($article['featured_image'])):
    // On fabrique le nom de l'image
    $extArticle = pathinfo($article['featured_image'], PATHINFO_EXTENSION);
    $nomArticle = pathinfo($article['featured_image'], PATHINFO_FILENAME);
    $imgArticle = "$nomArticle-300x300.$extArticle";
?>

    <p><img src="<?= URL . '/uploads/' . $imgArticle ?>" alt="<?= $article['nickname'] ?>"></p>
    
<?php endif; ?>

<h2> <?= $article['nickname'] ?> </h2>

<h3> <?= "Catégorie ".$article['name']." le ".formatDate($article['created_at']) ?> </h3>

<p> <?= extrait($article['content'], 150) ?> </p>

<?php endforeach; ?>


</body>
</html>
