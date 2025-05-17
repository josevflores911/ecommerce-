<?php
require_once ("../classes/cls_connect.php");

class cls_mainpage extends cls_connect {
    static $cursor = null;
    static $connected = false;
    static $conn = null;
    static $Error = '0';
    static $message = "";

    public function __construct() {
        parent::__construct();
        self::$conn = parent::$conn;
    }

    public function getProdutos() {
        if (self::$conn) {
            self::$connected = true;

                   $sql = "
                            SELECT p.id, p.nome, p.preco, e.quantidade
                            FROM produtos p
                            JOIN estoque e ON p.id = e.produto_id
                            WHERE e.quantidade > 0
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

    public function getUsuarioByEmailSenha($email, $senha) {
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

    public function getCursor() {
        if (self::$connected) {
            return ['Erro' => self::$Error, 'Message' => self::$message, 'Data' => self::$cursor];
        } else {
            return ["Erro" => "504", "Message" => "Desconectado"];
        }
    }
}
?>
