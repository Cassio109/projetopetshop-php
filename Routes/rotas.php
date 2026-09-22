<?php

require_once __DIR__ . '/../Controller/ControladorPet.php';

header("Content-Type: application/json");

$controller = new ControladorPet();

$metodo = $_SERVER['REQUEST_METHOD'];

$id = isset($_GET['id']) ? $_GET['id'] : null;


switch ($metodo) {

    // Listar todos os pets ou buscar por ID
    case 'GET':

        if ($id) {
            $controller->buscarPorId($id);
        } else {
            $controller->listarPets();
        }

        break;


    // Cadastrar novo pet
    case 'POST':

        $dados = json_decode(file_get_contents("php://input"), true);

        $controller->cadastrarPet($dados);

        break;


    // Atualizar dados de um pet
    case 'PUT':

        if (!$id) {
            echo json_encode([
                "erro" => "ID do pet não informado"
            ]);
            break;
        }

        $dados = json_decode(file_get_contents("php://input"), true);

        $controller->atualizarPet($id, $dados);

        break;


    // Deletar pet
    case 'DELETE':

        if (!$id) {
            echo json_encode([
                "erro" => "ID do pet não informado"
            ]);
            break;
        }

        $controller->deletarPet($id);

        break;


    // Caso o método HTTP não exista
    default:

        http_response_code(405);

        echo json_encode([
            "erro" => "Método HTTP não permitido"
        ]);

        break;
}


