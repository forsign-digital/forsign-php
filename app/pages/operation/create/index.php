<?php
require_once 'utils/auth.php';
require_once 'utils/template.php';

require_once 'api/operation.php';

// Título da página
$page_title = "Criar Operação";
// Mensagem de erro
$error_message = "";

// Verifica se o usuário está logado. Se não estiver, redireciona p/ login
if (!utilsAuthIsAuthenticated()) {
    utilsTemplateRedirect('/');
}

// Dados da operação
$step = 0;
$operation_name = '';
$operation_files = array();
$operation_members_quantity = 1;
$operation_members = (object)[];

$operation_language = '';
$operation_member_movement_warning = '';
$operation_display_cover = '';
$operation_optional_message = '';

// Recebe dados do formulário e armazena
// Recebe step
if (isset($_POST["step"])) {
    $step = intval($_POST["step"]);
} elseif (isset($_POST['current-step'])) {
    $step = intval($_POST["current-step"]);
}
// Recebe nome da operação
if (isset($_POST["operation-name"])) {
    $operation_name = $_POST["operation-name"];
} elseif (isset($_POST["name"])) {
    $operation_name = $_POST["name"];
}
// Recebe arquivos para a criação da operação
if (isset($_POST["files"]) && strlen($_POST["files"]) > 10) {
    $operation_files = json_decode(urldecode($_POST['files']));
} elseif (isset($_FILES["operation-files"])) {
    $files = $_FILES["operation-files"];
    $files_id = array();
    // Aqui é feito o upload dos arquivos e os ID's dos arquivos serão
    // utilizados posteriormente para a criação da operação.
    $callback_files = apiOperationUploadFiles($files);
    if (isset($callback_files->success) && isset($callback_files->data->filesId)) {
        $files_id = $callback_files->data->filesId;
    } else {
        $error_message = apiUtilsGetMessages($callback_files);
    }

    // Converte os arquivos para base64 para exibir em tela no step 2
    // e armazena os ID's dos uploads
    for ($i = 0; $i < count($files['name']); $i++) {
        $data = file_get_contents($files['tmp_name'][$i]);
        $base64 = base64_encode($data);
        $object = (object)[
            'name' => $files['name'][$i],
            'type' => $files['type'][$i],
            'size' => $files['size'][$i],
            'base64' => $base64,
        ];

        if (isset($files_id[$i])) {
            $object->id = $files_id[$i];
        }

        array_push($operation_files, $object);
    }
}
// Recebe quantos participantes a operação terá
if (isset($_POST["operation-members-quantity"])) {
    $operation_members_quantity = intval($_POST["operation-members-quantity"]);
}
// Recebe nomes dos participantes
if (isset($_POST["operation-member-name"])) {
    $operation_members->name = $_POST["operation-member-name"];
}
// Recebe e-mails dos participantes
if (isset($_POST["operation-member-email"])) {
    $operation_members->email = $_POST["operation-member-email"];
}
// Recebe telefones dos participantes
if (isset($_POST["operation-member-phone"])) {
    $operation_members->phone = $_POST["operation-member-phone"];
}
// Recebe funções dos participantes
if (isset($_POST["operation-member-role"])) {
    $operation_members->role = $_POST["operation-member-role"];
}
// Recebe canais de notificação dos participantes
if (isset($_POST["operation-member-notification-channel"])) {
    $operation_members->notificationChannel = $_POST["operation-member-notification-channel"];
}
// Recebe tipos de assinatura dos participantes
if (isset($_POST["operation-member-signature"])) {
    $operation_members->signatureType = $_POST["operation-member-signature"];
}
// Recebe tipos de autenticação dos participantes
if (isset($_POST["operation-member-authentication"])) {
    $operation_members->authenticationChannel = $_POST["operation-member-authentication"];
}
// Recebe tipos de anexos dos participantes
if (isset($_POST["operation-member-attachments"])) {
    $operation_members->attachments = $_POST["operation-member-attachments"];
}
// Codifica dados dos participantes para armazenar em input
if (!isset($_POST["operation-member-name"]) && !isset($_POST["operation-member-email"]) && isset($_POST["members"])) {
    $operation_members = json_decode(urldecode($_POST["members"]));
}

