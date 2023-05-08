<?php

/**
 * Criptografa uma string
 * @param {string} $string - String a ser criptografada
 * @return {string} String criptografada
 */
function utilsCryptoEncrypt($string)
{
    include "_variables.php";

    return openssl_encrypt(
        $string,
        $variables_ciphering,
        $variables_encryption_key,
        $variables_options,
        $variables_encryption_iv
    );
}

/**
 * Descriptografa uma string
 * @param {string} $string - String a ser descriptografada
 * @return {string} String descriptografada
 */
function utilsCryptoDecrypt($encodedString)
{
    include "_variables.php";

    return openssl_decrypt(
        $encodedString,
        $variables_ciphering,
        $variables_encryption_key,
        $variables_options,
        $variables_encryption_iv
    );
}
