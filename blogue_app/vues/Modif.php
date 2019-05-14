<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Modifier un Article</title>
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

    <main class="Modif">
            <?php
                echo "<div class='ModifArticle'>";
                echo "<h1>Modifier un Article</h1>";
                
                echo "</div>";
                if(isset($_SESSION["utilisateur"]))
                {
                    $rangeeArticle = mysqli_fetch_assoc($donneeArticle);
                    echo "<form method='POST' action='index.php'>";
                    echo "<p>Titre: </p><input name='titreModif' value='" . $rangeeArticle['titre'] . "'></input><br>";
                    echo "<p>Texte de l'Article: </p><textarea name='texteModif' rows='20' cols='160'>" . $rangeeArticle['texte'] . "</textarea><br>";
                    
                    echo "<input type='hidden' name='idArticle' value='" . $rangeeArticle['id'] . "'></input>";
                    echo "<input type='hidden' name='action' value='ValideModifArticle'/><br>
                    <input type='submit' value='Modifier'/>";
                    echo "</form>";
                }
                

            ?>
    </main>
</body>
</html>