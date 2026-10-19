<?php
require_once 'funcoes.php';
require_once 'conexao.php';
exigir_login();
 
$usuarioId = $_SESSION['usuario_id'];
$id   = (int)($_GET['id'] ?? 0);
 
// Carrega a tarefa, garantindo que ela pertence ao usuário logado
$stmt = $conn->prepare('SELECT id, titulo, descricao, status FROM tarefas WHERE id = ? AND usuario_id = ?');
$stmt->bind_param('ii', $id, $usuarioId);
$stmt->execute();
$tarefa = $stmt->get_result()->fetch_assoc();
$stmt->close();
 
// Não existe, ou é de outro usuário: volta para a lista
if (!$tarefa) {
    header('Location: index.php');
    exit;
}
 
$erros = [];
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tarefa['titulo']    = trim($_POST['titulo'] ?? '');
    $tarefa['descricao'] = trim($_POST['descricao'] ?? '');
    $tarefa['status']    = $_POST['status'] ?? 'pendente';
    $erros = validar_tarefa($tarefa);
 
    if (empty($erros)) {
        $stmt = $conn->prepare(
            'UPDATE tarefas SET titulo = ?, descricao = ?, status = ? WHERE id = ? AND usuario_id = ?'
        );
        $stmt->bind_param('sssii', $tarefa['titulo'], $tarefa['descricao'], $tarefa['status'], $id, $usuarioId);
        $stmt->execute();
        $stmt->close();
 
        header('Location: index.php?msg=editada');
        exit;
    }
}
 
$tituloPagina = 'Editar tarefa';
$textoBotao   = 'Salvar alterações';
require 'topo.php';
?>
<section class="card">
    <h1>Editar tarefa</h1>
    <?php require 'form_tarefa.php'; ?>
</section>
<?php require 'rodape.php'; ?>
