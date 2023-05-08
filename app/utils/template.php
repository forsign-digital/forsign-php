<?php

/**
 * Inclui HTML de alerta com a mensagem desejada
 * @param {string} $message - Mensagem a ser exibida
 * @param {(success|danger|warning|info)} $type - Tipo da mensagem
 */
function utilsTemplateAlert($message, $type)
{
    if (isset($message) && $message !== "") {
        echo "<div class=\"alert alert-" . $type . "\" role=\"alert\">" . $message . "</div>";
    }
}

/**
 * Redirecionamento de páginas
 * @param {string} $url - Página de destino
 */
function utilsTemplateRedirect($url)
{
    header('Location:' . $url, true);
    exit();
}
