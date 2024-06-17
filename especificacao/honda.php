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
        registrar_log($conexao, $user['id'], $user['nome'], 'Tela da Honda', $user['cpf']);
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
    <title>HONDA - Especificações</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="honda.css">
    <script src="honda.js"></script>
    <link href='https://unpkg.com/css.gg@2.0.0/icons/css/sync.css' rel='stylesheet'>
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
                    <a href="#" class="active">Honda</a>
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
                <h1 class="moto-nome">Honda CBR 650R</h1><br><br>
                <h6 class="h6-home">A partir de</h6>
                <h4 class="h4-home">R$ 55.900,00</h4>
                <a href="#modal"><button class="adquira" type="submit" onclick="handlePopup(true)">Tenho
                        Interesse</button><br></a>
                <div class="popup" id="popup">
                    <img src="../imagens/logobanzai.png" alt="warning">

                    <p class="desc">Estamos entusiasmados em oferecer a você uma experiência única de compra para
                        adquirir sua
                        próxima moto!</p>
                    <p class="desc2">Venha nos visitar para saber mais sobre as opções disponíveis e como podemos tornar
                        sua
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
                    <span id="gray"
                        onclick="imgSlider('HONDA ESPECIFICACAO CINZA.png'); circleChange('#092732')"></span>


                </div>
            </div>

            <div class="main-img">
                <img src="HONDA ESPECIFICACAO CINZA.png" alt="Imagem da Moto" id="moto">
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
                            Tipo: DOHC, quatro cilindros 4 tempos, arrefecimento líquido<br><br>
                            Cilindrada: 649 cc<br><br>
                            Potência Máxima: 88,4 CV a 11500 rpm<br><br>
                            Torque Máximo: 6,13 kgf.m a 8000 rpm<br><br>
                            Transmissão: 6 velocidades<br><br>
                            Sistema de Partida: Elétrica<br><br>
                            Diâmetro x Curso: 67,0 x 46,0 mm<br><br>
                            Relação de Compressão: 11.6 : 1<br><br>
                            Sistema Alimentação: Injeção Eletrônica PGM-FI<br><br>
                            Combustível: Gasolina<br><br>
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
                            Ignição: Eletrônic<br><br>
                            Bateria: 12V - 8.6 Ah<br><br>
                            Farol: Full LED<br><br>
                        </p>
                    </div>
                </div>

                <div class="accordion">
                    <button class="accordion-header">
                        <span>
                            Capacidade
                        </span>
                        <i class="fa-solid fa-chevron-down arrow"></i>
                    </button>

                    <div class="accordion-body">
                        <p>
                            Tanque de Combustível: 15,4 litros<br><br>
                            Óleo do Motor: 3,0 litros<br><br>
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
                            Comprimento x Largura x Altura: 2128 x 749 x 1149 mm<br><br>
                            Distância entre eixos: 1.449 mm<br><br>
                            Distância mínima do solo: 132 mm<br><br>
                            Altura do assento: 810 mm<br><br>
                            Peso Seco: 196 kg<br><br>
                        </p>
                    </div>
                </div>

                <div class="accordion">
                    <button class="accordion-header">
                        <span>
                            Chassi
                        </span>
                        <i class="fa-solid fa-chevron-down arrow"></i>
                    </button>

                    <div class="accordion-body">
                        <p>
                            Tipo: Diamond Frame<br><br>
                            Suspensão Dianteira/Curso: Garfo telescópico / 120 mm<br><br>
                            Suspensão Traseira/Curso: Mono-Shock / 128 mm<br><br>
                            Freio Dianteiro/Diâmetro: A disco / 310 mm (ABS)<br><br>
                            Freio Traseiro/Diâmetro: A disco / 240 mm (ABS)<br><br>
                            Pneu Dianteiro: 120/70 - 17<br><br>
                            Pneu Traseiro: 180/55 - 17
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

            <script type="text/javascript">

                /*Função de mudar a moto*/
                function imgSlider(e) {
                    document.querySelector('#moto').src = e;
                }

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
                    <a href="https://www.instagram.com/banzai_motos/" target="_blank" class="footer-link"
                        id="instagram">
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
                    <h3>Produtos</h3>
                </li>
                <li>
                    <a href="../equipamentos.php" class="footer-link">equipamentos</a>
                </li>

            </ul>


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