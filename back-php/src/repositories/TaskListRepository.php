<?php

require_once(__DIR__ . '/../database/Connection.php');

class TaskListRepository
{

    //POST https://lunodoro/usuarios/{id_usuario}/listas/{id_lista}/tarefas
    public static function insertListTaskIntoDatabase($id_lista, $id_tarefa)
    {
        try {
            $conn = Connection::getConnection();
            $conn->beginTransaction();
            $stmt = $conn->prepare("INSERT INTO lista_tarefa (id_lista, id_tarefa) VALUES (?, ?)");
            $stmt->execute([$id_lista, $id_tarefa]);
            $conn->commit();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            $conn->rollBack();
            throw new Exception("Erro ao associar a tarefa a lista", 500);
        }
    }

    // GET https://lunodoro/usuarios/{id_usuario}/listas/{id_lista}/tarefas
    public static function findTasksByList($id_lista, $id_usuario)
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
            $stmt->execute([$id_lista, $id_usuario]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new Exception("Erro ao acessar as tarefas da lista", 500);
        }
    }

    //GET https://lunodoro/usuarios/{id_usuario}/tarefas/{id_tarefa}/listas
    public static function findListsByTask($id_tarefa, $id_usuario)
    {
        try {
            $conn = Connection::getConnection();
            $stmt = $conn->prepare("
            SELECT l.id, l.nome_lista, l.descricao, l.dt_criacao, l.dt_atualizacao 
            FROM lista l 
            INNER JOIN lista_tarefa lt ON l.id = lt.id_lista 
            WHERE lt.id_tarefa = ? AND l.id_usuario = ?
        ");
            $stmt->execute([$id_tarefa, $id_usuario]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new Exception("Erro ao acessar as listas da tarefa", 500);
        }
    }

    // DELETE https://lunodoro/usuarios/{id_usuario}/listas/{id_lista}/tarefas/{id_tarefa}
    public static function removeListTask($id_lista, $id_tarefa)
    {
        try {
            $conn = Connection::getConnection();
            $conn->beginTransaction();
            $stmt = $conn->prepare("DELETE FROM lista_tarefa WHERE id_lista = ? AND id_tarefa = ?");
            $stmt->execute([$id_lista, $id_tarefa]);
            $conn->commit();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            $conn->rollBack();
            throw new Exception("Erro ao remover o relacionamento da tarefa com a lista", 500);
        }
    }

    // GET https://lunodoro/usuarios/{id_usuario}/listas/{id_lista}/foco
    public static function getTotalHoursOfFocus($id_lista, $id_usuario)
    {
        try {
            $conn = Connection::getConnection();
            $stmt = $conn->prepare("
                SELECT round(SUM(t.duracao), 2) AS tempo_foco 
                FROM lista_tarefa lt
                INNER JOIN tarefa t ON lt.id_tarefa = t.id
                INNER JOIN lista l ON lt.id_lista = l.id
                WHERE l.id = ? AND l.id_usuario = ?
            ");
            $stmt->execute([$id_lista, $id_usuario]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            throw new Exception("Erro ao calcular o tempo de foco", 500);
        }
    }


    // GET https://lunodoro/usuarios/{id_usuario}/tarefas/concluidas/tipos-listas
    public static function getCompletedTasksByTypeListInLast7Days($id_usuario)
    {
        try {
            $conn = Connection::getConnection();
            $stmt = $conn->prepare("
            SELECT tl.descricao AS tipo_lista, COUNT(t.id) AS quantidade_tarefas
            FROM tarefa t
            INNER JOIN lista_tarefa lt ON t.id = lt.id_tarefa
            INNER JOIN lista l ON lt.id_lista = l.id
            INNER JOIN tipo_lista tl ON l.id_tipo_lista = tl.id
            WHERE t.status = 'concluida' 
              AND t.dt_final >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
              AND l.id_usuario = ?
            GROUP BY tl.descricao
        ");
            $stmt->execute([$id_usuario]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new Exception("Erro ao acessar as tarefas efetuadas", 500);
        }
    }
}
