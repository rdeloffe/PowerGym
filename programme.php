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
            echo "Programme correspondant trouvé : " . $rowProgramme['nom'];
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

// Par exemple, afficher l'identifiant de l'utilisateur
echo "Identifiant de l'utilisateur : " . $user_id;
echo '<br>Vous êtes connecté en tant que : ' . $email;
?>
