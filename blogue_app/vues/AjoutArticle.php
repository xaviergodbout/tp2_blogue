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

    <main>
        <div class='titrePage'>
            <h1>Ajouter un article</h1>
        </div>

        <div class="ajout">
            <form method="post" action="index.php" autocomplete="off">
                <div class="input-group">
                    <input type="text" name="titre" placeholder="Titre">
                </div>

                <div class="input-group">
                    <textarea name="texte" placeholder="Votre texte..."></textarea>
                </div>

                <div class="input-group">
                    <input type="text" name="motcle" placeholder="Mots clés (e.g. Sport&Hockey&Canadiens)">
                </div>

                <input type="hidden" name="action" value="ValideAjout">
                <div class="input-group">
                    <div>
                        <input class="btn" type="submit" value="Ajouter">
                    </div>
                </div>
            </form>
        </div>
    </main>
</body>
</html>