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
        case "MotCle":
            $donneeMot = GetAllMot();
            if(isset($_GET["idMot"])){
                $donneeArticle = GetAllArticleParMotCle($_GET["idMot"]);
            }
            require_once("vues/Mot.php");
            break;
        case "ajoutArticle":
            if(isset($_SESSION['utilisateur'])){
                require_once("vues/AjoutArticle.php");
            }
            else{
                require_once("vues/Login.php");
            }
            break;
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