// server.js
const express = require('express');
const fetchExercises = require('./fetchExercises');
const app = express();
const port = 3000;

app.use(express.json()); // Pour traiter le corps des requêtes JSON
app.use(express.static('.'));

// Exemple d'endpoint pour générer et récupérer le programme d'entraînement
app.post('/generate-program', async (req, res) => {
  const { objectif, seances } = req.body; // Assurez-vous de valider et nettoyer les entrées dans une application réelle
  let filters = {};

  switch (objectif) {
    case 'prise_muscle':
      filters.type = 'strength';
      break;
    case 'perte_poids':
      filters.type = 'cardio';
      break;
    case 'maintien_musculaire':
      filters.type = 'strength'; // Vous pouvez ajuster cette logique
      break;
    default:
      return res.status(400).send('Objectif non valide');
  }

  try {
    const exercises = await fetchExercises(filters);
    // Simulez la sélection des exercices en fonction du nombre de séances
    // Cette partie doit être développée davantage pour un programme réel
    const selectedExercises = exercises.slice(0, seances);
    res.json(selectedExercises);
  } catch (error) {
    console.error("Erreur lors de la génération du programme : ", error);
    res.status(500).send('Erreur serveur');
  }
});

app.listen(port, () => {
  console.log(`Serveur démarré sur http://localhost:${port}`);
});
