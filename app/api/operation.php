<?php

/**
 * Retorna lista de tipo de anexos para criar uma operação.
 * @return {object} - Retorno da API
 */
function apiOperationAttachmentsTypeGet()
{
    include "_variables.php";
    include_once "api/utils.php";

    $url = $variables_api_url_base . "/attachments-body";
    $token = apiUtilsGetAuthenticationToken();

    return apiUtilsCallApi('GET', $url, null, $token);
}

/**
 * Envia arquivos PDF para criar operação
 * @param {$_FILES} $postFiles - Array de arquivos envidos através de um form
 * @return {object} - Retorno da API com ID's dos arquivos enviados
 */
function apiOperationUploadFiles($postFiles)
{
    include "_variables.php";
    include_once "api/utils.php";

    $url = $variables_api_url_base . "/operation/upload-file";
    $token = apiUtilsGetAuthenticationToken();

    $fields = [];
    $size = 0;

    if (isset($postFiles['name'])) {
        for ($i = 0; $i < count($postFiles['name']); $i++) {
            $size = $size + $postFiles['size'][$i];
            $fields['files[' . $i . ']'] = curl_file_create(
                $postFiles['tmp_name'][$i],
                $postFiles['type'][$i],
                $postFiles['name'][$i]
            );
        }
    }
    return apiUtilsCallApiUpload('POST', $url, $fields, $size, $token);
}

/**
 * Envia dados para criar operação.
 * @param {mixed} $data - Dados para a criação da operação
 * @return {object} - Retorno da API
 */
function apiOperationCreate($data)
{
    include "_variables.php";
    include_once "api/utils.php";

    $url = $variables_api_url_base . "/operation";
    $token = apiUtilsGetAuthenticationToken();

    return apiUtilsCallApi('POST', $url, $data, $token);
}

/**
 * Retorna a lista de operações paginada.
 * @param {int} $pageNumber - Página da paginação
 * @param {int} $pageSize - Ítens por página
 * @param {string} $search - Buscar por operação
 * @return {object} - Retorno da API
 */
function apiOperationsPagined($pageNumber = 1, $pageSize = 10, $search = '')
{
    include "_variables.php";
    include_once "api/utils.php";

    $url = $variables_api_url_base . "/operation/pagined";
    $token = apiUtilsGetAuthenticationToken();
    $data = (object)[
        'pageNumber' => $pageNumber,
        'pageSize' => $pageSize,
        'search' => $search,
    ];

    return apiUtilsCallApi('GET', $url, $data, $token);
}

/**
 * Retorna dados da operação.
 * @param {int} $id - ID da operação
 * @return {object} - Retorno da API
 */
function apiOperationGet($id)
{
    include "_variables.php";
    include_once "api/utils.php";

    $url = $variables_api_url_base . "/operation\/" . $id;
    $token = apiUtilsGetAuthenticationToken();

    return apiUtilsCallApi('GET', $url, null, $token);
}
