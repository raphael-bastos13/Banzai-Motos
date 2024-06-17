<?php
$showModal = false; // Variável para controlar a exibição do modal
    if (isset($_POST['submit']))
    {
        include_once('config.php');

        

        $nome = $_POST['nome'];
        $nomeMaterno = $_POST['nomeMaterno'];
        $cep = $_POST['cep'];
        $endereco = $_POST['endereco'];
        $cpf = $_POST['cpf'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $telefone = $_POST['telefone'];
        $nascimento = $_POST['nascimento'];
        $genero = $_POST['genero'];
        $emailCadastrado = "email já está cadastrado!";
        $telCadastrado = "Telefone já cadastrado!";

        $sqlEmail = "SELECT * FROM usuarios WHERE email = '$email'";
        $resultEmail = $conexao->query($sqlEmail);

        $sqlTelefone = "SELECT * FROM usuarios WHERE telefone = '$telefone'";
        $resultTelefone = $conexao->query($sqlTelefone);

        if (mysqli_num_rows($resultEmail) > 0)
        {
            echo '<script>alert("'.$emailCadastrado.'");</script>';
        }
        else if (mysqli_num_rows($resultTelefone) > 0) 
        {
            echo '<script>alert("'.$telCadastrado.'");</script>';
        }
        else
        {
          
           // Define 'usuario comum' para novos registros
        $tipo_usuario = 'usuario comum';

            $result = mysqli_query($conexao, "INSERT INTO usuarios(nome, email, senha, telefone, data_nasc, genero, nome_mae, cep, cpf,tipo_usuario,endereco) 
            VALUES ('$nome', '$email', '$senha', '$telefone', '$nascimento', '$genero', '$nomeMaterno', '$cep', '$cpf','$tipo_usuario','$endereco')");

            if ($result) {
             $showModal = true; // Define a variável para mostrar o modal
         } else {
            echo '<script>alert("Erro ao registrar. Tente novamente.");</script>';
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
    <link rel="stylesheet" href="css/logineregister.css">
    

    <link href="https://fonts.googleapis.com/css2?family=Nunito&family=Nunito+Sans&family=Oswald&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Unbounded&display=swap" rel="stylesheet">

    <link rel="shortcut icon" href="./assets/logo.png" type="image/x-icon">

    <title>Register</title>
</head>
<body>
<style>
        /* Estilos do modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background-color: #1b1b1b;
            padding: 20px;
            border-radius: 8px;
            width: 90%;
            max-width: 500px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            display: flex;
            justify-content: flex-end;
        }

        .close {
            font-size: 24px;
            cursor: pointer;
        }

        .modal-body h2 {
            color: rgb(197, 167, 35);
            font-size: 24px;
            margin-top: 0;
        }

        .modal-body p {
            color: white;
            font-size: 18px;
            margin: 10px 0;
        }

        .modal-footer {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .modal-footer button {
            padding: 10px 20px;
            border: none;
            background-color: #4CAF50;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
        }

        .modal-footer button:hover {
            background-color: #45a049;
        }
    </style>

    <section class="login">

        <div class="imagem-login">
            <img src="assets/logobanzai.png">
        </div>

        <div class="informacoes-login">
            <form action="register.php" method="post">

                <h2>Cadastro</h2>
                <h3 class="mensagem">Preencha os campos abaixo.</h3>
                <div class="infos">
                    <input type="text" name="nome" class="nome" placeholder="Preencha seu nome" required>
                    <input type="text" name="nomeMaterno" class="nome" placeholder="Preencha nome materno" required>
                    <input type="email" onblur="validacaoEmail(f1.email)" name="email" class="email" placeholder="Preencha seu E-mail" required>
                    <input type="password" name="senha" class="senha" placeholder="Preencha sua senha" required>
                    <input type="password" name="confirmar-senha" class="confirmar-senha" placeholder="Confirmar senha" required>
                    <input type="tel" minlength="11" maxlength="15" onkeyup="handlePhone(event)" name="telefone" id="telefone" placeholder="Preencha seu Telefone celular" required> 
                    <input type="date" name="nascimento" id="nascimento" required>
                    <input type="text" name="cpf" id="cpf" placeholder="Preencha seu CPF" required oninput="formatarCPF()">
                    <input type="text" name="cep" id="cep" placeholder="Preencha seu CEP" required onblur="buscarEndereco()">
                    <input type="text" name="endereco" id="endereco" placeholder="Preencha seu Endereço" required>
                      
                    
                    <div class="sexo">
                        <p>Gênero</p>
                        <div class="box-sexo">
                            <input type="radio" id="feminino" name="genero" value="feminino" required>
                            <label for="feminino">Feminino</label>
                        </div>
                    <br>
                        <div class="box-sexo">
                            <input type="radio" id="masculino" name="genero" value="masculino" required>
                            <label for="masculino">Masculino</label>
                        </div>
                    <br>
                        <div class="box-sexo">
                            <input type="radio" id="outro" name="genero" value="outro" required>
                            <label for="outro">Outro</label>                        
                        </div>
                    </div>
                </div>
                <h3 class="sem-conta">já possui conta?<a href="./login.php"> Logar</a></h3>
                <input type="submit" name="submit" id="submit" value="Cadastrar">

            </form>
        </div>
    </section>
    <?php if ($showModal) { ?>
    <!-- Modal de sucesso -->
    <div id="success-modal" class="modal" style="display: flex;">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" onclick="window.location.href = 'login.php';">&times;</span>
            </div>
            <div class="modal-body">
                <h2>Cadastro realizado com sucesso!</h2>
                <p>Você será redirecionado para a página de login.</p>
            </div>
            <div class="modal-footer">
                <button onclick="window.location.href = 'login.php';">OK</button>
            </div>
        </div>
    </div>
    <?php } ?>
    <script src="./js/telefone.js"></script>
    <script>
                        
                        function formatarCPF() {
                         var cpf = document.getElementById('cpf').value.replace(/\D/g, '');

                        if (cpf.length > 11) {
                          cpf = cpf.substring(0, 11);
                            }

                            var cpfFormatado = cpf;
                            if (cpf.length > 3) {
                             cpfFormatado = cpf.substring(0, 3) + '.' + cpf.substring(3);
                            }
                                if (cpf.length > 6) {
                                 cpfFormatado = cpf.substring(0, 3) + '.' + cpf.substring(3, 6) + '.' + cpf.substring(6);
                            }
                                if (cpf.length > 9) {
                                 cpfFormatado = cpf.substring(0, 3) + '.' + cpf.substring(3, 6) + '.' + cpf.substring(6, 9) + '-' + cpf.substring(9, 11);
                            }

                                 document.getElementById('cpf').value = cpfFormatado;
                        }
                        function buscarEndereco() {
                            var cep = document.getElementById('cep').value.replace(/\D/g, '');

                    if (cep !== "") {
                     var validacep = /^[0-9]{8}$/;

                    if(validacep.test(cep)) {
                     var script = document.createElement('script');
                     script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=preencherFormulario';
                     document.body.appendChild(script);
                    } else {
                         alert("Formato de CEP inválido.");
                    }
                }
            }

    function preencherFormulario(conteudo) {
        if (!("erro" in conteudo)) {
            document.getElementById('endereco').value = conteudo.logradouro + ", " + conteudo.bairro + ", " + conteudo.localidade + " - " + conteudo.uf;
        } else {
            alert("CEP não encontrado.");
        }
    }
</script>
</body>
</html>