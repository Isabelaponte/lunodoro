<?php

require_once(__DIR__ . '/../database/Connection.php');
require_once(__DIR__ . '/TaskListRepository.php');

class TaskRepository
{
    public static function insertTaskIntoDatabase($name, $description, $status, $id_list)
    {
        try {
            $conn = Connection::getConnection();
            $conn->beginTransaction();
            
            $stmt = $conn->prepare("INSERT INTO tarefa (nome, descricao, status) VALUES (?, ?, ?)");
            $stmt->execute([$name, $description, $status]);
            
            $id_tarefa = $conn->lastInsertId();
            
            $stmtListaTarefa = $conn->prepare("INSERT INTO lista_tarefa (id_lista, id_tarefa) VALUES (?, ?)");
            $stmtListaTarefa->execute([$id_list, $id_tarefa]);
            
            $conn->commit();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            $conn->rollBack();
            throw new Exception("Erro ao cadastrar tarefa", 500);
        }
    }

    public static function findTaskFromDatabase($id_user, $id_task)
    {
        try {
            $conn = Connection::getConnection();
            
            $stmt = $conn->prepare("
                SELECT t.* 
                FROM tarefa t
                INNER JOIN lista_tarefa lt ON t.id = lt.id_tarefa
                INNER JOIN lista l ON lt.id_lista = l.id
                WHERE t.id = ? AND l.id_usuario = ?
            ");
            $stmt->execute([$id_task, $id_user]);
            
            return $stmt->fetch();
        } catch (PDOException $e) {
            throw new Exception("Erro ao acessar os dados", 500);
        }
    }

    public static function findAllTasksFromDatabase($id_user, $id_taskList)
{
    try {
        $conn = Connection::getConnection();
        
        $stmt = $conn->prepare("
            SELECT t.* 
            FROM tarefa t
            INNER JOIN lista_tarefa lt ON t.id = lt.id_tarefa
            INNER JOIN lista l ON lt.id_lista = l.id
            WHERE l.id_usuario = ? AND l.id = ?
        ");
        $stmt->execute([$id_user, $id_taskList]);

        return $stmt->fetchAll();
    } catch (PDOException $e) {
        throw new Exception("Erro ao acessar os dados: " . $e->getMessage(), 500);
    }
}


    public static function updateTask($id_user, $id_task, $name, $description, $end_date, $status)
    {
        try {
            $conn = Connection::getConnection();
            $conn->beginTransaction();
            
            $stmt = $conn->prepare("
                UPDATE tarefa t
                INNER JOIN lista_tarefa lt ON t.id = lt.id_tarefa
                INNER JOIN lista l ON lt.id_lista = l.id
                SET t.nome = ?, t.descricao = ?, t.dt_final = ?, t.status = ?
                WHERE t.id = ? AND l.id_usuario = ?
            ");
            $stmt->execute([$name, $description, $end_date, $status, $id_task, $id_user]);
            
            $conn->commit();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            $conn->rollBack();
            throw new Exception("Erro ao atualizar a tarefa", 500);
        }
    }

    public static function removeTask($id_user, $id_task)
    {
        try {
            $conn = Connection::getConnection();
            $conn->beginTransaction();
            
            $stmt = $conn->prepare("
                DELETE t
                FROM tarefa t
                INNER JOIN lista_tarefa lt ON t.id = lt.id_tarefa
                INNER JOIN lista l ON lt.id_lista = l.id
                WHERE t.id = ? AND l.id_usuario = ?
            ");
            $stmt->execute([$id_task, $id_user]);
            
            $conn->commit();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            $conn->rollBack();
            throw new Exception("Erro ao remover a tarefa", 500);
        }
    }

    public static function checkTaskCompletionAndCalculateDuration($id_user, $id_task)
    {
        try {
            $conn = Connection::getConnection();
            $conn->beginTransaction();
            $stmt = $conn->prepare("
                SELECT t.dt_inicio, t.dt_final
                FROM tarefa t
                INNER JOIN lista_tarefa lt ON t.id = lt.id_tarefa
                INNER JOIN lista l ON lt.id_lista = l.id
                WHERE t.id = ? AND l.id_usuario = ?
            ");
            $stmt->execute([$id_task, $id_user]);
            $task = $stmt->fetch();
            
            if ($task && $task['dt_final']) {
                $dt_inicio = new DateTime($task['dt_inicio']);
                $dt_final = new DateTime($task['dt_final']);
                $interval = $dt_inicio->diff($dt_final);
                $durationInMinutes = ($interval->days * 24 * 60) + ($interval->h * 60) + $interval->i;

                $updateStmt = $conn->prepare("
                    UPDATE tarefa 
                    SET duracao = ?, status = 'concluida' 
                    WHERE id = ?
                ");
                $updateStmt->execute([$durationInMinutes, $id_task]);
                
                $conn->commit();
                return $durationInMinutes;
            } else {
                $conn->rollBack();
                throw new Exception("Tarefa não concluída ou sem data final definida", 400);
            }
        } catch (PDOException $e) {
            $conn->rollBack();
            throw new Exception("Erro ao calcular a duração da tarefa", 500);
        }
    }
}
