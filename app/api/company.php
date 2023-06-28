<?php

/**
 * Retorna informações da empresa do usuáiro logado no sistema.
 * @return {object} - Retorno da API
 */
function apiCompanyGet()
{
    include "_variables.php";
    include_once "api/utils.php";

    $url = $variables_api_url_base . "/company";
    $token = apiUtilsGetAuthenticationToken();

    return apiUtilsCallApi('GET', $url, null, $token);
}

/**
 * Loga em uma empresa(workspace).
 * @param {string} $id - ID da empresa que deseja logar
 * @return {object} - Retorno da API
 */
function apiCompanyLoggedIn($id)
{
    include "_variables.php";
    include_once "api/utils.php";

    $url = $variables_api_url_base . "/company/logged-in";
    $token = apiUtilsGetAuthenticationToken();
    $data = array('id' => $id);

    return apiUtilsCallApi('POST', $url, $data, $token);
}

/**
 * Retorna lista de usuários da empresa do usuáiro logado no sistema.
 * @return {object} - Retorno da API
 */
function apiCompanyUser()
{
    include "_variables.php";
    include_once "api/utils.php";

    $url = $variables_api_url_base . "/company/user";
    $token = apiUtilsGetAuthenticationToken();

    return apiUtilsCallApi('GET', $url, null, $token);
}
