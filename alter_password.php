<?php
session_start();

include_once('config.php');

// Verificar se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Receber os dados do formulário
    $oldPassword = $_POST['old-password'];
    $newPassword = $_POST['new-password'];

    // Verificar se o usuário está logado ou não
    if (!isset($_SESSION['email'])) {
        die("Você precisa estar logado para alterar a senha.");
    }

    // Consultar o banco de dados para obter a senha atual do usuário
    $email = $_SESSION['email'];
    $sql = "SELECT senha FROM usuarios WHERE email = '$email'";
    $result = $conexao->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $storedPassword = $user['senha'];

        // Verificar se a senha antiga fornecida pelo usuário está correta
        if ($oldPassword == $storedPassword) {
            // Atualizar a senha no banco de dados
            $updateSql = "UPDATE usuarios SET senha = '$newPassword' WHERE email = '$email'";
            if ($conexao->query($updateSql) === TRUE) {
                // Exibe modal de sucesso
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

                    <title>Senha Alterada com Sucesso</title>

                    <!-- Estilos do modal -->
                    <style>
                         a {
                        text-decoration: none;
                        color: white;
                        }
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
                    <!-- Modal de sucesso -->
                    <div id="myModal" class="modal">
                        <div class="modal-content">
                            <h2>Senha Alterada com Sucesso!</h2>
                            <p>Sua senha foi atualizada com sucesso.</p>
                            <a href="suaconta.php">Voltar para o Painel</a>
                        </div>
                    </div>

                    <!-- Script para fechar o modal após alguns segundos -->
                    <script>
                        setTimeout(function() {
                            document.getElementById("myModal").style.display = "none";
                            window.location.href = "index.php"; // Redireciona após fechar o modal
                        }, 3000); // Fecha o modal após 3 segundos
                    </script>
                </body>
                </html>';
                exit;
            } else {
                echo "Erro ao atualizar a senha: " . $conexao->error;
            }
        } else {
             // Exibe modal de erro de senha antiga incorreta
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
 
                 <title>Erro ao Alterar Senha</title>
 
                 <!-- Estilos do modal -->
                 <style>
                    a {
                    text-decoration: none;
                    color: white;
                    }
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
                         color: rgb(197, 35, 35);
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
                 <!-- Modal de erro de senha antiga incorreta -->
                 <div id="myModal" class="modal">
                     <div class="modal-content">
                         <h2>Erro ao Alterar Senha</h2>
                         <p>A senha antiga inserida está incorreta.</p>
                         <a href="javascript:history.go(-1)">Voltar ao painel</a>
                     </div>
                 </div>
 
                 <!-- Script para fechar o modal após alguns segundos -->
                 <script>
                     setTimeout(function() {
                         document.getElementById("myModal").style.display = "none";
                     }, 5000); // Fecha o modal após 3 segundos
                 </script>
             </body>
             </html>';
             exit;
         }
     } else {
         echo "Usuário não encontrado.";
     }
 
     // Fecha a conexão com o banco de dados
     $conexao->close();
 }
 ?>
?>
