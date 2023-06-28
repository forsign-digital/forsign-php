<?php
require_once 'utils/template.php';
require_once "api/operation.php";

// Título da página
$page_title = "Dados da operação";
// Mensagem de erro
$error_message = "";
// Dados da operação
$operation = (object)[];
$steps = array();

if (isset($_GET['id'])) {
    $callback = apiOperationGet($_GET['id']);

    if ($callback->success) {
        $operation = $callback->data;
        $steps = array_map(
            fn ($step) => (object)[
                'name' => $step->name,
                'value' => $step->value,
                'completed' => $step->completed
            ],
            $operation->timeLine->steps
        );
    } else {
        $error_message = apiUtilsGetMessages($callback);
    }
} else {
    $error_message = "ID da operação não informado";
}


?>

<?php require_once 'template/header.php'; ?>
<?php require_once 'template/header_template.php'; ?>

<main class="container">
    <h1 class="h3 mb-3 fw-normal text-center"><?= $page_title ?></h1>

    <?php
    // Exibe a mensagem de erro
    utilsTemplateAlert($error_message, 'danger');
    ?>

    <?php if (isset($operation->id)) { ?>
        <div class="mb-3"><?= getStepper($steps) ?></div>
    <? } ?>

    <div class="row">
        <div class="col-xs-12">
            <pre><?= json_encode($operation, JSON_PRETTY_PRINT) ?></pre>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-xs-12">
            <a href="/operations.php" class="btn btn-secondary"><i class="bi bi-list"></i> Lista de operações</a>
        </div>
    </div>

</main>

<?php require_once 'template/footer_template.php'; ?>
<?php require_once 'template/footer.php'; ?>