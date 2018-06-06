<?php

function get_passagens() {
    $passagensFile = PASSAGENS_FILE;
    return read_file($passagensFile);
}

function get_passagem($id) {
    $passagensFile = PASSAGENS_FILE;

    $content = read_file($passagensFile);
    $decoded_content = json_decode($content, true);

    if (!isset($decoded_content[$id])) {
        return json_encode(array(
            "erro" => "Registro não existente!"
        ));
    }

    return json_encode($decoded_content[$id]);
}

function post_passagem($data) {
    
}

/* ====================================================== */

function get_hospedagens() {
    $hospedagensFile = HOSPEDAGENS_FILE;
    return read_file($hospedagensFile);
}

function get_hospedagem($id) {
    $hospedagensFile = HOSPEDAGENS_FILE;

    $content = read_file($hospedagensFile);
    $decoded_content = json_decode($content, true);

    if (!isset($decoded_content[$id])) {
        return json_encode(array(
            "erro" => "Registro não existente!"
        ));
    }

    return json_encode($decoded_content[$id]);
}