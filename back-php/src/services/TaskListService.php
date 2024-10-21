<?php

require_once(__DIR__ . '/../repositories/TaskListRepository.php');
require_once(__DIR__ . '/../validators/TaskListValidator.php');
require_once(__DIR__ . '/../config/utils.php');

class TaskListService
{
    public static function createListTask($list_id, $task_id)
    {
        $errors = validateIDs($list_id, $task_id);

        if (!empty($errors)) {
            output(400, ["errors" => $errors]);
        }

        $response = TaskListRepository::insertListTaskIntoDatabase($list_id, $task_id);

        if (!$response) {
            throw new Exception("Erro ao cadastrar lista", 500);
        }

        return [
            "msg" => "Lista criada com sucesso!",
            "data" => [
                "id_lista" => $list_id,
                "id_tarefa" => $task_id
            ]
        ];
    }

    public static function getAllTasksByList($list_id, $user_id)
    {
        $errors = validateIDs($list_id, $user_id);

        if (!empty($errors)) {
            output(400, ["errors" => $errors]);
        }

        $response = TaskListRepository::findTasksByList($list_id, $user_id);

        if (!$response) {
            throw new Exception("Não existem tarefas associadas a essa lista", 404);
        }

        return [
            "msg" => "Tarefas encontradas com sucesso!",
            "data" => $response
        ];
    }

    public static function getAllListsByTask($task_id, $user_id)
    {
        $errors = validateIDs($task_id, $user_id);

        if (!empty($errors)) {
            output(400, ["errors" => $errors]);
        }

        $response = TaskListRepository::findListsByTask($task_id, $user_id);

        if (!$response) {
            throw new Exception("Não existem listas associadas a essa tarefa", 404);
        }

        return [
            "msg" => "Listas encontradas com sucesso!",
            "data" => $response
        ];
    }
    public static function removeTaskList($list_id, $task_id)
    {
        $errors = validateIDs($list_id, $task_id);

        if (!empty($errors)) {
            output(400, ["errors" => $errors]);
        }

        $response = TaskListRepository::removeListTask($list_id, $task_id);

        if (!$response) {
            throw new Exception("Não existe lista de tarefas associada a esta lista ou tarefa", 404);
        }

        return [
            "msg" => "Lista removida com sucesso!",
            "data" => $response
        ];
    }

    public static function getTotalHoursOfFocus($task_id, $user_id)
    {
        $errors = validateIDs($task_id, $user_id);

        if (!empty($errors)) {
            output(400, ["errors" => $errors]);
        }

        $response = TaskListRepository::getTotalHoursOfFocus($task_id, $user_id);

        if (!$response) {
            throw new Exception("Tarefa não encontrada", 404);
        }

        return [
            "msg" => "Tempo de foco calculado com sucesso!",
            "data" => $response
        ];
    }
    
    public static function getCompletedTasksByTypeListInLast7Days($user_id)
    {
        if (!isAValidID($user_id)) {
            output(400, ["errors" => $user_id]);
        }

        $response = TaskListRepository::getCompletedTasksByTypeListInLast7Days( $user_id);

        if (!$response) {
            throw new Exception("Tarefas não encontradas", 404);
        }

        return [
            "msg" => "Tarefas encontradas com sucesso!",
            "data" => $response
        ];
    }
}
