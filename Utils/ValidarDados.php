<?php
function validarCPF($cpf) {
    // Remove caracteres não numéricos
    $cpf = preg_replace('/[^0-9]/', '', $cpf);
    // Verifica se o CPF tem 11 dígitos
    if (strlen($cpf) != 11) {
        return false;
    }
    // Verifica se todos os dígitos são iguais, o que torna o CPF inválido
    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }
    // Calcula o primeiro dígito verificador
    for ($i = 9, $j = 0, $soma = 0; $i > 0; $i--, $j++) {
        $soma += $cpf[$j] * $i;
    }
    $resto = $soma % 11;
    $dv1 = $resto < 2 ? 0 : 11 - $resto;
    // Verifica o primeiro dígito verificador
    if ($dv1 != $cpf[9]) {
        return false;
    }
    // Calcula o segundo dígito verificador
    for ($i = 10, $j = 0, $soma = 0; $i > 0; $i--, $j++) {
        $soma += $cpf[$j] * $i;
    }
    $resto = $soma % 11;
    $dv2 = $resto < 2 ? 0 : 11 - $resto;
    // Verifica o segundo dígito verificador
    if ($dv2 != $cpf[10]) {
        return false;
    }
    return true;
}

function validarEmail($email) {
    // Remove espaços em branco no início e no fim do email
    $email = trim($email);

    // Usa a função filter_var para validar o email
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
}

function validarSenha($senha) {
    $senha = trim($senha);

    // Verifica se a senha tem pelo menos 8 caracteres
    if (strlen($senha) < 5) {
        return false;
    }
    
    // Verifica se a senha contém pelo menos uma letra minúscula
    if (!preg_match('/[a-z]/', $senha)) {
        return false;
    }
    
    // Verifica se a senha contém pelo menos um caractere especial
    if (!preg_match('/[^a-zA-Z0-9]/', $senha)) {
        return false;
    }

    return true;
}
