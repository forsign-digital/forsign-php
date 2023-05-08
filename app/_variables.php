<?php
// URL base da API
$variables_api_url_base = 'https://api.forsign.digital/api/v1';

// Configurações de criptografia
$variables_ciphering = "AES-128-CTR";
$variables_iv_length = openssl_cipher_iv_length($variables_ciphering);
$variables_options = 0;
$variables_encryption_iv = '1234567891011121';
$variables_encryption_key = "ForsignDigital";
