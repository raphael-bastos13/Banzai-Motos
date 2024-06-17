const questions = [
  "Qual o nome da sua mãe?",
  "Qual a data do seu nascimento?",
  "Qual o CEP do seu endereço?"
];

function generateRandomQuestion() {
  const randomIndex = Math.floor(Math.random() * questions.length);
  const questionElement = document.getElementById('question');
  questionElement.textContent = questions[randomIndex];
}

// Gerar uma pergunta aleatória ao carregar a página
window.onload = generateRandomQuestion;
