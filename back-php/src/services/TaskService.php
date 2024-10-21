<?php

require_once(__DIR__ . '/../repositories/TaskRepository.php');
require_once(__DIR__ . '/../validators/TaskValidator.php');
require_once(__DIR__ . '/../config/utils.php');

class TaskService
{
    public static function createTask($name, $description, $end_date, $status)
    {
        $errors = TaskValidator::validate($name, $description, $end_date, $status);

        if (!empty($errors)) {
            output(400, ["errors" => $errors]);
        }

        $response = TaskRepository::insertTaskIntoDatabase($name, $description, $end_date, $status);

        if (!$response) {
            throw new Exception("Erro ao cadastrar tarefa", 500);
        }

        return [
            "msg" => "Tarefa criada com sucesso!",
            "data" => [
                "nome" => $name,
                "descricao" => $description,
                "dt_final" => $end_date,
                "status" => $status
            ]
        ];
    }

    public static function getAllTasks($id_user, $id_task)
    {
        $errors = validateIDs($id_user, $id_task);

        if (!empty($errors)) {
            return output(400, ["errors" => $errors]);
        }

        $response = TaskRepository::findTaskFromDatabase($id_user, $id_task);

        if (!$response) {
            throw new Exception("Não existem tarefas associadas a seu usuário", 404);
        }

        return [
            "msg" => "Tarefas encontradas com sucesso!",
            "data" => $response
        ];
    }

    public static function updateTask($task_id, $user_id, $name, $description, $end_date, $status)
    {
        $errors = validateIDs($user_id, $task_id);
        
        if (!empty($errors)) {
            return output(400, ["errors" => $errors]);
        }

        $errors = TaskValidator::validate($name, $description, $end_date, $status);
        
        if (!empty($errors)) {
            return output(400, ["errors" => $errors]);
        }

        $existingTask = TaskRepository::findTaskFromDatabase($user_id, $task_id);

        if (!$existingTask) {
            output(404, ["error" => "Tarefa não encontrada"]);
        }
    
        if (
            $existingTask['nome'] === $name &&
            $existingTask['descricao'] === $description &&
            $existingTask['dt_final'] === $end_date &&
            $existingTask['status'] == $status
        ) {
            output(400, ["errors" => ["Nenhuma alteração foi detectada nos dados da tarefa."]]);
        }
    
        $response = TaskRepository::updateTask($user_id, $task_id, $name, $description, $end_date, $status);
    
        if (!$response) {
            throw new Exception("Erro ao atualizar a tarefa. Tente novamente mais tarde.", 500);
        }
    
        return [
            "msg" => "Tarefa atualizada com sucesso!",
            "data" => [
                "id_usuario" => $user_id,
                "id" => $task_id,
                "nome" => $name,
                "descricao" => $description,
                "dt_final" => $end_date,
                "status" => $status
            ]
        ];
    }
    
    public static function deleteTask($user_id, $task_id)
    {
        $errors = validateIDs($user_id, $task_id);
    
        if (!empty($errors)) {
            return output(400, ["errors" => $errors]);
        }
    
        $response = TaskRepository::removeTask($user_id, $task_id);
    
        if (!$response) {
            throw new Exception("Erro ao remover a tarefa. Tente novamente mais tarde.", 500);
        }
    
        return [
            "msg" => "Tarefa removida com sucesso!",
            "data" => [
                "id_usuario" => $user_id,
                "id" => $task_id
            ]
        ];
    }
}