<?php
require_once 'includes/config.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (verificationEmail($conn)) {
        insererUtilisateur($conn);
        $joursTires = tirageJours($_POST['seances']);
        echo $joursTires;
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
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $age = $_POST['identite-age'];
    $taille = $_POST['identite-taille'];
    $poids = $_POST['identite-poids'];
    $programme = $_POST['objectif'];
    $seances = $_POST['seances'];
    $sql = "INSERT INTO utilisateurs (Role, Email,Mot_De_Passe,Nom,Prenom,Age,Sexe,Taille,Poids,Programme_id,Nombre_Seances_Semaine)
            VALUES (1,'$email','$password','$nom','$prenom','$age','M','$taille','$poids',$programme,'$seances')";
    if ($conn->query($sql) === true) {
        echo 'Nouvel enregistrement créé avec succès';
    } else {
        echo 'Erreur : ' . $sql . '<br>' . $conn->error;
    }
}

function tirageJours($nombreJours)
{
    $joursSemaine = [
        'lundi',
        'mardi',
        'mercredi',
        'jeudi',
        'vendredi',
        'samedi',
        'dimanche',
    ];
    $joursTires = [];

    // Tant que le nombre de jours tirés n'est pas atteint
    while (count($joursTires) < $nombreJours && !empty($joursSemaine)) {
        // Choix d'un jour aléatoire
        $jour = $joursSemaine[array_rand($joursSemaine)]; // Utilisation de array_rand pour obtenir un indice aléatoire

        if ($nombreJours <= 3) {
            // Vérification si le jour est déjà sélectionné
            if (!in_array($jour, $joursTires)) {
                // Vérification de l'écart avec les jours déjà tirés
                $ecartValide = true;
                foreach ($joursTires as $jourTire) {
                    if (
                        abs(
                            array_search($jour, $joursSemaine) -
                                array_search($jourTire, $joursSemaine)
                        ) <= 1
                    ) {
                        $ecartValide = false;
                        break;
                    }
                }

                // Si l'écart est valide, ajouter le jour dans la liste des jours tirés
                if ($ecartValide) {
                    $joursTires[] = $jour;
                }
            }
        } else {
            // Retirer le jour de la liste des jours disponibles
            $joursSemaine = array_diff($joursSemaine, [$jour]);
            $joursTires[] = $jour;
        }
    }

    return $joursTires;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="accueil.css">
    <title>Nouvelle Page</title>
</head>
<body>
    <!-- Barre de navigation -->
    <div class="navbar">
        <div class="inscription-button">
            <a href="inscription.php">Inscription</a>
            <a href="connexion.php">Connexion</a>
        </div>
    </div>

    <!-- Zone pour mettre une image -->
    <div class="image-container">
        <img src="img/nice.png" alt="">
        <!-- Mettez votre image ici -->
    </div>

    <div class="presentation">
        <h3>Présentation du concept</h3>
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
            Commencez dès maintenant votre parcours vers une meilleure forme physique avec notre générateur de programmes de musculation personnalisés !        </p>
    </div>
    <br>
    <br>
    <br>
</body>
</html>
