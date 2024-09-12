<?php

class FocusTimeValidator
{
    public static function validate($task_id, $duration, $recorded_date, $focus_time_id)
    {
        $errors = [];

        if (!is_int($task_id) || $task_id <= 0) {
            $errors[] = "O ID da tarefa deve ser um número inteiro positivo.";
        }

        if (!is_numeric($duration) || $duration <= 0) {
            $errors[] = "A duração deve ser um número positivo.";
        }

        if (!self::validateDate($recorded_date)) {
            $errors[] = "A data registrada deve estar no formato Y-m-d H:i:s.";
        }

        if (!is_int($focus_time_id) || $focus_time_id <= 0) {
            $errors[] = "O ID do tempo de foco deve ser um número inteiro positivo.";
        }

        return $errors;
    }

    private static function validateDate($date)
    {
        $d = DateTime::createFromFormat('Y-m-d H:i:s', $date);
        return $d && $d->format('Y-m-d H:i:s') === $date;
    }
}
