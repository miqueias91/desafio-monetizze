# Desafio Técnico - API de Sorteios de Loteria

<p align="center">
  <a href="https://www.php.net/releases/8.3/pt_BR.php"><img src="https://img.shields.io/badge/php-8.3-df9049?style=for-the-badge" alt="Versão do PHP"></a>
</p>

Este repositório contém a solução para o desafio técnico que consiste em criar uma API para sorteios de brindes para nossos tripulantes.

## 💻 Pré-requisitos

Antes de começar, certifique-se que você atendeu aos seguintes requisitos:

- Você instalou a versão mais recente do [Docker](https://docs.docker.com/get-docker/) e [Docker Compose](https://docs.docker.com/compose/install/).
- Você está utilizando um sistema operacional Linux. Recomendamos o uso do [Ubuntu](https://ubuntu.com/download) devido à sua estabilidade e facilidade de uso.

## 🚀 Instalação

Para executar a API, siga os passos abaixo:

1. Clone o repositório:
  ```
   git clone https://github.com/miqueias91/desafio-monetizze.git
   cd desafio-monetizze
```

2. Construa a imagem Docker:
```
docker build --pull --rm -f "Dockerfile" -t sorteios-loteria:latest "."
```

3. Execute o Docker Compose para iniciar os serviços:
```
docker-compose up -d --build
```

## ☕ Usando a API

A API será disponibilizada na porta [8000](http://localhost:8000/). Recomendamos o uso do [Bruno HTTP Client](https://www.usebruno.com/) para consumir a API.

Na pasta `collection`, você encontrará uma coleção de requests que podem ser utilizadas no Bruno HTTP Client. Isso facilitará a interação com a API e permitirá que você teste as funcionalidades de maneira eficiente.

Exemplos de Uso:
- GET /loteria/listar: Retorna todos os bilhetes gerados.
- POST /loteria/solicitar: Cria novos bilhetes para um tripulante.
- GET /loteria/resultado: Retorna o resultado do sorteio.

## 📝 Rodando testes

Os testes podem ser executados utilizando o [Pest](https://pestphp.com/).

1. Entre no container:
```
docker exec -it api-php bash
```

2. Rode os testes:
```
./vendor/bin/pest tests/  
```

## 💻 Tecnologias

- [Composer](https://getcomposer.org/)
- [Git](https://git-scm.com/)
- [Docker](https://www.docker.com/)