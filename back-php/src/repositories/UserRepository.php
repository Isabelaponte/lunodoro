<?php

require_once(__DIR__ . '/../database/Connection.php');

class UserRepository
{
    // POST https://lunodoro/usuarios
    public static function insertUserIntoDatabase($name, $email, $password)
    {
        try {
            $conn = Connection::getConnection();
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO usuario (nome_usuario,
             email, senha) VALUES (?, ?, ?)");
            $stmt->execute([$name, $email, $hashedPassword]);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                throw new Exception("Usuário com esse email já cadastrado no sistema", 409);
            }
            throw new Exception("Erro ao cadastrar usuário", 500);
        }
    }

    // GET https://lunodoro/meusDados
    public static function getUserData($email, $password)
    {
        try {
            $conn = Connection::getConnection();
            $stmt = $conn->prepare("SELECT id, nome_usuario, senha, dt_criacao_conta FROM usuario WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();
    
            if ($user && password_verify($password, $user['senha'])) {
                unset($user['senha']);
                return $user;
            }
            throw new Exception("Credenciais inválidas", 401);
        } catch (PDOException $e) {
            throw new Exception("Erro ao acessar os dados", 500);
        }
    }
    
    // POST https://lunodoro/login
    public static function loginUser($email, $password)
    {
        try {
            $conn = Connection::getConnection();
            $stmt = $conn->prepare("SELECT id, nome_usuario, senha,
            dt_criacao_conta FROM usuario WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['senha'])) {
                unset($user['senha']);
                return $user;
            }
            return null;
        } catch (PDOException $e) {
            throw new Exception("Erro ao acessar os dados", 500);
        }
    }
}
