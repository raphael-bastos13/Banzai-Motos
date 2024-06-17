<?php
session_start();
include_once('config.php');

// Função para registrar log de atividades
function registrar_log($conexao, $usuario_id, $nome_usuario, $acao, $cpf, $detalhes_adicionais = '') {
    $sql = "INSERT INTO log_atividades (usuario_id, nome_usuario, acao, cpf, detalhes_adicionais) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('issss', $usuario_id, $nome_usuario, $acao, $cpf, $detalhes_adicionais);
    $stmt->execute();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE email = ? AND senha = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('ss', $email, $senha);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['email'] = $user['email'];
        $_SESSION['senha'] = $user['senha'];

        // Registra o log de login
        registrar_log($conexao, $user['id'], $user['nome'], 'Login', $user['cpf']);

        header('Location: index.php');
        exit;
    } else {
        echo "Email ou senha incorretos.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/logineregister.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link href="https://fonts.googleapis.com/css2?family=Nunito&family=Nunito+Sans&family=Oswald&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Unbounded&display=swap" rel="stylesheet">

    <link rel="shortcut icon" href="./assets/logo.png" type="image/x-icon">

    <title>Login</title>
</head>
<body>
    <section class="login">

        <div class="imagem-login" id="background-black">
        <img src="assets/logobanzai.png">
        </div>

        <form action="configLogin.php" method="POST">
        <div class="informacoes-login" id="login-form">
            <h2>LOGIN</h2>
            <h3 class="mensagem">Preencha os campos abaixo.</h3>
            <div class="infos">
                <input type="email" name="email" class="email" placeholder="Preencha seu Login">
                <input type="password" name="senha" class="senha" placeholder="Preencha sua senha">
            </div>
            <h3 class="sem-conta">Não possui conta? <a href="./register.php">Cadastrar-se</a></h3>
            <h3 class="sem-conta">Esqueceu a senha?<a href="./redefinir.php"> Alterar</a></h3>
            <input type="submit" id="submit" name="submit" value="Logar" class="entrar">
            <input type="reset" value="Limpar" class="entrar">
        </div>
        </form>

    </section>
    
</body>
</html>