// Recebe idioma de preferência
if (isset($_POST["operation-language"])) {
    $operation_language = $_POST["operation-language"];
} elseif (isset($_POST["language"])) {
    $operation_language = $_POST["language"];
}
// Recebe avisos sobre movimentação dos participantes
if (isset($_POST["operation-member-movement-warning"])) {
    $operation_member_movement_warning = $_POST["operation-member-movement-warning"];
} elseif (isset($_POST["language"])) {
    $operation_member_movement_warning = $_POST["member-movement-warning"];
}
// Recebe exibir capa antes do início da operação
if (isset($_POST["operation-display-cover"])) {
    $operation_display_cover = $_POST["operation-display-cover"];
} elseif (isset($_POST["language"])) {
    $operation_display_cover = $_POST["display-cover"];
}
// Recebe mensagem personalizada
if (isset($_POST["operation-optional-message"])) {
    $operation_optional_message = $_POST["operation-optional-message"];
} elseif (isset($_POST["language"])) {
    $operation_optional_message = $_POST["optional-message"];
}

// Monta payload e cria operação
if (isset($_POST["step"]) && $_POST["step"] === 'create') {
    // Recupera ID dos arquivos enviados por upload anteriormente
    $files = array();
    foreach ($operation_files as $key => $file) {
        array_push($files, (object)['id' => $file->id, 'description' => $file->name]);
    }

    // Dados dos participantes que vão assinar a operação
    $attachments = isset($operation_members->attachments) ? array_map(fn ($attach) => json_decode(urldecode($attach)), $operation_members->attachments) : [];
    $members = array(
        (object)[
            'name' => $operation_members->name,
            'email' => $operation_members->email,
            'phone' => $operation_members->phone,
            'role' => $operation_members->role,
            'notificationChannel' => $operation_members->notificationChannel,
            'signatureType' => $operation_members->signatureType,
            'authenticationChannel' => $operation_members->authenticationChannel,
            'attachments' => $attachments
        ]
    );

    // Monta payload para criar operação
    $payload = (object)[
        'files' => $files,
        'name' => $operation_name,
        'members' => $members,
        'language' => $operation_language,
        'memberMovementWarning' => $operation_member_movement_warning === 'true',
        'displayCover' => $operation_display_cover === 'true',
        'optionalMessage' => $operation_optional_message,
    ];

    // Envia dados para criar operação
    $callback = apiOperationCreate($payload);

    if (isset($callback->success)) {
        $id = $callback->data->data->id;
        utilsTemplateRedirect('/operation-create-success.php?id=' . $id);
    } else {
        $error_message = 'Erro ao criar a operação: ' . join(
            ', ',
            array_map(
                fn ($message) => $message->value,
                $callback->messages
            )
        );
        $step = 2;
    }
}

// Passos para criar a operação
$steps = array(
    (object)['name' => 'Documentos e participantes', 'current' => $step === 0],
    (object)['name' => 'Definir e positionar campos', 'current' => $step === 1],
    (object)['name' => 'Revisar e enviar', 'current' => $step === 2],
);
?>

<?php require_once 'template/header.php'; ?>
<?php require_once 'template/header_template.php'; ?>

<link href="/styles/operation-create.scss" rel="stylesheet" />

<main class="container">
    <h1 class="h3 mb-3 fw-normal text-center"><?= $page_title ?></h1>

    <div class="mb-3">
        <?php
        // Exibe a mensagem de erro
        utilsTemplateAlert($error_message, "danger")
        ?>

        <?= getStepper($steps) ?>
    </div>

    <div class="operation-create">
        <form action="" method="post" enctype="multipart/form-data" class="row g-2">
            <input type="hidden" name="current-step" value="<?= $step ?>" />
            <input type="hidden" name="name" value="<?= $operation_name ?>" />
            <input type="hidden" name="files" value="<?= urlencode(json_encode($operation_files)) ?>" />
            <input type="hidden" name="members" value="<?= urlencode(json_encode($operation_members)) ?>" />

            <input type="hidden" name="language" value="<?= $operation_language ?>" />
            <input type="hidden" name="member-movement-warning" value="<?= $operation_member_movement_warning ?>" />
            <input type="hidden" name="display-cover" value="<?= $operation_display_cover ?>" />
            <input type="hidden" name="optional-message" value="<?= $operation_optional_message ?>" />

            <?php
            switch ($step) {
                case 0:
                    require_once 'pages/operation/create/form-documents-participants.php';
                    break;
                case 1:
                    require_once 'pages/operation/create/form-documents-positions.php';
                    break;
                case 2:
                    require_once 'pages/operation/create/form-review-send.php';
                    break;
            }
            ?>
        </form>
    </div>

</main>

<?php require_once 'template/footer_template.php'; ?>
<?php require_once 'template/footer.php'; ?>