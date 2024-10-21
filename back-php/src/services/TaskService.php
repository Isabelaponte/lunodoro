<?php

require_once(__DIR__ . '/../repositories/TaskRepository.php');
require_once(__DIR__ . '/../validators/TaskValidator.php');
require_once(__DIR__ . '/../config/utils.php');

class TaskService
{
    public static function createTask($name, $description, $end_date, $status, $id_lista)
    {
        $errors = TaskValidator::validate($name, $description, $end_date, $status);

        if (!empty($errors)) {
            return output(400, ["errors" => $errors]);
        }

        $response = TaskRepository::insertTaskIntoDatabase($name, $description, $end_date, $status, $id_lista);

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

    public static function getAllTasks($id_task, $id_usuario)
    {
        $errors = validateIDs($id_task, $id_usuario);

        if (!empty($errors)) {
            return output(400, ["errors" => $errors]);
        }

        $response = TaskRepository::findTaskFromDatabase($id_task, $id_usuario);

        if (!$response) {
            throw new Exception("Tarefa não encontrada", 404);
        }

        return [
            "msg" => "Tarefa encontrada com sucesso!",
            "data" => $response
        ];
    }

    public static function updateTask($task_id, $name, $description, $end_date, $status, $id_usuario)
    {
        $errors = isAValidID($task_id);
        
        if (!empty($errors)) {
            return output(400, ["errors" => $errors]);
        }

        $errors = TaskValidator::validate($name, $description, $end_date, $status);
        
        if (!empty($errors)) {
            return output(400, ["errors" => $errors]);
        }

        $existingTask = TaskRepository::findTaskFromDatabase($task_id, $id_usuario);

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
    
        $response = TaskRepository::updateTask($task_id, $name, $description, $end_date, $status, $id_usuario);
    
        if (!$response) {
            throw new Exception("Erro ao atualizar a tarefa. Tente novamente mais tarde.", 500);
        }
    
        return [
            "msg" => "Tarefa atualizada com sucesso!",
            "data" => [
                "id" => $task_id,
                "nome" => $name,
                "descricao" => $description,
                "dt_final" => $end_date,
                "status" => $status
            ]
        ];
    }
    
    public static function deleteTask($task_id, $id_usuario)
    {
        $errors = validateIDs($task_id, $id_usuario);
    
        if (!empty($errors)) {
            return output(400, ["errors" => $errors]);
        }
    
        $response = TaskRepository::removeTask($task_id, $id_usuario);
    
        if (!$response) {
            throw new Exception("Erro ao remover a tarefa. Tente novamente mais tarde.", 500);
        }
    
        return [
            "msg" => "Tarefa removida com sucesso!",
            "data" => [
                "id" => $task_id
            ]
        ];
    }
}
