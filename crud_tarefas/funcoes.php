<?php
 
// Inicia a sessão uma única vez (necessário para o $_SESSION funcionar)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
 
// Status permitidos para uma tarefa: valor no banco => texto exibido
const STATUS_TAREFA = [
    'pendente'  => 'Pendente',
    'andamento' => 'Em andamento',
    'concluida' => 'Concluída',
];
 
// Retorna true se existe um usuário logado
function esta_logado(): bool
{
    return isset($_SESSION['usuario_id']);
}
 
// Envia para o login quem não estiver logado
function exigir_login(): void
{
    if (!esta_logado()) {
        header('Location: login.php');
        exit;
    }
}
 
// Escapa um texto antes de exibi-lo no HTML (protege contra XSS)
function e(?string $texto): string
{
    return htmlspecialchars($texto ?? '', ENT_QUOTES, 'UTF-8');
}
 
// Valida os dados de uma tarefa e devolve a lista de erros (vazia se estiver tudo certo)
function validar_tarefa(array $dados): array
{
    $erros = [];
 
    if (empty($dados['titulo'])) {
        $erros[] = 'Informe o título da tarefa.';
    } elseif (mb_strlen($dados['titulo']) > 150) {
        $erros[] = 'O título pode ter no máximo 150 caracteres.';
    }
 
    if (!array_key_exists($dados['status'], STATUS_TAREFA)) {
        $erros[] = 'Status inválido.';
    }
 
    return $erros;
}
