document.addEventListener('DOMContentLoaded', () => {
    const programmeData = JSON.parse(localStorage.getItem('programmeData'));
    const programmeContainer = document.getElementById('programmeContainer');

    if (programmeData && programmeData.length > 0) {
        programmeData.forEach(exercise => {
            const exerciseElement = document.createElement('div');
            exerciseElement.classList.add('exercise'); // Pour le style, si nécessaire
            exerciseElement.innerHTML = `
                <h3>${exercise.name}</h3>
                <p>Type: ${exercise.type}</p>
                <p>Muscle(s) ciblé(s): ${exercise.muscle}</p>
                <p>Difficulté: ${exercise.difficulty}</p>
            `;
            programmeContainer.appendChild(exerciseElement);
        });
    } else {
        programmeContainer.innerHTML = '<p>Aucun programme d\'entraînement trouvé. Veuillez retourner à la page d\'inscription et soumettre à nouveau vos informations.</p>';
    }
});
