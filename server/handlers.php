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
        'origem'        : '1', //inteiro - id da origem
        'destino'       : '2', //inteiro - id do destino
        'data'          : '15/12/2018 13:00:00', //formato dd/mm/yyyy hh:ii:ss
        'quantidade'    : '10', //inteiro (número de pessoas)
        'cartao'        : 'xxxxxxxxxxxxx', //string - número do cartao fictício
        'parcelas'      : '12', //inteiro
    }
    */

    /*
    {
        '1' : {
            'cidade' : 'Curitiba',
            'destino': {
                '1' : {
                    'cidade': São Paulo,
                    'data_hora': {
                        'xx/xx/xxxx xx:xx:xx' : 10 //vagas
                        'xx/xx/xxxx xx:xx:xx' : 20
                    }
                }
            }
        },
        '2' : {
            'cidade' : 'São Paulo',
            'destino': {
                '1' : {
                    'cidade': Curitiba,
                    'data_hora': {
                        'xx/xx/xxxx xx:xx:xx' : 2 //vagas
                    }
                },
                '2' : {
                    'cidade': Rio de Janeiro,
                    'data_hora': {
                        ''
                    }
                }
            }
        }
    }
    */

    $passagensFile = PASSAGENS_FILE;

    $content = read_file($passagensFile);
    $passagens = json_decode($content, true);

    if (!$data) {
        return json_encode(array(
            "erro" => "Dados enviados incorretamente!"
        ));
    }

    /* Caso a origem não exista */
    if (!isset($passagens[$dados['origem']])) {
        return json_encode(array(
            "erro" => "Origem não existente!"
        ));
    }

    /* Caso o destino não exista */
    if (!isset($passagens[$dados['destino']])) {
        return json_encode(array(
            "erro" => "Destino não existente!"
        ));
    }


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
    
}