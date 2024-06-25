<?php

function getContas() {
    $contasJson = file_get_contents(__DIR__ . '/../data/contas.json');
    return json_decode($contasJson, true);
}

function saveContas($contas) {
    $contasJson = json_encode($contas, JSON_PRETTY_PRINT);
    file_put_contents(__DIR__ . '/../data/contas.json', $contasJson);
}

function realizarTransacao($data) {
    if (!isset($data['forma_pagamento']) || !isset($data['numero_conta']) || !isset($data['valor'])) {
        http_response_code(400);
        echo json_encode(["error" => "Dados insuficientes"]);
        return;
    }

    $forma_pagamento = $data['forma_pagamento'];
    $numero_conta = $data['numero_conta'];
    $valor = floatval($data['valor']);

    $contas = getContas();

    if (!isset($contas[$numero_conta])) {
        http_response_code(404);
        echo json_encode(["error" => "Conta não encontrada"]);
        return;
    }

    switch ($forma_pagamento) {
        case 'D':
            $taxa = 0.03;
            break;
        case 'C':
            $taxa = 0.05;
            break;
        case 'P':
            $taxa = 0;
            break;
        default:
            http_response_code(400);
            echo json_encode(["error" => "Forma de pagamento inválida"]);
            return;
    }

    $taxaValor = $valor * $taxa;
    $valorTotal = $valor + $taxaValor;

    if ($contas[$numero_conta]['saldo'] < $valorTotal) {
        http_response_code(404);
        echo json_encode(["error" => "Saldo insuficiente"]);
        return;
    }

    $contas[$numero_conta]['saldo'] -= $valorTotal;

    saveContas($contas);

    http_response_code(201);
    echo json_encode($contas[$numero_conta]);
}

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        realizarTransacao($data);
        break;
    default:
        http_response_code(405);
        echo json_encode(["error" => "Método não permitido"]);
        break;
}
