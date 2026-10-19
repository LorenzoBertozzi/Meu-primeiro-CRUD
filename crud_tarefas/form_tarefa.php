<?php
// form_tarefa.php - campos do formulário usados por criar.php e editar.php
// Variáveis esperadas: $tarefa (array), $erros (array) e $textoBotao (string)
?>
<?php if (!empty($erros)): ?>
    <div class="alerta alerta-erro">
        <ul>
            <?php foreach ($erros as $erro): ?>
                <li><?= e($erro) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
 
<form method="post">
    <div class="campo">
        <label for="titulo">Título</label>
        <input type="text" id="titulo" name="titulo" maxlength="150" value="<?= e($tarefa['titulo']) ?>" required>
    </div>
 
    <div class="campo">
        <label for="descricao">Descrição</label>
        <textarea id="descricao" name="descricao" rows="4"><?= e($tarefa['descricao']) ?></textarea>
    </div>
 
    <div class="campo">
        <label for="status">Status</label>
        <select id="status" name="status">
            <?php foreach (STATUS_TAREFA as $valor => $rotulo): ?>
                <option value="<?= e($valor) ?>" <?= $tarefa['status'] === $valor ? 'selected' : '' ?>>
                    <?= e($rotulo) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
 
    <div class="form-acoes">
        <button type="submit" class="btn btn-primario"><?= e($textoBotao) ?></button>
        <a class="btn btn-secundario" href="index.php">Cancelar</a>
    </div>
</form>
