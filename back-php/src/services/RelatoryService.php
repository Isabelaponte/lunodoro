<?php

require_once(__DIR__ . "/../repositories/RelatoryRepository.php");
require_once(__DIR__ . "/../config/utils.php");

class RelatoryService
{
    public static function getTotalHoursOfFocus($id_task, $id_user)
    {
        $errors = validateIDs($id_task, $id_user);

        if (!empty($errors)) {
            output(400, ["errors" => $errors]);
        }

        $response = RelatoryRepository::getTotalHoursOfFocus($id_task, $id_user);

        if (!$response) {
            throw new Exception("Tarefa não encontrada", 404);
        }

        return [
            "status" => "success",
            "data" => $response
        ];
    }
    
    public static function getCompletedTasksByTypeListInLast7Days($id_user)
    {
        if (!isAValidID($id_user)) {
            output(400, ["errors" => $id_user]);
        }

        $response = RelatoryRepository::getCompletedTasksByTypeListInLast7Days( $id_user);

        if (!$response) {
            throw new Exception("Tarefas não encontradas", 404);
        }

        return [
            "status" => "success",
            "data" => $response
        ];
    }
}