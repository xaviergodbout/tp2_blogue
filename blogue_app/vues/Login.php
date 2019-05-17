<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
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
            <h1>Se connecter</h1>
        </div>
        <div class="login">
            <form method="post" action="index.php">
                <div class="input-group">
                    <input type="text" name="username" placeholder="Nom d'utilisateur :">
                </div>
                <div class="input-group">
                    <input type="password" name="password" placeholder="Mot de passe :">
                </div>
                
                <input type="hidden" name="action" value="Verifier">
                <div class="input-group">
                    <div>
                        <input class="btn" type="submit" value="Connexion">
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
<script src="vues/js/label.js"></script>
</html>