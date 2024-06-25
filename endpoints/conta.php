<?php

$contas = [];

function criarConta($data) {
    global $contas;

    $numero_conta = $data['numero_conta'];
    $saldo = $data['saldo'];

    if (isset($contas[$numero_conta])) {
        http_response_code(400);
        echo json_encode(["error" => "Conta já existe"]);
        return;
    }

    $contas[$numero_conta] = [
        'numero_conta' => $numero_conta,
        'saldo' => floatval($saldo)
    ];

    http_response_code(201);
    echo json_encode($contas[$numero_conta]);
}

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        criarConta($data);
        break;
    default:
        http_response_code(405);
        break;
}
