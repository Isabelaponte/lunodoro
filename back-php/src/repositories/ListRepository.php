<?php

require_once(__DIR__ . '/../database/Connection.php');

class ListRepository
{

    // POST https://lunodoro/lista
    public static function insertIntoListFromDatabase($id_usuario, $nome_lista, $descricao, $id_tipo_lista)
    {
        try {
            $conn = Connection::getConnection();
            $stmt = $conn->prepare("INSERT INTO lista (id_usuario, nome_lista,
             descricao, id_tipo_lista) VALUES (?, ?, ?, ?)");
            $stmt->execute([
                $id_usuario,
                $nome_lista,
                $descricao,
                $id_tipo_lista
            ]);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            throw new Exception("Erro ao cadastrar lista", 500);
        }
    }

    // GET https://lunodoro/usuarios/{id_usuario}/lista/
    public static function findAllLists($id_usuario)
    {
        try {
            $conn = Connection::getConnection();
            $stmt = $conn->prepare("SELECT id, id_usuario, nome_lista, descricao, 
            id_tipo_lista, dt_criacao, dt_atualizacao 
            FROM lista WHERE id_usuario = ?");
            $stmt->execute([
                $id_usuario
            ]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new Exception("Erro ao acessar os dados", 500);
        }
    }

    // GET https://lunodoro/usuarios/{id_usuario}/lista/{id}
    public static function findListFromDatabase($id_usuario, $id)
    {
        try {
            $conn = Connection::getConnection();
            $stmt = $conn->prepare("SELECT l.id, l.id_usuario, l.nome_lista, l.descricao, 
            l.id_tipo_lista, t.descricao AS tipo_descricao, l.dt_criacao, l.dt_atualizacao 
            FROM lista l 
            INNER JOIN tipo_lista t ON l.id_tipo_lista = t.id
            WHERE l.id_usuario = ? AND l.id = ?");
            $stmt->execute([
                $id_usuario,
                $id
            ]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            throw new Exception("Erro ao acessar os dados", 500);
        }
    }

    // PUT https://lunodoro/usuarios/{id_usuario}/lista/{id}
    public static function updateList($id_usuario, $id, $nome_lista, $descricao, $id_tipo_lista)
    {
        try {
            $existingList = ListRepository::findListFromDatabase($id_usuario, $id);

            if (!$existingList) {
                throw new Exception("Lista não encontrada", 404);
            }

            if (
                $existingList['nome_lista'] === $nome_lista &&
                $existingList['descricao'] === $descricao &&
                $existingList['id_tipo_lista'] == $id_tipo_lista
            ) {
                throw new Exception("Nenhuma mudança detectada nos dados da lista.", 400);
            }

            $conn = Connection::getConnection();
            $stmt = $conn->prepare("UPDATE lista 
                                SET nome_lista = ?, descricao = ?, id_tipo_lista = ? 
                                WHERE id = ? AND id_usuario = ?");
            $stmt->execute([
                $nome_lista,
                $descricao,
                $id_tipo_lista,
                $id,
                $id_usuario
            ]);

            return $stmt->rowCount();
        } catch (PDOException $e) {
            throw new Exception("Erro ao atualizar a lista", 500);
        }
    }


    // DELETE https://lunodoro/usuarios/{id_usuario}/lista/{id}
    public static function removeList($id_usuario, $id)
    {
        try {
            $existingList = ListRepository::findListFromDatabase($id_usuario, $id);

            if (!$existingList) {
                throw new Exception("Lista não encontrada", 404);
            }

            $conn = Connection::getConnection();
            $stmt = $conn->prepare("DELETE FROM lista WHERE id_usuario = ? AND id = ?");
            $stmt->execute([
                $id_usuario,
                $id
            ]);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            throw new Exception("Erro ao remover a lista", 500);
        }
    }
}
