<?php

function getContas() {
    $contasJson = file_get_contents(__DIR__ . '/../data/contas.json');
    return json_decode($contasJson, true);
}

function saveContas($contas) {
    $contasJson = json_encode($contas, JSON_PRETTY_PRINT);
    file_put_contents(__DIR__ . '/../data/contas.json', $contasJson);
}

function criarConta($data) {
    if (!isset($data['numero_conta']) || !isset($data['saldo'])) {
        http_response_code(400);
        echo json_encode(["error" => "Dados insuficientes"]);
        return;
    }

    $numero_conta = $data['numero_conta'];
    $saldo = $data['saldo'];

    $contas = getContas();

    if (isset($contas[$numero_conta])) {
        http_response_code(400);
        echo json_encode(["error" => "Conta já existe"]);
        return;
    }

    $contas[$numero_conta] = [
        'numero_conta' => $numero_conta,
        'saldo' => floatval($saldo)
    ];

    saveContas($contas);

    http_response_code(201);
    echo json_encode($contas[$numero_conta]);
}

function obterConta($numero_conta) {
    $contas = getContas();

    if (!isset($contas[$numero_conta])) {
        http_response_code(404);
        echo json_encode(["error" => "Conta não encontrada"]);
        return;
    }

    http_response_code(200);
    echo json_encode($contas[$numero_conta]);
}

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        criarConta($data);
        break;
    case 'GET':
        if (isset($_GET['numero_conta'])) {
            obterConta($_GET['numero_conta']);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Número da conta não especificado"]);
        }
        break;
    default:
        http_response_code(405);
        echo json_encode(["error" => "Método não permitido"]);
        break;
}
