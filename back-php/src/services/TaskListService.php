<?php

require_once(__DIR__ . "/../repositories/TaskListRepository.php");
require_once(__DIR__ . "/../config/utils.php");

class TaskListService
{
    public static function createListTask(TaskList $taskList)
    {
        $errors = validateIDs($taskList->getIdList(), $taskList->getIdTask());

        if (!empty($errors)) {
            output(400, ["errors" => $errors]);
        }

        $response = TaskListRepository::insertListTaskIntoDatabase($taskList->getIdList(), $taskList->getIdTask());

        if (!$response) {
            throw new Exception("Erro ao cadastrar lista", 500);
        }

        return [
            "status" => "success",
            "data" => [
                "id_list" => $taskList->getIdList(),
                "id_task" => $taskList->getIdTask()
            ]
        ];
    }

    public static function getAllTasksByList($id_list, $id_user)
    {
        $errors = validateIDs($id_list, $id_user);

        if (!empty($errors)) {
            output(400, ["errors" => $errors]);
        }

        $response = TaskListRepository::findTasksByList($id_list, $id_user);

        if (!$response) {
            throw new Exception("Não existem tarefas associadas a essa lista", 404);
        }

        return [
            "status" => "success",
            "data" => $response
        ];
    }

    public static function getAllListsByTask($id_task, $id_user)
    {
        $errors = validateIDs($id_task, $id_user);

        if (!empty($errors)) {
            output(400, ["errors" => $errors]);
        }

        $response = TaskListRepository::findListsByTask($id_task, $id_user);

        if (!$response) {
            throw new Exception("Não existem listas associadas a essa tarefa", 404);
        }

        return [
            "status" => "success",
            "data" => $response
        ];
    }
    public static function removeTaskList($id_list, $id_task)
    {
        $errors = validateIDs($id_list, $id_task);

        if (!empty($errors)) {
            output(400, ["errors" => $errors]);
        }

        $response = TaskListRepository::removeListTask($id_list, $id_task);

        if (!$response) {
            throw new Exception("Não existe lista de tarefas associada a esta lista ou tarefa", 404);
        }

        return [
            "status" => "success",
            "data" => $response
        ];
    }
}
