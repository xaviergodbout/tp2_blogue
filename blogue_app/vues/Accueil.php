<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Accueil</title>
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
        <?php
            while($rangeeArticle = mysqli_fetch_assoc($donneeArticle)){
                echo "<div>";
                echo "<h2>" . $rangeeArticle['titre'] . "</h2>";
                if(isset($_SESSION['utilisateur'])){
                    if($_SESSION['utilisateur'] == $rangeeArticle['idAuteur']){
                        echo "<a href='index.php?action=ModifArticle'>Modifier</a>";
                    }
                }
                echo "</div>";
                    echo "<h4>" . $rangeeArticle['prenom'] . " " . $rangeeArticle['nom'] . "</h4>";
                echo "<p>" . $rangeeArticle['texte'] . "</p>";
            }
        ?>
    </main>
</body>
</html>