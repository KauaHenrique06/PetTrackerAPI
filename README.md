# PetTrackerAPI

API para gerenciamento e rastreamento de informações de animais de estimação. Permite registrar usuários, pets e suas localizações.

---

## Requisitos para rodar

Para garantir o funcionamento correto da API, você precisará ter instalado em sua máquina:

* **PHP 8.2** ou superior
* **Composer 2.0** ou superior
* **MySql** (ou outro banco de dados suportado pelo Laravel, configurado no `.env`)

## Como executar

Siga os passos abaixo para colocar o projeto em execução em sua máquina local:

1.  **Verifique as dependências:**
    Confirme se as versões do PHP e do Composer estão nas recomendadas:
    ```bash
    php -v
    composer -v
    ```

2.  **Clone o repositório:**
    ```bash
    git clone [https://github.com/KauaHenrique06/PetTrackerAPI.git](https://github.com/KauaHenrique06/PetTrackerAPI.git)
    cd PetTrackerAPI
    ```

3.  **Configuração de ambiente:**
    Copie o arquivo de exemplo de ambiente e o renomeie para `.env`:
    ```bash
    cp .env.example .env
    ```

4.  **Instale as dependências:**
    ```bash
    composer install
    ```

5.  **Gere a chave da aplicação:**
    ```bash
    php artisan key:generate
    ```

6.  **Configure a conexão com o banco de dados:**
    Edite o arquivo `.env` para configurar a conexão com seu banco de dados MySQL.

    **Exemplo de configuração (adaptar conforme seu ambiente):**

    ```dotenv
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=db_pettracker // Nome do banco de dados que você irá criar
    DB_USERNAME=root         // Nome de usuário do seu banco
    DB_PASSWORD=sua_senha    // Senha do seu banco
    ```

7.  **Execute as migrações do banco de dados:**
    Este comando criará todas as tabelas necessárias:
    ```bash
    php artisan migrate
    ```

8.  **Inicie o servidor de desenvolvimento:**
    ```bash
    php artisan serve
    ```
    A API estará acessível em `http://127.0.0.1:8000` (ou outra porta indicada no console).

## Rotas Principais (Exemplos)

A seguir, alguns exemplos de rotas da API e como utilizá-las (assumindo que a API utiliza o Laravel Sanctum ou similar para autenticação via Token):

### Usuários e Autenticação

| Método | Rota | Descrição |
| :--- | :--- | :--- |
| `POST` | `/api/register` | Cria um novo usuário. |
| `POST` | `/api/login` | Autentica um usuário e retorna o token de acesso. |
| `POST` | `/api/logout` | Encerra a sessão do usuário autenticado. |

### Pets (Requer Autenticação)

| Método | Rota | Descrição |
| :--- | :--- | :--- |
| `POST` | `/api/pets` | Cria um novo pet associado ao usuário. |
| `GET` | `/api/pets` | Lista todos os pets do usuário autenticado. |
| `GET` | `/api/pets/{id}` | Retorna os detalhes de um pet específico. |
| `PUT` | `/api/pets/{id}` | Atualiza os dados de um pet. |
| `DELETE` | `/api/pets/{id}` | Exclui um pet. |

**Exemplo de Requisição POST para criar um Pet (`/api/pets`):**

```json
{
  "name": "Rex",
  "species": "Cachorro",
  "race": "Golden Retriever",
  "birth_date": "2020-01-01"
}
```

### Rastreamento de Localização

Esta seção lida com o registro e consulta das coordenadas geográficas dos pets.

#### Registrar uma Nova Localização

* **Rota:** `POST /api/pets/{id}/location`
* **Função:** Usado para um dispositivo (coleira, app) registrar a posição mais recente do pet.
* **Requer:** Autenticação e o ID do Pet na URL.
* **Corpo da Requisição (JSON):**

    ```json
    {
      "latitude": -23.55052,
      "longitude": -46.63330
    }
    ```

#### Consultar o Histórico de Localizações

* **Rota:** `GET /api/pets/{id}/locations`
* **Função:** Retorna o histórico de localizações para plotagem em um mapa.
* **Requer:** Autenticação e o ID do Pet na URL.

**Parâmetros de Consulta Opcionais (Query Strings):**

| Parâmetro | Exemplo | Descrição |
| :--- | :--- | :--- |
| `since` | `?since=2025-12-10` | Filtra localizações a partir de uma data específica. |
| `limit` | `?limit=50` | Limita o retorno às `N` localizações mais recentes. |
