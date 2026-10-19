<?php
require_once 'funcoes.php';
require_once 'conexao.php';
exigir_login();
 
$erros  = [];
$tarefa = ['titulo' => '', 'descricao' => '', 'status' => 'pendente'];
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tarefa['titulo']    = trim($_POST['titulo'] ?? '');
    $tarefa['descricao'] = trim($_POST['descricao'] ?? '');
    $tarefa['status']    = $_POST['status'] ?? 'pendente';
    $erros = validar_tarefa($tarefa);
 
    if (empty($erros)) {
        $usuarioId = $_SESSION['usuario_id'];
 
        $stmt = $conn->prepare(
            'INSERT INTO tarefas (usuario_id, titulo, descricao, status) VALUES (?, ?, ?, ?)'
        );
        $stmt->bind_param('isss', $usuarioId, $tarefa['titulo'], $tarefa['descricao'], $tarefa['status']);
        $stmt->execute();
        $stmt->close();
 
        header('Location: index.php?msg=criada');
        exit;
    }
}
 
$tituloPagina = 'Nova tarefa';
$textoBotao   = 'Salvar tarefa';
require 'topo.php';
?>
<section class="card">
    <h1>Nova tarefa</h1>
    <?php require 'form_tarefa.php'; ?>
</section>
<?php require 'rodape.php'; ?>
