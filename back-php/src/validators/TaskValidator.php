<?php

class TaskValidator
{
    public static function validate($name, $description, $status)
    {
        $errors = [];

        if (empty($name) || !is_string($name)) {
            $errors[] = "O nome da tarefa deve ser uma string não vazia.";
        }

        if (!is_string($description)) {
            $errors[] = "A descrição deve ser uma string.";
        }

        $validStatuses = ['em processo', 'concluida', 'lista vazia'];
        if (!in_array($status, $validStatuses)) {
            $errors[] = "O status deve ser um dos seguintes: " . implode(', ', $validStatuses) . ".";
        }


        return $errors;
    }

    private static function validateDate($date)
    {
        $d = DateTime::createFromFormat('Y-m-d H:i:s', $date);
        return $d && $d->format('Y-m-d H:i:s') === $date;
    }
}
