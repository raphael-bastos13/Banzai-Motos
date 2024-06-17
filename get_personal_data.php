<?php
session_start();

if (!isset($_SESSION['email'])) {
    echo "Você precisa estar logado para ver esta página.";
    exit;
}

include_once('config.php');

$email = $_SESSION['email'];
$sql = "SELECT nome, email, telefone, data_nasc, genero, nome_mae, cep, cpf FROM usuarios WHERE email = '$email'";
$result = $conexao->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    echo "<table border='1'>
            <tr><th>Nome</th><td>{$user['nome']}</td></tr>
            <tr><th>Email</th><td>{$user['email']}</td></tr>
            <tr><th>Telefone</th><td>{$user['telefone']}</td></tr>
            <tr><th>Data de Nascimento</th><td>{$user['data_nasc']}</td></tr>
            <tr><th>Gênero</th><td>{$user['genero']}</td></tr>
            <tr><th>Nome Materno</th><td>{$user['nome_mae']}</td></tr>
            <tr><th>CPF</th><td>{$user['cpf']}</td></tr>
          </table>";
} else {
    echo "Nenhum dado encontrado.";
}
?>
