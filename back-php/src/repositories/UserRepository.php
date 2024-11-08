<?php

require_once(__DIR__ . '/../database/Connection.php');
require_once(__DIR__ . '/../models/User.php');

class UserRepository
{
    
    private static function getConnection()
    {
        return Connection::getConnection();
    }

    public static function create(User $user): int
    {
        try {
            $conn = self::getConnection();
            $conn->beginTransaction();
            
            $hashedPassword = password_hash($user->getPassword(), PASSWORD_BCRYPT);
            $stmt = $conn->prepare("INSERT INTO usuario (nome_usuario, email, senha) VALUES (?, ?, ?)");
            $stmt->execute([$user->getUserName(), $user->getEmail(), $hashedPassword]);
            
            $conn->commit();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            $conn->rollBack();
            self::handleExceptionUser($e, "Erro ao cadastrar usuário");
        }
    }

    public static function findById(int $id): mixed
{
    try {
        $conn = self::getConnection();
        $stmt = $conn->prepare("SELECT id, nome_usuario, email, dt_criacao_conta FROM usuario WHERE id = ?");
        $stmt->execute([$id]);
        $userData = $stmt->fetch();
        
        if ($userData) {
            return new User($userData['email'], $userData['senha'], $userData['nome_usuario'], $userData['dt_criacao_conta']);
        }
        
        return null;
    } catch (PDOException $e) {
        throw new Exception("Erro ao recuperar usuário", 500);
    }
}

    public static function login(User $user): mixed
    {
        try {
            $conn = self::getConnection();
            $stmt = $conn->prepare("SELECT id, senha FROM usuario WHERE email = ?");
            $stmt->execute([$user->getEmail()]);
            $userResponse = $stmt->fetch();

            if ($userResponse && password_verify($user->getPassword(), $userResponse['senha'])) {
                return $userResponse['id'];
            }
            throw new Exception("Usuário ou senha inválidos", 401);
        } catch (PDOException $e) {
            throw new Exception("Erro ao acessar os dados", 500);
        }
    }

    private static function handleExceptionUser(PDOException $e, string $customMessage)
    {
        if ($e->getCode() == 23000) {
            throw new Exception("Email indisponível para uso no sistema.", 409);
        }
        throw new Exception($customMessage, 500);
    }
}