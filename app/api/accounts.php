<?php

/**
 * Retorna informações do usuário logado no sistema.
 * @param {string} $token - Token de autenticação da API
 * @return {object} - Retorno da API
 */
function apiAccountsAccountInfo($token = '')
{
    include "_variables.php";
    include_once "api/utils.php";

    $url = $variables_api_url_base . "/accounts/account-info";

    if (empty($token)) {
        $token = apiUtilsGetAuthenticationToken();
    }

    // Estrutura do retorno da API de autenticação
    // {
    //     "success": boolean,
    //     "statusCode": number,
    //     "data": {
    //       "id": number,
    //       "name": string,
    //       "email": string,
    //       "phoneNumber": stirng
    //     }
    //   }
    return apiUtilsCallApi('GET', $url, null, $token);
}
