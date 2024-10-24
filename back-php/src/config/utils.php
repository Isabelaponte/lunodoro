<?php

// Exemplo: valid("POST", ["id", "nome", "ano"]);
function valid($metodo, $lista)
{
    $obtidos = array_keys($metodo);
    $nao_encontrados = array_diff($lista, $obtidos);
    if (empty($nao_encontrados)) {
        foreach ($lista as $p) {
            if (empty(trim($metodo[$p]))) {
                return false;
            }
        }
        return true;
    }
    return false;
}

// Exemplo: method("PUT");
function method($metodo)
{
    if (!strcasecmp($_SERVER['REQUEST_METHOD'], $metodo)) {
        return true;
    }
    return false;
}

// Exemplo: output(201, ["msg" => "Cadastrado com sucesso"]);
function output($codigo, $msg)
{
    http_response_code($codigo);
    echo json_encode($msg);
    exit;
}

// Retorna os dados parseados (se houver JSON na entrada) ou false.
function handleJSONInput()
{
    try {
        $json = file_get_contents('php://input');
        $json = json_decode($json, true);
        if ($json == null) {
            throw new Exception("JSON não enviado", 0);
        }
        return $json;
    } catch (Exception $e) {
        return false;
    }
}


function isAValidID($id){
   return (filter_var($id, FILTER_VALIDATE_INT) && $id > 0);
}

function validateIDs($first_id, $second_id)
    {
        $errors = [];
    
        if (!isAValidID($first_id) || !isAValidID($second_id)) {
            $errors[] = "Os IDs devem ser números inteiros positivos.";
        }
    
        return $errors;
    }    