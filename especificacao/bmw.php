<?php
session_start();

if ((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true))
{
    unset($_SESSION['email']);
    unset($_SESSION['senha']);
    header('Location: login.php');
}
$logado = $_SESSION['email'];

// Conexão com o banco de dados para buscar o nome do usuário
include '../config.php';

// Função para registrar log de atividades
function registrar_log($conexao, $usuario_id, $nome_usuario, $acao, $cpf, $detalhes_adicionais = '') {
  $sql = "INSERT INTO log_atividades (usuario_id, nome_usuario, acao, cpf, detalhes_adicionais) VALUES (?, ?, ?, ?, ?)";
  $stmt = $conexao->prepare($sql);
  $stmt->bind_param('issss', $usuario_id, $nome_usuario, $acao, $cpf, $detalhes_adicionais);
  $stmt->execute();
}

// Verifica se o usuário está logado
if (isset($_SESSION['email'])) {
  $email = $_SESSION['email'];
  $sql = "SELECT * FROM usuarios WHERE email = ?";
  $stmt = $conexao->prepare($sql);
  $stmt->bind_param('s', $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
      $user = $result->fetch_assoc();

      // Registra o log de acesso à página inicial
      registrar_log($conexao, $user['id'], $user['nome'], 'Tela da BMW', $user['cpf']);
  }
} else {
  // Se o usuário não está logado, redireciona para a página de login
  header('Location: login.php');
  exit;
}

