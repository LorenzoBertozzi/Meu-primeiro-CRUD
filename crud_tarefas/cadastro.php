<?php
require_once 'funcoes.php';
require_once 'conexao.php';
 
// Quem já está logado não precisa se cadastrar
if (esta_logado()) {
    header('Location: index.php');
    exit;
}
 
$erros = [];
$nome  = '';
$email = '';
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome   = trim($_POST['nome'] ?? '');
    $email  = trim($_POST['email'] ?? '');
    $senha  = $_POST['senha'] ?? '';
    $senha2 = $_POST['senha2'] ?? '';
 
    // 1) Validação
    if ($nome === '') {
        $erros[] = 'Informe seu nome.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erros[] = 'Informe um e-mail válido.';
    }
    if (strlen($senha) < 6) {
        $erros[] = 'A senha deve ter pelo menos 6 caracteres.';
    }
    if ($senha !== $senha2) {
        $erros[] = 'As senhas não conferem.';
    }
 
    // 2) O e-mail já está em uso?
    if (empty($erros)) {
        $stmt = $conn->prepare('SELECT id FROM usuarios WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $erros[] = 'Este e-mail já está cadastrado.';
        }
        $stmt->close();
    }
 
    // 3) Grava o usuário com a senha em hash
    if (empty($erros)) {
        $hash = password_hash($senha, PASSWORD_DEFAULT);
        $stmt = $conn->prepare('INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)');
        $stmt->bind_param('sss', $nome, $email, $hash);
        $stmt->execute();
        $stmt->close();
 
        header('Location: login.php?cadastro=ok');
        exit;
    }
}
 
$tituloPagina = 'Cadastro';
require 'topo.php';
?>
<section class="card card-auth">
    <h1>Criar conta</h1>
 
    <?php if (!empty($erros)): ?>
        <div class="alerta alerta-erro">
            <ul>
                <?php foreach ($erros as $erro): ?>
                    <li><?= e($erro) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
 
    <form method="post" action="cadastro.php">
        <div class="campo">
            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" value="<?= e($nome) ?>" required>
        </div>
        <div class="campo">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" value="<?= e($email) ?>" required>
        </div>
        <div class="campo">
            <label for="senha">Senha</label>
            <input type="password" id="senha" name="senha" minlength="6" required>
        </div>
        <div class="campo">
            <label for="senha2">Repita a senha</label>
            <input type="password" id="senha2" name="senha2" minlength="6" required>
        </div>
        <button type="submit" class="btn btn-primario btn-bloco">Cadastrar</button>
    </form>
 
    <p class="texto-form">Já tem conta? <a href="login.php">Entrar</a></p>
</section>
