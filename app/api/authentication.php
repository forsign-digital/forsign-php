<?php

/**
 * Autneticar o usuário na API
 * @param {string} $username - Nome de usuário utilizado na Forsign
 * @param {string} $password - Senha utilizada na Forsign
 * @return {object} - Retorno da API com o token de autenticação
 */
function apiAuthenticationSignIn($username, $password)
{
    include_once "_variables.php";
    include_once "api/utils.php";

    $url = $variables_api_url_base . "/authentication/sign-in";
    $hash = "";

    if ($username !== "" && $password !== "") {
        $hash = base64_encode("{$username};{$password}");
    }

    $data = array('data' => $hash);

    // Estrutura do retorno da API de autenticação
    // {
    //   "access_token": string,
    //   "token_type": string,
    //   "expires_in": number,
    //   "refresh_token": string,
    //   "plan": string,
    //   "role": string,
    //   "permissionLevels": string[],
    //   "trial": boolean,
    //   "companies": {
    //      expiresIn: string,
    //      id: number,
    //      name: string,
    //      sandbox: boolean
    //   }[],
    //   "planId": number,
    //   "mustAnswer": boolean
    // }
    return apiUtilsCallApi('POST', $url, $data);
}
