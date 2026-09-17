<?php

namespace Model;

use Exception;
use Model\Conexao;

use OpenApi\Attributes\Property;
use PDO;
use PDOException;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "Pets",
    properties: [
        new OA\Property(property: "id", type: "integer"),
        new OA\Property(property: "name", type: "string"),
        new OA\Property(property: "email", type: "string"),
        new OA\Property(property: "password", type: "string", format: "password")
    ]
)]

#[OA\Schema(
    schema: "UserInput",
    required: [ "name", "email", "password" ],
    properties: [
        new OA\Property(property: "name", type: "string", example: "Ana Luisa Santos"),
        new OA\Property(property: "email", type: "string", example: "contato.analuisadev@gmail.com"),
        new OA\Property(property: "password", type: "string", minLength: 8, example: "senhaTeste123@_;a")
    ]
)]

#[OA\Schema(
    schema: "UserUpdateInput",
    properties: [
        new OA\Property(property: "name", type: "string", example: "Ana Luisa Santos"),
        new OA\Property(property: "email", type: "string", example: "ana.l.santos6@ba.docente.senai.br")
    ]
)]

class ModeloPet
{
    private PDO $bancoDados;

    public function __construct()
    {
        $this->db = Conexao::getInstance();
    }

    public function criarPet(string $name, string $email, string $password): int
    {
        try {
            $sql = 'INSERT INTO pets(name, email, created_at, password) VALUES (:name, :email, NOW(), :password)';

            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(":name", $name, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":password", $password, PDO::PARAM_STR);

            $stmt->execute();

            return (int) $this->db->lastInsertId();

        } catch (PDOException $error) {
            error_log($error->getMessage());
            throw new Exception("Erro ao criar usuário");
        }
    }

    public function buscarPet(int $id): ?array
    {
        try {
            //Primeira etapa de segurança - NUNCA mostrar SENHA
            $sql = "SELECT id, name, email, created_at FROM pets WHERE id = :id";

            $stmt = $this->db->prepare($sql);

            $stmt->bindValue(":id", $id, PDO::PARAM_INT);

            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result ?: null;

        } catch (PDOException $error) {
            error_log($error->getMessage());
            throw new Exception("Erro ao ler informações do usuário");
        }
    }

    public function listarPets(): array
    {
        try {
            $sql = "SELECT id, name, email, created_at FROM pets ORDER BY id";

            $stmt = $this->db->query($sql);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $error) {
            error_log($error->getMessage());
            throw new Exception("Erro ao listar usuários");
        }
    }

    public function atualizarPet(int $id, string $name, string $email): bool
    {
        try {
            $sql = "UPDATE pets SET name = :name, email = :email WHERE id = :id";

            $stmt = $this->db->prepare($sql);

            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            $stmt->bindParam(":name", $name, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);

            return $stmt->execute();

        } catch (PDOException $error) {
            error_log($error->getMessage());
            throw new Exception("Erro ao atualizar usuário");
        }
    }

    public function excluirPet(int $id): bool
    {
        try {

            $sql = "DELETE FROM pets WHERE id = :id";

            $stmt = $this->db->prepare($sql);

            $stmt->bindValue(":id", $id, PDO::PARAM_INT);

            $stmt->execute();

            return $stmt->rowCount > 0;

        } catch (PDOException $error) {
            error_log($error->getMessage());
            throw new Exception("Erro ao excluir usuário");
        }
    }

    public function emailExiste(string $email, ?int $excludeId = null): bool
    {
        try {
            $sql = "SELECT id FROM pets WHERE email = :email";

            if ($excludeId !== null) {
                $sql .= " AND id != :excludeId";
            }

            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(":email", $email, PDO::PARAM_STR);

            if ($excludeId !== null) {
                $stmt->bindValue(":excludeId", $excludeId, PDO::PARAM_INT);
            }

            $stmt->execute();

            return $stmt->fetch() !== false;

        } catch (PDOException $error) {
            error_log($error->getMessage());
            throw new Exception("Erro ao verificar e-mail");
        }
    }

}