<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="connexion.css">
    
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
        <form id="connexionForm" action="" method="post">
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required>

            <input type="submit" value="Connexion" class="submit-button">
            <div id="error-message" style="color: red;"></div>
        </form>
    </div>
</div>
<!-- Inclure jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Script AJAX -->
<script>
    $(document).ready(function(){
        $('#connexionForm').submit(function(e){
            e.preventDefault(); // Empêche la soumission du formulaire par défaut
            
            // Récupérer les données du formulaire
            var formData = $(this).serialize();
            
            // Envoyer une requête AJAX
            $.ajax({
                type: 'POST',
                url: 'traitement_connexion.php', // L'URL où traiter la soumission du formulaire
                data: formData,
                success: function(response){
                    if(response.trim() === "Success") {
                        window.location.href = "programme.php"; // Redirection vers programme.php
                    } else {
                        // Afficher la réponse du serveur dans #error-message
                        $('#error-message').html(response);
                    }
                }
            });
        });
    });
</script>

</body>
</html>
