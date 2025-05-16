CREATE SCHEMA `webshop` ;

CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    preco DECIMAL(10, 2) NOT NULL,
    ativo BOOLEAN DEFAULT TRUE
);

CREATE TABLE estoque (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produto_id INT NOT NULL,
    quantidade INT NOT NULL,
    atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (produto_id) REFERENCES produtos(id)
);

CREATE TABLE cupons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(50) NOT NULL UNIQUE,
    desconto_percentual DECIMAL(5, 2),
    desconto_valor DECIMAL(10, 2),
    validade DATE,
    ativo BOOLEAN DEFAULT TRUE
);

CREATE TABLE pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    data_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10, 2) NOT NULL,
    cupom_id INT,
    status ENUM('pendente', 'pago', 'cancelado') DEFAULT 'pendente',
    FOREIGN KEY (cupom_id) REFERENCES cupons(id)
);

CREATE TABLE pedido_produto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    produto_id INT NOT NULL,
    quantidade INT NOT NULL,
    preco_unitario DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id),
    FOREIGN KEY (produto_id) REFERENCES produtos(id)
);


