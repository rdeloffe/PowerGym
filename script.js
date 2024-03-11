// Attend que la page soit entièrement chargée avant d'exécuter le script
window.onload = function() {
    document.getElementById("inscriptionForm").addEventListener("submit", function(event) {
        // Empêcher le comportement par défaut du formulaire qui est de soumettre les données
        event.preventDefault();

        // Vérification de la correspondance entre les mots de passe
        checkPasswordMatch();
    });
}

function checkPasswordMatch() {
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("confirmPassword").value;
    var passwordMatchError = document.getElementById("passwordMatchError");
    
    if (password !== confirmPassword) {
        passwordMatchError.textContent = "Les mots de passe ne correspondent pas.";
    } else {
        // Si les mots de passe correspondent, soumettre le formulaire
        document.getElementById("inscriptionForm").submit();
    }
}
