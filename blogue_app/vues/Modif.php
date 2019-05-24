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
            <!-- Menu mobile -->
            <input class="menuMobile" type="checkbox" id="btnControl"/>
            <label class="btn menuMobile" for="btnControl"><img src="vues/img/menu.svg" height="15"/></label>
            <nav>
                <?php
                    echo "<ul>";
                    echo "<li><a href=index.php>Accueil</a></li>";
                    echo "<li><a href=index.php?action=MotCle>Mots clés</a></li>";
                    //Si pas connecté
                    if(!isset($_SESSION['utilisateur'])){
                        echo "<li><a href=index.php?action=Login>Se connecter</a></li>";
                    }
                    //Si connecté
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
        <div class="modif">
            <form method='POST' action='index.php'>
                <!--  Titre de la page  -->
                <div class='titrePage supprimer'>
                    <h1>Modifier un article</h1>
                    <!--  Bouton Supprimer  -->
                    <input class="btnSupprimer" type='submit' name='Supprimer' value='Supprimer'>
                </div>
                
                <div class="wrapper">
                    <div class="modifInput">
                        <!--  Message d'erreurs  -->
                        <?php
                            if(isset($erreurs)){
                                echo "<p class='erreur'>* " . $erreurs . "</p>";
                            }
                        
                            $rangeeArticle = mysqli_fetch_assoc($donneeArticle);
                        ?>

                        <!--  Modification Titre  -->
                        <div class="input-group">
                            <input type="text" name='titreModif' placeholder="Titre" value='<?php echo $rangeeArticle['titre'] ?>'>
                        </div>

                        <!--  Modification Texte  -->
                        <div class="input-group">
                            <textarea name='texteModif' rows='20' cols='160' placeholder="Votre texte..."><?php echo $rangeeArticle['texte'] ?></textarea>
                        </div>

                        <!--  Input Hidden -->
                        <input type='hidden' name='idArticle' value='<?php echo $rangeeArticle['id'] ?>'>
                        <input type='hidden' name='action' value='ValideModifArticle'/>

                        <!--  Bouton Enregistrer  -->
                        <div class="input-group">
                            <div>
                                <input class="btn" type='submit' name='Modifier' value='Enregistrer'>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
</body>
</html>