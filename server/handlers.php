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
        criaLog("passagem => Dados enviados incorretamente!");
        return json_encode(array(
            "erro" => "Dados enviados incorretamente!"
        ));
    }

    /* Caso a passagem não exista */
    if (!isset($passagens[$data['id']])) {
        criaLog("passagem => Passagem não encontrada");
        return json_encode(array(
            "erro" => "Passagem não encontrada"
        ));
    }

    $passagem = $passagens[$data['id']];

    /* Verifica vagas disponíveis */
    if ($data['n_pessoas'] > $passagem['vagas']) {
        criaLog("passagem => Não há vagas suficientes");
        return json_encode(array(
            "erro" => "Não há vagas suficientes"
        ));
    }

    /* Cria registro de compra */
    $compra = array_merge($data, array(
        'data_hora_compra' => date('d/m/Y H:i:s')
    ));

    $contentCompras = read_file($compraPassagensFile);
    $compras = json_decode($contentCompras, true);
    $compras = !is_null($compras) ? array_merge($compras, $compra) : $compra;

    /* Calcula vagas restantes */
    $vagasRestantes = (int)$passagem['vagas'] - (int)$data['n_pessoas'];
    $passagens[$data['id']]['vagas'] = $vagasRestantes;
    
    // criaLog(json_encode($passagens));
    /* Atualiza o arquivo de passagens com as vagas atualizadas */
    if (!write_file($passagensFile, $passagens)) {
        criaLog("passagem => erro ao atualizar vagas");
        return json_encode(array(
            "erro" => "Erro ao atualizar vagas"
        ));
    }

    //criaLog(json_encode($compras));
    /* Registra a compra */
    if (!write_file($compraPassagensFile, $compras)) {
        criaLog("passagem => Erro ao efetuar compra");
        return json_encode(array(
            "erro" => "Erro ao efetuar compra"
        ));
    }

    /* mensagem de sucesso */
    criaLog("passagem => Compra efetuada com sucesso");
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

    $hospedagemFile = HOSPEDAGENS_FILE;
    $compraHospedagensFile = COMPRA_HOSPEDAGENS_FILE;

    $content = read_file($hospedagemFile);
    $hospedagens = json_decode($content, true);
    
    if (!$data) {
        criaLog("hospedagem => Dados enviados incorretamente!");
        return json_encode(array(
            "erro" => "Dados enviados incorretamente!"
        ));
    }

    /* Caso a passagem não exista */
    if (!isset($hospedagens[$data['id']])) {
        criaLog("hospedagem => Hospedagem não encontrada");
        return json_encode(array(
            "erro" => "Hospedagem não encontrada"
        ));
    }

    $hospedagem = $hospedagens[$data['id']];
    /* Verifica vagas disponíveis */
    if ($data['n_pessoas'] > $hospedagem['vagas']) {
        criaLog("hospedagem => Não há vagas suficientes");
        return json_encode(array(
            "erro" => "Não há vagas suficientes"
        ));
    }

    /* Cria registro de compra */
    $compra = array_merge($data, array(
        'data_hora_compra' => date('d/m/Y H:i:s')
    ));

    $contentCompras = read_file($compraHospedagensFile);
    $compras = json_decode($contentCompras, true);
    $compras = !is_null($compras) ? array_merge($compras, $compra) : $compra;

    /* Calcula vagas restantes */
    $vagasRestantes = (int)$hospedagem['vagas'] - (int)$data['n_pessoas'];
    $hospedagens[$data['id']]['vagas'] = $vagasRestantes;
    
    /* Atualiza o arquivo de passagens com as vagas atualizadas */
    if (!write_file($hospedagemFile, $hospedagens)) {
        criaLog("hospedagem => Erro ao atualizar vagas");
        return json_encode(array(
            "erro" => "Erro ao atualizar vagas"
        ));
    }

    /* Registra a compra */
    if (!write_file($compraHospedagensFile, $compras)) {
        criaLog("hospedagem => Erro ao efetuar compra");
        return json_encode(array(
            "erro" => "Erro ao efetuar compra"
        ));
    }

    /* mensagem de sucesso */
    criaLog("hospedagem => Compra efetuada com sucesso!");
    return json_encode(array(
        "sucesso" => "Compra efetuada com sucesso!"
    ));
}