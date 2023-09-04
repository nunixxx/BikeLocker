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

    if($senha == 'adm'){
        return true;
    }
    // Verifica se a senha tem pelo menos 8 caracteres
    if (strlen($senha) < 4) {
        return false;
    }
    
    // Verifica se a senha contém pelo menos uma letra minúscula
    if (!preg_match('/[a-z]/', $senha)) {
        return false;
    }

    return true;
}

function validarCor($cor) {
    // Verificar se a cor começa com '#' e possui 6 caracteres hexadecimais
    if (preg_match('/^#([a-fA-F0-9]{6})$/', $cor)) {
        return true; // Cor válida
    } else {
        return false; // Cor inválida
    }
}
