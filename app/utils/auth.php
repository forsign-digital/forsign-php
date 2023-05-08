<?php

/**
 * Grava sessão com a autenticação do usuáiro criptografada
 * @param {mixed} $response - Resposta da API contendo token de autentição
 */
function utilsAuthSetAuthentication($response)
{
    include_once 'utils/crypto.php';

    if (!isset($response)) return;

    // Converte JSON da autenticação da API para string
    $authentication = json_encode($response->data);
    // Criptografa string da autenticação da API
    $authenticationCrypto = utilsCryptoEncrypt($authentication);
    // Grava a autenticação criptografada da API na sessão do usuário
    setcookie("authentication", $authenticationCrypto);
}

/**
 * Grava sessão com os dados do usuário logado (Nome, e-mail, telefone, etc)
 * @param {mixed} $user - Dados do usuáiro logado
 */
function utilsAuthSetUser($user)
{
    // Converte JSON com dados do usuário para string
    $userString = json_encode($user);
    // Grava dados na sessão do usuário
    setcookie("user", $userString);
}

/**
 * Recupera dados do usuáiro logado da sessão (Nome, e-mail, telefone, etc)
 * @return {mixed} Dados do usuáiro logado
 */
function utilsAuthGetUser()
{
    // Verifica se os dados do usuário estão na sessão
    if (isset($_COOKIE["user"])) {
        // Converte string com dados do usuário para JSON
        return json_decode($_COOKIE["user"]);
    }
}

// Verifica se o usuário está autenticado
function utilsAuthIsAuthenticated()
{
    return isset($_COOKIE["authentication"]);
}
