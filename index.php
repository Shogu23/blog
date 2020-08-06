<?php
require_once 'inc/header.php';
// On se connecte a la base de données
require_once 'inc/connect.php';
// j'ajoute la nav
require_once 'inc/nav.php';

// Si tu veux ne selectionner que certaines parties a afficher
$sql = "SELECT a.*, c.`name`, u.`nickname` FROM `articles` a 
        LEFT JOIN `categories` c ON a.`categories_id` = c.`id` 
        LEFT JOIN `users` u ON a.`users_id` = u.`id` ORDER BY a.`created_at` desc;";

$query = $db->query($sql);

$articles = $query->fetchAll(PDO::FETCH_ASSOC);

?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/css/bootstrap.min.css"
        integrity="sha384-VCmXjywReHh4PwowAiWNagnWcLhlEJLA5buUprzK8rxFgeH0kww/aWY76TfkUoSX" crossorigin="anonymous">

    <title>Mon Blog</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <?php foreach($articles as $article): ?>
            <div class="col-md-6">

                <div class="h-100 card" style="width: 24rem;">

                    <?php if(!is_null($article['featured_image'])):
    // On fabrique le nom de l'image
    $extArticle = pathinfo($article['featured_image'], PATHINFO_EXTENSION);
    $nomArticle = pathinfo($article['featured_image'], PATHINFO_FILENAME);
    $imgArticle = "$nomArticle-300x300.$extArticle";
?>

                    <img src="<?= URL . '/uploads/' . $imgArticle ?>" class="card-img-top"
                        alt="<?= $article['nickname'] ?>">

                    <?php endif; ?>

                    <div class="card-body">

                        <h5 class="card-title"><a
                                href="articles.php?id=<?= $article['id'] ?>"><?= $article['title'] ?></a></h5>

                        <h6 class="card-subtitle mb-2 text-muted"> <?= $article['nickname'] ?></h6>

                        <h6 class="card-subtitle mb-2 text-muted"> <?= "Catégorie ".$article['name'] ?></h6>

                        <h6 class="card-subtitle mb-2 text-muted"> <?= "Le".formatDate($article['created_at']) ?></h6>

                        <p class="card-text"><?= extrait($article['content'], 150) ?></p>

                        <a href="#" class="btn btn-primary">Modifier</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/js/bootstrap.min.js"
        integrity="sha384-XEerZL0cuoUbHE4nZReLT7nx9gQrQreJekYhJD9WNWhH8nEW+0c5qq7aIo2Wl30J" crossorigin="anonymous">
    </script>
</body>

</html>