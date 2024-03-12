window.onload = function() {
document.getElementById("inscriptionForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Empêcher le comportement par défaut du formulaire qui est de soumettre les données

    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("confirmPassword").value;
    var passwordMatchError = document.getElementById("passwordMatchError");

    if (password !== confirmPassword) {
        passwordMatchError.textContent = "Les mots de passe ne correspondent pas.";
    } else {
        passwordMatchError.textContent = ""; // Effacer l'erreur si les mots de passe correspondent

   
        var formData = {
            nom: document.getElementById("nom").value,
            prenom: document.getElementById("prenom").value,
            email: document.getElementById("email").value,
            age: parseInt(document.getElementById("identite-age").value, 10),
            taille: parseInt(document.getElementById("identite-taille").value, 10),
            poids: parseInt(document.getElementById("identite-poids").value, 10),
            objectif: document.getElementById("objectif").value,
            seances: parseInt(document.getElementById("seances").value, 10),
        };

        generateProgram(formData); // Envoyer les données pour générer le programme
    }
});

function generateProgram(formData) {
    fetch('/generate-program', { // Ajustez cet URL selon votre configuration serveur
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(formData),
    })
    .then(response => response.json())
    .then(data => {
        // Redirection vers une nouvelle page avec le programme généré
        // Supposons que vous ayez une page 'programme.html' pour afficher les résultats
        // Vous pouvez passer les données du programme via localStorage, par exemple
        localStorage.setItem('programmeData', JSON.stringify(data));
        window.location.href = 'programme.html'; // Rediriger vers la page du programme
    })
    .catch(error => {
        console.error('Erreur lors de la génération du programme:', error);
    });
}

}