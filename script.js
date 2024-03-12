// Array of week trainings
var weekTrainings = [
  { id: 1, trainingTitle: "PEC - DOS" },
  { id: 2, trainingTitle: "JAMBES" },
  { id: 3, trainingTitle: "EPAULE - BICEPS - TRICEPS" }
];

// Attend que la page soit entièrement chargée avant d'exécuter le script
window.onload = function () {
  displayWeekTrainings();
  document
    .getElementById("inscriptionForm")
    .addEventListener("submit", function (event) {
      // Empêcher le comportement par défaut du formulaire qui est de soumettre les données
      event.preventDefault();

      // Vérification de la correspondance entre les mots de passe
      checkPasswordMatch();
    });
};

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

function displayWeekTrainings() {
  var trainingList = document.getElementById("trainings-container");

  displayWeekSummary(weekTrainings);

  weekTrainings.forEach(function (training) {
    var div = document.createElement("div");
    trainingList.appendChild(div);
    var trainingTitle = document.createElement("h1");
    trainingTitle.textContent =
      "Séance " + training.id + " : " + training.trainingTitle;
    trainingTitle.style.borderTop = "orange 2px solid";
    trainingTitle.style.borderBottom = "orange 2px solid";
    trainingTitle.style.paddingTop = "2%";
    trainingTitle.style.paddingBottom = "2%";
    trainingTitle.style.width = "100%";
    trainingTitle.style.boxSizing = "border-box";
    trainingTitle.style.textAlign = "center";
    div.appendChild(trainingTitle);
  });
}

function displayWeekSummary(trainingList) {
  var trainingListDSummaryDOM = document.getElementById(
    "week-program-summary-container"
  );

  trainingList.forEach(function (training) {
    var div = document.createElement("div");
    div.classList.add("training-summary");
    trainingListDSummaryDOM.appendChild(div);
    var h2 = document.createElement("h2");
    h2.textContent = "Séance " + training.id + " :";
    var listItem = document.createElement("h2");
    listItem.textContent = training.trainingTitle;
    listItem.style.color = "white";
    listItem.style.marginLeft = "2%";
    div.appendChild(h2);
    div.appendChild(listItem);
  });
}
