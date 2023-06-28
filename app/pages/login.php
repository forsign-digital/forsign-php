<?php
// Função p/ chamar API de autenticação
require_once "api/authentication.php";
// Função p/ chamar API com dados do usuário
require_once "api/accounts.php";
// Funcoes úteis para dados da API
require_once "api/utils.php";
// Funções úteis - Verificar se o usuário está autenticado
require_once "utils/auth.php";
// Funções úteis - Exibir mensagem de erro
require_once "utils/template.php";
// Título da página
$page_title = "Acessar API";
// Mensagem de erro
$error_message = "";

// Verifica se o form de login foi submetido
if (isset($_POST["submit"])) {
    session_start();

    // Recupera dados de login/senha do formulário
    $username = $_POST["email"];
    $password = $_POST["password"];

    // Chamada da API de autenticação
    $response = apiAuthenticationSignIn($username, $password);

    // Verifica se a resposta da API foi bem sucedida
    if ($response->success) {
        // Gravar autenticação do usuário
        utilsAuthSetAuthentication($response);

        // Token para recuperar dados do usuário
        $token = $response->data->token_type . " " . $response->data->access_token;
        // Recupera dados o usuário da API
        $user = apiAccountsAccountInfo($token);

        // Se os dados da API foram recuperados, inclui na sessão
        if (isset($user)) {
            utilsAuthSetUser($user->data);
        }

        // Redireciona usuário p/ home logada
        utilsTemplateRedirect('/login-workspace.php');
    } else {
        $error_message = apiUtilsGetMessages($response);
    }
}

// Verifica se o usuário já está autenticado, então redireciona p/ página logada
if (utilsAuthIsAuthenticated()) {
    utilsTemplateRedirect('/login-workspace.php');
}
?>

<?php require_once 'template/header.php'; ?>

<link href="/styles/login.css" rel="stylesheet" />

<main class="form-signin text-center">
    <form action="/" method="POST">
        <a href="/"><img class="mb-4" src="/images/logo.svg" alt="Logo" width="160" /></a>

        <h1 class="h3 mb-3 fw-normal">Acessar API</h1>

        <div class="form-floating">
            <input type="email" name="email" required class="form-control" id="inputEmail" placeholder="name@example.com">
            <label for="inputEmail">Endereço de e-mail</label>
        </div>
        <div class="form-floating">
            <input type="password" name="password" required class="form-control" id="inputPassword" placeholder="Password">
            <label for="inputPassword">Senha</label>
        </div>

        <button type="submit" name="submit" class="w-100 btn btn-lg btn-secondary">Entrar</button>
    </form>

    <?php
    // Exibe a mensagem de erro
    utilsTemplateAlert($error_message, "danger")
    ?>
</main>

<?php require_once 'template/footer_template.php'; ?>
<?php require_once 'template/footer.php'; ?>