<?php
require_once 'funcoes.php';
require_once 'conexao.php';
exigir_login();
 
// Só aceita POST: um link (GET) nunca deve apagar dados
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}
 
$id    =(int)($_POST['id'] ?? 0);
$usuarioId = $_SESSION['usuario_id'];
 
$stmt = $conn->prepare('DELETE FROM tarefas WHERE id = ? AND usuario_id = ?');
$stmt->bind_param('ii', $id, $usuarioId);
$stmt->execute();
$stmt->close();
 
header('Location: index.php?msg=excluida');
exit;
