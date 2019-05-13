<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Accueil</title>
    <link rel="stylesheet" href="vues/css/reset.css">
    <link rel="stylesheet" href="vues/css/main.css">
</head>
<body>
    <header>
        <div class="wrapper">
            <a href="index.php"><img src="vues/img/logo.svg" alt="Logo Blog"></a>
            <nav>
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
            </nav>
        </div>
    </header>
    <main class="ajout">
        <form method="post" action="index.php" autocomplete="off">
            <label>Titre *</label>
            <input type="text" name="titre">
            <label>Texte *</label>
            <textarea name="texte"></textarea>
            <label>Mots clés</label>
            <input type="text" name="motCle">
            <input type="hidden" name="action" value="ValideAjout">
            <input type="submit" value="Ajouter">
        </form>
    </main>
</body>
</html>