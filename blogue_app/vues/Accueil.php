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

    <main class="accueil">
        <?php
            //Boucle générant les articles
            while($rangeeArticle = mysqli_fetch_assoc($donneeArticle)){
                echo "<article>";
                echo "<div class='modif'>";
                //Titre de l'article
                echo "<h1>" . $rangeeArticle['titre'] . "</h1>";
                //Modifier l'article si auteur
                if(isset($_SESSION['utilisateur'])){
                    if($_SESSION['utilisateur'] == $rangeeArticle['idAuteur']){
                        echo "<a href='index.php?action=ModifArticle&idArticle=" . $rangeeArticle['id'] . "'>Modifier</a>";
                    }
                }
                //Auteur de l'article
                echo "</div>";
                    echo "<h2>Par : " . $rangeeArticle['prenom'] . " " . $rangeeArticle['nom'] . "</h2>";
                echo "<p>" . $rangeeArticle['texte'] . "</p>";
                //Mot-clés de l'article
                $donneeMot = GetMotCleById($rangeeArticle['id']);
                echo "<div class='motCle'>";
                    while($rangeeMot = mysqli_fetch_assoc($donneeMot)){
                        echo "<a href='index.php?action=MotCle&idMot=" . $rangeeMot["id"] . "'>" . $rangeeMot["mot"] . "</a> ";
                    }
                echo "</div>";
                echo "</article>";
            }
        ?>
    </main>
</body>
</html>