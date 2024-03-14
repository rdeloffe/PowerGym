<?php
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
