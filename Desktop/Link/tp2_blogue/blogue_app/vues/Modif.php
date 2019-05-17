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

    <main>
        <div class='titrePage'>
            <h1>Modifier un article</h1>
        </div>
        <div class="modif">
            <form method='POST' action='index.php'>
                <?php  $rangeeArticle = mysqli_fetch_assoc($donneeArticle);?>
                <div class="input-group">
                    <input type="text" name='titreModif' placeholder="Titre" value='<?php echo $rangeeArticle['titre'] ?>'>
                </div>
                <div class="input-group">
                    <textarea name='texteModif' rows='20' cols='160' placeholder="Votre texte..."><?php echo $rangeeArticle['texte'] ?></textarea>
                </div>

                <input type='hidden' name='idArticle' value='<?php echo $rangeeArticle['id'] ?>'>
                <input type='hidden' name='action' value='ValideModifArticle'/>

                <div class="input-group">
                    <div>
                        <input class="btn" type='submit' name='Modifier' value='Modifier'>
                        <input class="btn" type='submit' name='Supprimer' value='Supprimer'>
                    </div>
                </div>
            </form>
        </div>
        <?php
            if(isset($erreurs)){
                echo "<p>* " . $erreurs . "</p>";
            }
        ?>
    </main>
</body>
</html>