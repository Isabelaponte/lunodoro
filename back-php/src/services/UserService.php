<?php

require_once(__DIR__ . '/../validators/UserValidator.php');
require_once(__DIR__ . '/../repositories/UserRepository.php');
require_once(__DIR__ . '/../models/User.php');
require_once(__DIR__ . '/../config/utils.php');

class UserService
{
    public static function getUser(User $user)
    {
        $errors = UserValidator::validateLogin($user);
        if (!empty($errors)) {
            throw new Exception("Dados inválidos: " . implode(", ", $errors), 400);
        }


        $userResponse = UserRepository::login($user);
        if (!$userResponse) {
            throw new Exception("Usuário ou senha inválidos", 401);
        }

        return self::generateSuccessResponse(["id" => $userResponse]);
    }

    public static function saveUser(User $user)
    {
        $errors = UserValidator::validate($user);
        if (!empty($errors)) {
            throw new Exception("Dados inválidos: " . implode(", ", $errors), 400);
        }

        $response = UserRepository::create($user);
        if ($response <= 0) {
            throw new Exception("Erro ao cadastrar usuário", 500);
        }

        return self::generateSuccessResponse([], "Usuário criado com sucesso!");
    }

    public static function getMyData(int $id)
    {
        $user = UserRepository::findById($id);
        if (!$user) {
            throw new Exception("Usuário não encontrado", 404);
        }

        return self::generateSuccessResponse([
            "email" => $user->getEmail(),
            "name" => $user->getUserName(),
            "dt_account_creation" => $user->getDtAccountCreation()
        ]);
    }

    private static function generateSuccessResponse(array $data = [], string $message = ''): array
    {
        return [
            "status" => "success",
            "message" => $message,
            "data" => $data
        ];
    }
}