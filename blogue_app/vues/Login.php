<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>
<body>
    <form method="post" action="index.php">
        <label>Nom d'utilisateur :</label>
        <input type="text" name="username">
        <label>Mot de passe :</label>
        <input type="text" name="password">
        <input type="hidden" name="action" value="Verifier">
        <input type="submit" value="Connexion">
    </form>
</body>
</html>