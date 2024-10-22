<?php

class TaskValidator
{
    public static function validate($name, $description, $end_date, $status)
    {
        $errors = [];

        if (empty($name) || !is_string($name)) {
            $errors[] = "O nome da tarefa deve ser uma string não vazia.";
        }

        if (!is_string($description)) {
            $errors[] = "A descrição deve ser uma string.";
        }

        if (!self::validateDate($end_date)) {
            $errors[] = "A data de término deve estar no formato Y-m-d H:i:s.";
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
