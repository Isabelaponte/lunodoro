<?php

require_once(__DIR__ . '/../database/Connection.php');
require_once(__DIR__. './TaskListRepository.php');

class TaskRepository
{

    // POST https://lunodoro/tarefa
    public static function insertTaskIntoDatabase($nome, $descricao, $dt_final, $status)
    {
        try {
            $conn = Connection::getConnection();
            $stmt = $conn->prepare("INSERT INTO tarefa (nome, descricao, dt_final, status) VALUES (?, ?, ?, ?)");
            $stmt->execute([
                $nome,
                $descricao,
                $dt_final,
                $status
            ]);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            throw new Exception("Erro ao cadastrar tarefa", 500);
        }
    }

    // GET https://lunodoro/usuarios/{id_usuario}/tarefa/{id}
    public static function findTaskFromDatabase($id_usuario, $id)
    {
        try {
            $conn = Connection::getConnection();
            $stmt = $conn->prepare("SELECT * FROM tarefa WHERE id = ? AND id_usuario = ?");
            $stmt->execute([
                $id,
                $id_usuario
            ]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            throw new Exception("Erro ao acessar os dados", 500);
        }
    }

    // PUT https://lunodoro/usuarios/{id_usuario}/tarefa/{id}
    public static function updateTask($id_usuario, $id, $nome, $descricao, $dt_final, $status)
    {
        try {
            $conn = Connection::getConnection();
            $stmt = $conn->prepare('UPDATE tarefa SET nome = ?, descricao = ?, dt_final = ?, status = ? WHERE id = ? AND id_usuario = ?');
            $stmt->execute([
                $nome,
                $descricao,
                $dt_final,
                $status,
                $id,
                $id_usuario
            ]);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            throw new Exception("Erro ao atualizar a tarefa", 500);
        }
    }

    // DELETE https://lunodoro/usuarios/{id_usuario}/tarefa/{id}
    public static function removeTask($id_usuario, $id)
    {
        try {
            $conn = Connection::getConnection();
            $stmt = $conn->prepare("DELETE FROM tarefa WHERE id_usuario = ? AND id = ?");
            $stmt->execute([
                $id_usuario,
                $id
            ]);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            throw new Exception("Erro ao remover a tarefa", 500);
        }
    }

    public static function checkTaskCompletionAndCalculateDuration($id_usuario, $id)
    {
        try {
            $conn = Connection::getConnection();
            $stmt = $conn->prepare("SELECT dt_inicio, dt_final FROM tarefa WHERE id = ? AND id_usuario = ?");
            $stmt->execute([
                $id,
                $id_usuario
            ]);
            $task = $stmt->fetch();

            if ($task && $task['dt_final']) {
                $dt_inicio = new DateTime($task['dt_inicio']);
                $dt_final = new DateTime($task['dt_final']);
                $interval = $dt_inicio->diff($dt_final);
                $durationInMinutes = ($interval->days * 24 * 60) + ($interval->h * 60) + $interval->i;

                $updateStmt = $conn->prepare("UPDATE tarefa SET duracao = ?, status = 'concluída' WHERE id = ? AND id_usuario = ?");
                $updateStmt->execute([
                    $durationInMinutes,
                    $id,
                    $id_usuario
                ]);

                return $durationInMinutes;
            } else {
                throw new Exception("Tarefa não concluída ou sem data final definida", 400);
            }
        } catch (PDOException $e) {
            throw new Exception("Erro ao calcular a duração da tarefa", 500);
        }
    }
}
