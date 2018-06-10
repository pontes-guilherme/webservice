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

function get_compra_passagem($id) {
    $compraPassagensFile = COMPRA_PASSAGENS_FILE;
    $contentCompras = read_file($compraPassagensFile);
    $compras = json_decode($contentCompras, true);

    if (!isset($compras[$id])) {
        return json_encode(array(
            "erro" => "Registro não existente!"
        ));
    }

    return json_encode($compras["$id"]);
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

    /* Valida número de pessoas */
    if (!is_numeric($data['n_pessoas']) || $data['n_pessoas'] < 1) {
        criaLog("passagem => Número de pessoas incorreto!");
        return json_encode(array(
            "erro" => "Número de pessoas incorreto!"
        ));
    }

    /* Valida número de parcelas */
    if (!is_numeric($data['parcelas']) || $data['parcelas'] > 24) {
        criaLog("passagem => Número de parcelas incorreto!");
        return json_encode(array(
            "erro" => "Número de parcelas incorreto!"
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

    /* Gerar código de compra */
    $codigoPgto = generateCode();
    $compra = array("$codigoPgto" => $compra);

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
        "sucesso" => "Compra efetuada com sucesso!",
        "codigo" => "$codigoPgto"
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

function get_compra_hospedagem($id) {
    $compraHospedagensFile = COMPRA_HOSPEDAGENS_FILE;
    $contentCompras = read_file($compraHospedagensFile);
    $compras = json_decode($contentCompras, true);

    if (!isset($compras[$id])) {
        return json_encode(array(
            "erro" => "Registro não existente!"
        ));
    }

    return json_encode($compras[$id]);
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

    /* Valida número de pessoas */
    if (!is_numeric($data['n_pessoas']) || $data['n_pessoas'] < 1) {
        criaLog("hospedagem => Número de pessoas incorreto!");
        return json_encode(array(
            "erro" => "Número de pessoas incorreto!"
        ));
    }

    /* Valida número de parcelas */
    if (!is_numeric($data['parcelas']) || $data['parcelas'] > 24) {
        criaLog("hospedagem => Número de parcelas incorreto!");
        return json_encode(array(
            "erro" => "Número de parcelas incorreto!"
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

    /* Gerar código de compra */
    $codigoPgto = generateCode();
    $compra = array("$codigoPgto" => $compra);

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
    criaLog("hospedagem => Compra efetuada com sucesso");
    return json_encode(array(
        "sucesso" => "Compra efetuada com sucesso!",
        "codigo" => "$codigoPgto"
    ));
}