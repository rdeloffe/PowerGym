// fetchExercises.js
const axios = require('axios');

const API_KEY = '+kYL0cIU4TMlE6EjFycgmg==SQPdveZBxTAlAoqQ';
const apiUrl = 'https://api.api-ninjas.com/v1/exercises';

async function fetchExercises(filters = {}) {
  const params = new URLSearchParams(filters);
  try {
    const response = await axios.get(`${apiUrl}?${params}`, {
      headers: {
        'X-Api-Key': API_KEY
      }
    });
    return response.data;
  } catch (error) {
    console.error("Erreur lors de la récupération des données de l'API : ", error);
    return [];
  }
}

module.exports = fetchExercises;
