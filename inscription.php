<?php
require_once 'includes/config.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="inscription.css">
    <link rel="stylesheet" type="text/css" href="header.css">
    <script src="script.js"></script>
    <title>Inscription PowerGym</title>
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
            <a href="connexion.php">Connexion</a>
        </div>
    </div>
    
    <!-- Zone pour mettre une image -->
    <div class="image-container">
        <img src="img/nice.png" alt="">
        <!-- Mettez votre image ici -->
    </div>

    <div class="container">
        <div class="form">
            <form id="inscriptionForm" action="programme.php" method="post">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" required>

            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" required>

            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required>

            <label for="confirmPassword">Confirmation du mot de passe :</label>
            <input type="password" id="confirmPassword" name="confirmPassword" required>

            <!-- Affichage de l'erreur -->
            <div id="passwordMatchError" style="color: red;"></div>

            <label for="identite-age">Âge :</label>
            <input type="number" id="identite-age" name="identite-age" required>

            <label for="identite-taille">Taille (en cm) :</label>
            <input type="number" id="identite-taille" name="identite-taille" required>

            <label for="identite-poids">Poids (en kg) :</label>
            <input type="number" id="identite-poids" name="identite-poids" required>

            <label for="objectif">Objectif du programme :</label>
            <select id="objectif" name="objectif" required>
                <option value="1">Perte de poids</option>
                <option value="2">Prise de muscle</option>
                <option value="3">Maintien musculaire</option>
            </select>

            <label for="seances">Nombre de séances par semaine souhaitées (maximum 7) :</label>
            <input type="number" id="seances" name="seances" min="1" max="7" required>

            <input type="submit" value="Finaliser l'inscription" class="submit-button">
        </form>
    </div>
</div>

</body>
</html>
