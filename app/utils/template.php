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

/**
 * Procura um objeto dentro de uma lista de objetos através da chave e valor
 * @param {array} $items - Lista de objetos
 * @param {string} $key - Chave a fazer a busca
 * @param {string} $value - Valor a ser buscado
 * @return {mixed} Objeto encontrado. Se não encontrar, retorna nulo
 */
function utilsTemplateFindObject($items, $key, $value)
{
    foreach ($items as $item) {
        if ($item->$key == $value) {
            return $item;
        }
    }

    return null;
}

/**
 * Monta bootstrap stepper
 * @param {mixed} $steps - Array com steps para montar o componente
 * @return HTML
 * @example
 * // 4 steps
 * getStepper(array(
 *    (object)['name' => 'Dados pessoais'],
 *    (object)['name' => 'Dados da empresa'],
 *    (object)['name' => 'Confirmar dados e enviar', 'current' => true],
 *    (object)['name' => 'Confirme sua conta'],
 *  ))
 */
function getStepper($steps)
{
    $completeds = array();
    foreach ($steps as $index => $step) {
        if (isset($step->current) && $step->current) {
            for ($i = 0; $i < $index; $i++) {
                array_push($completeds, $i);
            }
            break;
        }
    }

    $html = '';
    foreach ($steps as $index => $step) {
        $key = isset($step->value) ? $step->value : $index + 1;
        $completed = isset($step->completed) ? $step->completed : array_search($index, $completeds);
        $current = isset($step->current) && $step->current;
        $classes = 'step';

        if ($completed === 0 || $completed) {
            $classes = "{$classes} step-success";
        } elseif ($current) {
            $classes = "{$classes} step-active";
        }

        $html = <<<HTML
        $html
        <li class="$classes">
            <div class="step-content">
            <span class="step-circle">$key</span>
            <span class="step-text">$step->name</span>
            </div>
        </li>
        HTML;
    }

    return <<<HTML
    <link href="/styles/bootstrap-steps.css" rel="stylesheet" />
    <ul class="steps">
        $html
    </ul>
    HTML;
}
