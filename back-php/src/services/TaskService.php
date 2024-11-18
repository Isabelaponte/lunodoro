<?php

require_once(__DIR__ . '/../repositories/TaskRepository.php');
require_once(__DIR__ . '/../validators/TaskValidator.php');
require_once(__DIR__ . '/../config/utils.php');

class TaskService
{
    public static function createTask(Task $task)
    {
        $errors = TaskValidator::validate($task->getName(), $task->getDescription(), $task->getEndDate(), $task->getStatus());

        if (!empty($errors)) {
            return new InvalidArgumentException("Parâmetros inválidos: " . implode(", ", $errors));
        }

        $response = TaskRepository::insertTaskIntoDatabase($task->getName(), $task->getDescription(), $task->getEndDate(), $task->getStatus(), $task->getListId());

        if (!$response) {
            throw new RuntimeException("Erro ao cadastrar tarefa", 500);
        }

        return [
            "status" => "success",
            "data" => self::formatTaskData($task)
        ];
    }

    public static function getAllTasks(int $id_task, int $id_user)
    {
        $errors = validateIDs($id_task, $id_user);

        if (!empty($errors)) {
            return new InvalidArgumentException("Parâmetros inválidos: " . implode(", ", $errors));
        }

        $response = TaskRepository::findTaskFromDatabase($id_task, $id_user);

        if (!$response) {
            throw new RuntimeException("Tarefa não encontrada", 404);
        }

        return [
            "status" => "success",
            "data" => $response
        ];
    }
    
    public static function updateTask(Task $task, $id_user)
    {
        $errors = validateIDs($task->getId(), $id_user);

        if (!empty($errors)) {
            return new InvalidArgumentException("Parâmetros inválidos: " . implode(", ", $errors));
        }

        $errors = TaskValidator::validate(
            $task->getName(),
            $task->getDescription(),
            $task->getEndDate(),
            $task->getStatus()
        );

        if (!empty($errors)) {
            return new InvalidArgumentException("Parâmetros inválidos: " . implode(", ", $errors));
        }

        $existingTask = TaskRepository::findTaskFromDatabase($id_user, $task->getId());

        if (!$existingTask) {
            output(404, ["error" => "Tarefa não encontrada"]);
        }

        if (self::isTaskUnchanged($existingTask, $task)) {
            throw new RuntimeException("Nenhuma alteração foi detectada nos dados da tarefa.");
        }

        $response = TaskRepository::updateTask(
            $id_user,
            $task->getId(),
            $task->getName(),
            $task->getDescription(),
            $task->getEndDate(),
            $task->getStatus()
        );

        if (!$response) {
            throw new RuntimeException("Erro ao atualizar a tarea. Tente novamente mais tarde.");
        }

        return [
            "status" => "success",
            "data" => self::formatTaskData($task)
        ];
    }

    public static function deleteTask($task_id, $id_usuario)
    {
        $errors = validateIDs($task_id, $id_usuario);

        if (!empty($errors)) {
            return new InvalidArgumentException("Parâmetros inválidos: " . implode(", ", $errors));
        }

        $response = TaskRepository::removeTask($task_id, $id_usuario);

        if (!$response) {
            throw new RuntimeException("Erro ao remover a tarefa. Tente novamente mais tarde.");
        }

        return [
            "status" => "success",
            "data" => [
                "id" => $task_id
            ]
        ];
    }

    private static function formatTaskData(Task $task): array
    {
        return [
            "name" => $task->getName(),
            "description" => $task->getDescription(),
            "end_date" => $task->getEndDate(),
            "status" => $task->getStatus()
        ];
    }

    private static function isTaskUnchanged(array $existingTask, Task $task): bool
    {
        return $existingTask['name'] === $task->getName() &&
            $existingTask['description'] === $task->getDescription() &&
            $existingTask['end_date'] === $task->getEndDate() &&
            $existingTask['status'] == $task->getStatus();
    }
}
