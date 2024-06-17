<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['email']) || !isset($_SESSION['senha'])) {
    header('Location: login.php');
    exit;
}

include_once('config.php');

$email = $_SESSION['email'];

$sql = "SELECT nome_mae, data_nasc, cep FROM usuarios WHERE email = '$email'";
$result = $conexao->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $questions = [
        "Qual o nome da sua mãe?" => $user['nome_mae'],
        "Qual a data do seu nascimento?" => $user['data_nasc'],
        "Qual o CEP do seu endereço?" => $user['cep']
    ];

    // Seleciona uma pergunta aleatória se não estiver definida
    if (!isset($_SESSION['random_question']) || !isset($_SESSION['correct_answer'])) {
        $random_key = array_rand($questions);
        $_SESSION['random_question'] = $random_key;
        $_SESSION['correct_answer'] = $questions[$random_key];
    }
} else {
    header('Location: login.php');
    exit;
}

// Definição do número máximo de tentativas
$maxTentativas = 3;

// Verifica se o contador de tentativas está definido na sessão
if (!isset($_SESSION['tentativas_2fa'])) {
    $_SESSION['tentativas_2fa'] = 0;
}

// Verifica se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $answer = trim($_POST['answer']);
    $correct_answer = trim($_SESSION['correct_answer']);

    // Convertendo para minúsculas para comparação case-insensitive
    if (strtolower($answer) == strtolower($correct_answer)) {
        // Limpa as variáveis de sessão
        unset($_SESSION['random_question']);
        unset($_SESSION['correct_answer']);
        // Exibe um modal de confirmação de verificação bem-sucedida
    echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/logineregister.css">
    
        <link href="https://fonts.googleapis.com/css2?family=Nunito&family=Nunito+Sans&family=Oswald&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Unbounded&display=swap" rel="stylesheet">
    
        <link rel="shortcut icon" href="./assets/logo.png" type="image/x-icon">
    
        <title>Verificação de dois fatores</title>
    
        <!-- Estilos do modal -->
        <style>
            .modal {
                display: block;
                position: fixed;
                z-index: 999;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
            }
            .modal-content {
                background-color: #1b1b1b;
                margin: 15% auto;
                padding: 20px;
                border: 1px solid #888;
                width: 80%;
                max-width: 600px;
                text-align: center;
                border-radius: 10px;
            }
            .modal-content h2 {
                color: rgb(197, 167, 35);
                font-size: 24px;
                margin-bottom: 20px;
            }
            .modal-content p {
                color: white;
                font-size: 18px;
                margin-bottom: 20px;
            }
        </style>
    </head>
    <body>
        <!-- Modal de verificação bem-sucedida -->
        <div id="myModalSuccess" class="modal">
            <div class="modal-content">
                <h2>Verificação bem-sucedida!</h2>
                <p>Agora você está logado.</p>
            </div>
        </div>
    
        <!-- Script para fechar o modal e redirecionar após alguns segundos -->
        <script>
            setTimeout(function() {
                document.getElementById("myModalSuccess").style.display = "none";
                window.location.href = "index.php";
            }, 3000); // Redireciona para a página principal após 3 segundos
        </script>
    </body>
    </html>';
    exit;
    } else {
        // Incrementa o contador de tentativas
        $_SESSION['tentativas_2fa']++;

        if ($_SESSION['tentativas_2fa'] > $maxTentativas) {
            // Redireciona para a página de login após exceder o número máximo de tentativas
            unset($_SESSION['tentativas_2fa']); // Reseta o contador de tentativas
            echo '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="css/logineregister.css">

                <link href="https://fonts.googleapis.com/css2?family=Nunito&family=Nunito+Sans&family=Oswald&display=swap" rel="stylesheet">
                <link href="https://fonts.googleapis.com/css2?family=Unbounded&display=swap" rel="stylesheet">

                <link rel="shortcut icon" href="./assets/logo.png" type="image/x-icon">

                <title>Login</title>

                <!-- Estilos do modal -->
                <style>
                    .modal {
                        display: block;
                        position: fixed;
                        z-index: 999;
                        left: 0;
                        top: 0;
                        width: 100%;
                        height: 100%;
                        background-color: rgba(0, 0, 0, 0.5);
                    }
                    .modal-content {
                        background-color: #1b1b1b;
                        margin: 15% auto;
                        padding: 20px;
                        border: 1px solid #888;
                        width: 80%;
                        max-width: 600px;
                        text-align: center;
                        border-radius: 10px;
                    }
                    .modal-content h2 {
                        color: rgb(197, 167, 35);
                        font-size: 24px;
                        margin-bottom: 20px;
                    }
                    .modal-content p {
                        color:white;
                        font-size: 18px;
                        margin-bottom: 20px;
                    }
                </style>
            </head>
            <body>
                <!-- Modal de tentativas excedidas -->
                <div id="myModal" class="modal">
                    <div class="modal-content">
                        <h2>Limite de tentativas excedido!</h2>
                        <p>Você excedeu o número máximo de tentativas de verificação.</p>
                    </div>
                </div>

                <!-- Script para fechar o modal e redirecionar após alguns segundos -->
                <script>
                    setTimeout(function() {
                        document.getElementById("myModal").style.display = "none";
                        window.location.href = "login.php";
                    }, 3000); // Redireciona para a página de login após 3 segundos
                </script>
            </body>
            </html>';
            exit;
        } else {
            // Calcula as tentativas restantes
            $tentativasRestantes = $maxTentativas - $_SESSION['tentativas_2fa'];

            // Exibe um modal com as tentativas restantes
            echo '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="css/logineregister.css">

                <link href="https://fonts.googleapis.com/css2?family=Nunito&family=Nunito+Sans&family=Oswald&display=swap" rel="stylesheet">
                <link href="https://fonts.googleapis.com/css2?family=Unbounded&display=swap" rel="stylesheet">

                <link rel="shortcut icon" href="./assets/logo.png" type="image/x-icon">

                <title>Login</title>

                <!-- Estilos do modal -->
                <style>
                    .modal {
                        display: block;
                        position: fixed;
                        z-index: 999;
                        left: 0;
                        top: 0;
                        width: 100%;
                        height: 100%;
                        background-color: rgba(0, 0, 0, 0.5);
                    }
                    .modal-content {
                        background-color: #1b1b1b;
                        margin: 15% auto;
                        padding: 20px;
                        border: 1px solid #888;
                        width: 80%;
                        max-width: 600px;
                        text-align: center;
                        border-radius: 10px;
                    }
                    .modal-content h2 {
                        color: rgb(197, 167, 35);
                        font-size: 24px;
                        margin-bottom: 20px;
                    }
                    .modal-content p {
                        color: white;
                        font-size: 18px;
                        margin-bottom: 20px;
                    }
                </style>
            </head>
            <body>
                <!-- Modal de tentativas restantes -->
                <div id="myModal" class="modal">
                    <div class="modal-content">
                        <h2>Resposta incorreta!</h2>
                        <p>Tentativas restantes: ' . $tentativasRestantes . '</p>
                    </div>
                </div>

                <!-- Script para fechar o modal após alguns segundos -->
                <script>
                    setTimeout(function() {
                        document.getElementById("myModal").style.display = "none";
                    }, 3000); // Fecha o modal após 3 segundos
                </script>
            </body>
            </html>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/logineregister.css">

    <link href="https://fonts.googleapis.com/css2?family=Nunito&family=Nunito+Sans&family=Oswald&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Unbounded&display=swap" rel="stylesheet">

    <link rel="shortcut icon" href="./assets/logo.png" type="image/x-icon">

    <title>Verificação de dois fatores</title>
</head>
<body>
    <section class="login">

        <div class="imagem-login">
        <img src="assets/logobanzai.png">
        </div>

        <form action="tela2fa.php" method="POST">
        <div class="informacoes-login">
            <h2>Verificação de dois fatores</h2>
            <h3 class="mensagem">Preencha os campos abaixo.</h3>
            <div class="infos">
                <input type="hidden" name="question" value="<?php echo $_SESSION['random_question']; ?>">
                <input type="text" name="answer" class="email" placeholder="<?php echo $_SESSION['random_question']; ?>" required>
            </div>
            <h3 class="sem-conta">Esqueceu a senha?<a href="./redefinir.php"> Alterar</a></h3>
            <input type="submit" id="submit" name="submit" value="Verificar" class="entrar">
        </div>
        </form>

    </section>
</body>
</html>

