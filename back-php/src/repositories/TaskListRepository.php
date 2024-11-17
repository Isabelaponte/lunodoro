<?php

require_once(__DIR__ . '/../database/Connection.php');

class TaskListRepository
{

    public static function insertListTaskIntoDatabase($id_list, $id_task)
    {
        try {
            $conn = Connection::getConnection();
            $conn->beginTransaction();
            $stmt = $conn->prepare("INSERT INTO lista_tarefa (id_lista, id_tarefa) VALUES (?, ?)");
            $stmt->execute([$id_list, $id_task]);
            $conn->commit();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            $conn->rollBack();
            throw new Exception("Erro ao associar a tarefa a lista", 500);
        }
    }

    public static function findTasksByList($id_list, $id_user)
    {
        try {
            $conn = Connection::getConnection();
            $stmt = $conn->prepare("
            SELECT t.id, t.nome, t.descricao, t.dt_inicio, t.dt_final, t.status 
            FROM tarefa t 
            INNER JOIN lista_tarefa lt ON t.id = lt.id_tarefa 
            INNER JOIN lista l ON lt.id_lista = l.id 
            WHERE lt.id_lista = ? AND l.id_usuario = ?
        ");
            $stmt->execute([$id_list, $id_user]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new Exception("Erro ao acessar as tarefas da lista", 500);
        }
    }

    public static function findListsByTask($id_task, $id_user)
    {
        try {
            $conn = Connection::getConnection();
            $stmt = $conn->prepare("
            SELECT l.id, l.nome_lista, l.descricao, l.dt_criacao, l.dt_atualizacao 
            FROM lista l 
            INNER JOIN lista_tarefa lt ON l.id = lt.id_lista 
            WHERE lt.id_tarefa = ? AND l.id_usuario = ?
        ");
            $stmt->execute([$id_task, $id_user]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new Exception("Erro ao acessar as listas da tarefa", 500);
        }
    }

    public static function removeListTask($id_list, $id_task)
    {
        try {
            $conn = Connection::getConnection();
            $conn->beginTransaction();
            $stmt = $conn->prepare("DELETE FROM lista_tarefa WHERE id_lista = ? AND id_tarefa = ?");
            $stmt->execute([$id_list, $id_task]);
            $conn->commit();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            $conn->rollBack();
            throw new Exception("Erro ao remover o relacionamento da tarefa com a lista", 500);
        }
    }
}
