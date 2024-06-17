<?php

   
session_start();

if ((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true))
{
    unset($_SESSION['email']);
    unset($_SESSION['senha']);
    header('Location: login.php');
}
$logado = $_SESSION['email'];

// Obter o tipo de usuário
include_once('config.php');
$sql = "SELECT tipo_usuario FROM usuarios WHERE email = '$logado'";
$result = $conexao->query($sql);
$user = $result->fetch_assoc();
$tipo_usuario = $user['tipo_usuario'];

// Conexão com o banco de dados para buscar o nome do usuário
include 'config.php';
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
        registrar_log($conexao, $user['id'], $user['nome'], 'Acesso à página inicial', $user['cpf']);
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
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://unpkg.com/scrollreveal"></script> <!--Scroll reveal CDN-->
  <script src="reveal.js" defer></script> <!--JS ScrollReveal-->
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
    integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="script.js"></script>
  <title>Banzai</title>
</head>

<body>

  <header>
    <div class="logo">
      <a href="index.php"><img class="logo-img" src="imagens/logobanzai.png"></a>
    </div>
    <input type="checkbox" id="nav_check" hidden>
    <nav>
      <ul>
        <li>
          <a href="index.php" class="active">Início</a>
        </li>
        <li>
          <a href="#motos">Motos</a>
        </li>
        <li>
          <a href="equipamentos.php">Equipamentos</a>
        </li>
        <?php if (isset($_SESSION['email'])): ?>
        <li class="area-usuario">
          <a class="btn-usuario" href="profile.php">Olá, <?php echo htmlspecialchars($nomeUsuario); ?></a>
          <?php if($tipo_usuario === 'usuario comum'): ?>
          <a href="suaconta.php" class="account-link">Minha Conta</a>
          <?php endif; ?>
        </li>
        <li class="area-logout">
          <a class="btn-logout" href="logout.php">Logout</a>
        </li>

        <?php else: ?>
        <li class="area-login">
          <a class="btn-login" href="login.php">Login</a>
        </li>
        <li class="area-registro">
          <a class="btn-registrar" href="register.php">Registrar</a>
        </li>
        <?php endif; ?>

        <?php if($tipo_usuario === 'usuario master'): ?>
        <li class="area-consulta">
          <a class="btn-consulta" href="dashboard/dash.html">Área Master</a>
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



  <main>

    <section class="home">

      <div class="circle"></div>

      <div class="main-text scroll-maintxt">
        <h1 class="h1-home scroll-main-h1">Bem-vindo à Banzai Motos</h1>
        <h3 class="h3-home scroll-main-h3"> o destino definitivo para entusiastas de duas rodas</h3>
        <p class="p-home scroll-main-p">Fundada com paixão e expertise, a Banzai é mais do que uma simples
          concessionária <br> é um santuário para os amantes das motocicletas.</p>

        <div class="text">
          <h5>Escolha seu modelo:</h5>
        </div>



        <div class="content">
          <img class="bmw-logo" src="modelos/bmw.png" onclick="trocarBMW()">
          <img class="honda-logo" src="modelos/honda.png" onclick="trocarHonda()">
          <img class="yamaha-logo" src="modelos/yamaha.png" onclick="trocarYamaha()">
          <img class="triumph-logo" src="modelos/triumph.png" onclick="trocarTriumph()">
        </div>
      </div>
      <div class="main-img">
        <img id="figura" src="BMWS1000RR.png" /> <!--Id:moto-->
      </div>


    </section>


    <div class="motos" id="motos">

      <div class="moto-container">
        <img class="bmw-img" src="BMWS1000RR.png"> <!--Class moto-img-->
        <h3 class="modelo-aparelho">BMW S1000 RR</h3> <!--Class moto-modelo-->
        <h4 class="preco-pix">R$ 79.900,00</h3>
          <h4 class="preco-avista"> <br> </h3> <!--Preço parcelas-->
            <a href="especificacao/bmw.php"> <button class="btn-compra">Confira</button> </a>
      </div>

      <div class="moto-container">
        <img class="honda-img" src="HONDACBR650R.png">
        <h3 class="modelo-aparelho">Honda CBR 650R</h3>
        <h4 class="preco-pix">R$ 55.900,00</h3>
          <h4 class="preco-avista"><br> </h3>
            <a href="especificacao/honda.php"> <button class="btn-compra">Confira</button> </a>
      </div>

      <div class="moto-container">
        <img class="yamaha-img" src="yamahaxmax250.png">
        <h3 class="modelo-aparelho">Yamaha X-Max 250</h3>
        <h4 class="preco-pix">R$ 27.990,00</h3>
          <h4 class="preco-avista"> <br></h3>
            <a href="especificacao/yamaha.php"> <button class="btn-compra">Confira</button> </a>
      </div>

      <div class="moto-container">
        <img class="triumph-img" src="TriumphBonnevilleT100.png">
        <h3 class="modelo-aparelho">Triumph Bonneville T100</h3>
        <h4 class="preco-pix">R$ 56.990,00</h3>
          <h4 class="preco-avista"> <br> </h3>
            <a href="especificacao/triumph.php"> <button class="btn-compra">Confira</button> </a>
      </div>

    </div> <!--Fecha div motos-->
  </main>

  <footer>
    <div id="footer_content">
      <div id="footer_contacts">
        <div class="logo">
          <img class="logo-img" src="imagens/logobanzai.png">
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
        
      </ul>

      <ul class="footer-list">
        <li>
          <h3>Produtos</h3>
        </li>
        <li>
          <a href="equipamentos.php" class="footer-link">equipamentos</a>
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