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

// Par exemple, afficher l'identifiant de l'utilisateur
echo "Identifiant de l'utilisateur : " . $user_id;
echo '<br>Vous êtes connecté en tant que : ' . $email;
?>
