CREATE DATABASE IF NOT EXISTS sistema_produtos CHARACTER SET utf8mb4;
USE sistema_produtos;

CREATE TABLE IF NOT EXISTS categorias (
    id   INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS produtos (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    descricao    VARCHAR(255)   NOT NULL,
    categoria_id INT            NOT NULL,
    valor_compra DECIMAL(10,2)  NOT NULL,
    valor_venda  DECIMAL(10,2)  NOT NULL,
    qtd_estoque  INT            NOT NULL DEFAULT 0,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id)
);

INSERT INTO categorias (nome) VALUES
    ('Informática'),('Eletrônicos'),('Celulares'),
    ('Periféricos'),('Acessórios'),('Games'),('Outros');

INSERT INTO produtos (descricao, categoria_id, valor_compra, valor_venda, qtd_estoque)
VALUES ('Notebook Samsung', 1, 3800.00, 4120.00, 50);
