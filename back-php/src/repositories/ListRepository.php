<?php

require_once(__DIR__ . '/../database/Connection.php');

class ListRepository
{
    public static function insertIntoListFromDatabase($id_user, Listing $list)
    {
        try {
            $conn = Connection::getConnection();
            $conn->beginTransaction();

            $stmt = $conn->prepare("INSERT INTO lista (id_usuario, nome_lista, descricao, id_tipo_lista) VALUES (?, ?, ?, ?)");
            $stmt->execute([
                $id_user,
                $list->getNamelist(),
                $list->getDescription(),
                $list->getID_type_list()
            ]);

            $list->setIdList($conn->lastInsertId());
            $conn->commit();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            $conn->rollBack();
            throw new Exception("Erro ao cadastrar lista: " . $e->getMessage(), 500);
        }
    }

    public static function findAllLists($id_user)
    {
        try {
            $conn = Connection::getConnection();
            $stmt = $conn->prepare("SELECT id as 'id_list', nome_lista as 'name_list', descricao as 'description', 
                                    id_tipo_lista as 'id_type_list', dt_criacao as 'create', dt_atualizacao as 'lastUpdate'
                                    FROM lista WHERE id_usuario = ?");
            $stmt->execute([$id_user]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new Exception("Erro ao acessar os dados: " . $e->getMessage(), 500);
        }
    }

    public static function findListFromDatabase($id_user, $id)
    {
        try {
            $conn = Connection::getConnection();
            $stmt = $conn->prepare("SELECT l.id, l.id_usuario, l.nome_lista, l.descricao, 
                                    l.id_tipo_lista, t.descricao AS tipo_descricao, l.dt_criacao, l.dt_atualizacao 
                                    FROM lista l 
                                    INNER JOIN tipo_lista t ON l.id_tipo_lista = t.id
                                    WHERE l.id_usuario = ? AND l.id = ?");
            $stmt->execute([$id_user, $id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            throw new Exception("Erro ao acessar os dados: " . $e->getMessage(), 500);
        }
    }

    public static function updateList($id_user, Listing $list)
    {
        try {
            $existingList = self::findListFromDatabase($id_user, $list->getIdList());

            if (!$existingList) {
                throw new Exception("Lista não encontrada", 404);
            }

            if (
                $existingList['nome_lista'] === $list->getNamelist() &&
                $existingList['descricao'] === $list->getDescription() &&
                $existingList['id_tipo_lista'] == $list->getID_type_list()
            ) {
                throw new Exception("Nenhuma mudança detectada nos dados da lista.", 400);
            }

            $conn = Connection::getConnection();
            $conn->beginTransaction();

            $stmt = $conn->prepare("UPDATE lista SET nome_lista = ?, descricao = ?, id_tipo_lista = ? 
                                    WHERE id = ? AND id_usuario = ?");
            $stmt->execute([
                $list->getNamelist(),
                $list->getDescription(),
                $list->getID_type_list(),
                $list->getIdList(),
                $id_user
            ]);

            $conn->commit();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            $conn->rollBack();
            throw new Exception("Erro ao atualizar a lista: " . $e->getMessage(), 500);
        }
    }

    public static function removeList($id_user, $id)
    {
        try {
            $existingList = self::findListFromDatabase($id_user, $id);

            if (!$existingList) {
                throw new Exception("Lista não encontrada", 404);
            }

            $conn = Connection::getConnection();
            $conn->beginTransaction();

            $stmt = $conn->prepare("DELETE FROM lista WHERE id_usuario = ? AND id = ?");
            $stmt->execute([$id_user, $id]);

            $conn->commit();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            $conn->rollBack();
            throw new Exception("Erro ao remover a lista: " . $e->getMessage(), 500);
        }
    }
}
