# Instruções
[![License](https://img.shields.io/badge/License-MIT-blue.svg)](https://opensource.org/licenses/MIT)
[![Composer](https://img.shields.io/badge/Composer-2.5.8-ff69b4.svg)](https://getcomposer.org/)
[![PHP](https://img.shields.io/badge/PHP-8.1-0077B2.svg)](https://www.php.net/)
[![CodeIgniter](https://img.shields.io/badge/CodeIgniter-4.5.2-ff0000.svg)](https://codeigniter.com/)
[![JWT](https://img.shields.io/badge/JWT-6.10.1-ff69b4.svg)](https://github.com/firebase/php-jwt)

### OBS.: o arquivo `.env` não foi ocultado deste repositório por se tratar de um teste.
### *Um diagrama do banco de dados está disponível no arquivo `diagrama.pdf`*


### Instalação

1. Clone o repositório:
```bash
git clone https://github.com/JeanCSF/teste_backend_l5.git
```

2. Instale as dependências, na raiz do projeto execute o seguinte comando:
```bash
composer install
```

3. Em seu SGDB de preferência rode o script para criação do banco de dados contido no arquivo `l5_api.sql`, caso queira utilizar as migrations do codeigniter crie um banco de dados chamado `l5_api` e execute os seguintes comandos no terminal:

```bash
php spark migrate # Criação das tabelas
php spark db:seed MainSeeder # Inclusão de dados fictícios
```

### Execução

Inicie o servidor, na raiz do projeto execute os seguintes comandos, é importante seguir a ordem:

```bash
cd public
# e depois
php -S localhost:8080 # O número de porta pode ser alterado
```

A aplicação estará disponível em `http://localhost:8080`.

### Documentação
#### Esta aplicação conta com uma documentação interativa, para acessar a documentação é necessário acessar `http://localhost:8080` e efetuar o login, caso tenha utilizado o script SQL para criação do banco de dados, ou as migrations e o seed do codeigniter, um usuário padrão já foi criado com o nome `admin` e a senha `admin`. Caso contrario é possível criar um novo usuário clicando no botão `Cadastrar`, ou utilizar o endpoint `POST /api/signup`. Fique a vontade para testar a API por aqui ou utilizando o cliente de API de sua preferência, abaixo deixo em detalhes os endpoints disponíveis:

### Endpoint: Criação de Usuário

#### POST /api/signup
Este endpoint cria um novo usuário na aplicação.

#### Requisição

Enviar no corpo da requisição os seguintes dados no formato JSON:
- `usuario` (string): Nome de usuário desejado.
- `senha` (string): Senha desejada.

##### Exemplo de Corpo da Requisição:
```json
{
  "usuario": "admin",
  "senha": "admin"
}
```

#### Resposta

Se o usuário for criado com sucesso, a resposta será um objeto JSON com as seguintes informações:

- `status` (integer): Código de status HTTP (201 para criação bem-sucedida).
- `mensagem` (string): Mensagem informando o sucesso da operação.

##### Exemplo de Resposta:
```json
{
  "cabecalho": {
    "status": 201,
    "mensagem": "Usuário criado com sucesso"
  }
}
```

Caso ocorra algum erro, a resposta incluirá um código de status apropriado e uma mensagem de erro relevante.

### Endpoint: Autenticação de Usuário

#### POST /api/login
Este endpoint autentica um usuário na aplicação e retorna um token de autenticação JWT.

#### Requisição

Enviar no corpo da requisição os seguintes dados no formato JSON:
- `usuario` (string): Nome de usuário.
- `senha` (string): Senha do usuário.

##### Exemplo de Corpo da Requisição:
```json
{
  "usuario": "admin",
  "senha": "admin"
}
```

#### Resposta

Se a autenticação for bem-sucedida, a resposta será um objeto JSON com as seguintes informações:

- `status` (integer): Código de status HTTP (200 para sucesso).
- `mensagem` (string): Mensagem confirmando o sucesso do login.
- `token` (string): Token JWT para autenticação de futuras requisições.

##### Exemplo de Resposta:
```json
{
  "cabecalho": {
    "status": 200,
    "mensagem": "Sucesso: Login efetuado com sucesso"
  },
  "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJsb2NhbGhvc3QiLC..."
}
```

### Observação:
Foi necessário criar um sistema de login simples para implementar o token JWT.

### Endpoint: Listagem de Registros

#### POST /api/{rota}
Este endpoint lista todos os registros de uma tabela especificada na rota (clientes, produtos, pedidos).

#### Requisição

Enviar no corpo da requisição os parâmetros opcionais de filtro, paginação e pesquisa no formato JSON:
- `parametros` (object):
  - `limit` (integer): Limite de registros por página (opcional).
  - `page` (integer): Número da página (opcional).
  - `q` (string): Termo de pesquisa (opcional).

##### Exemplo de Corpo da Requisição:
```json
POST /api/clientes
{
  "parametros": {
    "limit": 10,
    "page": 1,
    "q": "empresa"
  }
}
```

#### Resposta

Se a listagem for bem-sucedida, a resposta será um objeto JSON com as seguintes informações:

- `status` (integer): Código de status HTTP (200 para sucesso).
- `mensagem` (string): Mensagem confirmando que os dados foram retornados com sucesso.
- `retorno` (array): Lista dos registros retornados, cada registro contendo:
  - `id` (string): Identificador do registro.
  - `nome_razao` (string): Nome ou razão social.
  - `cpf_cnpj` (string): CPF ou CNPJ.
  - `created_at` (string): Data de criação do registro.
  - `updated_at` (string or null): Data da última atualização do registro.
- `paginacao` (object): Informações de paginação:
  - `pagina` (integer): Número da página atual.
  - `total_registros` (integer): Total de registros encontrados.
  - `total_paginas` (integer): Total de páginas disponíveis.
  - `ultima_pagina` (boolean): Indicador se é a última página.

##### Exemplo de Resposta:
```json
{
  "cabecalho": {
    "status": 200,
    "mensagem": "Dados retornados com sucesso"
  },
  "retorno": [
    {
      "id": "3",
      "nome_razao": "Empresa ABC Ltda",
      "cpf_cnpj": "12345678000190",
      "created_at": "2024-06-22 05:08:16",
      "updated_at": null
    },
    {
      "id": "6",
      "nome_razao": "Empresa XYZ S.A.",
      "cpf_cnpj": "98765432000177",
      "created_at": "2024-06-22 05:08:16",
      "updated_at": null
    }
  ],
  "paginacao": {
    "pagina": 1,
    "total_registros": 2,
    "total_paginas": 1,
    "ultima_pagina": true
  }
}
```

### Endpoint: Criação de Novo Registro

#### POST /api/create/{rota}
Este endpoint cria um novo registro na tabela especificada na rota (cliente, produto, pedido).

#### Requisição

Enviar no corpo da requisição os dados obrigatórios para criar o registro no formato JSON:
- `parametros` (object): Campos obrigatórios para criar o registro, onde os nomes das chaves devem corresponder às colunas da tabela do banco de dados.

##### Exemplo de Corpo da Requisição:
```json
POST /api/create/cliente
{
  "parametros": {
    "nome_razao": "Empresa ABC Ltda",
    "cpf_cnpj": "12345678000190"
  }
}
```

#### Resposta

Se o registro for criado com sucesso, a resposta será um objeto JSON com as seguintes informações:

- `status` (integer): Código de status HTTP (201 para criação bem-sucedida).
- `mensagem` (string): Mensagem informando o sucesso da operação.

##### Exemplo de Resposta:
```json
{
  "cabecalho": {
    "status": 201,
    "mensagem": "Registro criado com sucesso"
  }
}
```

### Endpoint: Ler um Registro Específico

#### POST /api/read/{rota}
Este endpoint retorna um registro específico da tabela especificada na rota (cliente, produtos, pedido).

#### Requisição

Enviar no corpo da requisição os dados obrigatórios para ler o registro no formato JSON:
- `parametros` (object): Campo `id` é obrigatório para retornar o registro, onde os nomes das chaves devem corresponder às colunas da tabela do banco de dados.

##### Exemplo de Corpo da Requisição:
```json
POST /api/read/cliente
{
  "parametros": {
    "id": "1"
  }
}
```

#### Resposta

Se o registro for encontrado com sucesso, a resposta será um objeto JSON com as seguintes informações:

- `status` (integer): Código de status HTTP (200 para sucesso).
- `mensagem` (string): Mensagem informando o sucesso da operação.
- `retorno` (array): Lista com o registro encontrado, contendo:
  - `id` (string): Identificador do registro.
  - `nome_razao` (string): Nome ou razão social.
  - `cpf_cnpj` (string): CPF ou CNPJ.
  - `created_at` (string): Data de criação do registro.
  - `updated_at` (string or null): Data da última atualização do registro.

##### Exemplo de Resposta:
```json
{
  "cabecalho": {
    "status": 200,
    "mensagem": "Dados retornados com sucesso"
  },
  "retorno": [
    {
      "id": "1",
      "nome_razao": "João Silva",
      "cpf_cnpj": "12345678901",
      "created_at": "2024-06-21 16:57:15",
      "updated_at": null
    }
  ]
}
```

### Endpoint: Atualização de Registro

#### POST /api/update/{rota}
Este endpoint atualiza um registro na tabela especificada na rota (cliente, produtos, pedido).

#### Requisição

Enviar no corpo da requisição os dados obrigatórios para atualizar o registro no formato JSON:
- `parametros` (object): Campos obrigatórios para atualizar o registro, deve conter o id do registro que sera atualizado e os nomes das chaves devem corresponder às colunas da tabela do banco de dados.

##### Exemplo de Corpo da Requisição:
```json
POST /api/update/cliente
{
  "parametros": {
    "id": "1",
    "nome_razao": "João Pereira"
  }
}
```

#### Resposta

Se o registro for atualizado com sucesso, a resposta será um objeto JSON com as seguintes informações:

- `status` (integer): Código de status HTTP (200 para atualização bem-sucedida).
- `mensagem` (string): Mensagem informando o sucesso da operação.

##### Exemplo de Resposta:
```json
{
  "cabecalho": {
    "status": 200,
    "mensagem": "Registro atualizado com sucesso"
  }
}
```

### Endpoint: Exclusão de Registro

#### DELETE /api/delete/{rota}/{id}
Este endpoint exclui um registro especifico da tabela especificada na rota (cliente, produtos, pedido).

#### Requisição

Enviar na URL da requisição o id do registro que será excluído.
  - O parametro `id` é obrigatório para excluir o registro

##### Exemplo de Requisição:
```json
DELETE /api/delete/cliente/1
```

#### Resposta

Se o registro for excluído com sucesso, a resposta será um objeto JSON com as seguintes informações:

- `status` (integer): Código de status HTTP (200 para exclusão bem-sucedida).
- `mensagem` (string): Mensagem informando o sucesso da operação.
  
##### Exemplo de Resposta:
```json
{
  "cabecalho": {
    "status": 200,
    "mensagem": "Registro excluído com sucesso"
  }
}
```

## Licença
Este projeto está licenciado sob a [Licença MIT](LICENSE).
