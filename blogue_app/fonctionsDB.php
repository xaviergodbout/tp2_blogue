<?php

    //Connexion a la base de données
    function connectDB()
    {
        $c = mysqli_connect("localhost", "root", "", "blogue");
        
        if(!$c)
            trigger_error("Erreur de connexion... " . mysqli_connect_error());
        
        mysqli_query($c, "SET NAMES 'utf8'");
        return $c;
    }


    $connexion = connectDB();

    //Cherche tout les articles pour affichage sur l'accueil
    function GetAllArticle()
    {
        global $connexion;
        
        $requete = "SELECT id, titre, texte, nom, prenom, idAuteur FROM article JOIN utilisateur ON utilisateur.username = article.idAuteur GROUP BY article.id ORDER BY article.id DESC";
        $resultat = mysqli_query($connexion, $requete);

        return $resultat;
    }

    //Authentification au login
    function Authentification($utilisateur, $password)
    {
        global $connexion;
        
        $_SESSION["username"] = $utilisateur;
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

    //Cherche tout les mots clés en orde des plus utilisés
    function GetAllMot()
    {
        global $connexion;

        $requete = "SELECT id, mot FROM motcle JOIN motarticle ON motcle.id = motarticle.idMotCle GROUP BY id ORDER BY COUNT(idMotcle) DESC";
        $resultat = mysqli_query($connexion, $requete);

        return $resultat;
    }

    //Cherche les articles avec l'id d'un mot clé
    function GetAllArticleParMotCle($idMot)
    {
        global $connexion;
        
        $requete = "SELECT article.id AS id, titre, texte, nom, prenom, mot, idAuteur FROM article JOIN utilisateur ON utilisateur.username = article.idAuteur 
        JOIN motarticle ON article.id = motarticle.idArticle JOIN motcle ON motcle.id = motarticle.idMotCle 
        WHERE motcle.id = $idMot GROUP BY article.id ORDER BY article.id DESC";

        $resultat = mysqli_query($connexion, $requete);

        return $resultat;
    }
    
    //Ajoute un article
    function AjoutArticle($titre, $texte, $auteur){
        
        global $connexion;
        
        $requete = "INSERT INTO article (titre, texte, idAuteur) VALUES ('" . filtre($titre) . "', '" . filtre($texte) . "', '" . filtre($auteur) . "')";

        $resultat = mysqli_query($connexion, $requete);
    }

    //Cherche tous les mots clés dans la base de données
    function GetAllMotCle(){

        global $connexion;

        $requete = "SELECT id, mot FROM motcle";
        
        $resultat = mysqli_query($connexion, $requete);

        return $resultat;
    }

    //Cherche tous les mots clés pour un article
    function GetMotCleById($idArticle){
        global $connexion;
        
        $requete = "SELECT id, mot FROM motcle JOIN motarticle ON motcle.id = motarticle.idMotCle WHERE idArticle = " . $idArticle . "";
        
        $resultat = mysqli_query($connexion, $requete);

        return $resultat;
    }

    //Cherche le dernier article enregistrer avec le max ID
    function idDernierArticle(){
        global $connexion;
        
        $requete = "SELECT MAX(id) AS id FROM article";
        
        $resultat = mysqli_query($connexion, $requete);

        return $resultat;
    }

    //Cherche mot clé par id
    function GetMotId($mot_cle){

        global $connexion;
        
        $requete = "SELECT id FROM motcle WHERE mot = '" . $mot_cle . "'";
        
        $resultat = mysqli_query($connexion, $requete);

        return $resultat;
    }

    //Funtion ajouter des mots clés et associer les mots clés avec l'article
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
        WHERE article.id = $idArticle";

        $resultat = mysqli_query($connexion, $requete);

        return $resultat;
    }
    // FX modifier l'Article selon les inputs filtrés
    function ModifNow($idArticle, $titreModif, $texteModif)
    {
        global $connexion;
        
        $requete = "UPDATE article SET titre='" . filtre($titreModif) . "', texte='" . filtre($texteModif) . "' WHERE id=" . filtre($idArticle) . "";
        $resultat = mysqli_query($connexion, $requete);
    }

    // Supprimer l'Article completement 
    function DeleteNow($idArticle)
    {
        global $connexion;
        
        $requete = "DELETE FROM article WHERE id=" . filtre($idArticle) . "";
        $resultat = mysqli_query($connexion, $requete);
    }

    // Supprimer l'article de la table motarticle (liaison motcle & article)  
    function DeleteNowLink($idArticle)
    {
        global $connexion;
        
        $requete = "DELETE FROM motarticle WHERE idArticle=" . filtre($idArticle) . "";
        $resultat = mysqli_query($connexion, $requete);
    }

    // Fonction pour supprimer tous les mots Cle qui ne se trouve pas dans la table motarticle (donc non utilisé)
    function NettoyeMotCle()
    {
        global $connexion;
        
        $requete = "DELETE FROM motcle WHERE id NOT IN (SELECT idMotCle FROM motarticle)";
        $resultat = mysqli_query($connexion, $requete);
    }

    function ValideUtilisateurArticle($username, $idArticle)
    {
        global $connexion;

        $requete = "SELECT COUNT(1) AS valide FROM article WHERE article.idAuteur = '" . $username . "' AND article.id = " . $idArticle . "";
        $resultat = mysqli_query($connexion, $requete);
        $rep = mysqli_fetch_array($resultat);

        return $rep['valide'];
    }

    
?>