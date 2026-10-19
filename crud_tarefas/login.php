<?php
require_once 'funcoes.php';
require_once 'conexao.php';
 
if (esta_logado()) {
    header('Location: index.php');
    exit;
}
 
$erro  = '';
$email = '';
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
 
    // Busca o usuário pelo e-mail
    $stmt = $conn->prepare('SELECT id, nome, senha FROM usuarios WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $usuario = $stmt->get_result()->fetch_assoc();
    $stmt->close();
 
    // Confere a senha digitada com o hash guardado
    if ($usuario && password_verify($senha, $usuario['senha'])) {
        session_regenerate_id(true);
        $_SESSION['usuario_id']   = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
 
        header('Location: index.php');
        exit;
    }
 
    // A mesma mensagem para e-mail inexistente e senha errada
    $erro = 'E-mail ou senha incorretos.';
}
 
$tituloPagina = 'Entrar';
require 'topo.php';
?>
<section class="card card-auth">
    <h1>Entrar</h1>
 
    <?php if (($_GET['cadastro'] ?? '') === 'ok'): ?>
        <div class="alerta alerta-sucesso">Conta criada! Entre com seu e-mail e senha.</div>
    <?php endif; ?>
 
    <?php if ($erro !== ''): ?>
        <div class="alerta alerta-erro"><?= e($erro) ?></div>
    <?php endif; ?>
 
    <form method="post" action="login.php">
        <div class="campo">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" value="<?= e($email) ?>" required>
        </div>
        <div class="campo">
            <label for="senha">Senha</label>
            <input type="password" id="senha" name="senha" required>
        </div>
        <button type="submit" class="btn btn-primario btn-bloco">Entrar</button>
    </form>
 
    <p class="texto-form">Ainda não tem conta? <a href="cadastro.php">Cadastre-se</a></p>
</section>
<?php require 'rodape.php'; ?>
