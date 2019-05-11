<?php
    /*
        FonctionsDB.php est le fichier qui représente notre MODÈLE dans notre architecture MVC-lite. C'est donc dnas ce fichier que nous retrouverons TOUTES les requêtes SQL SANS AUCUNE EXCEPTION. C'est aussi ici que nous retoruverons la connexion à la base de données et les informations nécessaires à celle-ci (hostname, username, password, base de données, etc.)  
    
    */

    function connectDB()
    {
        $c = mysqli_connect("localhost", "root", "", "blogue");
        
        if(!$c)
            trigger_error("Erreur de connexion... " . mysqli_connect_error());
        
        mysqli_query($c, "SET NAMES 'utf8'");
        return $c;
    }

    $connexion = connectDB();

    function GetAllArticle()
    {
        global $connexion;
        
        $requete = "SELECT titre, texte, nom, prenom, mot, idAuteur FROM article JOIN utilisateur ON utilisateur.username = article.idAuteur JOIN motarticle ON article.id = motarticle.idArticle JOIN motcle ON motcle.id = motarticle.idMotCle GROUP BY article.id ORDER BY article.id DESC";
        $resultat = mysqli_query($connexion, $requete);

        return $resultat;
    }

    function Authentification($utilisateur, $password)
    {
        global $connexion;
        
        $requete = "SELECT password FROM utilisateur WHERE username = '" . filtre($utilisateur) . "'";
    
        $resultat = mysqli_query($connexion, $requete);
    
        if($rangee = mysqli_fetch_assoc($resultat))
        {
            if(password_verify($password, $rangee["password"]))                
                return true;
            else
                return false;
        }
        else
            return false;
    }

    function filtre($var)
    {
        global $connexion;
        
        $varFiltre = mysqli_real_escape_string($connexion, $var);
        //appliquer d'autres filtres
        //se prémunir contre les attaques de type XSS (cross-site scripting)
        $varFiltre = strip_tags($varFiltre, "<a><b><em>");
        
        return $varFiltre;
    }
?>