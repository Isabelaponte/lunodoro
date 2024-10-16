<?php

require_once(__DIR__ . '/../database/Connection.php');

class TypeListRepository
{
    // GET https://lunodoro/tipoLista/{descricao}
    public static function findTypeListFromDatabase($descricao)
    {
        try {
            $conn = Connection::getConnection();
            $stmt = $conn->prepare("SELECT id, descricao FROM tipo_lista WHERE descricao = ?");
            $stmt->execute([$descricao]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            throw new Exception("Erro ao acessar os dados", 500);
        }
    }

    // GET https://lunodoro/tipoLista/
    public static function findAllTypeList()
    {
        try {
            $conn = Connection::getConnection();
            $stmt = $conn->prepare("SELECT id, descricao FROM tipo_lista");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new Exception("Erro ao acessar os dados", 500);
        }
    }
}
?>
