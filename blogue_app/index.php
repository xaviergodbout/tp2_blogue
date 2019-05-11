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
            require_once("vues/Login.php");
            break;
        case "Verifier":
            //vérifier la combinaison username/password
            if(isset($_POST["username"]) && isset($_POST["password"]))
            {
                $resultat = Authentification($_POST["username"], $_POST["password"]);
                
                if($resultat)
                {
                    $_SESSION["utilisateur"] = $_POST["username"];
                    header("Location: index.php?action=Accueil");
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
        }
?>