$sql = "SELECT nome FROM usuarios WHERE email = '$logado'";
$result = $conexao->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $nomeUsuario = $user['nome'];
} else {
    $nomeUsuario = 'Usuário';
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BMW - Especificações</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
    integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="bmw.css">
  <script src="alert.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>


  <header>
    <div class="logo">
      <img class="logo-img" src="../imagens/logobanzai.png">
    </div>
    <input type="checkbox" id="nav_check" hidden>
    <nav>
      <ul>
        <li>
          <a href="../index.php">Início</a>
        </li>
        <li>
          <a href="#" class="active">BMW</a>
        </li>
        <li>
          <a href="../index.php">Motos</a>
        </li>
        <li>
          <a href="../equipamentos.php">Equipamentos</a>
        </li>

        <li class="separa">
          |
        </li>
        <?php if (isset($_SESSION['email'])): ?>
        <li class="area-usuario">
          <a class="btn-usuario" href="profile.php">Olá, <?php echo htmlspecialchars($nomeUsuario); ?></a>
        </li>
        <li class="area-logout">
          <a class="btn-logout" href="../logout.php">Logout</a>
        </li>
        <?php else: ?>
        <li class="area-login">
          <a class="btn-login" href="../login.php">Login</a>
        </li>
        <li class="area-registro">
          <a class="btn-registrar" href="../register.php">Registrar</a>
        </li>
        <?php endif; ?>
      </ul>
    </nav>
    <label for="nav_check" class="hamburger">
      <div></div>
      <div></div>
      <div></div>
    </label>
  </header>

  <!--Main-->

  <main>
    <section>
      <div class="main-text">
        <h1 class="moto-nome">BMW S 1000 RR</h1><br><br>
        <h6 class="h6-home">A partir de</h6>
        <h4 class="h4-home">R$ 79.900,00</h4>
        <a href="#modal"><button class="adquira" type="submit" onclick="handlePopup(true)">Tenho
            Interesse</button><br></a>
        <div class="popup" id="popup">
          <img src="../imagens/logobanzai.png" alt="warning">

          <p class="desc">Estamos entusiasmados em oferecer a você uma experiência única de compra para adquirir sua
            próxima moto!</p>
          <p class="desc2">Venha nos visitar para saber mais sobre as opções disponíveis e como podemos tornar sua
            experiência de compra uma jornada inesquecível!</p>

          <button class="close-popup-button" type="submit" onclick="handlePopup(false)">
            Fechar
          </button>
          <button class="conc-btn" onclick="concessionaria()">
            Nos visite
          </button>
          <script> /*Encaminha pra pagina*/
            function concessionaria() {

              window.location.href = "../concessionaria/concessionaria.php";
            } 
          </script>

        </div>


        <script>
          const popup = document.getElementById('popup');

          function handlePopup(open) {
            popup.classList[open ? 'add' : 'remove']('opened');
          }
        </script>
        <a href="#especificacao"><button class="ficha-tecnica">Especificações</button></a>
        <div class="text">
          <h5>Cor do Modelo:</h5>
        </div>

        <div class="content">
          <span id="black" onclick="imgSlider('BMW ESPECIFICACAO PRETO.png'); circleChange('#092732')"></span>
          <span id="white" onclick="imgSlider('BMW ESPECIFICACAO BRANCO.png');circleChange('#e0dbd7')"></span>
          <span id="red" onclick="imgSlider('BMW ESPECIFICACAO VERMELHO.png');circleChange('#cf4f68')"></span>

        </div>
      </div>

      <div class="main-img">
        <img src="BMW ESPECIFICACAO PRETO.png" alt="Imagem da Moto" id="moto">
      </div>

    </section>


    <section class="especificacao-container" id="especificacao">

      <div id="container">
        <h1 class="titulo">Ficha Técnica</h1>
        <div class="accordion">

          <button class="accordion-header">
            <span>
              Motor
            </span>
            <i class="fa-solid fa-chevron-down arrow"></i>
          </button>

          <div class="accordion-body">
            <p>
              Tipo: Motor tetracilíndrico em linha, de quatro tempos, com arrefecimento líquido e quatro válvulas por
              cilindro.<br><br>
              Cilindrada: 999 cc<br><br>
              Potência: 210 cv à 13.750rpm <br><br>
              Torque: 113 Nm às 11.000rpm<br> <br>
              Taxa de compressão: 13,3:1<br><br>
              Carburação/gestão do motor: Injeção eletrônica, coletores de admissão variáveis <br><br>
            </p>
          </div>
        </div>

        <div class="accordion">
          <button class="accordion-header">

            <span>
              Sistema Elétrico
            </span>
            <i class="fa-solid fa-chevron-down arrow"></i>
          </button>

          <div class="accordion-body">
            <p>
              Alternador: 450 W<br><br>
              Bateria de lítio M: 12 V/5 Ah <br><br>
            </p>
          </div>
        </div>

        <div class="accordion">
          <button class="accordion-header">
            <span>
              Transmissão
            </span>
            <i class="fa-solid fa-chevron-down arrow"></i>
          </button>

          <div class="accordion-body">
            <p>
              Embreagem: Multidisco deslizante banhada a óleo<br><br>
              Transmissão: Corrente com seis marchas.<br><br>
              Transmissão secundária: Corrente 525 17/46<br><br>
              Controle de tração: Dynamic Traction Control (DTC)<br><br>
            </p>
          </div>
        </div>

        <div class="accordion">
          <button class="accordion-header">
            <span>
              Dimensões/pesos
            </span>
            <i class="fa-solid fa-chevron-down arrow"></i>
          </button>

          <div class="accordion-body">
            <p>
              Altura do banco: 832 mm<br><br>
              Distância entre eixos: 1.457 mm<br><br>
              Capacidade do depósito: 16,5 l<br><br>
              Reserva: aprox. 4 l<br><br>
              Comprimento: 2.073 mm<br><br>
              Altura: 1.205 mm<br><br>
              Largura: 740 mm<br><br>
              Peso seco: 197 kg <br><br>
            </p>
          </div>
        </div>
      </div>
      <script>
        const accordions = document.querySelectorAll('.accordion');

        accordions.forEach(accordion => {
          accordion.addEventListener('click', () => {
            const body = accordion.querySelector('.accordion-body');
            body.classList.toggle('active');
          })
        })

      </script>


    </section>





  </main>

  <footer>
    <div id="footer_content">
      <div id="footer_contacts">
        <div class="logo">
          <img class="logo-img" src="../imagens/logobanzai.png">
        </div>


        <div id="footer_social_media">
          <a href="https://www.instagram.com/banzai_motos/" target="_blank" class="footer-link" id="instagram">
            <i class="fa-brands fa-instagram"></i>
          </a>

          <a href="https://www.facebook.com/banzaimotos" target="_blank" class="footer-link" id="facebook">
            <i class="fa-brands fa-facebook-f"></i>
          </a>

          <a href="#" class="footer-link" id="whatsapp">
            <i class="fa-brands fa-whatsapp"></i>
          </a>
        </div>
      </div>

      <ul class="footer-list">
        <li>
          <h3>Saiba Mais</h3>
        </li>
        <li>
          <a href="#" class="footer-link">Modelos</a>
        </li>
        <li>
          <a href="#" class="footer-link">Contratos</a>
        </li>
        <li>
          <a href="#" class="footer-link">Contato</a>
        </li>
      </ul>

      <ul class="footer-list">
        <li>
          <h3>Saiba Mais</h3>
        </li>
        <li>
          <a href="../index.php" class="footer-link">Modelos</a>
        </li>
        <li>
          <a href="#" class="footer-link">Contratos</a>
        </li>
        <li>
          <a href="#" class="footer-link">Contato</a>
        </li>
      </ul>

      <ul class="footer-list">
        <li>
          <h3>Produtos</h3>
        </li>
        <li>
          <a href="../equipamentos.php" class="footer-link">equipamentos</a>
        </li>

      </ul>
    </div>
    </div>

    <div id="footer_copyright">
      &#169
      2024 all rights reserved
    </div>
    </div>
  </footer>
  <script type="text/javascript">

    /*Função de mudar a moto*/
    function imgSlider(e) {
      document.querySelector('#moto').src = e;
    }

  </script>
</body>

</html>