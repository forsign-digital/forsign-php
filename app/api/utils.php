<?php

/**
 * Monta requisição da API, efetua a chamada e devolve os dados
 * @param {(POST|PUT|GET|etc)} $method - Método da requisição
 * @param {string} $url - URL que será feita a requisição
 * @param {mixed} $data - Dados que serão enviados para a requisição.
 * @param {mixed} $data - Exemplo: array("param" => "value") ==> index.php?param=value
 * @param {string} $token - Token de autenticação para efetuar a requisição
 * @param {boolean} $debug - Utilizado para debugar uma requisição
 * @return {object} - Retorno da API
 */
function apiUtilsCallApi($method, $url, $data, $token = '', $debug = false)
{
    $curl = curl_init();
    $headers = array(
        'accept: application/json',
        'content-type: application/json',
        'content-language: pt-br'
    );

    if (!empty($token)) {
        array_push($headers, "authorization: " . $token);
    }

    switch ($method) {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, true);

            if ($data) {
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            }
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, true);
            break;
        default:
            if ($data) {
                $url = sprintf("%s?%s", $url, http_build_query($data));
            }
    }

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    if ($debug) {
        curl_setopt($curl, CURLOPT_VERBOSE, true);
        $streamVerboseHandle = fopen('php://temp', 'w+');
        curl_setopt($curl, CURLOPT_STDERR, $streamVerboseHandle);
    }

    $response = curl_exec($curl);

    if ($debug && $response === false) {
        printf(
            "cUrl error (#%d): %s<br>\n",
            curl_errno($curl),
            htmlspecialchars(curl_error($curl))
        );
    }

    if ($debug) {
        rewind($streamVerboseHandle);
        $verboseLog = stream_get_contents($streamVerboseHandle);
        fclose($streamVerboseHandle);

        echo "cUrl verbose information:\n",
        "<pre>", htmlspecialchars($verboseLog), "</pre>\n";
    }

    curl_close($curl);

    return json_decode($response);
}

/**
 * Monta requisição da API para envio de arquivos, efetua a chamada e devolve os dados
 * @param {(POST|PUT|PATCH)} $method - Método da requisição
 * @param {string} $url - URL que será feita a requisição
 * @param {mixed} $data - Dados que serão enviados para a requisição.
 * @param {mixed} $data - Exemplo: array("param" => "value")
 * @param {string} $token - Token de autenticação para efetuar a requisição
 * @param {boolean} $debug - Utilizado para debugar uma requisição
 * @return {object} - Retorno da API
 */
function apiUtilsCallApiUpload($method, $url, $data, $dataSize, $token = '', $debug = false)
{
    $curl = curl_init();
    $headers = array(
        'accept: application/json',
        'content-type: multipart/form-data',
        'content-language: pt-br'
    );

    if (!empty($token)) {
        array_push($headers, "Authorization: " . $token);
    }

    switch ($method) {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, true);

            if ($data) {
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            }
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, true);
            break;
        default:
            if ($data) {
                $url = sprintf("%s?%s", $url, http_build_query($data));
            }
    }

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_INFILESIZE, $dataSize);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    if ($debug) {
        curl_setopt($curl, CURLOPT_VERBOSE, true);
        $streamVerboseHandle = fopen('php://temp', 'w+');
        curl_setopt($curl, CURLOPT_STDERR, $streamVerboseHandle);
    }

    $response = curl_exec($curl);

    if ($debug && $response === false) {
        printf(
            "cUrl error (#%d): %s<br>\n",
            curl_errno($curl),
            htmlspecialchars(curl_error($curl))
        );
    }

    if ($debug) {
        rewind($streamVerboseHandle);
        $verboseLog = stream_get_contents($streamVerboseHandle);
        fclose($streamVerboseHandle);

        echo "cUrl verbose information:\n",
        "<pre>", htmlspecialchars($verboseLog), "</pre>\n";
    }

    curl_close($curl);

    return json_decode($response);
}

/**
 * Obtém mensagens do retorno da API
 * @param {mixed} $response - Retorno da API
 * @return {stirng} String contendo mensagem devolvida da API
 */
function apiUtilsGetMessages($response)
{
    if (isset($response->messages[0]->value)) {
        return $response->messages[0]->value;
    }

    if (isset($response->data[0]->value)) {
        return $response->data[0]->value;
    }

    if (isset($response->statusCode)) {
        return $response->statusCode;
    }
}

/**
 * Recupera token da sessão para chamada de API's que necessitam de autenticação
 * @return {string} Token de autienticação
 */
function apiUtilsGetAuthenticationToken()
{
    include_once "utils/crypto.php";

    if (!isset($_COOKIE["authentication"])) {
        return '';
    }

    // Recupera autenticação descriptografada
    $authentication = utilsCryptoDecrypt($_COOKIE["authentication"]);
    // Converte de string para objeto
    $json = json_decode($authentication);
    // Concatena tipo de token e token para chamada das demais API's
    return $json->token_type . " " . $json->access_token;
}

/**
 * Formata uma data em JSON p/ o padrão brasileiro
 * @param {stirng} $dateJSON - Data formato JSON
 * @return {stirng} Data formatada 31/12/2000 23:59
 */
function apiUtilsFormatDateTime($dateJSON)
{
    return (date('d/m/Y H:i', strtotime($dateJSON)));
}
