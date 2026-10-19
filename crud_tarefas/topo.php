<?php
require_once __DIR__ . '/funcoes.php';
$tituloPagina = $tituloPagina ?? 'Tarefas';?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($tituloPagina) ?> | Minhas Tarefas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header class="topo">
    <div class="container topo-conteudo">
        <a class="marca" href="index.php">Minhas Tarefas</a>
        <nav>
            <?php if (esta_logado()): ?>
                <span class="saudacao">Olá, <?= e($_SESSION['usuario_nome']) ?></span>
                <a href="index.php">Tarefas</a>
                <a href="logout.php">Sair</a>
            <?php else: ?>
                <a href="login.php">Entrar</a>
                <a href="cadastro.php">Cadastrar</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
<main class="container">
