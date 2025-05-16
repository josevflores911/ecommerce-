INSERT INTO produtos (nome, descricao, preco, ativo) VALUES
('Camiseta Básica', 'Camiseta de algodão 100%', 49.90, TRUE),
('Calça Jeans Slim', 'Calça jeans azul escura', 119.90, TRUE),
('Tênis Esportivo', 'Tênis para corrida e caminhada', 229.90, TRUE),
('Jaqueta Corta Vento', 'Jaqueta leve e resistente à água', 179.90, TRUE),
('Mochila Escolar', 'Mochila com vários compartimentos', 99.90, TRUE);


INSERT INTO estoque (produto_id, quantidade) VALUES
(1, 100),
(2, 75),
(3, 50),
(4, 30),
(5, 120);

INSERT INTO cupons (codigo, desconto_percentual, desconto_valor, validade, ativo) VALUES
('PROMO10', 10.00, NULL, '2025-12-31', TRUE),
('FRETEGRATIS', NULL, 20.00, '2025-10-01', TRUE),
('BOASVINDAS', 15.00, NULL, '2025-08-15', TRUE),
('SUPER25', 25.00, NULL, '2025-07-01', TRUE),
('DESC5', NULL, 5.00, '2025-11-30', TRUE);

INSERT INTO pedidos (data_pedido, total, cupom_id, status) VALUES
(NOW(), 269.90, 1, 'pago'),       -- Tênis Esportivo + cupom PROMO10
(NOW(), 99.90, NULL, 'pendente'), -- Mochila sem cupom
(NOW(), 144.90, 5, 'pago'),       -- Camiseta + cupom DESC5
(NOW(), 299.90, 3, 'cancelado'),  -- Calça + Jaqueta + cupom BOASVINDAS
(NOW(), 119.90, NULL, 'pago');    -- Calça sem cupom

INSERT INTO pedido_produto (pedido_id, produto_id, quantidade, preco_unitario) VALUES
(1, 3, 1, 229.90), -- Tênis Esportivo
(2, 5, 1, 99.90),  -- Mochila
(3, 1, 1, 49.90),  -- Camiseta
(4, 2, 1, 119.90), -- Calça
(4, 4, 1, 179.90), -- Jaqueta
(5, 2, 1, 119.90); -- Calça
