<?php

/**
 * Retorna dados da conta do usuáiro logado no sistema.
 * @return {object} - Retorno da API
 */
function apiMyaccountGet()
{
    include "_variables.php";
    include_once "api/utils.php";

    $url = $variables_api_url_base . "/myaccount";
    $token = apiUtilsGetAuthenticationToken();

    return apiUtilsCallApi('GET', $url, null, $token);
}
