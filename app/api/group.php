<?php

/**
 * Retorna lista de grupos da empresa do usuáiro logado no sistema.
 * @return {object} - Retorno da API
 */
function apiGroupGet()
{
    include "_variables.php";
    include_once "api/utils.php";

    $url = $variables_api_url_base . "/group";
    $token = apiUtilsGetAuthenticationToken();

    return apiUtilsCallApi('GET', $url, null, $token);
}
