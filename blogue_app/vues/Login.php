<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>
<body>
    <header>
        <?php
            echo "<ul>";
            echo "<li><a href=index.php>Accueil</a></li>";
            echo "<li><a href=index.php?action=MotCle>Mots clés</a></li>";
            if(!isset($_SESSION['utilisateur'])){
                echo "<li><a href=index.php?action=Login>Se connecter</a></li>";
            }
            if(isset($_SESSION['utilisateur'])){
                echo "<li><a href=index.php?action=ajoutArticle>Ajouter un article</a></li>";
                echo "<li><a href=index.php?action=Logout>Se déconnecter</a></li>";
            }
            echo "</ul>";
        ?>
    </header>
    <main>
        <form method="post" action="index.php">
            <label>Nom d'utilisateur :</label>
            <input type="text" name="username">
            <label>Mot de passe :</label>
            <input type="text" name="password">
            <input type="hidden" name="action" value="Verifier">
            <input type="submit" value="Connexion">
        </form>
    </main>
</body>
</html>