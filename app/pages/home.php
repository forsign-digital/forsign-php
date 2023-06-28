<?php
// Funções úteis - verificar se o usuário está autenticado
require_once "utils/auth.php";
// Funções úteis - descriptografa token do usuário
require_once "utils/crypto.php";
// Funções úteis - Redireciona para login se o usuário não estiver autenticado
require_once "utils/template.php";
// Funções úteis para API - Recupera token
require_once "api/utils.php";

// Funções para obter dados da API
require_once "api/accounts.php";
require_once "api/myaccount.php";
require_once "api/company.php";
require_once "api/group.php";

// Título da página
$page_title = "Home";
// Mensagem de erro
$error_message = "";

if (!utilsAuthIsAuthenticated()) {
    utilsTemplateRedirect('/');
}

// Obter dados da API
$authentication = json_decode(utilsCryptoDecrypt($_COOKIE['authentication']));
$user_authenticated = apiAccountsAccountInfo()->data;
$myaccount = apiMyaccountGet()->data;
$users = apiCompanyUser();
$groups = apiGroupGet()->data->items;

if (isset($users->data)) {
    $users = $users->data->items;
} else {
    $users = array();
}
?>

<?php require_once 'template/header.php'; ?>
<?php require_once 'template/header_template.php'; ?>

<link href="/styles/home.css" rel="stylesheet" />

<main class="container">
    <div class="accordion" id="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header" id="heading1">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Sua credencial para acessar endpoints que necessitem de autenticação (endpoint <strong>/api/v1/authentication/sign-in</strong>)
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="heading1" data-bs-parent="#accordion">
                <div class="accordion-body">
                    <?= $authentication->token_type . " " . $authentication->access_token; ?>
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="heading2">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Seus dados pessoais (endpoint <strong>/api/v1/accounts/account-info</strong>)
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#accordion">
                <div class="accordion-body">
                    <?= "<p>
                    <strong>Nome: </strong>" . $user_authenticated->name . "<br>
                    <strong>E-mail: </strong>" . $user_authenticated->email . "<br>
                    <strong>Telefone: </strong>" . $user_authenticated->phoneNumber . "<br>
                    </p>"; ?>
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="heading22">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwoTwo" aria-expanded="false" aria-controls="collapseTwoTwo">
                    Seus dados pessoais (endpoint <strong>/api/v1/myaccount</strong>)
                </button>
            </h2>
            <div id="collapseTwoTwo" class="accordion-collapse collapse" aria-labelledby="heading22" data-bs-parent="#accordion">
                <div class="accordion-body">
                    <?= "<p>
                    <strong>Iniciais: </strong>" . $myaccount->initials . "<br>
                    <strong>Nome: </strong>" . $myaccount->firstName . "<br>
                    <strong>Telefone: </strong>" . $myaccount->phoneNumber . "<br>
                    <strong>País: </strong>" . $myaccount->country . "<br>
                    <strong>Idioma: </strong>" . $myaccount->language . "<br>
                    <strong>Conta atualizada em: </strong>" . $myaccount->updatedAt . "<br>
                    </p>"; ?>
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="heading3">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    Usuários vinculadas a sua empresa (endpoint <strong>/api/v1/company/user</strong>)
                </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#accordion">
                <div class="accordion-body">
                    <?php
                    if (count($users) === 0) {
                        echo "Nenhum usuário encontrado";
                    } else {
                        foreach ($users as $user => $value) {
                            $active = "Não";
                            if ($value->active) $active = "Sim";

                            echo "<p><strong>Nome:</strong> " . $value->firstName .
                                "<br><strong>E-mail:</strong> " . $value->email .
                                "<br><strong>Ativo:</strong> " . $active .
                                "<br><strong>Criado em:</strong> " . $value->createdAt . "</p>";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="heading4">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                    Grupos vinculados a sua empresa (endpoint <strong>/api/v1/group</strong>)
                </button>
            </h2>
            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#accordion">
                <div class="accordion-body">
                    <?php
                    foreach ($groups as $group => $value) {
                        echo "<p><strong>Nome:</strong> " . $value->name . "</p>";
                    }
                    ?>
                </div>
            </div>
        </div>

    </div>
</main>

<?php require_once 'template/footer_template.php'; ?>
<?php require_once 'template/footer.php'; ?>