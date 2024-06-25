# Bank Management API 🏦💻

Sistema de gestão bancária implementado em PHP, que expõe uma API composta por dois endpoints: `/conta` e `/transacao`. A API permite a criação de contas bancárias e a realização de transações financeiras, aplicando taxas diferenciadas conforme a forma de pagamento escolhida.

## Endpoints 🚀

- `POST /conta`: Cria uma nova conta bancária com um saldo inicial.
- `GET /conta?numero_conta={numero_conta}`: Obtém informações sobre uma conta específica.
- `POST /transacao`: Realiza uma operação financeira (débito, crédito ou Pix) em uma conta existente.

## Formatos de entrada e saída 📝


*POST /conta*

- **Entrada**:
  ```json
  {
    "numero_conta": 234,
    "saldo": 180.37
  }

- **Saída (em caso de sucesso):**
    ```json
    {
      "numero_conta": 234,
      "saldo": 180.37
    }

*HTTP Status: 201 Created*

*GET /conta?numero_conta={numero_conta}*

- **Saída (em caso de sucesso):**
    ```json
    {
      "numero_conta": 234,
      "saldo": 170.07
    }

*HTTP Status: 200 OK*

- **Erro (conta não encontrada):**
    ```json
    {
      "error": "Conta não encontrada"
    }

*HTTP Status: 404 Not Found*

*POST /transacao*

**Entrada:**

    {
      "forma_pagamento": "D",
      "numero_conta": 234,
      "valor": 10
    }

**Saída (em caso de sucesso):**

    {
      "numero_conta": 234,
      "saldo": 170.07
    }

**HTTP Status: 201 Created**

*Erro (saldo insuficiente):*

    {
      "error": "Saldo insuficiente"
    }

*HTTP Status: 404 Not Found*

## Instruções para Execução 🛠️

- PHP 7.4 ou superior instalado
- Clone o repositório: https://github.com/mtrebecca/Bank-Management-Api.git

### Inicie o Servidor PHP:

Execute o servidor PHP embutido: **php -S localhost:8000**

### Testes com curl 🧪 

**Criar uma conta:**

*curl -X POST http://localhost:8000/conta -H "Content-Type: application/json" -d "{\"numero_conta\": 234, \"saldo\": 180.37}"*


**Obter informações de uma conta:**

*curl -X GET "http://localhost:8000/conta?numero_conta=234"*

**Realizar uma transação:**

*curl -X POST http://localhost:8000/transacao -H "Content-Type: application/json" -d "{\"forma_pagamento\": \"D\", \"numero_conta\": 234, \"valor\": 10}"/*
