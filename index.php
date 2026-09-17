<?php
session_start();
require_once "vendor/autoload.php";

use Model\ModeloPet;
use Controller\ControladorPet;

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$parts = explode("/", $path);

//var_dump($parts);

$resource = $parts[2] ?? null;

$id = $parts[3] ?? null;

header("Content-Type: application/json; charset=UTF-8");

if ($resource !== "pets") {
    http_response_code(404);
    echo json_encode(["error" => "Rota desconhecida!"]);
    exit;
}

try {
    $modeloPet = new ModeloPet();
    $controladorPet = new ControladorPet($modeloPet);

    $controladorPet->processarRequisicao($_SERVER['REQUEST_METHOD'], $id);
} catch (\Throwable $error) {
    error_log($error->getMessage());
    http_response_code(500);
    echo json_encode(["error" => "Erro interno."]);
}