<?php

require_once(__DIR__ . '/../validators/UserValidator.php');
require_once(__DIR__ . '/../repositories/UserRepository.php');
require_once(__DIR__ . '/../config/utils.php');
require_once(__DIR__ . '/../NotValidUserException.php');


class UserService
{
    public static function getUser($email, $password)
    {
        $errors = UserValidator::validateLogin($email, $password);

        if (!empty($errors)) {
            output(400, ["errors" => $errors]);
        }

        $user = UserRepository::findUserFromDatabase($email, $password);
        return $user;
    }

    public static function saveUser($email, $password, $name){

        $errors = UserValidator::validate($name, $email, $password);

        if (!empty($errors)) {
            output(400, ["errors" => $errors]);
        }

        $response = UserRepository::insertUserIntoDatabase($name, $email, $password);

        if(!$response){
            throw new Exception("Erro ao cadastrar usuario.", 500);
        }

        return "Usuario criado com sucesso!";
    }
}
