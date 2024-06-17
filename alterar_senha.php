<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obter dados do formulário
    $email = $_POST['email'];
    $nova_senha = $_POST['senha'];
    
    // Validar dados (você pode adicionar mais validações conforme necessário)
    if (empty($email) || empty($nova_senha)) {
        die("Todos os campos são obrigatórios.");
    }
    
    // Conectar ao banco de dados
    $servername = "localhost";
    $username_db = "root";
    $password_db = "";
    $dbname = "formulario-teste";
    
    $conn = new mysqli($servername, $username_db, $password_db, $dbname);
    
    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }
    
    // Escapar strings para evitar SQL Injection
    $email = $conn->real_escape_string($email);
    $nova_senha = $conn->real_escape_string($nova_senha);
    
    // Atualizar senha no banco de dados
    $sql = "UPDATE usuarios SET senha = '$nova_senha' WHERE email = '$email'";
    
    if ($conn->query($sql) === TRUE) {
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
                        <h2>Senha alterada com sucesso!</h2>
                        <p>Redirecionando...</p>
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
                        <h2>Erro ao alterar senha!</h2>
                        <p>Tente novamente...</p>
                    </div>
                </div>

                <!-- Script para fechar o modal e redirecionar após alguns segundos -->
                <script>
                    setTimeout(function() {
                        document.getElementById("myModal").style.display = "none";
                        window.location.href = "redefinir.php";
                    }, 3000); // Redireciona para a página de login após 3 segundos
                </script>
            </body>
            </html>';
            exit;
    }
    
    // Fechar conexão
    $conn->close();
}
?>