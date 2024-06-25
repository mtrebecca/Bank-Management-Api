<?php

$contas = [];

function realizarTransacao($data) {
    global $contas;

    $forma_pagamento = $data['forma_pagamento'];
    $numero_conta = $data['numero_conta'];
    $valor = $data['valor'];

    if (!isset($contas[$numero_conta])) {
        http_response_code(404);
        echo json_encode(["error" => "Conta não encontrada"]);
        return;
    }

    // Calcula o valor com a taxa correspondente
    switch ($forma_pagamento) {
        case 'D':
            $taxa = 0.03;
            break;
        case 'C':
            $taxa = 0.05;
            break;
        case 'P': // Pix (sem taxa)
            $taxa = 0;
            break;
        default:
            http_response_code(400);
            echo json_encode(["error" => "Forma de pagamento inválida"]);
            return;
    }

    $taxaValor = $valor * $taxa;
    $valorTotal = $valor + $taxaValor;

    // Verifica se há saldo suficiente na conta
    if ($contas[$numero_conta]['saldo'] < $valorTotal) {
        http_response_code(404);
        echo json_encode(["error" => "Saldo insuficiente"]);
        return;
    }

    $contas[$numero_conta]['saldo'] -= $valorTotal;

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
        break;
}
