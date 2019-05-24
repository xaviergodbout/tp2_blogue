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
        <!--  Titre de la page  -->
        <div class='titrePage'>
            <h1>Se connecter</h1>
        </div>
        <div class="login">
            <form method="post" action="index.php">
                <!--  Message d'erreurs  -->
                <?php
                    if(isset($erreurs)){
                        echo "<p class='erreur'>* " . $erreurs . "</p>";
                    }
                ?>
                <!--  Username  -->
                <div class="input-group">
                    <input type="text" name="username" placeholder="Nom d'utilisateur :">
                </div>

                <!--  Password  -->
                <div class="input-group">
                    <input type="password" name="password" placeholder="Mot de passe :">
                </div>
                
                <!--  Input hidden  -->
                <input type="hidden" name="action" value="Verifier">

                <!--  Bouton se connecter  -->
                <div class="input-group">
                    <div>
                        <input class="btn" type="submit" value="Connexion">
                    </div>
                </div>
            </form>
        </div>
    </main>
</body>
</html>