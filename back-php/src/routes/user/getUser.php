<?php

session_start();

require_once(__DIR__. '../../../models/User.php');
require_once(__DIR__. '../../../database/Connection.php');
require_once(__DIR__. '../../../validators/MethodValidator.php');
require_once(__DIR__. '../../../validators/UserValidator.php');

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

if (validatorMethodServer('GET')) {
    $email = $_GET['email'] ?? null;
    $password = $_GET['password'] ?? null;

    if ($email && $password) {
        $errors = UserValidator::validateLogin($email, $password);

        if (!empty($errors)) {
            http_response_code(400);
            echo json_encode(['errors' => $errors]);
            exit;
        }

        try {
            $conn = Connection::getConnection();
            $stmt = $conn->prepare("SELECT id, nome_usuario, email FROM usuario WHERE email = ? AND senha = ?");
            $stmt->execute([$email, $password]);
            $user = $stmt->fetch();

            if ($user) {
                $_SESSION['nome_usuario'] = $user['nome_usuario'];
                header('Location: ../../../../pages/home.php');
                exit;
                // http_response_code(200);
                // echo json_encode([
                //     'user' => [
                //         'id' => $user['id'],
                //         'name' => $user['nome_usuario'],
                //         'email' => $user['email'],
                //     ]
                // ]);
            } else {
                http_response_code(401);
                echo json_encode(['error' => 'Email ou senha inválidos']);
            }
        } catch (PDOException $exception) {
            http_response_code(500);
            echo json_encode(['error' => 'Erro ao acessar os dados']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Email e senha são obrigatórios']);
    }
}
