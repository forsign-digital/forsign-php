<?php
include_once 'utils/crypto.php';
require_once "utils/auth.php";
require_once 'utils/template.php';
include_once 'api/company.php';
require_once "api/accounts.php";

// Título da página
$page_title = "Escolha a conta";
// Mensagem de erro
$error_message = "";

if (!utilsAuthIsAuthenticated()) {
    utilsTemplateRedirect('/');
}

// Obter dados da API
$companies = apiCompanyGet();

// Verifica se o form da conta foi submetido
if (isset($_POST['submit'])) {
    // Recupera id da conta a ser logada do formulário
    $id = $_POST['company'];

    // Chamada da API de autenticação
    $response = apiCompanyLoggedIn($id);

    // Verifica se a resposta da API foi bem sucedida
    if ($response->success) {
        // Recupera sessão atual
        $oldAuthentication = json_decode(utilsCryptoDecrypt($_COOKIE['authentication']));
        // Recupera dados da nova sessão
        $newAuthentication = (object) array_merge((array)$oldAuthentication, (array) $response->data);
        // Atualiza sessão
        utilsAuthSetAuthentication((object)['data' => $newAuthentication]);

        // Token para recuperar e atualizar dados do usuário
        $token = $newAuthentication->token_type . " " . $newAuthentication->access_token;
        // Recupera dados o usuário da API
        $user = apiAccountsAccountInfo($token);

        // Se os dados da API foram recuperados, inclui na sessão
        if (isset($user)) {
            $company = utilsTemplateFindObject($newAuthentication->companies, 'id', $id);
            $newUser = (object) array_merge((array)$user->data, array('company' => $company));
            utilsAuthSetUser($newUser);
        }

        // Redireciona usuário p/ home logada
        utilsTemplateRedirect('/home.php');
    } else {
        $error_message = apiUtilsGetMessages($response);
    }
}
?>

<?php require_once 'template/header.php'; ?>
<?php require_once 'template/header_template.php'; ?>

<link href="/styles/home.css" rel="stylesheet" />

<main class="container">
    <h1 class="h3 mb-3 fw-normal text-center"><?= $page_title ?></h1>

    <form action="" method="post" class="row g-2">
        <div class="col-xs-12 col-sm-6 col-md-4 offset-sm-3 offset-md-4">
            <div class="form-group">
                <select class="form-select" name="company" id="inputCompany">
                    <?php
                    if (isset($companies->data)) {
                        foreach ($companies->data as $company) {
                            echo <<<HTML
                                <option value="$company->id">$company->name</option>
                            HTML;
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4 offset-sm-3 offset-md-4 text-center">
            <button type="submit" name="submit" class="btn btn-secondary">Continuar</button>
        </div>
    </form>

    <?php
    // Exibe a mensagem de erro
    utilsTemplateAlert($error_message, "danger");
    ?>

</main>

<?php require_once 'template/footer_template.php'; ?>
<?php require_once 'template/footer.php'; ?>