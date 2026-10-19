CREATE DATABASE IF NOT EXISTS crud_tarefas
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
 
USE crud_tarefas;
 
CREATE TABLE IF NOT EXISTS usuarios (
  id        INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nome      VARCHAR(100) NOT NULL,
  email     VARCHAR(150) NOT NULL UNIQUE,
  senha VARCHAR(255) NOT NULL
);


CREATE TABLE IF NOT EXISTS tarefas (
  id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  usuario_id    INT UNSIGNED NOT NULL,
  titulo        VARCHAR(150) NOT NULL,
  descricao     TEXT NULL,
  status        ENUM('pendente', 'andamento', 'concluida') NOT NULL DEFAULT 'pendente',
  criado_em     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_tarefas_usuario
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
    ON DELETE CASCADE
);


USE crud_tarefas;


INSERT INTO usuarios (nome, email, senha)
VALUES ('Usuário de Teste', 'teste@exemplo.com','senha');


INSERT INTO tarefas (usuario_id, titulo, descricao, status) VALUES
(1, 'Instalar o XAMPP', 'Baixar e iniciar Apache e MySQL', 'concluida'),
(1, 'Criar o banco de dados', 'Rodar o script SQL no phpMyAdmin', 'andamento'),
(1, 'Fazer o primeiro CRUD', 'Listar, criar, editar e excluir tarefas', 'pendente');
