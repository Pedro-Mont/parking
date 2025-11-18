# Sistema de Controle de Estacionamento Inteligente

Um sistema robusto e escalável para gestão de estacionamentos, desenvolvido com PHP Puro aplicando rigorosamente os princípios SOLID, KISS e DRY.

## Sobre o Projeto

O Estacionamento do Dev é uma solução completa para calcular tarifas de estacionamento com base no tempo de permanência e tipo de veículo (Carro, Moto, Caminhão).

O diferencial deste projeto não é apenas "funcionar", mas como foi construído. Ele serve como um estudo de caso avançado sobre arquitetura de software limpa sem a dependência de frameworks pesados.

## Destaques Técnicos

Arquitetura em Camadas: Separação clara entre Domínio, Aplicação e Infraestrutura.

Strategy Pattern: O cálculo de preços é modular. Adicionar um novo veículo (ex: "Bicicleta") não exige alterar a classe Calculadora.

Injeção de Dependência: Todo o acoplamento é gerenciado externamente, facilitando testes.

Banco de Dados Leve: Uso de SQLite com PDO e Prepared Statements para segurança e portabilidade.

## Telas e Funcionalidades

1. Cadastro de Entrada

Interface intuitiva para registrar a chegada de veículos. O sistema valida placas e horários automaticamente.

<img width="1693" height="688" alt="image" src="https://github.com/user-attachments/assets/13c6205c-ebf7-45be-8a29-2a8a0f3f3a52" />

2. Dashboard Gerencial

Visão geral do faturamento e fluxo de veículos, com cálculos realizados em tempo real pelo backend.

<img width="1671" height="563" alt="image" src="https://github.com/user-attachments/assets/4587e3b3-9aed-48d6-b74b-fab2af26bcf5" />

## Como Rodar Localmente

Siga os passos abaixo para ter o projeto rodando em sua máquina em minutos.

**Pré-requisitos**

PHP 8.2 ou superior.

Composer instalado.

Instalação

Clone o repositório:
```bash
git clone [https://github.com/seu-usuario/parking.git](https://github.com/seu-usuario/parking.git)
cd parking
```

Instale as dependências:
```bash
composer install
```

Gere o Autoloader otimizado:
```bash
composer dump-autoload -o
```

Configure o Banco de Dados:
Rode o script de migração para criar o arquivo SQLite:
```bash
php migrate.php
```

Saída esperada: "OK: 'database.sqlite' e tabela 'parking_records' criados/atualizados."

Inicie o Servidor:
```bash
composer serve
```

Acesse:
Abra seu navegador em: http://localhost:8000/create.php

# Autores

## Pedro Monteiro Silva 2000328
## Giulio Rafael Nogueira Cruz 1991759
## Jhuan Gustavo Pereira Costa 1993392
