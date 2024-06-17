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
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="concessionaria.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
    integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>concessionária </title>
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
          <a href="../index.php">Motos</a>
        </li>
        <li>
          <a href="../equipamentos.php" class="">Equipamentos</a>
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


  <h1 class="h1-conce">Ambiente Banzai </h1>

  <section class="concessionaria">
    <div class="card-conc">
      <img class="img-conc" src="img2/conce-6.jpg">
    </div>
    <div class="card-conc">
      <img class="img-conc" src="img2/conce-2.png">
    </div>
    <div class="card-conc">
      <img class="img-conc" src="img2/conce-3.png">
    </div>
    <div class="card-conc">
      <img class="img-conc" src="img2/conce-1.png">
    </div>
    <div class="card-conc">
      <img class="img-conc" src="img2/conce-5.jpg">
    </div>
  </section>

  <div class="localizacao">
    <img class="img-local" src="img2/localizacao.png">
    <p class="endereco">Estrada Benvindo de Novaes, 1825 - Recreio dos Bandeirantes, Rio de Janeiro - RJ, 22790-381</p>
  </div>

  <h1 class="h1-clientes">Nossos clientes</h1>


  <section class="cards">
    <div class="card">
      <img class="usuario" src="img2/usuario.png">
      <h3>Cliente 1</h3>
      <div class="estrelas">
        <img class="estrela" src="img2/star.svg">
        <img class="estrela" src="img2/star.svg">
        <img class="estrela" src="img2/star.svg">
        <img class="estrela" src="img2/star.svg">
        <img class="estrela" src="img2/star.svg">
      </div>

      <p>"A moto chegou em perfeito estado e estou extremamente satisfeito com a qualidade. Recomendo a Banzai Motos
        para todos os meus amigos!"</p>

    </div>


    <div class="card">
      <img class="usuario" src="img2/usuario.png">
      <h3>Cliente 2</h3>
      <div class="estrelas">
        <img class="estrela" src="img2/star.svg">
        <img class="estrela" src="img2/star.svg">
        <img class="estrela" src="img2/star.svg">
        <img class="estrela" src="img2/star.svg">
        <img class="estrela" src="img2/star.svg">
      </div>

      <p>"Recentemente comprei um novo modelo e estou apaixonado pela performance e pelo conforto."</p>

    </div>


    <div class="card">
      <img class="usuario" src="img2/usuario.png">
      <h3>Cliente 3</h3>
      <div class="estrelas">
        <img class="estrela" src="img2/star.svg">
        <img class="estrela" src="img2/star.svg">
        <img class="estrela" src="img2/star.svg">
        <img class="estrela" src="img2/star.svg">
        <img class="estrela" src="img2/star.svg">
      </div>

      <p>"Comprei minha moto e o processo foi rápido e sem complicações."</p>

    </div>
  </section>

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
          <a href="../index.php" class="footer-link">Modelos</a>
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

      <div id="footer_subscribe">
        <h3>Entre em contato</h3>

        <p>
          Digite seu email para receber nossas novidades
        </p>

        <div id="input_group">
          <input type="email" id="email">
          <button>
            <i class="fa-regular fa-envelope"></i>
          </button>
        </div>
      </div>
    </div>

    <div id="footer_copyright">
      &#169
      2024 all rights reserved
    </div>
    </div>
  </footer>



</body>

</html>