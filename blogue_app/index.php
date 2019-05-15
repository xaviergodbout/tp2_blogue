<?php
    session_start();

    if(isset($_REQUEST["action"]))
    {
        $action = $_REQUEST["action"];
    }
    else
    {
        $action = "Accueil";
    }

    require_once("fonctionsDB.php");

    switch($action){
        //Aller a la page acceuil
        case "Accueil":
            $donneeArticle = GetAllArticle();
            require_once("vues/Accueil.php");
            break;
        case "Login":
            if(!isset($_SESSION["utilisateur"])){
                require_once("vues/Login.php");
                $_SESSION['dernierePage'] = $_SERVER['HTTP_REFERER'];
            }
            else{
                header("Location: index.php");
            }
            break;
        case "Verifier":
            //vérifier la combinaison username/password
            if(isset($_POST["username"]) && isset($_POST["password"]))
            {
                $resultat = Authentification($_POST["username"], $_POST["password"]);
                
                if($resultat)
                {
                    $_SESSION["utilisateur"] = $_POST["username"];
                    if(isset($_SESSION['dernierePage'])){
                        header("Location: " . $_SESSION['dernierePage'] . "");
                    }
                    else{
                        header("Location: " . $_SERVER['HTTP_REFERER'] . "");
                    }
                    
                }
                else
                {
                    $erreurs = "Combinaison username/password invalide.";
                    require_once("vues/Login.php");
                }
            }
            else
            {
                header("Location: index.php");
            }
            break;
        //Affiche la page Mots clés
        case "MotCle":
            $donneeMot = GetAllMot();
            if(isset($_GET["idMot"]) && is_numeric($_GET["idMot"])){
                $donneeArticle = GetAllArticleParMotCle($_GET["idMot"]);
            }
            require_once("vues/Mot.php");
            break;
        //Affiche la page ajouter un article
        case "ajoutArticle":
            if(isset($_SESSION['utilisateur'])){
                require_once("vues/AjoutArticle.php");
            }
            else{
                require_once("vues/Login.php");
            }
            break;
        //Valide l'ajoute d'un article
        case "ValideAjout":
            if(isset($_SESSION['utilisateur'])){
                if(isset($_POST['titre']) && isset($_POST['texte']) && isset($_POST['motcle'])){
                    if(trim($_POST['titre']) != "" && trim($_POST['texte']) != ""){
                        AjoutArticle($_POST['titre'], $_POST['texte'], $_SESSION["utilisateur"]);
                        
                        if(trim($_POST['motcle']) != ""){
                            AjoutMotCle($_POST['motcle']);
                        }
                        header("Location: index.php");
                    }
                    else{
                        $erreurs = "Veuillez remplir tous les champs obligatoires.";
                        require_once("vues/AjoutArticle.php");
                    }
                }
            }
            else{
                require_once("vues/AjoutArticle.php");
            }
            break;
        //FX case ModifArticle pour se rendre à la page Modification d'article et passer les info de l'article que l'on veut modifier
        case "ModifArticle":
            if(isset($_SESSION['utilisateur'])){
                if(isset($_GET["idArticle"]) && is_numeric($_GET["idArticle"])){
                    $donneeArticle = GetThisArticleModif($_GET["idArticle"]);
                    require_once("vues/Modif.php");
                }
                else{
                    header("Location: index.php");
                }
            }
            else{
                require_once("vues/Login.php");
            }
            break;
        // FX case Validation de la modification de l'article 
        case "ValideModifArticle":
            if(isset($_SESSION['utilisateur'])){
                if(isset($_POST["titreModif"]) && isset($_POST["texteModif"]) && isset($_GET['idArticle']))
                {
                    ModifNow($_GET["idArticle"], $_POST["titreModif"], $_POST["texteModif"]);
                    header("Location: index.php");
                }
                else
                {
                    $erreurs = "Veuillez remplir tous les champs obligatoires.";
                    require_once("vues/Modif.php");
                }
            }
            break;
        case "Logout":
            //vider le tableau $_SESSION
            $_SESSION = array();
            
            //supprimer le cookie de session
            if(isset($_COOKIE[session_name()]))
            {
                setcookie(session_name(), '', time() - 3600);
            }
            
            //détruire la session complètement
            session_destroy();
            header("Location: index.php");
            break;
        }
?>