<?php
require_once 'utils/template.php';

// Título da página
$page_title = "Criar operação";
?>

<?php require_once 'template/header.php'; ?>
<?php require_once 'template/header_template.php'; ?>

<main class="container">
    <h1 class="h3 mb-3 fw-normal text-center"><?= $page_title ?></h1>

    <?php
    utilsTemplateAlert('Operação criada com sucesso!', 'success');
    ?>

    <div class="row">
        <div class="col-xs-12 col-sm-4 offset-sm-2 text-center">
            <a href="/operation.php?id=<?= isset($_GET['id']) ? $_GET['id'] : '' ?>" class="btn btn-lg w-100 btn-secondary"><i class="bi bi-file-earmark-text-fill"></i> Ver operação</a>
        </div>
        <div class="col-xs-12 col-sm-4 text-center">
            <a href="/operations.php" class="btn btn-lg w-100 btn-outline-secondary"><i class="bi bi-list"></i> Lista de operações</a>
        </div>
    </div>

</main>

<?php require_once 'template/footer_template.php'; ?>
<?php require_once 'template/footer.php'; ?>