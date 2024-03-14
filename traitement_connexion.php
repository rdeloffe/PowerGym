<?php
session_start();

require_once 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Préparez votre requête SQL pour vérifier les informations de connexion
    $query = "SELECT * FROM utilisateurs WHERE Email = '$email'";

    // Préparation de la requête
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['Mot_De_Passe'])) {
            $_SESSION['user_id'] = $user['Id_Utilisateur'];
            $_SESSION['email'] = $user['Email'];
            echo 'Success';
        } else {
            echo 'Mauvais mot de passe';
        }
    } else {
        echo 'Aucun utilisateur avec cet e-mail.';
    }
}
?>
