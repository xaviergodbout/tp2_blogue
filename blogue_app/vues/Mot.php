<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mots Clés</title>
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

    <main class="mot">
            <?php
                echo "<div class='titrePage'>";
                echo "<h1>Liste de mot-clés</h1>";
                while($rangeeMot = mysqli_fetch_assoc($donneeMot)){
                    echo "<a href='index.php?action=MotCle&idMot=" . $rangeeMot["id"] . "'>" . $rangeeMot["mot"] . "</a> ";
                }
                echo "</div>";
                if(isset($donneeArticle)){
                    while($rangeeArticle = mysqli_fetch_assoc($donneeArticle)){
                        echo "<article>";
                        echo "<div>";
                        echo "<h1>" . $rangeeArticle['titre'] . "</h1>";
                        if(isset($_SESSION['utilisateur'])){
                            if($_SESSION['utilisateur'] == $rangeeArticle['idAuteur']){
                                echo "<a href='index.php?action=ModifArticle&idArticle=" . $rangeeArticle['id'] . "'>Modifier</a>";
                            }
                        }
                        echo "</div>";
                            echo "<h2>Par : " . $rangeeArticle['nom'] . " " . $rangeeArticle['prenom'] . "</h2>";
                        echo "<p>" . $rangeeArticle['texte'] . "</p>";
                        
                        $donneeMot = GetMotCleById($rangeeArticle['id']);
                        
                        while($rangeeMot = mysqli_fetch_assoc($donneeMot)){
                            echo "<a href='index.php?action=MotCle&idMot=" . $rangeeMot["id"] . "'>" . $rangeeMot["mot"] . "</a> ";
                        }
                        echo "</article>";
                    }
                }

            ?>
    </main>
</body>
</html>