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
