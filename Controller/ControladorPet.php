<?php

namespace Controller;

use Model\ModeloPet;

class ControladorPet
{
    private ModeloPet $modelo;

    public function __construct(ModeloPet $modelo)
    {
        $this->modelo = $modelo;
    }

    public function processarRequisicao(string $metodo, ?string $id): void
    {
        switch ($metodo) {
            case 'GET':
                $id ? $this->buscar((int)$id) : $this->listar();
                break;
            case 'POST':
                $this->criar();
                break;
            case 'PUT':
                $this->atualizar((int)$id);
                break;
            case 'DELETE':
                $this->excluir((int)$id);
                break;
            default:
                http_response_code(405);
                echo json_encode(['erro' => 'Método não permitido']);
        }
    }

    private function criar(): void
    {
        $dados = json_decode(file_get_contents('php://input'), true);
        $id = $this->modelo->criarPet($dados['name'], $dados['email'], $dados['password']);
        echo json_encode(['mensagem' => 'Pet criado', 'id' => $id]);
    }

    private function listar(): void
    {
        echo json_encode($this->modelo->listarPets());
    }

    private function buscar(int $id): void
    {
        echo json_encode($this->modelo->buscarPet($id));
    }

    private function atualizar(int $id): void
    {
        $dados = json_decode(file_get_contents('php://input'), true);
        echo json_encode([
            'sucesso' => $this->modelo->atualizarPet($id, $dados['name'], $dados['email'])
        ]);
    }

    private function excluir(int $id): void
    {
        echo json_encode([
            'sucesso' => $this->modelo->excluirPet($id)
        ]);
    }
}
