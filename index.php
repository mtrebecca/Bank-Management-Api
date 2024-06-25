<?php

header("Content-Type: application/json");

$request_uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

switch (true) {
    case preg_match('/\/conta/', $request_uri):
        include 'endpoints/conta.php';
        break;
    case preg_match('/\/transacao/', $request_uri):
        include 'endpoints/transacao.php';
        break;
    default:
        http_response_code(404);
        echo json_encode(["error" => "Endpoint não encontrado"]);
        break;
}
