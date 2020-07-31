<?php
require_once '../inc/header.php';
// On se connecte a la base de données
require_once '../inc/connect.php';

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

            foreach($liste as $user):
        ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td style="text-align: center;"><?= $user['nickname'] ?></td>
                <td style="text-align: center;"><?= $user['email'] ?></td>
                <td><?= $user['password'] ?></td>
                <td style="text-align: center;"><?= $user['roles'] ?></td>
                <td><a href="modifier.php?id=<?= $user['id'] ?>">Modifier</a><a href="delete.php?id=<?= $user['id'] ?>">Delete</a></td>
            </tr>
            <?php
            endforeach;
        ?>
        </tbody>
    </table>
    <form method="post">
        <h2>Inscription</h2>
        <div>
            <label for="Name">Pseudo</label>
            <input type="text" id="Name" name="formnom">
        </div>
        <div>
            <label for="Mail">eMail</label>
            <input type="email" id="Mail" name="formmail">
        </div>
        <div>
            <label for="Passwrd">Mot de pass</label>
            <input type="password" id="Passwrd" name="formpass">
        </div>
        <div>
            <label for="VerifPasswrd">Mot de pass</label>
            <input type="password" id="VerifPasswrd" name="formpassverif">
        </div>
        <div>
            <button>Ajouter</button>
        </div>
    </form>

</body>

</html>


<th>Titre</th>
                <th>Auteur</th>
                <th>Date</th>
                <th>Contenu</th>