<?php
class UserValidator {
    public static function validate($nome, $email, $senha) {
        $errors = [];

        if (empty($nome)) {
            $errors[] = "Nome é obrigatório.";
        }

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email inválido.";
        }

        if (empty($senha)) {
            $errors[] = "Senha é obrigatória.";
        }

        return $errors;
    }
}