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
    fwrite($fp, json_encode($content));
    fclose($fp);

    return true;
}

function criaLog($content, $file = 'log.txt') {
    // Logging class initialization
    $log = new Logging();
    // set path and name of log file (optional)
    $log->lfile($file);
    // write message to the log file
    $log->lwrite($content);
    // close log file
    $log->lclose();
}