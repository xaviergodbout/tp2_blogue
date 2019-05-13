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
        
        $requete = "SELECT titre, texte, nom, prenom, idAuteur FROM article JOIN utilisateur ON utilisateur.username = article.idAuteur GROUP BY article.id ORDER BY article.id DESC";
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
        $varFiltre = strip_tags($varFiltre, "<a><b><em><br>");
        
        return $varFiltre;
    }

    function GetAllMot()
    {
        global $connexion;

        $requete = "SELECT id, mot FROM motcle JOIN motarticle ON motcle.id = motarticle.idMotCle GROUP BY id ORDER BY COUNT(idMotcle) DESC";
        $resultat = mysqli_query($connexion, $requete);

        return $resultat;
    }

    function GetAllArticleParMotCle($idMot)
    {
        global $connexion;
        
        $requete = "SELECT titre, texte, nom, prenom, mot, idAuteur FROM article JOIN utilisateur ON utilisateur.username = article.idAuteur 
        JOIN motarticle ON article.id = motarticle.idArticle JOIN motcle ON motcle.id = motarticle.idMotCle 
        WHERE motcle.id = $idMot GROUP BY article.id ORDER BY article.id DESC";

        $resultat = mysqli_query($connexion, $requete);

        return $resultat;
    }

    function AjoutArticle($titre, $texte, $auteur){
        
        global $connexion;
        
        $requete = "INSERT INTO article (titre, texte, idAuteur) VALUES ('" . filtre($titre) . "', '" . filtre($texte) . "', '" . filtre($auteur) . "')";

        $resultat = mysqli_query($connexion, $requete);
    }

    function GetAllMotCle(){

        global $connexion;

        $requete = "SELECT id, mot FROM motcle";
        
        $resultat = mysqli_query($connexion, $requete);

        return $resultat;
    }

    function idDernierArticle(){
        global $connexion;
        
        $requete = "SELECT MAX(id) AS id FROM article";
        
        $resultat = mysqli_query($connexion, $requete);

        return $resultat;
    }

    function AjoutMotCle($mot){

        global $connexion;

        $liste_mot = array_map('trim', explode('&', $mot));

        foreach($liste_mot as $mot_cle){
            $liste = GetAllMotCle();
            $mot_valide = true;
            while($rangee = mysqli_fetch_assoc($liste)){
                if($rangee['mot'] == $mot_cle){
                    $mot_valide = false;
                }
            }
            if($mot_valide){
                $requete = "INSERT INTO motcle (mot) VALUES ('" . filtre($mot_cle) . "')";
                    
                $resultat = mysqli_query($connexion, $requete);
            }
        }

        $liste = GetAllMotCle();
        $dernier_article = idDernierArticle();
        $article = mysqli_fetch_assoc($dernier_article);

        while($rangee = mysqli_fetch_assoc($liste)){
            foreach($liste_mot as $mot_cle){
                if($rangee['mot'] == $mot_cle){
                    $requete = "INSERT INTO motarticle (idArticle, idMotCle) VALUES ('" . $article['id'] . "', '" . $rangee['id'] . "')";
                    
                    $resultat = mysqli_query($connexion, $requete);
                }
            }
        }
    }
?>