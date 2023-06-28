<?php
require_once 'utils/template.php';
require_once "api/operation.php";

// Título da página
$page_title = "Operações";
// Mensagem de erro
$error_message = "";
// Lista de operações
$list = (object)[];
// Paginação
$pagination = (object)[
    'totalCount' => 0,
    'totalPages' => 0,
    'currentPage' => isset($_GET['currentPage']) ? $_GET['currentPage'] : 1,
    'pageSize' => isset($_GET['pageSize']) ? $_GET['pageSize'] : 10,
    'hasNext' => false,
    'hasPrevious' => false,
    'search' => isset($_GET['search']) ? $_GET['search'] : ''
];

// Recupera lista de operações
$callback = apiOperationsPagined(
    $pagination->currentPage,
    $pagination->pageSize,
    $pagination->search,
);

if (isset($callback->success)) {
    $data = $callback->data;
    $list = $data->items;
    $error_message = count($list) > 0 ? '' : 'Nenhuma operação encontrada';
    $pagination = (object) array_merge(
        (array) $pagination,
        (array) [
            'totalCount' => $data->totalCount,
            'totalPages' => $data->totalPages,
            'currentPage' => $data->currentPage,
            'pageSize' => $data->pageSize,
            'hasPrevious' => $data->hasPrevious,
            'hasNext' => $data->hasNext,
        ]
    );
} else {
    $error_message = apiUtilsGetMessages($callback);
}

function getPaginationLink($currentPage, $pageSize = 10, $search = '')
{
    return
        '?pageSize=' . $pageSize .
        '&currentPage=' . $currentPage .
        (strlen($search) > 0 ? '&search=' . $search : '');
}
?>

<?php require_once 'template/header.php'; ?>
<?php require_once 'template/header_template.php'; ?>

<main class="container">
    <h1 class="h3 mb-3 fw-normal text-center"><?= $page_title ?></h1>

    <?php
    utilsTemplateAlert($error_message, 'danger');
    ?>

    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Operação</th>
                            <th scope="col">Responsável</th>
                            <th scope="col">Status</th>
                            <th scope="col">Fase</th>
                            <th scope="col">Criado em</th>
                            <th scope="col">Atualizado em</th>
                            <th scope="col">Concluído em</th>
                            <th scope="col">Partiicpantes</th>
                            <th scope="col">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($list as $key => $item) {
                            $createdAt = apiUtilsFormatDateTime($item->createdAt);
                            $updatedAt = apiUtilsFormatDateTime($item->updatedAt);
                            $finishOperationDate = isset($item->finishOperationDate) ? apiUtilsFormatDateTime($item->finishOperationDate) : '-';
                            echo <<<HTML
                                <tr>
                                    <th scope="row">{$item->id}</th>
                                    <td>{$item->name}</td>
                                    <td>{$item->creatorName}</td>
                                    <td>{$item->status}</td>
                                    <td>{$item->stage}</td>
                                    <td>{$createdAt}</td>
                                    <td>{$updatedAt}</td>
                                    <td>{$finishOperationDate}</td>
                                    <td>{$item->quantityMembers}</td>
                                    <td><a href="/operation.php?id=$item->id" class="link-dark h5" title="Visualizar dados da operação"><i class="bi bi-gear"></i></a></td>
                                </tr>
                            HTML;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <nav>
                <ul class="pagination justify-content-center">
                    <li class="page-item <?= $pagination->hasPrevious ? '' : 'disabled' ?>"><a <?= $pagination->hasPrevious ? 'href="' . getPaginationLink($pagination->currentPage - 1, $pagination->pageSize, $pagination->search) . '"' : '' ?> class="page-link">Anterior</a></li>
                    <?php
                    for ($i = 0; $i < $pagination->totalPages; $i++) {
                        $page = $i + 1;
                        $class = '';
                        $href = 'href="' . getPaginationLink($page, $pagination->pageSize, $pagination->search) . '"';
                        if ($pagination->currentPage === $page) {
                            $class = 'active';
                            $href = '';
                        }
                        echo <<<HTML
                            <li class="page-item {$class}"><a {$href} class="page-link">{$page}</a></li>
                        HTML;
                    }
                    ?>
                    <li class="page-item <?= $pagination->hasNext ? '' : 'disabled' ?>"><a <?= $pagination->hasNext ? 'href="' . getPaginationLink($pagination->currentPage + 1, $pagination->pageSize, $pagination->search) . '"' : '' ?> class="page-link">Próxima</a></li>
                </ul>
            </nav>
        </div>
    </div>
</main>

<?php require_once 'template/footer_template.php'; ?>
<?php require_once 'template/footer.php'; ?>