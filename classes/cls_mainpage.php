<?php
require_once("../classes/cls_connect.php");

class cls_mainpage extends cls_connect
{
    static $cursor = null;
    static $connected = false;
    static $conn = null;
    static $Error = '0';
    static $message = "";

    public function __construct()
    {
        parent::__construct();
        self::$conn = parent::$conn;
    }

    public function getProdutos()
    {
        if (self::$conn) {
            self::$connected = true;

            $sql = "
                            SELECT p.id, p.nome, p.preco, e.quantidade
                            FROM produtos p
                            JOIN estoque e ON p.id = e.produto_id
                            WHERE e.quantidade > 0 AND p.ativo = TRUE
                            ORDER BY p.nome;
                        ";


            $result = json_decode($this->dbquery($sql));
            // $result = json_decode($this->dbquery($sql, $agencia, $sistema));

            if ($result->nrecords > 0) {
                self::$Error = '0';
                self::$message = 'Consulta realizada com sucesso';
                self::$cursor = $result->records;
                return ['Error' => self::$Error, 'Message' => self::$message, 'Data' => self::$cursor];
            } else {
                self::$Error = '404';
                self::$message = "Consulta não retornou registros";
                return ["Error" => "404", "Message" => self::$message];
            }
        } else {
            self::$Error = '504';
            self::$message = "Banco de dados desconectado";
            return ["Error" => "504", "Message" => self::$message];
        }
    }

    public function getUsuarioByEmailSenha($email, $senha)
    {
        if (self::$conn) {
            self::$connected = true;

            $sql = "SELECT id, nome, email FROM usuarios WHERE email = ? AND senha = ?";
            $result = json_decode($this->dbquery($sql, $email, $senha));

            if ($result->nrecords > 0) {
                return ['erro' => '0', 'usuario' => $result->records[0]];
            } else {
                return ['erro' => '1', 'message' => 'Usuário ou senha inválidos.'];
            }
        } else {
            return ['erro' => '504', 'message' => 'Banco de dados desconectado.'];
        }
    }

    public function salvarProduto($nome, $descricao, $preco, $quantidade, $ativo = TRUE)
    {
        $conn = self::$conn;

        try {
            $conn->beginTransaction();

            // Insere produto
            $sqlProduto = "INSERT INTO produtos (nome, descricao, preco, ativo) VALUES (?, ?, ?, ?)";
            $stmtProduto = $conn->prepare($sqlProduto);
            $stmtProduto->execute([$nome, $descricao, $preco, $ativo]);

            $produtoId = $conn->lastInsertId();

            // Insere no estoque
            $sqlEstoque = "INSERT INTO estoque (produto_id, quantidade) VALUES (?, ?)";
            $stmtEstoque = $conn->prepare($sqlEstoque);
            $stmtEstoque->execute([$produtoId, $quantidade]);

            $conn->commit();
            return true;
        } catch (Exception $e) {
            $conn->rollBack();
            return false;
        }
    }

    public function atualizarEstoque($produtosComprados)
    {
        $conn = self::$conn;

        try {
            $conn->beginTransaction();

            foreach ($produtosComprados as $produto) {
                $produtoId = intval($produto['id']);
                $quantidadeComprada = intval($produto['quantidade']);

                $sql = "UPDATE estoque SET quantidade = quantidade - ? WHERE produto_id = ? AND quantidade >= ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$quantidadeComprada, $produtoId, $quantidadeComprada]);
            }

            $conn->commit();
            return ['erro' => '0', 'message' => 'Estoque atualizado com sucesso.'];
        } catch (Exception $e) {
            $conn->rollBack();
            return ['erro' => '1', 'message' => 'Erro ao atualizar estoque: ' . $e->getMessage()];
        }
    }

    public function getCursor()
    {
        if (self::$connected) {
            return ['Erro' => self::$Error, 'Message' => self::$message, 'Data' => self::$cursor];
        } else {
            return ["Erro" => "504", "Message" => "Desconectado"];
        }
    }
}
