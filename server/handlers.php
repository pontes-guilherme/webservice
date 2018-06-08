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

function search_passagem($key, $value) {
    $passagensFile = PASSAGENS_FILE;

    $content = read_file($passagensFile);
    $decoded_content = json_decode($content, true);

    $resultArray = array();

    foreach($decoded_content as $i => $content) {
        if (strpos(strtolower($content[$key]), strtolower($value)) !== false) {
            $resultArray[] = $content;
        }
    }

    if (!$resultArray) {
        return json_encode(array(
            "erro" => "Registro não existente!"
        ));
    }

    return json_encode($resultArray);
}

function post_passagem($data) {
    /*
    {
        'id'            : '1', //inteiro - id da origem
        'n_pessoas'     : '10', //inteiro (número de pessoas)
        'cartao'        : 'xxxxxxxxxxxxx', //string - número do cartao fictício
        'parcelas'      : '12', //inteiro
    }
    */

    $passagensFile = PASSAGENS_FILE;
    $compraPassagensFile = COMPRA_PASSAGENS_FILE;

    $content = read_file($passagensFile);
    $passagens = json_decode($content, true);

    if (!$data) {
        return json_encode(array(
            "erro" => "Dados enviados incorretamente!"
        ));
    }

    /* Caso a passagem não exista */
    if (!isset($passagens[$dados['id']])) {
        return json_encode(array(
            "erro" => "Passagem não encontrada"
        ));
    }

    $passagem = $passagens[$dados['id']];

    /* Verifica vagas disponíveis */
    if ($dados['n_pessoas'] > $passagem['vagas']) {
        return json_encode(array(
            "erro" => "Não há vagas suficientes"
        ));
    }

    /* Cria registro de compra */
    $compra = array_merge($dados, array(
        'data_hora_compra' => date('d/m/Y H:i:s')
    ));

    $contentCompras = read_file($compraPassagensFile);
    $compras = json_decode($content, true);
    $compras = array_merge($compras, $compra);

    /* Calcula vagas restantes */
    $vagasRestantes = $passagem['vagas'] - $dados['n_pessoas'];
    $passagens[$dados['id']]['vagas'] = $vagasRestantes;

    /* Atualiza o arquivo de passagens com as vagas atualizadas */
    if (!write_file($passagensFile, $passagens)) {
        return json_encode(array(
            "erro" => "Erro ao atualizar vagas"
        ));
    }

    /* Registra a compra */
    if (!write_file($compraPassagensFile, $compras)) {
        return json_encode(array(
            "erro" => "Erro ao efetuar compra"
        ));
    }

    /* mensagem de sucesso */
    return json_encode(array(
        "sucesso" => "Compra efetuada com sucesso!"
    ));

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

function search_hospedagem($key, $value) {
    $hospedagensFile = HOSPEDAGENS_FILE;

    $content = read_file($hospedagensFile);
    $decoded_content = json_decode($content, true);

    $resultArray = array();

    foreach($decoded_content as $i => $content) {
        if (strpos(strtolower($content[$key]), strtolower($value)) !== false) {
            $resultArray[] = $content;
        }
    }

    if (!$resultArray) {
        return json_encode(array(
            "erro" => "Registro não existente!"
        ));
    }

    return json_encode($resultArray);
}

function post_hospedagem($data) {
    /*
    {
        'id'            : '1', //inteiro - id da origem
        'n_pessoas'     : '10', //inteiro (número de pessoas)
        'cartao'        : 'xxxxxxxxxxxxx', //string - número do cartao fictício
        'parcelas'      : '12', //inteiro
    }
    */

    $hospedagemFile = HOSPEDAGEM_FILE;
    $compraHospedagensFile = COMPRA_HOSPEDAGEM_FILE;

    $content = read_file($hospedagemFile);
    $hospedagens = json_decode($content, true);

    if (!$data) {
        return json_encode(array(
            "erro" => "Dados enviados incorretamente!"
        ));
    }

    /* Caso a passagem não exista */
    if (!isset($hospedagens[$dados['id']])) {
        return json_encode(array(
            "erro" => "Passagem não encontrada"
        ));
    }

    $hospedagem = $hospedagens[$dados['id']];

    /* Verifica vagas disponíveis */
    if ($dados['n_pessoas'] > $hospedagem['vagas']) {
        return json_encode(array(
            "erro" => "Não há vagas suficientes"
        ));
    }

    /* Cria registro de compra */
    $compra = array_merge($dados, array(
        'data_hora_compra' => date('d/m/Y H:i:s')
    ));

    $contentCompras = read_file($compraHospedagensFile);
    $compras = json_decode($content, true);
    $compras = array_merge($compras, $compra);

    /* Calcula vagas restantes */
    $vagasRestantes = $hospedagem['vagas'] - $dados['n_pessoas'];
    $hospedagens[$dados['id']]['vagas'] = $vagasRestantes;

    /* Atualiza o arquivo de passagens com as vagas atualizadas */
    if (!write_file($hospedagensFile, $hospedagens)) {
        return json_encode(array(
            "erro" => "Erro ao atualizar vagas"
        ));
    }

    /* Registra a compra */
    if (!write_file($compraHospedagensFile, $compras)) {
        return json_encode(array(
            "erro" => "Erro ao efetuar compra"
        ));
    }

    /* mensagem de sucesso */
    return json_encode(array(
        "sucesso" => "Compra efetuada com sucesso!"
    ));
}