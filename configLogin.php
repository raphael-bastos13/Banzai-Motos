<?php
    session_start();
    

    if (isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['senha']))
    {
        include_once('config.php');
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $sql = "SELECT * FROM usuarios WHERE email = '$email' and senha = '$senha'";

        $result = $conexao->query($sql);

        if (mysqli_num_rows($result) < 1)
        {
            unset($_SESSION['email']);
            unset($_SESSION['senha']);
            header('Location:telaerror/telaerror.html');
            exit;
        }
        else
        {
            $_SESSION['email'] = $email;
            $_SESSION['senha'] = $senha;
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
                        <h2>Logado com sucesso!</h2>
                        <p>Redirecionando...</p>
                    </div>
                </div>

                <!-- Script para fechar o modal e redirecionar após alguns segundos -->
                <script>
                    setTimeout(function() {
                        document.getElementById("myModal").style.display = "none";
                        window.location.href = "tela2fa.php";
                    }, 3000); // Redireciona para a página de login após 3 segundos
                </script>
            </body>
            </html>';
            exit;
        }
    }
    else
    {
        header('Location: login.php');
    }

?>