<?php

/**
 * Monta requisição da API, efetua a chamada e devolve os dados
 * @param {(POST|PUT|GET|etc)} $method - Método da requisição
 * @param {string} $url - URL que será feita a requisição
 * @param {mixed} $data - Dados que serão enviados para a requisição.
 * @param {mixed} $data - Exemplo: array("param" => "value") ==> index.php?param=value
 * @param {string} $token - Token de autenticação para efetuar a requisição
 * @return {object} - Retorno da API
 */
function apiUtilsCallApi($method, $url, $data, $token = '')
{
    $curl = curl_init();
    $headers = array('Accept: application/json', 'Content-Type: application/json');

    if (!empty($token)) {
        array_push($headers, "Authorization: " . $token);
    }

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

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

    $response = curl_exec($curl);

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
