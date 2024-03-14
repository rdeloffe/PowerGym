<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre Programme Sportif</title>
    <link rel="stylesheet" type="text/css" href="programme.css">
    <link rel="stylesheet" type="text/css" href="header.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #9E9E9E;
        }
        .programme {
            margin-top: 40px;
            margin-bottom: 20px;
            margin-left: 3%;
            margin-right: 3%;
        }

        h2, h1 {
            color: orange;
        }
        .seance {
            background-color: #9E9E9E;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        .exercice {
            margin-left: 20px;
        }
    </style>
</head>
<body>
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
    $email = mysqli_real_escape_string($conn, $_POST['email']);
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
    $taille = mysqli_real_escape_string(
        $conn,
        strip_tags($_POST['identite-taille'])
    );
    $poids = mysqli_real_escape_string(
        $conn,
        strip_tags($_POST['identite-poids'])
    );
    $objectif = mysqli_real_escape_string(
        $conn,
        strip_tags($_POST['objectif'])
    );
    $seances = mysqli_real_escape_string($conn, strip_tags($_POST['seances']));
    $sql = "INSERT INTO utilisateurs (Role, Email,Mot_De_Passe,Nom,Prenom,Age,Sexe,Taille,Poids,Programme_id,Nombre_Seances_Semaine)
            VALUES (1,'$email','$password','$nom','$prenom','$age','M','$taille','$poids',$objectif,'$seances')";
    if ($conn->query($sql) === true) {
        echo 'Nouvel enregistrement créé avec succès';
    } else {
        echo 'Erreur : ' . $sql . '<br>' . $conn->error;
    }
}

session_start();

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
    header('Location: connexion.php');
    exit();
}

// Maintenant, vous pouvez utiliser $_SESSION['user_id'] comme vous le souhaitez dans cette page

$user_id = $_SESSION['user_id'];
$email = $_SESSION['email'];


// Préparer la requête SQL pour récupérer le Programme_id et Nombre_Seances_Semaine
$query = "SELECT Programme_id, Nombre_Seances_Semaine FROM utilisateurs WHERE Id_Utilisateur = ?";

if ($stmt = $conn->prepare($query)) {
    // Lier le paramètre id de l'utilisateur avec le placeholder
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($programme_id, $nombre_seances_semaine);
    $stmt->fetch();
    $stmt->close();

    // Préparer la requête SQL pour récupérer le programme adéquat
    $queryProgramme = "SELECT * FROM liste_programme WHERE type = ? AND nb_jours = ?";
    
    if ($stmtProgramme = $conn->prepare($queryProgramme)) {
        // Lier les paramètres Programme_id et Nombre_Seances_Semaine avec les placeholders
        $stmtProgramme->bind_param("ii", $programme_id, $nombre_seances_semaine);
        $stmtProgramme->execute();
        $resultProgramme = $stmtProgramme->get_result();
        
        if ($rowProgramme = $resultProgramme->fetch_assoc()) {
            // Maintenant, $rowProgramme contient les informations du programme correspondant
            // Vous pouvez utiliser ces informations pour les afficher à l'utilisateur ou pour d'autres traitements
        
            echo "<div class='programme'>";
            $type = "";
            if ($rowProgramme['type'] == 1) {
                $type = "Perte de poids";
            } elseif ($rowProgramme['type'] == 2) {
                $type = "Prise de muscle";
                echo "<h1>Programme de prise de muscle</h1>";
            } elseif ($rowProgramme['type'] == 3) {
                $type = "Maintien musculaire";
            }
            echo "<h1 class='program-title' style='margin-top: 7%;'>Programme : " . $type . " pour ".  $rowProgramme['nb_jours'] ." jours </h1>";

             // ID du programme trouvé"
             $idProgrammeTrouve = $rowProgramme['id_programme'];

            // Préparer la requête SQL pour récupérer les séances associées à ce programme
            $querySeances = "SELECT * FROM seance WHERE id_programme = ?";
            
    if ($stmtSeances = $conn->prepare($querySeances)) {
        // Lier le paramètre id_programme avec le placeholder
        $stmtSeances->bind_param("i", $idProgrammeTrouve);
        $stmtSeances->execute();
        $resultSeances = $stmtSeances->get_result();
        
        // Vérifier s'il y a des séances associées
        if ($resultSeances->num_rows > 0) {
            // Récupérer et traiter chaque séance   
            while ($rowSeance = $resultSeances->fetch_assoc()) {
                echo "<div class='seance'>";
                echo "<h2>Séance : " . $rowSeance['nom'] . "</h2>";
                // Vous pouvez ici récupérer d'autres détails de la séance
                // ID de la séance actuelle
                $idSeanceActuelle = $rowSeance['id_seance'];

                // Préparer la requête SQL pour récupérer les exercices de cette séance
                $queryExercices = "SELECT * FROM seance_exo WHERE id_seance = ?";

                if ($stmtExercices = $conn->prepare($queryExercices)) {
                    // Lier le paramètre id_seance avec le placeholder
                    $stmtExercices->bind_param("i", $idSeanceActuelle);
                    $stmtExercices->execute();
                    $resultExercices = $stmtExercices->get_result();

                    // Vérifier s'il y a des exercices associés
                    if ($resultExercices->num_rows > 0) {
                        // Récupérer et traiter chaque exercice
                        while ($rowExercice = $resultExercices->fetch_assoc()) {
                            // Vous pouvez ici récupérer d'autres détails de l'
                            // rechercher les exercices en fonction de l'id_exercice
                            $idExerciceActuel = $rowExercice['id_exercice'];
                            $queryExercice = "SELECT * FROM exercices WHERE id= ?";
                            if ($stmtExercice = $conn->prepare($queryExercice)) {
                                $stmtExercice->bind_param("i", $idExerciceActuel);
                                $stmtExercice->execute();
                                $resultExercice = $stmtExercice->get_result();
                                if ($rowExercice = $resultExercice->fetch_assoc()) {
                                    echo "<div class='exercice'>";
                                    echo "<p>Exercice : " . $rowExercice['nom'] . "</p>";
                                    echo "<p>Nombre de séries : " . $rowExercice['nombre_series'] . "</p>";
                                    echo "<p>Nombre de répétitions : " . $rowExercice['nombre_repetitions'] . "</p>";
                                    echo "<p>Description : " . $rowExercice['description'] . "</p>"; // Fin div exercice
                                    echo "</div>"; // Fin div exercice
                                    echo "<br>";
                                }
                                $stmtExercice->close();
                            } else {
                                echo "Erreur de préparation : " . $conn->error;
                            }
                        }
                    } else {
                        echo "Aucun exercice trouvé pour cette séance.";
                    }

                    $stmtExercices->close();
                } else {
                    echo "Erreur de préparation : " . $conn->error;
                }
        
            }
        } else {
            echo "Aucune séance trouvée pour ce programme.";
        }

        $stmtSeances->close();
    } else {
        echo "Erreur de préparation : " . $conn->error;
    }

        } else {
            echo "Aucun programme correspondant trouvé.";
        }
        
        $stmtProgramme->close();
    } else {
        echo "Erreur de préparation : " . $conn->error;
    }
    
} else {
    echo "Erreur de préparation : " . $conn->error;
}


// Fermer la connexion à la base de données
$conn->close();

?>

</body>
</html>