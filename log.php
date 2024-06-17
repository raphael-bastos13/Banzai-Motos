<?php
session_start();

include_once('config.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['email']) || !isset($_SESSION['senha'])) {
    header('Location: login.php');
    exit;
}

// Função para buscar dados de log no banco de dados
function fetch_logs($conexao) {
    $sql = "SELECT nome_usuario, data_hora, usuario_id, acao, cpf, detalhes_adicionais FROM log_atividades ORDER BY data_hora DESC";
    $result = $conexao->query($sql);
    $logs = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $logs[] = $row;
        }
    }
    return $logs;
}

$logs = fetch_logs($conexao);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="LOG.css">
    <script src="LOG.js"></script>
    <title>Tela de Log de Atividades do Usuário</title>
</head>
<body>
    <header>
        <div class="logo">
            <img class="logo-img" src="imagens/logobanzai.png" alt="Logo">
        </div>
        <input type="checkbox" id="nav_check" hidden>
        <nav>
            <ul>
                <li>
                    <a href="dashboard/dash.html" class="active">dashboard</a>
                </li>
                
                <li>
                    |
                </li>
            </ul>
        </nav>
        <label for="nav_check" class="hamburger">
            <div></div>
            <div></div>
            <div></div>
        </label>
    </header>
    <br>
    <h1>Log dos Usuários</h1>
    <div class="filter-container">
        <div class="expandable" id="expandableFilter">
            <button id="expandButton">Filtrar/Resetar</button>
            <select id="columnSelect">
                <option value="0">Nome de Usuário</option>
                <option value="1">Data e Hora</option>
                <option value="2">ID do Usuário</option>
                <option value="3">Ação Realizada</option>
                <option value="4">CPF</option>
            </select>
            <input type="text" id="searchInput" placeholder="Buscar...">
            <button id="filterButton">Filtrar</button>
            <button id="resetButton">Resetar Filtro</button>
        </div>
    </div>
    <table id="logTable">
        <thead>
            <tr>
                <th>Nome de Usuário</th>
                <th>Data e Hora</th>
                <th>ID do Usuário</th>
                <th>Ação Realizada</th>
                <th>CPF</th>
                
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logs as $log): ?>
                <tr>
                    <td><?php echo htmlspecialchars($log['nome_usuario']); ?></td>
                    <td><?php echo htmlspecialchars($log['data_hora']); ?></td>
                    <td><?php echo htmlspecialchars($log['usuario_id']); ?></td>
                    <td><?php echo htmlspecialchars($log['acao']); ?></td>
                    <td><?php echo htmlspecialchars($log['cpf']); ?></td>
                   
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <script src="LOG.js"></script>
</body>
</html>