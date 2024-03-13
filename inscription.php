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
        <div class="form" id="part1">
            <form id="inscriptionForm" action="accueil.php" method="post">
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

                <input type="button" value="Suivant" class="submit-button" onclick="verifyPassword()">
            </form>
        </div>
        <div class="form" id="part2" style="display: none;">
            <form id="inscriptionForm2" action="accueil.php" method="post">
                <label for="identite-age">Âge :</label>
                <input type="number" id="identite-age" name="identite-age" required>

                <label for="identite-taille">Taille (en cm) :</label>
                <input type="number" id="identite-taille" name="identite-taille" required>

                <label for="identite-poids">Poids (en kg) :</label>
                <input type="number" id="identite-poids" name="identite-poids" required>

                <label for="objectif">Objectif du programme :</label>
                <select id="objectif" name="objectif" required>
                    <option value="perte_poids">Perte de poids</option>
                    <option value="prise_muscle">Prise de muscle</option>
                    <option value="maintien_muscle">Maintien musculaire</option>
                </select>

                <label for="seances">Nombre de séances par semaine souhaitées (maximum 7) :</label>
                <input type="number" id="seances" name="seances" min="1" max="7" required>

                <input type="submit" value="Finaliser l'inscription" class="submit-button">
            </form>
        </div>
    </div>

    <div id="formData"></div>

    <script>
        // Fonction pour vérifier si tous les champs du premier formulaire sont remplis
        function checkFormFields() {
            var nom = document.getElementById("nom").value;
            var prenom = document.getElementById("prenom").value;
            var email = document.getElementById("email").value;
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirmPassword").value;
            var passwordMatchError = document.getElementById("passwordMatchError");

            if (nom === "" || prenom === "" || email === "" || password === "" || confirmPassword === "") {
                passwordMatchError.textContent = "Veuillez remplir tous les champs du formulaire.";
                return false; // Retourne false si un champ est vide
            } else {
                passwordMatchError.textContent = ""; // Efface le message d'erreur s'il n'y a pas de champ vide
                return true; // Retourne true si tous les champs sont remplis
            }
        }

        // Fonction pour afficher la deuxième partie du formulaire
        function showPart2() {
            document.getElementById("part1").style.display = "none";
            document.getElementById("part2").style.display = "block";
        }

        // Fonction pour vérifier si les mots de passe correspondent
        function verifyPassword() {
            if (checkFormFields()) {
                var password = document.getElementById("password").value;
                var confirmPassword = document.getElementById("confirmPassword").value;
                var passwordMatchError = document.getElementById("passwordMatchError");

                if (password !== confirmPassword) {
                    passwordMatchError.textContent = "Les mots de passe ne correspondent pas.";
                } else {
                    showPart2();
                }
            }
        }

        // Fonction pour récupérer les valeurs du formulaire et les afficher
        function showFormData() {
            var nom = document.getElementById("nom").value;
            var prenom = document.getElementById("prenom").value;
            var email = document.getElementById("email").value;
            var identiteAge = document.getElementById("identite-age").value;
            var identiteTaille = document.getElementById("identite-taille").value;
            var identitePoids = document.getElementById("identite-poids").value;
            var objectif = document.getElementById("objectif").value;
            var seances = document.getElementById("seances").value;

            // Affichage des informations dans la page
            var formDataContainer = document.getElementById("formData");
            formDataContainer.innerHTML = "<h2>Informations de l'utilisateur :</h2>" +
                "<p><strong>Nom :</strong> " + nom + "</p>" +
                "<p><strong>Prénom :</strong> " + prenom + "</p>" +
                "<p><strong>Email :</strong> " + email + "</p>" +
                "<p><strong>Âge :</strong> " + identiteAge + "</p>" +
                "<p><strong>Taille :</strong> " + identiteTaille + " cm</p>" +
                "<p><strong>Poids :</strong> " + identitePoids + " kg</p>" +
                "<p><strong>Objectif du programme :</strong> " + objectif + "</p>" +
                "<p><strong>Nombre de séances par semaine :</strong> " + seances + "</p>";
        }

        window.onload = function() {
            document.getElementById("inscriptionForm2").addEventListener("submit", function(event) {
                // Empêcher le comportement par défaut du formulaire qui est de soumettre les données
                event.preventDefault();

                // Appel de la fonction pour afficher les informations du formulaire
                showFormData();
            });
        }
    </script>

</body>
</html>
