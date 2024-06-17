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
        registrar_log($conexao, $user['id'], $user['nome'], 'Tela da Triumph', $user['cpf']);
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
    <title>TRIMPH- Especificações</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="triumph.css">
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
                    <a href="#" class="active">Triumph</a>
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
                <h1 class="moto-nome">Triumph Bonneville T100</h1><br><br>
                <h6 class="h6-home">A partir de</h6>
                <h4 class="h4-home">R$ 56.990,00</h4>
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
                    <span id="black" onclick="imgSlider('Triumph preto.png'); circleChange('#092732')"></span>
                    <span id="blue" onclick="imgSlider('Triumph azul.png');circleChange('#cf4f68')"></span>



                </div>
            </div>

            <div class="main-img">
                <img src="Triumph preto.png" alt="Imagem da Moto" id="moto">
            </div>

        </section>


        <section class="especificacao-container" id="especificacao">

            <div id="container">
                <h1 class="titulo">Ficha Técnica</h1>
                <div class="accordion">

                    <button class="accordion-header">
                        <span>
                            Motor e transmissão
                        </span>
                        <i class="fa-solid fa-chevron-down arrow"></i>
                    </button>

                    <div class="accordion-body">
                        <p>
                            Tipo: Resfriamento líquido, 8 válvulas, SOHC, ângulo de 270° da manivela com 2 cilindros
                            paralelos<br><br>
                            Cilindrada: 900 cc<br><br>
                            Diâmetro: 84.6 mm<br><br>
                            Curso: 80 mm<br><br>
                            Compressão: 11.0:1<br><br>
                            Potência Máx: 65 CV (47.8 kW) @ 7.400 rpm<br><br>
                            Torque Máx: 80 Nm @ 3.750 rpm<br><br>
                            Alimentação: Injeção eletrônica de combustível sequencial multiponto<br><br>
                            Exaustão: Sistema de escape de aço inoxidável escovado 2 em 2 com silenciadores
                            duplos<br><br>
                            Transmissão final: Corrente<br><br>
                            Embreagem: Discos múltiplos, banhados em óleo com embreagem auxiliar de torque<br><br>
                            Caixa de câmbio: 5 velocidades<br><br>
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
                            Quadro: Aço tubular, estrutura de berço duplo<br><br>
                            Braço oscilante: Fabricação de dupla face<br><br>
                            Roda dianteira: 32 raios 18 x 2,75 polegadas<br><br>
                            Roda traseira: 32 raios 17 x 4,25 polegadas<br><br>
                            Pneu dianteiro: 100/90-18<br><br>
                            Pneu traseiro: 150/70 R17<br><br>
                            Suspensão dianteira: Garfos de cartucho Ø 41 mm<br><br>
                            Suspensão traseira: RSUs gêmeas com ajuste de pré-carga<br><br>
                            Freio dianteiro: Disco flutuante único Ø310mm, pinça axial fixa Brembo de 2 pistão,
                            ABS<br><br>
                            Freio traseiro: Disco de 255 mm, pinça flutuante de simples pistão Nissin, ABS<br><br>
                            Painel de instrumentos e funções: Pacote de instrumentos LCD multifuncional com dois dial
                            com velocímetro analógico e tacômetro analógico<br><br>
                        </p>
                    </div>
                </div>

                <div class="accordion">
                    <button class="accordion-header">
                        <span>
                            Dimensões e pesos
                        </span>
                        <i class="fa-solid fa-chevron-down arrow"></i>
                    </button>

                    <div class="accordion-body">
                        <p>
                            Largura: 780 mm<br><br>
                            Altura: sem espelho 1100 mm<br><br>
                            Altura do Assento: 790 mm<br><br>
                            Distância entre eixos: 1450 mm<br><br>
                            Inclinação: 25.5 º<br><br>
                            Trail: 104.0 mm<br><br>
                            Capacidade do tanque: 14.5 L<br><br>
                            Peso com depósitos cheios: 228 kg<br><br>
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