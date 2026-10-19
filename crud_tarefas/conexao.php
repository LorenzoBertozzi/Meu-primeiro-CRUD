<?php
 
$host  = 'localhost';
$user  = 'root';
$pass  = '';            // padrão do XAMPP: sem senha
$banco = 'crud_tarefas';
 
// Faz o mysqli lançar exceções em vez de avisos silenciosos
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
 
try {
    $conn = new mysqli($host, $user, $pass, $banco);
    $conn->set_charset('utf8mb4');
} catch (mysqli_sql_exception $e) {
    // Em um sistema real, grave o erro em log e não mostra detalhes ao usuário
    die('Erro ao conectar ao banco de dados: ' . $e->getMessage());
}
