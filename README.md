# Implementação Forsign com PHP

Projeto com exemplo de como integrar com a Forsign utilizando a linguagem de programação PHP.

<p align="center">
  <img src="https://uploads-ssl.webflow.com/61fae23dc07bc027c284819a/61faec2e4ec90724adb5eeb5_ForSign-Logotipo_Aurora%20Colorido.png">
</p>

## Índice

- [Recursos Necessários](#recursos-necessários)
- [Estrutura dos Arquivos](#estrutura-dos-arquivos)
- [Setup](#setup)
- [Como Utilizar](#como-utilizar)

## Recursos Necessários

Abaixo, o que você vai precisar para rodar a aplicação no seu computador:

- [Editor de texto](https://code.visualstudio.com/download) (Recomendado: Visual Studio Code)
- [PHP Intelephense](https://marketplace.visualstudio.com/items?itemName=bmewburn.vscode-intelephense-client) (Recomendado - Extensão para Visual Studio Code)
- [PHP](https://www.php.net/downloads.php) (Versão mínima recomendada: 8.0.9)
- [Docker](https://docs.docker.com/get-docker/) (Opcional - Com o Docker, não há necessidade de instalação do PHP)
- [Docker](https://marketplace.visualstudio.com/items?itemName=ms-azuretools.vscode-docker) (Extensão para Visual Studio Code)
- [API da Forsign](https://api.forsign.digital/swagger/index.html) (Exemplos de requisições e respostas da API)

## Estrutura dos Arquivos

```text
.
├── docker (Configurações do docker)
│   ├── docker-compose.yaml
├── app (Aplicativo de exemplo com o PHP)
│   ├── api (Arquivos que repesentam a API da Forsign)
│   ├── images (Imagens utilizadas no aplicativo)
│   ├── template (Arquivos do template do aplicativo)
│   ├── styles (Arquivos de estilização do aplicativo)
│   ├── utils (Aruqivos com funções úteis para usar no aplicativo)
│   ├── _variables.php (Variáveis utilizadas no aplicativo)
│   ├── Dockerfile (Configurações do docker)
│   ├── home.php (Página após o usuário se autenticar)
│   ├── index.php (Página de login)
│   └── logout.php (Página que encerra a sessão do usuário)
├── compose.yaml (Configurações do docker)
└── README.md (Descritivo do projeto)
```

## Setup

Para utilizar o aplicativo de exemplo, basta instalar em seu computador os [Recursos Necessários](#recursos-necessários) informados acima.

## Como Utilizar

### Utilizando o PHP instalado no computador ou servidor

Copie todo o conteúdo da pasta `app` e cole dentro do diretório onde o PHP estará rodando. Depois basta acessar a URL configurada no PHP.

### Utilizando o Docker

Após instalar o docker em seu computador e o mesmo estiver em execução, abra o terminal e execute o comando `docker compose up -d`.

Após executar o comando acima, será criado o container e imagem para o aplicativo de exemplo.

Após a criação do container e a imagem, deverá aparecer a seguinte informação no terminal:

```bash
[+] Running 1/1
 ✔ Container NOME DA IMAGEM Started
 ```

Em seguida a aplicação será inicializada e estará disponível na URL <http://localhost:80>.

Para parar a aplicação, execute o `docker compose down`.
