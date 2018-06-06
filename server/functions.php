<?php

/**
 * Reads from a file
 *
 * @param [string] $filePath Path to the file
 * 
 * @return string/boolean File content, if file exists. False otherwise
 */
function read_file($filePath) {
    if (!file_exists($filePath))
        return false;

    $str = file_get_contents($filePath);

    return $str;
}

/**
 * Writes a json to a file
 *
 * @param [string] $filePath Path to the file
 * @param [array]  $content  File content
 * 
 * @return boolean True in case of success. False otherwise
 */
function write_file($filePath, $content) {
    if (!file_exists($filePath))
        return false;

    $fp = fopen($filePath, 'w');
    fwrite($fp, json_encode($response));
    fclose($fp);

    return true;
}

