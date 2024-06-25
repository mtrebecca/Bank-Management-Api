<?php

$request_uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

switch ($request_uri) {
    case '/conta':
        include 'endpoints/conta.php';
        break;
    case '/transacao':
        include 'endpoints/transacao.php';
        break;
    default:
        http_response_code(404);
        echo json_encode(["error" => "Endpoint não encontrado"]);
        break;
}
