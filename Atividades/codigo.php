<?php

/**
 * Valida um número de CPF brasileiro.
 * 
 * @param string $cpf O número do CPF a ser validado.
 * @throws InvalidArgumentException Se o formato do CPF for inválido.
 * @throws InvalidArgumentException Se o CPF for inválido.
 * @return bool Retorna verdadeiro se o CPF é válido, caso contrário, retorna falso.
 */
function validaCPF($cpf) {
    // Remove todos os caracteres não numéricos do CPF e verifica o comprimento
    $cpf = preg_replace('/[^0-9]/', '', $cpf);
    if (strlen($cpf) !== 11) {
        throw new InvalidArgumentException("O CPF deve ter 11 dígitos.");
    }
    
    // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
    if (preg_match('/^(\d)\1{10}$/', $cpf)) {
        throw new InvalidArgumentException("O CPF não pode conter uma sequência de dígitos repetidos.");
    }

    // Calcula os dígitos de verificação do CPF
    $dv1 = 0;
    $dv2 = 0;
    
    for ($i = 0; $i < 9; $i++) {
        $dv1 += $cpf[$i] * (10 - $i);
    }
    $dv1 = 11 - ($dv1 % 11);
    if ($dv1 > 9) {
        $dv1 = 0;
    }
    
    for ($i = 0; $i < 10; $i++) {
        $dv2 += $cpf[$i] * (11 - $i);
    }
    $dv2 = 11 - ($dv2 % 11);
    if ($dv2 > 9) {
        $dv2 = 0;
    }

    // Verifica se os dígitos de verificação calculados correspondem aos dígitos informados
    if ($cpf[9] !== (string)$dv1 || $cpf[10] !== (string)$dv2) {
        throw new InvalidArgumentException("O CPF informado é inválido.");
    }
    
    return true;
}