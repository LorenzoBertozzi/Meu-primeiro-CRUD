<?php
require_once 'funcoes.php';
require_once 'conexao.php';
exigir_login();
 
$usuarioId = $_SESSION['usuario_id'];
 
$stmt = $conn->prepare(
    'SELECT id, titulo, descricao, status, criado_em
    FROM tarefas
    WHERE usuario_id = ?
    ORDER BY criado_em DESC'
);
$stmt->bind_param('i', $usuarioId);
$stmt->execute();
$tarefas = $stmt->get_result();
 
// Mensagens de sucesso, escolhidas por uma chave na URL (?msg=criada)
$mensagens = [
    'criada'   => 'Tarefa criada com sucesso.',
    'editada'  => 'Tarefa atualizada com sucesso.',
    'excluida' => 'Tarefa excluída com sucesso.',
];

$msg = $mensagens [$_GET['msg'] ?? ''] ?? '';
 
$tituloPagina = 'Minhas tarefas';
require 'topo.php';
?>
<div class="cabecalho-pagina">
    <h1>Minhas tarefas</h1>
    <a class="btn btn-primario" href="criar.php">+ Nova tarefa</a>
</div>
 
<?php if ($msg !== ''): ?>
    <div class="alerta alerta-sucesso"><?= e($msg) ?></div>
<?php endif; ?>
 
<?php if ($tarefas->num_rows === 0): ?>
    <div class="card vazio">Você ainda não tem tarefas. Clique em Nova tarefa para começar.</div>
<?php else: ?>
    <div class="card">
        <table class="tabela">
            <thead>
                <tr>
                    <th>Tarefa</th>
                    <th>Status</th>
                    <th>Criada em</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($t = $tarefas->fetch_assoc()): ?>
                <tr>
                    <td>
                        <strong><?= e($t['titulo']) ?></strong>
                        <?php if (!empty($t['descricao'])): ?>
                            <div class="descricao"><?= e($t['descricao']) ?></div>
                        <?php endif; ?>
                    </td>
                    <td>
                        <span class="badge badge-<?= e($t['status']) ?>"><?= e(STATUS_TAREFA[$t['status']]) ?></span>
                    </td>
                    <td><?= date('d/m/Y H:i', strtotime($t['criado_em'])) ?></td>
                    <td class="acoes">
                        <a class="btn btn-secundario btn-pequeno" href="editar.php?id=<?= (int) $t['id'] ?>">Editar</a>
                        <form method="post" action="excluir.php" onsubmit="return confirm('Excluir esta tarefa?');">
                            <input type="hidden" name="id" value="<?= (int) $t['id'] ?>">
                            <button type="submit" class="btn btn-perigo btn-pequeno">Excluir</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
 
<?php require 'rodape.php'; ?>
