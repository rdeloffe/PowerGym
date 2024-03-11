// Attend que la page soit entièrement chargée avant d'exécuter le script
window.onload = function() {
    document.getElementById("inscriptionForm").addEventListener("submit", function(event) {
        // Empêcher le comportement par défaut du formulaire qui est de soumettre les données
        event.preventDefault();

        // Récupération des valeurs des mots de passe
        var password = document.getElementById("password").value;
        var confirmPassword = document.getElementById("confirmPassword").value;
        
        // Vérification de la correspondance entre les mots de passe
        if (password !== confirmPassword) {
            // Afficher un message d'erreur si les mots de passe ne correspondent pas
            alert("Les mots de passe ne correspondent pas !");
        } else {
            // Redirection vers la page acceuil.html après la soumission du formulaire
            window.location.href = "acceuil.html";
        }
    });
}
