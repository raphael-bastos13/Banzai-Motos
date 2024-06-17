<?php
session_start();
session_unset(); // Limpar todas as variáveis de sessão
session_destroy(); // Destruir a sessão
header("Location: index.php"); // Redirecionar para a página inicial
exit();
?>