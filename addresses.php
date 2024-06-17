<?php
session_start();

if (!isset($_SESSION['email'])) {
    echo "Você precisa estar logado para ver esta página.";
    exit;
}

include_once('config.php');

$email = $_SESSION['email'];
$sql = "SELECT cep,endereco FROM usuarios WHERE email = '$email'";
$result = $conexao->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr><th>CEP</th><th>Endereço completo</th></tr>";
    while ($address = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$address['cep']}</td>
                <td>{$address['endereco']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "Nenhum endereço encontrado.";
}
?>