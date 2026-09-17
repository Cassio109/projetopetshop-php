# Documentação da API - Cadastro de Pets

A documentação foi adicionada usando **OpenAPI 3.0.3** e **Swagger UI**.

## Arquivos

- `docs/openapi.yaml` — especificação OpenAPI da API.
- `docs/swagger.php` — interface visual do Swagger UI.

## Como abrir

Com o projeto rodando em um servidor PHP local, acesse:

`http://localhost/<pasta-do-projeto>/docs/swagger.php`

O Swagger exibirá os endpoints:

- GET `/pets`
- POST `/pets`
- GET `/pets/{id}`
- PATCH `/pets/{id}`
- DELETE `/pets/{id}`

A interface permite visualizar os parâmetros, corpos JSON e respostas documentadas.
