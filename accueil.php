<?php
require_once 'includes/config.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (verificationEmail($conn)) {
        insererUtilisateur($conn);
    } else {
        echo 'Email déja utilisé.';
    }
}

function verificationEmail($conn)
{
    $email = $_POST['email'];
    $query = "SELECT * FROM utilisateurs WHERE Email='$email'";

    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return false;
    } else {
        return true;
    }
}

function insererUtilisateur($conn)
{
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Pas besoin d'échapper après le hachage
    $nom = mysqli_real_escape_string($conn, strip_tags($_POST['nom']));
    $prenom = mysqli_real_escape_string($conn, strip_tags($_POST['prenom']));
    $age = mysqli_real_escape_string($conn, strip_tags($_POST['identite-age']));
    $taille = mysqli_real_escape_string($conn, strip_tags($_POST['identite-taille']));
    $poids = mysqli_real_escape_string($conn, strip_tags($_POST['identite-poids']));
    $seances = mysqli_real_escape_string($conn, strip_tags($_POST['seances']));
    $sql = "INSERT INTO utilisateurs (Role, Email,Mot_De_Passe,Nom,Prenom,Age,Sexe,Taille,Poids,Programme_id,Nombre_Seances_Semaine)
            VALUES (1,'$email','$password','$nom','$prenom','$age','M','$taille','$poids',1,'$seances')";
    if ($conn->query($sql) === true) {
        echo 'Nouvel enregistrement créé avec succès';
    } else {
        echo 'Erreur : ' . $sql . '<br>' . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="accueil.css">
    <link rel="stylesheet" type="text/css" href="header.css">
    <title>Nouvelle Page</title>
</head>

<body>
    <!-- Barre de navigation -->
    <div class="navbar">
        <div class="titrenav">
            <a href="accueil.php" style="text-decoration: none; color: white;">
                <p>POWERGYM</p>
            </a>
        </div>

        <div class="inscription-button">
            <a href="connexion.php">Connexion</a>
        </div>

        <div class="inscription-button">
            <a href="inscription.php">Inscription</a>
        </div>
    </div>


    <div class="accueil-container">
        <!-- Zone pour mettre une image -->
        <div class="image-container">
            <img src="img/nice.png" alt="">
            <!-- Mettez votre image ici -->
        </div>

        <div class="presentation">
            <p>Présentation du concept</p>
        </div>

        <!-- Zone de texte -->
        <div class="text-container">
            <p>
                Bienvenue sur notre Site de Génération de Programmes de Musculation Personnalisés
                <br>
                <br>
                Objectif : Notre site vous permet de créer des programmes de musculation adaptés à vos besoins uniques et à votre niveau de forme physique.
                <br>
                <br>
                Comment ça fonctionne :
                <br>
                <br>
                Remplissez un formulaire avec vos informations personnelles et vos objectifs de musculation.
                Notre algorithme avancé génère un programme de musculation sur mesure en fonction de vos données.
                Visualisez votre programme personnalisé et commencez votre entraînement dès aujourd'hui !
                Avantages :
                <br>
                <br>
                Personnalisation : Des programmes sur mesure pour atteindre vos objectifs spécifiques.
                <br>
                <br>
                Accessibilité : Adapté à tous les niveaux de forme physique, du débutant à l'athlète confirmé.
                <br>
                <br>
                Suivi de progression : Suivez vos progrès et ajustez votre programme en conséquence pour des résultats durables.
                <br>
                <br>
                Commencez dès maintenant votre parcours vers une meilleure forme physique avec notre générateur de programmes de musculation personnalisés !
            </p>
        </div>
        <br>
        <br>
        <br>
    </div>
</body>

</html>