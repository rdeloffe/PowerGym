<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="connexion.css">
    <link rel="stylesheet" type="text/css" href="header.css">
    <script src="script.js"></script>
    <title>Connexion PowerGym</title>
</head>
<body>
    <!-- Barre de navigation -->
    <div class="navbar">
        <div class="logo">
            <!-- Lien autour de l'image pour rediriger vers accueil.php -->
            <a href="accueil.php">
                <img src="img/nice.png" alt="" width="50" height="50">
            </a>
        </div>
        <div class="inscription-button">
            <a href="inscription.php">Inscription</a>
        </div>
    </div>

    <!-- Zone pour mettre une image -->
    <div class="image-container">
        <img src="img/nice.png" alt="">
        <!-- Mettez votre image ici -->
    </div>

    

<div class="container">
    
    <div class="form">
        <form id="inscriptionForm" action="accueil.php" method="post">
            

            
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required>

            <input type="submit" value="Connexion" class="submit-button">
        </form>
    </div>
</div>

</body>
</html>
