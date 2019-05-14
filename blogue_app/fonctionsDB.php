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
        
        $requete = "SELECT id, titre, texte, nom, prenom, idAuteur FROM article JOIN utilisateur ON utilisateur.username = article.idAuteur GROUP BY article.id ORDER BY article.id DESC";
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
        
        $requete = "SELECT article.id AS id, titre, texte, nom, prenom, mot, idAuteur FROM article JOIN utilisateur ON utilisateur.username = article.idAuteur 
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

    function GetMotCleById($idArticle){
        global $connexion;
        
        $requete = "SELECT id, mot FROM motcle JOIN motarticle ON motcle.id = motarticle.idMotCle WHERE idArticle = " . $idArticle . "";
        
        $resultat = mysqli_query($connexion, $requete);

        return $resultat;
    }

    function idDernierArticle(){
        global $connexion;
        
        $requete = "SELECT MAX(id) AS id FROM article";
        
        $resultat = mysqli_query($connexion, $requete);

        return $resultat;
    }

    function GetMotId($mot_cle){

        global $connexion;
        
        $requete = "SELECT id FROM motcle WHERE mot = '" . $mot_cle . "'";
        
        $resultat = mysqli_query($connexion, $requete);

        return $resultat;
    }

    function AjoutMotCle($mot){

        global $connexion;

        $liste_mot = array_map('trim', explode('&', $mot));

        $dernier_article = idDernierArticle();
        $article = mysqli_fetch_assoc($dernier_article);

        foreach($liste_mot as $mot_cle){
            $a_id_mot = GetMotId($mot_cle);
            $id_mot = mysqli_fetch_assoc($a_id_mot);

            if(mysqli_num_rows($a_id_mot)==0){

                $requete = "INSERT INTO motcle (mot) VALUES ('" . filtre($mot_cle) . "')";

                $resultat = mysqli_query($connexion, $requete);
            }

            $a_id_mot = GetMotId($mot_cle);
            $id_mot = mysqli_fetch_assoc($a_id_mot);

            $requete = "INSERT INTO motarticle (idArticle, idMotCle) VALUES ('" . $article['id'] . "', '" . $id_mot['id'] . "')";
                    
            $resultat = mysqli_query($connexion, $requete);
        }
    }

    // FX obtenir les info de l'Article à modifier
    function GetThisArticleModif($idArticle)
    {
        global $connexion;
        
        $requete = "SELECT article.id, titre, texte, nom, prenom FROM article JOIN utilisateur 
        ON utilisateur.username = article.idAuteur
        WHERE article.id =  '" . $idArticle . "' ";

        $resultat = mysqli_query($connexion, $requete);

        return $resultat;
    }
    // FX modifier l'Article selon les inputs filtrés
    function ModifNow($idArticle, $titreModif, $texteModif)
    {
        global $connexion;
        
        $requete = "UPDATE article SET titre='" . filtre($titreModif) . "', texte='" . filtre($texteModif) . "' WHERE id=" . filtre($idArticle) . "";
        $resultat = mysqli_query($connexion, $requete);

        return $resultat;
    }

    
?>